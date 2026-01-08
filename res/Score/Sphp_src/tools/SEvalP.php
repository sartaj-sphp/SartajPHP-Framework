<?php
namespace {

/**
 * SEvalParser - PHP-like template parser using PHP tokenizer
 * Parses PHP-like expressions into AST (Abstract Syntax Tree)
 */
class SEvalParser {
    private $tokens = [];
    private $pos = 0;
    private $length = 0;
        // Map PHP token names to operator symbols
    private $operatorMap = [
            // Comparison
            'T_IS_EQUAL' => '==',
            'T_IS_NOT_EQUAL' => '!=',
            'T_IS_IDENTICAL' => '===',
            'T_IS_NOT_IDENTICAL' => '!==',
            'T_IS_SMALLER_OR_EQUAL' => '<=',
            'T_IS_GREATER_OR_EQUAL' => '>=',
            'T_IS_SMALLER' => '<',
            'T_IS_GREATER' => '>',
            'T_SPACESHIP' => '<=>',
            
            // Boolean/Logical
            'T_BOOLEAN_AND' => '&&',
            'T_BOOLEAN_OR' => '||',
            'T_LOGICAL_AND' => 'and',
            'T_LOGICAL_OR' => 'or',
            'T_LOGICAL_XOR' => 'xor',
            
            // Bitwise
            'T_SL' => '<<',
            'T_SR' => '>>',
            
            // Arithmetic
            'T_POW' => '**',
            'T_INC' => '++',
            'T_DEC' => '--',
            
            // Null coalescing
            'T_COALESCE' => '??',
            'T_COALESCE_EQUAL' => '??=',
            
            // Assignment
            'T_PLUS_EQUAL' => '+=',
            'T_MINUS_EQUAL' => '-=',
            'T_MUL_EQUAL' => '*=',
            'T_DIV_EQUAL' => '/=',
            'T_CONCAT_EQUAL' => '.=',
            'T_MOD_EQUAL' => '%=',
            'T_AND_EQUAL' => '&=',
            'T_OR_EQUAL' => '|=',
            'T_XOR_EQUAL' => '^=',
            'T_SL_EQUAL' => '<<=',
            'T_SR_EQUAL' => '>>=',
            'T_POW_EQUAL' => '**=',
                    
            // Other
            'T_SL' => '<<',
            'T_SR' => '>>',
            'T_POW' => '**',
            'T_ARRAY' => 'array',
            'T_DOUBLE_ARROW' => '=>'
        ];
        
     // PHP operator precedence (from php.net)
     // LOWER number = HIGHER precedence
    private     $precedence = [
            // Highest precedence (level 1)
            'clone' => 1, 'new' => 1,
            // Level 2
            '[' => 2, '(' => 2, '->' => 2,
            // Level 3  
            '++' => 3, '--' => 3,
            // Level 4
            '~' => 4, '(int)' => 4, '(float)' => 4, '(string)' => 4, 
            '(array)' => 4, '(object)' => 4, '(bool)' => 4, '(unset)' => 4,
            // Level 5
            '!' => 5,
            // Level 6
            '*' => 6, '/' => 6, '%' => 6,
            // Level 7
            '+' => 7, '-' => 7, '.' => 7,
            // Level 8
            '<<' => 8, '>>' => 8,
            // Level 9
            '<' => 9, '<=' => 9, '>' => 9, '>=' => 9,
            // Level 10
            '==' => 10, '!=' => 10, '===' => 10, '!==' => 10, '<>' => 10, '<=>' => 10,
            // Level 11
            '&' => 11,
            // Level 12
            '^' => 12,
            // Level 13
            '|' => 13,
            // Level 14
            '&&' => 14,
            // Level 15
            '||' => 15,
            // Level 16
            '??' => 16,
            // Level 17 - TERNARY (right associative)
            '?' => 17, ':' => 17,
            // Level 18
            '=' => 18, '+=' => 18, '-=' => 18, '*=' => 18, '/=' => 18, '.=' => 18,
            '%=' => 18, '&=' => 18, '|=' => 18, '^=' => 18, '<<=' => 18, '>>=' => 18,
            '**=' => 18, '??=' => 18,
            // Level 19
            'and' => 19,
            // Level 20
            'xor' => 20,
            // Level 21 - LOWEST precedence
            'or' => 21,
            // Special: yield, yield from, print
            'yield' => 22, 'yield from' => 23, 'print' => 24
        ];

    /**
     * Parse a PHP-like expression into AST
     */
    public function parse(string $expression): array {
        $this->tokens = $this->tokenize($expression);
        $this->pos = 0;
        $this->length = count($this->tokens);
        
        return $this->parseStatements();
    }
    
    /**
     * Tokenize expression using PHP tokenizer
     */
    private function tokenize(string $code): array {
        // Wrap code in <?php tags for proper tokenization
        $wrappedCode = '<?php ' . $code . ' ?>';
        $tokens = token_get_all($wrappedCode);
        
        // Filter out unwanted tokens and normalize
        $filtered = [];
        foreach ($tokens as $token) {
            if (is_array($token)) {
                switch ($token[0]) {
                    case T_OPEN_TAG:
                    case T_CLOSE_TAG:
                    case T_WHITESPACE:
                        // Skip whitespace and PHP tags
                        break;
                    default:
                        $filtered[] = [
                            'type' => $token[0],
                            'value' => $token[1],
                            'name' => token_name($token[0])
                        ];
                }
            } else {
                // Single character tokens
                $filtered[] = [
                    'type' => $token,
                    'value' => $token,
                    'name' => 'CHAR'
                ];
            }
        }
        
        return $filtered;
    }
    
    /**
     * Get current token
     */
    private function current(): ?array {
        return $this->pos < $this->length ? $this->tokens[$this->pos] : null;
    }
    
    /**
     * Peek ahead token
     */
    private function peek(int $offset = 1): ?array {
        $pos = $this->pos + $offset;
        return $pos < $this->length ? $this->tokens[$pos] : null;
    }
    
    /**
     * Advance to next token
     */
    private function advance(): ?array {
        if ($this->pos < $this->length) {
            $this->pos++;
        }
        return $this->current();
    }
    
    /**
     * Check if current token matches type
     */
    /**
     * Check if current token matches type
     */
    private function match($type, ?string $value = null): bool {
        $token = $this->current();
        if (!$token) return false;
        
        if (is_array($type)) {
            foreach ($type as $t) {
                if ($this->match($t, $value)) return true;
            }
            return false;
        }
        
        // For character tokens (like '=', ';', etc.)
        if (is_string($type) && strlen($type) === 1) {
            if ($token['value'] === $type) {
                if ($value !== null && $token['value'] !== $value) return false;
                return true;
            }
            return false;
        }
        
        // For token types (T_* constants)
        $typeMatch = is_string($type) 
            ? ($token['name'] === $type)
            : ($token['type'] === $type);
            
        if (!$typeMatch) return false;
        if ($value !== null && $token['value'] !== $value) return false;
        
        return true;
    }
    
    /**
     * Consume token if it matches
     */
    private function consume($type, ?string $value = null): ?array {
        if ($this->match($type, $value)) {
            $token = $this->current();
            $this->advance();
            return $token;
        }
        return null;
    }
    
    /**
     * Expect token to be present
     */
    private function expect($type, ?string $value = null, string $message = "Unexpected token"): array {
        $token = $this->consume($type, $value);
        if (!$token) {
            $current = $this->current();
            $got = $current ? "'{$current['value']}' ({$current['name']})" : "end of input";
            $expected = is_string($type) && strlen($type) === 1 ? 
                "'$type'" : 
                (is_string($type) ? $type : token_name($type));
                
            throw new \Exception("$message, expected $expected" . 
                ($value ? " '$value'" : "") . 
                ", got $got");
        }
        return $token;
    }
    
    /**
     * Parse multiple statements separated by semicolons
     */
    private function parseStatements(): array {
        $statements = [];
        
        while ($this->current()) {
            $statements[] = $this->parseStatement();
            
            // If there's a semicolon, consume it
            if ($this->match(';')) {
                $this->advance();
            } else {
                break;
            }
        }
        
        if (count($statements) === 1) {
            return $statements[0];
        }
        
        return ['type' => 'block', 'statements' => $statements];
    }
    
    /**
     * Parse a single statement
     */
    private function parseStatement(): array {
        // Check for assignment (variable or array access)
        if ($this->match(T_VARIABLE)) {
            $left = $this->parsePrimary(); // This returns variable, array_access, property, etc.
            
            if ($this->match('=')) {
                return $this->parseAssignment($left);
            }
            
            // Not an assignment, return as expression
            if (is_array($left)) {
                return $left;
            }
            
            return ['type' => 'variable', 'name' => $left];
        }
        
        // Expression statement
        return $this->parseExpression();
    }
    
    
    /**
     * Parse statement body (could be single statement or block)
     */
    private function parseBody(bool $alternativeSyntax = false): array {
        if ($this->match('{')) {
            // Traditional syntax with braces
            $this->expect('{', '{');
            $statements = [];
            
            while (!$this->match('}')) {
                $statements[] = $this->parseStatement();
                if ($this->match(';')) {
                    $this->advance();
                }
            }
            
            $this->expect('}', '}');
            return ['type' => 'block', 'statements' => $statements];
        } elseif ($alternativeSyntax) {
            // Alternative syntax: parse until endif/elseif/else
            $statements = [];
            
            while ($this->current() && 
                   !$this->match(T_ENDIF) && 
                   !$this->match(T_ELSEIF) && 
                   !$this->match(T_ELSE)) {
                $statements[] = $this->parseStatement();
                if ($this->match(';')) {
                    $this->advance();
                }
            }
            
            return ['type' => 'block', 'statements' => $statements];
        } else {
            // Single statement
            return $this->parseStatement();
        }
    }
    
    /**
     * Parse expression with precedence
     */
    private function parseExpression(int $minPrecedence = 100): array {
        $left = $this->parsePrimary();
        
        while (true) {
            $token = $this->current();
            if (!$token) {
                break;
            }
            
            if ($token['value'] === '?') {
                break;
            }
            
            $op = $this->getOperatorFromToken($token);
            $opPrecedence = $this->getPrecedence($op);
            
            if ($opPrecedence === 0) {
                break;
            }
            
            if ($opPrecedence < $minPrecedence) {
                $this->advance();
                $right = $this->parseExpression($opPrecedence);
                
                $left = [
                    'type' => 'binary',
                    'operator' => $op,
                    'left' => $left,
                    'right' => $right
                ];
            } else {
                break;
            }
        }
        
        // Handle ternary after binary operators
        if ($this->current() && $this->current()['value'] === '?') {
            $ternaryPrecedence = 17;
             if ($ternaryPrecedence < $minPrecedence) {
            $this->advance();
            $trueExpr = $this->parseExpression(17);
            $this->expect(':', ':');
            // Ternary is right-associative, pass same precedence
            $falseExpr = $this->parseExpression(17);
            
            return [
                'type' => 'ternary',
                'condition' => $left,
                'true' => $trueExpr,
                'false' => $falseExpr
            ];
             }
              return $left;
        }
        
        return $left;
    }
    
    
    /**
     * Get operator from token
     */
    private function getOperatorFromToken(array $token): string {
        $name = $token['name'];
        $value = $token['value'];        
        if (isset($this->operatorMap[$name])) {
            return $this->operatorMap[$name];
        }
        
        // For single character operators
        return $value;
    }
        /**
     * Get operator precedence (simplified)
     */
    private function getPrecedence(string $op): int {        
        return $this->precedence[$op] ?? 0;
    }
    
    /**
     * Parse primary expression
     */
    private function parsePrimary(): array {
        $token = $this->current();
        if (!$token) {
            throw new \Exception("Unexpected end of expression");
        }
        
        // Variable (might be array access)
        if ($this->match(T_VARIABLE)) {
            $var = $token['value'];
            $this->advance();
            
            // Check for array access: $array['key'] or $array[$key]
            while ($this->match('[')) {
                $this->advance(); // Consume '['
                $key = $this->parseExpression();
                $this->expect(']', ']');
                
                $var = [
                    'type' => 'array_access',
                    'array' => $var,
                    'key' => $key
                ];
            }
            
            // Check for method/property chain
            while ($this->match(T_OBJECT_OPERATOR)) {
                $this->advance();
                $property = $this->expect(T_STRING, null, "Expected property/method name after ->");
                
                if ($this->match('(')) {
                    // Method call
                    $args = $this->parseArguments();
                    $var = [
                        'type' => 'method_call',
                        'object' => $var,
                        'method' => $property['value'],
                        'arguments' => $args
                    ];
                } else {
                    // Property access
                    $var = [
                        'type' => 'property',
                        'object' => $var,
                        'property' => $property['value']
                    ];
                }
            }
            
            // FIX: Return variable reference as array, not string
            if (is_string($var)) {
                return ['type' => 'variable', 'name' => $var];
            }
            
            return $var; // Already an array (method_call, property, or array_access)
        }
        
        // String literal
        if ($this->match(T_CONSTANT_ENCAPSED_STRING)) {
            $value = $this->parseStringLiteral($token['value']);
            $this->advance();
            return ['type' => 'string', 'value' => $value];
        }
        
        // Number
        if ($this->match(T_LNUMBER) || $this->match(T_DNUMBER)) {
            $value = $token['value'];
            $this->advance();
            return [
                'type' => 'number',
                'value' => strpos($value, '.') !== false ? (float)$value : (int)$value
            ];
        }
        
        // Boolean literals
        if ($this->match(T_STRING)) {
            $lower = strtolower($token['value']);
            if ($lower === 'true' || $lower === 'false' || $lower === 'null') {
                $this->advance();
                return [
                    'type' => 'literal',
                    'value' => $lower === 'true' ? true : ($lower === 'false' ? false : null)
                ];
            }
            
            // Function call
            $func = $token['value'];
            $this->advance();
            
            if ($this->match('(')) {
                $args = $this->parseArguments();
                return [
                    'type' => 'function_call',
                    'function' => $func,
                    'arguments' => $args
                ];
            }
            
            // Just an identifier (like a constant), support if inside concatenation
            //return ['type' => 'identifier', 'name' => $func];
            throw new \Exception("Unexpected identifier: $func");
        }
        
        // Array literal: array() or []
        if ($this->match(T_ARRAY)) {
            return $this->parseArray();
        }
        
        // Short array syntax: []
        if ($token['value'] === '[') {
            return $this->parseArray();
        }
        
        // Parenthesized expression
        if ($this->match('(')) {
            $this->advance();
            $expr = $this->parseExpression(100);
            $this->expect(')', ')');
            return $expr;
        }
        
        // Unary operators
        if ($token['value'] === '+' || $token['value'] === '-' || $token['value'] === '!') {
            $this->advance();
            $expr = $this->parsePrimary();
            return [
                'type' => 'unary',
                'operator' => $token['value'],
                'expression' => $expr
            ];
        }
        
        throw new \Exception("Unexpected token: {$token['value']}");
    }
 
    private function parseAssignment($left): array {
        $this->expect('=', '=', "Expected '='");
        $value = $this->parseExpression();
        
        if (is_string($left)) {
            // Variable assignment: $var = value
            return [
                'type' => 'assignment',
                'variable' => $left,
                'value' => $value
            ];
        } else if (is_array($left)) {
            switch ($left['type']){ 
                case 'variable':
                // Variable assignment: $var = value
                return [
                    'type' => 'assignment',
                    'variable' => $left['name'],
                    'value' => $value
                ];
                case 'array_access':
                    // Array assignment: $array['key'] = value
                    return [
                        'type' => 'array_assignment',
                        'array' => $left['array'],
                        'key' => $left['key'],
                        'value' => $value
                    ];
                case 'property':
                    // Property assignment: $obj->prop = value
                    return [
                        'type' => 'property_assignment',
                        'object' => $left['object'],
                        'property' => $left['property'],
                        'value' => $value
                    ];
                default:
                    throw new \Exception("Invalid assignment target: {$left['type']}");
            }
        }
        
        throw new \Exception("Invalid assignment");
    }
    
    private function parseArray(): array {
        $elements = [];
        
        if ($this->match(T_ARRAY)) {
            $this->advance(); // Consume 'array'
            $this->expect('(', '(');
            
            if (!$this->match(')')) {
                while (true) {
                    // Parse key => value or just value
                    $key = null;
                    $value = $this->parseExpression();
                    
                    if ($this->match(T_DOUBLE_ARROW)) {
                        $this->advance(); // Consume '=>'
                        $key = $value;
                        $value = $this->parseExpression();
                    }
                    
                    if ($key !== null) {
                        $elements[] = ['key' => $key, 'value' => $value];
                    } else {
                        $elements[] = ['value' => $value];
                    }
                    
                    if (!$this->match(',')) break;
                    $this->advance(); // Consume ','
                }
            }
            
            $this->expect(')', ')');
        } else if ($this->match('[')) {
            $this->advance(); // Consume '['
            
            if (!$this->match(']')) {
                while (true) {
                    // Parse key => value or just value
                    $key = null;
                    $value = $this->parseExpression();
                    
                    if ($this->match(T_DOUBLE_ARROW)) {
                        $this->advance(); // Consume '=>'
                        $key = $value;
                        $value = $this->parseExpression();
                    }
                    
                    if ($key !== null) {
                        $elements[] = ['key' => $key, 'value' => $value];
                    } else {
                        $elements[] = ['value' => $value];
                    }
                    
                    if (!$this->match(',')) break;
                    $this->advance(); // Consume ','
                }
            }
            
            $this->expect(']', ']');
        }
        
        return ['type' => 'array', 'elements' => $elements];
    }

    
    /**
     * Parse string literal without eval
     */
    private function parseStringLiteral(string $str): string {
        // Remove quotes
        if (strlen($str) >= 2 && ($str[0] === "'" || $str[0] === '"')) {
            $str = substr($str, 1, -1);
        }
        
        // Handle escape sequences
        $str = str_replace(
            ['\\"', "\\'", '\\\\', '\\n', '\\r', '\\t'],
            ['"', "'", '\\', "\n", "\r", "\t"],
            $str
        );
        
        return $str;
    }
    
    /**
     * Parse function/method arguments
     */
    private function parseArguments(): array {
        $this->expect('(', '(');
        $args = [];
        
        if (!$this->match(')')) {
            while (true) {
                $args[] = $this->parseExpression();
                if (!$this->match(',')) break;
                $this->advance();
            }
        }
        
        $this->expect(')', ')');
        return $args;
    }
}
}