<?php
namespace Sphp\tools{
/**
 * Description of FrontFile
 *
 * @author Sartaj Singh
 */

class FrontFile2 {

    public $data = "";
    public $filePath = "";
    public $compList = array();
    public $name = "";
    public $webapp = null;
    public $metadata = array();
    public $blncodebehind = false;
    public $blncodefront = false;
    public $blnshowFront = true;
    public $webapppath = "";
    public $sjspath = "";
    public $appname = "";
    public $HTMLParser = null;
    public function getData() {
        return $this->data;
    }

    public function getFilePath() {
        return $this->filePath;
    }

    public function getName() {
        return $this->name;
    }

    public function getWebapp() {
        return $this->webapp;
    }

    public function getWebapppath() {
        return $this->webapppath;
    }

    public function getSjspath() {
        return $this->sjspath;
    }

    public function getAppname() {
        return $this->appname;
    }
    public function setFilePath($filePath) {
        $this->filePath = $filePath;
    }

    public function setWebapp($webapp) {
        $this->webapp = $webapp;
    }

    public function setWebapppath($webapppath) {
        $this->webapppath = $webapppath;
    }

    public function setSjspath($sjspath) {
        $this->sjspath = $sjspath;
    }
    public function getBlncodebehind() {
        return $this->blncodebehind;
    }
    public function setBlncodebehind($blncodebehind) {
        $this->blncodebehind = $blncodebehind;
    }

    public function setBlncodefront($blncodefront) {
        $this->blncodefront = $blncodefront;
    }

    public function setBlnshowFront($blnshowFront) {
        $this->blnshowFront = $blnshowFront;
    }

    public function getBlncodefront() {
        return $this->blncodefront;
    }

    public function getBlnshowFront() {
        return $this->blnshowFront;
    }

        public function setAppname($appname) {
        $this->appname = $appname;
    }

    public function __construct($FrontFilePath, $blnStringData = false, $backfileobj = null) {
        $sphp_settings = getSphpSettings();
        if($sphp_settings->run_mode_not_extension){
            $libpath = $sphp_settings->lib_path ;
            includeOnce($libpath . "/comp/ajax/Ajaxsenddata.php");
        }
        $this->HTMLParser = new HTMLParser();
        $this->getFile($FrontFilePath, $blnStringData, $backfileobj, false);
    }

    public function addMetaData($key, $value) {
        $this->metadata[$key] = $value;
    }

    public function getMetaData($key) {
        return $this->metadata[$key];
    }

    public function __get($name) {
        return $this->compList[$name];
    }

    public function getComponent($key) {
        return $this->compList[$key];
    }
    public function setComponent($key,$obj) {
        $this->compList[$key] = $obj;
    }

    public function registerFrontFile() {
        $lst_frontfile = readGlobal("lst_frontfile");
        $md5url = md5($this->name);
        $lst_frontfile[$md5url] = $this;
        writeGlobal("lst_frontfile",$lst_frontfile);
    }
    
    public function getFile($FrontFilePath, $blnStringData = false, $backfileobj = null, $use_sjs_file = false) {
        $apppath = readAppPath();
        if ($FrontFilePath != "") {
            if (!$blnStringData) {
                $p = pathinfo($FrontFilePath);
                $this->name = $p["filename"];
                writeGlobal("currentfrontfile",  $this->name);
                $this->filePath = $FrontFilePath;
                $this->registerFrontFile();
                $this->HTMLParser->setFrontobj($this);
                if (is_object($backfileobj)) {
                    $this->blncodefront = true;
                    $this->HTMLParser->setCodebehind($p);
//    $this->appname = $this->HTMLParser->codebehind["filename"];
//    $frontfile = $apppath."fmodule/".$this->HTMLParser->codebehind["filename"].".php";
//    includeOnce($frontfile) ;
                    if ($use_sjs_file) {
                        $this->sjspath = $apppath . "/sjs/" . $this->HTMLParser->codebehind["filename"] . ".sjs";
                    }
//    $this->webapppath = $frontfile;
                    $this->webapp = $backfileobj;
                }

                $this->data = $this->HTMLParser->getHTMLFile($FrontFilePath);
                $this->data = $this->HTMLParser->parseHTMLObj($this->data, $this);
// check backcode file and process
                if ($this->blncodebehind || $this->blncodefront) {
                    $this->blnshowFront = false;
                    $this->webapp->setup($this);
// process aftercreate event
                    foreach ($this->compList as $key => $value) {
                        $value->onaftercreate();
                    }
// process webapp
                    $this->webapp->process($this);
                } else {
// process aftercreate event
                    foreach ($this->compList as $key => $value) {
                        $value->onaftercreate();
                    }
                }
            } else {
                $this->filePath = "";
//                registerFrontFile($this->name, $this);
                $this->HTMLParser->setFrontobj($this);
                $this->data = $this->HTMLParser->parseHTMLObj($FrontFilePath, $this);
            }
        }
    }

    public function run() {
        if ($this->blncodebehind) {
            $this->webapp->run();
            $this->webapp->render();
        }
        $this->data = $this->HTMLParser->parseHTML($this->data);
    }

    public function render() {
        echo $this->data;
    }

    public function runit() {
        $this->data = $this->HTMLParser->parseHTML($this->data);
    }

    public function renderit() {
        echo $this->data;
    }

}
}
