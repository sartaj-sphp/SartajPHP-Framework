<?php

namespace Sphp\tools {

    /**
     * Description of BasicApp
     *
     * @author Sartaj Singh
     */
    class BasicApp extends SphpApp {

        protected $auth = "GUEST";
        protected $tblName = "";
        protected $masterFile = "";

        /** @var \Sphp\kit\Page $page */
        public $page = "";

        /** @var \Sphp\tools\FrontFile $frontform */
        public $frontform;

        /** @var \Sphp\tools\FrontFile $mainfrontform */
        public $mainfrontform;

        /** @var string $apppath application folder path */
        public $apppath = "";

        /** @var string $phppath res folder path */
        public $phppath = "";

        /** @var string $respath res browser url */
        public $respath = "";

        /** @var string $myrespath application browser url */
        public $myrespath = "";

        /** @var string $mypath application folder path */
        public $mypath = "";

        /** @var \Sphp\kit\JSServer $JSServer */
        public $JSServer = null;

        /** @var \Sphp\core\Request $Client */
        public $Client = null;

        /** @var \MySQL $dbEngine */
        public $dbEngine = null;

        /** @var \Sphp\core\DebugProfiler $debug */
        public $debug = null;

        /**
         * Assign Default FrontFile to App for render
         * @param \Sphp\tools\FrontFile $obj 
         */
        public function setFrontFile($obj) {
            $this->frontform = array(true, $obj);
        }

        /**
         * Get Current FrontFile assign to app for render
         * @return \Sphp\tools\FrontFile
         */
        public function getFrontFile() {
            return $this->frontform[1];
        }

        /**
         * Rendering Permission to default assigned FrontFile 
         */
        public function showFrontFile() {
            $this->frontform[0] = true;
        }

        /**
         * Disable Rendering Permission to default assigned FrontFile 
         */
        public function showNotFrontFile() {
            $this->frontform[0] = false;
        }

        /**
         * Set default table of Database to Sphp\Page object and this application.
         * This information is important for Components and other database users objects.
         * @param string $dbtable
         */
        public function setTableName($dbtable) {
            \SphpBase::page()->tblName = $dbtable;
            $this->tblName = $dbtable;
        }

        /**
         * get default database table assigned to application
         * @return string
         */
        public function getTableName() {
            return $this->tblName;
        }

        /**
         * get Appgate event name trigger by browser
         * @return string
         */
        public function getEvent() {
            return $this->page->getEvent();
        }

        /**
         * get Appgate event parameter post by browser
         * @return string
         */
        public function getEventParameter() {
            return $this->page->getEventParameter();
        }

        /**
         * onstart=1
         * App Life Cycle Event
         * override this event handler in your application to handle it.
         * trigger when application start
         */
        public function onstart() {
            
        }

        /**
         * onfrontinit=2
         * Trigger After FrontFile Parse Phase, Component oninit and oncreate 
         * Events and before Components onaftercreate event. Trigger for 
         *  each Front File use with BasicApp
         * Only Trigger if Front File is used with App
         * override this event handler in your application to handle it.
         * @param \Sphp\tools\FrontFile $frontobj
         */
        public function onfrontinit($frontobj) {
            
        }

        /** 
         * onfrontprocess=3
         * Trigger after onaftercreate Event of Component and before BasicApp onready and onrun Events 
         * and also before onappevent Event of Component 
         * Only Trigger if Front File is used with App
         * override this event handler in your application to handle it.
         * @param \Sphp\tools\FrontFile $frontobj
         */
        public function onfrontprocess($frontobj) {
            
        }

        /**
         * onready=4
         * App Life Cycle Event
         * override this event handler in your application to handle it.
         * trigger after FrontFile Initialization and ready to Run App.
         */
        public function onready() {
            
        }

        /** 
         * onrun=5
         * App LifeCycle Event
         * override this event handler in your application to handle it.
         * trigger when application run after ready event and before trigger any PageEvent
         */
        public function onrun() {
            
        }
        
        /** 
         * PageEvent Delete
         * Trigger only when Browser access URL is matched with PageEvent
         * Trigger only one PageEvent per request.
         * Trigger after onrun Event and before on render.
         * override this event handler in your application to handle it.
         * trigger when browser get (url=index-delete.html)
         * where index is Appgate of application and application path is in reg.php file 
         */
        public function page_delete() {
            
        }

        /** 
         * PageEvent View
         * Trigger only when Browser access URL is matched with PageEvent
         * Trigger only one PageEvent per request.
         * Trigger after onrun Event and before on render.
         * override this event handler in your application to handle it.
         * trigger when browser get (url=index-view-19.html)
         * where index is Appgate of application and application path is in reg.php file 
         * view = event name 
         * 19 = recid of database table or any other value.
         */
        public function page_view() {
            
        }

        /** 
         * PageEvent Submit
         * Trigger only when Browser access URL is matched with PageEvent
         * Trigger only one PageEvent per request.
         * Trigger after onrun Event and before on render.
         * override this event handler in your application to handle it.
         * trigger when browser post Filled Form Components (url=index.html)
         * where index is Appgate of application and application path is in reg.php file 
         */
        public function page_submit() {
            
        }

        /** 
         * PageEvent Insert
         * Trigger only when Browser access URL is matched with PageEvent
         * Trigger only one PageEvent per request.
         * Trigger after onrun Event and before on render.
         * override this event handler in your application to handle it.
         * trigger when browser post Filled Empty Form Components (url=index.html)
         * where index is Appgate of application and application path is in reg.php file 
         */
        public function page_insert() {
            
        }

        /** 
         * PageEvent Update
         * Trigger only when Browser access URL is matched with PageEvent
         * Trigger only one PageEvent per request.
         * Trigger after onrun Event and before on render.
         * override this event handler in your application to handle it.
         * trigger when browser post Edited Form Components Which Filled with 
         * \SphpBase::page()->viewData() (url=index.html) 
         * from database with view_data function
         * where index is Appgate of application and application path is in reg.php file 
         */
        public function page_update() {
            
        }

        /** 
         * PageEvent New
         * Trigger only when Browser access URL is matched with PageEvent
         * Trigger only one PageEvent per request.
         * Trigger after onrun Event and before on render.
         * override this event handler in your application to handle it.
         * trigger when browser get URL (url=index.html) first time
         * where index is Appgate of application and application path is in reg.php file 
         */
        public function page_new() {
            
        }

        /** 
         * onrender=10
         * App Life Cycle Event
         * override this event handler in your application to handle it.
         * trigger when application render after run FrontFile but before start master
         * file process. You can't manage FrontFile output here but you can replace FrontFile
         * output in SphpBase::$dynData or change master file or add front place for master filepath
         */
        public function onrender() {
            
        }

        /**
         * set path of master design file name
         * @param string $masterFile
         */
        public function setMasterFile($masterFile) {
            $this->masterFile = $masterFile;
        }

        /**
         * Set which user can access this application. Default user is GUEST.
         * You can set session variable in login app 
         * SphpBase::sphp_request()->session('logType','ADMIN');
         * If user is not login with specific type then application exit and
         * redirect according to the getWelcome function in comp.php
         * @param string $authenticates <p>
         * comma separated list of string. Example:- getAuthenticate("GUEST,ADMIN") or getAuthenticate("ADNIN")
         * </p>
         */
        public function getAuthenticate($authenticates) {
            $this->auth = $authenticates;
            $this->page->Authenticate($authenticates);
        }

        /**
         * Check if user has session secure url. This application can't work with cross session.
         * Every app has unique url and expired with end of session. 
         */
        public function getSesSecurity() {
            $this->page->sesSecure();
        }

 

    //internal functions start
        public function __construct() {
            \SphpBase::page()->appobj = $this;
            $this->page = \SphpBase::page();
            $this->JSServer = \SphpBase::JSServer();
            $this->Client = \SphpBase::sphp_request();
            $this->apppath = \SphpBase::page()->apppath;
            $this->phppath = \SphpBase::sphp_settings()->php_path;
            $this->respath = \SphpBase::sphp_settings()->res_path;
            //$this->mypath = realpath($this->apppath);
            //$ap1 = str_replace('\\', "/", $this->apppath);
            //$ap2 = str_replace('\\', "/", PROJ_PATH);
            $class_info = new \ReflectionClass($this);
            $p1 = \SphpBase::sphp_api()->filepathToRespaths($class_info->getFileName());
            $this->mypath = $p1[1];
            $this->myrespath = $p1[2];
            $this->dbEngine = \SphpBase::dbEngine();
            $this->debug = \SphpBase::debug();
            $frontobj = new FrontFile('<span></span>', true);
            $this->setFrontFile($frontobj);
            $this->mainfrontform = $frontobj;
            $this->showNotFrontFile();
            $this->masterFile = readGlobal("masterf");
            $this->onstart();
        }

        /**
         * Advance function for change the behavior of app
         * @param \Sphp\tools\FrontFile $frontobj
         */
        public function _setup($frontobj) {
            $this->mainfrontform = $frontobj;
            $this->onfrontinit($frontobj);
            //echo $frontobj->filePath . " r ";
// add event handler into components
    //$this->fixCompEventHandlers($frontobj);
        }

        /**
         * Advance function for change the behavior of app
         * @param \Sphp\tools\FrontFile $frontobj
         */
        public function _process($frontobj) {
            $this->onfrontprocess($frontobj);
        }

        /**
         * Advance function for change the behavior of app
         */
        protected function _processEvent() {
            $this->_triggerAppEvent();
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
                $this->showFrontFile();
                $this->JSServer->getAJAX();
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
                \SphpBase::page()->masterfilepath = $this->masterFile;
                $mainfront = $this->mainfrontform;
                $mainfront->blnshowFront = true;
                $dynData = $this->frontform[1];
                $dynData->_run();
                \SphpBase::$dynData = $dynData;
                $this->_render(); 
                includeOnce2($this->masterFile);
            }
        }


        /**
         * Advance function for change the behavior of app
         */
        public function _run() {
            $this->onready();
            $this->onrun();
            $this->_processEvent();
        }

        /**
         * Advance function for change the behavior of app
         */
        protected function _render() {
            $this->onrender();
        }

    }
}
