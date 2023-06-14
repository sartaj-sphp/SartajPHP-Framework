<?php 
include_once(SphpBase::sphp_settings()->slib_path . "/comp/bundle/menu/BootstrapSideMenu_permis5.php"); 
//include_once(SphpBase::sphp_settings()->slib_path . "/comp/bundle/menu/BootstrapMenu.php"); 
//class MenuUi extends BootstrapMenu{
class MenuUi extends BootstrapSideMenu{
    public function onstart() {
        //$this->setNavBarCss("navbar sticky-top navbar-expand-md bg-dark navbar-dark");
        SphpBase::sphp_api()->addMenu("Dashboard",getAppUrl('mebhome'),"fa fa-home");
        SphpBase::sphp_api()->addMenu("Users",getAppUrl('mebProfile'),"fa fa-users","root",false,"mebProfile-view");
        SphpBase::sphp_api()->addMenu("Profile Permission",getAppUrl('mebProfilePermission'),"fa fa-users","root",false,"mebProfilePermission-view");
        SphpBase::sphp_api()->addMenu("Install",getEventURL('install','','mebhome'),"fa fa-users","root",false,"mebhome-install");
        
        $this->sphp_api->addMenu("Home", "","fa fa-home","root");
        $this->sphp_api->addMenuLink("Contact",getEventURL("page","contact","index"),"fa fa-video-camera","Home",false,"");
        $this->sphp_api->addMenuLink("Logout", getEventURL("logout","","signin"),"fa fa-fw fa-clock-o","Home");


        include_once(PROJ_PATH . "/temp/permismenu.php");  
        include_once(PROJ_PATH . "/plugin/cmebmenu.php");  
        
    }
}
