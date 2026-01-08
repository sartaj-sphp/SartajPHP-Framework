<?php
namespace {
/**
 * SEval - Compiler and executor for parsed AST
 */
class SEval {
    private $variables = [];
    private $objects = [];
    private $mainObject = null;
    private $parser;
    
    // Allowed functions for security
    private $allowedFunctions = [
        // String functions
        'strtoupper', 'strtolower', 'ucfirst', 'ucwords', 'trim',
        'ltrim', 'rtrim', 'strlen', 'substr', 'str_replace',
        'htmlspecialchars', 'htmlentities', 'strip_tags',
        'addslashes', 'stripslashes', 'str_repeat', 'strpos',
        
        // Array functions
        'array','count', 'sizeof', 'implode', 'join', 'explode',
        'json_encode', 'json_decode',
        
        // Date/Time functions
        'date', 'time', 'strtotime',
        
        // Math functions
        'abs', 'ceil', 'floor', 'round', 'max', 'min', 'rand',
        'mt_rand', 'sqrt', 'pow',
        
        // Other
        'in_array', 'is_array', 'is_string', 'is_numeric',
        'is_int', 'is_float', 'is_bool', 'empty', 'isset',
        //Sphp
        'readGlobal','getEventURL','getThisURL','getAppURL','traceError','traceMsg',
        'getKeyword'
    ];
    
    public function __construct() {
        $this->parser = new SEvalParser();
        $this->objects['$this'] = null;
    }
    
    public function setMainObject($object) {
        $this->mainObject = $object;
        $this->objects['$this'] = $object;
    }
    
    public function setObject($name, $object) {
        $this->objects[$name] = $object;
    }
        
    public function setVariable($name, $value) {
        $this->variables[$name] = $value;
    }
    /**
     * Check if expression is an if statement
     */
    private function isIfStatement($expression) {
        return preg_match('/^if\s+(.+)$/', trim($expression));
    }

    public function process(string $template): string {
        // Extract all ##{..}# and #{}# tags
        preg_match_all('/(#{|##\{)([^}]+)\}#/', $template, $matches, PREG_OFFSET_CAPTURE);        
        if (empty($matches[0])) {
            return $template;
        }        
        $result = '';
        $lastPos = 0;
        $skipUntil = 0;
        
        for ($i = 0; $i < count($matches[0]); $i++) {
            try {
            $fullMatch = $matches[0][$i];
            $tagType = $matches[1][$i][0];
            $expression = trim($matches[2][$i][0]);
            $position = $fullMatch[1];
            
            // Skip if we're inside a skipped block
            if ($position < $skipUntil) {
                continue;
            }

            // Append text before this tag
            $result .= substr($template, $lastPos, $position - $lastPos);
            
            // Check for control structures
            if (preg_match('/^(if|elseif|else|endif)\b/i', $expression, $ctrlMatch)) {
                $ctrlType = strtolower($ctrlMatch[1]);
                
                if ($ctrlType === 'if') {
                    // Extract complete if block
                    $ifBlock = $this->extractIfBlockFromMatches($template, $matches, $i);
                    
                    if ($ifBlock) {
                        // Evaluate and process
                        $selectedContent = $this->evaluateIfBlock($ifBlock); 
                        $result .= $this->process($selectedContent);
                        
                        // Skip to end of if block
                        $lastPos = $ifBlock['endPos'];
                        $skipUntil = $ifBlock['endPos'];
                        $i = $ifBlock['endIndex'];
                        continue;
                    }
                }
                // Skip other control tags (they're handled inside if blocks)
                $lastPos = $position + strlen($fullMatch[0]);
                continue;
            }
            
            // Process regular tag statement, no block                
                if ($tagType === '##{') {
                    $result .= $this->filterOutput($expression);
                } else {
                    $ast = $this->parser->parse($expression);
                    $this->execute($ast);
                }
                
                $lastPos = $position + strlen($fullMatch[0]);
            } catch (\Exception $e) {
                $lastPos = $position + strlen($fullMatch[0]);
                $line = $this->getLineNumberFromPosition($template, $position);
                throw new \Sphp\core\Exception($e->getMessage() . ' near ' . $expression, 0,null,$line);
            }
        }
        
        // Append remaining text
        $result .= substr($template, $lastPos);
        
        return $result;
    }
    private function filterOutput($match) {
        $content = trim($match);

        // Check for modifier
        if (preg_match('/^(\w+):(.+)$/', $content, $parts)) {
            $modifier = $parts[1];
            $expression = $parts[2];
            $ast = $this->parser->parse($expression);
            $value = $this->execute($ast);

            switch ($modifier) {
                case 'raw':
                    return $this->valueToString($value);
                case 'json':
                    return json_encode($value);
                case 'url':
                    return urlencode($this->valueToString($value));
                case 'escape':
                default:
                    return htmlspecialchars($this->valueToString($value), ENT_QUOTES, 'UTF-8');
            }
        } else {
            // Default: escaped
            $ast = $this->parser->parse($content);
            $value = $this->execute($ast);
            return htmlspecialchars($this->valueToString($value), ENT_QUOTES, 'UTF-8');
        }
    }

     private function getLineNumberFromPosition(string $template, int $position): int {
        // Count newlines before the position
        return substr_count($template, "\n", 0, $position) + 1;
    }

    private function extractIfBlockFromMatches($template, $matches, $startIndex) {
        $ifBlock = [
            'condition' => '',
            'ifContent' => '',
            'elseContent' => '',
            'elseIf' => [],
            'startPos' => $matches[0][$startIndex][1],
            'endPos' => 0,
            'endIndex' =>0
        ];
        
        // Extract if condition
        $ifExpr = $matches[2][$startIndex][0];
        $ifBlock['condition'] = trim(preg_replace('/^if\s*/i', '', $ifExpr));
        
        $currentIndex = $startIndex;
        
        // --- IF BLOCK ---
        // Find end of if content (could be elseif, else, or endif)
        $ifEnd = $this->fetchBlock($matches, $currentIndex + 1, ['elseif', 'else']);
        
        // Extract if content (from after if tag to before end tag)
        $ifContentStart = $matches[0][$currentIndex][1] + strlen($matches[0][$currentIndex][0]);
        $ifContentEnd = $matches[0][$ifEnd['index']][1];
        $ifBlock['ifContent'] = substr($template, $ifContentStart, $ifContentEnd - $ifContentStart);
        
        $currentIndex = $ifEnd['index'];
        $endTag = $ifEnd['tag'];
        
        // If endif, we're done
        if ($endTag === 'endif') {
            $ifBlock['endPos'] = $matches[0][$currentIndex][1] + strlen($matches[0][$currentIndex][0]);
            $ifBlock['endIndex'] = $currentIndex;
            return $ifBlock;
        }
        
        // --- ELSEIF BLOCKS ---
        while ($endTag === 'elseif') {
            // Extract elseif condition
            $elseIfExpr = $matches[2][$currentIndex][0];
            $condition = trim(preg_replace('/^elseif\s*/i', '', $elseIfExpr));
            
            // Find end of this elseif content
            $elseIfEnd = $this->fetchBlock($matches, $currentIndex + 1, ['elseif', 'else']);
            
            // Extract elseif content
            $elseIfContentStart = $matches[0][$currentIndex][1] + strlen($matches[0][$currentIndex][0]);
            $elseIfContentEnd = $matches[0][$elseIfEnd['index']][1];
            $content = substr($template, $elseIfContentStart, $elseIfContentEnd - $elseIfContentStart);
            
            $ifBlock['elseIf'][] = [
                'condition' => $condition,
                'ifContent' => $content
            ];
            
            $currentIndex = $elseIfEnd['index'];
            $endTag = $elseIfEnd['tag'];
            
            // If endif, we're done
            if ($endTag === 'endif') {
                $ifBlock['endPos'] = $matches[0][$currentIndex][1] + strlen($matches[0][$currentIndex][0]);
                $ifBlock['endIndex'] = $currentIndex;
                return $ifBlock;
            }
        }
        
        // --- ELSE BLOCK ---
        if ($endTag === 'else') {
            // Find end of else content (must be endif)
            $elseEnd = $this->fetchBlock($matches, $currentIndex + 1, []);
            
            // Extract else content
            $elseContentStart = $matches[0][$currentIndex][1] + strlen($matches[0][$currentIndex][0]);
            $elseContentEnd = $matches[0][$elseEnd['index']][1];
            $ifBlock['elseContent'] = substr($template, $elseContentStart, $elseContentEnd - $elseContentStart);
            
            $currentIndex = $elseEnd['index'];
            
            // Set end position (endif)
            $ifBlock['endPos'] = $matches[0][$currentIndex][1] + strlen($matches[0][$currentIndex][0]);
            $ifBlock['endIndex'] = $currentIndex;
            return $ifBlock;
        }
        
        return null; // Should not reach here
    }
    
private function fetchBlock($matches, $startIndex, $endTags) {
        $depth = 0;
        
        for ($i = $startIndex; $i < count($matches[0]); $i++) {
            $tagContent = $matches[2][$i][0];
            
            // Check for nested if
            if (preg_match('/^if\b/i', $tagContent)) {
                $depth++;
                continue;
            }
            
            // Check for endif
            if (preg_match('/^endif\b/i', $tagContent)) {
                if ($depth > 0) {
                    $depth--; // Nested endif
                    continue;
                }
                // Our endif
                return ['index' => $i, 'tag' => 'endif'];
            }
            
            // Only check end tags at depth 0
            if ($depth === 0) {
                foreach ($endTags as $endTag) {
                    if (preg_match('/^' . $endTag . '\b/i', $tagContent)) {
                        return ['index' => $i, 'tag' => $endTag];
                    }
                }
            }
        }
        
        // No end tag found
        return ['index' => count($matches[0]), 'tag' => null];
    }

    
    private function evaluateIfBlock($ifBlock) {
        // Evaluate main condition
        $conditionAst = $this->parser->parse($ifBlock['condition']);
        if ($this->execute($conditionAst)) {
            return $ifBlock['ifContent'];
        }
        
        // Check elseif conditions
        foreach ($ifBlock['elseIf'] as $elseIf) {
            $conditionAst = $this->parser->parse($elseIf['condition']);
            if ($this->execute($conditionAst)) {
                return $elseIf['ifContent'];
            }
        }
        
        // Return else content
        return $ifBlock['elseContent'];
    }
    
    /**
     * Execute AST node
     */
    private function execute(array $node) {
        switch ($node['type']) {
            case 'block':
                $result = null;
                foreach ($node['statements'] as $stmt) {
                    $result = $this->execute($stmt);
                }
                return $result;
                
            case 'assignment':
                $value = $this->execute($node['value']);
                $this->variables[$node['variable']] = $value;
                return $value;
                
            case 'array_assignment':
                $array = $this->resolveVariable($node['array']);
                $key = $this->execute($node['key']);
                $value = $this->execute($node['value']);
                
                if (!is_array($array)) {
                    // If array doesn't exist, create it
                    if (is_string($node['array']) && !isset($this->variables[$node['array']])) {
                        $this->variables[$node['array']] = [];
                        $array = &$this->variables[$node['array']];
                    } else {
                        throw new \Exception("Cannot assign to non-array");
                    }
                }
                
                $array[$key] = $value;
                
                // Update variable if needed
                if (is_string($node['array']) && isset($this->variables[$node['array']])) {
                    $this->variables[$node['array']] = $array;
                }
                
                return $value;
                
            case 'property_assignment':
                $object = $this->resolveVariable($node['object']);
                if (!is_object($object)) {
                    throw new \Exception("Cannot assign property to non-object");
                }
                
                $property = $node['property'];
                $value = $this->execute($node['value']);
                
                if (property_exists($object, $property)) {
                    $object->$property = $value;
                } else {
                    // Try setter method
                    $setter = 'set' . ucfirst($property);
                    if (method_exists($object, $setter)) {
                        $object->$setter($value);
                    } else {
                        throw new \Exception("Property $property does not exist or is not writable");
                    }
                }
                
                return $value;
                
            case 'array_access':
                $array = $this->resolveVariable($node['array']);
                $key = $this->execute($node['key']);
                
                if (!is_array($array) && !($array instanceof \ArrayAccess)) {
                    throw new \Exception("Cannot use array access on non-array");
                }
                
                return $array[$key] ?? null;
                
            case 'array':
                $result = [];
                foreach ($node['elements'] as $element) {
                    $value = $this->execute($element['value']);
                    
                    if (isset($element['key'])) {
                        $key = $this->execute($element['key']);
                        $result[$key] = $value;
                    } else {
                        $result[] = $value;
                    }
                }
                return $result;
                
            case 'if':
                // This is just an if condition node (from template)
                return $this->execute($node['condition']);
                
            case 'elseif':
                // This is just an elseif condition node
                return $this->execute($node['condition']);
                
            case 'else':
                // Else has no condition, always true
                return true;
                
            case 'endif':
                // Endif marker
                return null;
                
            case 'binary':
                $left = $this->execute($node['left']);
                $right = $this->execute($node['right']);
                
                switch ($node['operator']) {
                    case '+': return $left + $right;
                    case '-': return $left - $right;
                    case '*': return $left * $right;
                    case '/': 
                        if ($right == 0) throw new \Exception("Division by zero");
                        return $left / $right;
                    case '%': return $left % $right;
                    case '.': return $left . $right;
                    case '==': return $left == $right;
                    case '===': return $left === $right;
                    case '!=': return $left != $right;
                    case '!==': return $left !== $right;
                    case '<': return $left < $right;
                    case '>': return $left > $right;
                    case '<=': return $left <= $right;
                    case '>=': return $left >= $right;
                    case '&&': return $left && $right;
                    case 'and': return $left && $right;
                    case '||': return $left || $right;
                    case 'or': return $left || $right;
                    default:
                        throw new \Exception("Unknown operator: {$node['operator']}");
                }
                
            case 'unary':
                $expr = $this->execute($node['expression']);
                switch ($node['operator']) {
                    case '!': return !$this->isTruthy($expr);
                    case '-': return -$expr;
                    case '+': return +$expr;
                    default:
                        throw new \Exception("Unknown unary operator: {$node['operator']}");
                }
                
            case 'ternary':
                $condition = $this->execute($node['condition']);
                return $this->isTruthy($condition) 
                    ? $this->execute($node['true'])
                    : $this->execute($node['false']);
                
            case 'function_call':
                if (!in_array($node['function'], $this->allowedFunctions)) {
                    throw new \Exception("Function {$node['function']} is not allowed");
                }
                
                $args = [];
                foreach ($node['arguments'] as $arg) {
                    $args[] = $this->execute($arg);
                }
                
                return call_user_func_array($node['function'], $args);
                
            case 'method_call':
                $object = $this->resolveVariable($node['object']);
                if (!is_object($object)) {
                    throw new \Exception("Cannot call method on non-object");
                }
                
                $method = $node['method'];
                $args = [];
                foreach ($node['arguments'] as $arg) {
                    $args[] = $this->execute($arg);
                }
                
                if (!method_exists($object, $method)) {
                    throw new \Exception("Method $method does not exist");
                }
                
                return call_user_func_array([$object, $method], $args);
                
            case 'property':
                $object = $this->resolveVariable($node['object']);
                if (!is_object($object)) {
                    throw new \Exception("Cannot access property on non-object");
                }
                
                $property = $node['property'];
                if (property_exists($object, $property)) {
                    return $object->$property;
                }
                
                // Try getter method
                $getter = 'get' . ucfirst($property);
                if (method_exists($object, $getter)) {
                    return $object->$getter();
                }
                
                throw new \Exception("Property $property does not exist");
                
            case 'variable':
                return $this->resolveVariable($node['name']);
                
            case 'string':
            case 'number':
            case 'literal':
                return $node['value'];
                
            default:
                throw new \Exception("Unknown node type: {$node['type']}");
        }
    }
    
    /**
     * Check if value is truthy
     */
    private function isTruthy($value): bool {
        if (is_bool($value)) return $value;
        if (is_numeric($value)) return $value != 0;
        if (is_string($value)) return $value !== '';
        if (is_array($value)) return count($value) > 0;
        if (is_null($value)) return false;
        if (is_object($value)) return true;
        return (bool)$value;
    }
    
    /**
     * Resolve variable reference
     */
    private function resolveVariable($name) {
        if(is_string($name)){
        try{
        // Variable name
        if (isset($this->variables[$name])) {
            return $this->variables[$name];
        }
        
        if (isset($this->objects[$name])) {
            return $this->objects[$name];
        }
        }catch(\Exception $e){
            throw new \Exception("Undefined variable: $name, Error:- " . $e->getMessage());
        }
         // If ref is already an AST node (like property access), execute it
        }else if (is_array($name) && isset($name['type'])) {
            return $this->execute($name);
        
        }else{
            throw new \Exception("Undefined variable: " . $this->valueToString($name));
        }
    }
    
    /**
     * Convert value to string for output
     */
    private function valueToString($value): string {
        if ($value === null) return '';
        if (is_bool($value)) return $value ? 'true' : 'false';
        if (is_array($value)) return json_encode($value);
        if (is_object($value)) {
            if (method_exists($value, '__toString')) {
                return (string)$value;
            }
            return get_class($value) . ' Object';
        }
        return (string)$value;
    }
    
    /**
     * Process content (public alias for process)
     */
    public function processContent(string $content): string {
        return $this->process($content);
    }
    
    /**
     * Get all variables (for debugging)
     */
    public function getVariables(): array {
        return $this->variables;
    }
    
    /**
     * Clear all variables
     */
    public function clearVariables(): self {
        $this->variables = [];
        return $this;
    }
}
}