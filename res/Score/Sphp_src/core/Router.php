<?php

namespace Sphp\core {

    class Router {

        /** @var string $url_extension extension use in URL default is .html */
        public $url_extension = ".html";

        /** @var string $act Appgate Action */
        public $act = "";

        /** @var string $sact Appgate Event */
        public $sact = "";

        /** @var string $evtp Appgate Event Parameter */
        public $evtp = "";

        /** @var string $ctrl Current Request Appgate */
        public $ctrl = "";

        /** @var string $uri Request URI */
        public $uri = "";
        private $blnrooturi = true;

        /**
         * Advance Function, Internal use
         */
        public function route() {
            if (\SphpBase::$stmycache !== null) {
                $this->url_extension = \SphpBase::$stmycache->url_extension;
                $this->act = \SphpBase::$stmycache->act;
                $this->sact = \SphpBase::$stmycache->sact;
                $this->evtp = \SphpBase::$stmycache->evtp;
                $this->ctrl = \SphpBase::$stmycache->ctrl;
                $this->uri = \SphpBase::$stmycache->uri;
                $this->blnrooturi = \SphpBase::$stmycache->blnrooturi;
            }
        }
        /**
         * Get Current Request Appgate
         * @return string
         */
        public function getCurrentRequest() {
            return $this->ctrl;
        }
        /**
         * Check if any application registered with current request
         * @return boolean
         */
        public function isRegisterCurrentRequest() {
            return \SphpBase::sphp_api()->isRegisterApp($this->ctrl);
        }
        /**
         * Register Current Request with Application
         * @param string $apppath Application file path like apps/index.app
         * @param string $s_namespace Optional Namespace if any
         * @param string $permtitle Title Display in Permission List
         * @param array $permlist Create Permissions List for application
         */
        public function registerCurrentRequest($apppath, $s_namespace = "",$permtitle="",$permlist=null) {
            \SphpBase::sphp_api()->registerApp($this->ctrl, $apppath, $s_namespace,$permtitle,$permlist);
        }
        /**
         * Register Current Request with different Appgate
         * @param string $ctrl <p>
         * registerCurrentAppgate('home')
         * </p>
         */
        public function registerCurrentAppgate($ctrl) {
            $this->ctrl = $ctrl;
        }

        public function isRootURI() {
            if ($this->blnrooturi) {
                return true;
            } else {
                return false;
            }
        }
        /**
         * Get Registered Application FilePath details of Current Request
         * @return array
         */
        public function getCurrentAppPath() {
            return \SphpBase::sphp_api()->getAppPath($this->ctrl);
        }
        /**
         * Get Registered Application FilePath details
         * @param string $ctrl Appgate
         * @return array
         */
        public function getAppPath($ctrla2) {
            return \SphpBase::sphp_api()->getAppPath($ctrla2);
        }
        /**
         * Generate URL for a Appgate
         * @param string $AppgateName Appgate like index
         * @param string $extra <P> Extra query string in URL 
         * $extra = 'test=1&mpid=13'
         * </p>
         * @param string $newbasePath <p> new domain url
         * $newbasePath = 'https://domain.com/test
         * </p>
         * @param boolean $blnSesID Add session id default false
         * @param string $ext change url file extension as app default empty and use html or set in comp file.
         * @param boolean $noncache default false, if true, cache can not save this url in browser or in proxy
         * @return string
         */
        public function getAppURL($AppgateName, $extra = "", $newbasePath = "", $blnSesID = false,$ext='',$noncache=false) {
            if($noncache){
                if($extra == ""){
                    $extra = "nct=" . time();
                }else{
                    $extra .= "&nct=" . time();                    
                }
            }
            if($ext == '') $ext = $this->url_extension;
            $sesID = "";
            $basepath = $basepath2 = $retURL = "";
            //$sesID = \SphpBase::sphp_settings()->session_id; 
            $sesID = \SphpBase::sphp_request()->session("sesID");
            $basepath = \SphpBase::sphp_settings()->base_path;
            if ($newbasePath != "") {
                $basepath2 = $newbasePath;
            } else {
                $basepath2 = $basepath;
            }
            if ($basepath2 != "")
                $basepath2 .= '/';
            $retURL = $basepath2;
            if ($blnSesID) {
                if ($extra != "") {
                    $extra = "&" . $extra;
                }
                return $retURL . $AppgateName . $ext . "?sesID=" . $sesID . $extra;
            } else {
                if ($extra != "") {
                    $extra = "?" . $extra;
                }
                return $retURL . $AppgateName . $ext . $extra;
            }
            return "";
        }
        /**
         * Generate URL for Current Application
         * @param string $extra <P> Extra query string in URL 
         * $extra = 'test=1&mpid=13'
         * </p>
         * @param boolean $blnSesID Add session id default false
         * @param string $ext change url file extension as app default empty and use html or set in comp file.
         * @param boolean $noncache default false, if true, cache can not save this url in browser or in proxy
         * @return string
         */
        public function getthisURL($extra = "", $blnSesID = false,$ext='',$noncache=false) {
            if($noncache){
                if($extra == ""){
                    $extra = "nct=" . time();
                }else{
                    $extra .= "&nct=" . time();                    
                }
            }
            if($ext == '') $ext = $this->url_extension;
            $sesID = "";
            $basepath = $retURL = "";
            //$sesID = \SphpBase::sphp_settings()->session_id; 
            $sesID = \SphpBase::sphp_request()->session("sesID");
            $basepath = \SphpBase::sphp_settings()->base_path;
            if ($basepath != "")
                $basepath .= '/';
            $retURL = $basepath;
            if ($blnSesID) {
                if ($extra != "") {
                    $extra = "&" . $extra;
                }
                return $retURL . $this->ctrl . $ext . "?sesID=" . $sesID . $extra;
            } else {
                if ($extra != "") {
                    $extra = "?" . $extra;
                }
                return $retURL . $this->ctrl . $ext . $extra;
            }
            return "";
        }
        /**
         * Generate Secure Event URL for a Event of Application
         * @param string $eventName <p> Name of Event
         * class index extends Sphp\tools\BasicApp{
         * public function page_event_test($evtp){
         * 
         * }
         * }
         * $eventName = test
         * $AppgateName = index
         * Registered Application = apps/index.app
         * </p>
         * @param string $evtp Event Parameter pass to URL
         * @param string $AppgateName Appgate like index
         * @param string $extra <P> Extra query string in URL 
         * $extra = 'test=1&mpid=13'
         * </p>
         * @param string $newbasePath <p> new domain url
         * $newbasePath = 'https://domain.com/test
         * </p>
         * @param boolean $blnSesID Add session id default false, url expired with session (App can allow expired url)
         * @param string $ext change url file extension as app default empty and use html or set in comp file.
         * @param boolean $noncache default false, if true, cache can not save this url in browser or in proxy
         * @return string
         */
        public function getEventURLSecure($eventName, $evtp = "", $AppgateName = "", $extra = "", $newbasePath = "", $blnSesID = false,$ext='',$noncache=false) {
            if ($evtp != "") {
                $evtp = 'a@'. encryptme('a8b1]' . $evtp, \SphpBase::sphp_settings()->defenckey);
            }
            return $this->getEventURL($eventName, $evtp, $AppgateName, $extra, $newbasePath, $blnSesID, $ext, $noncache);
        }
        
        /**
         * Generate URL for a Event of Application
         * @param string $eventName <p> Name of Event
         * class index extends Sphp\tools\BasicApp{
         * public function page_event_test($evtp){
         * 
         * }
         * }
         * $eventName = test
         * $AppgateName = index
         * Registered Application = apps/index.app
         * </p>
         * @param string $evtp Event Parameter pass to URL
         * @param string $AppgateName Appgate like index
         * @param string $extra <P> Extra query string in URL 
         * $extra = 'test=1&mpid=13'
         * </p>
         * @param string $newbasePath <p> new domain url
         * $newbasePath = 'https://domain.com/test
         * </p>
         * @param boolean $blnSesID Add session id default false, url expired with session (App can allow expired url)
         * @param string $ext change url file extension as app default empty and use html or set in comp file.
         * @param boolean $noncache default false, if true, cache can not save this url in browser or in proxy
         * @return string
         */
        public function getEventURL($eventName, $evtp = "", $AppgateName = "", $extra = "", $newbasePath = "", $blnSesID = false,$ext='',$noncache=false) {
            if($noncache){
                if($extra == ""){
                    $extra = "nct=" . time();
                }else{
                    $extra .= "&nct=" . time();                    
                }
            }
            if($ext == '') $ext = $this->url_extension;
            
            $sesID = "";
            $basepath = $basepath2 = $retURL = "";
            //\SphpBase::sphp_settings()->session_id; not use
            $sesID = \SphpBase::sphp_request()->session("sesID");
            $basepath = \SphpBase::sphp_settings()->base_path;
            $addf = $act = "";
            $request = null;
            $request = \SphpBase::engine()->getRequest();
            if ($newbasePath != "") {
                $basepath2 = $newbasePath;
            } else {
                $basepath2 = $basepath;
            }
            if ($basepath2 != "")
                $basepath2 .= '/';
            if ($AppgateName == "") {
                $AppgateName = $this->ctrl;
            }
            $act = "evt";
            if ($eventName == "view") {
                $act = "view";
            } elseif ($eventName == "delete") {
                $act = "delete";
            }
            if ($act == "evt") {
                if ($eventName != "") {
                    $addf = "-" . $request->getURLSafe($eventName);
                }
            } elseif ($act != "") {
                $addf = "-$act";
            }

            $retURL = $basepath2;
            if ($evtp != "") {
                $addf .= "-" . $request->getURLSafe($evtp);
            }
            if ($blnSesID) {
                if ($extra != "") {
                    $extra = "&" . $extra;
                }
                return $retURL . $AppgateName . $addf . $ext . "?sesID=" . $sesID . $extra ;
            } else {
                if ($extra != "") {
                    $extra = "?" . $extra;
                }
                return $retURL . $AppgateName . $addf . $ext . $extra;
            }
            return "";
        }

        public function __toString() {
            return $this->ctrl;
        }
        /**
         * Advance Function, Internal use
         * @param string $evt
         * @param string $evtp
         */
        public function setEventName($evt, $evtp = "") {
            if ($evt == "view") {
                $this->act = "view";
            } elseif ($evt == "delete") {
                $this->act = "delete";
            } else {
                $this->act = "evt";
                $this->sact = \SphpBase::sphp_api()->getURLSafeRet($evt);
            }
            $this->evtp = \SphpBase::sphp_api()->getURLSafeRet($evtp);
        }

    }

}
