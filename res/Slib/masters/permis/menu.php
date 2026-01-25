<?php 
include_once(SphpBase::sphp_settings()->slib_path . "/comp/bundle/menu/BootstrapMenu.php"); 
class MenuUi extends BootstrapMenu{
    public function onstart() {
        //$this->setNavBarCss("navbar sticky-top navbar-expand-md bg-dark navbar-dark");
        $this->sphp_api->addMenu("Home", "","fa fa-home","root");
        $this->sphp_api->addMenuLink("Home", SphpBase::sphp_settings()->base_path,"fa fa-home","Home");
        $this->sphp_api->addMenuLink("Contact Us", getEventURL('page','contacts','index'),"fa fa-fw fa-clock-o","Home");
        if(SphpBase::page()->getAuthenticateType() == "GUEST"){
            $this->sphp_api->addMenuLink("Login", getAppURL("signin"),"","Home");
            include_once("plugin/cmenu.php"); 
            include_once(PROJ_PATH . "/masters/permis/menu.php");
        }else{
            // set menu permissions or login type, as comma separated value
            // not work if app is not using permission system like extend as PermisApp
            $this->sphp_api->addMenu("User",'',"fa fa-home","root",false,"ADMIN,MEMBER");
            $this->sphp_api->addMenuLink("Users",getAppURL('mebProfile'),"fa fa-users","User",false,"mebProfile-view");
            $this->sphp_api->addMenuLink("Profile Permission",getAppURL('mebProfilePermission'),"fa fa-users","User",false,"mebProfilePermission-view");
           // $this->sphp_api->addMenuLink("Profile Permission",getAppURL('mebProfilePermission'),"fa fa-users","User",false,"MEMBER");

            $this->sphp_api->addMenu("Tools",'',"","root",false,"ADMIN");
            $this->sphp_api->addMenuLink("DB Install",getEventURL('install','','mebhome'),"","Tools");
            $this->sphp_api->addMenuLink("Plugin Install",getAppURL('installer'),"fa fa-users","Tools");
            
            $this->sphp_api->addMenuLink("Dashboard",getAppURL('mebhome'),"fa fa-home","Home");
            $this->sphp_api->addMenuLink("Logout", getEventURL("logout","","signin"),"","Home");


            include_once("plugin/cmenu.php"); 
            include_once("plugin/cmebmenu.php"); 
            include_once("plugin/cadmmenu.php"); 
            include_once(PROJ_PATH . "/masters/permis/mebmenu.php");
        }
    }
    
    public function getHeaderSubMenu() {
        return '<div class="dropdown text-end">
          <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="masters/designing/img/logo.png" alt="mdo" width="32" height="32" class="rounded-circle">
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
