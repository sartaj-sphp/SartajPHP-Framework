<?php 
include_once(SphpBase::sphp_settings()->slib_path . "/comp/bundle/menu/BootstrapMenu.php"); 
class MenuUi extends BootstrapMenu{
    public function onstart() {
        //$this->setNavBarCss("navbar sticky-top navbar-expand-md bg-dark navbar-dark");
        $this->sphp_api->addMenu("Home", "","fa fa-home","root");
        $this->sphp_api->addMenuLink("Home", getAppURL("index"),"fa fa-home","Home");
        $this->sphp_api->addMenuLink("Contact Us", getEventURL('page','contacts','index'),"fa fa-fw fa-clock-o","Home");
        include_once("plugin/cmenu.php"); 
    }
}
