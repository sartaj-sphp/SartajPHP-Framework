<?php
/**
 * Description of OnsenPage
 *
 * @author SARTAJ
 */

include_once(__DIR__ ."/OnsenPage.php");
OnsenPage::$navigator = true;

class SideMenu extends Control{
    
public function oncreate($element){
    $this->setHTMLName("");
    $this->setHTMLID("");
    //$this->registerEventJS('demo');
}


public function onjsrender(){
    addFileLink(SphpBase::sphp_settings()->res_path . '/jslib/onsen/onsen.css');
    addFileLink(SphpBase::sphp_settings()->res_path . '/jslib/onsen/onsen.js');

    addHeaderJSCode('onsen0', ' window["onsen"] = {};');
    addHeaderJSCode('onsen3', ' window.onsen.loadPage = function(page,data){ var content = document.getElementById(\''. $this->name.'content\');
  var menu = document.getElementById(\''. $this->name.'\');
  content.load(page).then(menu.close.bind(menu));
};');
    addHeaderJSCode('onsensidemenu2', ' window["'. $this->name .'"] = {}; window["'. $this->name .'"].open = function(){var menu = document.getElementById(\''. $this->name .'\');
  menu.open();};
');
}

public function onrender() {
    $str1 = "";
    $str1 .= '<template id="'. $this->name.'1"><ons-page>';
    $this->setPreTag($str1);
    $this->tagName = 'ons-list';
    $this->setPostTag(' </ons-page></template><ons-splitter>
  <ons-splitter-side id="'. $this->name.'" side="left" width="220px" collapse swipeable page="'. $this->name.'1">
  </ons-splitter-side>
  <ons-splitter-content id="'. $this->name.'content" page="home.html"></ons-splitter-content>
</ons-splitter>');
}

}
