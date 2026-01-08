<?php

namespace Sphp\core {

    final class SphpAPI {

        private $cacheFileList = null;
        private $Appgate = null;
        // Error manipulation variables
        public $errStatus = false;
        private $errMsg = null;
        private $msgA = null;
        private $errMsgInner = null;
        // collection of Components for html parser
        private $Components = null;
        // collection of Component for database operation for Component class
        private $Components2 = null;
        // the below variables are used for generate html output
        // collection of header file links in html
        private $fileLinks = null;
        // file versions
        private $fileversions = null;
        // collection of js code in html
        private $headerJSFun = null;
        private $headerJSFunCode = null;
        private $headerJSCode = null;
        private $headerCSS = null;
        private $footerJSFun = null;
        private $footerJSFunCode = null;
        private $footerJSCode = null;
        private $frontPlaces = null;
        private $lstMenu = null;
        private $lstMenuLink = null;
        private $lstMenuBan = null;
        private $lstMenuLinkBan = null;
        private $lst_frontfile = null;
        private $lst_propbag = null;
        private static $defertoval = array('','async','defer');

        /**
         * Advance function, Internal use
         * @ignore
         */
        public function __construct() {
            $this->cacheFileList = \SphpBase::$cacheFileList;
            $this->Appgate = array();
            $this->init();
        }

        /**
         * Advance function, Internal use
         * @ignore
         */
        public function init() {
            $this->errStatus = false;
            $this->errMsg = array();
            $this->msgA = array();
            $this->errMsgInner = array();
            $this->Components = array();
            $this->Components2 = array();
            $this->lst_frontfile = array();
            $this->lst_propbag = array();
            $this->fileversions = array();
            // the below variables are used for generate html output
            // collection of header file links in html
            $this->fileLinks["global"] = array();
            $this->fileLinks["private"] = array();
            // collection of js code in html
            $this->headerJSFun["global"] = array();
            $this->headerJSFun["private"] = array();
            $this->headerJSFunCode["global"] = array();
            $this->headerJSFunCode["private"] = array();
            $this->headerJSCode["global"] = array();
            $this->headerJSCode["private"] = array();
            $this->headerCSS["global"] = array();
            $this->headerCSS["private"] = array();
            $this->footerJSFun["global"] = array();
            $this->footerJSFun["private"] = array();
            $this->footerJSFunCode = array();
            $this->footerJSCode["global"] = array();
            $this->footerJSCode["private"] = array();
            $this->frontPlaces = array();
            $this->lstMenu = array();
            $this->lstMenuLink = array();
            $this->lstMenuBan = array();
            $this->lstMenuLinkBan = array();
        }

        /**
         * Register FrontFile
         * @param string $key name of frontfile
         * @param \Sphp\tools\FrontFile $obj FrontFile Object
         */
        public function registerFrontFile($key, $obj) {
            $this->lst_frontfile[md5($key)] = $obj;
        }

        /**
         * Add Property into property bag. It is good to use, rather then global variables
         * @param string $name Name for identification
         * @param mixed $obj Any valid PHP Object or Data Type
         */
        public function addProp($name, $obj) {
            $this->lst_propbag[$name] = $obj;
        }

        /**
         * Read proprty from property bag
         * @param string $name Name for identification
         * @return string|mixed
         */
        public function getProp($name) {
            if (isset($this->lst_propbag[$name])) {
                return $this->lst_propbag[$name];
            } else {
                return "";
            }
        }

        /**
         * Advance Function, Internal use
         * Add Component 
         * @param string $comp Name for identification
         * @param \Sphp\tools\Component $obj Component Object
         */
        public function addComponent($comp, $obj) {
            $this->Components[md5($comp)] = $obj;
        }

        /**
         * Advance Function, Internal use
         * Add Component for Database bound
         * @param string $frontname frontfile name for identification as key
         * @param string $comp Name for identification as key
         * @param \Sphp\tools\Component $obj Component Object
         */
        public function addComponentDB($frontname, $comp, $obj) {
            $this->Components2[$frontname][$comp] = $obj;
        }

        /**
         * Advance Function, Internal use
         * Get Components List for Database bound
         * @return \Sphp\tools\Component
         */
        public function getComponentsDB() {
            return $this->Components2;
        }

        /**
         * Get Component if exist in List
         * @param string $comp Component Name for identification
         * @return \Sphp\tools\Component|null
         */
        public function isComponent($comp) {
            if (isset($this->Components[md5($comp)])) {
                return $this->Components[md5($comp)];
            } else {
                return null;
            }
        }

        /**
         * Add menu in menu list <p>
         * SphpBase::sphp_api()->addMenu("Live Chat",getEventURL("page","chat","index"),"fa fa-commenting","root",false,"index-chat-view");
         * SphpBase::sphp_api()->addMenu("Debug", "","fa fa-home","root");
         * SphpBase::sphp_api()->addMenuLink("Debug", 'javascript: debugApp();',"","Debug",true,"","f7");
         * These all features are depend on renderer, customize renderer may be not support all fetaures.
         * </p>
         * @param string $text name of menu
         * @param string $link Optional URL show in html tag
         * @param string $icon Optional CSS class of icon
         * @param string $parent Optional parent name for menu as sub menu, default is root
         * @param boolean $ajax Optional if true then use AJAX request
         * @param string $roles Optional <p>
         * comma separated list for user Authentication types or permissions, if match then menu display in HTML code 
         * </p>
         * @param string $akey Optional keyboard shortcut <p>
         * SphpBase::sphp_api()->addMenuLink("Debug", 'javascript: debugApp();',"","Debug",true,"","f7");
         * f7 is keyboard shortcut. v,alt+shift = press v + alt + shift key
         * </p>
         * @param array $settings Optional <p>
         * Extra data pass to renderer as associative array
         * </p>
         */
        public function addMenu($text, $link = "", $icon = "", $parent = "root", $ajax = false, $roles = "", $akey = "", $settings = null) {
            if (!isset($this->lstMenuBan[md5($parent)][md5($text)])) {
                $this->lstMenu[md5($parent)][md5($text)] = array($text, $link, $icon, $ajax, $roles, $akey, $settings);
            }
        }

        /**
         * Add menu link in menu <p>
         * SphpBase::sphp_api()->addMenu("Live Chat",getEventURL("page","chat","index"),"fa fa-commenting","root",false,"index-chat-view");
         * SphpBase::sphp_api()->addMenu("Debug", "","fa fa-home","root");
         * SphpBase::sphp_api()->addMenuLink("Debug", 'javascript: debugApp();',"","Debug",true,"","f7");
         * These all features are depend on renderer, customize renderer may be not support all fetaures.
         * </p>
         * @param string $text name of menulink
         * @param string $link Optional URL show in html tag
         * @param string $icon Optional CSS class of icon
         * @param string $parent Optional parent name for menulink, default is root
         * @param boolean $ajax Optional if true then use AJAX request
         * @param string $roles Optional <p>
         * comma separtaed list for user Authentication types or permissions, if match then menulink display in HTML code 
         * </p>
         * @param string $akey Optional keyboard shortcut <p>
         * SphpBase::sphp_api()->addMenuLink("Debug", 'javascript: debugApp();',"","Debug",true,"","f7");
         * f7 is keyboard shortcut. v,alt+shift = press v + alt + shift key
         * </p>
         * @param array $settings Optional <p>
         * Extra data pass to renderer as associative array
         * </p>
         */
        public function addMenuLink($text, $link = "", $icon = "", $parent = "root", $ajax = false, $roles = "", $akey = "", $settings = null) {
            if (!isset($this->lstMenuLinkBan[md5($parent)][md5($text)])) {
                $this->lstMenuLink[md5($parent)][md5($text)] = array($text, $link, $icon, $ajax, $roles, $akey, $settings);
            }
        }

        /**
         * Ban Menu from list, it will not display
         * @param string $text menu name
         * @param string $parent Optional menu parent
         */
        public function banMenu($text, $parent = "root") {
            if (isset($this->lstMenu[md5($parent)][md5($text)])) {
                unset($this->lstMenu[md5($parent)][md5($text)]);
            }
            $this->lstMenuBan[md5($parent)][md5($text)] = true;
        }

        /**
         * Ban Menulink from list, it will not display
         * @param string $text menu name
         * @param string $parent Optional menu parent
         */
        public function banMenuLink($text, $parent = "root") {
            if (isset($this->lstMenuLink[md5($parent)][md5($text)])) {
                unset($this->lstMenuLink[md5($parent)][md5($text)]);
            }
            $this->lstMenuLinkBan[md5($parent)][md5($text)] = true;
        }

        /**
         * Get All Menu List from parent menu
         * @param string $parent Optional menu parent
         * @return array|null
         */
        public function getMenuList($parent = "root") {
            if (isset($this->lstMenu[md5($parent)])) {
                return $this->lstMenu[md5($parent)];
            } else {
                return null;
            }
        }

        /**
         * Get All Menulink List from parent menu
         * @param string $parent Optional menu parent
         * @return array|null
         */
        public function getMenuLinkList($parent = "root") {
            if (isset($this->lstMenuLink[md5($parent)])) {
                return $this->lstMenuLink[md5($parent)];
            } else {
                return null;
            }
        }

        /**
         * Cache a request URL if it doesn't need processing.
         * SphpBase::sphp_api()->addCacheList("index",100)
         * Cache index application with all events and refersh interval is 100 seconds. Cache will update the index app with
         * interval of 100 seconds.
         * @param string $url match for cache like cache "index" or "index-page"
         * @param int $sec Expiry Time in seconds -1 mean never expire
         * @param string $type <p>
         * type = Default Appgate mean url has Appgate name only and response to all events basis on this Appgate
         * type = ce mean Appgate-event cache only that event
         * type = cep mean Appgate-event-evtp cache only that event with that parameter
         * type = e event on any application will be use cache
         * </p>
         */
        public function addCacheList($url, $sec = 0, $type = "Appgate") {
            if ($sec == 0) {
                $sec = \SphpBase::sphp_settings()->maxtime;
            }
            $md5url = md5($url);
            $this->cacheFileList[$md5url] = array($sec, $type);
        }

        /**
         * Check if URL register with cache list
         * @param string $url
         * @return boolean
         */
        public function isRegisterCacheItem($url) {
            $md5url = md5($url);
            if (isset($this->cacheFileList[$md5url])) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Read Cache Item from Cache List
         * @param string $url
         * @return array
         */
        public function getCacheItem($url) {
            $md5url = md5($url);
            return $this->cacheFileList[$md5url];
        }

        /**
         * Register Application with an Appgate
         * @param string $ctrl Name of Appgate assigned to application
         * @param string $apppath <p>
         * Attach application path. 
         * Path end with .php is module application 
         * and path end with .app is class application. 
         * Filename should match with class name
         * </p>
         * @param string $s_namespace if class application is under a name space
         * @param string $permtitle Title Display in Permission List
         * @param array $permlist Create Permissions List for application
         */
        public function registerApp($ctrl, $apppath, $s_namespace = "",$permtitle="",$permlist=null) {
            //if(realpath($apppath) == "") $apppath = PROJ_PATH . '/' . $apppath;
            $this->Appgate[$ctrl] = array($apppath, $s_namespace,$permtitle,$permlist);
        }

        /**
         * Check application is registered
         * @param string $ctrl
         * @return boolean
         */
        public function isRegisterApp($ctrl) {
            if (isset($this->Appgate[$ctrl])) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Get Application Details that is registered with Appgate name $ctrl 
         * @param string $ctrl
         * @return array
         */
        public function getAppPath($ctrl) {
            return $this->Appgate[$ctrl];
        }

        /**
         * Get List of Registered Applications 
         * @return array
         */
        public function getRegisteredApps() {
            return $this->Appgate;
        }
        
        /**
         * Get Appgate name that has matched apppath with $appfilepath
         * @param string $appfilepath
         * @return string|null
         */
        public function getAppCtrl($appfilepath) {
            foreach ($this->Appgate as $ctrl => $filepath) {
                if ($appfilepath == $filepath[0]) {
                    return $ctrl;
                }
            }
            return null;
        }

        /**
         * Get Root folder path of a path. 
         * It may be inside res folder or project folder.
         * Return SphpBase::sphp_settings()->php_path or PROJ_PATH
         * @param string $val path to check
         * @return string
         */
        public function getRootPath($val) {
            if (strpos(" " . $val, "res/") > 0 || strpos(" " . $val, "res\\") > 0) {
                return \SphpBase::sphp_settings()->php_path;
            } else {
                return PROJ_PATH;
            }
        }

        /**
         * Convert URL to local server filepath 
         * $a = SphpBase::sphp_api->respathToFilepath("../res/jslib/twitter/bootstarp4/main.css")
         * @param string $fileurl
         * @return array pathinfo,directory,url path,filepath
         */
        public function respathToFilepath($fileurl) {
            $fileurl = str_replace("\\", "/", $fileurl);
            $filepath = "";
            $filerespath = "";
            $patha = array();
            $filedir = ""; 
            // replace if url has start with http and from same domain
            $fileurl = str_replace(\SphpBase::sphp_settings()->base_path, "", $fileurl);
            // check if another domain or url type on same app
            if(strpos($fileurl,'://') !== false){
                // if outside url find, then no work
                $f3 = explode('/', $fileurl);
                // remove http and domain
                unset($f3[0]);
                unset($f3[1]);
                unset($f3[2]);
                $fileurl = '/' . implode('/', $f3); 
            }
            
            // convert url into path
            $fileurl2 = realpath($fileurl);
            if($fileurl2){
               $fileurl = str_replace("\\","/",$fileurl2); 
            }else{
                // absolute path is not in current directory try to guess res folder path and use phppath
                $f1 = strpos($fileurl, "res/");
                if ($f1 !== false) {
                    $fileurl = \SphpBase::sphp_settings()->php_path . substr($fileurl,$f1+3);
                }                
            }
            
            $filepath = $fileurl;
            $f1 = strpos($fileurl, "res/");
            if ($f1 !== false) {
                $filerespath = substr($fileurl,$f1+3);
                //$filepath = \SphpBase::sphp_settings()->php_path . $filerespath;
            }else{
                $filerespath = $fileurl;
                $f2 = strpos($fileurl, PROJ_PATH);
                if ($f2 !== false) {
                    $filerespath = substr($fileurl,$f2 + strlen(PROJ_PATH));
                    //$filerespath = str_replace(PROJ_PATH, "", $fileurl);
                }
            }
             
            $patha = pathinfo($filerespath);
            $filedir = $patha["dirname"];
            return array($patha, $filedir, $filerespath, $filepath);
        }
        
        /**
         * Convert filepath to URL path for browser
         * $a = SphpBase::sphp_api->filepathToRespaths("apps/chat/index.app")
         * @param string $filepath
         * @return array pathinfo,directory,url path,filepath
         */
        public function filepathToRespaths($filepath) {
            $scriptPath = \SphpBase::sphp_request()->scriptpath;
            $phppath = \SphpBase::sphp_settings()->php_path;
            $respath = \SphpBase::sphp_settings()->res_path;
            $filepath = str_replace("\\", "/", $filepath);
            //$filepath = str_replace("phar://", "", $filepath);
            $patha = pathinfo($filepath);
            $filedir = $patha["dirname"];
            $filerespath = $filedir;

            $srvpath = \SphpBase::sphp_request()->server("DOCUMENT_ROOT");
            if($srvpath == ''){
                $srvpath = PROJ_PATH;
            }
            $srvpath = str_replace("\\", "/", $srvpath);
            $filerespath = str_replace($srvpath . "/", "", $filerespath);
            $filerespath = str_replace($srvpath, "", $filerespath);
            
            if ($scriptPath != "/") {
                $URI = substr($scriptPath, 1);
                $filerespath = str_replace($URI, "", $filerespath);
            }

            $start = strpos(" $filerespath", "res/");
            if ($start !== false) {
                $filerespath = $respath . '/' . substr($filerespath, $start + 3);
            }
            /*
              $filerespath = str_replace("phar://", "", $filerespath);
              if(strpos($filedir,"phar://") !== false){
              $filedir = str_replace("phar://","",$filedir);
              if($filedir[0] == '/') {
              $filedir = "phar://" . $filedir;
              }else{
              $filedir = "phar://" . $srvpath . '/' . $filedir;
              }
              }
             *
             */
            return array($patha, $filedir, $filerespath, $filepath);
        }

        /**
         * Run Class type Application
         * @param string $path
         */
        public function runApp($path) {
            $formname = pathinfo($path, PATHINFO_FILENAME);
            includeOnce($path);
            $app = new $formname();
            $app->_run();
        }

        /**
         * Create Application object from $path as filepath
         * @param string $path
         * @return \Sphp\core\formname
         */
        public function getAppObject($path) {
            $formname = pathinfo($path, PATHINFO_FILENAME);
            includeOnce($path);
            $app = new $formname();
            return $app;
        }

        /**
         * 
         * @param string $filepath App Path
         * @param boolean $setEnv Default true = set apppath variable
         * @return type
         */
        public function getRegisterAppClass($filepath, $setEnv = true) {
            $filepath2 = str_replace(\SphpBase::sphp_settings()->server_path . '/', "", $filepath);
            $ctrlm = $this->getAppCtrl($filepath2);
            if ($ctrlm !== null) {
                $ctrlab = $this->getAppPath($ctrlm);
                $ctrl2 = $ctrlab[0];
            } else {
                $ctrlab[0] = $filepath;
                $ctrl2 = $ctrlab[0];
                $ctrlab[1] = "";
            }
            $apppatha = pathinfo($ctrl2);
            $apppath = $apppatha["dirname"];
            if ($setEnv) {
                $this->setGlobal("apppath", $apppath);
                \SphpBase::page()->apppath = $apppath;
                \SphpBase::page()->appfilepath = $ctrl2;
            }
            //includeOnce($ctrl2); 
            $clsname = $ctrlab[1] . $apppatha["filename"];
            //$app = new $clsname();
            return array($clsname, $ctrl2);
        }

        /**
         * Read Global Variable
         * @param string $varname
         * @return mixed
         */
        public function getGlobal($varname) {
            $rd = "readGlobal";
            return $rd($varname);
        }

        /**
         * Write Global Variable
         * @param string $varname
         * @param mixed $val value to set
         */
        public function setGlobal($varname, $val) {
            $rd = "writeGlobal";
            $rd($varname, $val);
        }

        /**
         * Set Error Status Flag. 
         * @param string $msg No Use
         */
        public function raiseError($msg) {
//    $errPage;
            $this->errStatus = true;
//    includeOnce("errPage");
            //exit();
        }

        /**
         * Print Message with end Line(br) in HTML
         * @param string $str
         */
        public function println($str) {
            echo str . "<br>";
        }

        /**
         * Convert Bool to Int
         * @param boolean $boolean1
         * @return int
         */
        public function boolToInt($boolean1) {
            if ($boolean1) {
                return 1;
            } else {
                return 0;
            }
        }

        /**
         * Convert Bool to Yes,No
         * @param boolean $boolean1
         * @return string
         */
        public function boolToYesNo($boolean1) {
            if ($boolean1) {
                return "yes";
            } else {
                return "no";
            }
        }

        /**
         * Convert Bool to String True,False
         * @param boolean $boolean1
         * @return string
         */
        public function boolToString($boolean1) {
            if ($boolean1) {
                return "True";
            } else {
                return "False";
            }
        }

        /**
         * Convert True,False to Bool
         * @param string $str
         * @return boolean
         */
        public function stringToBool($str) {
            if ($str == "True") {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Search exact match of Needle in array values as case insensitive 
         * @param string $needle
         * @param array $haystack
         * @return boolean
         */
        public function in_arrayi($needle, $haystack) {
            return in_array(strtolower($needle), array_map("strtolower", $haystack));
        }

        /**
         * Search Needle as array match anywhere in haystack as case insensitive 
         * @param string $haystack
         * @param array $needle
         * @return boolean
         */
        public function array_search_str( $haystack,$needle) {
            $haystack = strtolower($haystack);
            foreach (array_map("strtolower", $needle) as $index => $val) { 
                if (strpos($haystack, $val) !== false) { 
                    return true;
                }
            }
            return false;
        }

        /**
         * Search Needle match anywhere in haystack and return line number
         * @param string $haystack
         * @param string $needle
         * @return int line number
         */
        public function find_line_number($haystack,$needle) {
           $content_before_string = strstr($haystack, $needle, true);
           if (false !== $content_before_string) {
               return count(explode(PHP_EOL, $content_before_string));
           }
           return -1;
        }
        
        /**
         * Change Case of Values in array
         * @param array $arr
         * @param string $case1 Default strtolower other value = strtoupper
         * @return array
         */
        public function array_change_val_case($arr, $case1 = "") {
            if ($case1 == "") {
                return array_map("strtolower", $arr);
            } else {
                return array_map("strtoupper", $arr);
            }
        }

        /**
         * Search first match of Needle in array as case insensitive 
         * @param type $needle
         * @param type $haystack
         * @return int|string|false return key
         */
        public function array_search_i($needle, $haystack) {
            return array_search(strtolower($needle), array_map("strtolower", $haystack));
        }

        /**
         * Return IP Value of Client
         * @return String <br>
         * @author Sartaj Singh 
         *
         */
        public function getIP() {
            $ip = "";
            if (getenv("HTTP_CLIENT_IP")) {
                $ip = getenv("HTTP_CLIENT_IP");
            } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
                $ip = getenv("HTTP_X_FORWARDED_FOR");
            } elseif (getenv("REMOTE_ADDR")) {
                $ip = getenv("REMOTE_ADDR");
            } else {
                $ip = "UNKNOWN";
            }
            return $ip;
        }

        /**
         * Return Client Details IP, Request method, url,protocol,referer,browser
         * ret = SphpBase::sphp_api()->getGuestDetails();
         * echo ret["ip"]; <br>
         * echo ret["method"] ;<br>
         * echo  ret["uri"] ;<br>
         * echo ret["protocol"];<br>
         * echo  ret["referer"] ;<br>
         * echo  ret["agent"] ;<br>
         * @author Sartaj Singh 
         * @return array <br>
         *
         */
        public function getGuestDetails() {
            $ret = array();
            $ret["ip"] = getIP();
            $ret["method"] = \SphpBase::sphp_request()->server("REQUEST_METHOD");
            $ret["uri"] = \SphpBase::sphp_request()->server("REQUEST_URI");
            $ret["protocol"] = \SphpBase::sphp_request()->server("SERVER_PROTOCOL");
            $ret["referer"] = \SphpBase::sphp_request()->server("HTTP_REFERER");
            $ret["agent"] = \SphpBase::sphp_request()->server("HTTP_USER_AGENT");
            return ret;
        }

        /**
         * Return Client location: city country
         * echo ipDetail["city"];<br>
         * echo ipDetail["country"];<br>
         * echo ipDetail["country_code"];<br>
         * this function use http://hostip.info/ website api for conversion
         * @author Sartaj Singh 
         * @return array <br>
         *
         */
        public function getIPDetail() {
            $ipAddr = "";
            $match = array();
            $matches = array();
            $cc_match = array();
            $ipAddr = getIP();
            //ipAddr = "12.215.42.19";
            //verify the IP address for the
            if (ip2long($ipAddr) == -1 || ip2long($ipAddr) === false) {
                trigger_error("Invalid IP", E_USER_ERROR);
            }
            $ipDetail = array(); //initialize a blank array
            //get the XML result from hostip.info
            $xml = file_get_contents("http://api.hostip.info/?ip=" . $ipAddr);

            //get the city name inside the node <gml:name> and </gml:name>
            preg_match("@<Hostip>(\s)*<gml:name>(.*?)</gml:name>@si", $xml, $match);

            //assing the city name to the array
            $ipDetail["city"] = $match[2];

            //get the country name inside the node <countryName> and </countryName>
            preg_match("@<countryName>(.*?)</countryName>@si", $xml, $matches);

            //assign the country name to the ipDetail array
            $ipDetail["country"] = $matches[1];

            //get the country name inside the node <countryName> and </countryName>
            preg_match("@<countryAbbrev>(.*?)</countryAbbrev>@si", $xml, $cc_match);
            $ipDetail["country_code"] = $cc_match[1]; //assing the country code to array
            //return the array containing city, country and country code
            return $ipDetail;
        }

        /**
         * Check if string is a number
         * @param string $val
         * @param string $datatype default FLOAT other value is INT
         * @return boolean
         */
        public function is_valid_num($val, $datatype = "FLOAT") {
            $ret = true;
            if ($val != "") {
                if (!is_numeric($val)) {
                    $ret = false;
                } else {
                    switch ($datatype) {
                        case "INT": {
                                if (strpos($val, ".") > 0) {
                                    $ret = false;
                                }
                                break;
                            }
                    }
                }
            }
            return $ret;
        }

        public function getEngine() {
            return \SphpBase::engine();
        }

        /**
         * Check valid email format
         * @param string $email
         * @return boolean
         */
        public function is_valid_email($email) {
            if (preg_match("/[-a-zA-Z0-9_.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/", $email) > 0) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Generate JS Array code for PHP Array
         * @param string $jsVarName JS Array variable name in code
         * @param array $phpArray
         * @return string
         */
        public function getJSArray($jsVarName, $phpArray, $novar=false) {
            $strFront = "[";
            $str1 = '';
            foreach ($phpArray as $kye => $val1) {
                if(is_array($val1)){
                    $val2 = next($val1);
                    $kye2 = key($val1);
                    if(is_string($kye2)){
                        $strFront .= $str1 . $this->getJSArrayAss($jsVarName, $val1,true);
                    }else{
                        $strFront .= $str1 . $this->getJSArray($jsVarName, $val1,true);                        
                    }               
                }else{
                $strFront .= $str1 . '"' . $val1 . '"';
                }
                $str1 = ',';
            }
            $strFront .= "]";
            if(! $novar) return "var " . $jsVarName . " = $strFront ;";
            return $strFront;
        }
        
        /**
         * Generate JS Associative Array code for PHP Array
         * @param string $jsVarName JS Associative Array variable name in code
         * @param array $phpArray
         * @return string
         */
        public function getJSArrayAss($jsVarName, $phpArray, $novar=false) {
            $strFront = "{";
            $str1 = '';
            foreach ($phpArray as $kye => $val1) {
                if(is_array($val1)){
                    $val2 = next($val1);
                    $kye2 = key($val1);
                    if(is_string($kye2)){
                        $strFront .= $str1 . $this->getJSArrayAss($jsVarName, $val1,true);
                    }else{
                        $strFront .= $str1 . $this->getJSArray($jsVarName, $val1,true);                        
                    }               
                }else{
                $strFront .= $str1 .'"' . $kye . '": "' . $val1 . '"';
                }
                $str1 = ',';
            }
            $strFront .= "}";
            if(! $novar) return "var " . $jsVarName . " = $strFront ;";
            return $strFront;
        }

        /**
         * Convert HTML string into JS string
         * @param string $strHTML
         * @return string
         */
        public function HTMLToJS($strHTML) {
            $para = "/(" . RLINE . NEWLINE . ")+|(" . NEWLINE . "|" . RLINE . ")+/";
            $strHTML = preg_replace($para, "", $strHTML);
            return $strHTML;
        }

        /**
         * Get SartajPHP Version
         * @return String
         */
        public function getSartajPHP() {
            return "<a href='http://www/sartajphp.com/'>SartajPHP 5.x.x Open</a>";
        }

        public function getSartajPHPVer() {
            return "5.0.0";
        }

        public function setServLanguage($val) {
            \SphpBase::sphp_settings()->setServ_language($val);
        }

        public function getServLanguage() {
            return \SphpBase::sphp_settings()->setServ_language();
        }

        public function isDebugMode() {
            return \SphpBase::sphp_settings()->getDebug_mode();
        }

        /**
         * Get string from php content
         * @param string $filepath filepath or string
         * @param object $caller variable pass as object or array to use inside content as $caller->myprop
         * @param bool $stringpass $filepath as string
         * @return string
         */
        public function getDynamicContent($filepath,$caller=null,$stringpass=false) {
            $seval1 = new \SEval();
            if($caller == null) $caller = $this;
            if($stringpass){
                $strPHPCode = $filepath;
            }else{
                $strPHPCode = file_get_contents($filepath);
            }
            try {
                $this->seval1->setMainObject($caller);
                $this->seval1->setObject('$sphp_settings', \SphpBase::sphp_settings());
                return $this->seval1->process($strPHPCode);
            }catch(\Sphp\core\Exception $e){
                $e2 = new \Sphp\core\Exception($e->getMessage(),$e->getCode(),$e,$e->getLineNumber(),$filepath);
                //$e2->setLineNumber($linenum);
               // $e2->setFilePath($errfile);
                \SphpBase::debug()->Sphp_exception_handler($e2);
                return "";
            }
        }

        /**
         * Minify PHP code string
         * @param string $filedata
         * @return string
         */
        public function minifyPHP($filedata) {
            $minifier = new \PhpMinifier();
            return $minifier->Minify($filedata);
        }

        /**
         * Minify CSS code string
         * @param string $filedata
         * @return string
         */
        public function minifyCSS($filedata) {
            $minifier = new \CssMinifier();
            return $minifier->Minify($filedata);
        }

        /**
         * Minify HTML code string
         * @param string $filedata
         * @return string
         */
        public function minifyHTML($filedata) {
            $minifier = new \HtmlMinifier();
            return $minifier->Minify($filedata);
        }

        /**
         * Minify JS code string
         * @param string $filedata
         * @return string
         */
        public function minifyJS($filedata) {
            $minifier = new \JavascriptMinifier();
            return $minifier->Minify($filedata);
        }

        /**
         * Safe write file
         * @param string $filepath file path
         * @param string|mixed $data content to write in file
         * @return int| Exception
         */
        public function safeWriteFile($filepath, $data) {
            if (!file_exists($filepath) || is_writable($filepath)) {
                file_put_contents($filepath, $data);
            } else {
                throw new Exception("Permission Error:- " . `whoami` . " Couldn't write " . $filepath);
            }
        }

        /**
         * Trigger Error
         * SphpBase::sphp_api()->triggerError("Couldn't get any result from database", E_USER_NOTICE,debug_backtrace())
         * @param type $msg Error Message
         * @param type $errType Default E_USER_NOTICE
         * @param array $debug_array 
         */
        public function triggerError($msg, $errType, $debug_array) {
            $caller = next($debug_array);
            $msgfull = $msg . " in <strong>" . $caller["function"] . "</strong> called from <strong>" . $caller["file"] . "</strong> on line <strong>" . $caller["line"] . "</strong>";
            trigger_error($msgfull, $errType);
        }

        /**
         * Advance Function, Internal use
         * @param boolean $renderonce Default false
         * @return string
         */
        public function getrenderType($renderonce = false) {
            $rendertype = "private";
            if ($renderonce) {
                $rendertype = "global";
            }
            return $rendertype;
        }

        /**
         * Add CSS, JS File Link for browser 
         * SphpBase::sphp_api()->addFileLink("front/default/theme-black.css",true,"","","2.7")
         * SphpBase::sphp_api()->addFileLink("front/default/theme-black.js",false,"black1","js","2.7")
         * @param string $fileURL URL for file
         * @param boolean $renderonce Optional default false if true then file ignore in AJAX request
         * @param string $filename Optional file identification key. default=filename in fileurl
         * @param string $ext Optional default=file extension in fileurl
         * @param string $ver Optional default=0 file version if any
         * @param array $assets path for asset folders to copy with this file when distribute
         * @param int $async Default=global file setting, 2=defer, 1= async and 0=default
         */
        public function addFileLink($fileURL, $renderonce = false, $filename = "", $ext = "", $ver = "0",$assets=array(),$async=0) {
            $rendertype = $this->getrenderType($renderonce);
            $filep = pathinfo($fileURL);
            if ($filename == "") {
                $filename = $filep["filename"];
            }
            if ($ext == "") {
                $ext = strtolower($filep["extension"]);
            }
            if (!$this->issetFileLink($filename, $ext, $rendertype)) {
                $this->fileLinks[$rendertype][$ext][$filename] = array($fileURL, $ver,$assets,$async);
            }
        }

        /**
         * Update CSS, JS File Link for browser 
         * SphpBase::sphp_api()->updateFileLink("front/default/theme-black2.js",false,"black1","js","2.8")
         * @param string $fileURL URL for file
         * @param boolean $renderonce Optional default false if true then file ignore in AJAX request
         * @param string $filename Optional file identification key. default=filename in fileurl
         * @param string $ext Optional default=file extension in fileurl
         * @param string $ver Optional default=0 file version if any
         * @param array $assets path for asset folders to copy with this file when distribute
         * @param int $async Default=global file setting, 2=defer, 1= async and 0=default
         */
        public function updateFileLink($fileURL, $renderonce = false, $filename = "", $ext = "", $ver = "0",$assets=array(),$async=0) {
            $rendertype = $this->getrenderType($renderonce);
            $filep = pathinfo($fileURL);
            if ($filename == "") {
                $filename = $filep["filename"];
            }
            if ($ext == "") {
                $ext = strtolower($filep["extension"]);
            }
            $this->fileLinks[$rendertype][$ext][$filename] = array($fileURL, $ver, $assets,$async);
        }

        /**
         * Remove CSS, JS File Link for browser 
         * SphpBase::sphp_api()->removeFileLink("front/default/theme-black2.js",false,"black1","js")
         * @param string $fileURL URL for file
         * @param boolean $renderonce Optional default false if true then file ignore in AJAX request
         * @param string $filename Optional file identification key. default=filename in fileurl
         * @param string $ext Optional default=file extension in fileurl
         */
        public function removeFileLink($fileURL, $renderonce = false, $filename = "", $ext = "") {

            $rendertype = $this->getrenderType($renderonce);
            $filep = pathinfo($fileURL);
            if ($filename == "") {
                $filename = $filep["filename"];
            }
            if ($ext == "") {
                $ext = strtolower($filep["extension"]);
            }
            $this->fileLinks[$rendertype][$ext][$filename] = "remove";
        }

        /**
         * Insert HTML Tag into header section. 
         * SphpBase::sphp_api()->addFileLinkCode("f1",'<meta name="viewport" content="width=device-width, initial-scale=1" />')
         * @param string $name Name as id
         * @param string $code HTML link tag code
         * @param boolean $renderonce Optional default false, true mean ignore in AJAX request
         */
        public function addFileLinkCode($name, $code, $renderonce = false) {

            $rendertype = $this->getrenderType($renderonce);
            $this->fileLinks[$rendertype]["code"][$name] = $code;
        }

        /**
         * Check if filelink is set
         * if(SphpBase::sphp_api()->issetFileLink("black1","js",false)){
         * // add more related files
         * }
         * @param string $filename
         * @param string $ext
         * @param boolean $renderonce Optional default false, true mean ignore in AJAX request
         * @return boolean
         */
        public function issetFileLink($filename, $ext, $renderonce = false) {

            $ext = strtolower($ext);
            $rendertype = $this->getrenderType($renderonce);
            if (isset($this->fileLinks[$rendertype][$ext][$filename])) {
                return true;
            } else {
                return false;
            }
        }
        
        public function getParentDirectory($path) {
            // Detect backslashes
            $convert_backslashes = false;
            $backslash = false;
            if( strstr($path, '\\') ) $backslash = true;
                // Convert backslashes to forward slashes
                $path = str_replace('\\', '/', $path);
                // Add trailing slash if non-existent
                if( substr($path, strlen($path) - 1) != '/' ) $path .= '/';
                // Determine parent path
                $path = substr($path, 0, strlen($path) - 1);
                $path = substr( $path, 0, strrpos($path, '/') ) . '/';
                // Convert backslashes back
                if( !$convert_backslashes && $backslash ) $path = str_replace('/', '\\', $path);
                return $path;
        }
        public function directoriesCreate($dirPath,$mod=0775,$owner=""){
            $ret = false; 
            if(! file_exists($dirPath)){
            $pt = $this->getParentDirectory($dirPath);
            if(file_exists($pt)){
                if(mkdir($dirPath)){
                    chmod($dirPath, $mod);
                }
                $ret = true;
            }else{
                $this->directoriesCreate($pt);        
                if(!file_exists($dirPath) && mkdir($dirPath)){
                    chmod($dirPath, $mod);
                }
                $ret = true;
            }
            return $ret;
            }else{
                return true;
            }
        }
        public function directoryCopy($src,$dst,$fixdst=""){
            $dir = opendir($src);
            if(!file_exists($dst)){
                $this->directoriesCreate($dst);
            }
            while(false !== ( $file = readdir($dir)) ) {
                if (( $file != '.' ) && ( $file != '..' )) {
                    if ( is_dir($src . '/' . $file)) {
                        $this->directoryCopy($src . '/' . $file,$dst . '/' . $file,$fixdst);                    
                    }else {
                        $ndst = $dst;
                        if($fixdst != "") $ndst = $fixdst; 
                        if(! copy($src . '/' . $file,$ndst . '/' . $file)){
                            $this->setErr('dircopy', "Couldn't copy " . $src . '/' . $file);
                        }
                    }
                }
            }
            closedir($dir);
            return true;
        }

        private function distFileLinks($jsfiles, $global, $type,$combine=true,$distpath="cache") {
            $strFile = "";
            foreach ($jsfiles as $key => $val) {
                if ($val !== "remove") { 
                    $filea = $this->respathToFilepath($val[0]); 
                    if($combine){
                        $strFile .= file_get_contents($filea[3]) . ' 
 ';
                        unset($this->fileLinks[$global][$type][$key]);
                    }else{
                    // copy file and assets to dispath
                        $this->directoriesCreate($distpath . $filea[1]);
                        copy($filea[3],$distpath . $filea[2]);
                        $val[0] = $distpath . $filea[2];
                        $this->fileLinks[$global][$type][$key] = $val;
                    } 
                    foreach ($val[2] as $i => $v) { 
                        $filea2 = $this->respathToFilepath($v);
                        $this->directoryCopy($filea2[3], $distpath . $filea2[2]);
                    }
                }
            }
            return $strFile;
        }

        private function removeFileLinks($jsfiles, $global, $type) {
            foreach ($jsfiles as $key => $val) {
                if ($val !== "remove") {
                    unset($this->fileLinks[$global][$type][$key]);
                }
            }
        }

        /**
         * Advance Function
         * Distribute All Global JS Lib (render once=true) JS files. These
         * Files will not load by AJAX.
         * @param boolean $min Optional no use
         * @param boolean $removeonly Optional if true then remove only links
         * @param boolean $combine Optional if true then combine files
         * @param string $distpath Optional Folder Path to copy files Default = cache
         * @return string
         */
        public function getDistGlobalJSFiles($min = false, $removeonly = false,$combine=true,$distpath="cache") {
            $strFile = "";
            if (isset($this->fileLinks["global"]["js"])) {
                $jsfiles = $this->fileLinks["global"]["js"];
                unset($jsfiles["jquery-js-code"]);
                unset($jsfiles["jquery-min"]);
                unset($jsfiles["jquery-min2"]);
                unset($jsfiles["jquery-min1"]);
                unset($jsfiles["jquery-ui"]);
                if ($removeonly) {
                    $this->removeFileLinks($jsfiles, "global", "js");
                } else {
                    $strFile = $this->distFileLinks($jsfiles, "global", "js",$combine,$distpath);
                }
                //file_put_contents("cache/glbl.js", $this->minifyJS($strFile));
                //$this->addFileLink("cache/glbl.js",true);
            }
            return $strFile;
        }

        /**
         * Advance Function
         * Distribute All private files (render once=false) JS files. These
         * Files can also load via AJAX
         * @param boolean $min Optional no use
         * @param boolean $removeonly Optional if true then remove only links
         * @param boolean $combine Optional if true then combine files
         * @param string $distpath Optional Folder Path to copy files Default = cache
         * @return string
         */
        public function getDistJSFiles($min = false, $removeonly = false,$combine=true,$distpath="cache") {
            $strFile = "";
            if (isset($this->fileLinks["private"]["js"])) {
                $jsfiles = $this->fileLinks["private"]["js"];
                if ($removeonly) {
                    $this->removeFileLinks($jsfiles, "private", "js");
                } else {
                    $strFile .= $this->distFileLinks($jsfiles, "private", "js",$combine,$distpath);
                }
                //file_put_contents("cache/pvtl.js", $this->minifyJS($strFile));            
                //$this->addFileLink("cache/pvtl.js");
            }
            return $strFile;
        }
        /**
         * Advance Function
         * Distribute All css files
         * @param boolean $min Optional no use
         * @param boolean $removeonly Optional if true then remove only links no output
         * @param boolean $combine Optional if true then combine files
         * @param string $distpath Optional Folder Path to copy files Default = cache
         * @return string
         */
        public function getDistCSSFiles($min = false, $removeonly = false,$combine=true,$distpath="cache") {
            $strFile = "";
            if (isset($this->fileLinks["global"]["css"])) {
                $cssfiles = $this->fileLinks["global"]["css"];
                if ($removeonly) {
                    $this->removeFileLinks($cssfiles, "global", "css");
                } else {
                    $strFile = $this->distFileLinks($cssfiles, "global", "css",$combine,$distpath);
                }
            }
            if (isset($this->fileLinks["private"]["css"])) {
                $cssfiles = $this->fileLinks["private"]["css"];
                if ($removeonly) {
                    $this->removeFileLinks($cssfiles, "private", "css");
                } else {
                    $strFile .= $this->distFileLinks($cssfiles, "private", "css",$combine,$distpath);
                }
            }
            return $strFile;
        }
        /**
         * Combine All js and css filelinks and create combine file in $parentfolder folder.
         * It also incudes addFileLink code for browser.
         * Combines multiple css files into one may brake relative path. So you also
         * need to copy assets manually into relative path. If
         * you want to leave css links to combine but combine few css files then use combineFiles function to 
         * combine required css files.
         * in Debug mode=2 it create fresh file on every request but in normal mode
         * it checks file exist and create if not exist.
         * @param string $parentfolder Optional Default=front parent folder to save combo files
         * @param boolean $addcss Optional Default=false create css css combo file
         * @param boolean $force_overwrite Optional Default=false create fresh combo files
         * 
         */
        public function getCombineFileLinks($parentfolder = "front",$addcss=false,$force_overwrite=false) {
            $filepath2 =  $parentfolder . "/combo1.css";
            $filepath =  $parentfolder . "/combo1.js";
            $filed = false;
            if(\SphpBase::debug()->debugmode == 2) $force_overwrite = true;
            if(! $force_overwrite) $filed = file_exists($filepath);
            
            $str1 = $this->getDistGlobalJSFiles(false,$filed,true,$parentfolder);
            // private js files, leave because of AJAX auto file load
            $str1 .= $this->getDistJSFiles(false,$filed,true,$parentfolder);
            addFileLink($filepath);
            
            if($addcss){
                $str2 = $this->getDistCSSFiles(false,$filed,true,$parentfolder);
                addFileLink($filepath2);
            }

            if(!$filed){
        //        file_put_contents($filepath, $this->sphp_api->minifyJS($str1 . $jscode));
                file_put_contents($filepath,"// this file is auto generated by SartajPHP \r\n" . $str1);            
                if($addcss){
                    file_put_contents($filepath2,$str2); 
                }
            }
        }
        
        /**
         * Combine All files path into single file as $outputfilepath
         * It willn't incudes addFileLink code for browser. You need to provide browser
         * code if you need to send link to browser.
         * Combines multiple css files into one may brake relative path. So you also
         * need to copy assets manually into relative path. If
         * in Debug mode=2 it create fresh file on every request but in normal mode
         * it checks file exist and create if not exist.
         * @param array $array_list List of files path
         * @param string $outputfilepath Optional Default=front/combo2.css Combine file path
         * @param boolean $force_overwrite Optional Default=false create fresh combo files
         * 
         */
        public function combineFiles($array_list,$outputfilepath = "front/combo2.css",$force_overwrite=false) {
            $str1 = "";
            $filed = false;
            if(\SphpBase::debug()->debugmode == 2) $force_overwrite = true;
            if(! $force_overwrite) $filed = file_exists($outputfilepath);
            foreach ($array_list as $index => $filepath){
                $str1 .= file_get_contents($filepath);
            }
            if(!$filed){
                file_put_contents($outputfilepath,$str1); 
            }
        }
        
        /**
         * Check JS Function Exist in Header Section
         * @param string $funname Function name as id
         * @param string $rendertype default=private other value is global
         * @return boolean
         */
        public function isHeaderJSFunctionExist($funname, $rendertype = "private") {
            if (isset($this->headerJSFun[$rendertype][$funname])) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Check JS Function Exist in Footer Section
         * @param string $funname Function name as id
         * @param string $rendertype default=private other value is global
         * @return boolean
         */
        public function isFooterJSFunctionExist($funname, $rendertype = "private") {
            if (isset($this->footerJSFun[$rendertype][$funname])) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Add JS Function header section. 
         * SphpBase::sphp_api()->addHeaderJSFunction("myfun","function myfun(){var v1 = 12;","}");
         * SphpBase::sphp_api()->addHeaderJSFunctionCode("myfun","code1","console.log(v1);");
         * @param string $funname Function name as id
         * @param string $startcode 
         * @param string $endcode
         * @param boolean $renderonce Optional default false, true mean ignore in AJAX request
         */
        public function addHeaderJSFunction($funname, $startcode, $endcode, $renderonce = false) {
            $rendertype = $this->getrenderType($renderonce);
            $this->headerJSFun[$rendertype][$funname] = array($startcode, $endcode);
            $this->headerJSFunCode[$rendertype][$funname][] = "";
        }

        /**
         * Add JS Function footer section. 
         * SphpBase::sphp_api()->addFooterJSFunction("myfun","function myfun(){var v1 = 12;","}");
         * SphpBase::sphp_api()->addFooterJSFunctionCode("myfun","code1","console.log(v1);");
         * @param string $funname Function name as id
         * @param string $startcode 
         * @param string $endcode
         * @param boolean $renderonce Optional default false, true mean ignore in AJAX request
         */
        public function addFooterJSFunction($funname, $startcode, $endcode, $renderonce = false) {
            $rendertype = $this->getrenderType($renderonce);
            $this->footerJSFun[$rendertype][$funname] = array($startcode, $endcode);
            $this->footerJSFunCode[$rendertype][$funname][] = "";
        }

        /**
         * Insert JS Code into JS Function in header section. 
         * SphpBase::sphp_api()->addHeaderJSFunctionCode("myfun","code1","console.log(v1);");
         * @param string $funname Function name as id
         * @param type $name Code block name as id
         * @param type $code JS code
         * @param boolean $renderonce Optional default false, true mean ignore in AJAX request
         */
        public function addHeaderJSFunctionCode($funname, $name, $code, $renderonce = false) {
            $rendertype = $this->getrenderType($renderonce);
            if ($name != "") {
                $this->headerJSFunCode[$rendertype][$funname][$name] = $code;
            } else {
                $this->headerJSFunCode[$rendertype][$funname][] = $code;
            }
        }

        /**
         * Insert JS Code into JS Function in header section. 
         * SphpBase::sphp_api()->addFooterJSFunctionCode("myfun","code1","console.log(v1);");
         * @param string $funname Function name as id
         * @param type $name Code block name as id
         * @param type $code JS code
         * @param boolean $renderonce Optional default false, true mean ignore in AJAX request
         */
        public function addFooterJSFunctionCode($funname, $name, $code, $renderonce = false) {
            $rendertype = $this->getrenderType($renderonce);
            if ($name != "") {
                $this->footerJSFunCode[$rendertype][$funname][$name] = $code;
            } else {
                $this->footerJSFunCode[$rendertype][$funname][] = $code;
            }
        }

        /**
         * Insert JS Code into header section
         * SphpBase::sphp_api()->addHeaderJSCode("code1","console.log('test js code');");
         * @param type $name Code block name as id
         * @param type $code JS code
         * @param boolean $renderonce Optional default false, true mean ignore in AJAX request
         */
        public function addHeaderJSCode($name, $code, $renderonce = false) {
            $rendertype = $this->getrenderType($renderonce);
            if ($name != "") {
                $this->headerJSCode[$rendertype][$name] = $code;
            } else {
                $this->headerJSCode[$rendertype][] = $code;
            }
        }

        /**
         * Insert CSS Code into header section
         * SphpBase::sphp_api()->addHeaderCSS("code1","p{color: #FF88F6;}");
         * @param type $name Code block name as id
         * @param type $code JS code
         * @param boolean $renderonce Optional default false, true mean ignore in AJAX request
         */
        public function addHeaderCSS($name, $code, $renderonce = false) {
            $rendertype = $this->getrenderType($renderonce);
            if ($name != "") {
                $this->headerCSS[$rendertype][$name] = $code;
            } else {
                $this->headerCSS[$rendertype][] = $code;
            }
        }

        /**
         * Insert JS Code into footer section
         * SphpBase::sphp_api()->addFooterJSCode("code1","console.log('test js code');");
         * @param type $name Code block name as id
         * @param type $code JS code
         * @param boolean $renderonce Optional default false, true mean ignore in AJAX request
         */
        public function addFooterJSCode($name, $code, $renderonce = false) {
            $rendertype = $this->getrenderType($renderonce);
            if ($name != "") {
                $this->footerJSCode[$rendertype][$name] = $code;
            } else {
                $this->footerJSCode[$rendertype][] = $code;
            }
        }
        private function getDeferCode($param) {
            if($param == 0){
                return self::$defertoval[\SphpBase::sphp_settings()->default_filelink_load];
            }else{
                return self::$defertoval[$param];                
            }
        }
        private function getDeferCodeInline() {
            static $deferinline = '';
            if($deferinline != ''){
                return $deferinline;
            }
            switch(\SphpBase::sphp_settings()->default_filelink_load){                
                case 0: {
                    $deferinline = 'type="text/javascript"'; break;
                }default: {
                    $deferinline = 'type="module"'; break;
                }
            }
            return $deferinline;
        }
        private function getJSTopLib($htmltag, $libname = "jquery-min", $strProcess = false, $createJqVar = "") {
            $strout = "";
            if (isset($this->fileLinks["global"]["js"][$libname]) && $this->fileLinks["global"]["js"][$libname] != "remove") {
                if ($htmltag) {
                    if ($createJqVar != "") {
                        $strout .= "<script type=\"text/javascript\" ". $this->getDeferCode($this->fileLinks["global"]["js"][$libname][3]) ." src=\"" . $this->fileLinks["global"]["js"][$libname][0] . "\" ></script>";
                        if($libname == "jquery-min") $strout .= "<script ". $this->getDeferCodeInline() .">window.{$createJqVar} = $.noConflict(true);</script>";
                    } else {
                        $strout .= "<script type=\"text/javascript\" ". $this->getDeferCode($this->fileLinks["global"]["js"][$libname][3]) ." src=\"" . $this->fileLinks["global"]["js"][$libname][0] . "\"></script>";
                    }
                    if ($this->fileLinks["global"]["js"][$libname][1] != "0") {
                        $ver = explode(':', $this->fileLinks["global"]["js"][$libname][1]);
                        $this->fileversions['jquery'] = $ver[1];
                    }
                    $this->fileLinks["global"]["js"][$libname] = "remove";
                } else {
                    $this->fileLinks["global"]["js"][$libname] = "remove";
                    if ($strProcess) {
                        //    addHeaderJSFunction("ready", " strprocess = "", "";") ;
                        //\SphpBase::JSServer()->addJSONBlock("jsp", "proces", " setTimeout(\"sphpjq.globalEval(strprocess);\",300);");
                    }
                }
            }
            return $strout;
        }

        /**
         * Advance Function, Internal use
         * Generate all JS code for Header section
         * @param boolean $htmltag Optional default true generate HTML tags
         * @param boolean $global Optional default true generate render once code also
         * @param int $blockJSCode Optional default 0 block JS code section Other values 1 and 2
         * @return string
         */
        public function getHeaderJS($htmltag = true, $global = true, $blockJSCode = 0) {
            $strout = "";
            $strout2 = "";
            $strflist = "";

            if ($blockJSCode === 0 || $blockJSCode === 1) {
                // fix if script load as module rather then window object
                // use sphp_obj for create js functions or variable as global access
                if ($htmltag) $strout .= "<script ". $this->getDeferCodeInline() .">window['sphp_obj'] = {};if (typeof module === 'object') {window.module = module; module = undefined;}</script>";
                $strout .= $this->getJSTopLib($htmltag, "jquery-min", true, "jql");
                $strout .= $this->getJSTopLib($htmltag, "jquery-min2", false, "jq2");
                $strout .= $this->getJSTopLib($htmltag, "jquery-min1", false, "jq1");
                if (isset($this->fileLinks["global"]["js"]["jquery-js-code"]) && $this->fileLinks["global"]["js"]["jquery-js-code"] != "remove") {
                    if ($htmltag) {
                        $strout .= "<script ". $this->getDeferCodeInline() .">" . $this->fileLinks["global"]["js"]["jquery-js-code"][0] . "</script>";
                    }
                    $this->fileLinks["global"]["js"]["jquery-js-code"] = "remove";
                }
                // crass with bootstrap
                //$strout .= $this->getJSTopLib($htmltag, "jquery-ui");

                if ($global) {
                    if (isset($this->fileLinks["global"]["js"])) {
                        $jsfiles = $this->fileLinks["global"]["js"];
                        foreach ($jsfiles as $key => $val) {
                            if ($val !== "remove") {
                                if ($htmltag) {
                                    $strout .= "<script type=\"text/javascript\" ". $this->getDeferCode($val[3]) ." src=\"" . $val[0] . "\"></script>";
                                    if ($val[1] != "0") {
                                        $ver = explode(':', $val[1]);
                                        $this->fileversions[$ver[0]] = $ver[1];
                                    }
                                    //$strflist .= "'". $val[0] ."',";
                                } else {
                                    //$strout2 .= " $.getScript('$val', public function() {}); ";    
                                    //\SphpBase::JSServer()->addJSONBlock('jsfl','proces'," $.getScript('$val', public function() {});");
                                    //\SphpBase::JSServer()->addJSONBlock('jsfl','proces',"$('head').append('". '<script type="text/javascript" src="'.$val.'"></script>'."');");
                                    $strflist .= "'" . $val[0] . "',";
                                }
                            }
                        }
                    }
                }

                // end fix module
                if ($htmltag) $strout .= "<script ". $this->getDeferCodeInline() .">if (window.module) module = window.module;</script>";

                if (isset($this->fileLinks["private"]["js"])) {
                    $jsfiles = $this->fileLinks["private"]["js"];
                    foreach ($jsfiles as $key => $val) {
                        if ($val !== "remove") {
                            if ($htmltag) {
                                $strout .= "<script type=\"text/javascript\" ". $this->getDeferCode($val[3]) ." src=\"" . $val[0] . "\"></script>";

                                if ($val[1] != "0") {
                                    $ver = explode(':', $val[1]);
                                    $this->fileversions[$ver[0]] = $ver[1];
                                }
                                //$strflist .= "'" . $val[0] ."',";
                            } else {
                                //\SphpBase::JSServer()->addJSONBlock("jsfl","proces"," requireOnceJS("$val");");
                                $strflist .= "'" . $val[0] . "',";
                            }
                        }
                    }
                }

                if ($strflist != "") {
                    $strflist = substr($strflist, 0, strlen($strflist) - 1);
                    \SphpBase::JSServer()->addJSONBlock("jss", "proces", " window['fileList'] = new Array(" . $strflist . ");");
                    \SphpBase::JSServer()->addJSONBlock("jsfl", "jslink", " fdcode");
                    $strflist = "";
                }
            }
            if ($blockJSCode === 0 || $blockJSCode === 2) {
                unset($this->headerJSFun["private"]["ready"]);
                unset($this->headerJSFun["private"]["readyjql"]);
                unset($this->headerJSFun["private"]["readyjq2"]);
                unset($this->headerJSFun["private"]["readyjq1"]);
                if ($global) {
                    if (isset($this->headerJSFunCode["private"]["ready"])) {
                        $redc = $this->headerJSFunCode["private"]["ready"];
                        $this->headerJSFunCode["global"]["ready"] = array_merge($this->headerJSFunCode["global"]["ready"], $redc);
                    }
                    if (isset($this->headerJSFunCode["private"]["readyjql"])) {
                        $redc = $this->headerJSFunCode["private"]["readyjql"];
                        $this->headerJSFunCode["global"]["readyjql"] = array_merge($this->headerJSFunCode["global"]["readyjql"], $redc);
                    }
                    if (isset($this->headerJSFunCode["private"]["readyjq2"])) {
                        $redc = $this->headerJSFunCode["private"]["readyjq2"];
                        if (isset($this->headerJSFunCode["global"]["readyjq2"])) {
                            $this->headerJSFunCode["global"]["readyjq2"] = array_merge($this->headerJSFunCode["global"]["readyjq2"], $redc);
                        } else {
                            $this->headerJSFunCode["global"]["ready"] = array_merge($this->headerJSFunCode["global"]["ready"], $redc);
                        }
                    }
                    if (isset($this->headerJSFunCode["private"]["readyjq1"])) {
                        $redc = $this->headerJSFunCode["private"]["readyjq1"];
                        if (isset($this->headerJSFunCode["global"]["readyjq1"])) {
                            $this->headerJSFunCode["global"]["readyjq1"] = array_merge($this->headerJSFunCode["global"]["readyjq1"], $redc);
                        } else {
                            $this->headerJSFunCode["global"]["ready"] = array_merge($this->headerJSFunCode["global"]["ready"], $redc);
                        }
                    }
                    foreach ($this->headerJSFun["global"] as $key => $val) {
                        $strout2 .= $val[0];
                        if (isset($this->headerJSFunCode["global"][$key])) {
                            foreach ($this->headerJSFunCode["global"][$key] as $key2 => $val2) {
                                $strout2 .= $val2;
                            }
                        }
                        $strout2 .= $val[1];
                    }
                    foreach ($this->headerJSCode["global"] as $key => $val) {
                        $strout2 .= $val;
                    }
                }

                foreach ($this->headerJSFun["private"] as $key => $val) {
                    $strout2 .= $val[0];
                    if (isset($this->headerJSFunCode["private"][$key])) {
                        foreach ($this->headerJSFunCode["private"][$key] as $key2 => $val2) {
                            $strout2 .= $val2;
                        }
                    }
                    $strout2 .= $val[1];
                }

                foreach ($this->headerJSCode["private"] as $key => $val) {
                    $strout2 .= $val;
                }
                if (!$global) {
                    //$strout2 .= " ";
                    $str = "";
                    if (isset($this->headerJSFunCode["private"]["ready"])) {
                        foreach ($this->headerJSFunCode["private"]["ready"] as $key2 => $val2) {
                            $str .= $val2;
                        }
                    }
                    if (isset($this->headerJSFunCode["private"]["readyjql"])) {
                        foreach ($this->headerJSFunCode["private"]["readyjql"] as $key2 => $val2) {
                            $str .= $val2;
                        }
                    }
                    if (isset($this->headerJSFunCode["private"]["readyjq2"])) {
                        foreach ($this->headerJSFunCode["private"]["readyjq2"] as $key2 => $val2) {
                            $str .= $val2;
                        }
                    }
                    if (isset($this->headerJSFunCode["private"]["readyjq1"])) {
                        foreach ($this->headerJSFunCode["private"]["readyjq1"] as $key2 => $val2) {
                            $str .= $val2;
                        }
                    }
                    //$strout2 .= $this->getFilterJSString($str);
                    if (!$htmltag) {
                        $strout2 .= " window['sphpajready1'] = function(){setTimeout(function(){" . $str . " }," . \SphpBase::sphp_settings()->ajaxready_max . "); };";
                    } else {
                        $strout2 .= $str;
                    }
                }

                if ($strout2 != "") {
                    if ($htmltag) {
                        $strout2 .= " window['sphp_versions'] = " . $this->getJSArrayAss("sphp_versions", $this->fileversions,true);
                        if (\SphpBase::sphp_settings()->js_protection) {
                            $strout .= "<script ". $this->getDeferCodeInline() ."> function sphpappw(){ " . $strout2 . " } sphpappw();</script>";
                        } else {
                            $strout .= "<script ". $this->getDeferCodeInline() ."> " . $strout2 . "</script>";
                        }
                    } else {
                        $strout .= $strout2;
                    }
                }
            }
            return $strout;
        }

        /**
         * Filter String as JS String
         * @param string $str
         * @return string
         */
        public function getFilterJSString($str) {
            $str = \SphpBase::JQuery()->stripNewLineChar($str);
            return str_replace("'", "\'", $str);
        }

        /**
         * Advance Function, Internal use
         * Generate all JS code for Footer section
         * @param boolean $htmltag Optional default true generate HTML tags
         * @param boolean $global Optional default true generate render once code also
         * @param int $blockJSCode Optional default 0 block JS code section Other values 1 and 2
         * @return string
         */
        public function getFooterJS($htmltag = true, $global = true, $blockJSCode = 0) {
            $strout2 = "";
            if (\SphpBase::sphp_settings()->debug_mode > 0) {
                \SphpBase::engine()->engine_end_time = microtime(true);
                $extime = (\SphpBase::engine()->engine_end_time - \SphpBase::engine()->engine_start_time) * 1000;
                $extime2 = (\SphpBase::engine()->engine_start_time - \SphpBase::$stmycache->ytetimestart2) * 1000;
                $extime3 = (\SphpBase::engine()->engine_end_time - \SphpBase::$stmycache->ytetimestart1) * 1000;
                //$now = \DateTime::createFromFormat('U.u', \SphpBase::engine()->engine_start_time);
                //$strt = "";
                //if($now){
                //  $strt = " Start:- " . $now->format("H:i:s.u");
                //}
                \SphpBase::debug()->setMsgi("SPHP Time(ms):- " . round($extime, 2) . ", Req Time:- " . round($extime2, 2) . ", TT:- " . round($extime3, 2));
                \SphpBase::debug()->render();
            }
            \SphpBase::debug()->msg = array();
            if ($blockJSCode == 0 || $blockJSCode == 2) {
                if ($global) {
                    foreach ($this->footerJSFun["global"] as $key => $val) {
                        $strout2 .= $val[0];
                        foreach ($this->footerJSFunCode["global"][$key] as $key2 => $val2) {
                            $strout2 .= $val2;
                        }
                        $strout2 .= $val[1];
                    }
                    foreach ($this->footerJSCode["global"] as $key => $val) {
                        $strout2 .= $val;
                    }
                }

                foreach ($this->footerJSFun["private"] as $key => $val) {
                    $strout2 .= $val[0];
                    foreach ($this->footerJSFunCode["private"][$key] as $key2 => $val2) {
                        $strout2 .= $val2;
                    }
                    $strout2 .= $val[1];
                }
                foreach ($this->footerJSCode["private"] as $key => $val) {
                    $strout2 .= $val;
                }

                if ($strout2 != "") {
                    if ($htmltag) {
                        $strout2 = "<script ". $this->getDeferCodeInline() ."> " . $strout2 . " </script>";
                    }
                }
            }

            return $strout2;
        }

        /**
         * Advance Function, Internal use
         * Generate all HTML,CSS and JS code for Header Section
         * @param boolean $htmltag Optional default true generate HTML tags
         * @param boolean $global Optional default true generate render once code also
         * @param int $blockJSCode Optional default 0 block JS code section Other values 1 and 2
         * @return string
         */
        public function getHeaderHTML($htmltag = true, $global = true, $blockJSCode = 0) {
            $objsettings = \SphpBase::sphp_settings();
            $strout = "";

            if ($htmltag) {
                if (\SphpBase::sphp_settings()->blnEditMode) {
                    $strout = 'data-masterf="' . realpath(\SphpBase::page()->masterfilepath) . '"';
                    $strout .= ' data-mappname="' . realpath(\SphpBase::page()->appfilepath) . '"';
                }
                $strout = '<meta name="generator" content="SartajPHP" ' . $strout . ' />';
                if ($objsettings->metakeywords != '') {
                    $strout .= '<title>' . substr($objsettings->title, 0, 70) . '</title>';
                    $strout .= '<meta name="description" content="' . substr($objsettings->metadescription, 0, 150) . '" />';
                    $strout .= '<meta name="abstract" content="' . substr($objsettings->metadescription, 0, 150) . '" />';
                    $strout .= '<meta name="keywords" content="' . substr($objsettings->metakeywords, 0, 850) . '" />';
                    if ($objsettings->metaclassification != '') {
                        $strout .= '<meta name="classification" content="' . $objsettings->metaclassification . '" />';
                    }
                    $strout .= '<meta name="distribution" content="' . $objsettings->metadistribution . '" />';
                    $strout .= '<meta name="robots" content="' . $objsettings->metarobot . '" />';
                    $strout .= '<meta name="rating" content="' . $objsettings->metarating . '" />';
                    $strout .= '<meta name="author" content="' . $objsettings->metaauthor . '" />';
                    $strout .= '<meta name="alexa" content="100" />';
                    $strout .= '<meta name="pagerank" content="' . $objsettings->metapagerank . '" />';
                    $strout .= '<meta name="revisit" content="' . $objsettings->metarevisit . '" />';
                    $strout .= '<meta name="revisit-after" content="' . $objsettings->metarevisit . '" />';
                    $strout .= '<meta name="subject" content="' . $objsettings->metadescription . '" />';
                    $strout .= '<meta name="title" content="' . $objsettings->title . '" />';
                    $strout .= '<meta name="seoconsultantsdirectory" content="5" />';
                    $strout .= '<meta name="serps" content="1, 2, 3, 10, 11, 12, 13, 20, ATF" />';
                }
            }
            // add css
            $strflist = "";
            if ($global) {
                foreach ($this->fileLinks["global"] as $key => $val) {
                    if ($key != "js") {
                        foreach ($val as $key2 => $val2) {
                            if ($val2 != "remove") {
                                if ($key == "css") {
                                    if ($htmltag) {
                                        $strout .= "<link href=\"" . $val2[0] . "\" rel=\"stylesheet\"  type=\"text/css\" />";
                                        if ($val2[1] != "0") {
                                            $ver = explode(':', $val2[1]);
                                            $this->fileversions[$ver[0]] = $ver[1];
                                        }
                                    } else {
                                        $strflist .= "'" . $val2[0] . "',";
                                        //    $strout .=  "$('head').append('".'<link href="'.$val2.'" rel="stylesheet"  type="text/css" />'."');";    
                                        //   $strout .=  "$.get('$val2', public function(cssStyle) {
                                        //                        $('body').append('<style>' + cssStyle + '</style>');
                                        //                  });";
                                    }
                                } else if ($key == "code") {
                                    if ($htmltag) {
                                        $strout .= $val2;
                                    } else {
                                        $strout .= "$('head').append('" . $val2 . "');";
                                    }
                                }
                            }
                        }
                    }
                }
            }

            foreach ($this->fileLinks["private"] as $key => $val) {
                if ($key != "js") {
                    foreach ($val as $key2 => $val2) {
                        if ($val2 != "remove") {
                            if ($key == "css") {
                                if ($htmltag) {
                                    $strout .= "<link href=\"" . $val2[0] . "\" rel=\"stylesheet\"  type=\"text/css\" />";
                                    if ($val2[1] != "0") {
                                        $ver = explode(':', $val2[1]);
                                        $this->fileversions[$ver[0]] = $ver[1];
                                    }
                                } else {
                                    //    $strout .=  "$('head').append('".'<link href="'.$val2.'" rel="stylesheet"  type="text/css" />'."');";    
                                    $strflist .= "'" . $val2[0] . "',";
                                }
                            } else if ($key == "code") {
                                if ($htmltag) {
                                    $strout .= $val2;
                                } else {
                                    $strout .= "$('head').append('" . $val2 . "');";
                                }
                            }
                        }
                    }
                }
            }

            $strout2 = "";
            if ($global) {
                foreach ($this->headerCSS["global"] as $key => $val) {
                    $strout2 .= $val;
                }
            }
            foreach ($this->headerCSS["private"] as $key => $val) {
                $strout2 .= $val;
            }
            if ($strout2 != "") {
                if ($htmltag) {
                    $strout .= "<style type=\"text/css\"> " . $strout2 . " </style>";
                } else {
                    $strout2 = "<style type=\"text/css\"> " . $strout2 . " </style>";
                    $strout .= "$('body').append('" . $this->getFilterJSString($strout2) . "');";
                }
            }
            // add java script
            if ($htmltag) {
                //$strout .= $this->getHeaderJS($htmltag, $global,$blockJSCode);
            } else {
                $strflist = substr($strflist, 0, strlen($strflist) - 1);
                \SphpBase::JSServer()->addJSONBlock("jss", "proces", " window['fileList2'] = new Array(" . $strflist . ");");
                \SphpBase::JSServer()->addJSONBlock("csfl", "csslink", " bdcode");
                \SphpBase::JSServer()->addJSONBlock("css", "proces", $strout);
                //\SphpBase::JSServer()->addJSONBlock("js", "proces", $this->getHeaderJS($htmltag, $global,$blockJSCode));
                $strout = "";
            }
            return $strout;
        }

        /**
         * Advance Function, Internal use
         * Generate all HTML,CSS and JS code for Footer Section
         * @param boolean $htmltag Optional default true generate HTML tags
         * @param boolean $global Optional default true generate render once code also
         * @param int $blockJSCode Optional default 0 block JS code section Other values 1 and 2
         * @return string
         */
        public function getFooterHTML($htmltag = true, $global = true, $blockJSCode = 0) {
            // add java script
            $strout = "";
            if ($htmltag) {
                $strout = $this->getHeaderJS($htmltag, $global, $blockJSCode);
                $strout .= $this->getFooterJS($htmltag, $global, $blockJSCode);
            } else {
                $strout = $this->getHeaderJS($htmltag, $global, $blockJSCode);
                $strout .= $this->getFooterJS($htmltag, $global, $blockJSCode);
                \SphpBase::JSServer()->addJSONBlock("js", "proces", $strout);
                $strout = "";
            }
            return $strout;
        }

        /**
         * Generate JS Code for console message.
         * @param string $msg
         * @param string $type Optional Default=log, it is same as JS console like info, error
         * @return string
         */
        public function consoleMsg($msg, $type = "log") {
            $msg = str_replace(array("\r","\n"), ' ',$msg);
            $msg = str_replace('"', '\"',$msg); 
            $msg = str_replace('\\\"', '\"',$msg); 
            return 'console.'. $type .'("' .  $msg . '");';
        }

        /**
         * Print Error message in browser in HTML or JS code. This
         * uses SphpBase::sphp_api()->setErr function for set error message.
         * SphpBase::sphp_api()->getCheckErr() for check if there are any error.
         * @param type $blnDontJS Optional Default false
         * @return string
         */
        public function traceError($blnDontJS = false) {
            $strout = "";
            $strout2 = "";
            if (!$blnDontJS) {
                // add java script
                foreach ($this->errMsg as $key => $val) {
                    if (is_array($val)) {
                        foreach ($val as $key2 => $val2) {
                            //$val2 = preg_replace("(')", "\'", strip_tags($val2));
                            $strout2 .= $this->consoleMsg('Error in ' . $key . ' Detail:-(' . $key2 . ') ' . $val2, "error");
                        }
                    } else {
                        //$val = preg_replace("(')", "\'", strip_tags($val));
                        //$strout2 .= "console.error('Error in ". $key ." Detail:-". $val ."');";
                        $strout2 .= $this->consoleMsg('Error in ' . $key . ' Detail:- ' . $val . ' ', "error");
                    }
                }
                if ($strout2 != "") {
                    //$strout .= "<script type=\"text/javascript\" language=\"javascript\">";
                    //$strout .= $strout2 . "</script>";
                    $strout .= $strout2;
                }
            } else {
                foreach ($this->errMsg as $key => $val) {
                    $strout .= "<div class=\"sphp-error\">" . $val . "</div>";
                }
            }
            return $strout;
        }

        // below public functions are used for check error handling

        /**
         * 
         * Set Error Message and Error Flag, display for User of your project. 
         * This isn't PHP Language errors. It doesn't break your 
         * program execution. It is flag base error status which then you can
         * use for decision making on server side or browser side. You can also set this flag
         * from PHP exception and display error message in html tag rather then broken PHP 
         * output. Like validation error on TextBox Component will also set error flag on server and
         * send back html error message with proper format and valid HTML.  
         * After this SphpBase::sphp_api()->getCheckErr() return true.
         * @param string $name id for message error
         * @param string $msg 
         */
        public function setErr($name, $msg) {
            $this->errStatus = true;
            $this->errMsg[$name] = $msg;
        }

        /**
         * SphpBase::sphp_api()->getCheckErr() for check if there are any error set by setErr.
         * @return boolean
         */
        public function getCheckErr() {
            return $this->errStatus;
        }

        /**
         * Clear error flag set by setErr.
         */
        public function unsetCheckErr() {
            $this->errStatus = false;
        }

        /**
         * 
         * @param string $name name as id of error
         * @return string
         */
        public function getErrMsg($name) {
            if (isset($this->errMsg[$name])) {
                return $this->errMsg[$name];
            } else {
                return "";
            }
        }

        /**
         * Print Error message in browser in HTML or JS code. This
         * uses SphpBase::sphp_api()->setMsg function for set message.
         * @param type $blnDontJS Optional Default false
         * @return string
         */
        public function traceMsg($blnDontJS = false) {
            $strout = "";
            if (!$blnDontJS) {
                // add java script
                //$strout .= "<script type=\"text/javascript\" language=\"javascript\">";
                foreach ($this->msgA as $key => $val) {
                    if (is_array($val)) {
                        foreach ($val as $key2 => $val2) {
                            $strout .= $this->consoleMsg('Message By ' . $key . ' Detail:-(' . $key2 . ') ' . $val2, "log");
                        }
                    } else {
                        $strout .= $this->consoleMsg('Message By ' . $key . ' Detail:- ' . $key2 . ' ', "log");
                    }
                }
                //$strout .= "</script>";
            } else {
                foreach ($this->msgA as $key => $val) {
                    $strout .= "<div class=\"sphp-msg\">" . $val . "</div>";
                }
            }
            return $strout;
        }

        /**
         * Set Message for browser, display for User. 
         * @param string $name id for message
         * @param string $msg 
         */
        public function setMsg($name, $msg) {
            $this->msgA[$name] = $msg;
        }

        /**
         * 
         * @param string $name name as id of message
         * @return string
         */
        public function getMsg($name) {
            if (isset($this->msgA[$name])) {
                return $this->msgA[$name];
            } else {
                return "";
            }
        }

        /**
         * Print Developer Error message in browser in HTML or JS code. 
         * These errors are only available in debug mode and gives some extra informations
         * to devloper about logical erros or help in debugging. 
         * Not php erros or exceptions whichbreak executions. 
         * These are just messages which can also comes from PHP errors.
         * uses SphpBase::sphp_api()->setErrInner function for set error developer message.
         * @param type $blnDontJS Optional Default false
         * @return string
         */
        public function traceErrorInner($blnDontJS = false) {
            $strout = "";
            if (!$blnDontJS) {
                // add java script
                //$strout .= "<script type=\"text/javascript\" language=\"javascript\">";
                foreach ($this->errMsgInner as $key => $val) {
                    if (is_array($val)) {
                        foreach ($val as $key2 => $val2) {
                            $strout .= $this->consoleMsg('Error in ' . $key . ' Detail:-(' . $key2 . ') ' . $val2, "error");
                        }
                    } else {
                        $strout .= $this->consoleMsg('Error in ' . $key . ' Detail:- ' . $val . ' ', "error");
                    }
                }
                //$strout .= "</script>";
            } else {
                foreach ($this->errMsgInner as $key => $val) {
                    $strout .= "Error in " . $key . " Detail:-" . $val . "<br />";
                }
            }
            return $strout;
        }

        // below public functions are used for check error handling

        /**
         * Set Error Inner for developer
         * @param string $name id for message
         * @param string $msg
         */
        public function setErrInner($name, $msg) {
            $this->errMsgInner[$name] = $msg;
        }

        /**
         * Read Inner Error Message
         * @param string $name id for message
         * @return string
         */
        public function getErrMsgInner($name) {
            if (isset($this->errMsgInner[$name])) {
                return $this->errMsgInner[$name];
            } else {
                return "";
            }
        }

        /**
         * Set Front Place ignore if addFrontPlace don't initialize front place. 
         * It only reserve place. But not render in master without addFrontPlace.
         * @param string $frontname name is id
         * @param string $basepath DIR path
         * @param string $secname Optional Default=left
         * @param string $type Optional Default=FrontFile
         */
        public function setFrontPlacePath($frontname, $basepath, $secname = "left", $type = "FrontFile") {
            $objfr = array();
            $this->frontPlaces[$secname][$frontname] = array($basepath, $objfr, $type, "setpath");
        }

        /**
         * Remove Front Place. 
         * @param string $frontname name is id
         * @param string $secname Optional Default=left
         */
        public function removeFrontPlace($frontname, $secname = "left") {

            $arr = $this->frontPlaces[$secname][$frontname];
            unset($arr[1]);
            unset($arr);
            unset($this->frontPlaces[$secname][$frontname]);
        }

        /**
         * Add and initialize front place. 
         * @param string $frontname name is id
         * @param string $basepath DIR path
         * @param string $secname Optional Default=left
         * @param string $type Optional Default=FrontFile It recogonise extensions front or php
         */
        public function addFrontPlace($frontname, $filepath = "", $secname = "left", $type = "FrontFile") {
            $filename = basename($filepath);
            if (isset($this->frontPlaces[$secname][$frontname])) {
                $arr = $this->frontPlaces[$secname][$frontname];
            } else {
                $arr[0] = "";
            }
            if ($arr[0] != "") {
                $type = $arr[2];
                $pathi = pathinfo($arr[0]);
                $dirname = dirname($arr[0]) . "/";
                if (isset($pathi["extension"]) && strtolower($pathi["extension"]) == "front") {
                    if ($type == "PHP") {
                        $this->frontPlaces[$secname][$frontname] = array($dirname, $arr[0], $type, "init");
                    } else {
                        $objfr = new $type($arr[0]);
                        $this->frontPlaces[$secname][$frontname] = array($dirname, $objfr, $type, "init");
                    }
                } else {
                    if ($type == "PHP") {
                        $this->frontPlaces[$secname][$frontname] = array($arr[0], $arr[0] . $filename, $type, "init");
                    } else {
                        if (isset($pathi["extension"])) {
                            trigger_error("Invalid Front File Object:- " . $arr[0], E_USER_ERROR);
                        } else {
                            $objfr = new $type($arr[0] . $filename);
                            $this->frontPlaces[$secname][$frontname] = array($arr[0], $objfr, $type, "init");
                        }
                    }
                }
            } else {
                $dirname = dirname($filepath) . "/";
                if ($type == "PHP") {
                    $this->frontPlaces[$secname][$frontname] = array($dirname, $filepath, $type, "init");
                } else {
                    $pathi2 = pathinfo($filepath);
                    if ($pathi2["extension"] == "front") {
                        $objfr = new $type($filepath);
                        $this->frontPlaces[$secname][$frontname] = array($dirname, $objfr, $type, "init");
                    } else {
                        trigger_error("Invalid Front File Object:- " . $filepath, E_USER_ERROR);
                    }
                }
            }
        }

        /**
         * Get Front Place Object or path
         * @param string $frontname name is id
         * @param string $secname Optional Default=left
         * @return \Sphp\tools\FrontFile|string
         */
        public function getFrontPlace($frontname, $secname = "left") {
            $objfr = $this->frontPlaces[$secname][$frontname];
            $obj = $objfr[1];
            return $obj;
        }

        /**
         * Run Front Place. Only Run FrontFile not PHP. 
         * PHP file include only on render time.
         * @param string $frontname name is id
         * @param string $secname Optional Default=left
         */
        public function runFrontPlace($frontname, $secname = "left") {
            if (isset($this->frontPlaces[$secname][$frontname])) {
                $objfr = $this->frontPlaces[$secname][$frontname];
                if (is_object($objfr[1])) {
                    $objfr[1]->_run();
                    $this->frontPlaces[$secname][$frontname] = array($objfr[0], $objfr[1], $objfr[2], "run");
                }
            }
        }
        /**
         * Render Front Place Manually. It doesn't support PHP files. 
         * $frontname=dynData is reserved of center content of master.
         * It will return dynData.
         * @param string $frontname name is id
         * @param string $secname Optional Default=left
         * @return string HTML output from FrontFile
         */
        public function renderFrontPlaceManually($frontname, $secname = "left") {
            if (isset($this->frontPlaces[$secname][$frontname])) {
                $objfr = $this->frontPlaces[$secname][$frontname];
                if (is_object($objfr[1])) {
                    $this->frontPlaces[$secname][$frontname] = array($objfr[0], $objfr[1], $objfr[2], "render");
                    return $objfr[1]->getOutput();
                } else if ($objfr[2] == "PHP") {
                    $this->triggerError("PHP files don't support, use MasterFile");
                    return "PHP files don't support, use MasterFile";
                }
            } else if ($frontname == "dynData") {
                return \SphpBase::$dynData->getOutput();
            }
        }

        /**
         * Render Front Place. $frontname=dynData is reserved of center content of master.
         * It will render dynData.
         * @param string $frontname name is id
         * @param string $secname Optional Default=left
         */
        public function renderFrontPlace($frontname, $secname = "left") {
            if (isset($this->frontPlaces[$secname][$frontname])) {
                $objfr = $this->frontPlaces[$secname][$frontname];
                if (is_object($objfr[1])) {
                    $objfr[1]->render();
                    $this->frontPlaces[$secname][$frontname] = array($objfr[0], $objfr[1], $objfr[2], "render");
                } else if ($objfr[2] == "PHP") {
                    $this->frontPlaces[$secname][$frontname] = array($objfr[0], $objfr[1], $objfr[2], "render");
                    extract(getGlobals(), EXTR_REFS);
                    includeOnce($objfr[1]);
                }
            } else if ($frontname == "dynData") {
                //\SphpBase::$dynData->render();
                \SphpBase::getAppOutput();
            }
        }

        /**
         * Run All Front Places in a section
         * @param string $secname Optional Default=left
         */
        public function runFrontSection($secname = "left") {

            if (isset($this->frontPlaces[$secname])) {
                $arrd = $this->frontPlaces[$secname];
                if (is_array($arrd)) {
                    foreach ($arrd as $key => $val) {
                        if (is_object($val[1])) {
                            $val[1]->_run();
                            $this->frontPlaces[$secname][$key] = array($val[0], $val[1], $val[2], "run");
                        }
                    }
                }
            }
        }

        /**
         * Add and Run All Front Places in a section. 
         * If any Front Place is not added but set then this will add automatically.
         * @param string $secname Optional Default=left
         */
        public function addrunFrontSection($secname = "left") {

            if (isset($this->frontPlaces[$secname])) {
                $arrd = $this->frontPlaces[$secname];
                if (is_array($arrd)) {
                    foreach ($arrd as $key => $val) {
                        if (is_object($val[1])) {
                            $val[1]->_run();
                            $this->frontPlaces[$secname][$key] = array($val[0], $val[1], $val[2], "run");
                        } else if ($val[3] == "setpath") {
                            addFrontPlace($key, $val[0], $secname, $val[2]);
                            $objfr = $this->frontPlaces[$secname][$key];
                            $objfr[1]->_run();
                            $this->frontPlaces[$secname][$key] = array($val[0], $objfr[1], $val[2], "run");
                        }
                    }
                }
            }
        }

        /**
         * List of all front places which isn't render
         * @param string $secname Optional Default=left
         */
        public function listNotRenderFrontSection($secname = "left") {

            $arrd = $this->frontPlaces[$secname];
            if (is_array($arrd)) {
                foreach ($arrd as $key => $val) {
                    if ($val[3] == "run") {
                        echo "Section: " . $secname . " Frontplace: " . $key . " is Run But not render";
                    } else if ($val[3] == "init") {
                        echo "Section: " . $secname . " Frontplace: " . $key . " is Init But not Run and render";
                    }
                }
            }
        }

        /**
         * Render All Front Places in a section. 
         * @param string $secname Optional Default=left
         */
        public function renderFrontSection($secname = "left") {

            if (isset($this->frontPlaces[$secname])) {
                $arrd = $this->frontPlaces[$secname];
                if (is_array($arrd)) {
                    foreach ($arrd as $key => $val) {
                        if (is_object($val[1])) {
                            $val[1]->render();
                            $this->frontPlaces[$secname][$key] = array($val[0], $val[1], $val[2], "render");
                        } else if ($val[2] == "PHP") {
                            $this->frontPlaces[$secname][$key] = array($val[0], $val[1], $val[2], "render");
                            extract(getGlobals(), EXTR_REFS);
                            includeOnce($val[1]);
                        }
                    }
                }
            }
        }

        /**
         * Encrypt String 
         * @param string $strdata
         * @param string $key Optional Default=sbrtyu837
         * @return string
         */
        public function encrypt($strdata, $key = "sartajphp211") {
            $result = "";
            for ($i = 0; $i < strlen($strdata); $i++) {
                $chara = substr($strdata, $i, 1);
                $keychar = substr($key, ($i % strlen($key)) - 1, 1);
                $hex = dechex(ord($chara) + ord($keychar));
                $hex = substr("0" . $hex, -2);
                $result .= $hex;
            }
            //return base64_encode($result);
            return $result;
        }

        /**
         * Decrypt String 
         * @param string $strdata
         * @param string $key Optional Default=sbrtyu837
         * @return string
         */
        public function decrypt($strdata, $key = "sartajphp211") {
            return \decryptme($strdata,$key);
        }

        /**
         * Encrypt/Decrypt String. Use Hexadecimal key. Output Length is not big.
         * Data recover is near to impossible if you lost key.  
         * @param string $str
         * @param string $ky Optional Default=CD098AB
         * @return string
         */
        public function endec($str, $ky="CD098ABA") {
            if ($ky == "") return $str;
            if(gettype($str) != "string") $str = strval($str);
            $ky = str_replace(chr(32), "", $ky);
            if (strlen($ky) < 8)
                exit("key error");
            $kl = strlen($ky) < 32 ? strlen($ky) : 32;
            $k = array();
            for ($i = 0; $i < $kl; $i++) {
                $k[$i] = ord($ky[$i]) & 0x1F;
            }
            $j = 0;
            for ($i = 0; $i < strlen($str); $i++) {
                $e = ord($str[$i]);
                $str[$i] = $e & 0xE0 ? chr($e ^ $k[$j]) : chr($e);
                $j++;
                $j = $j == $kl ? 0 : $j;
            }
            return $str;
        }

        // reflection start
        public function rtClassMethod(\ReflectionClass &$refClass) {
            //$class_info = new \ReflectionClass($class);
            //$fl = @file($class_info->getFileName());
            return $refClass->getMethods();
        }

        public function rtClassFile(\ReflectionClass &$refClass) {
            //$class_info = new \ReflectionClass($class);
            return file($refClass->getFileName());
        }

        public function rtMethodSource(\ReflectionMethod &$method, &$arlines) {
            $from = $method->getStartLine();
            $to = $method->getEndLine();
            $ars = array_slice($arlines, $from, $to - $from - 1);
            $glu = "";
            $str = implode($glu, $ars);
            return $str;
        }

        public function rtMethodParamFromString($strline, $parameters) {
            $startp = strpos($strline, "(");
            $startp2 = strpos($strline, ")");
            $strParaLine = "";
            if ($startp2 > $startp) {
                $strParaLine = substr($strline, $startp + 1, $startp2 - $startp - 1);
            }
            $strParam = "";
            foreach ($parameters as $param) {
                if ($strParam != "") {
                    $strParam .= ',\\$' . $param->name;
                } else {
                    $strParam .= '\\$' . $param->name;
                }
            }
            return array($strParaLine, $strParam);
        }

        public function rtMethodParm(&$method) {
            $parameters = $method->getParameters();
            $strparm = "";
            $strparmhelp = "";
            foreach ($parameters as $para => $parm) {
                if ($strparm == "") {
                    $strparm .= '\\$' . $parm->getName();
                    $strparmhelp .= '$' . $parm->getName();
                } else {
                    $strparm .= ',\\$' . $parm->getName();
                    $strparmhelp .= ',$' . $parm->getName();
                }
                if ($parm->isOptional()) {
                    $strparmhelp .= "=OP";
                }
            }
            return array($strparm, $strparmhelp);
        }

        public function rtClassConstantHelp($mainClass, \ReflectionClass &$reflector) {
            $arv1 = array();
            $constants = $reflector->getReflectionConstants();
            //$properties = $reflector->getStaticProperties();
            //["help sysntax","doc help","Sphp\\SphpApi","snipit","Show type in List popup"]
            foreach ($constants as $key => $constant) {
                $clstype = "";
                if ($constant->isPublic() || $constant->isProtected()) {
                    $proptype = gettype($constant->getValue());
                    if ($proptype == "object") {
                        $proptype = get_class($constant->getValue());
                        $clstype = $proptype;
                    }
                    $arv1[$constant->getName()] = $this->rtAutoCompleteFormat($constant->getName(), $proptype . " Constant " . $mainClass, $clstype, $constant->getName(), "Constant");
                }
            }
            return $arv1;
        }

        public function rtScopeDefinedHelp(&$arCls, &$arConst, &$arFun, &$arVars) {
            $v1 = array();
            foreach ($arCls as $key => $value) {
                $class = new \ReflectionClass($value);
                $constructor = $class->getConstructor();
                if ($constructor !== NULL) {
                    $strParam = $this->rtMethodParm($constructor);
                } else {
                    $strParam[0] = "";
                    $strParam[1] = "";
                }
                $v1[$value] = $this->rtAutoCompleteFormat($value . '(' . $strParam[1] . ')', $value . " Class", $value, $value . '($0' . $strParam[0] . ')', "Class");
            }

            foreach ($arConst as $key => $value) {
                $v1[$key] = $this->rtAutoCompleteFormat($key . ' = ' . $value, $key . " Constant", $key, $key, "Constant");
            }

            foreach (array_merge($arFun["internal"], $arFun["user"]) as $key => $valuem) {
                $method = new \ReflectionFunction($valuem);
                $value = $method->getName();
                if ($method !== NULL) {
                    $strParam = $this->rtMethodParm($method);
                } else {
                    $strParam[0] = "";
                    $strParam[1] = "";
                }
                $v1[$value] = $this->rtAutoCompleteFormat($value . '(' . $strParam[1] . ')', $value . " Function", $value, $value . '($0' . $strParam[0] . ')', "Function");
            }

            $v2 = array_keys($arVars);
            foreach ($v2 as $key => $value) {
                $clstype = "";
                $proptype = gettype($arVars[$value]);
                if ($proptype == "object") {
                    $proptype = get_class($arVars[$value]);
                    $clstype = $proptype;
                }

                $v1['$' . $value] = $this->rtAutoCompleteFormat('$' . $value . ' ' . $proptype, '$' . $value . " Var", $clstype, '\\$' . $value, "Var");
            }

            //print_r($v1);
            return $v1;
        }

        public function rtClassMethodInvoke(&$method, &$obj, $args = null) {
            $resvar = null;
            $args2 = array();
            if ($args == null) {
                $parameters = $method->getParameters();
                foreach ($parameters as $para => $parm) {
                    //$strparm .= '\\$' . $parm->getName();
                    if (!$parm->isOptional()) {
                        $args2[] = "";
                    }
                }
            } else {
                $args2 = args;
            }

            if ($method->isStatic()) {
                $resvar = $method->invoke(null, $args2);
            } else {
                $resvar = $method->invoke($obj, $args2);
            }
            return $resvar;
        }

        public function rtFunctionInvoke($fun, $args = null) {
            $resvar = null;
            $args2 = array();
            if (is_callable($fun)) {
                $method = new \ReflectionFunction($fun);
                if ($args == null) {
                    $parameters = $method->getParameters();
                    foreach ($parameters as $para => $parm) {
                        if (!$parm->isOptional()) {
                            $args2[] = "";
                        }
                    }
                } else {
                    $args2 = args;
                }

                $resvar = $method->invokeArgs($args2);
            }
            return $resvar;
        }

        public function rtClassMethodFromFileLine(\ReflectionClass &$reflector, $line) {
            $methods = $reflector->getMethods();
            foreach ($methods as $key2 => $method) {
                $from = $method->getStartLine();
                $to = $method->getEndLine();
                if ($line > $from && $line < $to) {
                    return $method;
                }
            }
            return null;
        }

        public function rtClassMethodHelp($mainClass, \ReflectionClass &$reflector, &$arResult) {
            //$filepath = $reflector->getFileName();
            //$line_of_text = file_get_contents($filepath);
            //$flines = explode("\n", $line_of_text);
            //print_r($flines);
            //echo $filepath;
            $methods = $reflector->getMethods(\ReflectionMethod::IS_STATIC);
            foreach ($methods as $key2 => $method) {
                //$strParam = $this->getParamFromLine($flines[$method->getStartLine() - 1], $method->getParameters());
                $strParam = $this->rtMethodParm($method);
                $arResult["static"][$method->getName()] = array($method->getName() . '(' . $strParam[1] . ')', "SMethod " . $mainClass, "", $method->getName() . '($0' . $strParam[0] . ')', "SMethod");
            }
            $methods = $reflector->getMethods(\ReflectionMethod::IS_PUBLIC | \ReflectionMethod::IS_PRIVATE | \ReflectionMethod::IS_PROTECTED | \ReflectionMethod::IS_ABSTRACT | \ReflectionMethod::IS_FINAL);
            //$methods = $reflector->getMethods(\ReflectionMethod::IS_PUBLIC);
            foreach ($methods as $key2 => $method) {
                //$parameters = $method->getParameters();
                //echo $method->getName();
                //print_r($parameters);
                $strParam = $this->rtMethodParm($method);
                //$strParam = $this->getParamFromLine($flines[$method->getStartLine() - 1], $method->getParameters());

                $arResult["member"][$method->getName()] = array($method->getName() . '(' . $strParam[1] . ')', "Method " . $mainClass, "", $method->getName() . '($0' . $strParam[0] . ')', "Method");
                //break;
            }
        }

        public function rtClassPropertyHelp($mainClass, $clsobj, \ReflectionClass &$reflector, &$arResult) {
            $properties = $reflector->getProperties();
//$properties = $reflector->getStaticProperties();
//["help sysntax","doc help","Sphp\\SphpApi","snipit","Show type in List popup"]
            foreach ($properties as $key => $property) {
                //Populating properties
//    $clsobj->{$property->getName()}=$i;
                //Invoking the method to print what was populated
                //$ar1["member"][$property->getName()] = array($property->getName() ."()","","class type",$property->getName() ."($0)","Property of ");
                //$ar1["static"]['$'.$key] = array('$'.$key,"SProperty " . $mainClass,get_class($property),'\\$'.$key,"SProperty");
                $clstype = "";
                if ($property->isStatic() && $property->isPublic()) {
                    $proptype = gettype($property->getValue());
                    if ($proptype == "NULL" || $proptype == "object") {
                        $v1 = $property->getValue();
                        if ($v1 !== null) {
                            $proptype = get_class($v1);
                        } else {
                            $proptype = "NULL";
                        }
                        $clstype = $proptype;
                    }
                    $arResult["static"]['$' . $property->getName()] = array('$' . $property->getName(), $proptype . " SProperty " . $mainClass, $clstype, '\\$' . $property->getName(), "SProperty");
                } else if ($property->isPublic()) {
                    //echo $property->getName() . ' = ' . $property->getValue() . ' - ';
                    $proptype = gettype($property->getValue($clsobj));
                    if ($proptype == "NULL" || $proptype == "object") {
                        $v1 = $clsobj->{$property->getName()};
                        if ($v1 !== null) {
                            $proptype = get_class($v1);
                        } else {
                            $proptype = "NULL";
                        }

                        $clstype = $proptype;
                    }
                    $arResult["member"][$property->getName()] = array($property->getName(), $proptype . " Property " . $mainClass, $clstype, $property->getName(), "Property");
                }
                //echo $property->getName() . " ";
                //break;
            }
        }

        public function rtAutoCompleteFormat($objname, $helpdoc, $objtype, $code, $helptype) {
            return array($objname, $helpdoc, $objtype, $code, $helptype);
        }

        // reflection end

        public function executePHP($strPHPCode) {
            return(\executePHP($strPHPCode));
        }

        public function executePHPGlobal($strPHPCode) {
            \executePHPGlobal($strPHPCode);
        }

        public function executePHPFunc($strPHPCode) {
            return \executePHPFunc($strPHPCode);
        }

        public function consoleWrite($param) {
            fwrite(STDOUT, $param);
        }

        public function consoleWriteln($param) {
            fwrite(STDOUT, $param . "\n");
        }

        public function consoleReadln($msg) {
            fwrite(STDOUT, "$msg \n");
            return fgets(STDIN);
        }

        public function consoleError($err) {
            fwrite(STDERR, $err . "\n\n");
        }

    }

}
