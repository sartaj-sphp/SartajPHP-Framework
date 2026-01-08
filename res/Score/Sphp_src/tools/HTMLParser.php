<?php
namespace Sphp\tools{

/**
 * Description of HTMLParser
 *
 * @author SARTAJ
 */
use Sphp\tools\SHTMLDOMOld;
use Sphp\tools\SHTMLDOM;
use Sphp\tools\HTMLDOM;

class HTMLParser {

    public $curelement = null;
    public $curlineno = 0;
    public $codebehind = array();
    public $blncodebehind = false;
    /**
    * @var \Sphp\tools\FrontFile
    */
    public $frontobj;
    public $dhtmldom;
    /** @var Sphp\Settings */
    public $sphp_settings = null;
    public $phppath = "";
    public $respath = "";
    public $comppath = "" ;
    public $slibpath = "" ;
    public $debug = null;
    private $sphpcodeblocks = null;
    private $seval1 = null;


    public function __construct($dhtml=false) {
        $this->sphp_settings = \SphpBase::sphp_settings();
        $this->phppath = $this->sphp_settings->php_path;
        $this->respath = $this->sphp_settings->res_path;
        $this->comppath = $this->sphp_settings->comp_path ;
        $this->slibpath = $this->sphp_settings->slib_path ;
        $this->debug = \SphpBase::debug();
        $this->seval1 = new \SEval();

        if($dhtml || $this->sphp_settings->run_hd_parser){ 
//            $this->dhtmldom = new SHTMLDOM($this);
//            // this feature disbaled
            //$this->dhtmldom = new SHTMLDOM2($this); // experiment
            throw new \Exception("This feature is disabled");
        }else{
//            $this->dhtmldom = new SHTMLDOM2($this); // experiment
            $this->dhtmldom = new SHTMLDOMOld($this);            
        }
    }
    public function getFrontobj() {
        return $this->frontobj;
    }

    public function _setFrontobj($frontobj) {
        $this->frontobj = $frontobj;
        if($this->debug->debugmode == 2){
            \SphpBase::debug()->cur_front_file = $this->frontobj->getFilePath();
        }
    }

    public function _setCodebehind($codebehind) {
        $this->codebehind = $codebehind;
    }
    
    private function setSeval($obj){
        $this->frontobj = $obj;
        $this->seval1->setMainObject($obj);
        $this->seval1->setObject('$frontobj', $this->frontobj);
        $this->seval1->setObject('$parentapp', $this->frontobj->parentapp);
        $this->seval1->setObject('$sphp_settings', \SphpBase::sphp_settings());
        $this->seval1->setVariable('$metadata', $this->frontobj->metadata);        
    }
    // process front file object on construct time, here
    public function parseHTMLObj($strData, $obj) {
        $this->setSeval($obj);
        // will disable in future
        $strData = $this->convertPHPToExpression($strData);
//$strData2 = $this->executePHPCode($strData);
        $this->dhtmldom->load($strData);
// Register the callback function with it's function name
//        $this->dhtmldom->set_callback($this->parsefirst, $this);
        $this->dhtmldom->parseobj();
    }
    
    // render front file object here
    public function parseHTML(){
// Register the callback function with it's function name
        //$t1 = microtime(true);
        $this->dhtmldom->renderobj();
        //$t2 = microtime(true);
        //$this->debug->println($this->frontobj->filePath ." Total Time Render:- " . (($t2 - $t1) * 1000));
        $strData = $this->dhtmldom->save();

        if($this->frontobj->intPHPLevel > 0){
            //$strData = $this->convertExpressionToPHP($strData);
            //$strData = str_replace("-#","->",$strData);
            /*
            $strData = str_replace("?&gt;","?>",$strData);
            $strData = str_replace("&lt;?php","<?php",$strData);
            $strData = str_replace("%20"," ",$strData);
             * 
             */
            $strData = $this->executePHPCode($strData);
        }
//return $output;
         return $strData;
    }

    public function parseComponent($compobj,$innerHTML = false){
// Register the callback function with it's function name
        if($innerHTML) $compobj->fu_unsetRenderTag();
        $roote = new NodeTag();
        $roote->type = "root";        
        $roote->appendChild($compobj->element);
        $this->dhtmldom->rendercompobj($roote);
        $strData = $this->dhtmldom->savecomp($roote);
        $strData = $this->convertExpressionToPHP($strData);
        $strData = str_replace("-#","->",$strData);
        $strData = $this->executePHPCode($strData);
         return $strData;
    }
    public function createTagComponent($name="mycustomtag1",$tagname="div") {
        $roote2 = new NodeTag();
        $roote2->tagName = $tagname;
        $roote2->blnselfclose = false;
        $roote2->_setComponent(new \Sphp\comp\Tag($name));
        //$roote2->children = $compobj->element->children;
        //print_r($roote2->getChildren());
        //$roote2->_setParent($roote);
        //$roote->appendChild($roote2);
        return $roote2;
    }
    public function getChildrenWrapper($compobj){
        $roote = new NodeTag();
        $roote->type = "root";
        $roote->children = $compobj->element->children;
        return $roote;
    }
    public function parseComponentChildren($wrapperElement){
// Register the callback function with it's function name
        $strData = "";
        $this->dhtmldom->rendercompobj($wrapperElement);
        $strData = $this->dhtmldom->savecomp($wrapperElement);
        //$strData = $this->convertExpressionToPHP($strData);
        //$strData = str_replace("-#","->",$strData);
        $strData = $this->executePHPCode($strData);
        return $strData;
    }

public function parseHTMLTag($strData,$callbackfun,$obj){
    $HTMLParser = new HTMLDOM();
    $HTMLParser->load($strData);
    $HTMLParser->set_callback($callbackfun,$obj);
    $strData = $HTMLParser->save();
    //$strData = $this->executePHPCode($strData);
    return $strData;
}
    
    
    public function setupcomp($element,$parentelement) {
        //global $apppath;
        try{
        $apppath = \SphpBase::page()->apppath;
        $this->curelement = $element; 
        // mark tag as raw and inside frontfile tag and, not dynamacally produced
        if($this->sphp_settings->blnEditMode){
            $element->setAttribute("data-sedtt",$element->charpos);
        }
        if ($element->getAttribute("runat") == "server") {
            $element->runat = true;
            // stop attributes to render as html tag
            $element->setAttributeDyna("runat");
            $element->setAttributeDyna("on-startrender");
            $element->setAttributeDyna("on-endrender");
            $compobj = $this->frontobj->getComponentSafe($element->getAttribute('id'));
            if($compobj == null){
                $this->makeEditable($element, $parentelement);
                $this->init_tags($element,$parentelement);
            }else{
                // comp created by another tag, only render by this tag
                $element->_setRefComp($compobj);
            }
        } else if ($element->tagName == "codebehind" && !$this->frontobj->blncodefront) {
//$element->getAttribute('path'] = $this->executePHPCode($element->getAttribute('path']);
//$element->getAttribute('path'] = str_replace("component/", "{$this->phppath}/component/", $element->getAttribute('path']);
//$element->getAttribute('path'] = str_replace("libpath/", "{$this->slibpath}/", $element->getAttribute('path']);
//$element->getAttribute('path'] = str_replace("apppath/", "{$apppath}/", $element->getAttribute('path']);
            $this->codebehind = pathinfo($this->frontobj->getFilePath());
            $this->frontobj->setAppname($this->codebehind['filename']);
            $frontfile = $apppath . "/fmodule/" . $this->codebehind['filename'] . '.php';
            includeOnce($frontfile);
            if ($element->getAttribute('use_sjs_file')!=""){
//$this->frontobj->sjspath = $this->codebehind['filename'].'.sjs';
                $sjspath = $apppath . "/sjs/" . $this->codebehind['filename'] . '.sjs';
                $this->frontobj->setSjspath($sjspath);
            }
            $this->frontobj->setWebapppath($frontfile);
            $this->frontobj->setBlncodebehind(true);
            $webapp = new $this->frontobj->appname($this->frontobj);
            $this->frontobj->setWebapp($webapp);
            $element->setOuterHTML("");
        }
        }catch(\Throwable $e){
            $er1 = array($e->getTrace(),$e->getFile(),$e->getLine(),$e->getMessage(),$e->getCode(),$e);
            $this->catchElementError($er1, $element);
        }catch(\Exception $e){
            $er1 = array($e->getTrace(),$e->getFile(),$e->getLine(),$e->getMessage(),$e->getCode(),$e);
            $this->catchElementError($er1, $element);
        }        

    }
    
    private function makeEditable($element,$parentelement){
        // fill raw attribute without any processing
        if($this->sphp_settings->blnEditMode){
        // ref comp not implemented yet
            $element->removeAttribute("data-sedtt");
            addHeaderJSFunctionCode("funsfront" . $this->frontobj->name, "t1".$element->getAttribute("id"),"sfront{$this->frontobj->name}['". $element->getAttribute("id") ."']={};sfront{$this->frontobj->name}['". $element->getAttribute("id") ."']['attr'] = " . json_encode($element->attributes) . ";");
            $element->setAttribute("data-sedt",$this->frontobj->name);
            $element->setAttribute("data-sedtt",$element->charpos);
            if(!$element->hasAttribute("tabindex")){
                $element->setAttribute("tabindex", "0");
            }
         }
    }
    
    private function init_tags($element,$parentelement) {
        try{
        $compobj = null;
        $pathempty = false;
        
        $strOut = '';
        $versionpath = "";
// set path Class Object if not set in html
        if ($element->getAttribute("path")=="") {
            $element->setAttribute("path", "");
        }
        if ($element->getAttribute('dtable')=="") {
            $element->setAttribute('dtable','');
        }
        if ($element->getAttribute('dfield')=="") {
            $element->setAttribute('dfield', '');
        }
        if ($element->getAttribute('id')=="") {
            if ($element->getAttribute('name')!="") {
                $element->setAttribute('id', $element->getAttribute('name'));
            } else {
                trigger_error("Invalid id of Component Tag " . $element->tagName, E_USER_ERROR);
            }
        }
        if ($element->getAttribute('path') == "") {
            $pathempty = true;
            switch (strtolower($element->tagName)) {
                case 'input': { 
                        if ($element->getAttribute('type')=="") { 
                            trigger_error("Attribute=Type is not Defined in Tag Component=" . $element->getAttribute('id') . " ", E_USER_ERROR);
                        }
                        switch (strtolower($element->getAttribute('type'))){
                            case 'text': {
                                    $element->setAttribute('path', "{$this->slibpath}/comp/html/TextField.php");
                                    $element->setAttribute('phpclass',"\\Sphp\\comp\\html\\TextField");
                                    break;
                                }
                            case 'password': {
                                    $element->setAttribute('path', "{$this->slibpath}/comp/html/TextField.php");
                                    $element->setAttribute('phpclass', "\\Sphp\\comp\\html\\TextField");
                                    break;
                                }
                            case 'hidden': {
                                    $element->setAttribute('path', "{$this->slibpath}/comp/html/TextField.php");
                                    $element->setAttribute('phpclass', "\\Sphp\\comp\\html\\TextField");
                                    break;
                                }
                            case 'submit': {
                                    $element->setAttribute('path', "{$this->slibpath}/comp/html/TextField.php");
                                    $element->setAttribute('phpclass', "\\Sphp\\comp\\html\\TextField");
                                    break;
                                }
                            case 'button': {
                                    $element->setAttribute('path', "{$this->slibpath}/comp/html/TextField.php");
                                    $element->setAttribute('phpclass', "\\Sphp\\comp\\html\\TextField");
                                    break;
                                }
                            case 'file': {
                                    $element->setAttribute('path', "{$this->slibpath}/comp/html/FileUploader.php");
                                    $element->setAttribute('phpclass', "\\Sphp\\comp\\html\\FileUploader");
                                    break;
                                }
                            case 'checkbox': {
                                    $element->setAttribute('path', "{$this->slibpath}/comp/html/CheckBox.php");
                                    $element->setAttribute('phpclass', "\\Sphp\\comp\\html\\CheckBox");
                                    break;
                                }
                            case 'radio': {
                                    $element->setAttribute('path', "{$this->slibpath}/comp/html/Radio.php");
                                    $element->setAttribute('phpclass', "\\Sphp\\comp\\html\\Radio");
                                    break;
                                }
                            case 'date': {
                                    $element->setAttribute('path', "{$this->slibpath}/comp/html/DateField.php");
                                    $element->setAttribute('phpclass', "\\Sphp\\comp\\html\\DateField");
                                    break;
                                }
                            case 'email': {
                                    $element->setAttribute('path', "{$this->slibpath}/comp/html/TextField.php");
                                    $element->setAttribute('phpclass', "\\Sphp\\comp\\html\\TextField");
                                    break;
                                }
                            case 'number': {
                                    $element->setAttribute('path', "{$this->slibpath}/comp/html/TextField.php");
                                    $element->setAttribute('phpclass', "\\Sphp\\comp\\html\\TextField");
                                    break;
                                }
                            default:{ 
                                $element->setAttribute('path', "{$this->slibpath}/comp/Tag.php");
                                $element->setAttribute('phpclass', "\\Sphp\\comp\\Tag");
                            }
                        }

                        break; // end input
                    }
                case 'select': {
                        $element->setAttribute('path', "{$this->slibpath}/comp/html/Select.php");
                        $element->setAttribute('phpclass', "\\Sphp\\comp\\html\\Select");
                        break;
                    }
                case 'alert': {
                        $element->setAttribute('path', "{$this->slibpath}/comp/html/DisplayError.php");
                        $element->setAttribute('phpclass', "\\Sphp\\comp\\html\\DisplayError");
                        break;
                    }
                case 'include': {
                        $element->setAttribute('path', "{$this->slibpath}/comp/html/IncludeFront.php");
                        $element->setAttribute('phpclass', "\\Sphp\\comp\\html\\IncludeFront");
                        break;
                    }
                case 'include_place': {
                        $element->setAttribute('path', "{$this->slibpath}/comp/html/IncludePlace.php");
                        $element->setAttribute('phpclass', "\\Sphp\\comp\\html\\IncludePlace");
                        break;
                    }
                case 'form': {
                        $element->setAttribute('path', "{$this->slibpath}/comp/html/HTMLForm.php");
                        $element->setAttribute('phpclass', "\\Sphp\\comp\\html\\HTMLForm");
                        break;
                    }
                case 'textarea': {
                        $element->setAttribute('path', "{$this->slibpath}/comp/html/TextArea.php");
                        $element->setAttribute('phpclass', "\\Sphp\\comp\\html\\TextArea");
                        break;
                    }
                case 'image': {
                        $element->setAttribute('path', "{$this->slibpath}/comp/html/Img.php");
                        $element->setAttribute('phpclass', "\\Sphp\\comp\\html\\Img");
                        break;
                    }
                case 'title': {
                        $element->setAttribute('path', "{$this->slibpath}/comp/html/Title.php");
                        $element->setAttribute('phpclass', "\\Sphp\\comp\\html\\Title");
                        break;
                    }
                case 'ajax': {
                        $element->setAttribute('path', "{$this->slibpath}/comp/ajax/Ajaxsenddata.php");
                        $element->setAttribute('phpclass', "\\Sphp\\comp\\ajax\\Ajaxsenddata");
                        break;
                    }
                case 'menubar': {
                        $element->setAttribute('path', "{$this->phppath}/component/menu/MenuBar.php");
                        break;
                    }
                case 'menu': {
                        $element->setAttribute('path', "{$this->phppath}/component/menu/Menu.php");
                        break;
                    }
                case 'menulink': {
                        $element->setAttribute('path', "{$this->phppath}/component/menu/MenuLink.php");
                        break;
                    }
                case 'menuitem': {
                        $element->setAttribute('path', "{$this->phppath}/component/menu/MenuItem.php");
                        break;
                    }
                default: {
                        $element->setAttribute('path', "{$this->slibpath}/comp/Tag.php");
                        $element->setAttribute('phpclass', "\\Sphp\\comp\\Tag");
                    }
            }
        } else { 
            $element->setAttribute('path', $this->resolvePathVar($element->getAttribute('path')));
        }
        $pathb = ""; 
// set php class name automatically
        $path = pathinfo($element->getAttribute('path')); 
        if($element->getAttribute("version") != ""){
            $versionpath = $element->getAttribute("version") . "/";
            $pathb = $path["dirname"] ."/" . $versionpath . $path["basename"];
            $element->setAttribute('path',$pathb);
            $element->removeAttribute('version');
        }
        if ($element->getAttribute('phpclass')=="") {
            $element->setAttribute('phpclass', $path['filename']);
        }
        //if(!$pathempty || !$this->sphp_settings->blnPreLibLoad){
            //echo $element->getAttribute('path');
        try{
            includeOnce($element->getAttribute('path'));
        }catch(\Throwable $e){
            $er1 = array($e->getTrace(),$e->getFile(),$e->getLine(),$e->getMessage(),$e->getCode(),$e);
            $this->catchElementError($er1, $element);
        }catch(\Exception $e){
            $er1 = array($e->getTrace(),$e->getFile(),$e->getLine(),$e->getMessage(),$e->getCode(),$e);
            $this->catchElementError($er1, $element);
        }    
        //}
        
        $comp = $element->getAttribute('id');
        if ($comp == "") {
            $strmsg = $element->tagName . " Should have valid id attribute or name and unique which is not use as name of any other global variable or object";
            trigger_error($strmsg, E_USER_ERROR);
        }else{
            $comp .= $this->frontobj->prefixName;
            $element->setAttribute('id',$comp);
        }
        $compobj = \SphpBase::sphp_api()->isComponent($comp);
        if ($this->debug->debugmode > 2) {
            $this->debug->setMsg('FrontFile:-' . $this->frontobj->filePath . ' :init: ' . $comp);
        }
        // global var exist then stop to overrite
        $blnOvrt = true;
        if(is_object($compobj)) { // != "null" 
        // same comp can over write 2 different front files but second one not will global
            //if ($this->debug->debugmode == 1) {
            //    $strmsg = "Tag Component=" . $element->tagName . " try to overwrite a variable=$comp, ! Front File". $this->frontobj->filePath . "/ = " . $compobj->getFrontobj()->filePath ." Component should a unique ID or name which could not use as name of any other global variable or object";
    //          trigger_error($strmsg, E_USER_ERROR);
            //    $this->debug->setMsg($strmsg);
            //}
            //throw new \Exception("$strmsg");
            $blnOvrt = false;
        }
        
            $phpclassname = $element->getAttribute('phpclass'); 
            $compobj = new $phpclassname($element->getAttribute('id'), $element->getAttribute('dfield'), $element->getAttribute('dtable'));
            $compobj->_setFrontobj($this->frontobj); 
            $this->frontobj->_setComponent($comp, $compobj);
            if($blnOvrt){
                \SphpBase::sphp_api()->addComponent($comp,$compobj);
                if(\SphpBase::sphp_settings()->blnGlobalApp) writeGlobal($comp,$compobj);
            }
            if($element->getAttribute('pathres')!="") {
                $compobj->myrespath = $this->executePHPCode($element->getAttribute('pathres'));
            }
            
        // set $element for parseMe function
        $compobj->element = $element;
        $element->_setComponent($compobj);
        $compobj->tagName = $element->tagName;
        $compobj->blnendtag = !$element->blnselfclose;
        if ($parentelement!=null && $parentelement->comp!=null) {
            $compobj->parentobj = $parentelement->comp;
            $parentelement->comp->_addChild($compobj);
        }


// set pre tag conversation
    if($this->sphp_settings->blnEditMode){
            $ar1 = array();
            $ar1["path"] = $compobj->cfilepath;
            $ar1["phpclass"] = $compobj->cfilename;
            $ar1["frontfile"] = $this->frontobj->filePath;
            $ar1["tagName"] = strtolower($element->tagName);
            $ar1["selfclosed"] = $element->isSelfClose();
            $ar1["charpos"] = $element->charpos;
            addHeaderJSFunctionCode("funsfront" . $this->frontobj->name, "t2".$element->getAttribute("id"),"sfront{$this->frontobj->name}['". $element->getAttribute('id') ."']['info'] = " .  json_encode($ar1) . ";");
    }
        $element->removeAttribute('phpclass');
        $element->removeAttribute('path');
        $element->removeAttribute('pathres');
        $element->removeAttribute('dtable');
        $element->removeAttribute('dfield'); 
        
        foreach ($element->getAttributes() as $keym=>$valm) { 
            $key = $keym;
            $val = $valm; 
            if (!$this->executePHPScriptCheck($key)) { 
                $key2 = substr($key, 0, 4);
                // $val convert expression code in val
                // no need for new seval
                //$val = $this->convertExpressionToPHP($val);
                if ($key2 == 'fun-') {
                    
                    if (! $this->executePHPScriptCheck($val)) {
                        // fun function found non dynamic content
                        $element->setAttributeDyna($keym,true);
                        $key = substr($key, 4); 
                        $this->executeFun($compobj, $key, $val);
                    }else{
                        $element->setAttributeDyna($keym);
                    }
//                } else if ($key2 == 'fup') {
//$compobj->setParameterAD($key,'p');
                } else if ($key2 == 'fui-') {
                    $element->setAttributeDyna($keym);
                    $key = substr($key, 4);
                    if($this->executePHPScriptCheck($val)){
                        $val = $this->executePHPScript($val,$compobj);
                    }
                    $this->executeFun($compobj, $key, $val,true);
                    // end of if, function found fur type quick execute php code in this
                } 
            } // end of if key has not a php script tag
        }// end of foreach
// set inbuilt event fro frontfile
// call init event before create event
        $compobj->_oncompinit($element);
        }catch(\Throwable $e){
            $er1 = array($e->getTrace(),$e->getFile(),$e->getLine(),$e->getMessage(),$e->getCode(),$e);
            $this->catchElementError($er1, $element);
        }catch(\Exception $e){
            $er1 = array($e->getTrace(),$e->getFile(),$e->getLine(),$e->getMessage(),$e->getCode(),$e);
            $this->catchElementError($er1, $element);
        }        
    }

    public function endupcomp($element,$parentelement) {
// call create event
        try{
        $this->curelement = $element;
            if(! $element->refcomptag){
            $compobj = $element->comp;
            if($compobj!= null){
                $compobj->_oncompcreate($element);
            //if(!$this->sphp_settings->blnEditMode){
                $element->removeAttribute('on-init');
                $element->removeAttribute('on-create');
            //}
            
            }
        }
        }catch(\Throwable $e){
            $er1 = array($e->getTrace(),$e->getFile(),$e->getLine(),$e->getMessage(),$e->getCode(),$e);
            $this->catchElementError($er1, $element);
        }catch(\Exception $e){
            $er1 = array($e->getTrace(),$e->getFile(),$e->getLine(),$e->getMessage(),$e->getCode(),$e);
            $this->catchElementError($er1, $element);
        }        

    }    
    
    public function startrender($element,$parentelement) {
        try{
        $this->curelement = $element;
        if ($element->runat) { 
        if($element->refcomptag){
            if($element->getAttribute("refcompchild") !== ""){
                // overwrite element from comp tag element
                $element->children = $element->comp->element->children;
                $element->comp->element = $element;
            }else{
                // share comp between more then one tags
                $element->comp->element = $element;
            }
        }

            $this->renderTags($element,$parentelement);
        }
        }catch(\Throwable $e){
            $er1 = array($e->getTrace(),$e->getFile(),$e->getLine(),$e->getMessage(),$e->getCode(),$e);
            $this->catchElementError($er1, $element);
        }catch(\Exception $e){
            $er1 = array($e->getTrace(),$e->getFile(),$e->getLine(),$e->getMessage(),$e->getCode(),$e);
            $this->catchElementError($er1, $element);
        }        
    }    
    public function endrender($element,$parentelement) {
        try{
        $this->curelement = $element;
        $strparsedata = "";
        if ($element->runat) { //print($element->tagName . " " . $element->getAttribute("id") . $element->getLineNo() ." <br>"); 
                $obj = $element->comp;
                if (is_object($obj)) {
//                    if ($this->debug->debugmode > 2) {
//                        $this->debug->setMsg('FrontFile:-' . $this->frontobj->filePath . ' :EndRender: ' . $obj->name);
//                   }
                    $obj->_render();
                    if($element->refcomptag){
                        // share comp between more then one tags, restore
                        $element->comp->element = $element->refcomptagelement;
                    }

                } else {
                    $strMsg = "Sartaj PHP Error:- While render Component Tag $element->tagName id=" . $element->getAttribute('id') . " is not object or over write its global variable with another value";
                    trigger_error($strMsg, E_USER_ERROR);
                }
        } else if ($element->tagName == 'code') {
            if ($element->getAttribute('type')=="php") {
                $element->setOuterHTML("#{ " . $element->getInnerHTML() . " }#");
            } else if ($element->getAttribute('type') == 'value') {
                $element->setOuterHTML("##{ " . $element->getInnerHTML() . " }#");
            }else{
                //$element->setOuterHTML($this->executePHPCode($element->getInnerHTML()));                
            }
        } else if ($element->getAttribute('runas')!="") { 
            $runas = $element->getAttribute('runas');
            if($runas != "holder"){            
                $element->removeAttribute('runas');
            }
            $renderonce = false;
            if ($element->getAttribute('renderonce')!="") {
                $renderonce = true;
            }
            if($runas == "holder"){
                if($element->getAttribute('data-comp') != ""){
                    if($element->getAttribute('data-prop') != ""){ 
                        $propn1 = $element->getAttribute('data-prop');
                        $element->setInnerHTML($this->frontobj->getComponent($element->getAttribute('data-comp'))->{$propn1});
                    }else{
                        $this->frontobj->getComponent($element->getAttribute('data-comp'))->_trigger_holder($element);                        
                    }
                }else{
                    // run on app
                    if($element->getAttribute('data-prop') != ""){  
                        $propn1 = $element->getAttribute('data-prop'); 
                        $element->setInnerHTML($this->frontobj->parentapp->{$propn1});
                    }else{
                        $this->frontobj->parentapp->_trigger_holder($element);                        
                    }
                    
                }
            }else if ($element->tagName == 'script') { 
                if ($element->getAttribute('id')=="") {
                    $element->setAttribute('id',$element->tagName . rand(1, 30000));
                }
                // think about this section may be delete on next updates
                  if($runas=="jsfunctioncode"){ 
                  addHeaderJSFunctionCode($element->getAttribute('function'),"sc".$element->getAttribute('id'),$this->executePHPCode($element->innertext), $renderonce);
                    $element->setOuterHTML("");
                  }else if($runas=="jsfunction"){
                  if($element->getAttribute('functionpara')==""){$element->setAttribute('functionpara', " "); }
                  addHeaderJSFunction($element->getAttribute('function'), "function ". $element->getAttribute('function')."(". $element->getAttribute('functionpara')."){" , "}", $renderonce);
                  addHeaderJSFunctionCode($element->getAttribute('function'),"sc".$element->getAttribute('id'),$this->executePHPCode($element->innertext), $renderonce);
                  }else if($runas=="jsfunctionbnd"){
                      $fun = $element->getAttribute('function');
                      if($fun == "") $fun = str_replace(['.','#'],"",$element->getAttribute('binder') ). "_" . $element->getAttribute('listenevent');
                  addHeaderJSFunctionCode('ready',"bnd".$element->getAttribute('id'),'jql("'.$element->getAttribute('binder').'").bind("'.$element->getAttribute('listenevent').'", function(event, ui) {'.$element->getAttribute('function').'("'.$element->getAttribute('listenevent').'",{obj: jql(event.target),evt: "'.$element->getAttribute('listenevent').'",event: event,ui: ui}); } );', $renderonce);
                  addHeaderJSFunction($fun, "function ". $fun."(event,evtargs){" , "}", $renderonce);
                  addHeaderJSFunctionCode($fun,"sc".$element->getAttribute('id'),$this->executePHPCode($element->innertext), $renderonce);
                  }else if($runas=="jsfunctionbnds"){
                  addHeaderJSFunctionCode('ready',"bnd".$element->getAttribute('id'),'jql("'.$element->getAttribute('binder').'").bind("'.$element->getAttribute('listenevent').'", function(event, ui) {'.$element->getAttribute('function').'("'.$element->getAttribute('listenevent').'",{obj: jql(event.target),evt: "'.$element->getAttribute('listenevent').'",event: event,ui: ui}); } );', $renderonce);
                  addHeaderJSFunction($element->getAttribute('function'), "function ". $element->getAttribute('function')."(event,evtargs){ var data = {}; data['event'] = event; data['evtargs'] = {obj: evtargs.obj.attr('id'),evt: event,event: '', ui: ''}; " , ' getURL("'.getEventURL('sphp',$element->getAttribute('handler')).'",data);}', $renderonce);
                  addHeaderJSFunctionCode($element->getAttribute('function'),"sc".$element->getAttribute('id'),$this->executePHPCode($element->innertext), $renderonce);
                  }else if($runas=="jscode"){
                  addHeaderJSCode("sc".$element->getAttribute('id'),$this->executePHPCode($element->innertext), $renderonce);
                  }else if ($runas == "filelink") {
                    addFileLink($this->resolvePathVar($element->getAttribute('src')), $renderonce, $element->getAttribute('id'), 'js');
                    $element->setOuterHTML("");
                }
                //$element->parentNode->removeChild($element);
                $element->innertext = "";
            } else if ($element->tagName == 'link') {
                if ($runas == "filelink") {
                    if ($element->getAttribute('id')=="") {
                        $element->setAttribute('id', $element->tagName . rand(1, 30000));
                    }
                    addFileLink($this->resolvePathVar($element->getAttribute('href')), $renderonce, $element->getAttribute('id'), 'css');
                }
            } else {
                    $element->setTagName($runas);
            }
        }
        // run code block
        if($element->hasAttribute("runcb")){
            if($this->sphpcodeblocks == null){
                include_once(\SphpBase::sphp_settings()->slib_path . "/comp/sphpcodeblock.php");
                $this->sphpcodeblocks = \SphpCodeBlock::getCodeBlocks();
            }
            // implement css block
            $lst1 = $element->getAttributesCat("sphp-cb-");
            foreach ($lst1 as $key => $value) {
                if($value != ""){
                    $this->applyCodeBlock($element, $key, $lst1, $value);
                }else{
                    $this->applyCodeBlock($element, $key, $lst1);                   
                }
            }
        }
        }catch(\Throwable $e){
            $er1 = array($e->getTrace(),$e->getFile(),$e->getLine(),$e->getMessage(),$e->getCode(),$e);
            $this->catchElementError($er1, $element);
        }catch(\Exception $e){
            $er1 = array($e->getTrace(),$e->getFile(),$e->getLine(),$e->getMessage(),$e->getCode(),$e);
            $this->catchElementError($er1, $element);
        }        
    }

    private function applyCodeBlock($element,$sphpcss,$lst1,$sphpparam=null) {
        $a1 = $this->sphpcodeblocks[$sphpcss];
        $ar1 = array();
        if($sphpparam !== null){
            $ar2 = explode(',|',$sphpparam);
            foreach ($ar2 as $key => $value) {
                if($value != ''){
                    $ar1[$key] = $value;
                    // resolve positional argument like arg0, arg1 etc.
                    $a1['class'] = str_replace('@arg' . $key, $value, $a1['class']);
                    $a1['pclass'] = str_replace('@arg' . $key, $value, $a1['pclass']);
                    $a1['pretag'] = str_replace('@arg' . $key, $value, $a1['pretag']);
                    $a1['posttag'] = str_replace('@arg' . $key, $value, $a1['posttag']);
                    $a1['innerpretag'] = str_replace('@arg' . $key, $value, $a1['innerpretag']);
                    $a1['innerposttag'] = str_replace('@arg' . $key, $value, $a1['innerposttag']);
                }
            }
        }

        // css class will not get args
//        if($a1['class'] !== '' && ! $element->hasAttributeValue("class",$a1['class'])){
            $element->appendAttribute("class",' '. $a1['class']);
//        }
        $p1 = $element->getParent();
        if($a1['pclass'] !== '' && ! $p1->hasAttributeValue("class",$a1['pclass'])){
            $p1->appendAttribute("class",' '. $a1['pclass']);
        }
        
        if($a1['pretag'] !== '') $element->appendPreTag($a1['pretag']);
        if($a1['posttag'] !== '') $element->appendPostTag($a1['posttag']);
        if($a1['innerpretag'] !== '') $element->appendInnerPreTag($a1['innerpretag']);
        if($a1['innerposttag'] !== '') $element->appendInnerPostTag($a1['innerposttag']);
        if($a1['callback'] !== null) $a1['callback']($element,$ar1,$lst1);
    }
    private function renderTags($element,$parentelement) {
        try{
        $compobj = $element->comp;
            if (is_object($compobj)) { 
                $comp = $element->comp->getName();
                // restore if more tag but one component
                if ($this->debug->debugmode > 2) {
                    $this->debug->setMsg('FrontFile:-' . $this->frontobj->filePath . ' :render: ' . $comp);
                }
        foreach ($element->getAttributes() as $keym=>$valm) {
                        $key = $keym;
                        $val2 = $valm;
                        $key2 = substr($key, 0, 4);
                        
                        //$val2 = $this->convertExpressionToPHP($val);
                        if ($key2 == 'fun-') {
                            if(!$element->isDynaAttrRun($keym)){
                                $key = substr($key, 4);
                                $val2 = $this->executePHPScript($val2,$compobj);
                                $this->executeFun($compobj, $key, $val2);
                            }
                        } else if ($key2 == 'fur-') {
                            $element->setAttributeDyna($keym);
                            $key = substr($key, 4);
                            if($this->executePHPScriptCheck($val2)){ 
                                $val2 = $this->executePHPScript($val2,$compobj); 
                            }
                            $this->executeFun($compobj, $key, $val2);
                        } else if ($val2 != ""){
                            if($this->executePHPScriptCheck($val2)){ 
                                //dynamic attribute resolve once, for loop use prefix fur or fun 
                                //$element->setAttributeDyna($keym);
                                $val2 = $this->executePHPScript($val2,$compobj);
                                $element->setAttribute($keym,$val2); 
                            }
                           
                        } 
                } // end of for each

                $compobj->_prerender();
            }
        }catch(\Throwable $e){
            $er1 = array($e->getTrace(),$e->getFile(),$e->getLine(),$e->getMessage(),$e->getCode(),$e);
            $this->catchElementError($er1, $element);
        }catch(\Exception $e){
            $er1 = array($e->getTrace(),$e->getFile(),$e->getLine(),$e->getMessage(),$e->getCode(),$e);
            $this->catchElementError($er1, $element);
        }        
    }


    private function executeFun($compobj, $key, $val, $fui=false) {
// experimental ban event handler from front file
        /*
          $key2 = substr($key, 0,4);
          if($key2=='_svt'){
          $val = substr($key, 5) . ",|$val";
          $key = "setEventHandler";
          }else if($key2=='_jvt'){
          $val = substr($key, 5) . ",|$val";
          $key = "setEventHandlerJS";
          }else if($key2=='_jls'){
          $val = substr($key, 5) . ",|$val";
          $key = "registerEventListnerJS";
          }
         */
        $prefix = "fu_";
        $names = "";
        if ($key[0]=="_") {
            $compobj->setAttribute(substr($key, 1),$val);
            return ;
        }else{
            $blnfound = false;
            if($fui){
                if (method_exists($compobj, 'fi_'. $key)){
                    $prefix = 'fi_'; //priority fi_ 
                    $blnfound = true;
                }else if (method_exists($compobj, 'fu_'. $key)){
                    $blnfound = true;                    
                }
            }else if(method_exists($compobj, 'fu_'. $key)){
                    $blnfound = true;                 
            }else if(method_exists($compobj, 'fi_'. $key)){
                $class_info = new \ReflectionClass($compobj);
                $lines = $this->dhtmldom->htmlparser->countLines($compobj->element->charpos) + 1;
                trigger_error(" Error in FrontFile ". $compobj->getFrontobj()->filePath . " :FrontFile Line: ". $lines  . " :Object: " . $compobj->getName() 
                        . " :Type: " . $class_info->name . " : Fusion Method: ". $key ." :Source File: " . $class_info->getFileName() . 
                        " :Tag Name: " . $compobj->tagName . " :Try to call FI Fusion Methods with wrong Fusion Attribute, use fui-$key", E_USER_ERROR);
                return;
            }
            
            if (!$blnfound){ // add prefix fu_ or fi_
            $class_info = new \ReflectionClass($compobj);
            $sphp_api = \SphpBase::sphp_api();
            $ar = $sphp_api->rtClassMethod($class_info);
            foreach ($ar as $key2 => $val2) {
                $funnm = $val2->getName();
                if(substr($funnm, 0, 3) == $prefix){
                    $funnm = str_replace($prefix,'',$funnm);
                    $names .= $funnm . ", ";
                }
            } 
            $lines = $this->dhtmldom->htmlparser->countLines($compobj->element->charpos) + 1;
            //$compobj->element->getLineNo()
            trigger_error(" Error in FrontFile ". $compobj->getFrontobj()->filePath . " :FrontFile Line: ". $lines  . " :Object: " . $compobj->getName() . " :Type: " . $class_info->name . " :Undefined Method: ". $key ." :Source File: " . $class_info->getFileName() . " :Tag Name: " . $compobj->tagName . " :List of $prefix Fusion Methods Available in Class: ". $names , E_USER_ERROR);
            return;
            }
        } 
        
            try{
                // add prefix for fusion attribute binding
                $key = $prefix . $key;
            if (strpos($val, ",|") > 0) {
                $vala1 = explode(',|', $val);
                switch (count($vala1)) {
                    case 2: {
                            $compobj->$key($vala1[0], $vala1[1]);
                            break;
                        }
                    case 3: {
                            $compobj->$key($vala1[0], $vala1[1], $vala1[2]);
                            break;
                        }
                    case 4: {
                            $compobj->$key($vala1[0], $vala1[1], $vala1[2], $vala1[3]);
                            break;
                        }
                    case 5: {
                            $compobj->$key($vala1[0], $vala1[1], $vala1[2], $vala1[3], $vala1[4]);
                            break;
                        }
                    case 6: {
                            $compobj->$key($vala1[0], $vala1[1], $vala1[2], $vala1[3], $vala1[4], $vala1[5]);
                            break;
                        }
                    case 7: {
                            $compobj->$key($vala1[0], $vala1[1], $vala1[2], $vala1[3], $vala1[4], $vala1[5], $vala1[6]);
                            break;
                        }
                    case 8: {
                            $compobj->$key($vala1[0], $vala1[1], $vala1[2], $vala1[3], $vala1[4], $vala1[5], $vala1[6], $vala1[7]);
                            break;
                        }
                    case 9: {
                            $compobj->$key($vala1[0], $vala1[1], $vala1[2], $vala1[3], $vala1[4], $vala1[5], $vala1[6], $vala1[7], $vala1[8]);
                            break;
                        }
                    case 10: {
                            $compobj->$key($vala1[0], $vala1[1], $vala1[2], $vala1[3], $vala1[4], $vala1[5], $vala1[6], $vala1[7], $vala1[9]);
                            break;
                        }
                }
            } else {
                $compobj->$key($val);
            }
        }catch(\Throwable $e){
            $er1 = array($e->getTrace(),$e->getFile(),$e->getLine(),$e->getMessage(),$e->getCode(),$e);
            $this->catchElementError($er1, $compobj->element);
        }catch(\Exception $e){
            $er1 = array($e->getTrace(),$e->getFile(),$e->getLine(),$e->getMessage(),$e->getCode(),$e);
            $this->catchElementError($er1, $compobj->element);
        }        

       
        
    }

    private function executePHPScript($strPHPScript,$compobj) {
//        $strPHPScript = str_replace("%20"," ",$strPHPScript);
//        return executePHPScript($strPHPScript);
        if (strpos($strPHPScript, "#{") !== false) {
            return $this->executePHPCode($strPHPScript,$compobj);
        } else {
            return $strPHPScript;
        }

    }

    private function executePHPScriptCheck($strPHPScript) {
        // php tag not allowed
        if (strpos($strPHPScript, "#{") !== false) {
            return true;
        } else {
            return false;
        }
    }

    private function convertExpressionToPHP($val) {
        $val = str_replace('##{', '<?php echo ', $val);
        $val = str_replace('#{', '<?php ', $val);
        $val = str_replace('}#', ' ?>', $val);
        $val = str_replace("-#","->",$val);
        return $val;
    }

    private function convertPHPToExpression($val) {
        $val = str_replace(array('<?php echo ','<?php ',' ?>'),array('##{','#{','}#'), $val);
        return $val;
    }
    
    private function catchElementError($er1,$element) {
        //$er1 = array($e->getTrace(),$e->getFile(),$e->getLine(),$e->getMessage(),$e->getCode());
        if($this->debug->debugmode == 2){
            \SphpBase::debug()->cur_front_file = $this->frontobj->getFilePath();
        } 
        $f1 = "";
        if($element->getComponent() != null){
            $f1 = $element->getComponent()->cfilepath;
        }
        $e2 = new \Sphp\core\Exception($er1[3] . ' Error in Element:- ' . $element->tagName . '#' . $element->getAttribute("id") . ' Comp file:- ' . $f1 . ' ',$er1[4],$er1[5]);
        $lines = $this->dhtmldom->htmlparser->countLines($element->charpos) + 1;
        $e2->setLineNumber($lines);
        $e2->setFilePath($this->frontobj->getFilePath());
        \SphpBase::debug()->Sphp_exception_handler($e2);
    }
    
    private function catchException($er1,$strPHPCode="",$compobj = null){
        //$er1 = array($e->getTrace(),$e->getFile(),$e->getLine(),$e->getMessage(),$e->getCode());
        if($this->debug->debugmode > 2){
            \SphpBase::debug()->cur_front_file = $this->frontobj->getFilePath();
        }
        $lines = array();
        $linenum = 1;
        $errfirst = current($er1[0]);
        //print_r($er1[0]);
        //echo $er1[1];
        //by default error file
        $errfile = $this->frontobj->getFilePath();
        // if error in Component attribute php code
        if($compobj !== null){ 
            $strf = $this->convertExpressionToPHP($this->dhtmldom->getDoc());
            $lines = explode(PHP_EOL,$strf); 
            $linenum = \SphpBase::sphp_api()->find_line_number($strf,$strPHPCode);
            if(strpos($er1[1], 'HTMLParser.php') !== false){
                $strmsg1 = $er1[3] .  ' Error in Component:- ' . $compobj->getName();                  
            }else{
                $strmsg1 = $er1[3] .  ' Error in Component:- ' . $compobj->getName() ." File:- " . $er1[1] .' on line:- '. $er1[2];  
            }
        // if error in eval code  
        }else if(strpos($errfirst["file"], "eval()'d code") !== false){ 
            $lines = explode(PHP_EOL,$strPHPCode);
            $linenum = $er1[2];
            $strmsg1 = $er1[3] ." File:- " . $errfile .' on line:- '. $errfirst["line"]; 
            $errfile = $er1[1];
            $strmsg1 .= " near line:- " . htmlentities($lines[$errfirst["line"] - 1]);
        }else if(strpos($er1[1], "eval()'d code") !== false){ 
            $lines = explode(PHP_EOL,$strPHPCode);
            $linenum = $er1[2];
            $strmsg1 = $er1[3] ." File:- " . $errfile .' on line:- '. $linenum; 
            $errfile = $er1[1];
            $strmsg1 .= " near line:- " . htmlentities($lines[$linenum - 1]);
        }else if(strpos($er1[1], 'HTMLParser.php') !== false){
            $strf = $this->convertExpressionToPHP($this->dhtmldom->getDoc());
            $lines = explode(PHP_EOL,$strf); 
            $linenum = \SphpBase::sphp_api()->find_line_number($strf,$strPHPCode);
            $strmsg1 = $er1[3] ." File:- " . $er1[1] .' on line:- '. $er1[2]; 
        }else{
            $lines = explode(PHP_EOL,$strPHPCode);
            $linenum = $er1[2];
            $strmsg1 = $er1[3] ." File:- " . $er1[1] .' on line:- '. $er1[2]; 
            $errfile = $er1[1];
        }
        
        //$strmsg1 .= $e->getTraceAsString();
        $strmsg1 = str_replace(__FILE__, '', $strmsg1);
        $strmsg1 = str_replace( 'eval()\'d', 'error', $strmsg1); 
        $e2 = new \Sphp\core\Exception($strmsg1,$er1[4],$er1[5],$linenum,$errfile);
        //$e2->setLineNumber($linenum);
       // $e2->setFilePath($errfile);
        \SphpBase::debug()->Sphp_exception_handler($e2);

    }
    public function resolvePathVar($val){
        $val = $this->executePHPCode($val);
        $val = str_replace("components/", "{$this->phppath}/components/", $val);
        $val = str_replace("slibpath/", "{$this->slibpath}/", $val);
        $val = str_replace("slibrespath/", $this->sphp_settings->slib_res_path . "/", $val);
        $val = str_replace("phppath/", $this->sphp_settings->php_path . "/", $val);
        $val = str_replace("respath/", $this->sphp_settings->res_path . "/", $val);
        $val = str_replace("mypath/", "{$this->frontobj->mypath}/", $val);
        $val = str_replace("myrespath/", "{$this->frontobj->myrespath}/", $val);
        return $val;
    }
    /**
     * Execute PHP code in Limited Container. Use only Template Tags ##{ }# or #{ }#
     * @param string $strPHPCode PHP Template code
     * @param \Sphp\tools\Component $compobj default null, Show debug information if Component
     * run code
     * @return string
     */
    public function executePHPCode($strPHPCode,$compobj=null) { 
        if($this->frontobj->intPHPLevel > 1){
            // in future this will remove
            return $this->executePHPCodeA($strPHPCode, $compobj);            
        }else if($this->frontobj->intPHPLevel > 0){
            // default
            if($compobj != null) $this->seval1->setVariable('$compobj', $compobj);
            return $this->executePHPCodeB($strPHPCode, $compobj);
        }
    }
    private function executePHPCodeB($strPHPCode,$compobj=null) { 
        try{ 
            return $this->seval1->process($strPHPCode);
        }catch(\Sphp\core\Exception $e){
            if($this->curlineno < 1) $this->curlineno = $e->getLineNumber();
            $er1 = array($e->getTrace(),$this->frontobj->getFilePath(),$this->curlineno,$e->getMessage() ,$e->getCode(),$e);
            $this->catchException($er1,$strPHPCode,$compobj);
            //trigger_error($e->getMessage());
        }

    }
    private function executePHPCodeA($strPHPCode,$compobj=null) { 
        $frontobj = $this->frontobj;
        $parentapp = $this->frontobj->parentapp;
        $metadata = $this->frontobj->metadata;
        $blnp = false;
        if($this->frontobj->intPHPLevel == 3){
            extract($GLOBALS, EXTR_REFS);
            $blnp = true;
        }else{
            // not working it is over writing variables
            //$strPHPCode2 = '<?php $_SERVER = array(); $GLOBAL = array(); >'; 
        }
        switch($this->frontobj->intPHPLevel){
            case 2: {
                $blnp = true;                
                break;
            }case 1: {
                if($compobj != null) $blnp = true;
                break;
            }
        }
        
        if($blnp){
        try{ 
            $strPHPCode = $this->convertExpressionToPHP($strPHPCode);
        ob_start(); 
        eval('?>' . $strPHPCode);
        $result = ob_get_contents();
        ob_end_clean();        
        return($result);
    }catch(\Throwable $e){
        $er1 = array($e->getTrace(),$e->getFile(),$e->getLine(),$e->getMessage() ,$e->getCode(),$e);
        $this->catchException($er1,$strPHPCode,$compobj);
    }catch(\Exception $e){
        $er1 = array($e->getTrace(),$e->getFile(),$e->getLine(),$e->getMessage() ,$e->getCode(),$e);
        $this->catchException($er1,$strPHPCode,$compobj);
        //trigger_error($e->getMessage());
    }
    
    }else{
        return $strPHPCode;
    }
    }

}


}
