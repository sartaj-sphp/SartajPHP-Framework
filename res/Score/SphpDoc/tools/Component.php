<?php
namespace Sphp\tools {
use Sphp\core\SphpVersion;
class Component extends \Sphp\core\SphpVersion {
/** @var string Name of Component */
protected $name = "";
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
/** @var \Sphp\tools\Component Component Object */
public $parentobj = null;
/** @var \Sphp\tools\FrontFile Parent FrontFile */
protected $frontobj = null;
protected $children = array();
protected $proplist = array();
/** @var int  */
protected $styler = 0;
/**
* Create Component Object. Don't override this function in component, 
* if you don't understand the life cycle of object.
* @param string $name <p>
* Name of Component By default this is also HTML tag name and id
* </p>
* @param string $fieldName Database Field name for binding
* @param string $tableName Database Table name for binding
*/
final 
/**
* List Fusion Methods Start Here.
* Fusion Methods that can bind with FrontFile. These function always public and prefix with 
* "fi_" and "fu_" and called by Fusion Attributes fui-*,fun-*,fur-* from FrontFile Component Tag.
* "fu_" prefix used with those Component methods which is only need for Client Side Configuration
* or output and no need on server side processing. It is default behavior and can call on anytime. In 
* FrontFile you can call them and pass value with "fui_", "fun_" and "fur_" prefix.
* "fi_" prefix used with those methods that need to call for server side configurations, like validation
* methods, these methods can't call with "fun_" and "fur_" prefix. 
* "fun_" prefix used to as safe binding and reduce server load with decide automatic processing time.
* If value passed is static then it call Fusion Method on Parse Phase of FrontFile and if value need to evaluate then it call
* Fusion Method on Execute Phase of FrontFile.
* <input type="text" runat="server" fuisetMaxLen="20" />
*/
/**
* Set Styler for multi layout html output.
* @param int $styler
*/
public function fu_setStyler($styler) {}
/**
* Set Default Value
* It will over write value of component if 
* component is not submit by browser and  it is empty.
* @param string|json|mixed $val
*/
public function fi_setDefaultValue($val) {}
/**
* Set Value of Components which is used for html output.<br>
* txtName = new TextField();<br>
* txtName->setValue="Ram";<br>
* html output equals to <input value="Ram" /><br>
* @param String $val
*/
public function fu_setValue($val) {}
/**
* Not Render if match
* @param string $param Comma separated authentication list
* @depends \SphpBase::page()->checkUnAuth
*/
public function fu_setUnAuth($param) {}
/**
* Not Render if not match
* @param string $param Comma separated authentication list
* @depends \SphpBase::page()->checkAuth
*/
public function fu_setAuth($param) {}
/**
* Not Render if not match
* @param string $param Comma separated permission list
* @depends \SphpBase::sphp_permissions()->isPermission
*/
public function fu_setrender($permis = "") {}
/**
* Not Render if match
* @param string $param Comma separated permission list
* @depends \SphpBase::sphp_permissions()->isPermission
*/
public function fu_unsetrender($permis = "") {}
/**
* Not Render Tag if not match
* @param string $permis Comma separated permission list
* @depends \SphpBase::sphp_permissions()->isPermission
*/
public function fu_setrenderTag($permis = "") {}
/**
* Not Render Tag if match
* @param string $permis Comma separated permission list
* @depends \SphpBase::sphp_permissions()->isPermission
*/
public function fu_unsetrenderTag($permis = "") {}
/**
* Not Auto Fill with viewData method if match
* @param string $permis Comma separated permission list
* @depends \SphpBase::sphp_permissions()->isPermission
*/
public function fi_setDontFill($permis = "") {}
/**
* Not Auto Fill with viewData method if not match
* @param string $permis Comma separated permission list
* @depends \SphpBase::sphp_permissions()->isPermission
*/
public function fi_unsetDontFill($permis = "") {}
/**
* Not Submit if match
* @param string $permis Comma separated permission list
* @depends \SphpBase::sphp_permissions()->isPermission
*/
public function fi_setDontSubmit($permis = "") {}
/**
* Not Submit if not match
* @param string $permis Comma separated permission list
* @depends \SphpBase::sphp_permissions()->isPermission
*/
public function fi_unsetDontSubmit($permis = "") {}
/**
* Not Insert with inserData if match
* @param string $permis Comma separated permission list
* @depends \SphpBase::sphp_permissions()->isPermission
*/
public function fi_setDontInsert($permis = "") {}
/**
* Not Insert with inserData if not match
* @param string $permis Comma separated permission list
* @depends \SphpBase::sphp_permissions()->isPermission
*/
public function fi_unsetDontInsert($permis = "") {}
/**
* Not Update with updateData if match
* @param string $permis Comma separated permission list
* @depends \SphpBase::sphp_permissions()->isPermission
*/
public function fi_setDontUpdate($permis = "") {}
/**
* Not Update with updateData if not match
* @param string $permis Comma separated permission list
* @depends \SphpBase::sphp_permissions()->isPermission
*/
public function fi_unsetDontUpdate($permis = "") {}
/**
* Set HTML Tag's Name Attribute, By Default it will be empty.
*/
public function fu_setHTMLName($val) {}
/**
* Set HTML Tag ID Attribute, By Default it will be use object name.
* If ref-object is used then only main object will set id from name of object.
*/
public function fu_setHTMLID($val) {}
/**
* Submit Component value via Ajax Request and it 
* generate all required JS code automatically.
* in front file use:- funsubmitAJAX="click,|index-p1.html,|textarea1,textbox1"
* @param type $eventName JS Event Name
* @param type $url Optional Default=page_event_compname_$eventName URL to post data
* @param type $extracomp Comma Separated list html tag id or class with prefix . to send data
*/
public function fu_submitAjax($eventName, $url = "", $extracomp = "") {}
/**
* Submit Component value via WS Request and it 
* generate all required JS code automatically.
* in front file use:- funsubmitWS="click,|domain:8084,|textarea1,textbox1,|aigen,|picture"
* @param string $eventName JS Event Name
* @param string $host Optional Default=find socket in page to post data, it will ignore if socket already exist.
* @param string $extracomp Comma Separated list html id to send data
* @param string $ctrl Appgate of native app to submit data
* @param string $evt Event of native app to trigger
* @param string $evtp Event Parameter to pass any data
* 
*/
public function fu_submitWS($eventName, $host = "", $extracomp = "",$ctrl="main",$evt="",$evtp="") {}
/**
* End List of Fusion Methods
*/
/**
* Get Name of Object which is used for html tag id and name.
* @return String
*/
public function getName() {}
public function getValue() {}
/**
* escape single or double quotation in value. This don't need DB Connection.
* It is not escape sql characters. Use dbEngine->cleanQuery() for properly safe value but
* it need db connection.
* @return string
*/
public function getSqlSafeValue() {}
/**
*  Set Value From Database Row, only if dfield set. This function don't know table name,
*  So it is not safe like page_view. It will give error if field not exist in row.
* @param array $row Associative array from DB table
*/
public function setFromDatabase($row){}
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
public function getrender() {}
public function getrenderTag() {}
public function setDataType($val) {}
public function getDataType() {}
/**
*  Bind Component with Database
* @param string $table Optional DB Table name
* @param string $field Optional DB Table Field name
*/
public function bindToTable($table="",$field="") {}
public function setDataBound() {}
public function unsetDataBound() {}
public function getDataBound() {}
/**
*  Check if Control is bind with Database
* @return boolean
*/
public function hasDatabaseBinding() {}
public function getDontFill() {}
public function getDontSubmit() {}
public function getDontInsert() {}
public function getDontUpdate() {}
public function getEndTag() {}
/**
* Enable Closing Tag
*/
public function setEndTag() {}
/**
* Disable Closing Tag
*/
public function unsetEndTag() {}
public function setPathRes($val) {}
/**
* Get Parent FrontFile
* @return \Sphp\tools\FrontFile FrontFile Object
*/
public function getFrontobj() {}
/**
* Advanced Method,Internal use
* @param \Sphp\tools\FrontFile $frontobj
*/
public function _setFrontobj($frontobj) {}
/**
* Get Children Components Only First Level. Only Component Tags are included as child and 
* ignored normal HTML tags.
* @return array
*/
public function getChildren() {}
/**
* Get All Children Components All Levels. Only Component Tags are included as child and 
* ignored normal HTML tags.
* @return array
*/
public function getAllChildren() {}
/**
* Add Child Component
* @param \Sphp\tools\Component $child
*/
public function _addChild($child) {}
/**
* Get Parent Component if any or null
* @return \Sphp\tools\Component
*/
public function getParentComponent() {}
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
* Add Component as JS variable part of FrontFile JS Object. 
* HTML Name of component used as variable name in JS code. By default it
* is same as tag id.
* in JS you can get Component object as front1.getComponent('txtname');
*/
public function addAsJSVar() {}
/**
* Set Component as JS variable part of FrontFile JS Object. Remember not all component 
* will automatically create js object. It is created by component code. If component 
* developer doesn't offer JS integration then there are no any JS object. 
* in JS you can set Component object as front1.setComponent('txtname','$jscode');
* @param string $jscode JS Code as String
* @return string JS code
*/
public function setAsJSVar($jscode) {}
/**
* Get Component as JS Variable.
* return code like front1.getComponent('txtname');
* @return string JS code
*/
public function getAsJSVar() {}
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
/**
*  Create Front File Object and Share All Components with Parent File and also add all components 
* as children of parent Components.
* @param string $filepath File Path of Front File or String
* @param bool $blnStringData Optional True mean use string rather then filepath
* @return \Sphp\tools\FrontFile
*/
protected function createFrontObjectShare($filepath,$blnStringData = false){}
/**
*  Create Front File Object in Private Space. Nothing Share with Parent Front File.
* @param string $filepath File Path of Front File or String
* @param bool $blnStringData Optional True mean use string rather then filepath
* @return \Sphp\tools\FrontFile
*/
protected function createFrontObjectPrivate($filepath,$blnStringData = false){}
/**
* Prase HTML string and trigger onprase event for each node
* @param string $html
* @return string process html by onprocess callback
*/
public function parseHTML($html) {}
final public  function getHelp() {}
final public function _render() {}
final public function _prerender() {}
final public function _oncompinit($element) {}
final public function _oncompcreate($element) {}
/**
* Advance Function
* Execute Limited PHP Code for Template tags ##{} #{}#. 
* Global variables are not available, only component object $compobj and its public variables are available
* @param string &$strPHPCode Template code
* @return string
*/
protected function executePHPCode(&$strPHPCode) {}
/**
* Advance Function
* Read file and process PHP and return result. 
* Global variables are not available, only component object and its public variables are available
* @param string $filepath File Path
* @return string
*/
protected function getDynamicContent($filepath) {}
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
public function _trigger_after_create(){}
public function _trigger_app_event(){}
public function _trigger_holder($element){}
/** override functions list start here, in order of life cycle events trigger.
*  You can Design a new Component with override these functions in child class.
*/
/**
*  override this Life-Cycle event handler in your Component to handle it.
*  trigger when Component initialize and before any children Components initialize. You can set default values of Component 
*  in this event handler.
*/
protected function oninit() {}
/**
* override this Life-Cycle event handler in your Component to handle it.
* trigger when Component Create and before any children components Create event. 
* We can read all static attributes and "fui-_*" 
* dynamic attributes  set in FrontFile. So you can decide your default values or
* calculate or validate request submit in this handler.
* @param \Sphp\tools\NodeTag $element A HTML element of component
*/
protected function oncreate($element) {}
/**
* override this Life-Cycle event handler in your Component to handle it.
* trigger when All Components of FrontFile is created. If Component 
* settings or input dependent on other components of FrontFile or  
* it's children Components then we can use this handler to work further. For
* Example our component need to read Page Title when it find Title Component in 
* FrontFile.  
*/
protected function onaftercreate() {}
/**
*  override this Life-Cycle event handler in your Component to handle it.
*  trigger when Component Get Application ready Event as AppEvent. Trigger after 
*  App onrun event.
*  In this event handler Component can handle it's own PageEvents and reply AJAX directly 
*  to Browser and reduce the work App and developer. But this will work only if FrontFile
*  Object is created on App Life-Cycle event handler onstart.
*/
protected function onappevent() {}
/**
*  override this Life-Cycle event handler in your Component to handle it.
*  trigger before onprerender,onjsrender,onrender and before any children Components event PreJsRender and PreRender.
*  This will not work if Front File not Render or disable Component rendering. 
*  You can create JS Function with addHeaderJSFunction and then Children can write their code inside 
*  this JS Function with addHeaderJSFunctionCode. You can divide your logic between various render
*  event handlers.
*/
protected function onprejsrender() {}
/**
* override this Life-Cycle event handler in your Component to handle it.
* trigger before onjsrender, onrender and PreRender of children Components.
*  write js,html code which help or need by children for further addition onrender
*  This will not work if Front File not Render or disable Component rendering. 
*/
protected function onprerender() {}
/**
* override this Life-Cycle event handler in your Component to handle it.
* trigger when Component before onrender and after children render. Mostly
*  use to write own JS code and links external js,css files.
*  This will not work if Front File not Render or disable Component rendering. 
*/
protected function onjsrender() {}
/**
* override this Life-Cycle event handler in your Component to handle it.
* trigger when Component Render and Before RenderLast. Mostly use to 
* write HTML layout,design or over-write children output
*  This will not work if Front File not Render or disable Component rendering. 
*/
protected function onrender() {}
/**
* override this Life-Cycle event handler in your Component to handle it.
* trigger when Component Rendering Complete After all output is generated. 
* Use by Complex components. Use for Cleanup temporary resources and 
* Finalize output or control children components.
*  This will not work if Front File not Render or disable Component rendering. 
*/
protected function onpostrender() {}
/**
* override this event handler in your Component to handle it.
* trigger on Children Component Events. Use for interaction between parent 
*  child. So it is not Life-Cycle event. It will trigger by only first level of children.
* @param string $event Name of Event value may be oncreate,onprerender or onrender
* @param \Sphp\tools\Component $obj Child Component
*/
protected function onchildevent($event, $obj) {}
/**
* override this event handler in your Component to handle it.
* trigger when Runtime Attribute runas used with value of "holder" and that pass \Sphp\tools\NodeTag 
* Tag Object to component and then Component can display any type of content on holder object. 
* With helper attribute only data-comp and leave data-prop.
*  <div runas="holder" data-comp="pagrid1"></div>
*  So it is not Life-Cycle event.
* @param \Sphp\tools\NodeTag $obj 
*/
protected function onholder($obj) {}
/**
* Advance Function
* override this event handler in your Component to handle it.
* trigger when HTML text parse with parseHTML function.
* @param string $event value may be start or end.
* @param \Sphp\tools\HTMLDOMNode $domelement
*/
protected function onparse($event, $domelement) {}
/**
* Advance Function, Internal use
*/
/**
* Advance Function, Internal use
*/
final public function init($name, $fieldName = "", $tableName = "") {}
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
/**
* Component use it own Application to process events and Front File to design own 
* Complex design for example:- Tiny Editor Component, Web Page Editor
*/
class ComponentGroup extends Component {
final public function onaftercreate() {}
final public function onrender() {}
public function getCompApp() {}
}
class MenuGen {
public $htmlout = "";
public $sphp_api = null;
public $name = "def";
protected function onstart() {}
protected function onrun() {}
public function _run() {}
public function getOutput() {}
public function render() {}
}
class RenderComp {
public function render($obj) {}
public function createComp($id, $path = '', $class = '', $dfield = '', $dtable = '') {}
public function createComp2($id, $path = '', $class = '', $dfield = '', $dtable = '') {}
public function compcreate($comp) {}
}
}
