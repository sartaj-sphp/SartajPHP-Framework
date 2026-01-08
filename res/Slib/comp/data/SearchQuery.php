<?php
/**
 * Description of SearchQuery
 *
 * @author SARTAJ
 */
namespace {


class SearchQuery extends \Sphp\tools\Component{
public $sql = '';
public $strFormat = '';
public $result = array();
public $row = array();
public $cacheTime = 0;
private $cachesave = false;
private $cachefile = '';
private $cachekey = 'id';

protected function oninit() {
$this->unsetrenderTag();
}

    protected function genhelpPropList() {
        $this->addHelpPropFunList('setSQL','Set SQL Database Query','','$sql');
        $this->addHelpPropFunList('setCacheKey','Set Key for Cache default is id','','$val');
        $this->addHelpPropFunList('setCacheTime','Set Cache Expiry Time 0 mean no cache and -1 mean always data from cache','','$val');
    }

public function fu_setSQL($val){
$this->sql = $val;
}
public function fu_setCacheTime($val){
$this->cacheTime = intval($val);
}
public function fu_setCacheFile($val){
$this->cachefile = $val;
}
public function fu_setCacheSave(){
$this->cachesave = true;
}
public function fu_setCacheKey($val){
$this->cachekey = $val;
}
public function getRow($dfield){
if(isset($this->row[$dfield])){
return  $this->row[$dfield];
}else{
//    print_r($this->result);
//    trigger_error("Invalid Database Field in SQL:- ".$this->sql,E_USER_ERROR);  
    return "";
}
}

private function genrender(){
$stro = "";
//$roote = $this->frontobj->getChildrenWrapper($this);
foreach($this->result as $key1=>$keyar){
 foreach($keyar as $index=>$this->row){
$tmpf = new \Sphp\tools\FrontFileChild($this->strFormat,true,null,$this->frontobj);
$tmpf->run();
$stro .= $tmpf->data;
//$stro .= $this->frontobj->parseComponentChildren($roote);
 } }

return $stro;

}


protected function oncreate($element){
$this->strFormat = $this->element->innertext;
$this->element->innertext = '';
}


protected function onprerender(){
$mysql = \SphpBase::dbEngine();
$this->result = $mysql->fetchQuery($this->sql,$this->cacheTime,$this->cachefile,$this->cachekey,$this->cachesave);
}

protected function onrender(){
$this->innerHTML = $this->genrender();
}


}
}
