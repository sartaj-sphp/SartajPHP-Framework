<?php
/**
 * Description of MenuItem
 *
 * @author SARTAJ
 */


namespace{
class MenuItem extends Control{
private $mkey = "";
private $mkeychar = "";

public function __construct($name='',$fieldName='',$tableName='') {
$this->init($name,$fieldName,$tableName);
$this->setHTMLName("");
$this->setHTMLID("");
}

public function setKey($key,$controlkeys="") {
$fkeya = array();
$fkeya["F1"] = 112;
$fkeya["F2"] = 113;
$fkeya["F3"] = 114;
$fkeya["F4"] = 115;
$fkeya["F5"] = 116;
$fkeya["F6"] = 117;
$fkeya["F7"] = 118;
$fkeya["F8"] = 119;
$fkeya["F9"] = 120;
$fkeya["F10"] = 121;
$fkeya["F11"] = 122;
$fkeya["F12"] = 123;
$mkeychar = "";
$controlkeysp = ""; 
    if(!is_numeric($key)){
        $mkeychar = strtoupper($key);
        if(strlen($key)>1){
            $key = $fkeya[$mkeychar];            
        }else{
            $key = ord($mkeychar);
        }
    }else{
        $mkeychar = strtoupper(chr($key));
    }
    if($controlkeys != ""){
        $controlkeysp = "+"; 
    }
    $this->mkeychar = " ". strtoupper($controlkeys). $controlkeysp . $mkeychar;
    $this->mkey = $key;
    $controlkeysa = explode('+',$controlkeys);
    $strkey = "";
    foreach ($controlkeysa as $key => $value) {
        if($value == "alt"){
            if($strkey != "") $strkey .= " && ";
            $strkey .= "eventer.event.altKey";
        }else if($value == "ctrl"){
            if($strkey != "") $strkey .= " && ";
            $strkey .= "eventer.event.ctrlKey";
        }else if($value == "shift"){
            if($strkey != "") $strkey .= " && ";
            $strkey .= "eventer.event.shiftKey";
        }
    }
    if($strkey != "") $strkey .= " && ";
    // code depend on key listner javascript code of framework
    addHeaderJSFunction("jq_menukeyevent", "function jq_menukeyevent(eventer){", " return true;}",true);
    addHeaderJSFunctionCode("jq_keyevent", "menukeyevent1", 'ret = (jq_menukeyevent(eventer2) ? ret : false);',true);
    addHeaderJSFunctionCode("jq_menukeyevent", $this->name, ' if('. $strkey .'eventer.keycode=='. $this->mkey .'){
        if(eventer.evt==\'keyup\'){
            $(".dropdown-item[data-mkey='.$this->mkey.']")[0].click();
        }
        return false;
    } 
',true);
    //console.log(eventer.keycode);
  //console.log(eventer.event.shiftKey);
  //console.log(eventer.event.ctrlKey);
  //console.log(eventer.event.altKey);
}

public function onrender(){
global $JSServer,$blnAjaxLink;
$mnuitemhref = $this->parameterA['href'];
$mnuitemtext = $this->innerHTML . $this->mkeychar;
//$this->setAttribute("class", "dropdown-item" . $this->getAttribute('class'));
$mnuitemtitle = $this->getAttribute('title');
$tfun = "menu_ajax";
if($this->getAttribute("onclick") != ""){
    $tfun = $this->getAttribute("onclick");
}
if($mnuitemhref==''){
    $mnuitemhref = "#";
}else if($blnAjaxLink && $this->getAttribute("noajax") != "true"){
    $mnuitemhref = "javascript: $tfun('$mnuitemhref');";
}
$this->innerHTML = '<a class="dropdown-item" data-mkey="'. $this->mkey .'" href="'.$mnuitemhref.'">'.$mnuitemtext.'</a>';
$this->tagName = "li";
}

}
}
