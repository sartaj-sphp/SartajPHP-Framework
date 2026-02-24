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
protected $compList = array();
protected $extraCompList = array();
public $name = "";
public $backend_gate = null;
/**
* @var \Sphp\tools\BasicGate
*/
public $parentgate = null;
public $metadata = array();
public $blncodebehind = false;
public $blncodefront = false;
public $blnshowFront = true;
public $backend_gate_dir_path = "";
public $sjspath = "";
public $registergate = "";
public $gate_file_path = "";
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
/**
* Advance Function
* Bind with back-end type Gate or front-end type Gate. 
* Remember BasicGate is front-end Gate type which
* can manage more then one front file or run without any front file like in case of API. 
* Back-end Gate like WebGate always requires FrontFile
* for run. Like PSP Gate is a back-end Gate type.
* @param \Sphp\tools\WebGate $backend_gate
*/
/**
* Advance Function
* Set bound Gate file path
* @param string $backend_gate_dir_path
*/
/**
* Advance Function
* Set FrontFile can bind with back-end Gate type
* @param boolean $blncodebehind True mean, bound with back-end Gate
*/
/**
* Advance Function
* Set FrontFile can bind with front-end Gate type
* @param boolean $blncodebehind True mean, bound with back-end Gate
*/
/**
* Advance Function
* Set Parent Gate Name
* @param string $registergate
*/
/**
* Advance Function
* Add component object in FrontFile
* @param string $key component name or id in HTML code
* @param \Sphp\tools\Component $obj
*/
/**
* Advance Function
* Add component object in FrontFile as Reference. This reference Components are created 
* in other Front File so you can just use as reference in Gate or in this Front File. This used in parent child 
* Front Files. Front File can't process these Components.
* @param string $key component name or id in HTML code
* @param \Sphp\tools\Component $obj
*/
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
* @param \Sphp\tools\BasicGate $backfileobj Optional Default=null, bind Gate with FrontFile
* @param string $use_sjs_file Optional Default=false true mean use sjs file bind with front file
* @param \Sphp\tools\BasicGate $parentgateobj Optional Default=null, Parent Gate of FrontFile
*/
/**
* Advance Function
* Gate Event handler trigger by Gate. 
*/
/**
* Advance Function
* Process FrontFile
* also run and render back-end Gate if any
*/
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
* get FrontFile Front-End code
* @return string HTML Output
*/
public function ProcessMe() {}
/**
* Advance Function
* Process FrontFile
*/
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
* Get Parent Gate or Bind Gate with front file. It return bound Gate if FrontFile bound with Gate
* @return \Sphp\tools\BasicGate
*/
public function getBindGate() {}
/**
* Get Gate that is bound with front file
* @return \Sphp\tools\BackEndGate
*/
public function getBackEndGate() {}
/**
* Get Gate Path which is bound with this front file
* @return string
*/
public function getBackEndGateDirPath() {}
/**
* Get SJS File Path which is bound with this front file
* @return string
*/
public function getSjspath() {}
/**
* Get Parent Gate Name
* @return string
*/
public function getRegisterGate() {}
/**
* Disable PHP execution set $intPHPLevel=0, Default it is enable.
* PHP can only executed by a Custom Evaluator not by EVAL. So
* It can execute only few PHP syntax.PHP tags are not allowed.
* Only use Expression Tags for output ##{} and silent #{}# 
* Enable php execution in front file. 0= no php execution, 
* 1 = Allowed 
*/
public function disablePHP($level=0) {}
/**
* Set SJS file path
* @param string $backend_gate_dir_path
*/
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
* Check if FrontFile is bound with any front-end Gate type
* @return boolean
*/
public function getBlncodefront() {}
/**
* Check if FrontFile is bound with any back-end Gate type
* @return boolean
*/
public function getBlncodebehind() {}
/**
* 
* @param string $FrontFilePath File path of FrontFile Or Direct code as string
* @param boolean $blnStringData Optional Default=false, If true then $FrontFilePath= string code
* @param \Sphp\tools\BasicGate $backfileobj Optional Default=null, bind Gate with FrontFile
* @param \Sphp\tools\BasicGate $parentgateobj Optional Default=null, Parent Gate of FrontFile
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
* Add Meta Data attached to FrontFile. Only available after Parse Phase. 
* @param string $key
* @param string|array $value
*/
public function addMetaData($key, $value) {}
/**
* Alias of addMetaData
* Add Meta Data attached to FrontFile. Only available after Parse Phase. 
* @param string $key
* @param string|array $value
*/
public function addProp($key, $value) {}
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
* Get Children Components Only
* @return array
*/
public function getComponents() {}
/**
* Get All Children + References Components
* @return array
*/
public function getAllComponents() {}
/**
* Generate HTML for Component Object
* $frontobj = new Sphp\tools\FrontFile("Gates/forms/front1.front");
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
* $frontobj = new Sphp\tools\FrontFile("Gates/forms/front1.front");
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
/**
* Child Front File Share Components and meta data with parent as reference not a copy. So changes in child
*  effect in parent also.
*/
class FrontFileChild extends FrontFile {
/**
* Advance Function
* Add component object in FrontFile
* @param string $key component name or id in HTML code
* @param \Sphp\tools\Component $obj
*/
}
class FrontFileComp extends FrontFile {
}
/**
* Description of FrontPlace
*  Parent Class for create PHP Class as Front Place Object. 
*  Front Place is generate dynamic content in Master File and it can enable, disable by Master File.
*  For Example you can generate a slider with PHP file rather then FrontFile.
*/
abstract class FrontPlace{
abstract protected function _run();
abstract protected function render();
}
}
