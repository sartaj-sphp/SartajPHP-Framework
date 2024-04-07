<?php
//permissions system is not implemented, only menu ban works
class BootstrapFooterMenu extends \Sphp\tools\MenuGen{
private $navmenuClasses = "nav col-md-4 justify-content-end";
private $navmenuitemClasses = "nav-link px-2 text-body-secondary";
private $fixedPos = "";
private $rootMenu = "root";
private $blnAjaxLink = false;
private $bootstrapversion = 5; // set bootstrap version

public function onrun() {

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
public function getRootMenu() {
    return $this->rootMenu;
}
public function setNavMenuCss($val) {
    $this->navmenuClasses = $val;
}
public function setNavMenuItemCss($val) {
    $this->navmenuitemClasses = $val;
}

public function genMenus() {
    $strmbar = $this->genMenuBar();
    $mnuroot = $this->sphp_api->getMenuList($this->rootMenu);
    // generate bootstrap menu
    $str1 = "";
    foreach ($mnuroot as $mnuName => $lstMenu) {
        $str1 .= $this->genMenu($lstMenu);
    }
    $this->htmlout = $strmbar[0] . $str1 . $strmbar[1];
}
public function genMenu($lstMenu,$submenu=0){
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
        $str .= $this->getB4MenuLink($lstMenuLink);        
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
    /*
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
     * 
     */
return array('','');
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
return '<li class="nav-item"><a class="'. $this->navmenuitemClasses .'" data-mkey="'. $mkey .'" href="'.$mnuitemhref.'">'.$mnuitemtext.'</a></li>';
}
public function genMenuBar() {
    return array('<ul class="'. $this->navmenuClasses .'">','</ul>');
}


}
