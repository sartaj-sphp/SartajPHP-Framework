<?php
/**
* Description of DBGen
*
* @author Sartaj
*/
namespace Sphp\Dev{
/**
* DBGen
*
* Database code generator helper class. It generates HTML edit forms,
* search/browse grids and auto app gate code from database table columns.
*/
class DBGen {
/**
* Generate HTML Edit Form for a database table
* @param string $tablename
* @return string
*/
public function getEditForm($tablename) {}
/**
* Generate HTML Search and Browse Grid for a database table
* @param string $tablename
* @param string $gate
* @return string
*/
public function getShowForm($tablename,$gate="") {}
/**
* Generate Auto App Gate code for a database table
* @param string $tablename
* @param string $gate
* @return string
*/
public function getApp($tablename,$gate="") {}
/**
* Convert field name to display name
* @param string $fieldname
* @return string
*/
/**
* Generate HTML Label and Field for a database field
* @param array $dbfield
* @param string $formid
* @param string $idprefix
* @return string
*/
public function getEditFormFieldLabel($dbfield,$formid="form2",$idprefix="") {}
/**
* Generate HTML Field for a database field
* @param array $dbfield
* @param string $formid
* @param string $idprefix
* @return array
*/
public function getEditFormField($dbfield,$formid="form2",$idprefix="") {}
}
}
