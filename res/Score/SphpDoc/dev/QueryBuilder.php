<?php
/**
* Description of QueryBuilder
*
* @author Sartaj
*/
namespace Sphp\dev{
class QueryBuilder {
public function select($fldnames="") {}
public function addField($name,$value="") {}
public function addWhere($value,$fldname="",$operator="") {}
public function getSQL() {}
public function addComponentWhere($component,&$blnwherestatus,$comparison_type="LIKE") {}
}
}
