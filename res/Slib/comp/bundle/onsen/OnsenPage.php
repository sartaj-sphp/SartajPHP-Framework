<?php
/**
 * Description of OnsenPage
 *
 * @author SARTAJ
 */

class OnsenPage extends Control{
    public static $navigator = false;
    
public function oncreate($element){
    $this->setHTMLName("");
    $this->registerEventJS('init');
    $this->registerEventJS('destroy');
    $this->registerEventJS('show');
    $this->registerEventJS('hide');
}


public function onjsrender(){
    addFileLink(SphpBase::sphp_settings()->res_path . '/jslib/onsen/css/onsenui.css',false,"","","onsen:4",[SphpBase::sphp_settings()->res_path . '/jslib/onsen/css']);
    addFileLink(SphpBase::sphp_settings()->res_path . '/jslib/onsen/css/onsen-css-components.min.css',false,"","","onsen:4",[SphpBase::sphp_settings()->res_path . '/jslib/onsen/css']);
    addFileLink(SphpBase::sphp_settings()->res_path . '/jslib/onsen/js/onsenui.min.js');

    addHeaderJSCode('onsen0', ' window["onsen"] = {};');
    addHeaderJSFunction('comp_'. $this->name .'_init', 'function comp_'. $this->name .'_init(event) {', '}');
    addHeaderJSFunction('comp_'. $this->name .'_destroy', 'function comp_'. $this->name .'_destroy(event) {', '}');
    addHeaderJSFunction('comp_'. $this->name .'_show', 'function comp_'. $this->name .'_show(event) {', '}');
    addHeaderJSFunction('comp_'. $this->name .'_hide', 'function comp_'. $this->name .'_hide(event) {', '}');

    addHeaderJSFunction('init', 'document.addEventListener("init", function(event) {bindJsVarRefresh();', '});');
    addHeaderJSFunction('destroy', 'document.addEventListener("destroy", function(event) {', '});');
    addHeaderJSFunction('show', 'document.addEventListener("show", function(event) {', '});');
    addHeaderJSFunction('hide', 'document.addEventListener("hide", function(event) {', '});');
    
    addHeaderJSFunctionCode('init',$this->name . '1', 'if(event.target.id == "'. $this->name.'"){ '. $this->raiseEventJS('init') .'; } ');
    addHeaderJSFunctionCode('destroy',$this->name . '2', 'if(event.target.id == "'. $this->name.'"){ '. $this->raiseEventJS('destroy') .'; } ');
    addHeaderJSFunctionCode('show',$this->name . '3', 'if(event.target.id == "'. $this->name.'"){ '. $this->raiseEventJS('show') .'; } ');
    addHeaderJSFunctionCode('hide',$this->name . '4', 'if(event.target.id == "'. $this->name.'"){ '. $this->raiseEventJS('hide') .'; } ');
}

public function onrender() {
    $str1 = "";
    if(! OnsenPage::$navigator){
        addHeaderJSFunctionCode('ready','onsen1', ' const onsennavi = document.querySelector(\'#onsennavi\');');
        addHeaderJSCode('onsen3', ' window.onsen.loadPage = function(page,data){onsennavi.bringPageTop(page,data);}');
        $str1 = '<ons-navigator animation="slide" swipeable id="onsennavi" page="'. $this->name .'.html"></ons-navigator>';
        OnsenPage::$navigator = true;
    }
    $str1 .= '<template id="'. $this->name .'.html">';
    $this->setPreTag($str1);
    $this->setPostTag('</template>');
}

}
