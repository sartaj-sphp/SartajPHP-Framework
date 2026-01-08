<?php

namespace Sphp\core {

    class SphpPreRunP {

        /**
         * Start Event Handler for prerun.php file. include any library here will be available
         * in whole project 
         */
        public function onstart() {
            
        }

    }

    /**
     * Description of AppLoader
     *
     * @author Sartaj Singh
     */
    class AppLoader {

        /**
         * Advance Function, Internal use
         * @return array
         * @ignore
         */
        public function _load() {
            //$use_session = false;
            if (\SphpBase::sphp_settings()->getUse_session()) {
                //set$_SESSION_name($SESSION_NAME);
                //set$_SESSION_save_path($SESSION_PATH);
                if (\SphpBase::sphp_settings()->session_name != "") {
                    \SphpBase::sphp_session()->setSessionName(\SphpBase::sphp_settings()->session_name);
                }
                if (\SphpBase::sphp_settings()->session_path != "") {
                    \SphpBase::sphp_session()->setSessionSavePath(\SphpBase::sphp_settings()->session_path);
                }
                \SphpBase::sphp_session()->sessionStart();
            }
            return $this->_startApp();
        }

        /**
         * Advance Function, Internal use
         * @return array
         * @ignore
         */
        public function _startApp() {
            extract(getGlobals(), EXTR_REFS);
            includeOnce(PROJ_PATH . "/prerun.php");
            $s1 = new \SphpPreRun();
            $s1->onstart();
            // overwrite prerun in editctrl
            if(\SphpBase::sphp_settings()->blnEditMode){
                if(\SphpBase::sphp_settings()->editCtrl == "") \SphpBase::sphp_settings()->editCtrl = \SphpBase::sphp_settings()->slib_path . "/apps/helper/editctrl.php"; 
                includeOnce(\SphpBase::sphp_settings()->editCtrl);
            }
            $notglobalapp = true;
            $ctrl2 = "";
            $ctrlab = array();
            $masterf = \SphpBase::sphp_api()->getGlobal("masterf");
            // disable run as lib
//        $sphpRunasLib = false;
            if (!\SphpBase::sphp_api()->getGlobal("sphpRunasLib")) {
                // Register App Appgate with app path
                includeOnce2(\SphpBase::sphp_settings()->php_path . "/Score/global/regapp.php");
                //includeOnce2("reg.php");
                if (\SphpBase::sphp_router()->isRegisterCurrentRequest()) {
                    $appAppgate = \SphpBase::sphp_router()->ctrl;
                    $ctrlab = \SphpBase::sphp_router()->getCurrentAppPath();
                    $ctrl2 = $ctrlab[0];
                }
                if (\SphpBase::sphp_settings()->debug_mode) {
                    \SphpBase::debug()->setMsgi("Appgate:-" . \SphpBase::sphp_router()->ctrl . " :Registered Application: " . $ctrl2);
                    \SphpBase::debug()->setMsgi("Action:-" . \SphpBase::sphp_router()->act . " :Event: " . \SphpBase::sphp_router()->sact . " :Event Parameter: " . \SphpBase::sphp_router()->evtp);
                }

                if ($ctrl2 == "") {
                    \SphpBase::sphp_api()->setErr("Application", "Requested Page can not be found in this server!");
                    //$ctrlab = \SphpBase::sphp_api()->getAppPath("error");
                    //$ctrl2 = $ctrlab[0];
                    throw new Exception("Page not found");
                }
                //$appdira = pathinfo($ctrl2);
                //if(stristr($demopath, $ctrl2) === FALSE) {
                if (strpos(" " . $ctrl2, "res/") > 0) {
                    \SphpBase::engine()->setDrespath(\SphpBase::sphp_settings()->getRes_path());
                    \SphpBase::engine()->setDphppath(\SphpBase::sphp_settings()->getPhp_path());
                } else {
                    \SphpBase::engine()->setDrespath(\SphpBase::sphp_settings()->getBase_path());
                    \SphpBase::engine()->setDphppath("");
                    /*
                    if (\isPharApp()) {
                        $apppatha = pathinfo(\PHARAPP . '/' . $ctrl2);
                    } else {
                        $apppatha = pathinfo($ctrl2);
                    }
                     * 
                     */
                }
                
                if (\isPharApp() && strpos($ctrl2,':') === false && $ctrl2[0] != '/' && $ctrl2[0] != '~') {
                    $apppatha = pathinfo(\PHARAPP . '/' . $ctrl2);
                } else {
                    $apppatha = pathinfo($ctrl2);
                }
                $apppatha = pathinfo($ctrl2);
                $apppath = $apppatha["dirname"];
                $ctrl2 = $apppath . '/' . $apppatha["basename"];
                \SphpBase::sphp_api()->setGlobal("apppath", $apppath);
                \SphpBase::page()->apppath = $apppath;
                \SphpBase::page()->appfilepath = $ctrl2;

                if ($apppatha["extension"] == "psp") {
                    $dynDataa2 = new \Sphp\tools\FrontFile($ctrl2);
                    if ($dynDataa2->blncodebehind) {
                        if ($dynDataa2->blnshowFront) {
                            \SphpBase::page()->masterfilepath = $dynDataa2->webapp->getMasterFile();
                            $dynData = $dynDataa2->webapp->getFrontFile();
                            $dynData->_run();
                            setDynData($dynData);
                            \SphpBase::sphp_api()->setGlobal("dynData", $dynData);
                            includeOnce2(\SphpBase::page()->masterfilepath);
                        }
                    } else {
                        \SphpBase::page()->masterfilepath = $masterf;
                        $dynData = $dynDataa2;
                        $dynData->_run();
                        setDynData($dynData);
                        \SphpBase::sphp_api()->setGlobal("dynData", $dynData);
                        includeOnce2($masterf);
                    }
                } else if ($apppatha["extension"] == "app") {
                    includeOnce($ctrl2);
                    //print_r(array_diff($namespaces, $newNamespaces));
                    $clsname = $ctrlab[1] . $apppatha["filename"];
                    $mainclass = new $clsname();
                    $mainclass->_run();
                } else {
                    \SphpBase::sphp_settings()->blnGlobalApp = true;
                    $notglobalapp = false;
//        includeOnce($ctrl2); 
                }
            }
            return array($notglobalapp, $ctrl2);
        }

    }

    /**
     * \Sphp\core\Exception
     */
    class Exception extends \Exception {

        private $lineno = 0;
        private $filen = "";
        
        public function __construct($message="",$code=0,$previous=null,$lineno=0,$filen="") {
            if($previous !== null){
                $message .= $this->combinePrevious($previous);
            }
            $this->lineno = $lineno;
            $this->filen = $filen;
            parent::__construct($message, $code, $previous);
        }
        
        private function combinePrevious($pr1) {
            $str1 = $pr1->getMessage() . " File:- " . $pr1->getFile() .' on line:- '. $pr1->getLine();
            if($pr1->getPrevious() !== null){
                $str1 .= $this->combinePrevious($pr1->getPrevious());
            }
            return $str1;
        }
        /**
         * Get Line Number of Error
         */
        public function getLineNumber() {
            return $this->lineno;
        }

        /**
         * Get File Path where Error trigger
         */
        public function getFilePath() {
            return $this->filen;
        }
        /**
         * Set Line Number of Error
         */
        public function setLineNumber($line) {
            return $this->lineno = $line;
        }

        /**
         * Set File Path where Error trigger
         */
        public function setFilePath($file) {
            return $this->filen = $file;
        }

    }

    class FrontPlace {

        private $aname = '';
        private $sectionname = '';

        /**
         * Create Front Place Object
         * @param string $frontname Unique Name of Front Place
         * @param string $filepath File Path of Front Place
         * @param string $secname Section Name of master file where to display Front PLace
         * @param string $type <p> Type of file using in File Path.
         * $type = FrontFile(*.front) or PHP
         * </p>
         */
        public function __construct($frontname, $filepath, $secname = "left", $type = "FrontFile") {
            SphpBase::sphp_api()->addFrontPlace($frontname, $filepath, $secname, $type);
            $this->aname = $frontname;
            $this->sectionname = $secname;
        }

        /**
         * Run Front Place before processing master file getHeaderHTML() code
         */
        public function run() {
            runFrontPlace($this->aname, $this->sectionname);
        }

        /**
         * Call Render in master file where to display html code
         */
        public function render() {
            renderFrontPlace($this->aname, $this->sectionname);
        }

    }

    /**
     * SphpVersion class
     *
     * This class is parent class of all Components. You can Develop SartajPHP Application with version control
     * of this class or simple use SphpBase::page() to implement page object in any php module.
     * 
     * @author     Sartaj Singh
     * @copyright  2007
     */
    class SphpVersion {

        private $version = 0.0;
        private $min_version_sphp = 0.0;
        private $min_version_php = 0.0;
        private $max_version_sphp = 0.0;
        private $max_version_php = 0.0;

        public function setVersion($val) {
            $this->version = $val;
        }

        public function setMinVersionSphp($val) {
            $this->min_version_sphp = $val;
        }

        public function setMaxVersionSphp($val) {
            $this->max_version_sphp = $val;
        }

        public function setMinVersionPHP($val) {
            $this->min_version_php = $val;
        }

        public function setMaxVersionPHP($val) {
            $this->max_version_php = $val;
        }

        public function getVersion() {
            return $this->version;
        }

        public function getMinVersionSphp() {
            return $this->min_version_sphp;
        }

        public function getMaxVersionSphp() {
            return $this->max_version_sphp;
        }

        public function getMinVersionPHP() {
            return $this->min_version_php;
        }

        public function getMaxVersionPHP() {
            return $this->max_version_php;
        }

    }

}
