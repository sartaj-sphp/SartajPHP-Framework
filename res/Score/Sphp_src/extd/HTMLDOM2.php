<?php
namespace Sphp\tools{

class HTMLDOM2 {
    public $root = null;
    public $doc = null;

    public function __construct() {
        $this->doc = new \DOMDocument("1.0", 'UTF-8');
        $this->doc->preserveWhiteSpace = true;
        $this->doc->formatOutput  = false;
        $this->doc->encoding = "utf-8";
        $this->doc->strictErrorChecking = false;
        $this->doc->validateOnParse = false;
        $this->doc->xmlStandalone = false;
        $this->doc->standalone = false;
        $this->doc->recover = true;
        $this->doc->registerNodeClass("DOMElement", __NAMESPACE__ . "\HTMLElement");
        $this->doc->registerNodeClass("DOMText", __NAMESPACE__ . "\HTMLText");
    }

    public function load($str) {
        /*
        $str = str_replace("<?php", "#{", $str);
        $str = str_replace("?>", "}#", $str);
         * 
         */
//        echo html_entity_decode($str);
        $this->doc->loadXML('<frontfile>' . html_entity_decode($str) .'</frontfile>');
        $this->root = $this->doc->getElementsByTagName('frontfile')->item(0);
//        $this->root = $this->doc->getElementsByTagName('body')->item(0);
    }
    
}

}
