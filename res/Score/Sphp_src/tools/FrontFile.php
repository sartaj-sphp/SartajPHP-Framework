<?php

namespace Sphp\tools {

    /**
     * Description of FrontFile
     *
     * @author Sartaj Singh
     */
    class FrontFile {

        public $data = "";
        public $filePath = "";
        public $fileDir = "";
        public $mypath = "";
        public $myrespath = "";
        public $compList = array();
        public $name = "";
        public $webapp = null;
        /**
        * @var \Sphp\tools\BasicApp
        */
        public $parentapp = null;
        public $metadata = array();
        public $blncodebehind = false;
        public $blncodefront = false;
        public $blnshowFront = true;
        public $webapppath = "";
        public $sjspath = "";
        public $appname = "";
        public $appfilepath = "";
        public $HTMLParser = null;
        public $frontFileTag = "";
        public $frontFileTagE = "";
        public $prefixName = "";
        public $intPHPLevel = 1;
        
        //is js object of front file created, only created if any component use js object
        private $blnjsobject = false;

        
        /**
         * Advance Function
         * Set File Path of FrontFile
         * @param string $filePath
         */
        public function _setFilePath($filePath) {
            $this->filePath = $filePath;
        }
        /**
         * Advance Function
         * Bind with back-end type Application or front-end type application. 
         * Remember BasicApp is front-end application type which
         * can manage more then one front file or run without any front file like in case of API. 
         * Back-end application like WebApp always requires FrontFile
         * for run. Like PSP Application is a back-end application type.
         * @param \Sphp\tools\WebApp $webapp
         */
        public function _setWebapp($webapp) {
            $this->webapp = $webapp;
        }
        /**
         * Advance Function
         * Set bound application file path
         * @param string $webapppath
         */
        public function _setWebapppath($webapppath) {
            $this->webapppath = $webapppath;
        }
        /**
         * Advance Function
         * Set FrontFile can bind with back-end application type
         * @param boolean $blncodebehind True mean, bound with back-end application
         */
        public function _setBlncodebehind($blncodebehind) {
            $this->blncodebehind = $blncodebehind;
        }
        /**
         * Advance Function
         * Set FrontFile can bind with front-end application type
         * @param boolean $blncodebehind True mean, bound with back-end application
         */
        public function _setBlncodefront($blncodefront) {
            $this->blncodefront = $blncodefront;
        }
        /**
         * Advance Function
         * Set Parent App Name
         * @param string $appname
         */
        public function _setAppname($appname) {
            $this->appname = $appname;
        }
        /**
         * Advance Function
         * Add component object in FrontFile
         * @param string $key component name or id in HTML code
         * @param \Sphp\tools\Component $obj
         */
        public function _setComponent($key, $obj) {
            $this->compList[$key] = $obj;
        }
        /**
         * Add FrontFile as JS Variable to store the JS Objects of components.
         * name of frontfile is used as variable name in JS
         */
        public function addAsJSVar() {
            if(! $this->blnjsobject){
                addHeaderJSCode('jsobj' . $this->name, ' var ' . $this->name . ' = new FrontFile();');
                $this->blnjsobject = true;
            }
        }
        
        /**
         * Advance Function
         * Register FrontFile with SphpApi
         */
        private function _registerFrontFile() {
            \SphpBase::sphp_api()->registerFrontFile($this->name, $this);
        }
        private function setPathUrl($path){
            $p1 = \SphpBase::sphp_api()->filepathToRespaths($path);
            $this->mypath = $path; //$p1[1];
            $this->myrespath = $p1[2];
        }
        /**
         * 
         * Advance Function
         * @param string $FrontFilePath File path of FrontFile Or Direct code as string
         * @param boolean $blnStringData Optional Default=false, If true then $FrontFilePath= string code
         * @param \Sphp\tools\BasicApp $backfileobj Optional Default=null, bind application with FrontFile
         * @param string $use_sjs_file Optional Default=false true mean use sjs file bind with front file
         * @param \Sphp\tools\BasicApp $parentappobj Optional Default=null, Parent App of FrontFile
         */
        public function _getFile($FrontFilePath, $blnStringData = false, $backfileobj = null, $use_sjs_file = false, $parentappobj = null) {
            $this->fileDir = PROJ_PATH;
            $this->setPathUrl($this->fileDir);
            if ($FrontFilePath != "") {
                if (!$blnStringData) {
                    $p = pathinfo($FrontFilePath);
                    $this->name = $p["filename"];
                    $this->fileDir = realpath($p["dirname"]); // may be remove in future
                    $this->setPathUrl($this->fileDir);
                    $this->filePath = $FrontFilePath;
                    $this->_registerFrontFile();
                    //addHeaderJSFunction('frontobjfun' . $this->name, 'frontobj["' . $this->name .'"].init = function(){','};');
                    //addHeaderJSFunctionCode('ready','frontobjfuninit' . $this->name, 'frontobj["' . $this->name .'"].init();');
                    //not working
                    //addHeaderJSCode('frontobj' . $this->name, 'frontobj["' . $this->name .'"] = {};');
                    $this->HTMLParser->_setFrontobj($this);
                    if ($parentappobj != null) {
                        $this->parentapp = $parentappobj;
                        $this->parentapp->_registerFront($this);
                    } else if (\SphpBase::page()->appobj != null) {
                        $parentappobj = \SphpBase::page()->appobj;
                        $this->parentapp = $parentappobj;
                        $this->parentapp->_registerFront($this);
                    }
                    if (is_object($backfileobj)) {
                        $this->blncodefront = true;
                        $this->HTMLParser->_setCodebehind($p);
//    $this->appname = $this->HTMLParser->codebehind["filename"];
//    $frontfile = $apppath."fmodule/".$this->HTMLParser->codebehind["filename"].".php";
//    includeOnce($frontfile) ;
                        if ($use_sjs_file) {
                            $this->sjspath = \SphpBase::page()->apppath . "/sjs/" . $this->HTMLParser->codebehind["filename"] . ".sjs";
                        }
//    $this->webapppath = $frontfile;
                        $this->webapp = $backfileobj;
                        $this->parentapp = $backfileobj;
                    }

                    $this->HTMLParser->parseHTMLObj(file_get_contents($FrontFilePath), $this);
// check backcode file and process
                    if ($this->blncodebehind || $this->blncodefront) {
                        $this->blnshowFront = false;
                        $this->webapp->_setup($this);
// process aftercreate event
                        foreach ($this->compList as $key => $value) {
                            $value->_trigger_after_create();
                        }
// process webapp
                        $this->webapp->_process($this);
                    } else {
// process aftercreate event
                        if ($parentappobj != null) {
                            $this->parentapp->_setup($this);
                        }
                        foreach ($this->compList as $key => $value) {
                            $value->_trigger_after_create();
                        }
                        if ($parentappobj != null) {
                            $this->parentapp->_process($this);
                        }
                    }
                } else {
                    $this->filePath = "";
                    if ($parentappobj != null) {
                        $this->parentapp = $parentappobj;
                        $this->parentapp->_registerFront($this);
                    } else if (\SphpBase::page()->appobj != null) {
                        $parentappobj = \SphpBase::page()->appobj;
                        $this->parentapp = $parentappobj;
                        $this->parentapp->_registerFront($this);
                    }
//                registerFrontFile($this->name, $this);
                    $this->HTMLParser->_setFrontobj($this);
                    $this->HTMLParser->parseHTMLObj($FrontFilePath, $this);
                }
            }
        }
        
        //trigger onappevent of all component in front file
        /**
         * Advance Function
         * App Event handler trigger by application. 
         */
        public function _onAppEvent() {
            foreach ($this->compList as $key => $value) {
                $value->_trigger_app_event();
            }
        }
        /**
         * Advance Function
         * Process FrontFile
         * also run and render back-end application if any
         */
        public function _run() {
            if ($this->blncodebehind) {
                $this->webapp->_run();
                $this->webapp->_render();
            }
            $this->data = $this->frontFileTag . $this->HTMLParser->parseHTML() . $this->frontFileTagE;
        }
        /**
         * Advance Function
         * echo FrontFile Front-End code
         */
        public function render() {
            echo $this->data;
        }
        /**
         * Advance Function
         * get FrontFile Front-End code
         * @return string HTML Output
         */
        public function getOutput() {
            return $this->data;
        }
        /**
         * Advance Function
         * Process FrontFile
         */
        public function _runit() {
            $this->data = $this->frontFileTag . $this->HTMLParser->parseHTML() . $this->frontFileTagE;
        }
        /**
         * Advance Function
         * echo FrontFile data
         */
        public function renderit() {
            echo $this->data;
        }

        
        //finish advanced function
        
        
        /**
         * File Path of FrontFile
         * @return string
         */
        public function getFilePath() {
            return $this->filePath;
        }
        /**
         * Get Name(id) of front file
         * @return string
         */
        public function getName() {
            return $this->name;
        }
        /**
         * Get Parent App or Bind App with front file. It return bound app if FrontFile bound with app
         * @return \Sphp\tools\BasicApp
         */
        public function getBindApp() {
            if ($this->webapp !== null) {
                return $this->webapp;
            } else {
                return $this->parentapp;
            }
        }
        /**
         * Get Application that is bound with front file
         * @return \Sphp\tools\WebApp
         */
        public function getWebapp() {
            return $this->webapp;
        }
        /**
         * Get App Path which is bound with this front file
         * @return string
         */
        public function getWebapppath() {
            return $this->webapppath;
        }
        /**
         * Get SJS File Path which is bound with this front file
         * @return string
         */
        public function getSjspath() {
            return $this->sjspath;
        }
        /**
         * Get Parent App Name
         * @return string
         */
        public function getAppname() {
            return $this->appname;
        }
        /**
         * Disable PHP execution set $intPHPLevel=0, Default it is on 3.
         * Enable php execution in front file. 0= no php execution, 
         * 1 = Limited Allowed, 
         * 2 = Full, 3 = Full + pass global variables
         */
        public function disablePHP($level=0) {
            $this->intPHPLevel = $level;
        }
        /**
         * Set SJS file path
         * @param string $webapppath
         */
        public function _setSjspath($sjspath) {
            $this->sjspath = $sjspath;
        }
        /**
         * Enable rendering for front file
         * @param boolean $blnshowFront
         */
        public function setBlnshowFront($blnshowFront) {
            $this->blnshowFront = $blnshowFront;
        }
        /**
         * Check if FrontFile can render
         * @return boolean
         */
        public function getBlnshowFront() {
            return $this->blnshowFront;
        }        
        /**
         * Check if FrontFile is bound with any front-end application type
         * @return boolean
         */
        public function getBlncodefront() {
            return $this->blncodefront;
        }
        /**
         * Check if FrontFile is bound with any back-end application type
         * @return boolean
         */
        public function getBlncodebehind() {
            return $this->blncodebehind;
        }
        /**
         * 
         * @param string $FrontFilePath File path of FrontFile Or Direct code as string
         * @param boolean $blnStringData Optional Default=false, If true then $FrontFilePath= string code
         * @param \Sphp\tools\BasicApp $backfileobj Optional Default=null, bind application with FrontFile
         * @param \Sphp\tools\BasicApp $parentappobj Optional Default=null, Parent App of FrontFile
         * @param boolean $dhtml Optional Default=false, if true then use different frontlate engine
         * @param string $prefixNameadd Optional Default='', prefix for component id
         */
        public function __construct($FrontFilePath, $blnStringData = false, $backfileobj = null, $parentappobj = null, $dhtml = false, $prefixNameadd = "") {
            $sphp_settings = \SphpBase::sphp_settings();
            $this->prefixName = $prefixNameadd;
            /*
              if($sphp_settings->run_mode_not_extension){
              $libpath = $sphp_settings->lib_path ;
              includeOnce($libpath . "/comp/ajax/Ajaxsenddata.php");
              }
             * 
             */

            $this->HTMLParser = new HTMLParser($dhtml);
            $this->_getFile($FrontFilePath, $blnStringData, $backfileobj, false, $parentappobj);
            if (is_object($this->parentapp)) {
                $this->appfilepath = $this->parentapp->apppath;
            } else {
                $this->appfilepath = \SphpBase::page()->apppath;
            }
            if ($sphp_settings->blnEditMode) {
                $ctrlab = \SphpBase::sphp_router()->getCurrentAppPath();
                $appfilepath = $ctrlab[0];
                $ar1 = array();
                $ar1["frontname"] = $this->name;
                $ar1["fronturl"] = \SphpBase::sphp_router()->uri;
                $ar1["frontfname"] = $this->filePath;
                $ar1["frontappname"] = $appfilepath;
                $ar1["frontsjs"] = $this->sjspath;
                /*
                 * in nodetag getAttributesHTML make tag as focusable with tabindex
                 * on compsetup and init_tag function set components properties
                 */
                addHeaderJSFunction("funsfront" . $this->name, "lstfrontfun['funsfront{$this->name}'] = function(){ var sfront{$this->name} = {};", " return sfront{$this->name}; };");
                $this->frontFileTag = '<div id="sfront' . $this->name . '" class="sfront" data-sfront="' . str_replace('"',"&quot;",json_encode($ar1)) . '" >';
                $this->frontFileTagE = '</div>';
            }
        }
        
        /**
         * Execute PHP code in Limited Container. Use only Template Tags ##{ }# or #{ }#
         * @param string $strPHPCode PHP Template code
         * @param \Sphp\tools\Component $compobj default null, Show debug information if Component
         * run code
         * @return string
         */
        public function executePHPCode($strPHPCode,$compobj=null) { 
            return $this->HTMLParser->executePHPCode($strPHPCode, $compobj);
        }
        
        /**
         * Add Meta Data attached to FrontFile
         * @param string $key
         * @param string|array $value
         */
        public function addMetaData($key, $value) {
            $this->metadata[$key] = $value;
        }
        /**
         * Read Meta Data attached with FrontFile
         * @param string $key
         * @return string|array
         */
        public function getMetaData($key) {
            return $this->metadata[$key];
        }
        /**
         * Get Component Object
         * @param string $name
         * @return \Sphp\tools\Component
         */
        public function __get($name) {
            return $this->compList[$name];
        }
        /**
         * Check if Component Exist in FrontFile
         * @param string $key component name or id in HTML code
         * @return boolean
         */
        public function isComponent($key) {
            if (isset($this->compList[$key])) {
                return true;
            } else {
                return false;
            }
        }
        /**
         * Get Component
         * @param string $key component name or id in HTML code
         * @return \Sphp\tools\Component
         */
        public function getComponent($key) {
            return $this->compList[$key];
        }
        /**
         * Get Component if exist
         * @param string $key component name or id in HTML code
         * @return \Sphp\tools\Component|null
         */
        public function getComponentSafe($key) {
            if (isset($this->compList[$key])) {
                return $this->compList[$key];
            } else {
                return null;
            }
        }
        /**
         * Generate HTML for Component Object
         * $frontobj = new Sphp\tools\FrontFile("apps/forms/front1.front");
         * $div1 = $frontobj->getComponent('div1');
         * echo $frontobj->parseComponent($div1);
         * @param \Sphp\tools\Component $obj
         * @param boolean $innerHTML Optional Default=false, 
         * if true then it will not generate component tag in html
         * @return string
         */
        public function parseComponent($obj,$innerHTML = false) {
            return $this->HTMLParser->parseComponent($obj,$innerHTML);
        }
        /**
         * Wrap All Children of Component as Node Object.
         * $frontobj = new Sphp\tools\FrontFile("apps/forms/front1.front");
         * $div1 = $frontobj->getComponent('div1');
         * $node1 = $frontobj->getChildrenWrapper($div1);
         * echo $frontobj->parseComponentChildren($node1);
         * @param \Sphp\tools\Component $obj
         * @return Sphp\tools\NodeTag
         */
        public function getChildrenWrapper($compobj) {
            return $this->HTMLParser->getChildrenWrapper($compobj);
        }
        /**
         * Generate HTML for Component Children
         * @param \Sphp\tools\NodeTag $obj
         * @return string
         */
        public function parseComponentChildren($obj) {
            return $this->HTMLParser->parseComponentChildren($obj);
        }

    }

    class FrontFileChild extends FrontFile {

        public function __construct($FrontFilePath, $blnStringData = false, $backfileobj = null, $parentfront = null, $dhtml = false, $prefixNameadd = "") {
            if ($parentfront != null) {
                $this->metadata = $parentfront->metadata;
                $this->compList = $parentfront->compList;
                parent::__construct($FrontFilePath, $blnStringData, $backfileobj, $parentfront->parentapp, $dhtml, $prefixNameadd);
            } else {
                parent::__construct($FrontFilePath, $blnStringData, $backfileobj, null, $dhtml, $prefixNameadd);
            }
        }

    }

    class FrontFileComp extends FrontFile {

        public function __construct($FrontFilePath, $blnStringData = false, $parentapp = null, $noprefix = false) {
            if (!$noprefix) {
                $parentapp->nameprefix = $parentapp->parentComponent->name;
                parent::__construct($FrontFilePath, $blnStringData, null, $parentapp, false, $parentapp->parentComponent->name);
            } else {
                parent::__construct($FrontFilePath, $blnStringData, null, $parentapp);
            }
        }

    }
    


}
