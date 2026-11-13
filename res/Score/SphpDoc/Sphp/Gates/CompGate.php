<?php
namespace Sphp\Gates {
/**
* Description of CompGate
* CompGate is used to handle Gate Events for ComponentGroup class. So we can create complex UI with 
* Component and which handle its own PageEvents on Server Side. CompGate is child Gate of Component 
* and it is run and execute by ComponentGroup Class and not with GateLoader.
* CompGate File name use *.cgate.php post fix and inside Sub Folder CompGates of ComponentGroup
* Class Folder. It doesn't handle page_new and page_submit events. You can use Child Front files *.child.front with this 
* Type of Gate Class. It is worked as Child Gate of Component and no need of registration in reg.php file. It can only handle Component 
* based PageEvents when Registered Gate Class create Front File Object in LifeCycle Event handler like onstart. It can't register Event
*  for ComponentGroup but it can trigger Event of Component and ComponentGroup class.
* @author Sartaj Singh
*/
class CompGate extends \Sphp\Tools\Gate {
/** @var \Sphp\Gates\Front $parentFrontObj **/
public $parentFrontObj = null;
/** @var \Sphp\Gates\Component $parentComponent **/
public $parentComponent = null;
/** @var \Sphp\Gates\Gate $parentGate **/
public $parentGate = null;
public $nameprefix = "";
/**
* Constructor, initialize parent front object and component, then start Gate.
* @param \Sphp\Gates\Front &$pfrontobj Parent Front Object
* @param \Sphp\Gates\Component &$compobj Parent Component Object
*/
/**
* Call Page Events of Gate based on request type.
*/
protected function callPageEvents() {}
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
/**
* Get Return Data from Front File render.
* @return string
*/
public function getReturnData() {}
}
}
