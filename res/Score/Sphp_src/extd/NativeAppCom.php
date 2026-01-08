<?php
namespace Sphp\tools{
/**
 * Experimental:- 
 * NativeAppCom work as console app load by child process of different languages like dot net
 *
 * @author Sartaj Singh
 */

class NativeAppCom {
private $auth = "GUEST";
private $tblName = "";
/** @var \Sphp\kit\Page page */
public $page = "";
/** @var FrontFile frontform */
public $apppath = "";
public $phppath = "";
public $respath = "";
/** @var \Sphp\kit\JSServer JSServer */
public $JSServer = null;
/** @var \Sphp\kit\Request Client */
public $Client = null;
/** @var \Sphp\kit\MySQL dbEngine */
public $dbEngine = null;
/** @var \Sphp\core\DebugProfiler debug */
public $debug = null;
public $Form = null;
public $protocolJ = null;


public function __construct(){
    $this->page = \SphpBase::page();
    $this->JSServer = \SphpBase::JSServer();
    $this->Client =  \SphpBase::sphp_request();
    $this->apppath = \SphpBase::page()->apppath;
    $this->phppath = \SphpBase::sphp_settings()->php_path;
    $this->respath = \SphpBase::sphp_settings()->res_path;
    $this->dbEngine = \SphpBase::dbEngine();
    $this->debug = \SphpBase::debug();
    $this->protocolJ = new ProtocolJ();
    $this->onstart();
    if($this->Form !== null){
        $this->Form->initalize();
    }
    $this->initalize();
}
public function setForm($param) {
    $this->Form = $param;
}
public function processEvent(){
    $this->call_page_events();    
}
private function call_page_events(){
//    global $dynData,$page,$respath,$phppath;
   extract(getGlobals(),EXTR_REFS);
if($this->page->isevent){
    $fun = "page_event_{$this->page->sact}";
    if(method_exists($this, $fun)){
    $this->{$fun}($this->page->evtp);
    }
}else if($this->page->isnew){
    $this->page_new();
}else if($this->page->isdelete){
    $this->page_delete();
}else if($this->page->isview){
    $this->page_view();
}else if($this->page->issubmit){
    $this->page_submit();
    if($this->page->isinsert){
    $this->page_insert();
    }else if($this->page->isupdate){
    $this->page_update();
    }
}
// render form
$this->render();

    
}

public function setTableName($dbtable){
    \SphpBase::page()->tblName = $dbtable;
    $this->tblName = $dbtable;
}
    public function getTableName(){
        return $this->tblName;
    }


public function onstart(){}
public function initalize() {}
public function onready(){}
public function page_delete(){}
public function page_view(){}
public function page_submit(){}
public function page_insert(){}
public function page_update(){}
public function page_new(){}
public function getEvent(){return $this->page->sact;}
public function getEventParameter(){return $this->page->evtp;}

public function onrun(){}
public function onrender(){}

public function run(){
    $this->onready();
    $this->onrun();
    $this->processEvent();
}
public function render(){
    $this->onrender();
    if($this->Form !== null){
        $this->Form->run();
    }
}

public function getAuthenticate($authenticates){
    $this->auth = $authenticates;
    $this->page->Authenticate($authenticates);
}
public function getSesSecurity(){
$this->page->sesSecure();
}

}

class ProtocolJ {
    public $JSServer;
    
    public function __construct() {
        $this->JSServer = \SphpBase::JSServer();
    }

    public function createValueType($type,$subtype,$value) {
        $val = array();
        switch ($type) {
            case 'TYPE': // value pass covert to permitive type and return
                $val["SUBTYPE"] = $subtype; // INT, CHAR
                $val["VALUE"] = $value;
                break;
            case 'PROP': // create instance of subtype object and return static property
                $val["SUBTYPE"] = $subtype; // System.Drawing.Color
                $val["VALUE"] = $value;
                break;
            case 'OPROP': // return property of object name in subtype and return property as in value
                $val["SUBTYPE"] = $subtype; // btn1
                $val["VALUE"] = $value; // Text
                break;
            case 'EPROP': // return property of event function arg parameter object
                $val["SUBTYPE"] = $subtype; 
                $val["VALUE"] = $value;
                break;
            case 'CONSTRUCT': // return new instance of object with constructor input as value
                $val["SUBTYPE"] = $subtype; // System.Drawing.Point(10, 55)
                $val["VALUE"] = $value;
                break;
        }
        return array($type,$val);
    }
    
    public function createEvent($url,$evtargtype,$args) {
        return array($url,$evtargtype,$args);
    }
    public function createEventArgs($arg,$type,$subtype,$value) {
        return array($arg,$this->createValueType($type,$subtype,$value));
    }
    
    public function createObject($name,$objclass,$parentobj=null,$props = array()) {
        // create object on only new event
        if(\SphpBase::page()->isnew){
        $data = array();
        $data["objid"] = $name;
        $data["objclass"] = $objclass;
        if($parentobj!=null){
        $data["objparentid"] = $parentobj->name;
        $data["objparentclass"] = $parentobj->objclass;
        }else{
        $data["objparentid"] = "Form1"; 
        }
        /*
        $props = array();
        $props[] = array("Text",$this->protocolJ->createValueType("TYPE","STRING","check1"));
        //$props[] = array("BackColor","System.Drawing.Color:Gray");
        //$props[] = array("Location","System.Drawing.Point,10, 55");
        $props[] = array("BackColor",$this->protocolJ->createValueType("PROP","System.Drawing.Color","Red"));
        $props[] = array("Location",$this->protocolJ->createValueType("CONSTRUCT","System.Drawing.Point",array($this->protocolJ->createValueType("TYPE","INT",100), $this->protocolJ->createValueType("TYPE","INT",150))));
         * *
         */
        $data["props"] = $props;
        $this->JSServer->addJSONIpcBlock("create",$data);
        }
    }
    public function setProps($name,$props=array()) {
        $data = array();
        $data["objid"] = $name;
        $data["props"] = $props;
        $this->JSServer->addJSONIpcBlock("setprop",$data);
        
    }
    public function setEvts($name,$evts=array()) {
        $data = array();
        $data["objid"] = $name;
        $data["evts"] = $evts;
        $this->JSServer->addJSONIpcBlock("setevts",$data);
        
    }
}

}
