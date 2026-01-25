<?php 
include_once(SphpBase::sphp_settings()->slib_path . "/comp/bundle/menu/BootstrapSideMenu_permis.php"); 
//include_once(SphpBase::sphp_settings()->slib_path . "/comp/bundle/menu/BootstrapMenu.php"); 
//class MenuUi extends BootstrapMenu{
class MenuUi extends BootstrapSideMenu{
    public function onstart() {
        //$this->setNavBarCss("navbar sticky-top navbar-expand-md bg-dark navbar-dark");
        $this->sphp_api->addMenu("Home", "","fa fa-home","root");
        $this->sphp_api->addMenuLink("Home", SphpBase::sphp_settings()->base_path,"fa fa-home","Home");
        $this->sphp_api->addMenuLink("Contact Us", getEventURL('page','contacts','index'),"fa fa-fw fa-clock-o","Home");
        if(SphpBase::page()->getAuthenticateType() == "GUEST"){
            $this->sphp_api->addMenuLink("Login", getAppURL("signin"),"","Home");
            include_once("plugin/cmenu.php"); 
            include_once(PROJ_PATH . "/masters/permis/menu.php");
        }else{
            // set menu permissions or login type, as comma separated value
            // not work if app is not using permission system like extend as PermisApp
            $this->sphp_api->addMenu("User",'',"fa fa-home","root",false,"ADMIN,MEMBER");
            $this->sphp_api->addMenuLink("Users",getAppURL('mebProfile'),"fa fa-users","User",false,"mebProfile-view");
            $this->sphp_api->addMenuLink("Profile Permission",getAppURL('mebProfilePermission'),"fa fa-users","User",false,"mebProfilePermission-view");
           // $this->sphp_api->addMenuLink("Profile Permission",getAppURL('mebProfilePermission'),"fa fa-users","User",false,"MEMBER");

            $this->sphp_api->addMenu("Tools",'',"","root",false,"ADMIN");
            $this->sphp_api->addMenuLink("DB Install",getEventURL('install','','mebhome'),"","Tools");
            $this->sphp_api->addMenuLink("Plugin Install",getAppURL('installer'),"fa fa-users","Tools");
            
            $this->sphp_api->addMenuLink("Dashboard",getAppURL('mebhome'),"fa fa-home","Home");
            $this->sphp_api->addMenuLink("Logout", getEventURL("logout","","signin"),"","Home");


            include_once("plugin/cmenu.php"); 
            include_once("plugin/cmebmenu.php"); 
            include_once("plugin/cadmmenu.php"); 
            include_once(PROJ_PATH . "/masters/permis/mebmenu.php");
        
    }
    }
    
}
