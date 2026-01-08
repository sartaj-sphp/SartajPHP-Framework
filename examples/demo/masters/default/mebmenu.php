<?php 
include_once($slibpath . "/comp/bundle/menu/BootstrapMenu.php"); 
class MenuUi extends BootstrapMenu{
    public function onstart() {
        //$this->sphp_api->banMenuLink("Logout","Home");
        //$this->setPosition("fixed-top");
        $this->sphp_api->addMenu("Home");
        $this->sphp_api->addMenuLink("Home", getAppPath("mebhome"),"","Home");
        $this->sphp_api->addMenuLink("Logout", getEventPath("logout","","signin"),"","Home");
        include_once("plugin/cmebmenu.php"); 
    }
}
