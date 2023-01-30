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
public function setDebugger(){}
public function start()
{}
public function executeinit()
{}
public function execute($globalapp = false)
{}
public function sendDataCaseOfError($ermsg="",$erfile="",$erline=0) {}
public function stopOutput(){}
public function cleanOutput(){}
public function registerRouter($rout)
{}
public function getRequest(){}
public function getResponse(){}
public function getSettings(){}
public function getRouter(){}
public function getSphpAPI() {}
public function getSession() {}
/** 
* Get Default Page Object to develop page application.
* @return page
*/
public function getDefaultPageObject() {}
/** 
* Set Default Page Object to develop page application.
* @return void
* @deprecated 4.4.8
*/
public function setDefaultPageObject($pageobject){}
public function getDebug() {}
public function getDBEngine() {}
public function setDBEngine($dbengine) {}
public function getJSServer() {}
public function getJQuery() {}
public function getDrespath() {}
public function getDphppath() {}
public function setDrespath($drespath) {}
public function setDphppath($dphppath) {}
}
}
