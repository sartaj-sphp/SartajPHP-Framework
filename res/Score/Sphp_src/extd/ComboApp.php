<?php
namespace Sphp\tools{
/**
 * Description of BasicApp
 *
 * @author Sartaj Singh
 */

class ComboApp extends BasicApp{
    public $sjsobj = null;
    public $blnsjsobj = false;
    public $sphp_api = null;
    public $cfilename = "";
    public $mypath = "";
    public $myrespath = "";

public function __construct(){
    \SphpBase::page()->appobj = $this;    
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
    $this->masterFile = readGlobal("masterf");
    $this->onstart();
}
public function setup($frontobj){
    $frontobj->sjspath = $this->apppath . "/sjs/" . $this->cfilename . ".sjs";
    $this->mainfrontform = $frontobj;
    $this->onfrontinit($frontobj);
// add event handler into components
    $this->fixCompEventHandlers($this->mainfrontform);
    if ($frontobj->sjspath != "") {
        $this->sjsobj = new Psjs($frontobj->sjspath);
        $this->sjsobj->fixCompEventHandlers($this->mainfrontform);
        $this->blnsjsobj = true;
    }

}
public function process($frontobj){ $this->onfrontprocess($frontobj); }
public function processEvent(){
    $this->triggerAppEvent();
    $this->call_page_events();    
}
private function call_page_events(){
        extract(getGlobals(),EXTR_REFS);
        if ($this->page->isevent) {
            if ($this->page->sact == 'sphp') {
                $eventer = \SphpBase::JSServer()->getJSON("eventer");
                \SphpBase::JSServer()->startJSONOutput();
                $fun = $this->page->evtp;
                $this->{$fun}($eventer);
            } else if ($this->page->sact == 'sjs' && $this->blnsjsobj) {
                $this->sjsobj->processSJSEvent();
            } else {
                $fun = "page_event_{$this->page->sact}";
                if (method_exists($this, $fun)) {
                    $this->$fun($this->page->evtp);
                }
            }
        } else if ($this->page->isnew) {
            $this->showFrontFile();
             \SphpBase::JSServer()->getAJAX();
             \SphpBase::JQuery()->getJQKit();
            $this->page_new();
        } else if ($this->page->isdelete) {
            $this->page_delete();
        } else if ($this->page->isview) {
            $this->page_view();
        } else if ($this->page->issubmit) {
            $this->page_submit();
            if ($this->page->isinsert) {
                $this->page_insert();
            } else if ($this->page->isupdate) {
                $this->page_update();
            }
        }

if($this->frontform[0]){
    \SphpBase::page()->masterfilepath = $this->masterFile;
    $mainfront = $this->mainfrontform;
    $mainfront->blnshowFront = true;
    $dynData = $this->frontform[1];
    $dynData->run();
    \SphpBase::$dynData = $dynData;
    $this->render();
    includeOnce2($this->masterFile);
}
    
}

public function run(){
    $this->onready();
    $this->onrun();
    $this->processEvent();
}
public function render(){
    $this->onrender();  
    $this->genSJSCode('sphp', '');
    if ($this->blnsjsobj) {
        $this->sjsobj->genSJSCode('sjs', '');
    }
}


 public function setClassPath() {
        $class_info = new \ReflectionClass($this);
        $pathaAr = \SphpBase::sphp_api()->filepathToRespaths($class_info->getFileName());
        $patha = $pathaAr[0];
        $this->cfilename = $patha["filename"];
        $this->myrespath = $pathaAr[2];
        $this->mypath = $pathaAr[1];

    }

    }
}
