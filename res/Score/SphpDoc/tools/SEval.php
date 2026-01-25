<?php
namespace {
/**
* SEval - Compiler and executor for parsed AST
*/
class SEval {
public function setMainObject($object) {}
public function setPropObject(&$object) {}
public function setObject($name, $object) {}
public function setVariable($name, $value) {}
/**
* Check if expression is an if statement
*/
public function process($template){}
/**
* Execute AST node
*/
/**
* Check if value is truthy
*/
/**
* Resolve variable name reference
*/
/**
* Resolve variable reference
*/
/**
* Convert value to string for output
*/
/**
* Process content (public alias for process)
*/
public function processContent($content) {}
/**
* Get all variables (for debugging)
*/
public function getVariables() {}
public function getVariable($name) {}
/**
* Clear all variables
*/
public function clearVariables() {}
}
}