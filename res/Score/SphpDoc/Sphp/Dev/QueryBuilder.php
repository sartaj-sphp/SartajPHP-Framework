<?php
/**
* Description of QueryBuilder
*
* A dynamic SQL query builder that assembles SELECT statements with
* field lists and WHERE conditions. It supports fluent-style dynamic
* method calls (via __call) for building "where_<field>" conditions,
* and a helper to append component-based filter conditions.
*
* Key features:
* - Builds SELECT ... FROM ... WHERE ... SQL strings.
* - Dynamic where conditions via magic __call (e.g., where_fieldname).
* - Tracks whether SELECT and WHERE parts have been set.
* - addComponentWhere() appends conditions from form components.
*
* @author Sartaj
*/
namespace Sphp\Dev{
class QueryBuilder {
/**
* The name of the table to query.
* @var string
*/
/**
* Associative array of field names and their values for the SELECT clause.
* @var array
*/
/**
* Array of WHERE condition fragments.
* @var array
*/
/**
* Flag indicating whether a SELECT clause has been set.
* @var bool
*/
/**
* Flag indicating whether a WHERE clause has been set.
* @var bool
*/
/**
* Constructor. Sets the table name to query.
*
* If no table name is provided, falls back to the global $tblName.
*
* @param string $tablename The name of the table to query.
*/
/**
* Magic method that handles dynamic "where_<field>" method calls.
*
* Parses the called method name into parts and builds the arguments
* for addWhere(). Supports multi-part field names and AND/OR operators.
*
* @param string $name The called method name (e.g., "where_fieldname").
* @param array $arguments The arguments passed to the dynamic call.
*/
/**
* Splits a dynamic method name by underscores into an array of parts.
*
* @param string $name The method name to split.
* @return array The parts of the method name.
*/
/**
* Checks whether a given name is a logical operator (AND or OR).
*
* @param string $name The name to check.
* @return bool True if the name is "AND" or "OR" (case-insensitive), false otherwise.
*/
/**
* Sets the fields to select in the query.
*
* Splits the comma-separated field names and adds each as a field.
*
* @param string $fldnames Comma-separated list of field names.
*/
public function select($fldnames="") {}
/**
* Adds a field to the SELECT clause.
*
* @param string $name The field name.
* @param string $value The field value (optional).
*/
public function addField($name,$value="") {}
/**
* Adds a WHERE condition to the query.
*
* The first condition is added without an operator; subsequent
* conditions are prefixed with the given operator (e.g., AND, OR).
*
* @param string $value The condition value.
* @param string $fldname The field name for the condition.
* @param string $operator The logical operator (AND/OR) for subsequent conditions.
* @return bool The current state of the blnWhere flag.
*/
public function addWhere($value,$fldname="",$operator="") {}
/**
* Builds and returns the complete SQL query string.
*
* Assembles the SELECT, FROM, and WHERE parts based on the
* current state of the builder.
*
* @return string The complete SQL query string.
*/
public function getSql() {}
/**
* Adds a WHERE condition based on a form component's value.
*
* If the component has been submitted and has a non-empty value,
* it builds a condition using the component's database field and
* appends it to the query via a dynamic where_<field> call.
*
* @param object $component The form component to derive the condition from.
* @param bool $blnwherestatus Reference to the WHERE status flag.
* @param string $comparisonType The comparison type (default "LIKE").
* @return bool The updated WHERE status flag.
*/
public function addComponentWhere($component,&$blnwherestatus,$comparisonType="LIKE") {}
}
}
