<?php
namespace Sphp{
/**
* Settings Class
* Holds all framework and project settings such as resource paths, session
* configuration, database credentials, SEO meta tags, debug mode and edit mode.
* Properties are initialized from global variables in the constructor and are
* read-only afterwards (use getters or the __get magic method).
*/
class Settings{
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
* To Read Private Properties which is set from comp.php and set inside Settings Class
*         private $resourceUrl = "" ; // Relative or Full URL of SartajPhp's res folder(Shared Folder)
private $resourcePath = "" ; // Relative or Absolute Path of SartajPhp's res folder(Shared Folder)
private $slibPath = "" ; // Slib Folder Path(res/{$slibVersion}) 
private $slibVersion = ""; // Version Name of Slib folder default is Slib
private $slibUrl = "" ; // Slib Folder URL (res/{$slibVersion})
private $jsLibUrl = "" ; // URL of JS Libraries (res/jslib) 
private $compPath = "" ; // Path of Components Folder
private $compUrl = "" ; // URL of Components Folder
private $uiKitPath = "" ; //Path of Components UI Kit Folder
private $uiKitUrl = "" ; //URL of Components UI Kit Folder
private $libPath = "" ; // Path of SartajPhp Core Library folder
private $libVersion = "" ; // Version Name of SartajPhp Core Library folder, Default is Sphp 
private $projectUrl = "" ; // Project Folder url under Web root folder
private $webRootUrl = "" ; // Web Root URL 
private $serverPath = "" ; // PHP Server side Path on web server
private $START_PATH = "" ; // Project startup path, it may be different from PROJ_PATH
private $useSession = false ; // Enable, Disable the use of sessions
private $sphpUseSessionStorage = false; // use session as single file, so one session system
private $sphpUseSessionCookie = false; // Convert Session as cookies, So No Server side session storage
private $sessionName = "" ;  // Name of session
private $sessionPath = "" ;  // Session save path
private $sessionId = "" ;
private $sessionHandler = ""; // default is file or php ini settings, others are db and redis server
private $serverLanguage = "ENGLISH" ;
private $debugMode = 0 ; // debugging mode settings use by debugProfiler. 0 mean no debug info on browser console. mode 0,1,2,3
private $debugProfiler = "" ; // custom debug profiler to display debug info, default is handled by Framework
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
