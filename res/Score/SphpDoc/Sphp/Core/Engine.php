<?php
namespace Sphp{
use Sphp\Core\Request;
use Sphp\Core\Response;
use Sphp\Core\Router;
use Sphp\Core\SphpAPI;
use Sphp\Core\GateLoader;
use Sphp\Core\DebugProfiler;
use Sphp\Core\DebugProfiler2;
use Sphp\Kit\Session;
use Sphp\Kit\JsServer;
use Sphp\Kit\Page;
use Sphp\Core\SphpVersion;
/**
* Engine
* Core engine class of SartajPHP framework. It initializes and manages all core
* components like Request, Response, Router, Settings, SphpAPI, Session, GateLoader,
* jsServer, JQuery, Page, DBEngine and Debug profiler. It handles the full request
* lifecycle: parsing request, routing, loading gates, executing, sending response,
* and error handling.
*/
class Engine{
/** @var float engine start time in microtime */
public $engineStartTime = 0.0;
/** @var float engine end time in microtime */
public $engineEndTime = 0.0;
/** @var string resource url */
public $dresourceUrl = "";
/** @var string res folder path */
public $dresourcePath = "";
/**
* init
* Initializes all core components of the engine.
*/
/**
* Exit Me
* Executes the engine and exits the script.
*/
public function exitMe() {}
/**
* Set Debugger
* Sets up the debug profiler and error/exception handlers based on settings.
*/
public function setDebugger(){}
/**
* Start
* Starts the engine: records start time, parses request, routes, and sets default page.
*/
public function start()
{}
/**
* Execute Init
* Initializes execution: starts output buffering, restores session, loads gates,
* and sets response content.
* @return array
*/
public function executeinit()
{}
/**
* Execute
* Executes the engine: sends response content, saves session, and sends response.
* @param boolean $globalGate Optional default false
*/
public function execute($globalGate = false)
{}
/**
* Send Data Case Of Error
* Sends error response to client based on request type (AJAX, CLI, or HTML).
* @param string $ermsg Error message
* @param string $erfile Error file
* @param int $erline Error line
* @param boolean $nofatel Optional default true
*/
public function sendDataCaseOfError($ermsg="",$erfile="",$erline=0,$nofatel=true) {}
/**
* Stop Output
* Stops output buffering and cleans output if not stopping response.
*/
public function stopOutput(){}
/**
* Clean Output
* Gets output buffer contents.
*/
public function cleanOutput(){}
/**
* Send Response
* Private method to get HTML page output from buffer.
* @return string
*/
/**
* Register Router
* Sets the router object.
* @param Router $rout
*/
public function registerRouter($rout)
{}
/**
* Get Request
* @return Request
*/
public function getRequest(){}
/**
* Get Response
* @return Response
*/
public function getResponse(){}
/**
* Get Settings
* @return Settings
*/
public function getSettings(){}
/**
* Get Router
* @return Router
*/
public function getRouter(){}
/**
* Get Sphp API
* @return SphpAPI
*/
public function getSphpApi() {}
/**
* Get Session
* @return Session
*/
public function getSession() {}
/** 
* Get Default Page Object to develop page Gate.
* @return page
*/
public function getDefaultPageObject() {}
/**
* Get Debug
* @return DebugProfiler
*/
public function getDebug() {}
/**
* Get DB Engine
* @return DBEngine
*/
public function getDbEngine() {}
/**
* Set DB Engine
* @param DBEngine $dbengine
*/
public function setDbEngine($dbengine) {}
/**
* Get JS Server
* @return jsServer
*/
public function getJsServer() {}
/**
* Get D Res Path
* @return string
*/
public function getDresourceUrl() {}
/**
* Get D Php Path
* @return string
*/
public function getDresourcePath() {}
/**
* Set D Res Path
* @param string $dresourceUrl
*/
public function setDresourceUrl($dresourceUrl) {}
/**
* Set D Php Path
* @param string $dresourcePath
*/
public function setDresourcePath($dresourcePath) {}
}
}
