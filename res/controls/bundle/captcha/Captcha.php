<?php
/**
 * Description of captcha
 *
 * @author SARTAJ
 */
//include_once("{$libpath}/comp/html/TextField.php");


class Captcha extends Sphp\comp\html\TextField{

public function oncreate($element) {
$this->unsetEndTag();
if($this->issubmit){
if(SphpBase::sphp_request()->session('image_value') != md5(strtoupper($this->getValue()))){
setErr('Captcha', "Secure Image Code is not Correct!");

}
}

if(SphpBase::page()->isevent)
{
switch(SphpBase::page()->getEvent()){
case "captcha" :{ 
SphpBase::engine()->cleanOutput();
SphpBase::sphp_response()->addHttpHeader("Content-Type","image/jpeg");
SphpBase::sphp_response()->addHttpHeader("Cache-Control","no-cache, must-revalidate");
includeOnce("{$this->mypath}/cap.php");
$df = new CaptchaSub();
$dt1  = $df->genImage();
SphpBase::JSServer()->addJSONHTMLBlock('div'. $this->name, '<img src="data:image/jpeg;base64,'.  $dt1.'" width="150px" height="50px" />');
break;
}

}

 }

}



public function onrender(){
    SphpBase::JSServer()->getAJAX();
if($this->value!=''){
$this->setAttribute('value', $this->value);
}
if($this->maxLen!=''){
$this->setAttribute('maxlength', $this->maxLen);
}
//$this->setPreTag('<img src="'.  getEventURL('captcha').'" width="150px" height="50px"><br>');
$this->setPreTag('<div id="div'. $this->name .'"></div>');
addHeaderJSFunctionCode('ready', 'div' . $this->name, 'setTimeout(function(){getURL("'.  getEventURL('captcha').'");},4000);');
}

}