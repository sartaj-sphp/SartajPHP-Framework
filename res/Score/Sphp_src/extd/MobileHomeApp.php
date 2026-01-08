<?php
namespace Sphp\tools{
/**
 * Description of AngularApp
 *
 * @author Sartaj Singh
 */
//include_once($phppath . "/component/jquery.php");
include_once(\SphpBase::sphp_settings()->lib_path . "/lib/DIR.php");
include_once(\SphpBase::sphp_settings()->lib_path . "/lib/HtmlMinifier.php");

class MobileHomeApp extends ComboApp{
    private $dir = null;

public function __construct(){
    \SphpBase::page()->appobj = $this;
    $this->dir = new \DIR();
    $this->sphp_api = \SphpBase::sphp_api();
    $this->page = \SphpBase::page();
    $this->JSServer = \SphpBase::JSServer();
    $this->Client =  \SphpBase::sphp_request();
    $this->apppath = \SphpBase::page()->apppath;
    $this->phppath = \SphpBase::sphp_settings()->php_path;
    $this->respath = \SphpBase::sphp_settings()->res_path;
    $this->dbEngine = \SphpBase::dbEngine();
    $this->debug = \SphpBase::debug();
    $this->setClassPath();
    $frontobj = new FrontFile($this->apppath . "/forms/" . $this->cfilename . '.front',false,null, $this);
    $this->setFrontFile($frontobj);
    $this->mainfrontform = $frontobj;
    $this->showNotFrontFile();
    $this->masterFile = readGlobal("mobimasterf");
    $this->onstart();
}

public function render(){
    $this->loadStarter();
    parent::render();
    $this->createComboFiles();
}

private function loadStarter() {
    \SphpBase::sphpJsM()->addjQueryUI(); 
}

private function loadJSPhpLib($filename,$subpath,$overwrite=false){
        if(file_exists($this->apppath . '/'. $subpath)){
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

private function loadJSLib($filename,$subpath,$overwrite=false){
        if(file_exists($this->apppath .'/'. $subpath)){
        $lst = $this->dir->directorySearch($this->apppath . '/' . $subpath,".js");
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

private function createComboFiles() {
        addHeaderJSFunction("ready", "ModuleObject.setHandler('onDeviceReady',function(){", "});",true);
        $jscode = $this->sphp_api->getHeaderJS(false, true,2);
        $jscode .= $this->sphp_api->getFooterJS(false, true,2) .' 
 ';
        $filepath =  "cache/{$this->cfilename}.js";
        $str1 = $this->sphp_api->getCombineGlobalJSFiles();
        // private js files, leave because of AJAX auto file load
        $str1 .= $this->sphp_api->getCombineJSFiles();
//        file_put_contents($filepath, $this->sphp_api->minifyJS($str1 . $jscode));
        file_put_contents($filepath,"// this file is copyright by SartajPHP \r\n" . $str1);
        $this->loadJSLib($filepath,"clientjs/jslib");
        $this->loadJSLib($filepath,"clientjs/jsapps");
        //file_put_contents($filepath, $jscode,FILE_APPEND);
        file_put_contents($filepath, $this->sphp_api->minifyJS($jscode),FILE_APPEND);
        addFileLink($filepath);
    }

    

}
class MobilePageApp extends MobileHomeApp{

    public function page_event_loadpagefull($evtp){
        $this->render();
        $this->createComboFiles();
        $this->JSServer->addJSONFrontFull($this->mainfrontform,$evtp);  
    }
    public function page_event_loadpage($evtp){
        $this->render();        
        $this->createComboFiles();
        $this->JSServer->addJSONFront($this->mainfrontform,$evtp);  
    }
    private function createComboFiles() {
        $filepath =  "cache/{$this->cfilename}.js";
        $str1 = $this->sphp_api->getCombineGlobalJSFiles(false,true);
        $str1 = $this->sphp_api->getCombineJSFiles(false,true);
//        file_put_contents($filepath, $this->sphp_api->minifyJS($str1 . $jscode));
        //file_put_contents($filepath,"// this file is copyright by SartajPHP \r\n" . $str1);
        //addFileLink($filepath);
    }
    public function render(){
        $this->genSJSCode('sphp', '');
    if ($this->blnsjsobj) {
        $this->sjsobj->genSJSCode('sjs', '');
    }
    }
    
}
}
