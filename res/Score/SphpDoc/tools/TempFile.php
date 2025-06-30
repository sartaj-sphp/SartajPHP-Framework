<?php
namespace Sphp\tools {
/**
* Description of TempFile
*
* @author Sartaj Singh
*/
class TempFile {
public $data = "";
public $filePath = "";
public $fileDir = "";
public $compList = array();
public $name = "";
public $webapp = null;
/**
* @var \Sphp\tools\BasicApp
*/
public $parentapp = null;
public $metadata = array();
public $blncodebehind = false;
public $blncodefront = false;
public $blnshowFront = true;
public $webapppath = "";
public $sjspath = "";
public $appname = "";
public $appfilepath = "";
public $HTMLParser = null;
public $tempFileTag = "";
public $tempFileTagE = "";
public $prefixName = "";
public $intPHPLevel = 3;
/**
* Advance Function
* Set File Path of TempFile
* @param string $filePath
*/
public function setFilePath($filePath) {}
/**
* Advance Function
* Bind with back-end type Application or front-end type application. 
* Remember BasicApp is front-end application type which
* can manage more then one temp file or run without any temp file like in case of API. 
* Back-end application like WebApp always requires TempFile
* for run. Like PSP Application is a back-end application type.
* @param \Sphp\tools\WebApp $webapp
*/
public function setWebapp($webapp) {}
/**
* Advance Function
* Set bound application file path
* @param string $webapppath
*/
public function setWebapppath($webapppath) {}
/**
* Advance Function
* Set TempFile can bind with back-end application type
* @param boolean $blncodebehind True mean, bound with back-end application
*/
public function setBlncodebehind($blncodebehind) {}
/**
* Advance Function
* Set TempFile can bind with front-end application type
* @param boolean $blncodebehind True mean, bound with back-end application
*/
public function setBlncodefront($blncodefront) {}
/**
* Advance Function
* Set Parent App Name
* @param string $appname
*/
public function setAppname($appname) {}
/**
* Advance Function
* Add component object in TempFile
* @param string $key component name or id in HTML code
* @param \Sphp\tools\Control $obj
*/
public function setComponent($key, $obj) {}
/**
* Add TempFile as JS Variable to store the JS Objects of components.
* name of tempfile is used as variable name in JS
*/
public function addAsJSVar() {}
/**
* Advance Function
* Register TempFile with SphpApi
*/
public function registerTempFile() {}
/**
* 
* Advance Function
* @param string $TempFilePath File path of TempFile Or Direct code as string
* @param boolean $blnStringData Optional Default=false, If true then $TempFilePath= string code
* @param \Sphp\tools\BasicApp $backfileobj Optional Default=null, bind application with TempFile
* @param string $use_sjs_file Optional Default=false true mean use sjs file bind with temp file
* @param \Sphp\tools\BasicApp $parentappobj Optional Default=null, Parent App of TempFile
*/
public function getFile($TempFilePath, $blnStringData = false, $backfileobj = null, $use_sjs_file = false, $parentappobj = null) {}
/**
* Advance Function
* App Event handler trigger by application. 
*/
public function onAppEvent() {}
/**
* Advance Function
* Process TempFile
* also run and render back-end application if any
*/
public function run() {}
/**
* Advance Function
* echo TempFile data
*/
public function render() {}
/**
* Advance Function
* Process TempFile
*/
public function runit() {}
/**
* Advance Function
* echo TempFile data
*/
public function renderit() {}
/**
* Get Generated HTML data. Data available after run. This function help-full if you are not using render
* @return string
*/
public function getData() {}
/**
* File Path of TempFile
* @return string
*/
public function getFilePath() {}
/**
* Get Name(id) of temp file
* @return string
*/
public function getName() {}
/**
* Get Parent App or Bind App with temp file. It return bound app if TempFile bound with app
* @return \Sphp\tools\BasicApp
*/
public function getBindApp() {}
/**
* Get Application that is bound with temp file
* @return \Sphp\tools\WebApp
*/
public function getWebapp() {}
/**
* Get App Path which is bound with this temp file
* @return string
*/
public function getWebapppath() {}
/**
* Get SJS File Path which is bound with this temp file
* @return string
*/
public function getSjspath() {}
/**
* Get Parent App Name
* @return string
*/
public function getAppname() {}
/**
* Disable PHP execution set $intPHPLevel=0, Default it is on 3.
* Enable php execution in temp file. 0= no php execution, 
* 1 = only controls attribute, 
* 2 = php in all tags, 3 = all tags + pass global variables
*/
public function disablePHP($level=0) {}
/**
* Set SJS file path
* @param string $webapppath
*/
public function setSjspath($sjspath) {}
/**
* Enable rendering for temp file
* @param boolean $blnshowFront
*/
public function setBlnshowFront($blnshowFront) {}
/**
* Check if TempFile can render
* @return boolean
*/
public function getBlnshowFront() {}        
/**
* Check if TempFile is bound with any front-end application type
* @return boolean
*/
public function getBlncodefront() {}
/**
* Check if TempFile is bound with any back-end application type
* @return boolean
*/
public function getBlncodebehind() {}
/**
* 
* @param string $TempFilePath File path of TempFile Or Direct code as string
* @param boolean $blnStringData Optional Default=false, If true then $TempFilePath= string code
* @param \Sphp\tools\BasicApp $backfileobj Optional Default=null, bind application with TempFile
* @param \Sphp\tools\BasicApp $parentappobj Optional Default=null, Parent App of TempFile
* @param boolean $dhtml Optional Default=false, if true then use different template engine
* @param string $prefixNameadd Optional Default='', prefix for component id
*/
/**
* Add Meta Data attached to TempFile
* @param string $key
* @param string|array $value
*/
public function addMetaData($key, $value) {}
/**
* Read Meta Data attached with TempFile
* @param string $key
* @return string|array
*/
public function getMetaData($key) {}
/**
* Get Component Object
* @param string $name
* @return \Sphp\tools\Control
*/
/**
* Check if Component Exist in TempFile
* @param string $key component name or id in HTML code
* @return boolean
*/
public function isComponent($key) {}
/**
* Get Component
* @param string $key component name or id in HTML code
* @return \Sphp\tools\Control
*/
public function getComponent($key) {}
/**
* Get Component if exist
* @param string $key component name or id in HTML code
* @return \Sphp\tools\Control|null
*/
public function getComponentSafe($key) {}
/**
* Generate HTML for Component Object
* $tempobj = new Sphp\tools\TempFile("apps/forms/temp1.front");
* $div1 = $tempobj->getComponent('div1');
* echo $tempobj->parseComponent($div1);
* @param \Sphp\tools\Control $obj
* @param boolean $innerHTML Optional Default=false, 
* if true then it will not generate component tag in html
* @return string
*/
public function parseComponent($obj,$innerHTML = false) {}
/**
* Wrap All Children of Component as Node Object.
* $tempobj = new Sphp\tools\TempFile("apps/forms/temp1.front");
* $div1 = $tempobj->getComponent('div1');
* $node1 = $tempobj->getChildrenWrapper($div1);
* echo $tempobj->parseComponentChildren($node1);
* @param \Sphp\tools\Control $obj
* @return Sphp\tools\NodeTag
*/
public function getChildrenWrapper($compobj) {}
/**
* Generate HTML for Component Children
* @param \Sphp\tools\NodeTag $obj
* @return string
*/
public function parseComponentChildren($obj) {}
}
class TempFileChild extends TempFile {
}
class TempFileComp extends TempFile {
}
}
