<?php
/**
 * Description of fileuploader
 *
 * @author SARTAJ
 */
namespace Sphp\comp\html{


class FileUploader extends \Sphp\tools\Component{
public $maxLen = '';
public $minLen = '';
public $valuehid = '';
private $formName = '';
private $msgName = '';
private $defaultImg = '';
private $req = false;
private $fileType = '';
private $fileExtention = '';
private $filename = '';
private $fileTypeA = '';
private $fileSize = '';
private $fileFrontName = '';
private $fildName = '';
private $tablName = '';
private $fileSavePath = '';
private $btnDelete = false;
private $imgTag = false;
private $errmsg = "";

protected function oncreate($element) {
$page = \SphpBase::page();
$tblName = \SphpBase::page()->tblName;
$JSServer = \SphpBase::JSServer();
$Client = \SphpBase::sphp_request();
$mysql = \SphpBase::dbEngine();

$this->unsetEndTag();
if(\SphpBase::sphp_request()->isFile("$this->name")){
    $f1 = \SphpBase::sphp_request()->files("$this->name");
$this->fileType = $f1["type"];
$this->fileSize = $f1["size"];
$this->fileFrontName = $f1["tmp_name"];
if($this->fileFrontName!=''){
\SphpBase::sphp_request()->request($this->name,false,$f1["name"]);
$ft = pathinfo($f1["name"]);
$this->fileExtention = $ft['extension'];
$this->filename = $ft['filename'];

}
}
$this->tagName = "input";
if(\SphpBase::page()->sact== $this->name.'del'){
$file = substr(decryptme(\SphpBase::sphp_request()->request('pfn')),3);
$pt = pathinfo($file);
if(file_exists($file)){unlink($file);}
if(file_exists('cache/'.$pt['basename'])){unlink('cache/'.$pt['basename']);}
if($this->fildName!=''){
$mysql->executeQueryQuick("UPDATE $tblName SET $this->fildName='' WHERE id='". \SphpBase::page()->getEventParameter() . "'");
}
$JSServer->addJSONBlock('html','out'.$this->name,'Pic Deleted!');
}
    $this->setAttribute('type', 'file');
    if($this->getAttribute('blndontsave')!= "true"){
        $this->saveFile($this->fileSavePath);
    }

}

    protected function genhelpPropList() {
        parent::genhelpPropList();
        $this->addHelpPropFunList('setForm','Bind with Form JS Event','','$formid');
        $this->addHelpPropFunList('setMsgName','Name Display in placeholder and Error','','$val');
        $this->addHelpPropList('blndontsave','dont save file on server','','$val','select','true,false');
        $this->addHelpPropFunList('setRequired','Can not submit Empty','','');
        $this->addHelpPropFunList('setImage','Set Image Path to display as file icon','','$filepath');
        $this->addHelpPropFunList('setDisplayFile','Show File','','');
        $this->addHelpPropFunList('setDeleteButton','Show File Delete Button','','');
        $this->addHelpPropFunList('setFileMaxLen','Set allow Max file size to upload','','$size');
        $this->addHelpPropFunList('setFileMinLen','Set allow Min file size to upload','','');
        $this->addHelpPropFunList('setFileTypesAllowed','Set MIME types list with comma separated string','','$list');
        $this->addHelpPropFunList('setFileSavePath','Set file save path on server','','$filepath');      
    }

public function deleteFile() {
    $file = decryptme(\SphpBase::sphp_request()->request("hid" . $this->name));
    if($file != ""){
    $file = substr($file,3);
    $pt = pathinfo($file);
    if(file_exists($file)){unlink($file);}
    if(file_exists('cache/'.$pt['basename'])){unlink('cache/'.$pt['basename']);}
    }
}
public function isUpdateFile() {
    $file = decryptme(\SphpBase::sphp_request()->request("hid" . $this->name));
    if($file != "" && $this->value != ""){
        $file = substr($file,3);
        if($file != $this->value){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }    
}
public function fu_setDisplayFile() {
    $this->imgTag = true;
}
public function fu_setDeleteButton() {
    $this->btnDelete = true;
}
protected function onit() {
        if($this->getAttribute("placeholder") != ""){
            $this->msgName = $this->getAttribute("placeholder");
        }        

}

     public function fu_setImage($val) { $this->defaultImg = $val;}
     public function fi_setForm($val) { $this->formName = $val;}
     public function fu_setMsgName($val) { $this->msgName = $val; $this->setAttribute('placeholder', $val);}
     public function fi_setRequired() {
if($this->issubmit){
if(strlen($this->value) < 1){
$this->setErrMsg($this->getAttribute("placeholder") .' ' . "Can not submit Empty");
            }
  }
$this->req = true;
}
     public function fi_setFileMaxLen($val)
     {
         $this->maxLen = $val;
if($this->issubmit){
if($this->getFileSize() > $val){
$this->setErrMsg($this->getAttribute("placeholder") .' ' . "Maximum File Length should not be exceed then $val bytes");
                                }
              }
         }
     public function getFileMaxLen() { return $this->maxLen; }
     public function fi_setFileMinLen($val)
     {
         $this->minFileLen = $val;
if($this->issubmit){
if($this->getValue()!='' && $this->getFileSize() < $val ){
    $this->setErrMsg("Minimum File Length should be $val bytes");
}
}
         }
public function getFileMinLen() { return $this->minLen; }
     public function fi_setFileType($val){$this->fileType = $val;}
     public function getFileType(){return $this->fileType;}
     public function fi_setFileSize($val){$this->fileSize = $val;}
     public function getFileSize(){return $this->fileSize;}
     public function fi_setFileTypesAllowed($val){$this->fileTypeA = $val; $this->findTypeAllowed();}
     public function getFileTypesAllowed(){return $this->fileTypeA;}
     public function getFileFrontName(){return $this->fileFrontName;}
     public function getFileName(){return $this->filename;}
     public function getFilePrevName(){return \SphpBase::sphp_request()->request('hid'.$this->name);}
     public function getFileExtension(){return $this->fileExtention;}
     public function fi_setFileSavePath($val){$this->fileSavePath = $val;}

private function findTypeAllowed(){
$blnFound = false;
if($this->issubmit){
$types = explode(',',$this->getFileTypesAllowed());
    foreach($types as $key=>$val){
        if($val == $this->getFileType()){
$blnFound = true;
break;
    }
    }
    if(!$blnFound){
       $this->setErrMsg($this->getAttribute("placeholder") .' ' . $this->getFileType(). ' File Type is not allowed');
    }
}

}
public function saveFile($FilePath){
if ($this->issubmit && !getCheckErr()){
if (\SphpBase::sphp_request()->isFile($this->name) && \SphpBase::sphp_request()->files($this->name)["error"] > 0)
    {
        $this->setErrMsg(\SphpBase::sphp_request()->files($this->name)["error"]);
       }
  else{
      $p1 = "";
       if(\SphpBase::sphp_request()->isNativeClient){
           $p1 = \SphpBase::sphp_request()->request($this->name);
        if(file_exists($p1) && !rename($p1,$FilePath )){
            $this->setErrMsg("Can not save file on server");
                }else{
                    $this->value = $FilePath;
                }
       }else{
          $p1 = \SphpBase::sphp_request()->files($this->name)["tmp_name"];           
            if(!move_uploaded_file($p1, $FilePath )){
                $this->setErrMsg("Can not save file on server");
                    }else{
                        $this->value = $FilePath;
                    }
       }
       
        }

    }
    
}


protected function onjsrender(){
//SphpBase::JSServer()->getAJAX();
if($this->formName!=''){
if($this->req){
addHeaderJSFunctionCode("{$this->formName}_submit", "{$this->name}req", "
ctlReq['$this->name']= Array('$this->msgName','TextField');");
}
}

}
    public function setErrMsg($msg){
        $this->errmsg .= '<strong class="alert-danger">' . $msg . '! </strong>';
        if(\SphpBase::sphp_request()->isAJAX()){
            \SphpBase::JSServer()->addJSONJSBlock('$("#'. $this->name .'").after("<strong class=\"alert-danger\">' . $msg . '! </strong>");');
        }
        setErr($this->name, $msg);
    }

protected function onrender(){
$page = \SphpBase::page();
$imgtag = '';
$btnd = '';
    if($this->errmsg!=""){
        $this->addPostTag($this->errmsg);
    }

if($this->value !=""){  
    $ft = pathinfo($this->value);
    $this->fileExtention = strtolower($ft['extension']);
    if($this->imgTag || $this->fileExtention == "jpeg" || $this->fileExtention == "jpg" || $this->fileExtention == "gif" || $this->fileExtention == "png"){
        if($this->defaultImg == ''){
            $this->defaultImg = $this->value;
        }
        $imgtag = '<img src="'.$this->defaultImg.'" width="150" height="100" />';
    }
    if($this->btnDelete){
        $btnd = '<a href="javascript: '. \SphpBase::JSServer()->postServer("'".getEventURL($this->name.'del',\SphpBase::page()->evtp,'','pfn='.encryptme('t7i' . $this->value),'',true)."'").'">Delete</a>';
    }
}

$this->setAttributeDefault("class", "form-control");
    if($this->value!=''){
    $this->setAttribute('value', $this->value);
if($this->value!=''){
    $this->valuehid = encryptme('t7i'.$this->value);
    $this->addPostTag('<input type="hidden" name="hid'.$this->name.'" value="'. $this->valuehid .'" /><div id="out'.$this->name.'">
      '. $imgtag . $btnd .'  </div>');
}
}
        switch($this->styler){
            case 1:{
                $this->element->appendPreTag('<div class="form-floating mb-3">');
                $this->element->appendPostTag('<label for="'. $this->HTMLID .'" class="form-label">'. $this->msgName .'</label></div>');
                break;
            }case 2:{
                $this->element->appendPreTag('<div class="mb-3">
                <label for="'. $this->HTMLID .'" class="form-label">'. $this->msgName .'</label>');
                $this->element->appendPostTag('<div id="'. $this->HTMLID .'Help" class="form-text">'. $this->helptext .'</div></div>');
                break;
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
}
