<?php 
include_once(SphpBase::sphp_settings()->slib_path . "/comp/bundle/menu/BootstrapFooterMenu.php"); 
class FooterMenuUi extends BootstrapFooterMenu{
    public function onstart() {
        //$this->setNavMenuCss("nav col-md-4 justify-content-end");
        // just remove to empty for use root menu as same as in header
        $this->setRootMenu("footer");
        $this->sphp_api->addMenu("Home2", "","fa fa-home","footer");
        $this->sphp_api->addMenu("Home", "","fa fa-home","footer");
        
        $this->sphp_api->addMenuLink("Home", getAppURL("index"),"fa fa-home","Home2");
        $this->sphp_api->addMenuLink("Admin Login", getAppURL("admin"),"fa fa-home","Home2");
        //$this->sphp_api->addMenuLink("User Login", getAppURL("signin"),"fa fa-home","Home2");
        $this->sphp_api->addMenuLink("Contact Us", getEventURL('page','contacts','index'),"fa fa-fw fa-clock-o","Home2");
         
        
        include_once("plugin/cmenu.php"); 
        
    }
}
