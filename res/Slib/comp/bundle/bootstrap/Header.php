<?php

class Header extends Control {
    private $menufile = null;
    private $text = "";
    private $icon = "";
    private $fullsize = false;
    private $fixed = false;

    public function setText($val) {
        $this->text = $val;
    }
    public function setFullSize() {
        $this->fullsize = true;
    }
    public function setIcon($val) {
        $this->icon = $val;
    }
    public function setFixed() {
        $this->fixed = true;
    }
    public function setMenuFile($menupath) {
        $this->menufile = $menupath;
    }
    private function getMenu($callback) {
        $menuo = "";
        if($this->menufile != null){
            include_once($this->menufile);
            $menu = new MenuUi();
            $callback($menu);
            $menu->run();
            $menuo = $menu->render();
        }
        return $menuo;
    }
    public function onrender() {
        global $cmpname;
        if($this->text == "")  $this->text = $cmpname;
        if($this->icon == "") $this->icon = SphpBase::sphp_settings()->slib_res_path . "/temp/default/imgs/android-icon-192x192.png";
        
        $this->setTagName("header");

        
        switch($this->styler){
            default:{
                $df1 = "d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom";
                if(! $this->fullsize){
                        $this->setPreTag('<div class="container" >');
                        $this->setPostTag('</div>');
                }else{
                    $df1 = "d-flex flex-wrap justify-content-center px-3 py-3 mb-4 border-bottom";
                }
                    $this->setAttributeDefault("class",$df1 );
                $menuo = $this->getMenu(function($menu){
                    $menu->setNavBarCss('navbar navbar-expand-md');
                    $menu->setNavMenuCss('nav nav-pills');
                });
                $st = '<a href="'. getAppURL('index') .'" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none gap-3">
                <img src="'. $this->icon .'" class="img img-fluid" width="40"  />
                <span class="fs-4">'. $this->text .'</span>
              </a>'. $menuo ;        
              break;
            }case 1:{
                if(! $this->fullsize){
                        $this->setPreTag('<div class="container" >');
                        $this->setPostTag('</div>');
                }
                $menuo = $this->getMenu(function($menu){
                    $menu->setNavBarCss('navbar navbar-expand-md');
                    $menu->setNavMenuCss('nav nav-pills');
                });
                $this->setAttributeDefault("class", "d-flex justify-content-left py-3 px-3 border-bottom mb-3");
                $st = $menuo ;        
              break;
            }case 2:{
                $df1 = "d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom";
                if(! $this->fullsize){
                        $this->setPreTag('<div class="container" >');
                        $this->setPostTag('</div>');
                }else{
                    $df1 = "d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom px-3";
                }
                    $this->setAttributeDefault("class",$df1 );
                $menuo = $this->getMenu(function($menu){
                    $menu->setNavBarCss('navbar navbar-expand-md');
                    $menu->setNavMenuCss('nav nav-pills');
                });
                $st = '<div class="col-md-3 mb-2 mb-md-0">
        <a href="/" class="d-inline-flex link-body-emphasis text-decoration-none">
                <img src="'. $this->icon .'" class="img img-fluid" width="40"  />
        </a>
      </div>
'. $menuo .'
      <div class="col-md-3 text-end">
        <button id="btnlogin" type="button" class="btn btn-outline-primary me-2">Login</button>
        <button id="btnsignin" type="button" class="btn btn-primary">Sign-up</button>
      </div>';        
                addHeaderJSFunctionCode("ready", "header1", '$("#btnlogin").on("click",function(){getURL("index-login.html");});'
                        . '$("#btnsignin").on("click",function(){getURL("index-signin.html");});');
              break;
            }case 3:{
                $menuo = $this->getMenu(function($menu){
                    $menu->disableNavBar();
                    $menu->setNavMenuCss('nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0  text-white');
                });
                $this->setAttributeDefault("class", "p-3 text-bg-dark");
                $st = '
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
           <img src="'. $this->icon .'" class="img img-fluid" width="40"  />
        </a>
'. $menuo .'
        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search" id="frmsearch" action="'. getEventURL('search','','index').'" method="post" enctype="mutipart/form-data">
          <input id="txtsearch" name="txtsearch" type="search" class="form-control form-control-dark text-bg-dark" placeholder="Search..." aria-label="Search">
        </form>

        <div class="text-end">
        <button id="btnlogin" type="button" class="btn btn-outline-light me-2">Login</button>
        <button id="btnsignin" type="button" class="btn btn-warning">Sign-up</button>
        </div>
      </div>
    </div>';        
                addHeaderJSFunctionCode("ready", "header1", '$("#btnlogin").on("click",function(){getURL("index-login.html");});'
                        . '$("#btnsignin").on("click",function(){getURL("index-signin.html");});');
              break;
            
            }case 4:{
                 $menusub = '';
                $menuo = $this->getMenu(function($menu) use (&$menusub){
                    $menu->disableNavBar();
                    $menu->setNavMenuCss('nav col-xs-auto me-lg-auto mb-2 justify-content-center mb-md-0');
                    $menusub = $menu->getHeaderSubMenu();
                });
                $this->setAttributeDefault("class", "p-3 mb-3 border-bottom");
                if( $menusub == ''){
                $menusub = '<div class="dropdown text-end ">
          <a href="#" class="d-block nav-dlink text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="'. SphpBase::sphp_settings()->slib_res_path . "/temp/default/imgs/android-icon-192x192.png" .'" alt="mdo" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small nav-dlink">
            <li><a class="dropdown-item" href="#">use setSubMenuFile as temp file</a></li>
            <li><a class="dropdown-item" href="#">for override this</a></li>
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Sign out</a></li>
          </ul>
        </div>
';
                }
                
                $st = '<div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-right justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
           <img src="'. $this->icon .'" class="img img-fluid" width="40"  />
        </a>
'. $menuo .'
        <form class="col-12 col-lg-auto  mb-3 mb-lg-0 me-lg-3 d-none d-lg-block" role="search" id="frmsearch" action="'. getEventURL('search','','index').'" method="post" enctype="mutipart/form-data">
          <input id="txtsearch" name="txtsearch" type="search" class="form-control" placeholder="Search..." aria-label="Search">
        </form>
'. $menusub .'        
      </div>
    </div>';        
                addHeaderJSFunctionCode("ready", "header1", '$("#btnlogin").on("click",function(){getURL("index-login.html");});'
                        . '$("#btnsignin").on("click",function(){getURL("index-signin.html");});');
              break;
            }case 5:{
                $menuo = $this->getMenu(function($menu){
                    $menu->disableNavBar();
                    $menu->setNavMenuCss('nav me-auto');
                });
                $this->setAttributeDefault("class", "py-3 mb-4 border-bottom");
                $st1 = '<nav class="py-2 bg-body-tertiary border-bottom">
    <div class="container d-flex flex-wrap">
'. $menuo .'
    
      <ul class="nav">
        <li class="nav-item"><a href="'. getEventURL('login','','index') .'" class="nav-link link-body-emphasis px-2">Login</a></li>
        <li class="nav-item"><a href="'. getEventURL('signup','','index') .'" class="nav-link link-body-emphasis px-2">Sign up</a></li>
      </ul>
    </div>
  </nav>'; 
                $this->setPreTag($st1);
                $st = '<div class="container d-flex flex-wrap justify-content-center">
      <a href="/" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto link-body-emphasis text-decoration-none gap-3">
                <img src="'. $this->icon .'" class="img img-fluid" width="40"  />
                <span class="fs-4">'. $this->text .'</span>
      </a>
        <form class="col-12 col-lg-auto mb-3 mb-lg-0" role="search" id="frmsearch" action="'. getEventURL('search','','index').'" method="post" enctype="mutipart/form-data">
          <input id="txtsearch" name="txtsearch" type="search" class="form-control" placeholder="Search..." aria-label="Search">
        </form>
    </div>';        
              break;
            }
            
            
        }
        
        
        $this->setInnerHTML($st);
        if($this->fixed){
            $this->element->appendAttribute('class', ' fixed-top');
            addHeaderJSFunctionCode('ready', 'header', '$(window).on("scroll",function(){'
                    . 'const threshold = $(document).scrollTop() > 50;
   $("#'. $this->name .'").toggleClass(\'scrolled\', threshold);});$(window).scroll();');
        }
      
    }
}
