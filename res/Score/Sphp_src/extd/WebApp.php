<?php
namespace Sphp\tools{
/**
 * Description of WebApp
 *
 * @author Sartaj Singh
 */

class WebApp extends SphpApp {

    private $auth = "GUEST";
    private $tblName = "";
    private $masterFile = "";

    /** @var page */
    public $page = "";
    public $frontform;
    public $mainfrontform;
    public $sjsobj;
    public $blnsjsobj = false;
    public $JSServer = null;
    public $Client = null;
    public $dbEngine = null;
    public $sphp_api = null;
    public $debug = null;
    public $phppath = "";
    public $respath = "";
    public $apppath = "";

    public function __construct($frontfile) {
        \SphpBase::page()->appobj = $this;
        $this->page = \SphpBase::page();
        $this->sphp_api = getSphpApi();
        $this->JSServer = \SphpBase::JSServer();
        $this->Client = getSphpRequest();
        $this->dbEngine = getDBEngine();
        $this->apppath = readAppPath();
        $this->phppath = readPhpPath();
        $this->respath = readResPath();
        $this->debug = getDebug();
        $this->setFrontFile($frontfile);
        $this->mainfrontform = $frontfile;
        $this->showNotFrontFile();
        $this->masterFile = readGlobal("masterf");
        $this->onstart();
    }

    public function _setup($frontobj) {
        $this->mainfrontform = $frontobj;
        $this->onfrontinit($frontobj);
// add event handler into components
        $this->_fixCompEventHandlers($this->mainfrontform);
        if ($frontobj->sjspath != "") {
            $this->sjsobj = new Psjs($frontobj->sjspath);
            $this->sjsobj->fixCompEventHandlers($this->mainfrontform);
            $this->blnsjsobj = true;
        }
    }

    public function _process($frontobj) {
        $this->onfrontprocess($frontobj);
        $this->onready();
        $this->call_page_events();
    }

    private function call_page_events() {
//    global $dynData,$page,$respath,$phppath;
        extract(getGlobals(),EXTR_REFS);
        $JSServer = \SphpBase::JSServer();
        $JQuery = getJQuery();
        if ($this->page->isevent) {
            if ($this->page->sact == 'sphp') {
                $eventer = $JSServer->getJSON("eventer");
                $JSServer->startJSONOutput();
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
            $JSServer->getAJAX();
            $JQuery->getJQKit();
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

        if ($this->frontform[0]) {
            $this->mainfrontform->setBlnshowFront(true);
//    $dynData = $this->frontform[1];
//    $this->run();
//    $dynData->run();
//    $this->render();
//    includeOnce($this->masterFile);
        }
    }

    /**
     * Set Internal Front File. Internal Front File Also render Page Components.
     * @param FrontFile $obj 
     */
    public function setFrontFile($obj) {
        $this->frontform = array(true, $obj);
    }

    public function getFrontFile() {
        return $this->frontform[1];
    }

    public function showFrontFile() {
        $this->frontform[0] = true;
    }

    public function showNotFrontFile() {
        $this->frontform[0] = false;
    }

    public function onstart() {
        
    }

    public function onready() {
        
    }

    public function onfrontinit($frontobj) {
        
    }

    public function onfrontprocess($frontobj) {
        
    }

    public function page_delete() {
        
    }

    public function page_view() {
        
    }

    public function page_submit() {
        
    }

    public function page_insert() {
        
    }

    public function page_update() {
        
    }

    public function page_new() {
        
    }

    public function getEvent() {
        return $this->page->sact;
    }

    public function getEventParameter() {
        return $this->page->evtp;
    }

    public function onrun() {
        
    }

    public function onrender() {
        
    }

    public function _run() {
        $this->onrun();
    }

    public function render() {
        $this->onrender();
        $this->genSJSCode('sphp', '');
        if ($this->blnsjsobj) {
            $this->sjsobj->genSJSCode('sjs', '');
        }
    }

    /**
     * Set MasterFile
     */
    public function setMasterFile($masterFile) {
        $this->masterFile = $masterFile;
    }

    public function getMasterFile() {
        return $this->masterFile;
    }

    public function setTableName($tableName) {
        $tblName = $tableName;
        $this->tblName = $tableName;
        \SphpBase::page()->tblName = $dbtable;
    }
    public function getTableName(){
        return $this->tblName;
    }

    public function getAuthenticate($authenticates) {
        $this->auth = $authenticates;
        $this->page->Authenticate($authenticates);
    }

    public function getSesSecurity() {
        $this->page->sesSecure();
    }

}
}
