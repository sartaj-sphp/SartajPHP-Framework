<?php 
include_once(SphpBase::sphp_settings()->slib_path . "/comp/bundle/menu/BootstrapFooterMenu.php"); 
class FooterMenuUi extends BootstrapFooterMenu{
    public function onstart() {
        //$this->setNavMenuCss("nav col-md-4 justify-content-end");
        // just remove to empty for use root menu as same as in header
        $this->setRootMenu("footer");
        $this->sphp_api->addMenu("Home2", "","fa fa-home","footer");
        $this->sphp_api->addMenu("Home", "","fa fa-home","Home2");
        $this->sphp_api->addMenuLink("Home", SphpBase::sphp_settings()->base_path,"fa fa-home","Home");
        $this->sphp_api->addMenuLink("Contact Us", getEventURL('page','contacts','index'),"fa fa-fw fa-clock-o","Home");
        
        if(SphpBase::page()->getAuthenticateType() == "GUEST"){
            $this->sphp_api->addMenuLink("Login", getAppURL("signin"),"","Home");
            include_once("plugin/cmenu.php"); 
        }else{            
            $this->sphp_api->addMenuLink("Dashboard",getAppPath('mebhome'),"fa fa-home","Home");
            $this->sphp_api->addMenuLink("Logout", getEventURL("logout","","signin"),"","Home");
            include_once("plugin/cmenu.php"); 
        }
         
        
        include_once("plugin/cmenu.php"); 
        
    }
}
