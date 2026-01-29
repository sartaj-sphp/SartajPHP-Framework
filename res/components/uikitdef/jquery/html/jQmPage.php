<?php
/**
 * Description of jQmPage
 *
 * @author SARTAJ
 */

class jQmPage extends Sphp\tools\Component{
    private $mcache = "true";
    public $header = false;
    public $footer = false;
    public $headerbar = "";
    public $footerbar = "";
    public $pagename = "";
    
protected function oncreate($element){
$this->setHTMLName("");
$this->setHTMLID("");
$this->frontobj->addMetaData("jQpage",$this);
$this->pagename = $this->name;
}

public function fu_setCache($param) {
    $this->mcache = $param;
}
public function fu_setHeader($param) {
    $this->header = true;
}
public function fu_setFooter($param) {
    $this->footer = true;
}

protected function onjsrender(){
    $this->class = "col";
    $this->setPreTag('<div data-dom-cache="'. $this->mcache .'" data-role="page" id="'. $this->name .'page" class="spage">' . $this->headerbar . ''
 . '<div id="'.  $this->name .'" role="main" data-role="content" class="ui-content" >
<div class="container-fluid">
 <div class="row">');

$this->setPostTag("</div></div></div>" . $this->footerbar . '</div>');    

}


}
