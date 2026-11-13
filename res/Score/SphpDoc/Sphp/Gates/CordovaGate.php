<?php
namespace Sphp\Gates{
/**
* Description of MobileApp
*
* @author Sartaj Singh
*
* CordovaGate is a Gate class for building Apache Cordova mobile applications.
* It extends BasicGate and provides functionality to generate Cordova project
* files, manage mobile pages, distribute JS/CSS libraries, and handle mobile
* device events. It creates the www folder structure, configures the Cordova
* plugin, and renders the mobile HTML output.
*/
require_once(\SphpBase::sphpSettings()->libPath . "/Sphp/Lib/Dir.php");
include_once(\SphpBase::sphpSettings()->libPath . "/Sphp/Lib/HtmlMinifier.php");
class CordovaGate extends BasicGate{
/** @var string $mobRegisterGate Mobile registration gate name */
public $mobRegisterGate = "HelloCordova";
/** @var string $mobGateid Mobile Gate ID */
public $mobGateid = "com.sartajphp.hellocordova";
/** @var string $mobGateversion Mobile Gate version */
public $mobGateversion = "0.0.1";
/** @var int $mobGateversion1 Mobile Gate version number */
/** @var string $mobGatedes Mobile Gate description */
public $mobGatedes = "A sample Apache Cordova Gate that responds to the deviceready event.";
/** @var string $mobGateauthor Mobile Gate author */
public $mobGateauthor = "Apache Cordova Team";
/** @var string $mobGateauthorEmail Mobile Gate author email */
public $mobGateauthorEmail = "dev@cordova.apache.org";
/** @var string $mobGateauthorWeb Mobile Gate author website */
public $mobGateauthorWeb = "https://cordova.apache.org";
/** @var array $sjsobj Server-side JS objects */
public $sjsobj = array();
/** @var boolean $blnsjsobj Enable server-side JS */
public $blnsjsobj = true;
/** @var object $sphpApi Sphp API instance */
public $sphpApi = null;
/** @var string $cfilename Class file name */
public $cfilename = "";
/** @var object $dir Directory helper */
public $dir = null;
/** @var boolean $blncombine Combine files flag */
/** @var array $mpages Mobile pages */
/** @var array $distlibs Distribution libraries */
/** @var object $mainfront Main front file */
/** @var object $homefront Home front file */
/** @var string $genRootFolder Generated root folder */
/** @var string $genFolder Generated folder */
/** @var string $specialmeta Special meta tags */
/**
* Constructor
* Initializes the CordovaGate with default settings and prepares the mobile app structure.
*/
/**
* Set Generated Root Folder
* @param string $param Root folder name
*/
public function setGenRootFolder($param) {}
/**
* Set Special Meta Tag
* @param string $val Meta tag HTML
*/
public function setSpecialMetaTag($val) {}
/**
* Set Distribute multi js css files rather then single
*/
public function setMultiFiles() {}
/**
* Setup front object with event handlers and server-side JS
* @param object $frontobj Front file object
*/
public function setup($frontobj){}
/**
* Add a mobile page
* @param object $pageobj Page object
*/
public function addPage($pageobj) {}
/**
* Add a distribution library folder
* @param string $folderpath Folder path
*/
public function addDistLib($folderpath) {}
/**
* Process front object
* @param object $frontobj Front file object
*/
public function process($frontobj){}
/**
* Process Gate events
*/
public function processEvent(){}
/**
* Call page events
*/
protected function callPageEvents(){}
/**
* Get auto-incremented version
*/
/**
* Create Cordova plugin files
* @param string $curdirpath Current directory path
*/
protected function createCordovaPlugin($curdirpath) {}
/**
* Send render data to generate mobile HTML files
*/
protected function sendRenderData() {}
/**
* Run the Gate
*/
public function run(){}
/**
* Render the Gate output
*/
public function render(){}
/**
* Set class path from reflection
*/
public function setClassPath() {}
/**
* Set up mobile device events
*/
/**
* Load JS library files
* @param string $filename Output file name
* @param string $subpath Sub path
* @param boolean $overwrite Overwrite flag
*/
/**
* Create combined JS and CSS files
*/
/**
* Load JS PHP library files
* @param string $filename Output file name
* @param string $subpath Sub path
* @param boolean $overwrite Overwrite flag
*/
}
}