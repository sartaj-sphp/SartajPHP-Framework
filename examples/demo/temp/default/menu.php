<?php 
include_once($slibpath . "/comp/bundle/menu/BootstrapMenu.php"); 
class MenuUi extends BootstrapMenu{
    public function onstart() {
        //$this->setNavBarCss("navbar sticky-top navbar-expand-md bg-dark navbar-dark");
        $this->sphp_api->addMenu("Home", "","fa fa-home","root");
        $this->sphp_api->addMenuLink("Home", getAppPath("index"),"fa fa-home","Home");
        $this->sphp_api->addMenuLink("Admin Login", getAppPath("admin"),"fa fa-home","Home");
        $this->sphp_api->addMenuLink("User Login", getAppPath("signin"),"fa fa-home","Home");
        $this->sphp_api->addMenuLink("Contact Us", getEventPath('page','contacts','index'),"fa fa-fw fa-clock-o","Home");
        include_once("plugin/cmenu.php"); 
        
    }
}
