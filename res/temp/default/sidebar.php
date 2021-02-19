<?php 
include_once($phppath . "controls/menu/BootstrapSideMenu.php"); 
class MenuUiSide extends BootstrapSideMenu{
    public function onstart() {
        //$this->sphp_api->banMenuLink("Logout","Home");
        $this->sphp_api->addMenu("Home","","fa fa-home");
        $this->sphp_api->addMenuLink("Home", getAppPath("index"),"fa fa-home","Home");
        $this->sphp_api->addMenuLink("Contact Us", getEventPath('page','contacts','index'),"fa fa-fw fa-clock-o","Home");
        include_once("plugin/cmenu.php"); 
    }
}
