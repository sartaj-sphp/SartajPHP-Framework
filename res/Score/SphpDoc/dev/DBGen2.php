<?php
/**
* Description of DBGen
*
* @author Sartaj
*/
namespace Sphp\dev{
class DBGen2 {
public function getEditForm($tablename,$gate="") {}
public function getGate($tablename,$gate="") {}
public function getShowForm($tablename,$gate="") {}
public function convertFieldName($fieldname){}
public function getEditFormFrontlateStart($dbfield,$gate,$formid="form2",$idprefix="") {}
public function getEditFormFieldLabel($dbfield,$formid="form2",$idprefix="") {}
public function getEditFormField($dbfield,$formid="form2",$idprefix="") {}
public function getAllField($tablename) {}
}
}
