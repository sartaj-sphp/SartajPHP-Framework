<?php
namespace Sphp\tools{
/**
* Description of AngularApp
*
* @author Sartaj Singh
*/
include_once(\SphpBase::sphp_settings()->lib_path . "/lib/DIR.php");
include_once(\SphpBase::sphp_settings()->lib_path . "/lib/HtmlMinifier.php");
class MobileHomeApp extends ComboApp{
public function render(){}
}
class MobilePageApp extends MobileHomeApp{
public function page_event_loadpagefull($evtp){}
public function page_event_loadpage($evtp){}
public function render(){}
}
}
