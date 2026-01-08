<?php 
include_once($slibpath . "/comp/bundle/menu/BootstrapSideMenu.php"); 
class MenuUi extends BootstrapSideMenu{
    public function onstart() {
        //$this->sphp_api->banMenuLink("Logout","Home");
        //$this->setPosition("fixed-top");
        $this->sphp_api->addMenu("Home");
        $this->sphp_api->addMenuLink("Home", getAppURL("admhome"),"","Home");
        $this->sphp_api->addMenuLink("Plugin Home", getAppURL("installer"),"","Home");
        $this->sphp_api->addMenuLink("Logout", getEventURL("logout","","admin"),"","Home");
        include_once("plugin/cadmmenu.php"); 
    }
}
