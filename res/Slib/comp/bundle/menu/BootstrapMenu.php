<?php
// disable bootstrap 4
//SphpJsM::$jslib["bootstrap"] = 5;
//permissions system is also implemented, menu ban works
class BootstrapMenu extends \Sphp\tools\MenuGen{
private $brandicon = "";
private $navbarClasses = "navbar navbar-expand-md bg-dark navbar-dark";
private $navmenuClasses = "navbar-nav";
private $navbar = true;
private $fixedPos = "";
private $rootMenu = "root";
private $blnAjaxLink = false;
private $bootstrapversion = 5; // set bootstrap version
public $tempfiledir = "";

public function __construct($filedir="") {
    if($filedir == "") $filedir = getcwd();
    $this->tempfiledir = $filedir;
    parent::__construct();
}

public function onrun() {
    $this->init();
    $this->genMenus();
}
public function setPosition($val="sticky-top") {
    // fixed-bottom fixed-top sticky-top
    $this->fixedPos = $val;
}
public function setBootstrapVersion($val) {
    $this->bootstrapversion = $val;
}
public function setRootMenu($val) {
    $this->rootMenu = $val;
}
public function setNavBarCss($val) {
    $this->navbarClasses = $val;
}
public function disableNavBar() {
    $this->navbar = false;
}
public function setNavMenuCss($val) {
    $this->navmenuClasses = $val;
}
public function setBrandIcon($val) {
    $this->brandicon = $val;
}

public function genMenus() {
    $strmbar = $this->genMenuBar();
    $mnuroot = $this->sphp_api->getMenuList($this->rootMenu);
    // generate bootstrap menu
    $str1 = "";
    foreach ($mnuroot as $mnuName => $lstMenu) {
        if($lstMenu[4] == ""){
            $str1 .= $this->genMenu($lstMenu);            
        }else if(SphpBase::sphp_permissions()->isPermission($lstMenu[4])){
            $str1 .= $this->genMenu($lstMenu);
        }
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
            if($lstMenu2[4] == ""){
                $str .= $this->genMenu($lstMenu2,1);
            }else if(SphpBase::sphp_permissions()->isPermission($lstMenu2[4])){
                $str .= $this->genMenu($lstMenu2,1);
            }
        }
        $str1 = $this->genMenuLinks($this->sphp_api->getMenuLinkList($lstMenu[0]));
        if($str1 != ""){
            $stra = $this->getB4Menu($lstMenu[0],$lstMenu[1],$lstMenu[3],$submenu);  
        }else{
            $stra = $this->getB4Menu($lstMenu[0],$lstMenu[1],$lstMenu[3],$submenu);              
        }
        return $stra[0] . $str . $str1 . $stra[1];
            
    }else{
        $str = $this->genMenuLinks($this->sphp_api->getMenuLinkList($lstMenu[0]));
        if($str != ""){
            $stra = $this->getB4Menu($lstMenu[0],$lstMenu[1],$lstMenu[3],$submenu);  
        }else{
            $stra = $this->getB4Menu($lstMenu[0],$lstMenu[1],$lstMenu[3],2);              
        }
        return $stra[0] . $str . $stra[1];
    }
    
}
private function genMenuLinks($mnuroot){
    $str = "";
    if($mnuroot != null){
    foreach ($mnuroot as $mnuLinkName => $lstMenuLink) {
        if($lstMenuLink[4] == ""){
            $str .= $this->getB4MenuLink($lstMenuLink);   
        }else if(SphpBase::sphp_permissions()->isPermission($lstMenuLink[4])){
            $str .= $this->getB4MenuLink($lstMenuLink);   
        }
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
private function getB4Menu($mnutext,$mnuhref="",$blnAjaxLink2=false,$mnuSub=0){
$mnutitle = $mnutext;
if($mnuhref==''){
    $mnuhref = "#";
}else if($blnAjaxLink2){
    if(!$this->blnAjaxLink){
        $this->setAjax();
    }
    $mnuhref = "javascript: menu_ajax('$mnuhref');";
}
$stro = array();
if($mnuSub==0){
    if($this->bootstrapversion == 5){
        $stro[0] = '<li class="nav-item dropdown nav-dli"><a class="nav-link dropdown-toggle nav-dlink" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="'.$mnuhref.'" >'.$mnutitle.'</a><ul class="dropdown-menu">';
    }else{
        $stro[0] = '<li class="nav-item dropdown nav-dli"><a class="nav-link dropdown-toggle nav-dlink" data-toggle="dropdown" href="'.$mnuhref.'" >'.$mnutitle.'</a><ul class="dropdown-menu">';
    }
$stro[1] = '</ul></li>';
}else if($mnuSub==1){
    if($this->bootstrapversion == 5){
        $stro[0] = '<li class="dropdown-submenu nav-dli"><a class="dropdown-item dropdown-toggle nav-dlink2" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="'.$mnuhref.'" >'.$mnutitle.'</a><ul class="dropdown-menu">';    
    }else{
        $stro[0] = '<li class="dropdown-submenu nav-dli"><a class="dropdown-item dropdown-toggle nav-dlink2" data-toggle="dropdown" href="'.$mnuhref.'" >'.$mnutitle.'</a><ul class="dropdown-menu">';    
    }
$stro[1] = '</ul></li>';
}else{
$stro[0] = '<li class="nav-item"><a class="nav-link" href="'.$mnuhref.'" >'.$mnutitle.'</a>';    
$stro[1] = '</li>';    
}
return $stro;
}
private function getB4MenuLink($lstMenuLink){
$mnuitemtext = $lstMenuLink[0];
$mnuitemhref = $lstMenuLink[1];
$blnAjaxLink2 = $lstMenuLink[3];
$mkey = "";
$mkeychar = "";
if($lstMenuLink[5] !== ""){
    $mkeya = $this->setKey($mnuitemtext,$lstMenuLink[5]);
    $mkey = $mkeya[1];
    $mkeychar = $mkeya[0];
}
$mnuitemtext = $mnuitemtext . $mkeychar;
$tfun = "menu_ajax";
if($mnuitemhref==''){
    $mnuitemhref = "#";
}else if($blnAjaxLink2){
    if(!$this->blnAjaxLink){
        $this->setAjax();
    }
    if(strpos($mnuitemhref,"avascript:")<1){
        $mnuitemhref = "javascript: $tfun('$mnuitemhref');";
    }
}
return '<li><a class="dropdown-item" data-mkey="'. $mkey .'" href="'.$mnuitemhref.'">'.$mnuitemtext.'</a></li>';
}
public function genMenuBar() {
if($this->brandicon != ""){
$this->brandicon = '  <!-- Brand -->
  <a class="navbar-brand" href="#"><img src="'. $this->brandicon .'" alt="Logo" style="width:40px;"></a>
';
}
    if($this->bootstrapversion == 5){
        if($this->navbar){
$bootstrapMenu = '<nav class="'. $this->navbarClasses . ' ' . $this->fixedPos .'"><div class="container-fluid"> '. $this->brandicon .'
  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav1" aria-controls="nav1" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="nav1">
  <ul class="'. $this->navmenuClasses .'">
';
return array($bootstrapMenu,'</ul></div></div></nav>');
        }else{
return array('<ul class="'. $this->navmenuClasses .'">','</ul>');
            
        }
    }else{
$bootstrapMenu = '<nav class="'. $this->navbarClasses . ' ' . $this->fixedPos .'"> '. $this->brandicon .'
  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav1">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="nav1">
  <ul class="'. $this->navmenuClasses .'">
';
return array($bootstrapMenu,'</div></nav>');
    }
}
private function setKey($mnuname,$strkeyll) {
$controlkeys="";
$keya = explode(",",$strkeyll);
$key = $keya[0];
if(count($keya)>1) $controlkeys = $keya[1];
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
    $mkeychar = " ". strtoupper($controlkeys). $controlkeysp . $mkeychar;
    $mkey = $key;
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
    addHeaderJSFunctionCode("jq_menukeyevent", $mnuname, ' if('. $strkey .'eventer.keycode=='. $mkey .'){
        if(eventer.evt==\'keyup\'){
            $(".dropdown-item[data-mkey='.$mkey.']")[0].click();
        }
        return false;
    } 
',true);
    return array($mkeychar,$mkey);
    //console.log(eventer.keycode);
  //console.log(eventer.event.shiftKey);
  //console.log(eventer.event.ctrlKey);
  //console.log(eventer.event.altKey);
}

private function init() {
    $links = 'var links = $(\'.navbar ul li a\');'; 
    if($this->bootstrapversion == 5){ 
        $links = 'var links = $(\'.navbar div ul li a\');';
    }    
        addHeaderJSFunctionCode("ready", "navbar", '
 '. $links .'    
    $.each(links, function (key, va) {
        if (va.href == document.URL) {
            $(this).addClass(\'active\');
            var pa = $(this).parents(\'li.nav-dli\');
            $.each(pa, function (key2, va2) {
                $(va2).children("a.nav-dlink:first").addClass(\'active\');
            });
        }
    });
    $(\'.dropdown-menu a.dropdown-toggle\').on(\'click\', function(e) {
  if (!$(this).next().hasClass(\'show\')) {
    $(this).parents(\'.dropdown-menu\').first().find(\'.show\').removeClass("show"); 
  }
  var $subMenu = $(this).next(".dropdown-menu");
  $subMenu.toggleClass(\'show\');
  $(this).parents(\'li.nav-item.dropdown.show\').on(\'hidden.bs.dropdown\', function(e) {
    $(\'.dropdown-submenu .show\').removeClass("show");
  });
  return false;
});
//$(\'.nav-dlink\').click();
$.each($(\'.nav-dlink\'), function (key, va) {
    //va.click();
});
',true);
    addHeaderCSS("navbar", ' .dropdown-submenu {
  position: relative;
}

.dropdown-submenu a::after {
  transform: rotate(-90deg);
  position: absolute;
  right: 6px;
  top: .8em;
}

.dropdown-submenu .dropdown-menu {
  top: 0;
  left: 100%;
  margin-left: .1rem;
  margin-right: .1rem;
} ', true);

}

}
