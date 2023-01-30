<?php
/**
 * Description of fileuploader
 *
 * @author SARTAJ
 */



class FileUploader extends Control{
public $maxLen = '';
public $minLen = '';
private $formName = '';
private $msgName = '';
private $req = false;
private $fileType = '';
private $fileExtention = '';
private $fileTypeA = '';
private $fileSize = '';
private $fileTempName = '';
private $fildName = '';
private $tablName = '';
private $fileSavePath = '';

public function __construct($name='',$fieldName='',$tableName='') {
global $page,$JSServer,$tblName,$mysql;
$this->name = $name;
$this->fildName = $fieldName;
$this->tablName = $tableName;
$this->unsetEndTag();
$this->fileType = $_FILES["$name"]["type"];
$this->fileSize = $_FILES["$name"]["size"];
$this->fileTempName = $_FILES["$name"]["tmp_name"];
if($this->fileTempName!=''){
$_REQUEST[$this->name] =  $_FILES["$name"]["name"];
$ft = pathinfo($_FILES["$name"]["name"]);
$this->fileExtention = $ft['extension'];
}
$this->tagName = "input";
$this->parameterA['type'] = 'file';
$this->init($this->name,$this->fildName,$this->tablName);
if(SphpBase::page()->sact== $name.'del'){
$file = decrypt($_REQUEST['pfn']);
$pt = pathinfo($file);
if(file_exists($file)){unlink($file);}
if(file_exists('cache/'.$pt['basename'])){unlink('cache/'.$pt['basename']);}
$mysql->executeQueryQuick("UPDATE $tblName SET $this->fildName='' WHERE id='SphpBase::page()->evtp'");
$JSServer->addJSONBlock('html','out'.$this->name,'Pic Deleted!');
}
}

     public function setForm($val) { $this->formName = $val;}
     public function setMsgName($val) { $this->msgName = $val;}
     public function setRequired() {
if($this->issubmit){
if(strlen($this->value) < 1){
setErr($this->name.'-req',"Can not submit Empty");
            }
  }
$this->req = true;
}
     public function setFileMaxLen($val)
     {
         $this->maxLen = $val;
if($this->issubmit){
if($this->getFileSize() > $val){
setErr($this->name.'-maxfl',"Maximum File Length should not be exceed then $val bytes");
                                }
              }
         }
     public function getFileMaxLen() { return $this->maxLen; }
     public function setFileMinLen($val)
     {
         $this->minFileLen = $val;
if($this->issubmit){
if($this->getValue()!='' && $this->getFileSize() < $val ){
    setErr($this->name.'-minfl',"Minimum File Length should be $val bytes");
}
}
         }
public function getFileMinLen() { return $this->minLen; }
     public function setFileType($val){$this->fileType = $val;}
     public function getFileType(){return $this->fileType;}
     public function setFileSize($val){$this->fileSize = $val;}
     public function getFileSize(){return $this->fileSize;}
     public function setFileTypesAllowed($val){$this->fileTypeA = $val; $this->findTypeAllowed();}
     public function getFileTypesAllowed(){return $this->fileTypeA;}
     public function getFileTempName(){return $this->fileTempName;}
     public function getFilePrevName(){return $_REQUEST['hid'.$this->name];}
     public function getFileExtention(){return $this->fileExtention;}
     public function setFileSavePath($val){$this->fileSavePath = $val;}

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

public function oncreate($element){ 
$this->saveFile($this->fileSavePath);
}

public function onjsrender(){
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

public function onrender(){
global $JSClient,$page;
    if($this->value!=''){
    $this->parameterA['value'] = $this->value;
if($this->value!=''){
    $this->setPostTag('<input type="hidden" name="hid'.$this->name.'" value="'.$this->value.'" /><div id="out'.$this->name.'">
        <img src="'.$this->value.'" width="150" height="100" /><a href="javascript: '.$JSClient->postServer("'".getEventPath($this->name.'del',SphpBase::page()->evtp,'','pfn='.encrypt($this->value),'',true)."'").'">Delete</a></div>');
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