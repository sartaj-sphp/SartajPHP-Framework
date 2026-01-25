<?php

/**
 * Description of form
 *
 * @author SARTAJ
 */

namespace Sphp\comp\html{

class HTMLForm extends \Sphp\tools\Component {
    private $recID = 'txtid2';
    private $txtid2 = '';
    private $onvalidation = '';
    private $blnajax = false;
    private $blnsocket = false;
    private $socketctrl = "index";
    private $socketevt = "";
    private $socketevtp = "";
    private $ajax = null;
    private $target = "";

    protected function genhelpPropList() {
        parent::genhelpPropList();
        $this->addHelpPropFunList('setAjax','Set Form post as AJAX','','');
        $this->addHelpPropFunList('setOnValidation','JS Function call on form validation and return false stop form to submit','','$jscode');
    }
    // call outside to load js lib for need form use via ajax lator
    public function fu_setupJSLib() {
        addFileLink($this->myrespath . "/jslib/validation.js", true);
        addFileLink($this->myrespath . "/jslib/jquery.form.js", true);        
    }
    protected function oninit() {
        $this->tagName = "form";
        if(!$this->element->hasAttribute("name")){
            $this->HTMLName = $this->name;
        }else{
            $this->HTMLName = $this->getAttribute("name");            
        }
        addFileLink($this->myrespath . "/jslib/validation.js", true);
        $this->recID = $this->HTMLName . 're';        
        if (\SphpBase::sphp_request()->request($this->recID) !== "") {
            $this->txtid2 = urldecode(\SphpBase::sphp_request()->request($this->recID));
            if(isSecureVal($this->txtid2)){
                $this->txtid2 = secure2Val($this->txtid2);
                if($this->txtid2 == "") setErr("App", "Invalid Form Data");
            }
        }        
    }

    
    public function fu_setAjax() {
        $this->blnajax = true;
        addFileLink($this->myrespath . "/jslib/jquery.form.js", true);
    }

    public function fu_setSocket($ctrl,$evt="",$evtp="") {
        $this->blnsocket = true;
        $this->socketctrl = $ctrl;
        $this->socketevt = $evt;
        $this->socketevtp = $evtp;
    }
    
    public function fu_setAjaxTarget($val) {
        $this->target = $val;
    }

    public function getRecID() {
        return $this->txtid2;
    }

    public function setRecID($v) {
        $this->txtid2 = $v;
    }
    
    public function fu_setOnValidation($val) {
        $this->onvalidation = $val;
    }
    protected function onprejsrender() {
        $valdx = "";
        if ($this->blnajax) {
            \SphpBase::JSServer()->getAJAX();
            if ($this->target == '') {
                $divt = '<div style="visibility:hidden;"><img src="' . \SphpBase::sphp_settings()->res_path . '/'. \SphpBase::sphp_settings()->slib_version  . '/comp/html/res/ajax-loader.gif" />' . "</div><div id=\"" . $this->name . "res\"></div>";
                $this->target = $this->name . "res";
            } else {
                $divt = "";
            }

            $this->setPreTag($divt);
            $subcode = "$('#{$this->name}').find(\"input[type='submit']\").attr('disabled',true);
$('#" . $this->name . "').ajaxSubmit({
dataType: 'text',
success:  function(html) { 
if(document.getElementById('ajax_loader')!=null){
document.getElementById('ajax_loader').style.visibility = 'hidden';
}
$('#{$this->name}').find(\"input[type='submit']\").attr('disabled',false);
        sartajpro(html,function(res){}); 
    }
        });
   ";
//$("#testform").serialize())
            /*
              if(!isset($this->parameterA['action'])){
              $subcode ="
              getURL('".getThisURL('',true)."',$('#$this->name').serialize());
              ";
              }else{
              $subcode ="
              getURL('".$this->parameterA['action']."',$('#$this->name').serialize());
              ";
              }
             * 
             */

            //addHeaderJSFunctionCode('ready', $this->name, "$('#" . $this->name . "').ajaxForm(); ");
        }else if($this->blnsocket){
            \SphpBase::JSServer()->getAJAX();
            $subcode = " frontobj.getSphpSocket(function(wsobj1){
    var formData = $('#" . $this->name . "').serializeAssoc();
	delete formData['sphpajax'];
    wsobj1.callProcessApp('{$this->socketctrl}','{$this->socketevt}','{$this->socketevtp}',formData);
});";
            
} else {
            $subcode = "
if(val==''){
objc1.submit();
}else{
objc1.action=val;
objc1.submit();
    }
    ";
        }
        if ($this->onvalidation != '') {
            $valdx = "if(blnSubmit==true){
blnSubmit =  " . $this->onvalidation . ";
}
";
        }
        addHeaderJSCode($this->name . "csubmit2", 'var ' . $this->name . 'st1 = true;$("#'. $this->name .'").on("keydown",clearValidationError);');
        addHeaderJSFunction($this->name . "_submit2", "function " . $this->name .  "_submit2(val){ var vt = false;"," if({$this->name}st1){ {$this->name}st1 = false; vt = " . $this->name . "_submit(val); } setTimeout(function(){{$this->name}st1 = true;},4000); return vt;}");
        addHeaderJSFunction($this->name . "_submit", "function " . $this->name . "_submit(val){
var blnSubmit = true ;
var ctlReq = Array();
var ctlEmail = Array();
var ctlNums = Array();
var ctlMins = Array();
var ctlMax = Array();
clearValidationError('');
", "
 
if(blnSubmit==true && checkTextEmpty(ctlReq)==false){
    blnSubmit = false ;
}
if(blnSubmit==true && checkmax(ctlMax)==false){
    blnSubmit = false ;
}
if(blnSubmit==true && checkmin(ctlMins)==false){
    blnSubmit = false ;
}
if(blnSubmit==true && checkemails(ctlEmail)==false){
    blnSubmit = false ;
}
if(blnSubmit==true && checknums(ctlNums)==false){
    blnSubmit = false ;
}
$valdx
if(blnSubmit==true ){
var objc1 = document.getElementById('" . $this->name . "');
$subcode
        }
return false;
}");
    }

    protected function onrender() {
        $this->setAttributeDefault("role","form");
        $this->setAttributeDefault("method","post");
        $this->setAttributeDefault("enctype","multipart/form-data");
        $this->setAttributeDefault("action",getThisURL("",false,".app"));
        //$this->setAttributeDefault('onsubmit', "var vt = " . $this->name . "_submit2('');return false;");
        if(!isset($this->onsubmit)){
            addHeaderJSFunctionCode("ready", $this->name .'rd1', "$('#" . $this->name . "').on('submit',function(e){e.preventDefault(); var vt = " . $this->name . "_submit2(''); return vt;}); ");
        }
        $v1 = "";
        if($this->txtid2 != ""){
            $v1 = 't';
            $this->txtid2 = urlencode(val2Secure($this->txtid2));
        }
        $hdn = "<input type=\"hidden\" name=\"txtid\" value=\"" . $v1 . "\" />";
        $hdn .= "<input type=\"hidden\" name=\"" . $this->recID . "\" value=\"" . $this->txtid2 . "\" />";
        if($this->blnajax) $hdn .= "<input type=\"hidden\" name=\"sphpajax\" value=\"1\" />";
        $this->appendHTML($hdn);
        $parenttag = $this->wrapTag("div");
        $parenttag->setAttribute("id","wrp" . $this->name);
        $parenttag->setAttribute("class", "px-4 py-4");
    }

}

}
