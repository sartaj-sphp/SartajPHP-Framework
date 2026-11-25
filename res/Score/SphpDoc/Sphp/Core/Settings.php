<?php
namespace Sphp{
/**
* Settings Class
* Holds all framework and project settings such as resource paths, session
* configuration, database credentials, SEO meta tags, debug mode and edit mode.
* Properties are initialized from global variables in the constructor and are
* read-only afterwards (use getters or the __get magic method).
* All Protected Properties are Read Only.
*/
class Settings{
/** All Protected Properties are Read Only */
protected $resourceUrl = "" ; 
protected $resourcePath = "" ; 
protected $slibPath = "" ; 
protected $slibVersion = ""; 
protected $slibUrl = "" ; 
protected $jsLibUrl = "" ; 
protected $compPath = "" ; 
protected $compUrl = "" ; 
protected $uiKitPath = "" ; 
protected $uiKitUrl = "" ; 
protected $libPath = "" ; 
protected $libVersion = "" ; 
protected $projectUrl = "" ; 
protected $webRootUrl = "" ; 
protected $serverPath = "" ; 
protected $useSession = false ; 
protected $sphpUseSessionStorage = false; 
protected $sphpUseSessionCookie = false; 
protected $sessionName = "" ;  
protected $sessionPath = "" ;  
protected $sessionId = "" ;
protected $sessionHandler = ""; 
protected $serverLanguage = "ENGLISH" ;
protected $debugMode = 0 ; 
protected $debugProfiler = "" ; 
/** Public properties */
public $blnEditMode = false ;
public $editCtrl = "" ;
public $blnGlobalGate = false ;
public $translaterMode = false ;
public $responseMethod = "NORMAL";
public $defenceKey = "";
public $enableLog = false ;
public $errorPage = "" ;
public $errorLog = "" ;
public $jsProtection = false ;
public $dbEnginePath = "";
public $dbDriver = "" ;
public $dbUser = "" ;
public $db = "" ;
public $dbPass = "" ;
public $dbHost = "" ;
public $ajaxReadyMax = 300;
public $minTime = 0 ;
public $midTime = 0 ;
public $maxTime = 0 ;
public $keywordIndex = -1;
public $keywords = array();
public $title = "";
public $metaKeywords = "";
public $metaDescription = "";
public $metaDistribution = "global";
public $metaClassification = "";
public $metaRobot = "index, follow";
public $metaRating = "general";
public $metaAuthor = "";
public $metaPageRank = "10";
public $metaRevisit = "15 days";
public $runModeNotExtension = false;
public $runHdParser = false;
public $blnPreLibLoad = false;
public $blnStopResponse = false;
public $defaultFilelinkLoad = 0;
/**
* Constructor
* Initializes all settings from global variables.
*/
/**
* __get
* Advance Function, Internal Use
* To Read Private Protected Properties which is set from comp.php and set inside Settings Class
* @param string $key property name
* @return mixed
*/
/**
* __set
* Use Setter Method to set Properties, this will not set any property and through error.
* Advance Function, Internal Use
* @param string $key property name
* @param mixed $val value
*/
/** SEO Friendly
* Return one keyword from keywords array with internal index and increment index.
* So Every call return different keyword. Important for SEO of page content.   
* @return string
*/
public function getKeyword() {}    
/**
* Generate Auto Generated
* @param array $para
* @param int $paraRepeated
* @param int $startIndex
* @return string
*/
public function genAutoText($para,$paraRepeated=1,$startIndex=1){}
/**
* Get Title of web page
* @return string
*/
public function getTitle() {}
/**
* Get Resource URL
* @return string
*/
public function getResourceUrl() {}
/**
* Get Resource Path
* @return string
*/
public function getResourcePath() {}
/**
* Get Server Path
* @return string
*/
public function getServerPath() {}
/**
* Get Project Path
* @return string
*/
public function getProjectPath() {}
/**
* Get Start Path
* Startup path may be different from PROJ_PATH
* @return string
*/
public function getStartPath() {}
/**
* Set Title of web page
* @param string $title
*/
public function setTitle($title) {}
/**
* Set Session Id
* @param string $sessionId
*/
public function setSessionId($sessionId) {}
/**
* Set Enable Log
* @param boolean $enableLog
*/
public function setEnableLog($enableLog) {}
/**
* Set Error Page
* @param string $errorPage
*/
public function setErrorPage($errorPage) {}
/**
* Set Error Log
* @param string $errorLog
*/
public function setErrorLog($errorLog) {}
/**
* Advanced Function
* Disable editing mode and add header JS function code.
*/
public function disableEditing() {}
/**
* Advanced Function
* Enable editing mode and add header JS function code for double click editing.
*/
public function enableEditing() {}
}
}
