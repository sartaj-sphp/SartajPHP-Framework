<?php

namespace Sphp\core{


class DebugProfiler {
    /** @var array All Messages as associative array */
    public $msg = array();
    /** @var int $debugmode 0=no,1=only error,2=all 
     * @deprecated 4.4.8
     * @ignore
     */
    public $debugmode = 0;
    public $cur_front_file = "";
    private $maxErrorCounter = 0;

    public function __construct() {
        $this->debugmode = \SphpBase::sphp_settings()->debug_mode;
    }
    /**
     * Clear all messages
     */
    public function clearMe() {
        $this->msg = array();
    }
    /**
     * Add Message
     * @param string $msgb Message
     * @param string $errnob PHP Error Number like E_USER_ERROR
     * @param string $errfileb Error in filepath
     * @param string $errlineb Error Line Number
     * @param string $typeb default info 
     */
    public function setMsg($msgb, $errnob = "", $errfileb = "", $errlineb = "", $typeb = "info") {
        $this->msg[] = array($msgb, $errnob, $errfileb, $errlineb, $typeb);
    }
    /**
     * Add Info Message
     * @param string $msgc Message
     * @param string $errnoc PHP Error Number like E_USER_ERROR
     * @param string $errfilec Error in filepath
     * @param string $errlinec Error Line Number
     * @param string $typec default infoi 
     */
    public function setMsgi($msgc, $errnoc = "", $errfilec = "", $errlinec = "", $typec = "infoi") {
        $this->msg[] = array($msgc, $errnoc, $errfilec, $errlinec, $typec);
    }
    /**
     * Print Line
     * @param string $msg
     */
    public function println($msg) {
        $this->setMsg($msg, "", "", "", "plain");
    }
    /**
     * Print Object or Array
     * @param array|object $arr
     */
    public function print_r($arr) {
        $this->setMsg(json_encode($arr), "", "", "", "plain");
    }
    /**
     * Get All Messages
     * @return array
     */
    public function getMsg() {
        return $this->msg;
    }

    private function getFunctionArgs($caller) {
        $arglist = "";
        if (isset($caller['args'])) {
            $caller['args'] = array();
        foreach ($caller['args'] as $key2 => $fun) {
            $argfun = $this->getFunctionArgsR($fun,1);
            //$arglist .= $key2 . " : {" . $argfun . "} , ";
            if($argfun !== "") $arglist .= $argfun . ", ";
        }
        }
        return $arglist;
    }

    private function getFunctionArgsR($funs,$c) {
        $argfun = "";
        if (is_array($funs)) {
            return "Array";
        } else {
            if(is_string($funs)){
                $argfun = substr($funs,0,255);
            }else if(is_object($funs)){
                $class_info = new \ReflectionClass($funs);
                $argfun = $class_info->getFileName();
            }else{
                $argfun = $funs;
            }
        }
        return $argfun;
    }
    private function getFunctionArgsR2($funs,$c) {
        $argfun = "";
        if (is_array($funs)) {
            if($c<2){
            foreach($funs as $keyn => $funn) {
                $argfun .= $keyn . " : " . $this->getFunctionArgsR($funn,$c+1) . " , ";
            }
            }else{ 
                return $argfun;
            }
        } else {
            if(is_string($funs)){
                $argfun = substr($funs,0,255);
            }else if(is_object($funs)){
                $class_info = new \ReflectionClass($funs);
                $argfun = $class_info->getFileName();
            }else{
                $argfun = $funs;
            }
        }
        return $argfun;
    }

    private function getErrorType($errno1) {
        switch ($errno1) {
            case E_USER_ERROR: return "SartajPHP Fatal ERROR [". $errno1 ."]";
            case E_USER_WARNING: return "SartajPHP WARNING [". $errno1 ."]";
            case E_USER_NOTICE: return "SartajPHP NOTICE [". $errno1 ."]";
            default: return "SartajPHP UNKNOWN [". $errno1 ."]";
        }
    }
    protected function traceBack($errnom, $errstr, $errfile, $errline,$debug_arry) {
        
        if ($this->maxErrorCounter > 0) {
            // This error code is not included in error_reporting
            return;
        }
        $this->maxErrorCounter += 1;
//        $this->setMsg($errstr,$errno,$errfile,$errline,"error");
        $errnoa = $this->getErrorType($errnom);        
        $arglist = "";
        $objname = "";
        $callerline = 0;
        $filepath = "";
        $filept = "";
        
        //future work
        //$e = new Exception;
        //var_dump($e->getTraceAsString());

        $this->setMsg($errstr , $errnom, $errfile, $errline, "error");
        $errstr = "";
        $arc = array("traceBack","SphpErrorHandler","eval","executePHPCode");
        foreach ($debug_arry as $key => $caller) { 
            $ar = array();
            if(!isset($caller["file"])){
                $caller["file"] = "";
            }
            if(!isset($caller["line"])){
                $caller["line"] = 0;
            }
            if(!isset($caller["class"])){
                $caller["class"] = "";
            }
            if(!isset($caller["object"])){
                $caller["object"] = "";
            }
            if(!isset($caller["type"])){
                $caller["type"] = "";
            }
            if(! in_array($caller["function"], $arc)){ 
            $ar['file'] = $caller["file"];
            $ar['line'] = $caller["line"];
            $ar['function'] = $caller["function"];
            $ar['class'] = $caller["class"];
            //$ar['object'] = $caller["object"];
            $ar['type'] = $caller["type"];
            $ar["arglist"] = $this->getFunctionArgs($caller);
//            $ar['error_type'] = $args[0];
            //$ar['error_msg'] = $args[1];
//            $ar['error_file'] = $args[2];
//            $ar['error_line'] = $args[3];
           // $ar['error_args'] = $args[4];
            if($ar["line"]==0){
                $errstr = ":Error Msg: (" . $ar["arglist"] . ')ENDMsg ' ;                
            }else{
                $errstr = " Call". $this->maxErrorCounter ."[" . $ar["class"] . $ar["type"] . $ar["function"] . "(". $ar["arglist"] .")]";
            }
            $this->setMsg($errstr , $errnoa, $ar['file'], $ar["line"], "error");
            }
            
    
        }
        
        //$this->write_log($errstr);

    }
    /**
     * Advance Function, Internal Use
     */
    public function callerFun() {
        $dbt=debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,2);
        $caller = isset($dbt[1]['function']) ? $dbt[1]['function'] : null;
    }
    /**
     * Advance Function, Internal Use
     */
    public function SphpErrorHandler($errnom, $errstr, $errfile, $errline) {
        if(strpos($errfile,"/HTMLParser.php")) $errfile = $this->cur_front_file;
        $msg = "SartajPHP Fatel Error:- Type:-".$errnom ." Msg:-". $errstr." File:-". $errfile." on line no. ". $errline ;
        
        $debug_arry = debug_backtrace(0,10);
        $errnoa = $this->getErrorType($errnom);        
        //$arc = array("traceBack");
        $arc = array("traceBack","eval","executePHPCode");
        $errstr = "";
        foreach ($debug_arry as $key => $caller) { 
            $ar = array();
            if(!isset($caller["file"])){
                $caller["file"] = "";
            }
            if(!isset($caller["line"])){
                $caller["line"] = 0;
            }
            if(!isset($caller["class"])){
                $caller["class"] = "";
            }
            if(!isset($caller["object"])){
                $caller["object"] = "";
            }
            if(!isset($caller["type"])){
                $caller["type"] = "";
            }
            if(! in_array($caller["function"], $arc)){ 
            if(strpos($caller["file"],"/HTMLParser.php")) $caller["file"] = $this->cur_front_file;
            $ar['file'] = $caller["file"];
            $ar['line'] = $caller["line"];
            $ar['function'] = $caller["function"];
            $ar['class'] = $caller["class"];
            //$ar['object'] = $caller["object"];
            $ar['type'] = $caller["type"];
            $ar["arglist"] = $this->getFunctionArgs($caller);
//            $ar['error_type'] = $args[0];
            //$ar['error_msg'] = $args[1];
//            $ar['error_file'] = $args[2];
//            $ar['error_line'] = $args[3];
           // $ar['error_args'] = $args[4];
            if($ar["line"]==0){
                $errstr = ":Error Msg: (" . $ar["arglist"] . ')ENDMsg ' ;                
            }else{
                $errstr = " Call". $this->maxErrorCounter ."[" . $ar["class"] . $ar["type"] . $ar["function"] . "(". $ar["arglist"] .")]";
            }
            $this->setMsg($errstr , $errnoa, $ar['file'], $ar["line"], "error");
            }
            
    
        }
        //echo $msg;
        $this->write_log($msg);
        \SphpBase::engine()->sendDataCaseOfError($msg,$errfile,$errline,false);
        // not reachable, fatel error close php
        //$this->traceBack($errnom, $errstr, $errfile, $errline);
    }
/*
    public function SphpErrorHandler2($errnom, $errstr, $errfile, $errline) {
        $ctrl = "";
        $router = $this->engine->getRouter();
        $ctrl = $router;
        $blnerrorLog = false;
        if (!(error_reporting() & $errnom)) {
            // This error code is not included in error_reporting
            return;
        }
        if ($this->errorLog) {
            $blnerrorLog = true;
        }
//        $this->setMsg($errstr,$errno,$errfile,$errline,"error");
        $errnoa = $this->getErrorType($errnom);

        $debug_arry = debug_backtrace();

        $arglist = "";
        $objname = "";
        $callerline = 0;
        $filepath = "";
        $filept = "";
        foreach ($debug_arry as $key => $caller) {
            if($callerline!=0){
            if (!isset($caller['object']) && isset($caller['line']) && $caller['line'] != 0) {
                $arglist = $this->getFunctionArgs($caller);
                if (strpos($caller['file'], 'HTMLParser') === 0) {
                    $this->setMsg($errstr . ":function call: " . $caller['function'] . "(". $arglist .")", $errnoa, $caller['file'], $callerline, "error");
                    $errstr = "";
//        $errstr .= ' in <strong>'.' - '.$caller['function'].'</strong> called from <strong>'.$caller['file'].'</strong> on line <strong>'.$caller['line'].'</strong><br />';
                }
            } else if (isset($caller['object'])) {
                if (is_object($caller['object'])) {
                    $class_info = new \ReflectionClass($caller['object']);
                    if (property_exists($caller['object'], 'filePath') && $caller['object']->filePath != "") {
                        $filept = $caller['object']->filePath;
                    } else if (property_exists($caller['object'], 'path') && $caller['object']->mypath != "") {
                        $filept = $caller['object']->mypath;
                    } else {
                        $filept = $class_info->getFileName();
                    }
                    if (property_exists($caller['object'], 'name')) {
                        $objname = $caller['object']->name;
                    } else {
                        $objname = "";
                    }
                    $element = "";
                    if ($caller['class'] == 'FrontFile') {
                        $element = htmlentities($caller['object']->HTMLParser->curelement->getOuterHTML());
                    }
                    if (!isset($caller['line'])) {
                        $caller['line'] = 0;
                    }
//        $errstr .= '  Error In Object Found:- <strong>'.$objname."</strong> Type:- <strong>" . $caller['class'].'</strong> Caller:- <strong>' . $caller['function'].'</strong> Source File:- <strong>' . $filept.'</strong>  <br /> '.$element.'<br />';
                    $this->setMsg($errstr . ":Error In Object Found: " . $objname . ":Type: " . $caller['class'] . ":Caller: " . $caller['function'] . ":Element: " . $element, $errnoa, $filept, $callerline, "error");
                    $errstr = "";
                    //$errstr .= '  Object Path:- <strong>'.$caller['object']->mypath." Pathres:- " . $caller['object']->myrespath.'</strong>   <br/>';
                }
            }
                $callerline = $caller['line'];
            }else{
                if(isset($caller['line'])){
                $callerline = $caller['line'];
                }
            }  
        }
    }
*/
    public function write_log($log_data) {
        if (\SphpBase::sphp_settings()->enable_log) {
        $log_str = "
[" . date('Y-m-d: H:i:s') . '] URL:- ' . $_SERVER["REQUEST_URI"] .' ';
        /*    $log_str = "[".date('Y-m-d: H:i:s').'] Server Status:- '. json_encode($_SERVER);
          $log_str .= '
          Request Status:- '. json_encode($_REQUEST). '
          ';
         * $this->request->getEngineRootPath() .
         */
        try{
            //is_writable
            if(filesize(\SphpBase::sphp_settings()->start_path . "/cache/Sphp_errorLog.txt") > 100000){
        file_put_contents(\SphpBase::sphp_settings()->start_path . "/cache/Sphp_errorLog.txt", $log_str . $log_data . " 
                ENDLOG_DATA");
            }else{
        file_put_contents(\SphpBase::sphp_settings()->start_path . "/cache/Sphp_errorLog.txt", $log_str . $log_data . " 
                ENDLOG_DATA", FILE_APPEND);
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }
        }
    }
    /**
     * Advance Function, Internal Use
     */
    public function Sphp_exception_handler($exception) {
        $filen = $exception->getFile();
        if(strpos($filen,"/HTMLParser.php")) $filen = $this->cur_front_file;
        $linen = $exception->getLine();
        //$errnom = $exception->getCode();
        $msg = "SartajPHP Exception: " . $exception->getMessage() . " File:- $filen On Line:-" . $linen;
        //$msg .= $exception->getTraceAsString();
        //$debug_arry = debug_backtrace(0,10);
        //$debug_arry = array_merge($exception->getTrace(),$exception->getPrevious()->getTrace());
        $debug_arry = $exception->getTrace();
        $errnoa = $this->getErrorType(E_USER_ERROR);        
        $this->setMsg($msg , $errnoa, $filen, $linen, "error");
        $arc = array("traceBack","SphpErrorHandler","eval","executePHPCode");
        $errstr = "";
        foreach ($debug_arry as $key => $caller) { 
            $ar = array();
            if(!isset($caller["file"])){
                $caller["file"] = "";
            }
            if(!isset($caller["line"])){
                $caller["line"] = 0;
            }
            if(!isset($caller["class"])){
                $caller["class"] = "";
            }
            if(!isset($caller["object"])){
                $caller["object"] = "";
            }
            if(!isset($caller["type"])){
                $caller["type"] = "";
            }
            if(! in_array($caller["function"], $arc)){ 
            if(strpos($caller["file"],"/HTMLParser.php")) $caller["file"] = $this->cur_front_file;
            $ar['file'] = $caller["file"];
            $ar['line'] = $caller["line"];
            $ar['function'] = $caller["function"];
            $ar['class'] = $caller["class"];
            //$ar['object'] = $caller["object"];
            $ar['type'] = $caller["type"];
            $ar["arglist"] = $this->getFunctionArgs($caller);
//            $ar['error_type'] = $args[0];
            //$ar['error_msg'] = $args[1];
//            $ar['error_file'] = $args[2];
//            $ar['error_line'] = $args[3];
           // $ar['error_args'] = $args[4];
            if($ar["line"]==0){
                $errstr = ":Error Msg: (" . $ar["arglist"] . ')ENDMsg ' ;                
            }else{
                $errstr = " Call". $this->maxErrorCounter ."[" . $ar["class"] . $ar["type"] . $ar["function"] . "(". $ar["arglist"] .")]";
            }
            $this->setMsg($errstr , $errnoa, $ar['file'], $ar["line"], "error");
            }
            
    
        }

        //echo "SPHP Uncaught exception: " . $msg . "<br />\n";
        //$this->setMsg("Sphp Uncaught exception: " . $msg , "Sphp Uncaught exception", "", 0, "error");
        $this->write_log($msg);
        \SphpBase::engine()->sendDataCaseOfError($msg,$filen,$linen,false);
    }

    /**
     * Advance Function, Internal Use
     */
    public function Sphp_handle_fatal() {
        // handle shut down error
        //$errorLog = true;
        $error = error_get_last();
        if ($error !== null && $error["type"] == E_ERROR) {
            if(strpos($error["file"],"/HTMLParser.php")) $error["file"] = $this->cur_front_file;
            $this->SphpErrorHandler($error["type"], $error["message"], $error["file"], $error["line"]);
//        }else{
           //throw new Exception("Shutdown, Debuger couldn't Catch Error! Check SartajPHP Framework properly loaded");
            //print_r(debug_backtrace());
  //          $this->traceBack(E_USER_ERROR, "Shutdown, Debuger couldn't Catch Error!", "", 0); 
    //        \SphpBase::engine()->sendDataCaseOfError("","",0);
        }
    }
    /**
     * Print All as HTML
     */
    public function printAll() {
        foreach ($this->msg as $key => $value) {
            if ($value[4] == "info") {
                echo $value[0] . "<br>\n";
            }else if($value[4] == "infoi"){
                echo $value[0] . "<br>\n";
            }else{
                echo "$value[2] - $value[0] " . " $value[1] - $value[3]" . "<br>\n";
            }
        }
        echo traceError(false).' '.traceErrorInner(false) . "<br>\n";
    }
    /**
     * Write message on JS Console
     * @param string $msg
     * @param string $type default=log, info,error
     * @return type
     */
    protected function consoleMsg($msg,$type="log"){
        return \SphpBase::sphp_api()->consoleMsg($msg,$type);
    }
    /**
     * Advance Function, Internal Use
     */
    protected function renderHexMode() { 
        $C = 0;
        $str1 = '';
        try{
           
        foreach ($this->msg as $key=>$value) { 
            if($C > 90){
                break ;
            }
            if($value[4]=="info"){
                //$C += 1;
                //$firephp->info($value[0]);
                 $str1 .= $this->consoleMsg($value[0],"log");
            }else if($value[4]=="infoi"){
                $C += 1;
                 $str1 .= $this->consoleMsg($value[0],"info");
            }else{
                $C += 1;
                $str1 .= $this->consoleMsg("$value[2] - $value[0]" . " $value[1] - $value[3]","error");
            }
        }
        if(function_exists("getCheckErr") && getCheckErr()){
            $str1 .= traceError(false).' '.traceErrorInner(false);
            $this->write_log($str1);
        }
        }  catch (Exception $e){
            echo 'Debugger Failed: ',  $e->getMessage(), "\n";
            $this->write_log('Debugger Failed: ',  $e->getMessage(), "\n");
        }
        //$str1 .= '</script>';
        addFooterJSCode("debugger1",'/* start debug */' . $str1 . '/* end debug */');
        
    }

    /**
     * Advance Function, Internal Use
     */
    public function render() {
        if(\SphpBase::sphp_settings()->response_method == "HEX"){
            $this->renderHexMode(); 
        }else if(\SphpBase::sphp_request()->mode =="CLI"){
            $sphp_api = \SphpBase::sphp_api();
            foreach ($this->msg as $key => $value) {
                if ($value[4] == "info") {
                    $sphp_api->consoleWriteln($value[0]);
                }else if($value[4] == "infoi"){
                    $sphp_api->consoleWriteln($value[0]);                    
                }else{
                    $sphp_api->consoleError("$value[2] - $value[0] " . " $value[1] - $value[3]");                     
                }
            }
        }else if(\SphpBase::sphp_request()->type == "AJAX"){
            $this->renderHexMode();
        }else if(\SphpBase::sphp_settings()->response_method == "HTMLY"){
        echo '<table class="table table-striped table-bordered table-condensed">';
        echo '<tr><th>Type</th><th>Line</th><th>Details</th><th>File</th></tr>';
        foreach ($this->msg as $key => $value) {
            if ($value[4] == "info") {
                echo '<tr class="info">';
                echo "<td>INFO</td><td>" . $value[3] . "</td><td>" . $value[0] . "</td><td>" . $value[3] . "</td>";
                echo '</tr>';
            }else if($value[4] == "infoi"){
                echo '<tr class="info">';
                echo "<td>INFOI</td><td>" . $value[3] . "</td><td>" . $value[0] . "</td><td>" . $value[3] . "</td>";
                echo '</tr>';
            } else {
                echo '<tr>';
                echo "<td>" . $value[1] . " - " . $value[4] . "</td><td>" . $value[3] . "</td><td>". $value[0] . "</td><td>" . $value[2] . "</td>";
                echo '</tr>';
            }
        }
        echo '</table>';
    }else{
        $this->renderHexMode();        
    }
    }

}
class DebugProfiler2 extends DebugProfiler {
    //overwrite method for save memory on debug mode off
    // only log file availble
    public function setMsg($msgb, $errnob = "", $errfileb = "", $errlineb = "", $typeb = "info") {
    }

    public function setMsgi($msgc, $errnoc = "", $errfilec = "", $errlinec = "", $typec = "infoi") {
    }

    public function println($msg) {
    }

    public function print_r($arr) {
    }

    
}

}
