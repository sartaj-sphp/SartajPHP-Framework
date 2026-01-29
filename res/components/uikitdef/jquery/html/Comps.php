<?php
/**
 * Description of Accordion
 *
 * @author SARTAJ
 */
//
include_once(SphpBase::sphp_settings()->php_path . "/classes/base/CompGroup.php");
include_once(SphpBase::sphp_settings()->comp_uikit_path . "/form/TextField.php");


class Comps extends CompGroup{
    
public function onstart(){
global $JQuery;
    $this->addComponent(new TextField('df1'));  
$this->setFrontFile(new FrontFile($this->mypath."demo2.front"));
$JQuery->getJQKit();
}
protected function oncompcreate($element){
//$this->inhtml = $element->innertext;
}
public function page_new(){
//    print $this->mypath;
}

protected function onjsrender(){
$tmp = $this->getFrontControl('txa1');
$tmp->setInnerHTMLApp($this->innerHTML);
$this->innerHTML = "";
}

public function sjs_df1_ofjs_drag($eventer){
 $jq->get('#df1')->val("drag1");
}
public function sjs_df2_ofjs_dragstart($eventer){
 $jq->get('#df1')->val("drag start");
}
public function sjs_df2_ofjs_dragstop($eventer){
 $jq->get('#df1')->val("drag stop");
}
public function sjs_dt1_ofjs_resize($eventer){
//    alert("resize ".$eventer->obj->val());
}
public function sjs_txa1_ofjs_drop($eventer){
//    $jq->get('#df1')->val("drop1");
$eventer->obj->append($jq->get($eventer->ui->draggable)->outerHTML());
}
public function sjs_df2_ofjs_click($eventer){
$data = "{dsm: 'hello2' }";
}
public function sjs_df2_sphp_click($eventer){
$JSServer->addJSONBlock('jsp','proces',"alert('".$_REQUEST['dsm']."')");  
}

}
?>