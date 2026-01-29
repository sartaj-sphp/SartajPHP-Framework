<?php

$frtMain = new \Sphp\tools\FrontFile(__DIR__ . "/fronts/error_msg.front");

if(SphpBase::page()->getEvent() == 'page'){
    frtMain->getComponent("spnmsg")->setInnerHTML("HTML Error " . SphpBase::page()->getEventParameter());
}

$frtMain->processMe();
SphpBase::$dynData = $frtMain;
global $masterf;
include_once("$masterf");
