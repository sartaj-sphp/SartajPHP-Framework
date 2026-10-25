<?php
namespace Sphp\tools {
/**
* Description of CompGate
* CompGate is used to handle Gate Events for ComponentGroup class. So we can create complex UI with 
* Component and which handle its own PageEvents on Server Side. CompGate is child Gate of Component 
* and it is run and execute by ComponentGroup Class and not with GateLoader.
* CompGate File name use *.cgate.php post fix and inside Sub Folder CompGates of ComponentGroup
* Class Folder. It doesn't handle page_new and page_submit events. You can use Child Front files *.child.front with this 
* Type of Gate Class. It is worked as Child Gate of Component and no need registration. It can only handle Component 
* base PageEvents when Registered Gate Class create Front File Object in LifeCycle Event handler like onstart.
* @author Sartaj Singh
*/
class CompGate extends Gate {
/** @var \Sphp\tools\Front $parentFrontObj **/
public $parentFrontObj = null;
/** @var \Sphp\tools\Component $parentComponent **/
public $parentComponent = null;
/** @var \Sphp\tools\Gate $parentgate **/
public $parentgate = null;
public $nameprefix = "";
protected function call_page_events() {}
/**
* Set Internal Front File. Internal Front File Also render Page Components.
* @param FrontFile $obj 
*/
/**
* CompGate Life Cycle Event
* override this event handler in your Child Gate to handle it.
* trigger when ComponentGroup pre render trigger
*/
public function onprerender() {}
public function getReturnData() {}
}
}
