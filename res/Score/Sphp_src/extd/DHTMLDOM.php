<?php
namespace Sphp\tools{

use Sphp\tools\DHTMLElement;

class DHTMLDOM {
    public $callback = null;
    public $doc = null;
    public $dhtmlparser = null;
    public $doctree = array();
    
    public function __construct($dhtmlparser) {
        $this->dhtmlparser = $dhtmlparser;
    }

    public function __destruct() {
        // not work in extension
        //$this->clear();
    }

    // load html from string
    public function load($str) {
        // prepare
        $this->init($str);
    }

    // load html from file
    public function load_file($filepath) {
        $this->load(file_get_contents($filepath), true);
    }
    public function load_file_str($filepath) {
        return (file_get_contents($filepath));
    }

    // set callback public function
    public function set_callback($function_name,$obj) {
        $this->callback = array($function_name,$obj);
    }
    public function setCallback($callbackm) {
        $this->callback = $callbackm;
    }
    public function getCallback() {
        return $this->callback;
    }

    // remove callback public function
    public function remove_callback() {
        $this->callback = null;
    }


    // prepare HTML data and init everything
    protected function init($str) {
        $this->doc = new \DOMDocument("1.0", 'UTF-8');
        $this->doc->preserveWhiteSpace = FALSE;
        $this->doc->formatOutput  = FALSE;
        $this->doc->encoding = "utf-8";
        $this->doc->strictErrorChecking = FALSE;
        $this->doc->validateOnParse = FALSE;
        $this->doc->xmlStandalone = FALSE;
        $this->doctree = array();
        $this->doc->registerNodeClass("DOMElement", __NAMESPACE__ . "\DHTMLElement");
        $str = str_replace("\"<?php", "\"#{", html_entity_decode($str, ENT_COMPAT, 'UTF-8'));
        $str = str_replace("?>\"", "}#\"", $str);
//        if($str!=""){
//        $this->doc->loadHTML($str, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_COMPACT);
//        $this->doc->loadHTML($str, LIBXML_HTML_NODEFDTD | LIBXML_COMPACT);
//        $this->doc->loadXML( $str );
        $this->doc->loadXML('<sphp> ' . $str . '</sphp>');
//        }
//        echo "<pre>";
//        $this->showDOMNode($this->doc);
    } 
    public function showDOMNode(\DOMNode $domNode,$sp="  ") {
        foreach ($domNode->childNodes as $node)
        {
            if(get_class($node)=="Sphp\\tools\\DHTMLElement"){
            print($sp . $node->tagName .'
<br />
');
            //print $sp . $node->nodeName.':' . $node->nodeValue. "<br>";
            if($node->hasChildNodes()) {
                $this->showDOMNode($node,$sp . "  ");
            }
            }
        }    
    }
    private function parseObjectLoop(\DOMNode $domNode,$parent=null) {
        $arr1 = array();
        foreach ($domNode->childNodes as $node)
        {
            if(get_class($node)=="Sphp\\tools\\DHTMLElement"){
                $arr2 = array();
                $arr2["node"] = $node;
                $this->dhtmlparser->setupcomp($node,$parent);
            //print $sp . $node->nodeName.':' . $node->nodeValue. "<br>";
                if($node->hasChildNodes()) {
                    if($node->getAttribute("runat") == "server"){
                        $arr2["children"] = $this->parseObjectLoop($node,$node);
                    }else{
                        $arr2["children"] = $this->parseObjectLoop($node,$parent);
                    }
                }
                $this->dhtmlparser->endupcomp($node,$parent);
                $arr1[] = $arr2;
            }
        }
        return $arr1;
    }
    public function parseobj() {
        $node = $this->parseObjectLoop($this->doc);
        $this->doctree = $node;
    }
    private function renderObjectLoop2(\DOMNode $domNode,$parent=null) {
        foreach ($domNode->childNodes as $node)
        {
            if(get_class($node)=="Sphp\\tools\\DHTMLElement"){
                $this->dhtmlparser->startrender($node,$parent);
            print  $node->nodeName.':' . "<br>";
                if($node->hasChildNodes()) {
                    if($node->getAttribute("runat") == "server"){
                        $this->renderObjectLoop($node,$node);
                    }else{
                        $this->renderObjectLoop($node,$parent);
                    }
                }
                $this->dhtmlparser->endrender($node,$parent);
            }
        }    
    }
    private function renderObjectLoop($domNode,$parent=null) {
        foreach ($domNode as $index=>$nodea)
        {
            $node = $nodea["node"];
            if(get_class($node)=="Sphp\\tools\\DHTMLElement"){
                $this->dhtmlparser->startrender($node,$parent);
//            print  $node->nodeName.':' . "<br>";
                if(isset($nodea["children"])) {
                    if($node->getAttribute("runat") == "server"){
                        $this->renderObjectLoop($nodea["children"],$node);
                    }else{
                        $this->renderObjectLoop($nodea["children"],$parent);
                    }
                }
                $this->dhtmlparser->endrender($node,$parent);
            }
        }    
    }
    public function renderobj() {
//        $this->renderObjectLoop($this->doc);
        $this->renderObjectLoop($this->doctree);
    }
    // parse html content
    public function parse() {
        if($this->callback!=null){
            $elements = $this->doc->getElementsByTagName('*');
    //        echo "<pre>";
            foreach($elements as $element)
            {
                $this->callbackfun($element);
    //            print_r($element);
    //              echo   "<br>";
            }
        }

    }
    
    private function callbackfun($element) {
        // call_user_func_array($this->dom->callback, array($this));
        // call_user_method_array($this->dom->callback[0],$this->dom->callback[1],array($this));
            $callback1 = $this->callback[1];
            $callback0 = $this->callback[0];
            $callback1->{$callback0}($element);
    }
    public function save() {
        //return $this->doc->saveHTML();
        return $this->doc->saveXML($this->doc->getElementsByTagName("sphp")->item(0)->firstChild);
    }

    public function __toString() {
//        return $this->doc->saveHTML();
        return $this->doc->saveXML($this->doc->getElementsByTagName("sphp")->item(0)->firstChild);
    }

}
}
