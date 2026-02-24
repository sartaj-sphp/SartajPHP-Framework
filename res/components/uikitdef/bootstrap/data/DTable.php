<?php
/**
 * Description of DTable
 *
 * @author Sartaj
 */
namespace {

class DTable  extends \Sphp\tools\Component{
private $strFormat = '';
public $fields = array();
private $app = '';
public $RenderComp;
private $form = '';
private $blnDontuseFormat = false;


protected function oninit() {
$tblName = \SphpBase::page()->tblName;
if($tableName==''){
$this->dtable = $tblName;
    }
$this->RenderComp = new \Sphp\tools\RenderComp();
}

     public function fu_setMsgName($val) { $this->msgName = $val;}
public function fu_setApp($val){
$this->app = $val;
}
public function fu_setForm($val){
$this->form = $val;
}

public function fu_setField($dfield,$label='',$type='',$req='',$min='',$max=''){
if($label==''){
   $label = $dfield;
}
$this->fields[] = array($label,$dfield,$type,$req,$min,$max);
}
public function fu_setDontUseFormat(){
$this->blnDontuseFormat = true;
}

public function createComp($id,$path='',$class=''){
$comp = $this->RenderComp->createComp2($id,$path,$class,$id);
$comp->setForm($this->form);
$comp->setFrontobj($this->frontobj);
$this->frontobj->setComponent($comp->name,$comp); 
\SphpBase::sphp_api()->addComponent($comp->name,$comp);
return $comp;
}

public function genComp(){
  $comppath = \SphpBase::sphp_settings()->comp_path;
  $libpath = \SphpBase::sphp_settings()->slib_path;
// count total page
foreach($this->fields as $key=>$arrn){ 
$label = $arrn[0];
$id = $arrn[1];
$type = $arrn[2];
$minlen = $arrn[4];
$maxlen = $arrn[5];
$req = $arrn[3];
switch($type){
    case 'text':{
$gate = $this->createComp($id,"{$libpath}/comp/html/TextField.php","Sphp\\comp\\html\\TextField");
$gate->tagName = "input";
if($minlen!=""){
$gate->setMinLen($minlen);
}
if($maxlen!=""){
$gate->setMaxLen($maxlen);
}
if($req=="r"){
$gate->setRequired();
}
break;
    }
    case 'hidden':{
$gate = $this->createComp($id,"{$libpath}/comp/html/TextField.php","Sphp\\comp\\html\\TextField");
$gate->tagName = "input";
$gate->unsetVisible();
break;
    }
   case 'pass':{
$gate = $this->createComp($id,"{$libpath}/comp/html/TextField.php","Sphp\\comp\\html\\TextField");
$gate->tagName = "input";
$gate->setPassword();
if($minlen!=""){
$gate->setMinLen($minlen);
}
if($maxlen!=""){
$gate->setMaxLen($maxlen);
}
if($req=="r"){
$gate->setRequired();
}
break;
    }
    case 'num':{
$gate = $this->createComp($id,"{$libpath}/comp/html/TextField.php","Sphp\\comp\\html\\TextField");
$gate->tagName = "input";
$gate->setNumeric();
if($minlen!=""){
$gate->setMinLen($minlen);
}
if($maxlen!=""){
$gate->setMaxLen($maxlen);
}
if($req=="r"){
$gate->setRequired();
}
break;
    }
    case 'numeric':{
$gate = $this->createComp($id,"{$libpath}/comp/html/TextField.php","Sphp\\comp\\html\\TextField");
$gate->tagName = "input";
$gate->setNumeric();
if($minlen!=""){
$gate->setMinLen($minlen);
}
if($maxlen!=""){
$gate->setMaxLen($maxlen);
}
if($req=="r"){
$gate->setRequired();
}
break;
    }
    case 'email':{
$gate = $this->createComp($id,"{$libpath}/comp/html/TextField.php","Sphp\\comp\\html\\TextField");
$gate->tagName = "input";
$gate->setEmail();
if($minlen!=""){
$gate->setMinLen($minlen);
}
if($maxlen!=""){
$gate->setMaxLen($maxlen);
}
if($req=="r"){
$gate->setRequired();
}
break;
    }
    case 'textarea':{
$gate = $this->createComp($id,"{$libpath}/comp/html/TextArea.php","Sphp\\comp\\html\\TextArea");
$gate->tagName = "textarea";
if($minlen!=""){
$gate->setMinLen($minlen);
}
if($maxlen!=""){
$gate->setMaxLen($maxlen);
}
if($req=="r"){
$gate->setRequired();
}
break;
    }
    case 'select':{
$gate = $this->createComp($id,"{$libpath}/comp/html/Select.php","Sphp\\comp\\html\\Select");
$gate->tagName = "select";
$gate->setOptions($req);
break;
    }
    case 'date':{
$gate = $this->createComp($id,"controls/jquery/DateField2.php");
$gate->tagName = "input";
if($req=="r"){
$gate->setRequired();
}
break;
    }
    case 'file':{
$gate = $this->createComp($id,"{$libpath}/comp/html/FileUploader.php","Sphp\\comp\\html\\FileUploader");
$gate->tagName = "input";
$gate->setParameterA('type', 'file');
if($minlen!=""){
$gate->setFileMinLen($minlen);
}
if($maxlen!=""){
$gate->setFileMaxLen($maxlen);
}
if($req=="r"){
$gate->setRequired();
}
break;
    }
    default:{
$gate = $this->createComp($id,"$type");
if($minlen!=""){
$gate->setMinLen($minlen);
}
if($maxlen!=""){
$gate->setMaxLen($maxlen);
}
if($req=="r"){
$gate->setRequired();
}
break;
    }
}

$gate->setMsgName($label);
}
}

public function firecompcreate(){
    $idobj = null;
    foreach($this->fields as $key=>$arrn){
$id = $arrn[1];
$idobj = readGlobal($id);
$this->RenderComp->compcreate($idobj);
    }
    
}

public function genForm(){
// count total page
$stro = '';
$idobj = null;
if($this->strFormat==''){
$stro = '<table class="table table-striped pagtable">';
$blnf = true;
foreach($this->fields as $key=>$arrn){
$label = $arrn[0];
$id = $arrn[1];
$type = $arrn[2];
$minlen = $arrn[4];
$maxlen = $arrn[5];
$req = $arrn[3];
$idobj = readGlobal($id);
$idobj->setMsgName($label);
$field = $this->RenderComp->render($idobj);

if($blnf){
$stro .= "<tr class=\"pagrow1\">";
$blnf = false;
}else{
$stro .= "<tr class=\"pagrow2\">";
$blnf = true;
    }
$stro .= "<td class=\"paglabel\">$label</td><td class=\"pagfield\">$field</td></tr>";
}
$stro .= "</table>";
}
else{
$stro = $this->loadScript('<?php
 $idobj = null;
foreach($this->fields as $key=>$arrn){
$label = $arrn[0];
$id = $arrn[1];
$type = $arrn[2];
$minlen = $arrn[4];
$maxlen = $arrn[5];
$req = $arrn[3];
$idobj = readGlobal($id);
$idobj->setMsgName($label);
$field = $'.$this->name.'->RenderComp->render($idobj);

 ?>'.$this->strFormat.'<?php } ?>');
}
return $stro;

}

protected function oncreate($element){
if(!$this->blnDontuseFormat){
$this->strFormat = $element->innertext;
}
$element->innertext = '';
$str = $this->loadScript($element->getAttribute('oncreate')); 
$element->removeAttribute("oncreate");
$this->genComp();
}
    

protected function onjsrender(){
}

protected function onrender(){
// set default values
//$this->parameterA['class'] = 'pag';
$this->innerHTML = $this->genForm();
$this->unsetrenderTag();
}

// javascript functions used by ajax control and other control
public function getJSValue(){
return "document.getElementById('$this->name').value" ;
}

public function setJSValue($exp){
return "document.getElementById('$this->name').value = $exp;" ;
}



}
}
