<?php

/**
 * Description of form
 *
 * @author SARTAJ
 */

namespace Sphp\comp\html{

class HTMLForm extends \Sphp\tools\Control {

    public $recID = 'txtid';
    private $onvalidation = '';
    private $blnajax = false;
    private $ajax = null;
    private $target = "";

    protected function genhelpPropList() {
        parent::genhelpPropList();
        $this->addHelpPropFunList('setAjax','Set Form post as AJAX','','');
        $this->addHelpPropFunList('setOnValidation','JS Function call on form validation and return false stop form to submit','','$jscode');
    }
    // call outside to load js lib for need form use via ajax lator
    public function setupJSLib() {
        addFileLink($this->myrespath . "/jslib/validation.js", true);
        addFileLink($this->myrespath . "/jslib/jquery.form.js", true);        
    }
    public function oninit() {
        $this->tagName = "form";
        addFileLink($this->myrespath . "/jslib/validation.js", true);
    }

    public function setAjax() {
        $this->blnajax = true;
        addFileLink($this->myrespath . "/jslib/jquery.form.js", true);
    }

    public function setAjaxTarget($val) {
        $this->target = $val;
    }

    public function setRecID($val) {
        $this->recID = $val;
    }

    public function getRecID() {
        return $this->recID;
    }

    public function setOnValidation($val) {
        $this->onvalidation = $val;
    }

    public function onprejsrender() {
        $valdx = "";
        if ($this->blnajax) {
            \SphpBase::$JSServer->getAJAX();
            if ($this->target == '') {
                $divt = '<div style="visibility:hidden;"><img src="' . \SphpBase::$sphp_settings->res_path . '/'. \SphpBase::$sphp_settings->slib_version  . '/comp/html/res/ajax-loader.gif" />' . "</div><div id=\"" . $this->name . "res\"></div>";
                $this->target = $this->name . "res";
            } else {
                $divt = "";
            }

            $this->setPreTag($divt);
            $subcode = "$('#{$this->name}').find(\"input[type='submit']\").attr('disabled',true);
jql('#" . $this->name . "').ajaxSubmit({
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
//jql("#testform").serialize())
            /*
              if(!isset($this->parameterA['action'])){
              $subcode ="
              getURL('".getThisPath('',true)."',jql('#$this->name').serialize());
              ";
              }else{
              $subcode ="
              getURL('".$this->parameterA['action']."',jql('#$this->name').serialize());
              ";
              }
             * 
             */

            //addHeaderJSFunctionCode('ready', $this->name, "jql('#" . $this->name . "').ajaxForm(); ");
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
        addFooterJSFunction($this->name . "_submit", "function " . $this->name . "_submit(val){
var blnSubmit = true ;
var ctlReq = Array();
var ctlEmail = Array();
var ctlNums = Array();
var ctlMins = Array();
var ctlMax = Array();
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

    public function onrender() {
        $this->setAttributeDefault("role","form");
        $this->setAttributeDefault("method","post");
        $this->setAttributeDefault("enctype","multipart/form-data");
        $this->setAttributeDefault("action",getThisPath());
        //$this->setAttributeDefault('onsubmit', "var vt = " . $this->name . "_submit('');return false;");
        if(!isset($this->onsubmit)){
            addHeaderJSFunctionCode("ready", $this->name .'rd1', "jql('#" . $this->name . "').on('submit',function(){var vt = " . $this->name . "_submit(''); event.preventDefault(); return false;}); ");
        }
        $hdn = "<input type=\"hidden\" name=\"" . $this->recID . "\" value=\"" . \SphpBase::$sphp_request->request($this->recID) . "\" />";
        $this->appendHTML($hdn);
        $parenttag = $this->wrapTag("div");
        $parenttag->setAttribute("id","wrp" . $this->name);
    }

}

}
