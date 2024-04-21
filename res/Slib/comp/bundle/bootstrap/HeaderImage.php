<?php

class HeaderImage extends Control {

    public function onrender() {
        $this->tagName = 'section';
        $this->element->appendAttribute('class', 'hero');
        if(! $this->element->hasAttribute('src')) $this->src = SphpBase::sphp_settings()->slib_res_path . '/temp/default/assets/img/hero-bg.jpg';
        $this->element->setInnerPreTag('<img src="'. $this->src .'" data-aos="fade-in"  /><div class="container">');
        $this->element->setInnerPostTag('</div>');
        addHeaderCSS('headerimage', '.hero .container {
	position: relative;
	z-index: 3;
        color: #FFFFFF;
}
.hero {
  --default-color: #ffffff;
  --default-color-rgb: 255, 255, 255;
  --background-color-rgb: 0, 0, 0;
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
');
    }
}
