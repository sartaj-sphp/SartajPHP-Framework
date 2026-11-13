<?php
namespace {
/**
* SafeEval - Compiler and executor for parsed AST
*
* Evaluates PHP-like template expressions (##{...}# and #{}# tags) safely
* by parsing them into an AST via SafeEvalParser and executing the AST
* against a sandboxed set of variables, objects, and allowed functions.
* Supports if/elseif/else/endif control structures inside templates.
*/
class SafeEval {
/**
* Constructor. Initializes the SafeEvalParser and sets up the $this object slot.
*/
/**
* Set the main object that will be referenced as $this in expressions.
*
* @param mixed $object The main object instance.
* @return void
*/
public function setMainObject($object) {}
/**
* Set a reference to a property list for variable resolution.
*
* @param mixed $object Reference to the property list array.
* @return void
*/
public function setPropObject(&$object) {}
/**
* Register an object by name for use in expressions.
*
* @param string $name The variable name (e.g. "$obj").
* @param mixed $object The object instance.
* @return void
*/
public function setObject($name, $object) {}
/**
* Set a variable value for use in expressions.
*
* @param string $name The variable name (e.g. "$var").
* @param mixed $value The value to assign.
* @return void
*/
public function setVariable($name, $value) {}
/**
* Check if expression is an if statement
*
* @param string $expression The expression to check.
* @return int Match count (1 if it is an if statement, 0 otherwise).
*/
/**
* Process a template string, evaluating all ##{...}# and #{}# tags.
*
* @param string $template The template string containing expression tags.
* @return string The processed template with expressions evaluated.
*/
public function process($template){}
/**
* Filter and format output for ##{...}# tags.
*
* Supports modifiers: raw, json, url, escape (default).
*
* @param string $match The expression string from the tag.
* @return string The formatted output string.
*/
/**
* Get the line number from a character position in the template.
*
* @param string $template The full template string.
* @param int $position The character position.
* @return int The 1-based line number.
*/
/**
* Extract a complete if/elseif/else/endif block from matched tags.
*
* @param string $template The full template string.
* @param array $matches The preg_match_all result array.
* @param int $startIndex The index of the 'if' tag in matches.
* @return array|null The if block structure or null if not found.
*/
/**
* Find the end of a block (endif, elseif, or else) from matched tags.
*
* @param array $matches The preg_match_all result array.
* @param int $startIndex The index to start searching from.
* @param array $endTags The end tag names to look for (e.g. ['elseif', 'else']).
* @return array An array with 'index' and 'tag' keys.
*/
/**
* Evaluate an if block and return the content of the matching branch.
*
* @param array $ifBlock The if block structure from extractIfBlockFromMatches.
* @return string The content of the first matching branch.
*/
/**
* Execute AST node
*
* @param array $node The AST node to execute.
* @return mixed The result of executing the node.
*/
/**
* Check if value is truthy
*
* @param mixed $value The value to check.
* @return bool Whether the value is truthy.
*/
/**
* Resolve variable name reference
*
* @param string $name The variable name to resolve.
* @return mixed The resolved value, or '??' if not found.
*/
/**
* Resolve a variable reference (name or AST node) to its value.
*
* @param mixed $name The variable name string or AST node array.
* @return mixed The resolved value.
* @throws \Exception If the variable is undefined.
*/
/**
* Convert value to string for output
*
* @param mixed $value The value to convert.
* @return string The string representation.
*/
/**
* Process content (public alias for process)
*
* @param string $content The template content to process.
* @return string The processed content.
*/
public function processContent($content) {}
/**
* Get all variables (for debugging)
*
* @return array The current variables array.
*/
public function getVariables() {}
/**
* Get a single variable by name.
*
* @param string $name The variable name.
* @return mixed The variable value.
* @throws \Exception If the variable is undefined.
*/
public function getVariable($name) {}
/**
* Clear all variables
*
* @return SafeEval This instance for chaining.
*/
public function clearVariables() {}
}
}
