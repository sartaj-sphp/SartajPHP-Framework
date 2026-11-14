<?php 
/* use bootstrap menu generater file provide by SartajPHP Framework */
include_once(SphpBase::sphpSettings()->uiKitPath . "/bundle/menu/BootstrapMenu.php"); 
/* Create Class name as same as file name */
class menu extends BootstrapMenu{
    public function onstart() {
        //$this->setNavBarCss("navbar sticky-top navbar-expand-md bg-dark navbar-dark");
        $this->sphpApi->addMenu("Home", "","fa fa-home","root");
        $this->sphpApi->addMenuLink("Home", SphpBase::sphpSettings()->projectUrl,"fa fa-home","Home");
        $this->sphpApi->addMenuLink("Contact Us", getEventUrl('page','contacts','index2'),"fa fa-fw fa-clock-o","Home");
        if(SphpBase::page()->getAuthenticateType() == "GUEST"){
            $this->sphpApi->addMenuLink("Login", getGateUrl("signin"),"","Home");
        }else{
            // set menu permissions or login type, as comma separated value
            // not work if app is not using permission system like extend as PermisApp
            $this->sphpApi->addMenu("User",'',"fa fa-home","root",false,"ADMIN,MEMBER");
            $this->sphpApi->addMenuLink("Users",getGateUrl('mebProfile'),"fa fa-users","User",false,"mebProfile-view");
            $this->sphpApi->addMenuLink("Profile Permission",getGateUrl('mebProfilePermission'),"fa fa-users","User",false,"mebProfilePermission-view");
           // $this->sphpApi->addMenuLink("Profile Permission",getGateUrl('mebProfilePermission'),"fa fa-users","User",false,"MEMBER");

            $this->sphpApi->addMenu("Tools",'',"","root",false,"ADMIN");
            $this->sphpApi->addMenuLink("Plugin Install",getGateUrl('installer'),"fa fa-users","Tools");
            $this->sphpApi->addMenuLink("DB Install",getEventUrl('install','install','mebhome'),"fa fa-users","Tools");
            
            $this->sphpApi->addMenuLink("Dashboard",getGateUrl('mebhome'),"fa fa-home","Home");
            $this->sphpApi->addMenuLink("Logout", getEventUrl("logout","","signin"),"","Home");
            include_once(PROJ_PATH . "/plugin/cmenu.php"); 
            include_once(PROJ_PATH . "/plugin/cmebmenu.php"); 
            include_once(PROJ_PATH . "/plugin/cadmmenu.php"); 
        }
    }
    
    public function getHeaderSubMenu() {
        return '<div class="dropdown text-end">
          <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="'. SphpBase::sphpSettings()->uiKitUrl . "/masters/default/imgs/android-icon-192x192.png" .'" alt="mdo" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small">
            <li><a class="dropdown-item" href="#">getHeaderSubMenu from menu file</a></li>
            <li><a class="dropdown-item" href="#">for override this</a></li>
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Sign out</a></li>
          </ul>
        </div>';
    }
}