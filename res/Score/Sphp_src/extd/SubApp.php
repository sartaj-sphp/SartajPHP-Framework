<?php
namespace Sphp\tools{
/**
 * Description of SubApp
 *
 * @author Sartaj Singh
 */

class SubApp extends SphpApp{
private $auth = "GUEST";
private $tblName = "";
/** @var \Sphp\kit\Page page */
public $page = "";
/** @var FrontFile frontform */
public $frontform;
/** @var FrontFile mainfrontform */
public $mainfrontform;
public $apppath = "";
public $phppath = "";
public $respath = "";
/** @var \Sphp\kit\JSServer JSServer */
public $JSServer = null;
/** @var \Sphp\kit\Request Client */
public $Client = null;
/** @var \Sphp\kit\MySQL dbEngine */
public $dbEngine = null;
/** @var \Sphp\core\DebugProfiler debug */
public $debug = null;
public $cfilename = "";
public $cfilepath = "";
public $mypath = "";
public $myrespath = "";


public function __construct(){
    $this->page = \SphpBase::page();
    $this->JSServer = \SphpBase::JSServer();
    $this->Client =  \SphpBase::sphp_request();
    $this->phppath = \SphpBase::sphp_settings()->php_path;
    $this->respath = \SphpBase::sphp_settings()->res_path;
    $this->dbEngine = \SphpBase::dbEngine();
    $this->debug = \SphpBase::debug();
    $frontobj = new FrontFile('<span></span>',true);
    $this->setFrontFile($frontobj);
    $this->mainfrontform = $frontobj;
    $this->showNotFrontFile();
    $this->setClassPath();
    $this->apppath = $this->mypath;
    $this->onstart();
}
public function setup($frontobj){
    $this->mainfrontform = $frontobj;
    $this->onfrontinit($frontobj);
// add event handler into components
    //$this->fixCompEventHandlers($this->mainfrontform);
}
public function process($frontobj){ $this->onfrontprocess($frontobj); }
public function processEvent(){
    $this->triggerAppEvent();
    $this->call_page_events();    
}
private function call_page_events(){
//    global $dynData,$page,$respath,$phppath;
   extract(getGlobals(),EXTR_REFS);
if($this->page->isevent){
    $fun = "page_event_{$this->page->sact}";
    if(method_exists($this, $fun)){
    $this->{$fun}($this->page->evtp);
    }
}else if($this->page->isnew){
    $this->page_new();
}else if($this->page->isdelete){
    $this->page_delete();
}else if($this->page->isview){
    $this->page_view();
}else if($this->page->issubmit){
    $this->page_submit();
    if($this->page->isinsert){
    $this->page_insert();
    }else if($this->page->isupdate){
    $this->page_update();
    }
}
if($this->frontform[0]){
    $mainfront = $this->mainfrontform;
    $mainfront->blnshowFront = true;
    $dynData4 = $this->frontform[1];
    $dynData4->run();
    $this->render();
    $dynData4->render();
}
    
}

/**
 * Set Internal Front File. Internal Front File Also render Page Components.
 * @param FrontFile $obj 
 */
public function setFrontFile($obj){
$this->frontform = array(true,$obj);
}
public function getFrontFile() {
return $this->frontform[1];    
}
public function showFrontFile(){
$this->frontform[0] = true;
}
public function showNotFrontFile(){
$this->frontform[0] = false;
}
public function setTableName($dbtable){
    \SphpBase::page()->tblName = $dbtable;
    $this->tblName = $dbtable;
}
    public function getTableName(){
        return $this->tblName;
    }


public function onstart(){}
public function onready(){}
public function onfrontinit($frontobj){}
public function onfrontprocess($frontobj){}
public function page_delete(){}
public function page_view(){}
public function page_submit(){}
public function page_insert(){}
public function page_update(){}
public function page_new(){}
public function getEvent(){return $this->page->sact;}
public function getEventParameter(){return $this->page->evtp;}

public function onrun(){}
public function onrender(){}

public function run(){
    $this->onready();
    $this->onrun();
    $this->processEvent();
}
public function render(){
    $this->onrender();    
}


public function getAuthenticate($authenticates){
    $this->auth = $authenticates;
    $this->page->Authenticate($authenticates);
}
public function getSesSecurity(){
$this->page->sesSecure();
}

    public function setClassPath() {
        $class_info = new \ReflectionClass($this);
        $p1 = \SphpBase::sphp_api()->filepathToRespaths($class_info->getFileName());
        $this->cfilepath = $p1[3];
        $this->cfilename = $p1[0]["filename"];
        $this->myrespath = $p1[2];
        $this->mypath = $p1[1];

    }
}
}
