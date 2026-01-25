<?php
/**
 * Description of fileuploader
 *
 * @author SARTAJ
 */



class FileUploader extends Sphp\tools\Component{
public $maxLen = '';
public $minLen = '';
private $formName = '';
private $msgName = '';
private $req = false;
private $fileType = '';
private $fileExtention = '';
private $fileTypeA = '';
private $fileSize = '';
private $fileFrontName = '';
private $fildName = '';
private $tablName = '';
private $fileSavePath = '';

protected function oncreate($element) {
        if(!$this->element->hasAttribute("name")){
            $this->HTMLName = $this->name;
        }else{
            $this->HTMLName = $this->getAttribute("name");            
        }
$this->unsetEndTag();
$this->fileType = $_FILES["$name"]["type"];
$this->fileSize = $_FILES["$name"]["size"];
$this->fileFrontName = $_FILES["$name"]["tmp_name"];
if($this->fileFrontName!=''){
$_REQUEST[$this->name] =  $_FILES["$name"]["name"];
$ft = pathinfo($_FILES["$name"]["name"]);
$this->fileExtention = $ft['extension'];
}
$this->tagName = "input";
$this->setAttribute('type', 'file');
if(SphpBase::page()->sact== $name.'del'){
$file = decrypt($_REQUEST['pfn']);
$pt = pathinfo($file);
if(file_exists($file)){unlink($file);}
if(file_exists('cache/'.$pt['basename'])){unlink('cache/'.$pt['basename']);}
if($element->dtable == ""){
$tblName = SphpBase::page()->tblName;
}else{
    $tblName = $element->dtable;
}
SphpBase::dbEngine()->executeQueryQuick("UPDATE $tblName SET $this->fildName='' WHERE id='". SphpBase::page()->getEventParameter() ."'");
SphpBase::JSServer->addJSONBlock('html','out'.$this->name,'Pic Deleted!');
}
$this->saveFile($this->fileSavePath);

}

     public function fu_setForm($val) { $this->formName = $val;}
     public function fu_setMsgName($val) { $this->msgName = $val;}
     public function fu_setRequired() {
if($this->issubmit){
if(strlen($this->value) < 1){
setErr($this->name.'-req',"Can not submit Empty");
            }
  }
$this->req = true;
}
     public function fu_setFileMaxLen($val)
     {
         $this->maxLen = $val;
if($this->issubmit){
if($this->getFileSize() > $val){
setErr($this->name.'-maxfl',"Maximum File Length should not be exceed then $val bytes");
                                }
              }
         }
     public function getFileMaxLen() { return $this->maxLen; }
     public function fu_setFileMinLen($val)
     {
         $this->minFileLen = $val;
if($this->issubmit){
if($this->getValue()!='' && $this->getFileSize() < $val ){
    setErr($this->name.'-minfl',"Minimum File Length should be $val bytes");
}
}
         }
public function getFileMinLen() { return $this->minLen; }
     public function fu_setFileType($val){$this->fileType = $val;}
     public function getFileType(){return $this->fileType;}
     public function fu_setFileSize($val){$this->fileSize = $val;}
     public function getFileSize(){return $this->fileSize;}
     public function fu_setFileTypesAllowed($val){$this->fileTypeA = $val; $this->findTypeAllowed();}
     public function getFileTypesAllowed(){return $this->fileTypeA;}
     public function getFileFrontName(){return $this->fileFrontName;}
     public function getFilePrevName(){return $_REQUEST['hid'.$this->name];}
     public function getFileExtention(){return $this->fileExtention;}
     public function fu_setFileSavePath($val){$this->fileSavePath = $val;}

private function findTypeAllowed(){
$blnFound = false;
if($this->issubmit){
$types = split(',',$this->getFileTypesAllowed());
    foreach($types as $key=>$val){
        if($val == $this->getFileType()){
$blnFound = true;
break;
    }
    }
    if(!$blnFound){
       setErr($this->name.'-filetype',$this->getFileType(). ' File Type is not allowed');
    }
}

}
private function saveFile($FilePath){
if ($this->issubmit && !getCheckErr()){
if ($_FILES[$this->name]["error"] > 0)
    {
        setErr($this->name.'-save',$_FILES[$this->name]["error"]);
       }
  else
    {
	if(!move_uploaded_file($_FILES[$this->name]["tmp_name"], $FilePath )){
        setErr($this->name.'-save',"Can not save file on server");
            }else{
                $this->value = $this->fileSavePath;
            }
//    $this->value = $FilePath;
    }
    }
}


protected function onjsrender(){
global $JSServer;
$JSServer->getAJAX();
addFileLink($this->myrespath."res/jquery.MultiFile.pack.js");
$this->setPostTag('<div id="'.$this->name.'-list"></div>');
addHeaderJSFunctionCode('ready', $this->name, "
$('#{$this->name}').MultiFile({
list: '#{$this->name}-list',
max: 1,
accept: 'gif|jpg|png|bmp|swf'
});
");
if($this->formName!=''){
if($this->req){
addFooterJSFunctionCode("{$this->formName}_submit", "{$this->name}req", "
ctlReq['$this->name']= Array('$this->msgName','TextField');");
}
}

}

protected function onrender(){
global $JSClient,$page;
    if($this->value!=''){
    $this->parameterA['value'] = $this->value;
if($this->value!=''){
    $this->setPostTag('<input type="hidden" name="hid'.$this->name.'" value="'.$this->value.'" /><div id="out'.$this->name.'">
        <img src="'.$this->value.'" width="150" height="100" /><a href="javascript: '.$JSClient->postServer("'".getEventURL($this->name.'del',SphpBase::page()->evtp,'','pfn='.encrypt($this->value),'',true)."'").'">Delete</a></div>');
}
}
}

// javascript functions used by ajax control and other control
public function getJSValue(){
return "document.getElementById('$this->name').value" ;
}

public function setJSValue($exp){
return "document.getElementById('$this->name').value = $exp;" ;
}

}
?>