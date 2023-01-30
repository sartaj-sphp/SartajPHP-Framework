<?php
namespace Sphp\tools{
/**
* Description of AngularApp
*
* @author Sartaj Singh
*/
include_once($libpath . "/lib/DIR.php");
include_once($libpath . "/lib/HtmlMinifier.php");
class MobileHomeApp extends ComboApp{
public function __construct(){}
public function render(){}
}
class MobilePageApp extends MobileHomeApp{
public function page_event_loadpagefull($evtp){}
public function page_event_loadpage($evtp){}
public function render(){}
}
}
