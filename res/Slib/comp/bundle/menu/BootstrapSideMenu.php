<?php

class BootstrapSideMenu extends \Sphp\tools\MenuGen{
public $brandicon = "";
public $navbarClasses = "nav flex-column flex-nowrap overflow-hidden nav-pills";
private $mkey = "";
private $mkeychar = "";
private $fixedPos = "";
private $rootMenu = "sidebar";
private $counter1 = 1;

public function onrun() {
    $this->init();
    $this->genMenus();
}
public function setPosition($val="sticky-top") {
    // fixed-bottom fixed-top sticky-top
    $this->fixedPos = $val;
}
public function setRootMenu($val) {
    $this->rootMenu = $val;
}
public function setNavBarCss($val) {
    $this->navbarClasses = $val;
}
public function setBrandIcon($val) {
    $this->brandicon = $val;
}
public function genMenus() {
    $strmbar = $this->genMenuBar();
    $mnuroot = $this->sphp_api->getMenuList("root");
    // generate bootstrap 4 menu
    $str1 = "";
    foreach ($mnuroot as $mnuName => $lstMenu) {
            $str1 .= $this->genMenu($lstMenu);            
    }
    $this->htmlout = $strmbar[0] . $str1 . $strmbar[1];
}
private function genMenu($lstMenu,$submenu=0){
    $mnuroot = $this->sphp_api->getMenuList($lstMenu[0]);
    $stra = array();
    $str = "";
    $str1 = "";
    if($mnuroot != null){
        foreach ($mnuroot as $mnuName => $lstMenu2) {
            $str .= $this->genMenu($lstMenu2,1);
        }
        $str1 = $this->genMenuLinks($this->sphp_api->getMenuLinkList($lstMenu[0]));
        if($str1 != ""){
            $stra = $this->getB4Menu($lstMenu[0],$lstMenu[1],$lstMenu[2],$lstMenu[3],$submenu);  
        }else{
            $stra = $this->getB4Menu($lstMenu[0],$lstMenu[1],$lstMenu[2],$lstMenu[3],$submenu);              
        }
        return $stra[0] . $str . $str1 . $stra[1];
            
    }else{
        $str = $this->genMenuLinks($this->sphp_api->getMenuLinkList($lstMenu[0]));
        if($str != ""){
            $stra = $this->getB4Menu($lstMenu[0],$lstMenu[1],$lstMenu[2],$lstMenu[3],$submenu);  
        }else{
            $stra = $this->getB4Menu($lstMenu[0],$lstMenu[1],$lstMenu[2],$lstMenu[3],2);              
        }
        return $stra[0] . $str . $stra[1];
    }
    
}
private function genMenuLinks($mnuroot){
    $str = "";
    if($mnuroot != null){
        foreach ($mnuroot as $mnuLinkName => $lstMenuLink) {
            $str .= $this->getB4MenuLink($lstMenuLink[0],$lstMenuLink[1],$lstMenuLink[2],$lstMenuLink[3]); 
        }
    }
    return $str;
}
private function setAjax(){
$this->blnAjaxLink = true;
SphpBase::JSServer()->getAJAX();
addHeaderJSFunction('menu_ajax', "function menu_ajax(url){
", " getURL(url); }");
}
private function getB4Menu($mnutext,$mnuhref="",$mnuicon,$blnAjaxLink2=false,$mnuSub=0){
$mnutitle = $mnutext;
if($mnuhref==''){
    $mnuhref = "#";
}else if($blnAjaxLink2){
    if(!$this->blnAjaxLink){
        $this->setAjax();
    }
    $mnuhref = "javascript: menu_ajax('$mnuhref');";
}
$mnuhref2 = 'd'. $this->counter1;
$this->counter1 += 1;
$stro = array();
// if menu under root and dropdown
if($mnuSub==0){
    if(SphpJsM::getJSLibVersion("bootstrap") == 5){ 
        $stro[0] = '<li class="nav-item nav-dli"><a class="nav-link nav-dlink text-truncate" data-bs-toggle="collapse" data-target="#'. $mnuhref2 .'" href="#'.$mnuhref2.'" >' . 
        '<i class="'. $mnuicon .'"></i> <span class="d-none d-sm-inline">' . $mnutitle.'</span></a>'
        . '<div id="'. $mnuhref2 .'" aria-expanded="true"><ul class="flex-column pl-2 nav">';
    }else{
        $stro[0] = '<li class="nav-item nav-dli"><a class="nav-link nav-dlink text-truncate" data-toggle="collapse" data-target="#'. $mnuhref2 .'" href="#'.$mnuhref2.'" >' . 
        '<i class="'. $mnuicon .'"></i> <span class="d-none d-sm-inline">' . $mnutitle.'</span></a>'
        . '<div id="'. $mnuhref2 .'" aria-expanded="true"><ul class="flex-column pl-2 nav">';
    }
$stro[1] = '</ul></div></li>';
}else if($mnuSub==1){ // if sub menu and dropdown
    if(SphpJsM::getJSLibVersion("bootstrap") == 5){ 
$stro[0] = '<li class="nav-item nav-dli"><a class="nav-link nav-dlink collapsed text-truncate" data-bs-toggle="collapse" data-target="#'. $mnuhref2 .'" href="#'.$mnuhref2.'" >' . 
'<i class="'. $mnuicon .'"></i> <span class="d-none d-sm-inline">' . $mnutitle.'</span></a>'
. '<div class="collapse" id="'. $mnuhref2 .'" aria-expanded="false"><ul class="flex-column pl-2 nav">';
    }else{
$stro[0] = '<li class="nav-item nav-dli"><a class="nav-link nav-dlink collapsed text-truncate" data-toggle="collapse" data-target="#'. $mnuhref2 .'" href="#'.$mnuhref2.'" >' . 
'<i class="'. $mnuicon .'"></i> <span class="d-none d-sm-inline">' . $mnutitle.'</span></a>'
. '<div class="collapse" id="'. $mnuhref2 .'" aria-expanded="false"><ul class="flex-column pl-2 nav">';
        
    }
$stro[1] = '</ul></div></li>';
}else{ // if menu with no links and no sub menu without dropdown
$stro[0] = '<li class="nav-item"><a class="nav-link text-truncate" data-mkey="'. $this->mkey .'" href="'.$mnuhref.'"><i class="'. $mnuicon .'"></i> <span class="d-none d-sm-inline">'.$mnutitle.'</span></a>'; 
$stro[1] = '</li>';    
}
return $stro;
}
private function getB4MenuLink($mnuitemtext,$mnuitemhref="",$mnuicon,$blnAjaxLink2=false){
$mnuitemtitle = $mnuitemtext;
$mnuitemtext = $mnuitemtext . $this->mkeychar;
$tfun = "menu_ajax";
if($mnuitemhref==''){
    $mnuitemhref = "#";
}else if($blnAjaxLink2){
    $mnuitemhref = "javascript: $tfun('$mnuitemhref');";
}
return '<li class="nav-item"><a class="nav-link nav-dli text-truncate" data-mkey="'. $this->mkey .'" href="'.$mnuitemhref.'"><i class="'. $mnuicon .'"></i> <span class="d-none d-sm-inline">'.$mnuitemtext.'</span></a></li>';
}
public function genMenuBar() {
if($this->brandicon != ""){
$this->brandicon = '  <!-- Brand -->
<div><a class="" href="#"><img class="img img-fluid img-circle" src="'. $this->brandicon .'" alt="Logo"></a></div>';
}
$bootstrapMenu = $this->brandicon . '<div class="snavbar"><ul class="'. $this->navbarClasses .'">';
return array($bootstrapMenu,'</ul></div>');
}
private function setKey($key,$controlkeys="") {
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
    addHeaderJSFunction("jq_menukeyevent", "function jq_menukeyevent(eventer){", "}",true);
    addHeaderJSFunctionCode("jq_keyevent", "menukeyevent1", 'ret = jq_menukeyevent(eventer2);',true);
    addHeaderJSFunctionCode("jq_menukeyevent", $this->name, ' if('. $strkey .'eventer.keycode=='. $this->mkey .'){
        if(eventer.evt==\'keyup\'){
            $(".dropdown-item[data-mkey='.$this->mkey.']")[0].click();
            return false;
        }
    } 
',true);
    //console.log(eventer.keycode);
  //console.log(eventer.event.shiftKey);
  //console.log(eventer.event.ctrlKey);
  //console.log(eventer.event.altKey);
}

private function init() {
        addHeaderJSFunctionCode("ready", "snavbar1", '
    var links = jql(\'.snavbar a\');
    jql.each(links, function (key, va) {
        if (va.href == document.URL) {
            jql(this).addClass(\'active\');
            var pa = jql(this).parents(\'li.nav-dli\');
            jql.each(pa, function (key2, va2) {
                jql(va2).children("a.nav-dlink:first").addClass(\'active\');
            });
        }
    });
',true);
        /*
    addHeaderCSS("snavbar2", '     .nav-link[data-toggle].collapsed:before {
    content: " ▾";
}
.nav-link[data-toggle]:not(.collapsed):before {
    content: " ▴";
}

', true);
         * 
         */

}

}
