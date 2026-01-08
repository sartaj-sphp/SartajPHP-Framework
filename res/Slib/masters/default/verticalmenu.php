<?php 
include_once(SphpBase::sphp_settings()->slib_path . "/comp/bundle/menu/BootstrapSideMenu.php"); 
class MenuUiSide extends BootstrapSideMenu{
    public function onstart() {
        //$this->sphp_api->banMenuLink("Logout","Home");
        $this->setRootMenu("sidebar");
        include_once($this->frontfiledir . "/menu.php"); 
    }
}
