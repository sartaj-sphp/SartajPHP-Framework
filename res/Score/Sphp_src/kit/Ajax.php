<?php

namespace Sphp\kit{

/**
 * Description of ajax
 *
 * @author SARTAJ
 */
class Ajax {

    private function getAjax() {
        \SphpBase::sphp_api()->addFileLink(\SphpBase::sphp_settings()->res_path . \SphpBase::sphp_settings()->slib_version . "/comp/ajax/res/ajax.js", true);
    }

    private function getFields($flds) {
        $strOut = '';
        foreach ($flds as $key => $val) {
            if (is_object($val)) {
                $strOut .= "params += '&". $val->name ."=' + encodeURIComponent(" . $val->getJSValue() . "); ";
            } else {
                $strOut .= "params += '&". $key ."=' + encodeURIComponent(". $val ."); ";
            }
        }
        return $strOut;
    }

    public function postDataAjax($url, $outputID, $showObj = '', $flds = Array(), $MIMEType = '', $data = false) {
        $this->getAjax();
        $jsOut = "var params = ''; ";
        if ($data) {
            $params = $this->getFields($flds);
        } else {
            $params = $data;
        }
        $jsOut .= "$params ";
        $jsOut .= "getPostData('". $url ."','". $outputID ."','". $showObj ."','". $MIMEType ."',params); ";
        return $jsOut;
    }

    public function getDataAjax($url, $outputID, $showObj = '') {
        $this->getAjax();
        $jsOut = "getData('". $url ."','". $outputID ."','". $showObj ."'); ";
        return $jsOut;
    }

}

class Session {
    private $name = "";
    private $mypath = "";
        
    public function setSessionName($name="SphpID") {
        $this->name = $name;
        \session_name($name);
        /*
        if(\SphpBase::sphp_request()->isCookie("SPHPID")){
            session_id(\SphpBase::sphp_request()->cookie("SPHPID"));
        }
        */ 
    }
    public function setSessionSavePath($path="") {
        $this->mypath = $path;
        \session_save_path($path);
    }
    public function closeSession() {
        \session_write_close();
    }
    public function sessionStart(){ 
        $sesID = $logType = $logID = $uid = "";
    $secure = false; // if you only want to receive the cookie over HTTPS
    $httponly = true; // prevent JavaScript access to session cookie
    $samesite = 'lax';
    $maxlifetime = 86400; //0;
    $domain1 = $_SERVER['HTTP_HOST'];
    $parsedUrl = parse_url($_SERVER['HTTP_HOST']);
    // remove port
    if(isset($parsedUrl['host'])) $domain1 = $parsedUrl['host'];
    
    if(PHP_VERSION_ID < 70300) {
        session_set_cookie_params($maxlifetime, '/; samesite='.$samesite, $domain1, $secure, $httponly);
    } else {
        session_set_cookie_params([
            'lifetime' => $maxlifetime,
            'path' => '/',
            'domain' => $domain1,
            'secure' => $secure,
            'httponly' => $httponly,
            'samesite' => $samesite
        ]);
    }
    if(session_status() < 2) session_start();
        if (\SphpBase::sphp_request()->IsSession("sesID")){
            \SphpBase::sphp_request()->request("sesID","");
//            if ( \SphpBase::sphp_request()->request("sesID"] !=  \SphpBase::sphp_request()->session("sesID"]){
//                print "Session is not valid ".  \SphpBase::sphp_request()->request("sesID"] . " = " .  \SphpBase::sphp_request()->session("sesID"] ;
//                print_r($_REQUEST);
//                exit();
//            }
        }else{
            if (! \SphpBase::sphp_request()->isSession("uid")){
                \SphpBase::sphp_request()->session("sesID", session_id());
                \SphpBase::sphp_request()->session("logType", "GUEST");
                \SphpBase::sphp_request()->session("uid", "");
            }
        }
        $sesID =  \SphpBase::sphp_request()->session("sesID");
        \SphpBase::sphp_settings()->setSession_id($sesID);
        $logType =  \SphpBase::sphp_request()->session("logType");
        if (\SphpBase::sphp_request()->isSession("logID")){
            $logID =  \SphpBase::sphp_request()->session("logID");
        }
        if (defined("autocompkey") && \SphpBase::sphp_request()->session("edtmode") == autocompkey){
            \SphpBase::sphp_settings()->blnEditMode = true;
        }
        $uid =  \SphpBase::sphp_request()->session("uid");
        \SphpBase::sphp_api()->setGlobal("sesID",$sesID);
        \SphpBase::sphp_api()->setGlobal("logType",$logType);
        \SphpBase::sphp_api()->setGlobal("logID",$logID);
        \SphpBase::sphp_api()->setGlobal("uid",$uid);
    }
    public function setSession($lType,$uid1){
        \SphpBase::sphp_request()->session("logType", $lType);
        \SphpBase::sphp_request()->session("uid",  $uid1);
        \SphpBase::sphp_api()->setGlobal("logType",$lType);
        \SphpBase::sphp_api()->setGlobal("uid",$uid1);
    }

    public function destSession(){
        /*
        \SphpBase::sphp_request()->unsetSession("sesID");
        \SphpBase::sphp_request()->unsetSession("logType");
        \SphpBase::sphp_request()->unsetSession("uid");
         * 
         */
        \SphpBase::sphp_request()->destroySession();
        \SphpBase::sphp_api()->setGlobal("logType","GUEST");
        \SphpBase::sphp_api()->setGlobal("uid","");
    }
    
}

/**
 * Description of jq
 *
 * @author Sartaj Singh
 */

class jq {

    public $jsstate = "of";

    public function __construct() {
        
    }

    public function __invoke($param1) {
        
    }

    public function __call($name, $arguments) {
        $JQuery = getJQuery();
        switch ($name) {
            case "get": {
                    return "jql(" . $arguments[0] . ")";
                    break;
                }
            case "getEventURL": {
                    $arg = $JQuery->stringtophpargu($arguments[0]);
                    if (!isset($arg[1]))
                        $arg[1] = "";
                    if (!isset($arg[2]))
                        $arg[2] = "";
                    if (!isset($arg[3]))
                        $arg[3] = "";
                    if (!isset($arg[4]))
                        $arg[4] = "";
                    if (!isset($arg[5]))
                        $arg[5] = false;
                    return "'" . getEventURL($arg[0], $arg[1], $arg[2], $arg[3], $arg[4], $arg[5]) . "'";
                    break;
                }
            case "getSJSPath": {
                    $arg = $JQuery->stringtophpargu($arguments[0]);
                    if (!isset($arg[1]))
                        $arg[1] = "";
                    if (!isset($arg[2]))
                        $arg[2] = "";
                    if (!isset($arg[3]))
                        $arg[3] = "";
                    if (!isset($arg[4]))
                        $arg[4] = "";
                    return "'" . getEventURL("backend_evt", $arg[0], $arg[1], $arg[2], $arg[3], $arg[4]) . "'";
                    break;
                }
            case "eval": {
                    if ($this->jsstate == "of") {
                        return "jql" . ".globalEval(" . $arguments[0] . ")";
                    } else if ($this->jsstate == "on") {
                        return "";
                        //return $JSServer->executePHP("echo ".$arguments[0].";");    
                    }
                    break;
                }
        }
    }

    public static function __callStatic($name, $arguments) {
    }

    public function __get($varName) {
        
    }

    public function __set($varName, $value) {
        
    }

    public function __toString() {
        return "jq";
    }

}

/**
 * Description of Eventer
 *
 * @author Sartaj Singh
 */

class Eventer{
        public $obj="";
        public $evt="";
        public $event="";
        public $ui="";
    public function __construct() { }

}
class Event{
        private $handlers = array();
        private $target = null;
        
    public function __construct($targetobj) {
        $this->target = $targetobj;
    }
    public function setHandler($eventhandlerobj, $handler) {
        array_push($this->handlers,array($eventhandlerobj, "$handler"));
    }
    public function raiseEvent($arglst = array()) {
        $arglst["obj"] = $this->target;
        foreach ($this->handlers as $key => $value) {
            call_user_func_array(array($value[0], $value[1]), array($arglst));            
        }
    }

}

}
