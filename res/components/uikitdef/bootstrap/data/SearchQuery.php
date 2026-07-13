<?php
/**
 * Description of SearchQuery
 *
 * @author SARTAJ
 */
namespace {


class SearchQuery extends \Sphp\tools\Component{
public $sql = '';
public $result = array();
public $row = array();
public $cacheTime = 0;
private $cachesave = false;
private $cachefile = '';
private $cachekey = 'id';
private $roote = null;

protected function oninit() {
//$this->fu_unsetrenderTag();
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
    $mysql = \SphpBase::dbEngine();
    $this->result = $mysql->fetchQuery($this->sql,$this->cacheTime,$this->cachefile,$this->cachekey,$this->cachesave);

    $stro = "";
    if($this->roote == null){
        $this->roote = $this->frontobj->getChildrenWrapper($this);
    }
    foreach($this->result as $key1=>$keyar){ 
        foreach($keyar as $index=>$this->row){ 
       $stro .= $this->frontobj->parseComponentChildren($this->roote);
        }  
    }
    //SphpBase::debug()->println($stro);

    return $stro;

}



protected function onprerender(){
    $this->element->replaceChildren($this->genrender());
}

    protected function onholder($obj) {
        switch($obj->tagName){
            case 'img':{
                if($this->row[$obj->getAttribute("dfield")] != ''){
                    $obj->setAttribute('src',$this->row[$obj->getAttribute("dfield")]);
                }else if($obj->hasAttribute('default')){
                    $obj->setAttribute('src',$obj->getAttribute('default'));                    
                }
                break;
            }default:{
                if($this->row[$obj->getAttribute("dfield")] != ''){
                    $obj->setInnerHTML($this->row[$obj->getAttribute("dfield")]);
                }else if($obj->hasAttribute('default')){
                    $obj->setInnerHTML($obj->getAttribute('default'));                    
                }
                break;
            }
        }
    }

}
}
