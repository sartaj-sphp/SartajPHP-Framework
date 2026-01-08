<?php
namespace Sphp\tools{
/**
 * Description of SphpApp
 *
 * @author Sartaj Singh
 */

class SphpApp {
    private $frontFiles = array();
    
    public function _registerFront($frontobj) {
        array_push($this->frontFiles,$frontobj);
    }
    protected function _triggerAppEvent() {
        foreach ($this->frontFiles as $key => $tobj) {
            $tobj->_onAppEvent();
        }
    }
    public function startQuickResponse() {
        // for same session start parallel processing
        \SphpBase::sphp_session()->closeSession();
    }
    public function createFrontFile($filepath,$prefix="") {
        return new FrontFile($filepath,false,null, $this, false, $prefix);
    }

    protected function _fixCompEventHandlers($frontobj) {
        $class_info = new \ReflectionClass($this);
        $ar = \SphpBase::sphp_api()->rtClassMethod($class_info);
        foreach ($ar as $key => $val) {
            $name = explode('_', $val->getName());
            if ($name[0] == 'comp') {
                $handler = "comp_event_" . $name[2] . "_" . $name[3];
                $obj = $frontobj->getComponent($name[2]);
                $obj->setEventHandler($name[3], $handler, $this);
            }
        }
    }

    public function setServerSentEvent($eventurl) {
        addHeaderJSFunction("sphpeventfun", ' function sphpeventfun(event){', '}');
        addHeaderJSFunctionCode("ready",'sphpapp1', ' if(typeof(EventSource) !== "undefined") { var esource = new EventSource("'. $eventurl .'");
        esource.onmessage = function(event) {
            sphpeventfun(event);
        };} ');
    }
    public function createWebWorker($jsfunname,$jsfileurl) {
        addHeaderJSFunction($jsfunname, ' function '. $jsfunname .'(event){', '}');
        addHeaderJSFunctionCode("ready",$jsfunname . '1', ' if(typeof(Worker) !== "undefined") { var '. $jsfunname .'w1 = new Worker("'. $jsfileurl .'");
        '. $jsfunname .'w1.onmessage = function(event) {
            '. $jsfunname .'(event);
        };} ');
    }
    protected function _genSJSCode($eventname, $ajaxname) {
        $jq = new \Sphp\kit\jq();
        //$compList = $this->frontform[1]->compList;

        $class_info = new \ReflectionClass($this);
        $ar = \SphpBase::sphp_api()->rtClassMethod($class_info);
        foreach ($ar as $key => $val) {
            $name = explode('_', $val->getName());
            if ($name[0] == 'js') {
                $jq->jsstate = 'sphp';
                $jsfun = "ofjs_" . $name[2] . "_" . $name[3];
//$compList[$name[1]]->setParameterA('on'.$name[2],$jsfun."();");
                addHeaderJSFunctionCode('ready', $jsfun, ' jql("#' . $name[2] . '").on("' . $name[3] . '", function(event, ui) {' . $jsfun . '({obj: jql(event.target),evt: "' . $name[3] . '",event: event,ui: ui}); } );');
$jsfuncode = "";
$jsfuncode .= " function ". $jsfun ."(eventer){ ";
$jsfuncode .= " var data = {}; ";
$jsfuncode .= " data['eventer'] = {obj: eventer.obj.attr('id'),evt: eventer.evt,event: '', ui: ''}; ";
$jsfuncode .= " var dataType = 'json'; ";
$jsfuncode .= " var cache = false; ";
$jsendcode = " sartajgt('$ajaxname','" . getEventURL($eventname, $val->name) . "',data,cache,dataType); } ";
                addHeaderJSFunction($jsfun, $jsfuncode,$jsendcode );
            } // end if event
        }
    }

}


}
