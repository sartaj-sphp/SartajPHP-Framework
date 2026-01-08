<?php

namespace Sphp\core{

class Request {
    /** @var string $method Request Method */
    public $method = "";
    /** @var string $mode Default SERVER OR CLI or CGI */
    public $mode = "SERVER"; // CLI or CGI
    /** @var string $protocol Request Protocol */
    public $protocol = "";
    /** @var boolean $blnsecure Request SSL */
    public $blnsecure = false;
    /** @var string $uri Request URI */
    public $uri = "";
    /** @var string $scriptpath Engine Script Path */
    public $scriptpath = "";
    /** @var array $argv Command Line Arguments */
    public $argv = array();
    /** @var string $type Request Type Default NORMAL or AJAX or SOAP */
    public $type = "NORMAL"; // AJAX or SOAP etc
    /** @var boolean $isNativeClient true if application embed with browser  */
    public $isNativeClient = false;
    private $isAjax = false;
    private $settings = null;
    private $svar1 = array();
    private $ses = array();
    private $blnSvar = false;

    public function __construct() {
        $this->settings = \SphpBase::sphp_settings();
    }
    /**
     * Get All Request Headers
     * @return array()
     */
    public function getClientHeaders() {
        return apache_request_headers();
    }
    /**
     * Advance Function, Internal use
     */
    public function parseRequest() {
        if(\SphpBase::$stmycache !== null){
            $this->blnSvar = false;
            $this->ses = array();
            $this->method = \SphpBase::$stmycache->method;
            $this->mode = \SphpBase::$stmycache->mode;
            $this->protocol = \SphpBase::$stmycache->protocol;
            $this->blnsecure = \SphpBase::$stmycache->blnsecure;
            $this->uri = \SphpBase::$stmycache->uri;
            $this->scriptpath = \SphpBase::$stmycache->scriptpath;
            $this->argv = \SphpBase::$stmycache->argv;
            $this->type = \SphpBase::$stmycache->type; 
            $this->isNativeClient = \SphpBase::$stmycache->isNativeClient;
            $this->isAjax = false;

            //run in edit mode 
            if(\SphpBase::$stmycache->edtmode){
                $this->settings->blnEditMode = true; 
                $this->settings->editCtrl = \SphpBase::$stmycache->edtctrl;
            }
        }
    }
    /**
     * True if Application run with SphpServer Mode or Browser embed mode 
     * False on Web Server Mode or Console Mode
     * @return boolean
     */
    public function isNativeApp() {
        if(\SphpBase::sphp_settings()->response_method == "HEX"){ 
            return true;
        }else{
            return false;
        }
    }
    /**
     * Check if client demand JSON response.
     * @return boolean 
     */
    public function isAJAX() {
        if($this->isAjax || \SphpBase::sphp_settings()->response_method == "HEX" || \SphpBase::JSServer()->jsonready || $this->type == "AJAX"){ 
            $this->isAjax = true;
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Read Browser Get Method Data
     * @param string $name key
     * @param boolean $blnRaw true mean, no escaping
     * @return string|array
     */
    public function get($name, $blnRaw = false) {
        if (isset($_GET[$name])) {
            if (!$blnRaw) {
                return $this->escapetag($_GET[$name]);
            } else {
                return $_GET[$name];
            }
        } else {
            return "";
        }
    }
    /**
     * Read Browser Post Method Data
     * @param string $name key
     * @param boolean $blnRaw true mean, no escaping
     * @return string|array
     */
    public function post($name, $blnRaw = false) {
        if (isset($_POST[$name])) {
            if (!$blnRaw) {
                return $this->escapetag($_POST[$name]);
            } else {
                return $_POST[$name];
            }
        } else {
            return "";
        }
    }
    /**
     * Check if Request has key
     * @param string $name key
     * @return boolean
     */
    public function isRequest($name) {
        if (isset($_REQUEST[$name])) return true;
        return false;
    }
    /**
     * Check if Cookie has key
     * @param string $name key
     * @return boolean
     */
    public function isCookie($name) {
        if (isset($_COOKIE[$name])) return true;
        return false;
    }
    /**
     * Check if Session has key
     * @param string $name key
     * @return boolean
     */
    public function isSession($name) {
        if (isset($_SESSION[$name])) return true;
        return false;
    }
    /**
     * Check if Server has key
     * @param string $name key
     * @return boolean
     */
    public function isServer($name) {
        if (isset($_SERVER[$name])) return true;
        return false;
    }
    /**
     * Check if Post has key
     * @param string $name key
     * @return boolean
     */
    public function isPost($name) {
        if (isset($_POST[$name])) return true;
        return false;
    }
    /**
     * Check if Get has key
     * @param string $name key
     * @return boolean
     */
    public function isGet($name) {
        if (isset($_GET[$name])) return true;
        return false;
    }
    /**
     * Check if File has key
     * @param string $name key
     * @return boolean
     */
    public function isFile($name) {
        if (isset($_FILES[$name])) return true;
        return false;
    }
    /**
     * Read/Write Request key
     * @param string $name key
     * @param boolean $blnRaw true mean, no escaping at time of reading
     * @param string|array $value null mean read key
     * @return string
     */
    public function request($name, $blnRaw = false,$value=null) {
        if($value === null){
        if (isset($_REQUEST[$name])) {
            if (!$blnRaw) {
                return $this->escapetag($_REQUEST[$name]);
            } else {
                return $_REQUEST[$name];
            }
        } else {
            return "";
        }
        }else{
            $_REQUEST[$name] = $value;
        }
    }
    /**
     * Read Raw Request Data
     * @return string
     */
    public function requestStream() {
        return file_get_contents('php://input');
    }
    /**
     * Write/Read Cookie
     * @param string $name key
     * @param boolean $blnRaw true mean, no escaping at time of reading
     * @param string|array $value null mean read key
     * @param int $expire
     * @param string $path
     * @param string $domain
     * @param boolean $secure
     * @param boolean $httponly
     * @return string
     */
    public function cookie($name, $value = null, $blnRaw = false,$expire=-1,$path='/', $domain="", $secure=false, $httponly=true) {
        if ($value === null) {
            if (isset($_COOKIE[$name])) {
                if (!$blnRaw) {
                    return $this->escapetag($_COOKIE[$name]);
                } else {
                    return $_COOKIE[$name];
                }
            } else {
                return "";
            }
        } else {
            $_COOKIE[$name] = $value;
            \SphpBase::sphp_response()->setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
        }
    }
    /**
     * Write/Read Cookie with tamper protection. Bad cookie return empty value.
     * @param string $name key
     * @param boolean $blnRaw true mean, no escaping at time of reading
     * @param string|array $value null mean read key
     * @param int $expire
     * @param string $path
     * @param string $domain
     * @param boolean $secure
     * @param boolean $httponly
     * @return string
     */
    public function cookie_secure($name, $value = null, $blnRaw = false,$expire=-1,$path='/', $domain="", $secure=false, $httponly=true,$prefix="") {
        // max cookies per domain is 50 and max value length 4000 bytes
        $namem = $prefix . encryptme($name, $this->settings->defenckey);
        //$namem = $name;
        // read cookie
        if ($value === null) {
            if (isset($_COOKIE[$namem])) {
                if (!$blnRaw) {
                    $value = $this->escapetag($_COOKIE[$namem]);
                } else {
                    $value = $_COOKIE[$namem];
                } 
                $blnar = substr($value,0,2);
                $chksum = substr($value,2,20); 
                $value = substr($value,22); 
                $value = endec(urldecode($value),"A07B2D18"); 
                if($chksum == str_pad(crc32($value),20,'O',STR_PAD_LEFT)){
                    if($blnar == "10"){
                        $value = json_decode($value,true);                         
                    }
                    $_COOKIE[$name] = $value;
                    //unset($_COOKIE[$namem]);
                    return $value;
                }else{
                    $this->unsetCookie($namem);
                    return "";
                }

            } else {
                return "";
            }
        } else {
            $_COOKIE[$name] = $value;
            if(gettype($value) == "array" || gettype($value) == "object"){
                $value = json_encode($value);
                $chksum = str_pad(crc32($value),20,'O',STR_PAD_LEFT);
                $value = "10" . $chksum . urlencode(endec($value,"A07B2D18"));
            }else{
                $chksum = str_pad(crc32($value),20,'O',STR_PAD_LEFT);
                $value = "00" . $chksum . urlencode(endec($value,"A07B2D18"));
            } 
            \SphpBase::sphp_response()->setcookie($namem, $value,$expire,$path, $domain, $secure, $httponly);  
        }
    }
    
    /**
     * Advance Function, Internal use
     */
    public function restoreSessionFromStorage() {
        if($this->settings->sphp_use_session_storage){
        // work as key to restore value from cookie
        if(file_exists(\SphpBase::sphp_settings()->start_path . "/cache/sessphp.txt")){
            $_SESSION = unserialize(file_get_contents(\SphpBase::sphp_settings()->start_path . "/cache/sessphp.txt"));
        }else{
            $this->session("logType", "GUEST");
        }
        if(\SphpBase::sphp_settings()->sphp_use_session_cookie && is_array($_SESSION)){
            foreach ($_SESSION as $index=>$val){
                $_SESSION[$index] = $this->cookie_secure($index,null, false,-1,'/', "", false, true,"0sa2"); 
                $this->ses[$index] = $_SESSION[$index];
            }
            
        }
        }else if(\SphpBase::sphp_settings()->sphp_use_session_cookie){
            foreach ($_COOKIE as $index=>$val){
                $v2 = strpos($index,"0sa2");
                if($v2 !== false){ 
                    $index2 = decryptme(substr($index,4), $this->settings->defenckey);
                    $_SESSION[$index2] = $this->cookie_secure($index2,null, false,-1,'/', "", false, true,"0sa2"); 
                    $this->ses[$index2] = $_SESSION[$index2];
                }
            }
            
        }
    }
    /**
     * Advance Function, Internal use
     */
    public function saveSessionToStorage() { 
        if($this->settings->sphp_use_session_storage){
            file_put_contents(\SphpBase::sphp_settings()->start_path . "/cache/sessphp.txt",serialize($_SESSION)); 
        }
        if(\SphpBase::sphp_settings()->sphp_use_session_cookie && is_array($_SESSION)){
            // convert session var to cookie if not exist
            foreach ($_SESSION as $index=>$val){ 
                if(! isset($_COOKIE[$index]) || (isset($this->ses[$index]) && $this->ses[$index] != $val)){
                    $this->cookie_secure($index, $val,false,-1,'/', "", false, true,"0sa2");
                }
            }
            foreach ($this->ses as $index=>$val){
                if(!isset($_SESSION[$index])){
                    $this->unsetCookie('0sa2'. encryptme($index,$this->settings->defenckey));
                }
            }
        }
    }
    /**
     * Delete Cookie
     * @param string $name key
     */
    public function unsetCookie($name) {
        unset($_COOKIE[$name]);
        \SphpBase::sphp_response()->setcookie($name, "", time() - 3600);
    }
    /**
     * Delete Session Variable
     * @param string $name key
     */
    public function unsetSession($name) {
        unset($_SESSION[$name]);
    }
    /**
     * Destroy All Session Data
     */
    public function destroySession() {
        $_SESSION = array();
        if(session_status() == 2) session_destroy();
    }
    /**
     * Read/Write Session key
     * @param string $name key
     * @param string|array $value null mean read key
     * @return string|array
     */
    public function session($name, $value = null) {
        if($this->blnSvar){
            return $this->svar($name, $value);
        }else{
        if ($value === null) {
            if (isset($_SESSION[$name])) {
                return $_SESSION[$name];
            } else {
                return "";
            }
        } else {
            $_SESSION[$name] = $value;
        }
        }
    }
    /**
     * Advance Function, Internal use
     */
    public function setUseServerVariables() {
            $this->blnSvar = true;        
    }
    /**
     * Advance Function, Internal use
     */
    public function svar($name, $value = null) {
        if ($value == null) {
            if (isset($this->svar1[$name])) {
                return $this->svar1[$name];
            } else {
                return "";
            }
        } else {
            $this->svar1[$name] = $value;
        }
    }
    /**
     * Read $_SERVER key
     * @param string $name key
     * @return string
     */
    public function server($name) {
        if (isset($_SERVER[$name])) {
            return $_SERVER[$name];
        } else {
            return "";
        }
    }
    /**
     * Read $_FILES key
     * @param string $name key
     * @return string
     */
    public function files($name) {
        if (isset($_FILES[$name])) {
            return $_FILES[$name];
        } else {
            return "";
        }
    }
    /**
     * Advance Function, Internal use
     */
    public function escapetag($str) {
        //$badWords = "/(<)|(>)/i";
        if (is_array($str)) {
            foreach ($str as $key => $val) {
                $str[$key] = $this->escapetag($val);
            }
        } else {
            $str = str_replace(["<",">"], ["[!","!]"], $str);
            //$str = str_replace(">", "]", $str);
        }
        return $str;
    }

    /**
     * Advance Function, Internal use
     * @deprecated 4.4.8
     */
    public function getEngineRootPath() {
        return $_SERVER["DOCUMENT_ROOT"] . $this->scriptPath;
    }

    /**
     * Advance Function, Internal use
     */
    public function getURLSafe($val) {
        $val = str_replace("-", "_" . ord("-") . "_", $val);
        $val = str_replace(".", "_" . ord(".") . "_", $val);
        $val = urlencode($val);
        return $val;
    }

    /**
     * Advance Function, Internal use
     */
    public function getURLSafeRet($val) {
        $val = str_replace("_" . ord("-") . "_", "-", $val);
        $val = str_replace("_" . ord(".") . "_", ".", $val);
        return $val;
    }

}
}
