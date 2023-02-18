<?php 
include_once($slibpath . "/comp/bundle/menu/BootstrapSideMenu.php"); 
class MenuUiSide extends BootstrapSideMenu{
    public function onstart() {
        //$this->sphp_api->banMenuLink("Logout","Home");
        $this->sphp_api->addMenu("Home","","fa fa-home");
        $this->sphp_api->addMenuLink("Home", getAppURL("index"),"fa fa-home","Home");
        $this->sphp_api->addMenuLink("Contact Us", getEventURL('page','contacts','index'),"fa fa-fw fa-clock-o","Home");
        include_once("plugin/cmenu.php"); 
    }
}
