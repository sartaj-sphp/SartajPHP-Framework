<?php
/**
 * Description of AutoAppS
 *
 * @author Sartaj
 */
include_once($phppath . "/controls/jquery.php");
include_once($libpath . "/lib/DIR.php");
include_once($phppath . "/classes/parser/minifier1/JavascriptMinifier.phpclass");

class MobileAppJQuery extends \Sphp\tools\BasicApp{
    private $dir = null;
    private $jsonf = array();
    private $key = 0;
    public $outfolder = "apps/objs";
    
    public function onstart() {
        $this->dir = new DIR();
    }

    public function page_new() {
        global $phppath;
        $this->loadStarter();
        $this->loadFrontPlaces();
        $ty = new Sphp\tools\TempFile($phppath . "/apps/mobile/forms/index.temp");
        $this->setTempFile($ty);
        $pages = $this->loadPages();
        file_put_contents($this->outfolder . "/pages.html", $pages);
        $this->key += 1;
        $this->jsonf[$this->key] = array("html",$this->outfolder . "/pages.html");
        $ty->getComponent('dir1')->setInnerHTML($pages);
        $this->getSphpJSCode();
        $firstRunf["version"] = 1; 
        $firstRunf["files"] = $this->jsonf;
        file_put_contents("apps/acfdb/firstrun.json", json_encode($firstRunf));
    }
    private function loadStarter() {
        global $phppath,$respath;
        addjQueryMobile(); 
        addjQueryUI(); 
        addBootStrap(); 
        addFontAwesome();
        addFileLink($this->apppath . "/objs/temp/css/framework.css");
        addFileLink($respath . "/jslib/jquery/jslib.js");
        addFileLink($respath . "/jslib/jqueryPlugin/jsstore.js");
        addFileLink($respath . "/apps/mobile/core/jQmCore.js");
        $this->key += 1;
        $this->jsonf[$this->key] = array("js","https://proj.itkruze.com/res/apps/mobile/core/jQmCore.js");
        $this->key += 1;
        $this->jsonf[$this->key] = array("css",$this->apppath . "/objs/temp/css/framework.css");
        addFileLink($this->outfolder . "/sphpapp" . '.js');
        $this->loadJSLib("lib",true);
        $this->loadJSLib("jsapps");
        $this->loadJSLib("pages/js");
        $this->loadJSLib("components/js");
        $this->loadJSLib("frontplace/js");
    }
    private function loadFrontPlaces() {
        addFrontPlace("emsg", $this->apppath . "/frontplace/ErrorMSG.front");
        addFrontPlace("sidemenu",$this->apppath . "/frontplace/SideMenu.front");  
        //$this->key += 1;
        //$this->jsonf[$this->key] = array("html", $this->outfolder . "/front.html");
        
    }
    private function getSphpJSCode() {
        global $respath;
        $sphp_api = getSphpApi();
        addHeaderJSFunction("ready", "ModuleObject.setHandler('onDeviceReady',function(){", "});",true);
        $jscode = $sphp_api->getHeaderJS(false, true,2);
        $jscode .= $sphp_api->getFooterJS(false, true,2);
        $filepath = $this->apppath . "/gen/sphplib.js";
        $this->key += 1;
        $this->jsonf[$this->key] = array("js",$filepath);
        file_put_contents($filepath, $jscode);
        addFileLink($filepath);
    }
    private function loadJSLib($subpath,$overwrite=false) {
        global $respath;
        $lst = $this->dir->directorySearch($this->apppath . $subpath,".js");
        $stro = "";
        foreach ($lst as $key => $value) {
            $stro .= file_get_contents($value[0] .'/' . $value[1]);
            $stro .= ' 
 ';
        }  
        $minifier = new JavascriptMinifier ();
        $filename = $this->outfolder . "/sphpapp" . '.js';
        if($overwrite){
//            $d = file_get_contents($respath . "/apps/mobile/core/jQmCore.js") .' 
// ';
            file_put_contents($filename, $minifier->Minify($stro));         
        }else{
            file_put_contents($filename, $minifier->Minify($stro),FILE_APPEND);
        }
        $this->key += 1;
        $this->jsonf[$this->key] = array("js",$filename);
    }
    private function loadPages() {
        $header = new Sphp\tools\TempFile($this->apppath . "/components/header-bar.temp",false,$this);
        $footer = new Sphp\tools\TempFile($this->apppath . "/components/footer-bar.temp",false,$this);
        $header->run();
        $footer->run();
        $lst = $this->dir->directorySearch($this->apppath . "/pages/",".temp");
        $stro = "";
        foreach ($lst as $key => $value) {
             //echo $value[1];
            $t = new Sphp\tools\TempFile($value[0].$value[1],false,$this);
            if($t->getMetaData('jQpage')->header){
                $t->getMetaData('jQpage')->headerbar = $header->data;
                addHeaderJSFunctionCode("ready", $t->getMetaData('jQpage')->pagename ."comp1" , 'PageObject.addCompName("' . $t->getMetaData('jQpage')->pagename . "page" . '","header-bar");',true);
            }
            if($t->getMetaData('jQpage')->footer){
                $t->getMetaData('jQpage')->footerbar = $footer->data;
                addHeaderJSFunctionCode("ready", $t->getMetaData('jQpage')->pagename ."comp2" , 'PageObject.addCompName("' . $t->getMetaData('jQpage')->pagename . "page" . '","footer-bar");',true);
            }
            $t->run();
           
            $stro .= $t->data;
        }
        return $stro;
    }
}