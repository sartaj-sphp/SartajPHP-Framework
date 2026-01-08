<?php
namespace Sphp\tools {
/**
* Description of FrontFile
*
* @author Sartaj Singh
*/
class FrontFile {
public $data = "";
public $filePath = "";
public $fileDir = "";
public $mypath = "";
public $myrespath = "";
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
public $frontFileTag = "";
public $frontFileTagE = "";
public $prefixName = "";
public $intPHPLevel = 1;
/**
* Advance Function
* Set File Path of FrontFile
* @param string $filePath
*/
public function _setFilePath($filePath) {}
/**
* Advance Function
* Bind with back-end type Application or front-end type application. 
* Remember BasicApp is front-end application type which
* can manage more then one front file or run without any front file like in case of API. 
* Back-end application like WebApp always requires FrontFile
* for run. Like PSP Application is a back-end application type.
* @param \Sphp\tools\WebApp $webapp
*/
public function _setWebapp($webapp) {}
/**
* Advance Function
* Set bound application file path
* @param string $webapppath
*/
public function _setWebapppath($webapppath) {}
/**
* Advance Function
* Set FrontFile can bind with back-end application type
* @param boolean $blncodebehind True mean, bound with back-end application
*/
public function _setBlncodebehind($blncodebehind) {}
/**
* Advance Function
* Set FrontFile can bind with front-end application type
* @param boolean $blncodebehind True mean, bound with back-end application
*/
public function _setBlncodefront($blncodefront) {}
/**
* Advance Function
* Set Parent App Name
* @param string $appname
*/
public function _setAppname($appname) {}
/**
* Advance Function
* Add component object in FrontFile
* @param string $key component name or id in HTML code
* @param \Sphp\tools\Component $obj
*/
public function _setComponent($key, $obj) {}
/**
* Add FrontFile as JS Variable to store the JS Objects of components.
* name of frontfile is used as variable name in JS
*/
public function addAsJSVar() {}
/**
* Advance Function
* Register FrontFile with SphpApi
*/
/**
* 
* Advance Function
* @param string $FrontFilePath File path of FrontFile Or Direct code as string
* @param boolean $blnStringData Optional Default=false, If true then $FrontFilePath= string code
* @param \Sphp\tools\BasicApp $backfileobj Optional Default=null, bind application with FrontFile
* @param string $use_sjs_file Optional Default=false true mean use sjs file bind with front file
* @param \Sphp\tools\BasicApp $parentappobj Optional Default=null, Parent App of FrontFile
*/
public function _getFile($FrontFilePath, $blnStringData = false, $backfileobj = null, $use_sjs_file = false, $parentappobj = null) {}
/**
* Advance Function
* App Event handler trigger by application. 
*/
public function _onAppEvent() {}
/**
* Advance Function
* Process FrontFile
* also run and render back-end application if any
*/
public function _run() {}
/**
* Advance Function
* echo FrontFile Front-End code
*/
public function render() {}
/**
* Advance Function
* get FrontFile Front-End code
* @return string HTML Output
*/
public function getOutput() {}
/**
* Advance Function
* Process FrontFile
*/
public function _runit() {}
/**
* Advance Function
* echo FrontFile data
*/
public function renderit() {}
/**
* File Path of FrontFile
* @return string
*/
public function getFilePath() {}
/**
* Get Name(id) of front file
* @return string
*/
public function getName() {}
/**
* Get Parent App or Bind App with front file. It return bound app if FrontFile bound with app
* @return \Sphp\tools\BasicApp
*/
public function getBindApp() {}
/**
* Get Application that is bound with front file
* @return \Sphp\tools\WebApp
*/
public function getWebapp() {}
/**
* Get App Path which is bound with this front file
* @return string
*/
public function getWebapppath() {}
/**
* Get SJS File Path which is bound with this front file
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
* Enable php execution in front file. 0= no php execution, 
* 1 = Limited Allowed, 
* 2 = Full, 3 = Full + pass global variables
*/
public function disablePHP($level=0) {}
/**
* Set SJS file path
* @param string $webapppath
*/
public function _setSjspath($sjspath) {}
/**
* Enable rendering for front file
* @param boolean $blnshowFront
*/
public function setBlnshowFront($blnshowFront) {}
/**
* Check if FrontFile can render
* @return boolean
*/
public function getBlnshowFront() {}        
/**
* Check if FrontFile is bound with any front-end application type
* @return boolean
*/
public function getBlncodefront() {}
/**
* Check if FrontFile is bound with any back-end application type
* @return boolean
*/
public function getBlncodebehind() {}
/**
* 
* @param string $FrontFilePath File path of FrontFile Or Direct code as string
* @param boolean $blnStringData Optional Default=false, If true then $FrontFilePath= string code
* @param \Sphp\tools\BasicApp $backfileobj Optional Default=null, bind application with FrontFile
* @param \Sphp\tools\BasicApp $parentappobj Optional Default=null, Parent App of FrontFile
* @param boolean $dhtml Optional Default=false, if true then use different frontlate engine
* @param string $prefixNameadd Optional Default='', prefix for component id
*/
/**
* Execute PHP code in Limited Container. Use only Template Tags ##{ }# or #{ }#
* @param string $strPHPCode PHP Template code
* @param \Sphp\tools\Component $compobj default null, Show debug information if Component
* run code
* @return string
*/
public function executePHPCode($strPHPCode,$compobj=null) {}
/**
* Add Meta Data attached to FrontFile
* @param string $key
* @param string|array $value
*/
public function addMetaData($key, $value) {}
/**
* Read Meta Data attached with FrontFile
* @param string $key
* @return string|array
*/
public function getMetaData($key) {}
/**
* Get Component Object
* @param string $name
* @return \Sphp\tools\Component
*/
/**
* Check if Component Exist in FrontFile
* @param string $key component name or id in HTML code
* @return boolean
*/
public function isComponent($key) {}
/**
* Get Component
* @param string $key component name or id in HTML code
* @return \Sphp\tools\Component
*/
public function getComponent($key) {}
/**
* Get Component if exist
* @param string $key component name or id in HTML code
* @return \Sphp\tools\Component|null
*/
public function getComponentSafe($key) {}
/**
* Generate HTML for Component Object
* $frontobj = new Sphp\tools\FrontFile("apps/forms/front1.front");
* $div1 = $frontobj->getComponent('div1');
* echo $frontobj->parseComponent($div1);
* @param \Sphp\tools\Component $obj
* @param boolean $innerHTML Optional Default=false, 
* if true then it will not generate component tag in html
* @return string
*/
public function parseComponent($obj,$innerHTML = false) {}
/**
* Wrap All Children of Component as Node Object.
* $frontobj = new Sphp\tools\FrontFile("apps/forms/front1.front");
* $div1 = $frontobj->getComponent('div1');
* $node1 = $frontobj->getChildrenWrapper($div1);
* echo $frontobj->parseComponentChildren($node1);
* @param \Sphp\tools\Component $obj
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
class FrontFileChild extends FrontFile {
}
class FrontFileComp extends FrontFile {
}
}
