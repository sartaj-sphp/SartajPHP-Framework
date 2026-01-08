<?php

namespace Sphp\tools {

    use Sphp\core\SphpVersion;

/*
     * Copyright (c) 2006 SartajPHP.  All rights reserved.
     * Redistribution of source must retain this copyright notice.
     *
     * Sartaj Singh (http://www.sartajphp.com) is a software consultant.
     *
      /**
     * Class Component.<br>
     * <strong>Description</strong>:-<br>
     * For Create HTML, JS, or any Components. <br>
     * This is parent class of all Components.<br>
     * @author Sartaj Singh <sartaj@sartajsingh.com>
     * @copyright Copyright(c) 2006 SartajPHP.
     * @link http://www.sartajphp.com
     * @var Object
     * 
     */

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

        //db

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

// Component to render behave

        /** @var boolean Default true */
        public $visible = true;

        /** @var boolean Default true */
        public $renderMe = true;

        /** @var boolean Default true */
        public $renderTag = true;

        /** @var boolean Submit flag check component submit by browser or not */
        public $issubmit = false;
// check if html has end tag

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
        private $onjseventlist = array();
        private $headerFunctionCode = array();
        // events
        private $eventRegister = array();
        private $eventRegisterJS = array();
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
        final public function __construct($name, $fieldName = "", $tableName = "") {
            $this->init($name, $fieldName, $tableName);
        }

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
        public function fu_setStyler($styler) {
            $this->styler = intval($styler);
        }
        
        /**
         * Set Default Value
         * It will over write value of component if 
         * component is not submit by browser and  it is empty.
         * @param string|json|mixed $val
         */
        public function fi_setDefaultValue($val) {
            $this->defvalue = $val;
            if (!$this->issubmit && $this->value == "") {
                $this->value = $val;
            }
        }

        /**
         * Set Value of Components which is used for html output.<br>
         * txtName = new TextField();<br>
         * txtName->setValue="Ram";<br>
         * html output equals to <input value="Ram" /><br>
         * @param String $val
         */
        public function fu_setValue($val) {
            if (!$this->issubmit) {
                $this->value = $val;
            }
        }

        /**
         * Not Render if match
         * @param string $param Comma separated authentication list
         * @depends \SphpBase::page()->checkUnAuth
         */
        public function fu_setUnAuth($param) {
            $blnF = \SphpBase::page()->checkUnAuth($param);
            if ($blnF) {
                $this->renderMe = false;
            }
        }

        /**
         * Not Render if not match
         * @param string $param Comma separated authentication list
         * @depends \SphpBase::page()->checkAuth
         */
        public function fu_setAuth($param) {
            $blnF = \SphpBase::page()->checkAuth($param);
            if (!$blnF) {
                $this->renderMe = false;
            }
        }

        /**
         * Not Render if not match
         * @param string $param Comma separated permission list
         * @depends \SphpBase::sphp_permissions()->isPermission
         */
        public function fu_setrender($permis = "") {
            if ($permis != "") {
                if (\SphpBase::sphp_permissions()->isPermission($permis)) {
                    $this->renderMe = true;
                } else {
                    $this->renderMe = false;
                }
            } else {
                $this->renderMe = true;
            }
        }

        /**
         * Not Render if match
         * @param string $param Comma separated permission list
         * @depends \SphpBase::sphp_permissions()->isPermission
         */
        public function fu_unsetrender($permis = "") {
            if ($permis != "") {
                if (\SphpBase::sphp_permissions()->isPermission($permis)) {
                    $this->renderMe = false;
                } else {
                    $this->renderMe = true;
                }
            } else {
                $this->renderMe = false;
            }
        }

        /**
         * Not Render Tag if not match
         * @param string $permis Comma separated permission list
         * @depends \SphpBase::sphp_permissions()->isPermission
         */
        public function fu_setrenderTag($permis = "") {
            if ($permis != "") {
                if (\SphpBase::sphp_permissions()->isPermission($permis)) {
                    $this->renderTag = true;
                } else {
                    $this->renderTag = false;
                }
            } else {
                $this->renderTag = true;
            }
        }

        /**
         * Not Render Tag if match
         * @param string $permis Comma separated permission list
         * @depends \SphpBase::sphp_permissions()->isPermission
         */
        public function fu_unsetrenderTag($permis = "") {
            if ($permis != "") {
                if (\SphpBase::sphp_permissions()->isPermission($permis)) {
                    $this->renderTag = false;
                } else {
                    $this->renderTag = true;
                }
            } else {
                $this->renderTag = false;
            }
        }

        /**
         * Not Auto Fill with viewData method if match
         * @param string $permis Comma separated permission list
         * @depends \SphpBase::sphp_permissions()->isPermission
         */
        public function fi_setDontFill($permis = "") {
            if ($permis != "") {
                if (\SphpBase::sphp_permissions()->isPermission($permis)) {
                    $this->blnDontFill = true;
                } else {
                    $this->blnDontFill = false;
                }
            } else {
                $this->blnDontFill = true;
            }
        }

        /**
         * Not Auto Fill with viewData method if not match
         * @param string $permis Comma separated permission list
         * @depends \SphpBase::sphp_permissions()->isPermission
         */
        public function fi_unsetDontFill($permis = "") {
            if ($permis != "") {
                if (\SphpBase::sphp_permissions()->isPermission($permis)) {
                    $this->blnDontFill = false;
                } else {
                    $this->blnDontFill = true;
                }
            } else {
                $this->blnDontFill = false;
            }
        }

        /**
         * Not Submit if match
         * @param string $permis Comma separated permission list
         * @depends \SphpBase::sphp_permissions()->isPermission
         */
        public function fi_setDontSubmit($permis = "") {
            if ($permis != "") {
                if (\SphpBase::sphp_permissions()->isPermission($permis)) {
                    $this->blnDontSubmit = true;
                } else {
                    $this->blnDontSubmit = false;
                }
            } else {
                $this->blnDontSubmit = true;
            }
        }

        /**
         * Not Submit if not match
         * @param string $permis Comma separated permission list
         * @depends \SphpBase::sphp_permissions()->isPermission
         */
        public function fi_unsetDontSubmit($permis = "") {
            if ($permis != "") {
                if (\SphpBase::sphp_permissions()->isPermission($permis)) {
                    $this->blnDontSubmit = false;
                } else {
                    $this->blnDontSubmit = true;
                }
            } else {
                $this->blnDontSubmit = false;
            }
        }

        /**
         * Not Insert with inserData if match
         * @param string $permis Comma separated permission list
         * @depends \SphpBase::sphp_permissions()->isPermission
         */
        public function fi_setDontInsert($permis = "") {
            if ($permis != "") {
                if (\SphpBase::sphp_permissions()->isPermission($permis)) {
                    $this->blnDontInsert = true;
                } else {
                    $this->blnDontInsert = false;
                }
            } else {
                $this->blnDontInsert = true;
            }
        }

        /**
         * Not Insert with inserData if not match
         * @param string $permis Comma separated permission list
         * @depends \SphpBase::sphp_permissions()->isPermission
         */
        public function fi_unsetDontInsert($permis = "") {
            if ($permis != "") {
                if (\SphpBase::sphp_permissions()->isPermission($permis)) {
                    $this->blnDontInsert = false;
                } else {
                    $this->blnDontInsert = true;
                }
            } else {
                $this->blnDontInsert = false;
            }
        }

        /**
         * Not Update with updateData if match
         * @param string $permis Comma separated permission list
         * @depends \SphpBase::sphp_permissions()->isPermission
         */
        public function fi_setDontUpdate($permis = "") {
            if ($permis != "") {
                if (\SphpBase::sphp_permissions()->isPermission($permis)) {
                    $this->blnDontUpdate = true;
                } else {
                    $this->blnDontUpdate = false;
                }
            } else {
                $this->blnDontUpdate = true;
            }
        }

        /**
         * Not Update with updateData if not match
         * @param string $permis Comma separated permission list
         * @depends \SphpBase::sphp_permissions()->isPermission
         */
        public function fi_unsetDontUpdate($permis = "") {
            if ($permis != "") {
                if (\SphpBase::sphp_permissions()->isPermission($permis)) {
                    $this->blnDontUpdate = false;
                } else {
                    $this->blnDontUpdate = true;
                }
            } else {
                $this->blnDontUpdate = false;
            }
        }

        /**
         * Set HTML Tag's Name Attribute, By Default it will be empty.
         */
        public function fu_setHTMLName($val) {
            $this->HTMLName = $val;
        }

        /**
         * Set HTML Tag ID Attribute, By Default it will be use object name.
         * If ref-object is used then only main object will set id from name of object.
         */
        public function fu_setHTMLID($val) {
            $this->HTMLID = $val;
        }

        /**
         * Submit Component value via Ajax Request and it 
         * generate all required JS code automatically.
         * in front file use:- funsubmitAJAX="click,|index-p1.html,|textarea1,textbox1"
         * @param type $eventName JS Event Name
         * @param type $url Optional Default=page_event_compname_$eventName URL to post data
         * @param type $extracomp Comma Separated list html tag id or class with prefix . to send data
         */
        public function fu_submitAjax($eventName, $url = "", $extracomp = "") {
            if ($url == "")
                $url = getEventURL($this->name . "_" . $eventName,"","","","",false,".app",true);
            $selector = "#" . $this->name;
            //$jsfun = $selector . $eventName;
            $jsfun = str_replace("#", "", $selector);
            $jsfun = str_replace(".", "", $jsfun);
            $jsfun = "comp_" . $jsfun . "_" . $eventName;
            $this->onJsEvent($eventName, $jsfun);
            $lstcomp = "";
            if ($extracomp != "") {
                $ar1 = explode(",", $extracomp);
                foreach ($ar1 as $key => $val) {
                    if($val[0] != '.') $val = "#$val";
                    $lstcomp .= 'data["' . substr($val,1) . '"] = getValue("'. $val .'");';
                }
            }
            addHeaderJSFunction($jsfun, 'function ' . $jsfun . '(evtp){var data = {}; data["' . $this->name . '"] = $("#' . $this->name . '").val(); ' . $lstcomp . ' getURL("' . $url . '",data);', '}');
        }

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
        public function fu_submitWS($eventName, $host = "", $extracomp = "",$ctrl="main",$evt="",$evtp="") {
            $selector = "#" . $this->name;
            //$jsfun = $selector . $eventName;
            $jsfun = str_replace("#", "", $selector);
            $jsfun = str_replace(".", "", $jsfun);
            $jsfun = "compws_" . $jsfun . "_" . $eventName;
            $this->onJsEvent($eventName, $jsfun);
            $lstcomp = "";
            if ($extracomp != "") {
                $ar1 = explode(",", $extracomp);
                foreach ($ar1 as $key => $val) {
                    if($val[0] != '.') $val = "#$val";
                    $lstcomp .= 'data["' . substr($val,1) . '"] = getValue("'. $val .'");';
                }
            }
            $subcode = "";
            if($host != "") $subcode = " frontobj.websockethost = '$host'; ";
        $subcode .= " frontobj.websockethost = '$host'; frontobj.getSphpSocket(function(wsobj1){
    wsobj1.callProcessApp('{$ctrl}','{$evt}','{$evtp}',data);
});";

            addHeaderJSFunction($jsfun, 'function ' . $jsfun . '(evtp){var data = {}; data["' . $this->name . '"] = $("#' . $this->name . '").val(); ' . $lstcomp . ' ' . $subcode, '}');
        }

        /**
         * End List of Fusion Methods
         */
        

        /**
         * Get Name of Object which is used for html tag id and name.
         * @return String
         */
        public function getName() {
            return $this->name;
        }

        public function getValue() {
            return $this->value;
        }
        
        /**
         * escape single or double quotation in value. This don't need DB Connection.
         * It is not escape sql characters. Use dbEngine->cleanQuery() for properly safe value but
         * it need db connection.
         * @return string
         */
        public function getSqlSafeValue() {
            $string = stripslashes($this->value);
            $search = array("'", "\"");
            $replace = array("\\'", "\\\"");
            $string = str_replace($search, $replace, $string);
            return $string;
        }

        public function getDefaultValue() {
            return $this->defvalue;
        }

        /**
         * Set HTML Tag Name
         * @param string $param
         */
        public function setTagName($param) {
            $this->tagName = $param;
        }

        /**
         * Set HTML pre Tag. This HTML code will display before component Tag.
         * @param string $val
         */
        public function setPreTag($val) {
            $this->element->setPreTag($val);
        }

        /**
         * Add(Concatenate) HTML pre Tag in previous pre tag. 
         * This HTML code will display before component Tag.
         * @param string $val
         */
        public function addPreTag($val) {
            $this->element->pretag .= $val;
        }

        public function getPreTag() {
            return $this->element->pretag;
        }

        /**
         * Set HTML post Tag. This HTML code will display after component Tag.
         * @param string $val
         */
        public function setPostTag($val) {
            $this->element->setPostTag($val);
        }

        /**
         * Add(Concatenate) HTML post Tag in previous post tag. 
         * This HTML code will display after component Tag.
         * @param string $val
         */
        public function addPostTag($val) {
            $this->element->posttag .= $val;
        }

        public function getPostTag() {
            return $this->element->posttag;
        }

        /**
         * Set HTML pre Tag for children. 
         * This HTML code will display before any component children Tags.
         * @param string $val
         */
        public function setInnerPreTag($val) {
            $this->element->setInnerPreTag($val);
        }

        /**
         * Get All attributes of Tag
         * @return array
         */
        public function getAttributes() {
            return $this->element->getAttributes();
        }

        /**
         * Read Attribute of Tag
         * @param string $name Attribute name
         * @return string
         */
        public function getAttribute($name) {
            return $this->element->getAttribute($name);
        }

        /**
         * Set Attribute of Tag
         * $div1->setAttribute('style','color: #ff6789');
         * @param string $name Attribute name
         * @param string $val
         */
        public function setAttribute($name, $val) {
            $this->element->setAttribute($name, $val);
        }

        /**
         * Remove Attribute
         * @param string $name Attribute name
         */
        public function removeAttribute($name) {
            $this->element->removeAttribute($name);
        }

        /**
         * Set Attribute of Tag if value is empty
         * $div1->setAttribute('style','color: #ff6789');
         * @param string $name Attribute name
         * @param string $val
         */
        public function setAttributeDefault($name, $val) {
            if ($this->element->getAttribute($name) == "") {
                $this->element->setAttribute($name, $val);
            }
        }

        /**
         * Set Inner HTML of Tag
         * @param string $val
         */
        public function setInnerHTML($val) {
            $this->element->setInnerHTML($val);
        }

        public function getInnerHTML() {
            return $this->element->getInnerHTML();
        }

        /**
         * Append HTML code
         * @param \Sphp\tools\NodeTag $html
         */
        public function appendHTML($html) {
            $this->element->appendHTML($html);
        }

        /**
         * Wrap Tag with valid HTML Tag
         * @param string $tagname
         * @return \Sphp\tools\NodeTag
         */
        public function wrapTag($tagname) {
            return $this->element->wrapTag($tagname);
        }

        /**
         * Wrap Children Tags with valid HTML Tag Name
         * @param string $tagname
         * @return \Sphp\tools\NodeTag
         */
        public function wrapInnerTags($tagname) {
            return $this->element->wrapInnerTags($tagname);
        }

        public function setVisible() {
            $this->visible = true;
        }

        public function unsetVisible() {
            $this->visible = false;
        }

        public function getVisible() {
            return $this->visible;
        }

        public function getrender() {
            return $this->renderMe;
        }

        public function getrenderTag() {
            return $this->renderTag;
        }

        public function setDataType($val) {
            $this->dataType = $val;
        }

        public function getDataType() {
            return $this->dataType;
        }

        public function setDataBound() {
            $this->dataBound = true;
            $this->blnDontFill = false;
        }

        public function unsetDataBound() {
            $this->dataBound = false;
            $this->blnDontFill = true;
        }

        public function getDataBound() {
            return $this->dataBound;
        }

        public function getDontFill() {
            return $this->blnDontFill;
        }

        public function getDontSubmit() {
            return $this->blnDontSubmit;
        }

        public function getDontInsert() {
            return $this->blnDontInsert;
        }

        public function getDontUpdate() {
            return $this->blnDontUpdate;
        }

        public function getEndTag() {
            return $this->blnendtag;
        }

        /**
         * Enable Closing Tag
         */
        public function setEndTag() {
            $this->blnendtag = true;
        }

        /**
         * Disable Closing Tag
         */
        public function unsetEndTag() {
            $this->blnendtag = false;
        }

        public function setPathRes($val) {
            $this->myrespath = $val;
        }

        /**
         * Get Parent FrontFile
         * @return \Sphp\tools\FrontFile FrontFile Object
         */
        public function getFrontobj() {
            return $this->frontobj;
        }

        /**
         * Advanced Method,Internal use
         * @param \Sphp\tools\FrontFile $frontobj
         */
        public function _setFrontobj($frontobj) {
            $this->frontobj = $frontobj;
            if ($this->dfield != "") {
                \SphpBase::sphp_api()->addComponentDB($this->frontobj->name, $this->name, $this);
            }
        }

        /**
         * Get All Children Components. Only Component Tags are included as child and ignored normal HTML tags
         * @return array
         */
        public function getChildren() {
            return $this->children;
        }

        /**
         * Add Child Component
         * @param \Sphp\tools\Component $child
         */
        public function _addChild($child) {
            $this->children[] = $child;
        }

        /**
         * Get Parent Component if any or null
         * @return \Sphp\tools\Component
         */
        public function getParentComponent() {
            return $this->parentobj;
        }
        
        /**
         * Regsiter Event for Object which uses for Event Driven Programming.
         * @param string $event_name
         */
        protected function registerEvent($event_name) {
            $this->eventRegister[$event_name] = array("null", "null");
        }

        protected function isRegisterHandler($event_name) {
            if ($this->eventRegister[$event_name][1] != "null") {
                return true;
            } else {
                return false;
            }
        }

        private function setEventHandlerIn($event_name, $element) { 
            if ($element->getAttribute($event_name) == "true") {
                $fun = "comp_" . $this->name . "_" . str_replace("-", "_", $event_name);
                $this->setEventHandler($event_name, $fun, $this->frontobj->getBindApp());
            }
        }

        /**
         * Set Event Handler of Component. 
         * This is Registered Event in component which can handle by application.
         * @param string $event_name Event Name to handle
         * @param string $handler Name of Function or Method that handle event
         * @param object $eventhandlerobj Optional Object handle the event 
         */
        public function setEventHandler($event_name, $handler, $eventhandlerobj = "null") {
            if (isset($this->eventRegister[$event_name])) {
                if (is_object($eventhandlerobj) && $eventhandlerobj != "null") {
//    global $$eventhandlerobj; 
                    $this->eventRegister[$event_name] = array($eventhandlerobj, "$handler");
                } else {
                    // disable global function call
                    $this->eventRegister[$event_name] = array($eventhandlerobj, "$handler");
//     throw new \Exception("Object $this->name does not support global event handler for event = $event_name ");
                }
            } else {
                throw new \Exception("Object " . $this->name . " has not defined event = " . $event_name);
            }
        }

        protected function raiseEvent($event_name, $arglst = array()) {
            $arglst["obj"] = $this;
            $arglst["evt"] = $event_name;

            if (is_object($this->eventRegister[$event_name][0])) {
                call_user_func_array(array($this->eventRegister[$event_name][0], $this->eventRegister[$event_name][1]), array($arglst));
            } else if ($this->eventRegister[$event_name][1] != "null") {
                call_user_func_array($this->eventRegister[$event_name][1], array($arglst));
            }
        }

        protected function registerEventJS($event_name) {
            $this->eventRegisterJS[$event_name] = array("null", "null");
        }

        protected function isRegisterHandlerJS($event_name) {
            if ($this->eventRegisterJS[$event_name][1] != "null") {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Set Event Handler for JS Code
         * @param string $event_name Event Name to handle
         * @param string $handler Name of JS Function that handle event
         * @param object $eventhandlerobj Optional not supported 
         */
        public function setEventHandlerJS($event_name, $handler, $eventhandlerobj = "null") {
            if (isset($this->eventRegisterJS[$event_name])) {
                if (is_object($eventhandlerobj) && $eventhandlerobj != "null") {
//    global $$eventhandlerobj; 
                    throw new \Exception("Object " . $this->name . " does not support OOP event handler for JS event = " . $event_name);
//$this->eventRegisterJS[$event_name] = array($$eventhandlerobj,"$handler");
                } else {
                    $this->eventRegisterJS[$event_name] = array($eventhandlerobj, "$handler");
                }
            } else {
                throw new \Exception("Object '" . $this->name . "' has not defined '" . $event_name . "' JS event");
            }
        }

        /**
         * Generate JS Code to call event handler which 
         * is set by setEventHandlerJS method.
         * @param string $event_name
         * @param array $arglst
         * @return string
         */
        protected function raiseEventJS($event_name, $arglst = array()) {
            if (!is_object($this->eventRegisterJS[$event_name][0])) {
                $str = "";
                if (!isset($arglst["obj"])) {
                    $arglst["obj"] = "$('#" . $this->name . "')";
                }
                $arglst["evt"] = "'" . $event_name . "'";
                $arglst["event"] = "event";

                foreach ($arglst as $key => $value) {
                    if (!is_string($value)) {
                        $value = '"' . $value . '"';
                    }
                    if ($str == "") {
                        $str .= "\"" . $key . "\": " . $value;
                    } else {
                        $str .= ",\"" . $key . "\": " . $value;
                    }
                }
                if ($this->eventRegisterJS[$event_name][1] == "null") {
                    $str = "comp_" . $this->name . "_" . $event_name . "(" . "{" . $str . "}" . ")";
                } else {
                    $str = $this->eventRegisterJS[$event_name][1] . "(" . "{" . $str . "}" . ")";
                }
                return $str;
            }
            return "";
        }
        
        /**
         * 
         * @param string $eventName JS Event Name
         * @param string $handlerFunName JS Function to handle Event
         * @param boolean $renderonce Optional default=false, true=ignore on ajax request
         */
        public function onJsEvent($eventName, $handlerFunName = "", $renderonce = false) {
            array_push($this->onjseventlist, array("#" . $this->name, $eventName, $handlerFunName, $renderonce));
        }

        /**
         * This function only work if JS Function as also created by addHeaderJSFunction.
         * @param string $funname JS Function name where code need to insert
         * @param string $name JS code block id
         * @param string $code JS Code to insert into JS Function
         * @param boolean $renderonce Optional default=false, true=ignore on ajax request
         */
        public function addHeaderJSFunctionCode($funname, $name, $code, $renderonce = false) {
            array_push($this->headerFunctionCode, array($funname, $name, $code, $renderonce));
        }

        /**
         * Add Component as JS variable part of FrontFile JS Object. 
         * HTML Name of component used as variable name in JS code. By default it
         * is same as tag id.
         * in JS you can get Component object as front1.getComponent('txtname');
         */
        public function addAsJSVar() {
            $this->frontobj->addAsJSVar();
            addHeaderJSCode('jsobj' . $this->HTMLID, $this->frontobj->getName() . '.addComponent("'. $this->HTMLID .'");');
        }
        
        /**
         * Set Component as JS variable part of FrontFile JS Object. Remember not all component 
         * will automatically create js object. It is created by component code. If component 
         * developer doesn't offer JS integration then there are no any JS object. 
         * in JS you can set Component object as front1.setComponent('txtname','$jscode');
         * @param string $jscode JS Code as String
         * @return string JS code
         */
        public function setAsJSVar($jscode) {
            return $this->frontobj->getName() . '.setComponent("'. $this->HTMLID .'",'. $jscode .');';
        }

        /**
         * Get Component as JS Variable.
         * return code like front1.getComponent('txtname');
         * @return string JS code
         */
        public function getAsJSVar() {
            return $this->frontobj->getName() . '.getComponent("'. $this->HTMLID .'");';
        }
        
        /**
         * Bind with any JS Event with $handlerFunName. 
         * It generate all required JS code and add into jQuery ready handler.
         * @param string $selector jQuery selector
         * @param string $eventName JS Event Name
         * @param string $handlerFunName JS function name for handling event.
         * @param boolean $renderonce Optional default=false, true=ignore on ajax request
         */
        protected function bindJSEvent($selector, $eventName, $handlerFunName = "", $renderonce = false) {
            $jsfun = $selector . $eventName;
            if ($handlerFunName == "") {
                $jsfun = str_replace("#", "", $selector);
                $jsfun = str_replace(".", "", $jsfun);
                $jsfun = "comp_" . $jsfun . "_" . $eventName;
                $handlerFunName = $jsfun;
            }
            addHeaderJSFunctionCode("ready", $jsfun, ' $("' . $selector . '").on("' . $eventName . '",function(event, ui){ var rt = ' . $handlerFunName . '({obj: $(event.target),evt: "' . $eventName . '",event: event,ui: ui}); return rt;});', $renderonce);
        }

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
        protected function bindJSObjEvent($selector, $obj, $eventName, $handlerFunName = "", $renderonce = false) {
            $jsfun = $selector . $eventName;
            if ($handlerFunName == "") {
                $jsfun = str_replace("#", "", $selector);
                $jsfun = str_replace(".", "", $jsfun);
                $jsfun = "comp_" . $jsfun . "_" . $eventName;
                $handlerFunName = $jsfun;
            }
            addHeaderJSFunctionCode("ready", $jsfun, ' $("' . $selector . '").' . $obj . '({' .
                    $eventName . ': function(event, ui){ var rt = ' . $handlerFunName .
                    '({obj: $("' . $selector . '"),evt: "' . $eventName . '",event: event,ui: ui}); return rt;}});', $renderonce);
        }
        /**
         * Prase HTML string and trigger onprase event for each node
         * @param string $html
         * @return string process html by onprocess callback
         */
        public function parseHTML($html) {
            $htmlparser = new \Sphp\tools\HTMLDOM();
            $htmlparser->load($html,false);
            $this->parserm($htmlparser->root->nodes);
            return $htmlparser->root->outertext;
        }

        private function parserm($nodes) {
			
            foreach ($nodes as $key => $node) {
                if ($node->nodetype == 1) {
                    $this->onparse("start", $node);
                    if ($node->hasChildren()) {
                        $this->parserm($node->children);
                    }
                    $this->onparse("end", $node);
                }
            }
        }

        final public  function getHelp() {
            $this->setPostTag('<a href="http://www.sartajphp.com/" target="__blank" >For More Help Visit Sphp Website</a>');
        }

        private function renderOnJsEvent() {
            foreach ($this->onjseventlist as $key => $value) {
                $this->bindJSEvent($value[0], $value[1], $value[2], $value[3]);
            }
            foreach ($this->headerFunctionCode as $key => $value) {
                addHeaderJSFunctionCode($value[0], $value[1], $value[2], $value[3]);
            }
        }

        final public function _render() {
            $strRet = "";
            if ($this->renderMe == true) {
                $this->onjsrender();
                $this->onrender();
                $this->renderLast();
                $this->raiseEvent("on-endrender",array("element" => $this->element));
                if ($this->parentobj != null) {
                    $this->parentobj->onchildevent("onrender", $this);
                }
                $this->getHTMLTag();
            }
            $this->element->blnrender = $this->renderMe;
            $this->element->blnrenderTag = $this->renderTag;
            $this->element->blnselfclose = !$this->blnendtag;

//        return $strRet;
        }

        final public function _prerender() {
            if ($this->renderMe == true) {
                $this->raiseEvent("on-startrender",array("element" => $this->element));
                $this->renderOnJsEvent();
                $this->onprejsrender();
                $this->onprerender();
                if ($this->parentobj != null) {
                    $this->parentobj->onchildevent("onprerender", $this);
                }
            }
        }

//        $this->callback = array($function_name,$obj);
// $this->callback = null;
        final public function _oncompinit($element) {
            // set all internal events
            $this->setEventHandlerIn("on-init", $element);
            $this->setEventHandlerIn("on-create", $element);
            $this->setEventHandlerIn("on-startrender", $element);
            $this->setEventHandlerIn("on-endrender", $element);
            $this->oninit();
            $this->raiseEvent("on-init", array("element" => $element));
        }

        final public function _oncompcreate($element) {
            $this->raiseEvent("on-create", array("element" => $element));
            $this->oncreate($element);
            if ($this->parentobj != null) {
                $this->parentobj->onchildevent("oncreate", $this);
            }
        }


        /**
         * Advance Function
         * Execute Limited PHP Code for Template tags ##{} #{}#. 
         * Global variables are not available, only component object $compobj and its public variables are available
         * @param string &$strPHPCode Template code
         * @return string
         */
        protected function executePHPCode(&$strPHPCode) {
            try {
                return $this->frontobj->executePHPCode($strPHPCode,$this);
            } catch (\Exception $e) {
                trigger_error($e->getMessage() . ' in FrontFile:- ' . $this->frontobj->filePath . ' Component:- ' . $this->name);
            }
            return "";
        }

        /**
         * Advance Function
         * Read file and process PHP and return result. 
         * Global variables are not available, only component object and its public variables are available
         * @param string $filepath File Path
         * @return string
         */
        protected function getDynamicContent($filepath) {
            $strPHPCode = file_get_contents($filepath);
            return $this->executePHPCode($strPHPCode);
        }

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
        public function addDynamicFileLink($fileURL2, $renderonce = false, $filename = "", $ext = "", $ver = "0") {
            $filep = pathinfo($fileURL2);
            if ($filename == "") {
                $filename = $filep["filename"];
            } else {
                
            }
            if ($ext == "") {
                $ext = strtolower($filep["extension"]);
            }
            if (\SphpBase::sphp_settings()->translatermode) {
                $fileURL = "cache/" . $filename . "." . $ext;
                file_put_contents($fileURL, $this->getDynamicContent($fileURL2));
            } else {
                $fileURL = "cache/" . $filename . "." . $ext;
            }

            \SphpBase::sphp_api()->addFileLink($fileURL, $renderonce, $filename, $ext, $ver);
        }
// public interface to trigger events
        public function _trigger_after_create(){
            $this->onaftercreate();
        }
        public function _trigger_app_event(){
            $this->onappevent();
        }
        public function _trigger_holder($element){
            $this->onholder($element);
        }
        
        /** override functions list start here, in order of life cycle events trigger.
         *  You can Design a new Component with override these functions in child class.
         */

        /**
         *  override this Life-Cycle event handler in your Component to handle it.
         *  trigger when Component initialize and before any children Components initialize. You can set default values of Component 
         *  in this event handler.
         */
        protected function oninit() {
            
        }
        /**
         * override this Life-Cycle event handler in your Component to handle it.
         * trigger when Component Create and before any children components Create event. 
         * We can read all static attributes and "fui-_*" 
         * dynamic attributes  set in FrontFile. So you can decide your default values or
         * calculate or validate request submit in this handler.
         * @param \Sphp\tools\NodeTag $element A HTML element of component
         */
        protected function oncreate($element) {
            
        }
        /**
         * override this Life-Cycle event handler in your Component to handle it.
         * trigger when All Components of FrontFile is created. If Component 
         * settings or input dependent on other components of FrontFile or  
         * it's children Components then we can use this handler to work further. For
         * Example our component need to read Page Title when it find Title Component in 
         * FrontFile.  
         */
        protected function onaftercreate() {
            
        }
        /**
         *  override this Life-Cycle event handler in your Component to handle it.
         *  trigger when Component Get Application ready Event as AppEvent. Trigger after 
         *  App onrun event.
         *  In this event handler Component can handle it's own PageEvents and reply AJAX directly 
         *  to Browser and reduce the work App and developer. But this will work only if FrontFile
         *  Object is created on App Life-Cycle event handler onstart.
         */
        protected function onappevent() {
            
        }
        /**
         *  override this Life-Cycle event handler in your Component to handle it.
         *  trigger before onprerender,onjsrender,onrender and before any children Components event PreJsRender and PreRender.
         *  This will not work if Front File not Render or disable Component rendering. 
         *  You can create JS Function with addHeaderJSFunction and then Children can write their code inside 
         *  this JS Function with addHeaderJSFunctionCode. You can divide your logic between various render
         *  event handlers.
         */
        protected function onprejsrender() {
            
        }
        /**
         * override this Life-Cycle event handler in your Component to handle it.
         * trigger before onjsrender, onrender and PreRender of children Components.
         *  write js,html code which help or need by children for further addition onrender
         *  This will not work if Front File not Render or disable Component rendering. 
         */
        protected function onprerender() {
            
        }
        /**
         * override this Life-Cycle event handler in your Component to handle it.
         * trigger when Component before onrender and after children render. Mostly
         *  use to write own JS code and links external js,css files.
         *  This will not work if Front File not Render or disable Component rendering. 
         */
        protected function onjsrender() {
            
        }
        /**
         * override this Life-Cycle event handler in your Component to handle it.
         * trigger when Component Render and Before RenderLast. Mostly use to 
         * write HTML layout,design or over-write children output
         *  This will not work if Front File not Render or disable Component rendering. 
         */
        protected function onrender() {
            
        }
        /**
         * override this Life-Cycle event handler in your Component to handle it.
         * trigger when Component RenderLast After all output is generated. Use by Complex components.
         *  This will not work if Front File not Render or disable Component rendering. 
         */
        protected function renderLast() {
            
        }

        /**
         * override this event handler in your Component to handle it.
         * trigger on Children Component Events. Use for interaction between parent 
         *  child. So it is not Life-Cycle event.
         * @param string $event Name of Event value may be oncreate,onprerender or onrender
         * @param \Sphp\tools\Component $obj Child Component
         */
        protected function onchildevent($event, $obj) {
            
        }
        /**
         * override this event handler in your Component to handle it.
         * trigger when Runtime Attribute runas used with value of "holder" and that pass \Sphp\tools\NodeTag 
         * Tag Object to component and then Component can display any type of content on holder object. 
         * With helper attribute only data-comp and leave data-prop.
         *  <div runas="holder" data-comp="pagrid1"></div>
         *  So it is not Life-Cycle event.
         * @param \Sphp\tools\NodeTag $obj 
         */
        protected function onholder($obj) {
            
        }
        /**
         * Advance Function
         * override this event handler in your Component to handle it.
         * trigger when HTML text parse with parseHTML function.
         * @param string $event value may be start or end.
         * @param \Sphp\tools\HTMLDOMNode $domelement
         */
        protected function onparse($event, $domelement) {
            
        }
        
        public function __toString() {
            $ret = $this->_render();
            if($ret == null) return "";
            return $ret;
        }

        public function &__get($name) {
            switch ($name) {
                case "parameterA": {
                        return $this->element->attributes;
                        break;
                    }
                case "innerHTML": {
                        $ohtml = $this->element->getInnerHTML();
                        return $ohtml;
                        break;
                    }
                case "outerHTML": {
                        $ohtml = $this->element->getOuterHTML();
                        return $ohtml;
                        break;
                    }
                default: {
                        $ohtml = $this->element->getAttribute($name);
                        return $ohtml;
                    }
            }
        }

        public function __set($name, $value) {
            switch ($name) {
                case "parameterA": {
                        $this->element->attributes = $value;
                        break;
                    }
                case "preTag": {
                        $this->element->setPreTag($value);
                        break;
                    }
                case "postTag": {
                        $this->element->setPostTag($value);
                        break;
                    }
                case "innerHTML": {
                        $this->element->setInnerHTML($value);
                        break;
                    }
                case "outerHTML": {
                        $this->element->setOuterHTML($value);
                        break;
                    }
                default: {
                        $this->element->setAttribute($name, $value);
                    }
            }
        }

        public function __isset($name) {
            //no value attr: nowrap, checked selected...
            return ($this->element->hasAttribute($name));
        }

        public function __unset($name) {
            $this->element->removeAttribute($name);
        }

        private function getHTMLTag() {
            if ($this->renderMe == true) {
                if ($this->visible == false) {
                    $this->tagName = "input";
                    $this->setAttribute("type", "hidden");
                    $this->blnendtag = false;
                }
                if ($this->tagName != $this->element->tagName) {
                    $this->element->setTagName($this->tagName);
                }
                if (!$this->element->refcomptag) {
                    if ($this->HTMLName != "") {
                        $this->setAttribute("name", $this->HTMLName);
                    } else {
                        $this->element->removeAttribute("name");
                    }
                    if ($this->HTMLID != "") {
                        $this->setAttribute("id", $this->HTMLID);
                    } else {
                        $this->element->removeAttribute("id");
                    }
                }
//            if ($this->renderTag && $this->blnendtag) {
                //              $taghtml .= "</" . $this->tagName . ">";
                //        }
            }
        }
        /**
         * Advance Function, Internal use
         */
        public function setClassPath() {
            $class_info = new \ReflectionClass($this);
            $p1 = \SphpBase::sphp_api()->filepathToRespaths($class_info->getFileName());
            $this->cfilepath = $p1[3];
            $this->cfilename = $p1[0]["filename"];
            $this->mypath = $p1[1];
            $this->myrespath = $p1[2];
        }
        /**
         * Advance Function, Internal use
         */
        final public function init($name, $fieldName = "", $tableName = "") {
            $ret = false;
            $this->registerEvent("on-init");
            $this->registerEvent("on-create");
            $this->registerEvent("on-startrender");
            $this->registerEvent("on-endrender");
            if ($name != "") {
                $this->name = $name;
                $this->HTMLID = $name;
            }
            $this->dtable = $tableName;
            $this->dfield = $fieldName;
            if (\SphpBase::sphp_request()->isRequest($name)) {
                $this->issubmit = true;
            }

            if ($this->issubmit) {
                $ret = true;
                $this->value = strval(\SphpBase::sphp_request()->request("$name"));
//unset (\SphpBase::sphp_request()->request("$name"]);
                if ($this->dfield != "") {
                    $this->dataBound = true;
                }
            }
            $this->setClassPath();
            return $ret;
        }
        /**
         * Add Help for Component
         * @param string $name prop name
         * @param string $help Help text
         * @param string $val value list
         * @param string $param
         * @param string $type Data Type
         * @param string $options
         */
        protected function addHelpPropList($name, $help = '', $val = '', $param = '', $type = '', $options = '') {
            //value,param,editortype,options for value,helptext,proptype = call function or attribute
            // if param = r then property readonly, param also help to show input parameter for functions
            $this->proplist[$name] = array($val, $param, $type, $options, $help, '');
        }
        /**
         * Add Help for Component
         * @param string $name function name
         * @param string $help Help text
         * @param string $val value list
         * @param string $param
         * @param string $type Data Type
         * @param string $options
         */
        protected function addHelpPropFunList($name, $help = '', $val = '', $param = '', $type = '', $options = '') {
            //value,param,editortype,options for value,helptext,proptype = call function or attribute
            // if param = r then property readonly, param also help to show input parameter for functions
            $this->proplist[$name] = array($val, $param, $type, $options, $help, 'f');
        }
        /**
         * Advance Function, Internal use
         */
        public function helpPropList() {
            $this->genhelpPropList();
            $attrilist = $this->element->attributes;
            foreach ($attrilist as $atrn => $atrv) {
                $k1 = substr($atrn, 3);
                if (isset($this->proplist[$k1])) {
                    $this->proplist[$k1][0] = $atrv;
                } else if (isset($this->proplist[$atrn])) {
                    $this->proplist[$atrn][0] = $atrv;
                } else {
                    $this->addHelpPropList($atrn, '', $atrv);
                }
            }
            ksort($this->proplist);
            return $this->proplist;
        }
        /**
         * Advance Function, Internal use
         */
        protected function genhelpPropList() {
            $this->proplist["runat"] = array('', '', 'select', 'server', 'runtime', '');
            $this->proplist["dtable"] = array($this->dtable, '', '', '', 'Database table name', '');
            $this->proplist["dfield"] = array($this->dfield, '', '', '', 'Database table Column name', '');

            $this->proplist["setHTMLName"] = array($this->HTMLName, '$val', '', '', 'HTML Tag Name', 'f');
            $this->proplist["setHTMLID"] = array($this->HTMLID, '$val', '', '', 'HTML Tag ID', 'f');
            $this->proplist["path"] = array($this->mypath, '$val', '', '', 'component file path', '');
            $this->proplist["pathres"] = array($this->myrespath, '$val', '', '', 'component file pathres', '');
            $this->proplist["setValue"] = array($this->value, '$val', '', '', 'value of component, few case of value attribute of tag', 'f');
            $this->proplist["setDefaultValue"] = array('', '$val', '', '', 'Default value if value is empty', 'f');
            $this->proplist["setTagName"] = array($this->tagName, '$val', '', '', 'HTML Tag name', 'f');
            $this->proplist["setPreTag"] = array('', '$val', '', '', 'Pre HTML', 'f');
            $this->proplist["setPostTag"] = array('', '$val', '', '', 'Post HTML', 'f');
            $this->proplist["setInnerPreTag"] = array('', '$val', '', '', 'first innerhtml', 'f');
            $this->proplist["setInnerPostTag"] = array('', '$val', '', '', 'last innerhtml', 'f');
            $this->proplist["wrapTag"] = array('', '$val', '', '', 'wrap with html tag', 'f');
            $this->proplist["wrapInnerTags"] = array('', '$val', '', '', 'wrap innerhtml with html tag', 'f');
            $this->proplist["setUnAuth"] = array('', '$auth_list', '', '', 'Unauthorised comma separated list which can not see this component', 'f');
            $this->proplist["setAuth"] = array('', '$auth_list', '', '', 'Authorised comma separated list which can see this component', 'f');
            $this->proplist["setrender"] = array('', '$permissions', '', '', 'Comma separated Permissions list which can see this component', 'f');
            $this->proplist["unsetrender"] = array('', '$permissions', '', '', 'Comma separated Permissions list which can not see this component', 'f');
            $this->proplist["setrenderTag"] = array('', '$permissions', '', '', 'Comma separated Permissions list which can see this Tag', 'f');
            $this->proplist["unsetrenderTag"] = array('', '$permissions', '', '', 'Comma separated Permissions list which can not see this Tag', 'f');
            $this->proplist["setDontFill"] = array('', '$permissions', '', '', 'Comma separated Permissions list which can not fetch data from database', 'f');
            $this->proplist["unsetDontFill"] = array('', '$permissions', '', '', 'Comma separated Permissions list which can fetch data from database', 'f');
            $this->proplist["setDontSubmit"] = array('', '$permissions', '', '', 'Comma separated Permissions list which can not insert or update to database', 'f');
            $this->proplist["unsetDontSubmit"] = array('', '$permissions', '', '', 'Comma separated Permissions list which can insert or update data to  database', 'f');
            $this->proplist["setDontInsert"] = array('', '$permissions', '', '', 'Comma separated Permissions list which can not insert to  database', 'f');
            $this->proplist["unsetDontInsert"] = array('', '$permissions', '', '', 'Comma separated Permissions list which can insert data to  database', 'f');
            $this->proplist["setDontUpdate"] = array('', '$permissions', '', '', 'Comma separated Permissions list which can not update data to  database', 'f');
            $this->proplist["unsetDontUpdate"] = array('', '$permissions', '', '', 'Comma separated Permissions list which can update data to database', 'f');
            $this->proplist["onJsEvent"] = array('', '$eventName,$handlerFunName="",$renderonce=false', '', '', 'Bind JS Event', '');

            $this->proplist["on-init"] = array('', '', '', '', 'Bind INIT Event with App', '');
            $this->proplist["on-create"] = array('', '', '', '', 'Bind Create Event with App', '');
            $this->proplist["on-startrender"] = array('', '', '', '', 'Bind Start Render Event with App', '');
            $this->proplist["on-endrender"] = array('', '', '', '', 'Bind End Render Event with App', '');
        }

    }

    class ComponentGroup extends Component {

        private $compApp = null;

        final public function onaftercreate() {
            includeOnce($this->mypath . '/apps/' . $this->cfilename . 'App' . ".app");
            $clsname = $this->cfilename . 'App';
            $this->compApp = new $clsname($this->frontobj, $this);
            $this->compApp->run();
        }

        final public function onrender() {
            $this->innerHTML = $this->compApp->getReturnData();
        }

        public function getCompApp() {
            return $this->compApp;
        }

    }

    class MenuGen {

        private $blnAjaxLink = false;
        public $htmlout = "";
        public $sphp_api = null;
        public $name = "def";

        public function __construct() {
            $this->sphp_api = \SphpBase::sphp_api();
            $this->onstart();
        }

        protected function onstart() {
            
        }

        protected function onrun() {
            
        }

        public function _run() {
            $this->onrun();
        }

        public function _render() {
            return $this->htmlout;
        }

    }

    class RenderComp {

        public function render($obj) {
            $obj->_prerender();
            $obj->_render();
            return $obj->element->_render();
        }

        public function createComp($id, $path = '', $class = '', $dfield = '', $dtable = '') {
            $sphp_settings = \SphpBase::sphp_settings();
            $comppath = $sphp_settings->comp_path;
            $libpath = $sphp_settings->slib_path;
            $libversion = $sphp_settings->slib_version;
            $phppath = $sphp_settings->php_path;
            $respath = $sphp_settings->res_path;

            if ($path == '') {
                $path = "{$phppath}/{$libversion}/comp/Tag.php";
            } else {
                $path = str_replace("component/", "{$phppath}/component/", $path);
                $path = str_replace("libpath/", "{$phppath}/{$libversion}/", $path);
            }
// set php class name automatically
            $patha = pathinfo($path);
            if ($class == '') {
                $class = $patha['filename'];
            }
            includeOnce($path);
            $comp = readGlobal($id);
            if (!is_object($comp)) {
                $comp = new $class($id, $dfield, $dtable);
                $comp->mypath = $patha['dirname'];
                if ($respath != '') {
                    $start = strpos($patha['dirname'], 'ontrols/');
                    if ($start > 0) {
                        $pathres = $respath . "/component/" . substr($patha['dirname'], $start + 8);
                        $comp->myrespath = $pathres;
                    } else {
                        $start = strpos($patha['dirname'], $libversion . '/');
                        if ($start > 0) {
                            $pathres = $respath . '/' . $libversion . "/" . substr($patha['dirname'], $start + strlen($libversion) + 1);
                            $comp->myrespath = $pathres;
                        }
                    }
                } else {
                    $comp->myrespath = $patha['dirname'];
                }
            }
            $element = new \Sphp\tools\NodeTag();
            $comp->element = $element;
            $element->setComponent($comp);
            $comp->_oncompinit($element);
            $comp->_oncompcreate($element);
            writeGlobal($id, $comp);

            return $comp;
        }

        public function createComp2($id, $path = '', $class = '', $dfield = '', $dtable = '') {
            $sphp_settings = \SphpBase::sphp_settings();
            $comppath = $sphp_settings->comp_path;
            $libpath = $sphp_settings->slib_path;
            $libversion = $sphp_settings->slib_version;
            $phppath = $sphp_settings->php_path;
            $respath = $sphp_settings->res_path;

            if ($path == '') {
                $path = "{$phppath}/{$libversion}/comp/Tag.php";
            } else {
                $path = str_replace("component/", "{$phppath}/component/", $path);
                $path = str_replace("libpath/", "{$phppath}/{$libversion}/", $path);
            }
// set php class name automatically
            $patha = pathinfo($path);
            if ($class == '') {
                $class = $patha['filename'];
            }
            includeOnce($path);
            $comp = readGlobal($id);
            if (!is_object($comp)) {
                $comp = new $class($id, $dfield, $dtable);
                $comp->mypath = $patha['dirname'];
                if ($respath != '') {
                    $start = strpos($patha['dirname'], 'ontrols/');
                    if ($start > 0) {
                        $pathres = $respath . "/component/" . substr($patha['dirname'], $start + 8);
                        $comp->myrespath = $pathres;
                    } else {
                        $start = strpos($patha['dirname'], $libversion . '/');
                        if ($start > 0) {
                            $pathres = $respath . '/' . $libversion . "/" . substr($patha['dirname'], $start + strlen($libversion) + 1);
                            $comp->myrespath = $pathres;
                        }
                    }
                } else {
                    $comp->myrespath = $patha['dirname'];
                }
                $element = new \Sphp\tools\NodeTag();
                $comp->element = $element;
                $element->setComponent($comp);
            }

            writeGlobal($id, $comp);

            return $comp;
        }

        public function compcreate($comp) {
            $element = $comp->element;
            $comp->_oncompinit($element);
            $comp->_oncompcreate($element);
        }

    }

}
