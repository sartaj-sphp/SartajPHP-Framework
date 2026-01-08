<?php
namespace Sphp{
use Sphp\core\Request;
use Sphp\core\Response;
use Sphp\core\Router;
use Sphp\core\SphpAPI;
use Sphp\core\AppLoader;
use Sphp\core\DebugProfiler;
use Sphp\core\DebugProfiler2;
use Sphp\kit\Session;
use Sphp\kit\JQuery;
use Sphp\kit\JSServer;
use Sphp\kit\Page;
use Sphp\core\SphpVersion;


final class Engine{
    public $engine_start_time = 0.0;
    public $engine_end_time = 0.0;
    public $drespath = "";
    public $dphppath = "";
    
    private $router = null;
    private $request = null;
    private $response = null;
    private $settings = null;
    private $sphp_api = null;
    private $session = null;
    private $app_loader = null;
    private $debug = null;
    private $js_server = null;
    private $js_jquery = null;
    private $page = null;
    private $dbEngine = null;
    private $bnlStopOutput = false;
    
    public function __construct()
    {
        $this->settings = \SphpBase::sphp_settings();
        $this->request = \SphpBase::sphp_request();
        $this->sphp_api = new SphpAPI();
        $this->response = new Response();
        $this->router = new Router();
        $this->session = new Session();
        $this->app_loader = new AppLoader();
        $this->js_server = new JSServer();
        $this->js_jquery = new JQuery();
        $this->setDebugger();
        $dbenginea = explode(",",$this->settings->db_engine_path);
        include_once($dbenginea[0]);
        $this->dbEngine = new $dbenginea[1]($this);
    }
    public function exitMe() {
        \SphpBase::engine()->execute(true);
        exit();
    }
    public function setDebugger(){
        if($this->settings->debug_mode > 0){
           if($this->settings->debug_profiler!=""){
                require $this->settings->debug_profiler;
                $this->debug = new \SphpProfiler();
            }else{
                $this->debug = new DebugProfiler();    
            }
            if(\SphpBase::$stmycache->mode !== "CLI") register_shutdown_function(array($this->debug,"Sphp_handle_fatal"));      
        }else{
            $this->debug = new DebugProfiler2();    
        }
        //set error handler
        set_error_handler(array($this->debug,"SphpErrorHandler"),E_ALL);
        //set_error_handler(array($this->debug,"Sphp_exception_handler"),E_ALL);
        set_exception_handler(array($this->debug,"Sphp_exception_handler"));
    }
    public function start()
    {
        if($this->settings->debug_mode){
            $this->engine_start_time = microtime(true);
            //$this->engine_start_time = \SphpBase::$stmycache->ytetimestart2;
        }
        //$e2 = microtime(true);
        //create dbengine object
        $this->request->parseRequest();
        $this->router->route(); 
        //$e1 = microtime(true);
        //$extime = ($e1 - $e2) * 1000;
        //$this->debug->println("route:- " . $extime);  
        /** 
         * Default Page Object to develop page application.
         * @var Page $page
         */
        \SphpBase::set_page(new Page());
        $this->page = \SphpBase::page();
    }
    public function executeinit()
    {
        if(\SphpBase::$stmycache->blnCashExp){
//            if (substr_count($_SERVER["HTTP_ACCEPT_ENCODING"], "gzip")){ ob_start("ob_gzhandler");}
  //             else{ ob_start("ob_gzhandler");}
            ob_start();
            $this->request->restoreSessionFromStorage();
            $notglobalapp = $this->app_loader->_load();
            
            if($notglobalapp[0]){
                if (!$this->bnlStopOutput && $this->js_server->jsonready) {
                    $this->response->setContent($this->js_server->getResponse());
                }else{
                    $this->response->setContent($this->sendResponse());
                }
            }
                return $notglobalapp;
            
        }else{
            return array(true,"");
        }
    }
    public function execute($globalapp = false)
    {
        if($globalapp){
            if (!$this->bnlStopOutput && $this->js_server->jsonready) {
                $this->response->setContent($this->js_server->getResponse());
            }else{
                $this->response->setContent($this->sendResponse()); 
            }
        }

        $this->request->saveSessionToStorage();
        if(!$this->settings->blnStopResponse){
            $this->response->send();
        }
        //clear debugger buffer
        $this->debug->clearMe();
        //echo $this->engine_end_time - $this->engine_start_time ;
    }
    
    public function sendDataCaseOfError($ermsg="",$erfile="",$erline=0,$nofatel=true) {
        $h = "";
        $stra2 = 'Current Front File:- '. \SphpBase::debug()->cur_front_file . ' Error Msg:- '
        . "Error:- $ermsg file:- " . $erfile . " on line $erline";
        //$this->js_server->jsonready = true;
        //$this->js_server->addJSONJSBlock('console.log("Error:- "); ');
        if ($this->request->isAJAX()) {
            $this->js_server->addJSONHTMLBlock('sphpmsg', "Something goes wrong!");
            $this->js_server->addJSONJSBlock(\SphpBase::sphp_api()->consoleMsg($stra2  . strip_tags($h) .' Error:- app:- '. \SphpBase::page()->appfilepath,"log"));
            $this->response->setContent($this->js_server->getResponse());
        }else if(\SphpBase::sphp_request()->mode == 'CLI'){
            if($this->debug->debugmode > 1){
                $h = ob_get_clean();
            }
            echo $stra2 . " Error:- $ermsg $h app:- " . \SphpBase::page()->appfilepath . " on line $erline";
        }else{
            if($this->debug->debugmode > 1){
                $h = ob_get_clean();
            }
            \SphpBase::sphp_settings()->response_method = "HTMLY"; 
            $str1 = '<div>' . $stra2  
                    .'</div><h2>Extra:-</h2>' . htmlentities($h) ;
            $dynData = new tools\FrontFile("<h1>Error !</h1>" . $str1,true);
            $dynData->_run();
            \SphpBase::$dynData = $dynData;
            // global code will remove in future
            $this->sphp_api->setGlobal("dynData",$dynData);
            includeOnce(\SphpBase::sphp_settings()->slib_path . "/masters/default/master_err.php");
            $this->response->setContent($this->sendResponse()); 
        }
        $this->response->send($nofatel);
        $this->debug->clearMe();
        exit();
    }
    
    public function stopOutput(){
        $htmlPageOut = "";
        $arbuf1 = ob_get_status(true);
        if(count($arbuf1)>0){
            $htmlPageOut = ob_get_contents();
            if(!$this->settings->blnStopResponse){
                ob_end_clean();
                $this->bnlStopOutput = true;
            }
        }
    }
    public function cleanOutput(){
        $htmlPageOut = "";
        $htmlPageOut = ob_get_contents();
    }
    private function sendResponse(){
        $htmlPageOut = "";
        // process application
//        includeOnce("{$phppath}/sphp/widgets/page.php");
        if(! $this->bnlStopOutput){
            $arbuf1 = ob_get_status(true);
            if(count($arbuf1)>0){
                $htmlPageOut = ob_get_contents(); 
                ob_end_clean();
            }
        }
        //print "$htmlfileName";
        return $htmlPageOut;

    }
    
    public function registerRouter($rout)
    {
        $this->router = $rout;
    }
    public function getRequest(){
        return $this->request;
    }
    public function getResponse(){
        return $this->response;
    }
    public function getSettings(){
        return $this->settings;
    }
    public function getRouter(){
        return $this->router;
    }
    public function getSphpAPI() {
        return $this->sphp_api;
    }
    public function getSession() {
        return $this->session;
    }
    /** 
     * Get Default Page Object to develop page application.
     * @return page
     */
    public function getDefaultPageObject() {
        return $this->page;
    }
    /** 
     * Set Default Page Object to develop page application.
     * @return void
     * @deprecated 4.4.8
     */
    public function setDefaultPageObject($pageobject){
        \SphpBase::set_page($pageobject);
        $this->page = \SphpBase::page();
    }
    public function getDebug() {
        return $this->debug;
    }
    public function getDBEngine() {
        return $this->dbEngine;
    }
    public function setDBEngine($dbengine) {
        $this->dbEngine = $dbengine;
        \SphpBase::set_dbEngine($dbengine);
    }
    public function getJSServer() {
        return $this->js_server;
    }
    public function getJQuery() {
        return $this->js_jquery;
    }
    public function getDrespath() {
        return $this->drespath;
    }
    public function getDphppath() {
        return $this->dphppath;
    }
    public function setDrespath($drespath) {
        $this->drespath = $drespath;
        $this->sphp_api->setGlobal("drespath", $drespath);
    }
    public function setDphppath($dphppath) {
        $this->dphppath = $dphppath;
        $this->sphp_api->setGlobal("dphppath", $dphppath);
    }
}

}
