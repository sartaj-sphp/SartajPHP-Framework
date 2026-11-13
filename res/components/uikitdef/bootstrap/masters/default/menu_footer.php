<?php 
include_once(SphpBase::sphpSettings()->uiKitPath . "/bundle/menu/BootstrapFooterMenu.php"); 
class FooterMenuUi extends BootstrapFooterMenu{
    public function onstart() {
        //$this->setNavMenuCss("nav col-md-4 justify-content-end");
        // just remove to empty for use root menu as same as in header
        $this->setRootMenu("footer");
        $this->sphpApi->addMenu("Home2", "","fa fa-home","footer");
        $this->sphpApi->addMenu("Home", "","fa fa-home","Home2");
        $this->sphpApi->addMenuLink("Home", SphpBase::sphpSettings()->projectUrl,"fa fa-home","Home");
        $this->sphpApi->addMenuLink("Contact Us", getEventUrl('page','contacts','index'),"fa fa-fw fa-clock-o","Home");
        
        if(SphpBase::page()->getAuthenticateType() == "GUEST"){
            $this->sphpApi->addMenuLink("Login", getGateUrl("signin"),"","Home");
            include_once("plugin/cmenu.php"); 
        }else{            
            $this->sphpApi->addMenuLink("Dashboard",getGateUrl('mebhome'),"fa fa-home","Home");
            $this->sphpApi->addMenuLink("Logout", getEventUrl("logout","","signin"),"","Home");
            include_once("plugin/cmenu.php"); 
        }
         
        
        include_once("plugin/cmenu.php"); 
        
    }
}
