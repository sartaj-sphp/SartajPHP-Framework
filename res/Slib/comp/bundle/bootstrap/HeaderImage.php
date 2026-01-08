<?php

class HeaderImage extends \Sphp\tools\Component{
    private static $renderon = true;
        
    protected function onrender() {
        if(self::$renderon){
            self::$renderon = false;
        $this->tagName = 'section';
        $this->element->appendAttribute('class', 'hero');
        if(! $this->element->hasAttribute('src')) $this->src = SphpBase::sphp_settings()->slib_res_path . '/masters/default/assets/img/hero-bg.jpg';
        $this->element->setInnerPreTag('<img src="'. $this->src .'" data-aos="fade-in"  /><div class="container">');
        $this->element->setInnerPostTag('</div>');
        $strcs1 = "";
        if($this->styler == 1){
        $strcs1 = '.hero .container {
	position: relative;
	z-index: 3;
        color: #FFFFFF;
}
.hero {
  --default-color: #ffffff;
  --default-color-rgb: 255, 255, 255;
  --background-color-rgb: 0, 0, 0;
  --background-color: 0, 0, 0;
  width: 100%;
 min-height: 30vh;
  padding: 160px 0 80px 0;
  display: flex;
  align-items: center;
  justify-content: center;
}
.hero img {
	position: absolute;
	inset: 0;
	display: block;
	width: 100%;
	height: 30%;
	-o-object-fit: cover;
	object-fit: cover;
	z-index: 1;
}
.hero:before {
  content: "";
  background: rgba(var(--background-color-rgb), 0.5);
  position: absolute;
  inset: 0;
  z-index: 2;
  height: 30%;
}
section, .section {
	color: var(--default-color);
	background-color: var(--background-color);
	padding: 60px 0;
	overflow: clip;
}
';
            
        }else{
        $strcs1 = '.hero .container {
	position: relative;
	z-index: 3;
        color: #FFFFFF;
}
.hero {
  --default-color: #ffffff;
  --default-color-rgb: 255, 255, 255;
  --background-color-rgb: 0, 0, 0;
  --background-color: 0, 0, 0;
  width: 100%;
 min-height: 100vh;
  padding: 160px 0 80px 0;
  display: flex;
  align-items: center;
  justify-content: center;
}
.hero img {
	position: absolute;
	inset: 0;
	display: block;
	width: 100%;
	height: 100%;
	-o-object-fit: cover;
	object-fit: cover;
	z-index: 1;
}
.hero:before {
  content: "";
  background: rgba(var(--background-color-rgb), 0.5);
  position: absolute;
  inset: 0;
  z-index: 2;
}
section, .section {
	color: var(--default-color);
	background-color: var(--background-color);
	padding: 60px 0;
	overflow: clip;
}
';
        }
        addHeaderCSS('headerimage',$strcs1);
    }else{
        $this->unsetrender();
    }
    }
}
