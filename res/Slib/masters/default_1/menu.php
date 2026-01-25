<?php 
include_once(SphpBase::sphp_settings()->slib_path . "/comp/bundle/menu/BootstrapMenu.php"); 
class MenuUi extends BootstrapMenu{
    public function onstart() {
        //$this->setNavBarCss("navbar sticky-top navbar-expand-md bg-dark navbar-dark");
        $this->sphp_api->addMenu("Home", "","fa fa-home","root");
        $this->sphp_api->addMenuLink("Home", "/","fa fa-home","Home");
        $this->sphp_api->addMenuLink("Contact Us", getEventURL('page','contacts','index'),"fa fa-fw fa-clock-o","Home");
        include_once("plugin/cmenu.php"); 
    }
    
    public function getHeaderSubMenu() {
        return '<div class="dropdown text-end">
          <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="'. SphpBase::sphp_settings()->slib_res_path . "/masters/default/imgs/android-icon-192x192.png" .'" alt="mdo" width="32" height="32" class="rounded-circle">
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
