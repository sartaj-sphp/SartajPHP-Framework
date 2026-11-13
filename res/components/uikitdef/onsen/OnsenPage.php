<?php
/**
 * Description of OnsenPage
 *
 * @author SARTAJ
 */

class OnsenPage extends \Sphp\Tools\Component{
    public static $navigator = false;
    
public function oncreate($element){
    $this->fu_setHtmlName("");
    $this->registerEventJs('init');
    $this->registerEventJs('destroy');
    $this->registerEventJs('show');
    $this->registerEventJs('hide');
}


public function onjsrender(){
    addFileLink(SphpBase::sphpSettings()->resourceUrl . '/jslib/onsen/css/onsenui.css',false,"","","onsen:4",[SphpBase::sphpSettings()->resourceUrl . '/jslib/onsen/css']);
    addFileLink(SphpBase::sphpSettings()->resourceUrl . '/jslib/onsen/css/onsen-css-components.min.css',false,"","","onsen:4",[SphpBase::sphpSettings()->resourceUrl . '/jslib/onsen/css']);
    addFileLink(SphpBase::sphpSettings()->resourceUrl . '/jslib/onsen/js/onsenui.min.js');

    addHeaderJsCode('onsen0', ' window["onsen"] = {};');
    addHeaderJsFunction('comp_'. $this->name .'_init', 'function comp_'. $this->name .'_init(event) {', '}');
    addHeaderJsFunction('comp_'. $this->name .'_destroy', 'function comp_'. $this->name .'_destroy(event) {', '}');
    addHeaderJsFunction('comp_'. $this->name .'_show', 'function comp_'. $this->name .'_show(event) {', '}');
    addHeaderJsFunction('comp_'. $this->name .'_hide', 'function comp_'. $this->name .'_hide(event) {', '}');

    addHeaderJsFunction('init', 'document.addEventListener("init", function(event) {bindJsVarRefresh();', '});');
    addHeaderJsFunction('destroy', 'document.addEventListener("destroy", function(event) {', '});');
    addHeaderJsFunction('show', 'document.addEventListener("show", function(event) {', '});');
    addHeaderJsFunction('hide', 'document.addEventListener("hide", function(event) {', '});');
    
    addHeaderJsFunctionCode('init',$this->name . '1', 'if(event.target.id == "'. $this->name.'"){ '. $this->raiseEventJs('init') .'; } ');
    addHeaderJsFunctionCode('destroy',$this->name . '2', 'if(event.target.id == "'. $this->name.'"){ '. $this->raiseEventJs('destroy') .'; } ');
    addHeaderJsFunctionCode('show',$this->name . '3', 'if(event.target.id == "'. $this->name.'"){ '. $this->raiseEventJs('show') .'; } ');
    addHeaderJsFunctionCode('hide',$this->name . '4', 'if(event.target.id == "'. $this->name.'"){ '. $this->raiseEventJs('hide') .'; } ');
}

public function onrender() {
    $str1 = "";
    if(! OnsenPage::$navigator){
        addHeaderJsFunctionCode('ready','onsen1', ' const onsennavi = document.querySelector(\'#onsennavi\');');
        addHeaderJsCode('onsen3', ' window.onsen.loadPage = function(page,data){onsennavi.bringPageTop(page,data);}');
        $str1 = '<ons-navigator animation="slide" swipeable id="onsennavi" page="'. $this->name .'.html"></ons-navigator>';
        OnsenPage::$navigator = true;
    }
    $str1 .= '<template id="'. $this->name .'.html">';
    $this->setPreTag($str1);
    $this->setPostTag('</template>');
}

}
