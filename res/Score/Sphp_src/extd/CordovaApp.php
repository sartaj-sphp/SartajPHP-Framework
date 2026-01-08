<?php
namespace Sphp\tools{
/**
 * Description of MobileApp
 *
 * @author Sartaj Singh
 */
require_once(\SphpBase::sphp_settings()->lib_path . "/lib/DIR.php");
include_once(\SphpBase::sphp_settings()->lib_path . "/lib/HtmlMinifier.php");

class CordovaApp extends BasicApp{
    public $mobappname = "HelloCordova";
    public $mobappid = "com.sartajphp.hellocordova";
    public $mobappversion = "0.0.1";
    private $mobappversion1 = 1;
    public $mobappdes = "A sample Apache Cordova application that responds to the deviceready event.";
    public $mobappauthor = "Apache Cordova Team";
    public $mobappauthoremail = "dev@cordova.apache.org";
    public $mobappauthorweb = "https://cordova.apache.org";
    public $sjsobj = array();
    public $blnsjsobj = true;
    public $sphp_api = null;
    public $cfilename = "";
    public $dir = null;
    private $blncombine = true;
    private $mpages = array();
    private $distlibs = array();
    private $mainfront = null;
    private $homefront = null;
    private $genRootFolder = "www";
    private $genFolder = "";
    private $specialmeta = '<meta http-equiv="Content-Security-Policy" content="default-src \'self\' data: gap: https://sartajsingh.com https://www.sartajphp.com https://ssl.gstatic.com ; script-src \'self\' https://sartajsingh.com https://www.sartajphp.com \'unsafe-inline\' \'unsafe-eval\';style-src \'self\' https://sartajsingh.com https://www.sartajphp.com \'unsafe-inline\'; media-src *; img-src * data: content:; frame-src https://sartajsingh.com https://www.sartajphp.com ; connect-src \'self\' https://sartajsingh.com https://www.sartajphp.com ;">
    <meta name="format-detection" content="telephone=no">
    <meta name="msapplication-tap-highlight" content="no">
';

public function __construct(){
    $this->setGenRootFolder($this->genRootFolder);
    \SphpBase::page()->appobj = $this;    
    $this->sphp_api = \SphpBase::sphp_api();
    $this->page = \SphpBase::page();
    $this->JSServer = \SphpBase::JSServer();
    $this->Client =  \SphpBase::sphp_request();
    $this->apppath = \SphpBase::page()->apppath;
    $this->phppath = str_replace("\\",'/',realpath(\SphpBase::sphp_settings()->php_path)); 
    $this->respath = \SphpBase::sphp_settings()->res_path;
    $this->dbEngine = \SphpBase::dbEngine();
    $this->debug = \SphpBase::debug();
    $this->dir = new \DIR();
    $this->setClassPath();
    $this->mainfront =  new FrontFile('<span></span>',true);
    $this->homefront = new FrontFile($this->apppath . "/forms/" . $this->cfilename . '.front',false,null, $this);
    $this->setFrontFile($this->mainfront);
    $this->mainfrontform = $this->mainfront;
    $this->showNotFrontFile();
    $this->masterFile = readGlobal("masterf");
    $this->getAutoVersion();
    $this->onstart();
}
public function setGenRootFolder($param) {
    $this->genRootFolder = $param;
    $this->genFolder = $this->genRootFolder . "/sphpmob";    
}
public function setSpecialMetaTag($val) {
    $this->specialmeta = $val;
}
/**
 * Set Distribute multi js css files rather then single
 */
public function setMultiFiles() {
    $this->blncombine = false;
}
public function setup($frontobj){
    $this->onfrontinit($frontobj);
// add event handler into components
    $this->fixCompEventHandlers($frontobj);
    if(!isset($this->sjsobj[$frontobj->name])){
    $frontobj->sjspath = $this->apppath . "/sjs/" . $frontobj->name . ".sjs";
    $sjs1 = new Psjs($frontobj->sjspath);
    $this->sjsobj[$frontobj->name] = $sjs1;
    $sjs1->fixCompEventHandlers($frontobj);
    }

}
public function addPage($pageobj) {
    $this->mpages[] = $pageobj;
}
public function addDistLib($folderpath) {
    $this->distlibs[] = $folderpath;
}
public function process($frontobj){ $this->onfrontprocess($frontobj); }
public function processEvent(){
    $this->triggerAppEvent();
    $this->call_page_events();    
}
private function call_page_events(){
        extract(getGlobals(),EXTR_REFS);
        if ($this->page->isevent) {
        } else if ($this->page->isnew) {
            $this->showFrontFile();
             \SphpBase::JSServer()->getAJAX();
             \SphpBase::JQuery()->getJQKit();
             $this->setUpMobileEvents();
            $this->page_new();
        }

if($this->frontform[0]){
    \SphpBase::page()->masterfilepath = $this->masterFile;
    $mainfront = $this->mainfrontform;
    $mainfront->blnshowFront = true;
    $dynData = $this->frontform[1];
    $this->homefront->run();
    $dynData->data = $this->homefront->data;
    foreach ($this->mpages as $p=>$tmp1){
        $tmp1->run();
        $dynData->data .= $tmp1->data;
    }
    \SphpBase::$dynData = $dynData;
    $this->render();
    //includeOnce2($this->masterFile);
    $this->sendRenderData();
}
    
}
private function getAutoVersion() {
    if(file_exists('./autover.txt')){
        $this->mobappversion1 = intval(file_get_contents("./autover.txt"));
    }
    $this->mobappversion1 += 1;
    file_put_contents('./autover.txt', $this->mobappversion1);
    $ver = strval($this->mobappversion1);
    $verc = strlen($ver);
    if($verc > 2){
        $this->mobappversion = $ver[0] . '.' . $ver[1] . '.' . $ver[2]; 
    }else if($verc > 1){
        $this->mobappversion = '0.' . $ver[0] . '.' . $ver[1]; 
    }else if($verc > 0){
        $this->mobappversion = '0.0.' . $ver[0]; 
    }else{
        $this->mobappversion = '0.0.1';
    }
}

protected function createCordovaPlugin($curdirpath) {
    $workpath = $curdirpath . "/apps/cordova";
    if(! \DIR::directoryExists($workpath)){
        $this->dir->directoriesCreate($workpath);
        $this->dir->directoriesCreate($curdirpath . "/front/cordova/plugins");
        $this->dir->directoryCopy($this->phppath . "/jslib/mobileapp/cordova",$workpath);
    }
    $this->dir->directoryCopyChanges($workpath . '/plugins', $curdirpath . "/front/cordova/plugins");
    
    file_put_contents($curdirpath . '/front/cordova/plugins/com.sartajphp.scordova/package.json', \SphpBase::sphp_api()->getDynamicContent($workpath . '/plugins/com.sartajphp.scordova/package.json',$this));
    file_put_contents($curdirpath . '/front/cordova/plugins/com.sartajphp.scordova/plugin.xml', \SphpBase::sphp_api()->getDynamicContent($workpath . '/plugins/com.sartajphp.scordova/plugin.xml',$this));
    file_put_contents($curdirpath . '/package.json', \SphpBase::sphp_api()->getDynamicContent($workpath . '/package.json',$this));
    file_put_contents($curdirpath . '/config.xml', \SphpBase::sphp_api()->getDynamicContent($workpath . '/config.xml',$this));
}

protected function sendRenderData() {
    $curdirpath = str_replace("\\","/",realpath('./'));
    $this->genRootFolder = $curdirpath . '/' . $this->genRootFolder;
    $workpath = $curdirpath . '/' . $this->genFolder;
    if(! \DIR::directoryExists($this->genRootFolder . "/favicon")){
        $this->dir->directoryCopy($this->phppath . "/jslib/mobileapp/front/cordova/favicon",$this->genRootFolder . '/favicon');        
    }
    if(!file_exists($this->genRootFolder . '/sartajphp.css')){
        copy($this->phppath . "/jslib/mobileapp/front/cordova/sartajphp.css", $this->genRootFolder . '/sartajphp.css');
    }
    if(! \DIR::directoryExists($workpath)){
        $this->dir->directoriesCreate($workpath);
        $this->dir->directoryCopy($this->phppath . "/jslib/mobileapp/base",$workpath);
        $this->dir->directoryCopy($this->phppath . "/jslib/jquery",$workpath .'/resm/jslib/jquery');
        $this->dir->directoryCopy($this->phppath . "/jslib/jquery-ui-1.12.1",$workpath .'/resm/jslib/jquery-ui-1.12.1');
    }else{
        //$this->dir->directoryCopy($this->phppath . "/jslib/mobileapp",$workpath);
    }
    // distribute jslib
    foreach ($this->distlibs as $l=>$libpath1){
        $libpath2 = str_replace($this->phppath, $this->genFolder . '/resm',$libpath1); 
        if(! \DIR::directoryExists($libpath2)){
            $this->dir->directoryCopy($libpath1,$libpath2,"",false,array("js","php"),array("js.map"));            
            $this->dir->directoryCopy($libpath1,$libpath2,$this->genFolder . '/resm/jslib',true,array(),array("js.map"));          
        }        
    }
    //updateFileLink("$this->genFolder/jslib/jquery/jquery.min.js", true, "jquery-min","js");
    //updateFileLink("$this->genFolder/jslib/jquery-ui-1.12.1/jquery-ui.min.js", true, "jquery-ui","js");
    //\SphpJsM::addBootStrap();
    //\SphpJsM::addFontAwesome();
    $this->createComboFiles();
    $this->createCordovaPlugin($curdirpath);
    $stro2 = "";
    $stro = '<!DOCTYPE html>
<html>
<head lang="en">
    <!--
    Customize this policy to fit your own app\'s needs. For more guidance, see:
        https://github.com/apache/cordova-plugin-whitelist/blob/master/README.md#content-security-policy
    Some notes:
        * gap: is required only on iOS (when using UIWebView) and is needed for JS->native communication
        * https://ssl.gstatic.com is required only on Android and is needed for TalkBack to function properly
        * Disables use of inline scripts in order to mitigate risk of XSS vulnerabilities. To change this:
            * Enable inline JS: add \'unsafe-inline\' to default-src
    -->
    '. $this->specialmeta .'
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width">
';
    $stro2 .=  getHeaderHTML(true,true,1);
    $stro2 .= '
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link href="sartajphp.css" rel="stylesheet"  type="text/css" />
    </head>
<body>
<div class="container-fluid">';
    $stro2 .= \SphpBase::$dynData->data;
    $stro2 .= '</div> 
';
    $stro2 .= getFooterHTML(true,true,1);
    $stro2 .= '</body></html>';
    $stro = str_replace([\SphpBase::sphp_settings()->res_path,$this->genFolder . '/resm'], 'sphpmob/resm', $stro);
    $stro2 = str_replace([\SphpBase::sphp_settings()->res_path,$this->genFolder . '/resm'], 'sphpmob/resm', $stro2);
    \SphpBase::sphp_api()->safeWriteFile('www/index.html', $stro . '<script type="text/javascript" src="cordova.js"></script>' . $stro2);
    \SphpBase::sphp_api()->safeWriteFile('index.html', $stro . $stro2);
   // echo $stro . $stro2;
}

/*
private function sendRenderData_old() {
    $workpath = realpath('./');
    if(! \DIR::directoryExists($workpath . '/front/cordova')){
        $this->dir->directoryCopy($this->phppath . "/jslib/mobileapp/front/cordova",$workpath . '/front/cordova');
    }
    if(! \DIR::directoryExists($workpath . '/$this->genFolder')){
        $workpath .= '/$this->genFolder';
        $this->dir->directoriesCreate($workpath);
        $this->dir->directoryCopy($this->phppath . "/jslib/mobileapp/base",$workpath);
        $this->dir->directoryCopy($this->phppath . "/jslib/jquery",$workpath .'/resm/jslib/jquery');
        $this->dir->directoryCopy($this->phppath . "/jslib/jquery-ui-1.12.1",$workpath .'/resm/jslib/jquery-ui-1.12.1');
    }else{
        $workpath .= '/$this->genFolder';        
        //$this->dir->directoryCopy($this->phppath . "/jslib/mobileapp",$workpath);
    }
    foreach ($this->distlibs as $l=>$libpath1){
        $libpath2 = str_replace($this->phppath, '$this->genFolder/resm/',$libpath1);
        if(! \DIR::directoryExists($libpath2)){
            $this->dir->directoryCopy($libpath1,$libpath2,"",false,array("js","php"),array("js.map"));            
            $this->dir->directoryCopy($libpath1,$libpath2,'$this->genFolder/resm/jslib',true,array(),array("js.map"));          
        }        
    }
    //updateFileLink("$this->genFolder/jslib/jquery/jquery.min.js", true, "jquery-min","js");
    //updateFileLink("$this->genFolder/jslib/jquery-ui-1.12.1/jquery-ui.min.js", true, "jquery-ui","js");
    //\SphpJsM::addBootStrap();
    //\SphpJsM::addFontAwesome();
    $this->createComboFiles();
    $stro2 = "";
    $stro = '<!DOCTYPE html>
<html>
<head lang="en">
    <!--
    Customize this policy to fit your own app\'s needs. For more guidance, see:
        https://github.com/apache/cordova-plugin-whitelist/blob/master/README.md#content-security-policy
    Some notes:
        * gap: is required only on iOS (when using UIWebView) and is needed for JS->native communication
        * https://ssl.gstatic.com is required only on Android and is needed for TalkBack to function properly
        * Disables use of inline scripts in order to mitigate risk of XSS vulnerabilities. To change this:
            * Enable inline JS: add \'unsafe-inline\' to default-src
    -->
    '. $this->specialmeta .'
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width">
';
    $stro2 .=  getHeaderHTML(true,true,1);
    $stro2 .= '
    <link rel="icon" type="image/png" sizes="16x16" href="front/cordova/favicon/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="front/cordova/favicon/favicon-32x32.png"></head>
<body>
<div class="container-fluid">';
    $stro2 .= \SphpBase::$dynData->data;
    $stro2 .= '</div> 
';
    $stro2 .= getFooterHTML(true,true,1);
    $stro2 .= '</body></html>';
    $stro = str_replace(\SphpBase::sphp_settings()->res_path, '$this->genFolder/resm/', $stro);
    $stro2 = str_replace(\SphpBase::sphp_settings()->res_path, '$this->genFolder/resm/', $stro2);
    \SphpBase::sphp_api()->safeWriteFile('index_mob.html', $stro . '<script type="text/javascript" src="front/cordova/cordova.js"></script>' . $stro2);
    \SphpBase::sphp_api()->safeWriteFile('index.html', $stro . $stro2);
    echo $stro . $stro2;
}
*/

public function run(){
    $this->onready();
    $this->onrun();
    $this->processEvent();
}
public function render(){
    $this->onrender();  
    //$this->genSJSCode('sphp', ''); not supported server side js
    if ($this->blnsjsobj) {
        foreach ($this->sjsobj as $p=>$sjs1){
            $sjs1->genSJSCode('sjs', '');
        }
    }
}


 public function setClassPath() {
        $class_info = new \ReflectionClass($this);
        $p1 = \SphpBase::sphp_api()->filepathToRespaths($class_info->getFileName());
        //$this->cfilepath = $p1[3];
        $this->cfilename = $p1[0]["filename"];
        $this->mypath = $p1[1];
        $this->myrespath = $p1[2];
    }
    
    private function setUpMobileEvents() {
        $str = 'var sphpstatus = {
    online: false,
    ENVMobile: false,
    osAgentKey: "",
    sandBoxDirectory: "",
    downloadPath: ""
};
//$.holdReady( true );
var ConnectionN = {UNKNOWN: 1,
    ETHERNET: 2,
    WIFI: 3,
    CELL_2G: 4,
    CELL_3G: 5,
    CELL_4G: 6,
    NONE: 7
};

var SphpPlugin;
var appn = {
    // Application Constructor
    initialize: function() {
        document.addEventListener(\'pause\', this.onPause, false);
        document.addEventListener(\'resume\', this.onResume, false);
        document.addEventListener(\'online\', this.onLine, false);
        document.addEventListener(\'offline\', this.onOffLine, false);
        $(window).on("beforeunload", this.sunload);
        document.addEventListener(\'deviceready\', this.onDeviceReady.bind(this), false);
        
        //window.onload = appn.onDeviceReady;
        document.addEventListener("backbutton", function (e) {
                        /* block back button:- e.preventDefault(); */ 
                        jq_backkey(e);
                    }, false );
        sphpstatus.osAgentKey = window.navigator.userAgent;
        sphpstatus.online = navigator.onLine;
    },
    sunload: function (e) {
        jq_unload(e);
    },
    onLine: function (e) {
        sphpstatus.online = true;
        jq_online(e);
    },
    onOffLine: function (e) {
        sphpstatus.online = false;
        jq_offline(e);
    },
    onPause: function (e) {
        jq_device_pause(e);
    },
    onResume: function (e) {
        // on resume app restart so not use, use init
        jq_device_resume(e);
    },
    onDeviceReady: function(e) {
        sphpstatus.ENVMobile = true; 
        /* 
        sphpstatus.sandBoxDirectory = cordova.file.dataDirectory;
        */ 
        sphpstatus.downloadPath = sphpstatus.sandBoxDirectory.replace("file:///","/");
        SphpPlugin = window.plugins.SphpPlugin;
        jq_device_ready(e);
    }
};
var successCallback = function(data) {
    logMe("Success!");
};
var errorCallback = function(errMsg) {
    logMe("Error! " + errMsg);
};
function isDevice(){
    return sphpstatus.ENVMobile; 
}
appn.initialize();
';
 addHeaderJSFunction('jq_unload', "function jq_unload(e){", "}");
 addHeaderJSFunction('jq_online', "function jq_online(e){", "}");
 addHeaderJSFunction('jq_offline', "function jq_offline(e){", "}");
 addHeaderJSFunction('jq_device_pause', "function jq_device_pause(e){", "}");
 addHeaderJSFunction('jq_device_resume', "function jq_device_resume(e){", "}");
 addHeaderJSFunction('jq_backkey', "function jq_backkey(e){", "}");
 // work only on device
 addHeaderJSFunction('jq_device_ready', "function jq_device_ready(e){", "}");
 addHeaderJSCode('mobileapp1', $str);
    }
    
    private function loadJSLib($filename,$subpath,$overwrite=false){
        if(file_exists($this->apppath . '/'. $subpath)){
        $lst = $this->dir->directorySearch($this->apppath . '/'. $subpath,".js");
        $stro = '';
        if(\SphpBase::sphp_settings()->js_protection){
            $stro .= 'function startsjsapp(){';
        }
        foreach ($lst as $key => $value) {
            $stro .= file_get_contents($value[0] .'/' . $value[1]);
            $stro .= ' 
 ';
        }  
        if($overwrite){
            if(\SphpBase::debug()->debugmode == 0){
            file_put_contents($filename, $this->sphp_api->minifyJS($stro)); 
            }else{
            file_put_contents($filename, $stro);         
            }
        }else{
            if(\SphpBase::debug()->debugmode == 0){
            file_put_contents($filename, $this->sphp_api->minifyJS($stro),FILE_APPEND);
            }else{
            file_put_contents($filename, $stro, FILE_APPEND);         
            }
        }
        }
    }

    private function createComboFiles() {
        //addHeaderJSFunction("ready", "ModuleObject.setHandler('onDeviceReady',function(){", "});",true);
        $jscode = $this->sphp_api->getHeaderJS(false, true,2);
        $jscode .= $this->sphp_api->getFooterJS(false, true,2) .' 
 ';
        $filepath =  "{$this->genFolder}/resm/jslib/sjmm.js";
        $str1 = $this->sphp_api->getDistGlobalJSFiles(false,false,true,"{$this->genFolder}/resm/jslib");
        // private js files, leave because of AJAX auto file load
        $str1 .= $this->sphp_api->getDistJSFiles(false,false,true,"{$this->genFolder}/resm/jslib");
//        file_put_contents($filepath, $this->sphp_api->minifyJS($str1 . $jscode));
        file_put_contents($filepath,"// this file is copyright by SartajPHP \r\n" . $str1);
        $str1 = "";
        $this->loadJSLib($filepath,"jslib");
        //$this->loadJSLib($filepath,"clientjs/jsapps");
        //file_put_contents($filepath, $jscode,FILE_APPEND);
        if(\SphpBase::sphp_settings()->js_protection){
            if(\SphpBase::debug()->debugmode == 0){
            file_put_contents($filepath, $this->sphp_api->minifyJS($jscode) . '} startsjsapp();',FILE_APPEND);
            }else{
            file_put_contents($filepath, $jscode . '} startsjsapp();',FILE_APPEND);
            }
        }else{
            if(\SphpBase::debug()->debugmode == 0){
            file_put_contents($filepath, $this->sphp_api->minifyJS($jscode),FILE_APPEND);            
            }else{
            file_put_contents($filepath, $jscode,FILE_APPEND); 
            }
        }
        addFileLink("{$this->genFolder}/resm/jslib/alib.js");
        addFileLink($filepath);
        
        $str1 = $this->sphp_api->getDistCSSFiles(false,false,false,"{$this->genFolder}/resm");
        //$filepath =  "{$this->genFolder}/resm/scmm.css";
        //file_put_contents($filepath,"/* this file generated by SartajPHP \r\n */" . $str1);
        //addFileLink($filepath);
            
    }

    
    //not in use
    private function loadJSPhpLib($filename,$subpath,$overwrite=false){
        if(file_exists($this->apppath .'/'. $subpath)){
        $parser = (new \PhpParser\ParserFactory())->create(\PhpParser\ParserFactory::PREFER_PHP7);
        $jsPrinter = new \phptojs\JsPrinter\JsPrinter();

    $phpCode = file_get_contents('path/to/phpCode');
    $stmts = $parser->parse($phpCode);
    $jsCode = $jsPrinter->jsPrint($stmts);
    
        $lst = $this->dir->directorySearch($this->apppath . '/'. $subpath,".php");
        $stro = "";
        foreach ($lst as $key => $value) {
            $stro .= file_get_contents($value[0] .'/' . $value[1]);
            $stro .= ' 
 ';
        }  
        if($overwrite){
            file_put_contents($filename, $this->sphp_api->minifyJS($stro));         
        }else{
            file_put_contents($filename, $this->sphp_api->minifyJS($stro),FILE_APPEND);
        }
        }
}


    }
    
  
    
}
