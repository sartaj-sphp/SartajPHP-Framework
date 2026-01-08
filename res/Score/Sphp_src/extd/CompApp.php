<?php

namespace Sphp\tools {

    /**
     * Description of CompApp
     *
     * @author Sartaj Singh
     */
    class CompApp extends SphpApp {

        public $parentFrontObj = null;
        public $parentComponent = null;
        public $parentapp = null;

        /** @var \Sphp\kit\Page page */
        public $page = "";

        /** @var FrontFile frontform */
        public $frontform;

        /** @var FrontFile mainfrontform */
        public $mainfrontform;
        public $apppath = "";
        public $mypath = "";
        public $myrespath = "";
        public $phppath = "";
        public $respath = "";
        public $nameprefix = "";

        /** @var \Sphp\kit\JSServer JSServer */
        public $JSServer = null;

        /** @var \Sphp\kit\Request Client */
        public $Client = null;

        /** @var \Sphp\kit\MySQL dbEngine */
        public $dbEngine = null;

        /** @var \Sphp\core\DebugProfiler debug */
        public $debug = null;

        public function __construct($pfrontobj, $compobj) {
            $this->parentFrontObj = $pfrontobj;
            $this->parentComponent = $compobj; 
            $this->parentapp = $pfrontobj->parentapp;
            $this->page = \SphpBase::page();
            $frontobj = new FrontFile('<span></span>', true);
            $this->JSServer = \SphpBase::JSServer();
            $this->Client = \SphpBase::sphp_request();
            $this->apppath = $this->parentapp->apppath;
            $this->mypath = $compobj->mypath;
            $this->myrespath = $compobj->myrespath;
            $this->phppath = \SphpBase::sphp_settings()->php_path;
            $this->respath = \SphpBase::sphp_settings()->res_path;
            $this->dbEngine = \SphpBase::dbEngine();
            $this->debug = \SphpBase::debug();
            $this->setFrontFile($frontobj);
            $this->mainfrontform = $frontobj;
            $this->showNotFrontFile();
            $this->onstart();
        }
        /**
         * 
         * @param string $filepath front file path
         * @param boolean $noprefix false mean add prefix as parent-component name to all Components
         * @return \Sphp\tools\FrontFile
         */
        public function createFrontFile($filepath,$noprefix=false) {
            $front1 = null;
            if(!$noprefix){
                $this->nameprefix = $this->parentComponent->name;
                $front1 = new FrontFile($filepath,false,null, $this, false, $this->parentComponent->name);
            }else{
                $front1 = new FrontFile($filepath,false,null, $this);                
            }
            // update parent frontfile complist for db binding
                foreach($front1->compList as $key=>$val){ 
                        $this->parentFrontObj->compList[$key] = $val;
                }
                return $front1;
        }
        public function setup($frontobj) {
            $this->mainfrontform = $frontobj;
            $this->onfrontinit($frontobj);
// add event handler into components
//            $this->fixCompEventHandlers($this->mainfrontform);
        }

        public function process($frontobj) {
            $this->onfrontprocess($frontobj);
        }

        public function processEvent() {
            $this->triggerAppEvent();
            $this->call_page_events();
        }

        private function call_page_events() {
//    global $dynData,$page,$respath,$phppath;
            extract(getGlobals(), EXTR_REFS);
            if ($this->page->isevent) {
                $fun = "page_event_{$this->page->sact}";
                if (method_exists($this, $fun)) {
                    $this->{$fun}($this->page->evtp);
                }
            } else if ($this->page->isnew) {
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

        public function setTableName($dbtable) {
            \SphpBase::page()->tblName = $dbtable;
            $this->tblName = $dbtable;
        }
    public function getTableName(){
        return $this->tblName;
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

        public function run() {
            $callM = $this->parentComponent->name . '_event_init';
            if (method_exists($this->parentapp, $callM)) {
                $this->parentapp->$callM($this);
            }
           // print_r($this->parentFrontObj);
            $this->onready();
            $this->onrun();
            $this->processEvent();
        }

        public function render() {
            $this->onrender();
        }
        public function getReturnData() {
            if ($this->frontform[0]) {
                $mainfront = $this->mainfrontform;
                $mainfront->blnshowFront = true;
                $dynDatam = $this->frontform[1];
                $dynDatam->run();
                $this->render();
                return $dynDatam->data;
            }

        }

    }

}
