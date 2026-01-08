<?php
/**
 * Description of QueryBuilder
 *
 * @author Sartaj
 */
namespace Sphp\dev{

class QueryBuilder {
    private $tablename = "";
    private $fldnames = array();
    private $where = array();
    private $blnSelect = false;
    private $blnWhere = false;


    public function __construct($tablename="") {
        global $tblName;
        if($tablename==""){
            $tablename = $tblName;
        }
        $this->tablename = $tablename;
    }
    public function __call($name,$arguments) {
        $counter = 0;
        $fun = $this->findFunctionName($name);
        if($fun[0]=="where"){
            if(count($fun)>2){
                $arguments[1] = $fun[1];
                $counter = count($fun);
                if($this->findLastKey($fun[$counter - 1])){
                    $counter = $counter - 2;
                    $arguments[2] = $fun[$counter + 1];
                }
            $blst = true;
            foreach ($fun as $key => $value) {
                if($key>0 && $key <= $counter ){
                    if($blst){
                        $blst = false;
                        $arguments[1] = $value ;
                    }else{
                        $arguments[1] = $arguments[1] . '_' . $value ;   
                    }
                }
            }
            }else{
                $arguments[1] = $fun[1];                
            }

global $ctrl;
//$ctrl->debug->println(json_encode($arguments));
        call_user_func_array(array($this, 'addWhere'), $arguments);
        }
      // print_r($fun);
    }
    private function findFunctionName($name) {
           return explode('_',$name);
    }
    private function findLastKey($name) {
        $name = strtoupper($name);
        if($name=="AND"){
            return true;
        }else if($name=="OR"){
            return true;            
        }else{
            return false;
        }
    }

    public function select($fldnames="") {
        $this->blnSelect = true;
        $flds = explode(',',$fldnames);
        foreach ($flds as $key => $value) {
            $this->addField($value);
        }
    }
    public function addField($name,$value="") {
        $this->fldnames[$name] = $value;
    }
    public function addWhere($value,$fldname="",$operator="") {
        if($this->blnWhere){
        $this->where[] = strtoupper($operator) . " $fldname  $value";            
        }else{
        $this->blnWhere = true;
        $this->where[] = " " . " $fldname  $value";
        }
        return $this->blnWhere;
    }
    
    public function getSQL() {
        $sql = "";
        if($this->blnSelect){
            $sql = "SELECT ";
            foreach ($this->fldnames as $key => $value) {
                $sql .= "$key,";
            }
            $sql = substr($sql,0,  strlen($sql)-1) . " FROM $this->tablename";
        }
        if($this->blnWhere){
            $sql .= " WHERE ";
            foreach ($this->where as $key => $value) {
                $sql .= " $value";
            }
            
        }
        
        return $sql;
    }
    // below function is for special purpose
    public function addComponentWhere($component,&$blnwherestatus,$comparison_type="LIKE") {
        if($component->issubmit && $component->value!="empt" && $component->value!="--Select--" && $component->value!=""){
            $str = '';
            $fun = "where_" . $component->dfield;
            if($comparison_type=="LIKE"){
                $str = "LIKE '%" . $component->getSqlSafeValue() ."%'";
            }else{
                $str = "$comparison_type '". $component->getSqlSafeValue() ."'";                
            }
            if($blnwherestatus){
            $this->{$fun ."_and"}($str) ;
            }else{
            $blnwherestatus = true;
            $this->{$fun}($str) ;
            }
        }
        return $blnwherestatus;
    }
    // end special purpose
}

}
