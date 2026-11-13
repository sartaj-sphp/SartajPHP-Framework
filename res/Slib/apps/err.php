<?php

$frtMain = new \Sphp\Tools\FrontFile(__DIR__ . "/fronts/error_msg.front");

if(SphpBase::page()->getEvent() == 'page'){
    frtMain->getComponent("spnmsg")->setInnerHtml("HTML Error " . SphpBase::page()->getEventParameter());
}

$frtMain->processMe();
SphpBase::$dynData = $frtMain;
include_once(readGlobal("masterf"));
