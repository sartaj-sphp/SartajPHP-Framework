<?php

namespace Sphp\tools{

/**
 * Description of HTMLParser
 *
 * @author SARTAJ
 */
// no use of this file, only experiment
class HTMLParser2 {

    private $callbackfunc = "";
    public $parsefirst = 'tagsToObject';
    public $parserender = 'convert_tags';
    public $curelement = null;
    public $curlineno = 0;
    public $codebehind = array();
    public $blncodebehind = false;
    public $frontobj;

    public function __construct() {
        $sphp_settings = getSphpSettings();
        if ($sphp_settings->run_mode_not_extension) {
            $libpath = $sphp_settings->php_path . "/sphp/";
            includeOnce($libpath . "/tools/HTMLDOMNode.php");
            includeOnce($libpath . "/tools/HTMLDOM.php");
        }
    }
    public function getFrontobj() {
        return $this->frontobj;
    }

    public function setFrontobj($frontobj) {
        $this->frontobj = $frontobj;
    }

    public function init() {
        /*
        $this->parsefirst = function($element) {
            $this->tagsToObject($element);
        };
        $this->parserender = function($element) {
            $this->convert_tags($element);
        };
         * 
         */
        $this->parsefirst = new HTMLParserInit($this);
        $this->parserender = new HTMLParserRender($this);
    }
    public function setCodebehind($codebehind) {
        $this->codebehind = $codebehind;
    }

        // helper functions
    // -----------------------------------------------------------------------------
    // get html dom form file
    public function file_get_html($filepath) {
        $dom = new HTMLDOM();
        $dom->load(file_get_contents($filepath), true);
        return $dom;
    }

    // get html dom form string
    public function str_get_html($str, $lowercase = true) {
        $dom = new HTMLDOM();
        $dom->load($str, $lowercase);
        return $dom;
    }

    // dump html dom tree
    public function dump_html_tree($node, $show_attr = true, $deep = 0) {
        $lead = str_repeat('    ', $deep);
        echo $lead . $node->tag;
        if ($show_attr && count($node->attr) > 0) {
            echo '(';
            foreach ($node->attr as $k => $v)
                echo "[$k]=>\"" . $node->$k . '", ';
            echo ')';
        }
        echo "\n";

        foreach ($node->nodes as $c)
            $this->dump_html_tree($c, $show_attr, $deep + 1);
    }

    // get dom form file (deprecated)
    public function file_get_dom($filepath) {
        $dom = new HTMLDOM();
        $dom->load(file_get_contents($filepath), true);
        return $dom;
    }

    // get dom form string (deprecated)
    public function str_get_dom($str, $lowercase = true) {
        $dom = new HTMLDOM();
        $dom->load($str, $lowercase);
        return $dom;
    }

    public function parseHTMLFile($url) {
        $HTMLParser = new HTMLDOM();
        $content = $HTMLParser->load_file_str($url);
//$content = $this->executePHPCode($content);
        $HTMLParser->load($content);
        $content = "";
// Register the callback function with it's function name
        $HTMLParser->set_callback($this->parserender, $this);
        $output = $HTMLParser->save();
        $output = $this->executePHPCode($output);
        return $output;
    }

    public function getHTMLFile($url) {
        $HTMLParser = new HTMLDOM();
        $content = $HTMLParser->load_file_str($url);
        return $content;
    }

    public function parseHTML($strData) {
        $HTMLParser2 = new HTMLDOM();
//$strData = $this->executePHPCode($strData);
        $HTMLParser2->load($strData);
// Register the callback function with it's function name
        $HTMLParser2->set_callback($this->parserender, $this);
        $strData = $HTMLParser2->save();
        $strData = $this->executePHPCode($strData);
//return $output;
        return $strData;
    }

    public function parsefeed($element) {
        call_user_func($this->callbackfunc, $element);
    }

    public function parseHTMLTagFun($strData, $callbackfun) {
        $this->callbackfunc = $callbackfun;
        $HTMLParser = new HTMLDOM();
        $HTMLParser->load($strData);
        $HTMLParser->set_callback('parsefeed', $this);
        $strData = $HTMLParser->save();
        return $strData;
    }

    public function parseHTMLTag($strData, $callbackfun, $obj) {
        $HTMLParser = new HTMLDOM();
        $HTMLParser->load($strData);
        $HTMLParser->set_callback($callbackfun, $obj);
        $strData = $HTMLParser->save();
//$strData = $this->executePHPCode($strData);
        return $strData;
    }

    public function parseHTMLObj($strData, $obj) {
        $HTMLParser3 = new HTMLDOM();
        $this->frontobj = $obj;
//$strData2 = $this->executePHPCode($strData);
        $HTMLParser3->load($strData);
// Register the callback function with it's function name
        $HTMLParser3->set_callback($this->parsefirst, $this);
        $output = $HTMLParser3->save();
        return $output;
    }

    private function parseHTMLD($strData) {
        $HTMLParser4 = new HTMLDOM();
        $HTMLParser4->load($strData);
// Register the callback function with it's function name
        $HTMLParser4->set_callback($this->parserender, $this);
        $output = $HTMLParser4->save();
        return $output;
    }

    public function tagsToObject($element) {
//global $phppath,$apppath;
        extract(getGlobals(), EXTR_REFS);
        $apppath = readGlobal("apppath");
        $this->curelement = $element;
        if (isset($element->attr['runat']) && $element->attr['runat'] == 'server') {
            $this->init_tags($element);
        } else if ($element->tag == 'codebehind' && !$this->frontobj->blncodefront) {
//$element->attr['path'] = $this->executePHPCode($element->attr['path']);
//$element->attr['path'] = str_replace("component/", "{$phppath}/component/", $element->attr['path']);
//$element->attr['path'] = str_replace("libpath/", "{$phppath}/sphp/", $element->attr['path']);
//$element->attr['path'] = str_replace("apppath/", "{$apppath}/", $element->attr['path']);
            $this->codebehind = pathinfo($this->frontobj->getFilePath());
            $this->frontobj->setAppname($this->codebehind['filename']);
            $frontfile = $apppath . "/fmodule/" . $this->codebehind['filename'] . '.php';
            includeOnce($frontfile);
            if (isset($element->attr['use_sjs_file'])) {
//$this->frontobj->sjspath = $this->codebehind['filename'].'.sjs';
                $sjspath = $apppath . "/sjs/" . $this->codebehind['filename'] . '.sjs';
                $this->frontobj->setSjspath($sjspath);
            }
            $this->frontobj->setWebapppath($frontfile);
            $this->frontobj->setBlncodebehind(true);
            $webapp = new $this->frontobj->appname($this->frontobj);
            $this->frontobj->setWebapp($webapp);
            $element->outertext = "";
        }
    }

    public function convert_tags($element) {
        $this->curelement = $element;
        if (isset($element->attr['runat']) && $element->attr['runat'] == 'server') {
            if ($element->tag == 'form') {
                $obj = $this->renderTags($element);
// set $element for parseMe function
                $obj->element = $element;
                $obj->prerender();
// clear $element object
                $obj->element = null;
                $element->innertext = $this->parseHTMLD($element->innertext);
                $obj->setInnerHTML($element->innertext);
                $element->outertext = $obj->render();
            } else {
                $obj = $this->renderTags($element);
                if (is_object($obj)) {
// set $element for parseMe function
                    $obj->element = $element;
                    $obj->prerender();
// clear $element object
                    $element = $obj->element;
                    $obj->element = null;
                    $obj->setInnerHTML($element->innertext);
                    $element->outertext = $obj->render();
                } else {
                    $strMsg = "Sartaj PHP Error:- While render Component Tag $element->tag id=" . $element->attr['id'] . " is not object or over write its global variable with another value";
                    trigger_error($strMsg, E_USER_ERROR);
                }
            }
        } else if ($element->tag == 'code') {
            if (!isset($element->attr['type'])) {
                $element->outertext = $this->executePHPCode($element->innertext);
            } else if ($element->attr['type'] == 'php') {
                $element->outertext = "<?php " . $element->innertext . " ?>";
            } else if ($element->attr['type'] == 'value') {
                $element->outertext = "<?php echo " . $element->innertext . "; ?>";
            }
        } else if (isset($element->attr['runas'])) {
            $renderonce = false;
            if (isset($element->attr['renderonce'])) {
                $renderonce = true;
            }
            if ($element->tag == 'script') {
                if (!isset($element->attr['id'])) {
                    $element->attr['id'] = $element->tag . rand(1, 30000);
                }
                /*
                  if($element->attr['runas']=="jsfunctioncode"){
                  addHeaderJSFunctionCode($element->attr['function'],"sc".$element->attr['id'],$this->executePHPCode($element->innertext), $renderonce);
                  }else if($element->attr['runas']=="jsfunction"){
                  if(!isset($element->attr['functionpara'])){$element->attr['functionpara'] = ""; }
                  addHeaderJSFunction($element->attr['function'], "function ". $element->attr['function']."(". $element->attr['functionpara']."){" , "}", $renderonce);
                  addHeaderJSFunctionCode($element->attr['function'],"sc".$element->attr['id'],$this->executePHPCode($element->innertext), $renderonce);
                  }else if($element->attr['runas']=="jsfunctionbnd"){
                  addHeaderJSFunctionCode('ready',"bnd".$element->attr['id'],'$("'.$element->attr['binder'].'").bind("'.$element->attr['listenevent'].'", function(event, ui) {'.$element->attr['function'].'("'.$element->attr['listenevent'].'",{obj: $(event.target),evt: "'.$element->attr['listenevent'].'",event: event,ui: ui}); } );', $renderonce);
                  addHeaderJSFunction($element->attr['function'], "function ". $element->attr['function']."(event,evtargs){" , "}", $renderonce);
                  addHeaderJSFunctionCode($element->attr['function'],"sc".$element->attr['id'],$this->executePHPCode($element->innertext), $renderonce);
                  }else if($element->attr['runas']=="jsfunctionbnds"){
                  addHeaderJSFunctionCode('ready',"bnd".$element->attr['id'],'$("'.$element->attr['binder'].'").bind("'.$element->attr['listenevent'].'", function(event, ui) {'.$element->attr['function'].'("'.$element->attr['listenevent'].'",{obj: $(event.target),evt: "'.$element->attr['listenevent'].'",event: event,ui: ui}); } );', $renderonce);
                  addHeaderJSFunction($element->attr['function'], "function ". $element->attr['function']."(event,evtargs){ var data = {}; data['event'] = event; data['evtargs'] = {obj: evtargs.obj.attr('id'),evt: event,event: '', ui: ''}; " , ' getURL("'.getEventURL('sphp',$element->attr['handler']).'",data);}', $renderonce);
                  addHeaderJSFunctionCode($element->attr['function'],"sc".$element->attr['id'],$this->executePHPCode($element->innertext), $renderonce);
                  }else if($element->attr['runas']=="jscode"){
                  addHeaderJSCode("sc".$element->attr['id'],$this->executePHPCode($element->innertext), $renderonce);
                  }else
                 * 
                 */
                if ($element->attr['runas'] == "filelink") {
                    addFileLink($element->attr['src'], $renderonce, $element->attr['id'], 'js');
                }
                $element->outertext = "";
            } else if ($element->tag == 'link') {
                if ($element->attr['runas'] == "filelink") {
                    if (!isset($element->attr['id'])) {
                        $element->attr['id'] = $element->tag . rand(1, 30000);
                    }
                    addFileLink($this->executePHPCode($element->attr['href']), $renderonce, $element->attr['id'], 'css');
                }
            } else {
                switch ($element->attr['runas']) {
                    case "if": {
                            $element->outertext = "<?php if(" . $element->attr['expression'] . ") { ?>" . $element->innertext . " <?php } ?>";
                            break;
                        }
                    default : {
                            $element->tag = $element->attr['runas'];
                            break;
                        }
                }
                unset($element->attr['runas']);
            }
        }
    }

    private function renderTags($element) {
        $phppath = readPhpPath();
        $respath = readResPath();
        $sphp_settings = getSphpSettings(); 
        $comppath = $sphp_settings->comp_path ;
        $libpath = $sphp_settings->lib_path ;
        $debug = getDebug();
        $compobj = null;
        
        if (isset($element->attr['id'])) {
            $comp = $element->attr['id'];
        } else {
            $comp = "";
        }
        if ($comp == "") {
            $element->attr['id'] = $element->attr['name'];
            $comp = $element->attr['id'];
        }
        if ($comp != "") {
            $compobj = readGlobal($comp);
            if ($debug->debugmode) {
                $debug->setMsg('FrontFile:-' . $this->frontobj->filePath . ' :render: ' . $comp);
            }
            if (is_object($compobj)) {
// set pre tag conversation
                $element->attr['parentobj'] = 'n$';
                $element->attr['phpclass'] = 'n$';
                $element->attr['path'] = 'n$';
                $element->attr['pathres'] = 'n$';
                $element->attr['runat'] = 'n$';
                $element->attr['dtable'] = 'n$';
                $element->attr['dfield'] = 'n$';
                $element->attr['on-init'] = 'n$';
                $element->attr['on-create'] = 'n$';
                $element->attr['on-startrender'] = 'n$';
                $element->attr['on-endrender'] = 'n$';
                foreach ($element->attr as $key => $val) {
                    if (!isset($compobj->parameterAD[$key]) && $val != 'n$') {
                        $key2 = substr($key, 0, 3);
                        $val2 = $element->attr[$key];
                        $val2 = $this->convertExpressionToPHP($val2);
                        if ($key2 == 'fun') {
                            $key = substr($key, 3);
                            $val2 = $this->executePHPScript($val2);
                            $this->executeFun($comp, $key, $val2);
                        } else if ($key2 == 'fup') {
                            $key = substr($key, 3);
                            $val2 = $this->executePHPScript($val2);
                            $this->executeFun($comp, $key, $val2);
                        } else if ($val2 != "") {
                            $val2 = $this->executePHPScript($val2);
                            $compobj->setParameterA($key, $val2);
                        }
                    }
                } // end of for each

                return $compobj;
            }
        }
    }

    private function init_tags($element) {
        $phppath = readPhpPath();
        $respath = readResPath();
        $sphp_settings = getSphpSettings(); 
        $comppath = $sphp_settings->comp_path ;
        $libpath = $sphp_settings->lib_path ;
        $compobj = null;
        $debug = getDebug();

        $eattr = $element->attr;
        $strOut = '';
// set path Class Object if not set in html
        if (!isset($element->attr['path'])) {
            $element->attr['path'] = '';
        }
        if (!isset($element->attr['dtable'])) {
            $element->attr['dtable'] = '';
        }
        if (!isset($element->attr['dfield'])) {
            $element->attr['dfield'] = '';
        }
        if (!isset($element->attr['id'])) {
            if (isset($element->attr['name'])) {
                $element->attr['id'] = $element->attr['name'];
            } else {
                trigger_error("Invalid id of Component Tag " . $element->tag, E_USER_ERROR);
            }
        }
        if ($element->attr['path'] == "") {
            switch (strtolower($element->tag)) {
                case 'input': {
                        if (!isset($element->attr['type'])) {
                            trigger_error("Attribute=Type is not Defined in Tag Component=" . $element->attr['id'] . " ", E_USER_ERROR);
                        }
                        switch (strtolower($element->attr['type'])) {
                            case 'text': {
                                    $element->attr['path'] = "{$phppath}/sphp/comp/html/TextField.php";
                                    $element->attr['phpclass'] = "\\Sphp\\comp\\html\\TextField";
                                    break;
                                }
                            case 'password': {
                                    $element->attr['path'] = "{$phppath}/sphp/comp/html/TextField.php";
                                    $element->attr['phpclass'] = "\\Sphp\\comp\\html\\TextField";
                                    break;
                                }
                            case 'hidden': {
                                    $element->attr['path'] = "{$phppath}/sphp/comp/html/TextField.php";
                                    $element->attr['phpclass'] = "\\Sphp\\comp\\html\\TextField";
                                    break;
                                }
                            case 'submit': {
                                    $element->attr['path'] = "{$phppath}/sphp/comp/html/TextField.php";
                                    $element->attr['phpclass'] = "\\Sphp\\comp\\html\\TextField";
                                    break;
                                }
                            case 'button': {
                                    $element->attr['path'] = "{$phppath}/sphp/comp/html/TextField.php";
                                    $element->attr['phpclass'] = "\\Sphp\\comp\\html\\TextField";
                                    break;
                                }
                            case 'file': {
                                    $element->attr['path'] = "{$phppath}/sphp/comp/html/FileUploader.php";
                                    $element->attr['phpclass'] = "\\Sphp\\comp\\html\\FileUploader";
                                    break;
                                }
                            case 'checkbox': {
                                    $element->attr['path'] = "{$phppath}/sphp/comp/html/CheckBox.php";
                                    $element->attr['phpclass'] = "\\Sphp\\comp\\html\\CheckBox";
                                    break;
                                }
                            case 'radio': {
                                    $element->attr['path'] = "{$phppath}/sphp/comp/html/Radio.php";
                                    $element->attr['phpclass'] = "\\Sphp\\comp\\html\\Radio";
                                    break;
                                }
                            case 'date': {
                                    $element->attr['path'] = "{$phppath}/sphp/comp/html/DateField.php";
                                    $element->attr['phpclass'] = "\\Sphp\\comp\\html\\DateField";
                                    break;
                                }
                            default:{ 
                                $element->attr['path'] = "{$phppath}/sphp/comp/Tag.php";
                                $element->attr['phpclass'] = "\\Sphp\\comp\\Tag";
                            }
                        }

                        break; // end input
                    }
                case 'select': {
                        $element->attr['path'] = "{$phppath}/sphp/comp/html/Select.php";
                        $element->attr['phpclass'] = "\\Sphp\\comp\\html\\Select";
                        break;
                    }
                case 'form': {
                        $element->attr['path'] = "{$phppath}/sphp/comp/html/HTMLForm.php";
                        $element->attr['phpclass'] = "\\Sphp\\comp\\html\\HTMLForm";
                        break;
                    }
                case 'textarea': {
                        $element->attr['path'] = "{$phppath}/sphp/comp/html/TextArea.php";
                        $element->attr['phpclass'] = "\\Sphp\\comp\\html\\TextArea";
                        break;
                    }
                case 'image': {
                        $element->attr['path'] = "{$phppath}/sphp/comp/html/Image.php";
                        $element->attr['phpclass'] = "\\Sphp\\comp\\html\\Image";
                        break;
                    }
                case 'ajax': {
                        $element->attr['path'] = "{$phppath}/sphp/comp/ajax/Ajaxsenddata.php";
                        $element->attr['phpclass'] = "\\Sphp\\comp\\ajax\\Ajaxsenddata";
                        break;
                    }
                case 'menubar': {
                        $element->attr['path'] = "{$phppath}/component/menu/MenuBar.php";
                        break;
                    }
                case 'menu': {
                        $element->attr['path'] = "{$phppath}/component/menu/Menu.php";
                        break;
                    }
                case 'menulink': {
                        $element->attr['path'] = "{$phppath}/component/menu/MenuLink.php";
                        break;
                    }
                case 'menuitem': {
                        $element->attr['path'] = "{$phppath}/component/menu/MenuItem.php";
                        break;
                    }
                default: {
                        $element->attr['path'] = "{$phppath}/sphp/comp/Tag.php";
                        $element->attr['phpclass'] = "\\Sphp\\comp\\Tag";
                    }
            }
        } else {
            $element->attr['path'] = $this->executePHPCode($element->attr['path']);
            $element->attr['path'] = str_replace("component/", "{$phppath}/component/", $element->attr['path']);
            $element->attr['path'] = str_replace("libpath/", "{$phppath}/sphp/", $element->attr['path']);
        }

// set php class name automatically
        $path = pathinfo($element->attr['path']); 
        if (! isset($element->attr['phpclass'])) {
            $element->attr['phpclass'] = $path['filename'];
        }
        includeOnce($element->attr['path']);
        $comp = $element->attr['id'];
        if ($comp == "") {
            $comp = $element->attr['id'];
        }
        if ($comp == "") {
            $strmsg = $element->tag . " Should have valid id attribute or name and unique which is not use as name of any other global variable or object";
            trigger_error($strmsg, E_USER_ERROR);
        }
        $compobj = readGlobal($comp);
        if ($debug->debugmode) {
            $debug->setMsg('FrontFile:-' . $this->frontobj->filePath . ' :init: ' . $comp);
        }
        if(is_object($compobj) === false) {
            if($compobj!="null") {
                $strmsg = "Tag Component=" . $element->tag . " try to overwrite a variable=$comp, Component should a unique ID or name which could not use as name of any other global variable or object";
                trigger_error($strmsg, E_USER_ERROR);
            } else {
                $phpclassname = $element->attr['phpclass']; 
                $compobj = new $phpclassname($element->attr['id'], $element->attr['dfield'], $element->attr['dtable']);
                $compobj->setFrontobj($this->frontobj);
                $this->frontobj->setComponent($comp, $compobj);
                writeGlobal($comp,$compobj);
                if(isset($element->attr['pathres'])) {
                    $compobj->myrespath = $element->attr['pathres'];
                }
            }
        }
        $compobj->tagName = $element->tag;
        if (isset($element->attr['parentobj'])) {
            $parentobjtxt = $element->attr['parentobj'];
            $parentobj = readGlobal($parentobjtxt);
            if (is_object($parentobj)) {
                $compobj->parentobj = $parentobj;
            } else {
                $strmsg = "Tag Component=" . $element->attr['id'] . " try to call a parent object=". $parentobjtxt .", Which is not available. ";
                trigger_error($strmsg, E_USER_ERROR);
            }
        }

// set inbuilt event fro frontfile
// call init event before create event
        $compobj->oncompinit($element);

// set pre tag conversation
        $element->attr['parentobj'] = 'n$';
        $element->attr['phpclass'] = 'n$';
        $element->attr['path'] = 'n$';
        $element->attr['pathres'] = 'n$';
        $element->attr['runat'] = 'n$';
        $element->attr['dtable'] = 'n$';
        $element->attr['dfield'] = 'n$';
        $element->attr['on-init'] = 'n$';
        $element->attr['on-create'] = 'n$';
        $element->attr['on-startrender'] = 'n$';
        $element->attr['on-endrender'] = 'n$';

        foreach ($element->attr as $key => $val) {
            if (!$this->executePHPScriptCheck($key) && $val != 'n$') {
                $key2 = substr($key, 0, 3);
// $val convert expression code in val
                $val = $this->convertExpressionToPHP($val);
                if ($key2 == 'fun') {
                    if (!$this->executePHPScriptCheck($val)) {
                        $keyf = $key;
                        $key = substr($key, 3);
                        $this->executeFun($comp, $key, $val);
                        $compobj->setParameterAD($keyf, '');
                    } // end of if function found non dynamic content
//                } else if ($key2 == 'fup') {
//$compobj->setParameterAD($key,'p');
                } else if ($key2 == 'fur') {
                    $keyf = $key;
                    $key = substr($key, 3);
                    $val = $this->executePHPScript($val);
                    $this->executeFun($comp, $key, $val);
                    $compobj->setParameterAD($keyf, '');
                    // end of if, function found fur type quick execute php code in this
                } else if ($val != "") {
                    if (!$this->executePHPScriptCheck($val)) {
                        $compobj->setParameterA($key, $val);
                        $compobj->setParameterAD($key, '');
                    }
                }
            } // end of if key has not a php script tag
        }// end of foreach
// set $element for parseMe function
        $compobj->element = $element;
// call create event
        $compobj->oncompcreate($element);
// clear element object
        $compobj->element = null;
        $element->attr = $eattr;
    }

    public function executeFun($comp, $key, $val) {
        $compobj = null;
        $names = "";
        $compobj = readGlobal($comp);
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
        if (!method_exists($compobj, $key)) {
            $class_info = new \ReflectionClass($compobj);
            $sphp_api = \SphpBase::sphp_api();
            $ar = $sphp_api->getClassMethod($compobj);
            foreach ($ar as $key2 => $val2) {
                $names .= $val2->getName() . ", ";
            }
            trigger_error(" Error in Object: " . $compobj->name . ":Type: " . $class_info->name . " :Undefined Method: ". $key ." :Source File: " . $class_info->getFileName() . " :Tag Name: " . $compobj->tagName . " :List of Methods Available in Class: ". $names, E_USER_ERROR);
        } else {
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
        } // method is not found
    }

    private function executePHPScript($strPHPScript) {
        return executePHPScript($strPHPScript);
    }

    private function executePHPScriptCheck($strPHPScript) {
        if (strpos($strPHPScript, "?php") > 0) {
            return true;
        } else {
            return false;
        }
    }

    private function convertExpressionToPHP($val) {
        $val = str_replace('##{', '<?php echo ', $val);
        $val = str_replace('#{', '<?php ', $val);
        $val = str_replace('}#', '; ?>', $val);
        return $val;
    }

    public function executePHPCode($strPHPCode) {
        return executePHPCode($strPHPCode);
    }

}
}

