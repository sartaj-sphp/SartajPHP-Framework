<?php
/**
* Description of DBGen
*
* @author Sartaj
*/
namespace Sphp\dev{
class DBGen {
public function getEditForm($tablename) {}
public function getShowForm($tablename,$gate="") {}
public function getApp($tablename,$gate="") {}
public function getEditFormFieldLabel($dbfield,$formid="form2",$idprefix="") {}
public function getEditFormField($dbfield,$formid="form2",$idprefix="") {}
}
}
