<?php
/**
 * Description of ContentBox
 *
 * @author SARTAJ
 */


class ContentBox extends Sphp\tools\Component{

protected function oncreate($element){
$this->setHTMLName("");
}


protected function onjsrender(){
global $jquerypath;
//addFileLink('$jquerypath/themes/base/jquery.ui.all.css');
    if($this->parameterA['class'] == ''){
$this->parameterA['class'] = 'ui-widget-content ui-corner-all';
}

}


}
?>