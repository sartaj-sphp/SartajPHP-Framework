<?php
namespace Sphp\tools{
    // psjs javascript object
/**
 * Description of Psjs
 *
 * @author Sartaj Singh
 */

    class Psjs {

    public $strdata = "";
    public $strlen = -1;
    public $file_arr = array();

    public function __construct($filepath) {
        $this->strdata = file_get_contents($filepath);
        $this->strlen = strlen($this->strdata);
        $this->file_arr = $this->parseJavascript();
        $this->strdata = "";
    }

    public function parseJavascript() {
        $global = array();
        $result = array();
        $fun = array();
        $pos = -1;
        for ($i = 0; $i < $this->strlen; $i++) {
            // findout function keyword
            $pos = strpos($this->strdata, "function", $i);
            $pos2 = strpos($this->strdata, "(", $i);
            if ($pos !== false && $pos2 !== false) {
                // findout function name
                $fun['name'] = trim(substr($this->strdata, $pos + 8, $pos2 - $pos - 8));
                $pos = $pos2;
                $pos3 = $this->parseJavascriptBlock($pos, "(", ")");
                $fun['para'] = trim(substr($this->strdata, $pos + 1, $pos3[1] - $pos - 1));
                $pos = $pos3[1];
                $pos3 = $this->parseJavascriptBlock($pos, "{", "}");
                if ($pos3[0] > 0) {
                    $fun['body'] = substr($this->strdata, $pos3[0] + 1, $pos3[1] - $pos3[0] - 1);
                    $result[] = $fun;
                    $i = $pos3[1];
                } else {
                    break;
                }
            } else {
                break;
            }
        }
        return $result;
    }

    public function parseJavascriptBlock($start, $find_start, $find_end) {
        $count = -1;
        $st = 0;
        for ($i = $start; $i < $this->strlen; $i++) {
            if ($this->strdata[$i] == $find_start) {
                if ($count == -1) {
                    $st = $i;
                    $count = 1;
                } else {
                    $count += 1;
                }
            }
            if ($this->strdata[$i] == $find_end) {
                $count -= 1;
            }
            if ($count == 0) {
                break;
            }
        }
        return array($st, $i);
    }

    public function fixCompEventHandlers($frontobj) {
        foreach ($this->file_arr as $key => $val) {
            $name = explode('_', $val['name']);
            $jsevt = $name[0];
            if ($jsevt == 'comp') {
                $handler = "comp_" . $name[1] . "_" . $name[2];
                $obj = $frontobj->getComponent($name[1]);
                $obj->setEventHandlerJS($name[2], $handler);
            }
        }
    }

    public function processSJSEvent() {
        $JSServer = \SphpBase::JSServer();
        foreach ($this->file_arr as $key => $val) {
            $name = explode('_', $val['name']);
            $jsevt = $name[0];
            if ($val['name'] == \SphpBase::page()->evtp) {
                $jsfun = $name[0] . "_" . $name[1] . "_" . $name[2];
                $JSServer->getJSON();
                if ($jsevt == 'onjs') {
                    $this->processSJSFunction("on", $jsfun, $val);
                } // jevt only server side javascript process method without any tag event binding
                else if ($jsevt == 'jevt') {
                    $this->processSJSFunction("jevt", $jsfun, $val);
                }
                break;
            }
        }
    }

    public function processSJSFunction($jsstate, $jsfunname, $obj_method) {
        $JSServer = \SphpBase::JSServer();
        addHeaderJSFunction($jsfunname, " function ". $jsfunname ."(" . $obj_method['para'] . "){ ", " " . $obj_method['body'] . " } ");
//$this->convertPhpToJs($this->getMethodSource($obj_method, $class_file),$jsfunname);
        $JSServer->addJSONJSBlock(" ". $jsfunname ."();");
    }

    public function sendJs($fun, $jsfun, $funtype = false) {
        addHeaderJSFunctionCode($jsfun, "", $fun['body'], $funtype);
    }

    public function addJSFunction($jsfun) {
        if (!isHeaderJSFunctionExist($jsfun)) {
            addHeaderJSFunction($jsfun, " function ". $jsfun ."(eventer){ ", " } ");
        }
    }

    public function genSJSCode($eventname, $ajaxname) {
        $jq = new \Sphp\kit\jq();
        $frontnull = "";
//$compList = $this->frontform[1]->compList;

        foreach ($this->file_arr as $key => $val) {
            $name = explode('_', $val['name']);
//$jsevt = substr($name[1], 0, 4);
            $jsevt = $name[0];
            if($jsevt == 'ofjs'){
                $jq->jsstate = 'of';
                $jsfun = $name[0] . "_" . $name[1] . "_" . $name[2];
                if ($name[2] == 'drag' || $name[2] == 'dragstart' || $name[2] == 'dragstop') {
$strcode = " $('#" . $name[1] . "').draggable({ " ; 
$strcode .= " appendTo: \"body\",helper: 'clone', " ;
$strcode .= " start: function(event, ui) { var rt = jq_drag({obj: $(event.target),evt: \"dragstart\",event: event,ui: ui}); return rt;}, ";
$strcode .= " drag: function(event, ui) { var rt = jq_drag({obj: $(event.target),evt: \"drag\",event: event,ui: ui}); return rt;}, ";
$strcode .= " stop: function(event, ui) { var rt = jq_drag({obj: $(event.target),evt: \"dragstop\",event: event,ui: ui}); return rt;}, ";
$strcode .= " cancel: null });" ;
                    addHeaderJSFunctionCode('ready', $name[1] . '_drag', $strcode );
$strfuncode = " if(eventer.obj.attr('id')=='". $name[1] ."' && eventer.evt == '". $name[2] ."'){ ";
$strfuncode .= " " . $jsfun . "(eventer); }";
                    addHeaderJSFunctionCode('jq_drag', $jsfun, $strfuncode , true); 
                }elseif($name[2] == 'drop') {
$strcode = " $('#" . $name[1] . "').droppable({ "; 
$strcode .= " activeClass: \"ui-state-active\", ";
$strcode .= " hoverClass: \"ui-state-hover\", ";
$strcode .= " drop: function( event, ui ) { ";
$strcode .= " $(this).addClass( \"ui-state-highlight\" ); "; 
$strcode .= " setTimeout(function(){ " ;
$strcode .= " $('#" . $name[1] . "').removeClass( \"ui-state-highlight\" ); "; 
$strcode .= " },800); ";
$strcode .= " var rt = jq_drop({obj: $(this),evt: 'drop',event: event,ui: ui}); return rt; ";
$strcode .= " } });" ;
                    addHeaderJSFunctionCode('ready', $name[1] . '_drop',$strcode);
$strfuncode = " if(eventer.obj.attr('id')=='". $name[1] ."' && eventer.evt == '". $name[2] ."'){ ";
$strfuncode .= " " . $jsfun . "(eventer); }";
                    addHeaderJSFunctionCode("jq_drop", $jsfun, $strfuncode, true);
                }elseif($name[2] == "resize") {
$strcode = " $('#" . $name[1] . "').resizable({ "; 
$strcode .= " resize: function( event, ui ) { ";
$strcode .= " var rt = jq_resize({obj: $(this),evt: 'resize',event: event,ui: ui}); return rt; ";
$strcode .= " }});";
                    addHeaderJSFunctionCode("ready", $name[1] . '_resize', $strcode);
$strfuncode = " if(eventer.obj.attr('id')=='". $name[1] ."' && eventer.evt == '". $name[2] ."'){ " ;
$strfuncode .= " " . $jsfun . "(eventer); }" ;
                    addHeaderJSFunctionCode('jq_resize', $jsfun, $strfuncode , true);
                }elseif($name[2] == 'keyup' || $name[2] == 'keydown' || $name[2] == 'keypress') {
$strcode = " $('#" . $name[1] . "').". $name[2] ."(function( event, ui ) { ";
$strcode .= " var rt = jq_keyevent({obj: $(this),evt: '" . $name[2] . "',event: event,ui: ui}); return rt; } );" ;
                    addHeaderJSFunctionCode('ready', $jsfun, $strcode);
$strfuncode = " if(eventer.obj.attr('id')=='". $name[1] ."' && eventer.evt == '". $name[2] ."'){ ";
$strfuncode .= " ret2 = " . $jsfun . "(eventer2); ";
$strfuncode .= " if(ret2==false){ ";
$strfuncode .= " ret = ret2; } }";
                    addHeaderJSFunctionCode('jq_keyevent', $jsfun, $strfuncode , true);
                }else{
   // bind any event to any id of tag
$strcode = " $('#" . $name[1] . "').on('" . $name[2] . "',function(event, ui) { ";
$strcode .= " var rt = ". $jsfun ."({obj: $(event.target),evt: \"" . $name[2] . "\",event: event,ui: ui}); return rt;});" ;
    if(isset($name[3])){
        $funin1 = "";
        for($c1=3;$c1<count($name);$c1++){
            if($funin1 != "") $funin1 .= '_';
            $funin1 .= $name[$c1];        
        }
        addHeaderJSFunctionCode($funin1, $jsfun, $strcode);        
    }else{
        addHeaderJSFunctionCode('ready', $jsfun, $strcode);        
    }
                }
                $this->addJSFunction($jsfun);
//$JQuery->setJSFunctionName($jsfun);
//$val->invoke($this);
//$JSServer->convertPhpToJs($JSServer->getMethodSource($val, $fl),$jsfun);
                $this->sendJs($val, $jsfun);
            }elseif($jsevt == 'comp'){
                $jsfun = $name[0] . "_" . $name[1] . "_" . $name[2];
                $this->addJSFunction($jsfun);
                $this->sendJs($val, $jsfun);
            }elseif($jsevt == 'onjs') {
                $jq->jsstate = 'on';
                $jsfun = "ofjs_" . $name[1] . "_" . $name[2];
//$compList[$name[1]]->setParameterA('on'.$name[2],$jsfun."();");
                addHeaderJSFunctionCode('ready', $jsfun, ' $("#' . $name[1] . '").on("' . $name[2] . '", function(event, ui) {' . $jsfun . '({obj: $(event.target),evt: "' . $name[2] . '",event: event,ui: ui}); } );');
$strcode = " function ". $jsfun ."(eventer){ ";
$strcode .= " var data = {}; ";
//data['eventer'] = {obj: eventer.obj.attr('id'),evt: eventer.evt,event: '', ui: ''};
$strcode .= " var dataType = 'json'; ";
$strcode .= " var cache = false; "; 
$strfuncode = " sartajgt('$ajaxname','" . getEventURL($eventname, $val['name']) . "',data,cache,dataType); }";
                addHeaderJSFunction($jsfun, $strcode,$strfuncode);
//$compList[$name[1]]->setParameterA("on".$name[2],"sartajgt('".getEventURL($val->name)."','$name[0]=' + $(this).val(),true);");
            }elseif($name[0] == 'jq'){
                $jq->jsstate = 'jq';
                if(isset($name[1])) {
                    $jsevt = $name[1];
                }else{
                    $jsevt = 'global';
                }
                if ($jsevt == 'ready') {
                    $this->sendJs($val, "ready");
                }elseif($jsevt == 'pageload') {
                    $this->sendJs($val, 'pageload', true);
                }elseif($jsevt == 'event' || $jsevt == 'drag' || $jsevt == 'drop' || $jsevt == 'focus' || $jsevt == 'keyevent') {
                    if(isset($name[2])){ 
                        $this->sendJs($val, "jq_" .$jsevt,true);   
                    }else{
                        $this->sendJs($val, "jq_" . $jsevt);
                    }
                }elseif($jsevt == 'global') {
                    addHeaderJSFunction('jq_global', " /* global code start here */ ", " /* global code end here */ ");
//$JQuery->setJSFunctionName('jq_global');
//$JSServer->convertPhpToJs($JSServer->getMethodSource($val, $fl),'jq_'.$jsevt);
                    $this->sendJs($val, 'jq_' . $jsevt);
                }elseif($jsevt == 'jevt' || $jsevt == 'sevt') {
                    $frontnull = "null";
                }else{
                    if(isset($name[2])){
                        $jsfun = $name[0] . "_" . $name[1] . "_" . $name[2];
                    }else{
                        $jsfun = $name[0] . "_" . $name[1];
                    }
                    if(isHeaderJSFunctionExist($jsfun) === false) {
                        addHeaderJSFunction($jsfun, " function ". $jsfun ."(" . $val['para'] . "){ ", " } ");
                    }
//$JQuery->setJSFunctionName($jsfun);
//$JSServer->convertPhpToJs($JSServer->getMethodSource($val, $fl),$jsfun);
                    $this->sendJs($val, $jsfun);
                }
            } // end if event
        }
    }

}

}