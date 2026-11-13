<?php
namespace Sphp\Gates{
/**
* Description of SubApp
*
* @author Sartaj Singh
*/
/**
* SubGate is a gate class that extends SphpGate to provide sub-application
* functionality. It manages front files, page events, and rendering for
* sub-gate pages within the SartajPHP framework.
*/
class SubGate extends \Sphp\Tools\SphpGate{
/** @var \Sphp\Kit\Page page */
public $page = "";
/** @var FrontFile frontform */
public $frontform;
/** @var FrontFile mainfrontform */
public $mainfrontform;
public $gateDirPath = "";
public $resourcePath = "";
public $resourceUrl = "";
/** @var \Sphp\Kit\JsServer jsServer */
public $jsServer = null;
/** @var \Sphp\Kit\Request client */
public $client = null;
/** @var \Sphp\Kit\MySQL dbEngine */
public $dbEngine = null;
/** @var \Sphp\Core\DebugProfiler debug */
public $debug = null;
public $cfilename = "";
public $cfilepath = "";
public $myPath = "";
public $myUrl = "";
/**
* Constructor. Initializes page, jsServer, client, dbEngine, debug,
* front file, and class path, then calls onstart().
* @return void
*/
/**
* Sets up the front file and triggers the onfrontinit event.
* @param FrontFile $frontobj the front file object
* @return void
*/
public function setup($frontobj){}
/**
* Processes the front file by triggering the onfrontprocess event.
* @param FrontFile $frontobj the front file object
* @return void
*/
public function process($frontobj){}
/**
* Processes the current page event by triggering the gate event
* and calling page events.
* @return void
*/
public function processEvent(){}
/**
* Calls the appropriate page event handler based on the current
* page state (event, new, or submit) and renders the front file.
* @return void
*/
/**
* Set Internal Front File. Internal Front File Also render Page Components.
* @param FrontFile $obj 
*/
public function setFrontFile($obj){}
/**
* Gets the internal front file object.
* @return FrontFile the front file object
*/
public function getFrontFile() {}
/**
* Shows the front file by setting the frontform flag to true.
* @return void
*/
public function showFrontFile(){}
/**
* Hides the front file by setting the frontform flag to false.
* @return void
*/
public function showNotFrontFile(){}
/**
* Sets the table name for the page and the gate.
* @param string $dbtable the database table name
* @return void
*/
public function setTableName($dbtable){}
/**
* Gets the table name.
* @return string the table name
*/
public function getTableName(){}
/**
* Called at the start of the gate. Override in subclasses.
* @return void
*/
public function onstart(){}
/**
* Called when the gate is ready. Override in subclasses.
* @return void
*/
public function onready(){}
/**
* Called when the front file is initialized. Override in subclasses.
* @param FrontFile $frontobj the front file object
* @return void
*/
public function onfrontinit($frontobj){}
/**
* Called when the front file is processed. Override in subclasses.
* @param FrontFile $frontobj the front file object
* @return void
*/
public function onfrontprocess($frontobj){}
/**
* Called when the page is submitted. Override in subclasses.
* @return void
*/
public function page_submit(){}
/**
* Called when a new page is loaded. Override in subclasses.
* @return void
*/
public function page_new(){}
/**
* Gets the current event name.
* @return string the event name
*/
public function getEvent(){}
/**
* Gets the current event parameter.
* @return mixed the event parameter
*/
public function getEventParameter(){}
/**
* Called when the gate runs. Override in subclasses.
* @return void
*/
public function onrun(){}
/**
* Called when the gate renders. Override in subclasses.
* @return void
*/
public function onrender(){}
/**
* Runs the gate by calling onready, onrun, and processEvent.
* @return void
*/
public function run(){}
/**
* Renders the gate by calling onrender.
* @return void
*/
public function render(){}
/**
* Sets the authentication level for the page.
* @param string $authenticates the authentication level
* @return void
*/
public function getAuthenticate($authenticates){}
/**
* Enables session security for the page.
* @return void
*/
public function getSesSecurity(){}
/**
* Sets the class path, file name, and URL from the reflection class.
* @return void
*/
public function setClassPath() {}
}
}
