<?php
namespace Sphp\tools {
use Sphp\core\SphpVersion;
class Control extends \Sphp\core\SphpVersion {
/** @var string Name of Component */
public $name = "";
/** @var string HTML Tag Name of Component */
public $tagName = "";
/** @var string value of Component, depend on component code */
public $value = "";
/** @var string Default Value of Component */
public $defvalue = "";
/** @var string Data Type(STRING) of value of Component */
public $dataType = "STRING";
/** @var string Bind with Database Table */
public $dtable = "";
/** @var string Bind with Database Table Field */
public $dfield = "";
/** @var boolean Database Bind Flag */
public $dataBound = false;
/** @var boolean Database Fill Flag */
public $blnDontFill = false;
/** @var boolean Form Submit Flag */
public $blnDontSubmit = false;
/** @var boolean Database Insert Flag */
public $blnDontInsert = false;
/** @var boolean Database Update Flag */
public $blnDontUpdate = false;
/** @var string HTML Tag Name */
public $HTMLName = "";
/** @var string HTML Tag id */
public $HTMLID = "";
/** @var boolean Default true */
public $visible = true;
/** @var boolean Default true */
public $renderMe = true;
/** @var boolean Default true */
public $renderTag = true;
/** @var boolean Submit flag check component submit by browser or not */
public $issubmit = false;
/** @var boolean Set HTML Closing Tag */
public $blnendtag = true;
/** @var string Component File Directory */
public $mypath = "";
/** @var string Component File Directory As URL */
public $myrespath = "";
public $cfilename = "";
public $cfilepath = "";
/** @var \Sphp\tools\NodeTag Component Node Tag */
public $element = null;
public $parentobj = null;
/** @var \Sphp\tools\TempFile Parent TempFile */
public $tempobj = null;
public $children = array();
protected $proplist = array();
/**
* Create Component Object. Don't override this function in component, 
* if you don't understand the life cycle of object.
* @param string $name <p>
* Name of Component By default this is also HTML tag name and id
* </p>
* @param string $fieldName Database Field name for binding
* @param string $tableName Database Table name for binding
*/
public function __construct($name = "", $fieldName = "", $tableName = "") {}
/**
* Set Name of Object which is used for html tag id and name.
* @param String $val
*/
public function setName($val) {}
/**
* Get Name of Object which is used for html tag id and name.
* @return String
*/
public function getName() {}
/**
* Set Value of Controls which is used for html output.<br>
* txtName = new TextField();<br>
* txtName->setValue="Ram";<br>
* html output equals to <input value="Ram" /><br>
* @param String $val
*/
public function setValue($val) {}
public function getValue() {}
/**
* Set Default Value
* It will over write value of component if 
* component is not submit by browser and  it is empty.
* @param string|json|mixed $val
*/
public function setDefaultValue($val) {}
public function getDefaultValue() {}
/**
* Set HTML Tag Name
* @param string $param
*/
public function setTagName($param) {}
/**
* Set HTML pre Tag. This HTML code will display before component Tag.
* @param string $val
*/
public function setPreTag($val) {}
/**
* Add(Concatenate) HTML pre Tag in previous pre tag. 
* This HTML code will display before component Tag.
* @param string $val
*/
public function addPreTag($val) {}
public function getPreTag() {}
/**
* Set HTML post Tag. This HTML code will display after component Tag.
* @param string $val
*/
public function setPostTag($val) {}
/**
* Add(Concatenate) HTML post Tag in previous post tag. 
* This HTML code will display after component Tag.
* @param string $val
*/
public function addPostTag($val) {}
public function getPostTag() {}
/**
* Set HTML pre Tag for children. 
* This HTML code will display before any component children Tags.
* @param string $val
*/
public function setInnerPreTag($val) {}
/**
* Get All attributes of Tag
* @return array
*/
public function getAttributes() {}
/**
* Read Attribute of Tag
* @param string $name Attribute name
* @return string
*/
public function getAttribute($name) {}
/**
* Set Attribute of Tag
* $div1->setAttribute('style','color: #ff6789');
* @param string $name Attribute name
* @param string $val
*/
public function setAttribute($name, $val) {}
/**
* Remove Attribute
* @param string $name Attribute name
*/
public function removeAttribute($name) {}
/**
* Set Attribute of Tag if value is empty
* $div1->setAttribute('style','color: #ff6789');
* @param string $name Attribute name
* @param string $val
*/
public function setAttributeDefault($name, $val) {}
/**
* Set Inner HTML of Tag
* @param string $val
*/
public function setInnerHTML($val) {}
public function getInnerHTML() {}
/**
* Append HTML code
* @param \Sphp\tools\NodeTag $html
*/
public function appendHTML($html) {}
/**
* Wrap Tag with valid HTML Tag
* @param string $tagname
* @return \Sphp\tools\NodeTag
*/
public function wrapTag($tagname) {}
/**
* Wrap Children Tags with valid HTML Tag Name
* @param string $tagname
* @return \Sphp\tools\NodeTag
*/
public function wrapInnerTags($tagname) {}
public function setVisible() {}
public function unsetVisible() {}
public function getVisible() {}
/**
* Not Render if match
* @param string $param Comma separated authentication list
* @depends \SphpBase::page()->checkUnAuth
*/
public function setUnAuth($param) {}
/**
* Not Render if not match
* @param string $param Comma separated authentication list
* @depends \SphpBase::page()->checkAuth
*/
public function setAuth($param) {}
/**
* Not Render if not match
* @param string $param Comma separated permission list
* @depends \SphpBase::sphp_permissions()->isPermission
*/
public function setrender($permis = "") {}
/**
* Not Render if match
* @param string $param Comma separated permission list
* @depends \SphpBase::sphp_permissions()->isPermission
*/
public function unsetrender($permis = "") {}
public function getrender() {}
/**
* Not Render Tag if not match
* @param string $permis Comma separated permission list
* @depends \SphpBase::sphp_permissions()->isPermission
*/
public function setrenderTag($permis = "") {}
/**
* Not Render Tag if match
* @param string $permis Comma separated permission list
* @depends \SphpBase::sphp_permissions()->isPermission
*/
public function unsetrenderTag($permis = "") {}
public function getrenderTag() {}
public function setDataType($val) {}
public function getDataType() {}
public function setDataBound() {}
public function unsetDataBound() {}
public function getDataBound() {}
/**
* Not Auto Fill with viewData method if match
* @param string $permis Comma separated permission list
* @depends \SphpBase::sphp_permissions()->isPermission
*/
public function setDontFill($permis = "") {}
/**
* Not Auto Fill with viewData method if not match
* @param string $permis Comma separated permission list
* @depends \SphpBase::sphp_permissions()->isPermission
*/
public function unsetDontFill($permis = "") {}
public function getDontFill() {}
/**
* Not Submit if match
* @param string $permis Comma separated permission list
* @depends \SphpBase::sphp_permissions()->isPermission
*/
public function setDontSubmit($permis = "") {}
/**
* Not Submit if not match
* @param string $permis Comma separated permission list
* @depends \SphpBase::sphp_permissions()->isPermission
*/
public function unsetDontSubmit($permis = "") {}
public function getDontSubmit() {}
public function getDontInsert() {}
/**
* Not Insert with inserData if match
* @param string $permis Comma separated permission list
* @depends \SphpBase::sphp_permissions()->isPermission
*/
public function setDontInsert($permis = "") {}
/**
* Not Insert with inserData if not match
* @param string $permis Comma separated permission list
* @depends \SphpBase::sphp_permissions()->isPermission
*/
public function unsetDontInsert($permis = "") {}
public function getDontUpdate() {}
/**
* Not Update with updateData if match
* @param string $permis Comma separated permission list
* @depends \SphpBase::sphp_permissions()->isPermission
*/
public function setDontUpdate($permis = "") {}
/**
* Not Update with updateData if not match
* @param string $permis Comma separated permission list
* @depends \SphpBase::sphp_permissions()->isPermission
*/
public function unsetDontUpdate($permis = "") {}
public function getEndTag() {}
/**
* Enable Closing Tag
*/
public function setEndTag() {}
/**
* Disable Closing Tag
*/
public function unsetEndTag() {}
/**
* Set HTML Tag Name Attribute
*/
public function setHTMLName($val) {}
/**
* Set HTML Tag ID Attribute
*/
public function setHTMLID($val) {}
public function setPathRes($val) {}
/**
* Get Parent TempFile
* @return \Sphp\tools\TempFile TempFile Object
*/
public function getTempobj() {}
/**
* Advanced Method,Internal use
* @param \Sphp\tools\TempFile $tempobj
*/
public function setTempobj($tempobj) {}
/**
* Get All Children Components. Only Component Tags are included as child and ignored normal HTML tags
* @return array
*/
public function getChildren() {}
/**
* Add Child Component
* @param \Sphp\tools\Control $child
*/
public function addChild($child) {}
/**
* @deprecated 4.4.7
*/
public function setParameterA($name, $value) {}
/**
* @deprecated 4.4.7
*/
public function getParameterA($name) {}
/**
* Regsiter Event for Object which uses for Event Driven Programming.
* @param string $event_name
*/
protected function registerEvent($event_name) {}
protected function isRegisterHandler($event_name) {}
/**
* Set Event Handler of Component. 
* This is Registered Event in component which can handle by application.
* @param string $event_name Event Name to handle
* @param string $handler Name of Function or Method that handle event
* @param object $eventhandlerobj Optional Object handle the event 
*/
public function setEventHandler($event_name, $handler, $eventhandlerobj = "null") {}
protected function raiseEvent($event_name, $arglst = array()) {}
protected function registerEventJS($event_name) {}
protected function isRegisterHandlerJS($event_name) {}
/**
* Set Event Handler for JS Code
* @param string $event_name Event Name to handle
* @param string $handler Name of JS Function that handle event
* @param object $eventhandlerobj Optional not supported 
*/
public function setEventHandlerJS($event_name, $handler, $eventhandlerobj = "null") {}
/**
* Generate JS Code to call event handler which 
* is set by setEventHandlerJS method.
* @param string $event_name
* @param array $arglst
* @return string
*/
protected function raiseEventJS($event_name, $arglst = array()) {}
/**
* Submit Component value via Ajax Request and it 
* generate all required JS code automatically.
* in temp file use:- funsubmitAJAX="click,|index-p1.html,|textarea1,textbox1"
* @param type $eventName JS Event Name
* @param type $url Optional Default=page_event_compname_$eventName URL to post data
* @param type $extracomp Comma Separated list html id to send data
*/
public function submitAjax($eventName, $url = "", $extracomp = "") {}
/**
* 
* @param string $eventName JS Event Name
* @param string $handlerFunName JS Function to handle Event
* @param boolean $renderonce Optional default=false, true=ignore on ajax request
*/
public function onJsEvent($eventName, $handlerFunName = "", $renderonce = false) {}
/**
* This function only work if JS Function as also created by addHeaderJSFunction.
* @param string $funname JS Function name where code need to insert
* @param string $name JS code block id
* @param string $code JS Code to insert into JS Function
* @param boolean $renderonce Optional default=false, true=ignore on ajax request
*/
public function addHeaderJSFunctionCode($funname, $name, $code, $renderonce = false) {}
/**
* Bind with any JS Event with $handlerFunName. 
* It generate all required JS code and add into jQuery ready handler.
* @param string $selector jQuery selector
* @param string $eventName JS Event Name
* @param string $handlerFunName JS function name for handling event.
* @param boolean $renderonce Optional default=false, true=ignore on ajax request
*/
protected function bindJSEvent($selector, $eventName, $handlerFunName = "", $renderonce = false) {}
/**
* Bind with any JS Object Event(NON DOM Events) with $handlerFunName. 
* For Example:- Bind with activate event of bootstrap Tab 
* $this->bindJSObjEvent("#tabeditor","tabs","activate","comp_tabeditor_activate");
* It generate all required JS code and add into jQuery ready handler.
* @param string $selector jQuery selector
* @param string $obj JS Object variable name
* @param string $eventName JS Object Event Name
* @param string $handlerFunName JS function name for handling event.
* @param boolean $renderonce Optional default=false, true=ignore on ajax request
*/
protected function bindJSObjEvent($selector, $obj, $eventName, $handlerFunName = "", $renderonce = false) {}
public function parseMe() {}
public final function getHelp() {}
public final function render() {}
public final function prerender() {}
public final function oncompinit($element) {}
public final function oncompcreate($element) {}
/**
* Advance Function
* Execute PHP and return result with eval. 
* Global variables are not available, only component object and its public variables are available
* @param string $php
* @return string
*/
public function loadScript($php) {}
/**
* Advance Function
* Execute PHP and return result with eval. 
* Global variables are not available, only component object and its public variables are available
* @param string &$strPHPCode
* @return string
*/
public function executePHPCode(&$strPHPCode) {}
/**
* Advance Function
* Read file and process PHP and return result. 
* Global variables are not available, only component object and its public variables are available
* @param string $filepath File Path
* @return string
*/
public function getDynamicContent($filepath) {}
/**
* Process PHP in Dynamic CSS,JS File and add as url Link. When 
* \SphpBase::sphp_settings()->translatermode = true then
* framework generate file under cache folder. For Example:- CSS Theme component
* generate new theme according to settings as a public variables of component.
* @param type $fileURL2
* @param type $renderonce
* @param type $filename
* @param type $ext
* @param type $ver
*/
public function addDynamicFileLink($fileURL2, $renderonce = false, $filename = "", $ext = "", $ver = "0") {}
/**
* override this event handler in your Component to handle it.
* trigger when Component initialize
*/
public function oninit() {}
/**
* override this event handler in your Component to handle it.
* trigger when Component Create
* @param \Sphp\tools\NodeTag $element A HTML element of component
*/
public function oncreate($element) {}
/**
* override this event handler in your Component to handle it.
* trigger when Component AfterCreate
*/
public function onaftercreate() {}
/**
* override this event handler in your Component to handle it.
* trigger when Component Get Application ready Event as AppEvent
*/
public function onappevent() {}
/**
* override this event handler in your Component to handle it.
* trigger when Component RenderLast After all children render
*/
public function renderLast() {}
/**
* override this event handler in your Component to handle it.
* trigger when Component PreRender before Render
*/
public function onprerender() {}
/**
* override this event handler in your Component to handle it.
* trigger when Component PreJsRender before PreRender
*/
public function onprejsrender() {}
/**
* override this event handler in your Component to handle it.
* trigger when Component Render Before RenderLast
*/
public function onrender() {}
/**
* override this event handler in your Component to handle it.
* trigger when Component JsRender before Render
*/
public function onjsrender() {}
/**
* override this event handler in your Component to handle it.
* trigger when Component Children Events
* @param string $event Name of Event
* @param \Sphp\tools\Control $obj Child Component
*/
public function onchildevent($event, $obj) {}
/**
* override this event handler in your Component to handle it.
* trigger when runas holder bind with component 
* @param \Sphp\tools\NodeTag $obj 
*/
public function onholder($obj) {}
/**
* Advance Function
* override this event handler in your Component to handle it.
* trigger when component parse manually
* @param string $event
* @param \Sphp\tools\NodeTag $element
*/
public function onparse($event, $element) {}
public function __toString() {}
public function &__get($name) {}
public function __set($name, $value) {}
public function __isset($name) {}
public function __unset($name) {}
/**
* Advance Function, Internal use
*/
public function setClassPath() {}
/**
* Advance Function, Internal use
*/
public function init($name = "", $fieldName = "", $tableName = "") {}
/**
* Add Help for Component
* @param string $name prop name
* @param string $help Help text
* @param string $val value list
* @param string $param
* @param string $type Data Type
* @param string $options
*/
protected function addHelpPropList($name, $help = '', $val = '', $param = '', $type = '', $options = '') {}
/**
* Add Help for Component
* @param string $name function name
* @param string $help Help text
* @param string $val value list
* @param string $param
* @param string $type Data Type
* @param string $options
*/
protected function addHelpPropFunList($name, $help = '', $val = '', $param = '', $type = '', $options = '') {}
/**
* Advance Function, Internal use
*/
public function helpPropList() {}
/**
* Advance Function, Internal use
*/
protected function genhelpPropList() {}
}
class ControlGroup extends Control {
public function __construct($name = '', $fieldName = '', $tableName = '') {}
final public function onaftercreate() {}
final public function onrender() {}
public function getCompApp() {}
}
class MenuGen {
public $htmlout = "";
public $sphp_api = null;
public $name = "def";
public function __construct() {}
public function onstart() {}
public function onrun() {}
public function run() {}
public function render() {}
}
class RenderComp {
public function render($obj) {}
public function createComp($id, $path = '', $class = '', $dfield = '', $dtable = '') {}
public function createComp2($id, $path = '', $class = '', $dfield = '', $dtable = '') {}
public function compcreate($comp) {}
}
}
