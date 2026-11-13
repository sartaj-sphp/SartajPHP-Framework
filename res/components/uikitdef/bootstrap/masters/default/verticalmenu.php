<?php 
include_once(SphpBase::sphpSettings()->slibPath . "/comp/bs/bundle/menu/BootstrapSideMenu.php"); 
class MenuUiSide extends BootstrapSideMenu{
    public function onstart() {
        //$this->sphpApi->banMenuLink("Logout","Home");
        $this->setRootMenu("sidebar");
        include_once($this->frontfiledir . "/menu.php"); 
    }
}
