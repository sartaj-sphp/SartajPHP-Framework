<?php
/**
 * Description of jQmPage
 *
 * @author SARTAJ
 */

class jQmPage extends Control{
    private $mcache = "true";
    public $header = false;
    public $footer = false;
    public $headerbar = "";
    public $footerbar = "";
    public $pagename = "";
    
public function oncreate($element){
$this->setHTMLName("");
$this->setHTMLID("");
$this->tempobj->addMetaData("jQpage",$this);
$this->pagename = $this->name;
}

public function setCache($param) {
    $this->mcache = $param;
}
public function setHeader($param) {
    $this->header = true;
}
public function setFooter($param) {
    $this->footer = true;
}

public function onjsrender(){
    $this->class = "col";
    $this->setPreTag('<div data-dom-cache="'. $this->mcache .'" data-role="page" id="'. $this->name .'page" class="spage">' . $this->headerbar . ''
 . '<div id="'.  $this->name .'" role="main" data-role="content" class="ui-content" >
<div class="container-fluid">
 <div class="row">');

$this->setPostTag("</div></div></div>" . $this->footerbar . '</div>');    

}


}
