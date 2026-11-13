<?php
/**
* Description of DBGen
*
* @author Sartaj
*/
namespace Sphp\Dev{
/**
* DBGen2
*
* Database code generator for SartajPHP. It generates edit forms, show/search
* panels, and gate class code from database table column definitions.
*/
class DBGen2 {
/**
* Constructor
* @param object $dbEngine Database engine object
*/
/**
* Generate Edit Form HTML for a table
* @param string $tablename
* @param string $gate
* @return string
*/
public function getEditForm($tablename,$gate="") {}
/**
* Generate Gate class code for a table
* @param string $tablename
* @param string $gate
* @return string
*/
public function getGate($tablename,$gate="") {}
/**
* Generate Show/Search Form HTML for a table
* @param string $tablename
* @param string $gate
* @return string
*/
public function getShowForm($tablename,$gate="") {}
/**
* Convert field name to display name
* @param string $fieldname
* @return string
*/
public function convertFieldName($fieldname){}
/**
* Generate Edit Form front late start HTML
* @param array $dbfield
* @param string $gate
* @param string $formid
* @param string $idprefix
* @return string
*/
public function getEditFormFrontlateStart($dbfield,$gate,$formid="form2",$idprefix="") {}
/**
* Generate Edit Form field label HTML
* @param array $dbfield
* @param string $formid
* @param string $idprefix
* @return string
*/
public function getEditFormFieldLabel($dbfield,$formid="form2",$idprefix="") {}
/**
* Generate Edit Form field HTML
* @param array $dbfield
* @param string $formid
* @param string $idprefix
* @return array
*/
public function getEditFormField($dbfield,$formid="form2",$idprefix="") {}
/**
* Get all fields of a table
* @param string $tablename
* @return array
*/
public function getAllField($tablename) {}
}
}
