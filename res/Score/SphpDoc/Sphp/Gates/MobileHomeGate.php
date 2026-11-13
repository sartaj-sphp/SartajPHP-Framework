<?php
namespace Sphp\Gates{
/**
* Description of AngularApp
*
* @author Sartaj Singh
*/
include_once(\SphpBase::sphpSettings()->libPath . "/Sphp/Lib/Dir.php");
include_once(\SphpBase::sphpSettings()->libPath . "/Sphp/Lib/HtmlMinifier.php");
/**
* MobileHomeGate is a gate class for mobile home pages.
* It extends ComboGate and handles rendering, loading starter resources,
* and creating combined JS files for mobile applications.
*/
class MobileHomeGate extends ComboGate{
/**
* Constructor for MobileHomeGate.
* Initializes the gate with page, jsServer, client, and other dependencies.
* @return void
*/
/**
* Renders the mobile home gate.
* Loads starter resources, calls parent render, and creates combo files.
* @return void
*/
public function render(){}
/**
* Loads starter resources for the mobile home gate.
* @return void
*/
/**
* Loads a JS/PHP library file and appends it to the specified filename.
* @param string $filename The target file to write to.
* @param string $subpath The subpath to search for PHP files.
* @param bool $overwrite Whether to overwrite the file or append.
* @return void
*/
/**
* Loads a JS library file and appends it to the specified filename.
* @param string $filename The target file to write to.
* @param string $subpath The subpath to search for JS files.
* @param bool $overwrite Whether to overwrite the file or append.
* @return void
*/
/**
* Creates combined JS files for the mobile home gate.
* @return void
*/
}
/**
* MobilePageGate is a gate class for mobile pages.
* It extends MobileHomeGate and handles page events for loading pages.
*/
class MobilePageGate extends MobileHomeGate{
/**
* Handles the page event for loading a full page.
* @param mixed $evtp Event parameter.
* @return void
*/
public function page_event_loadpagefull($evtp){}
/**
* Handles the page event for loading a page.
* @param mixed $evtp Event parameter.
* @return void
*/
public function page_event_loadpage($evtp){}
/**
* Creates combined JS files for the mobile page gate.
* @return void
*/
/**
* Renders the mobile page gate.
* @return void
*/
public function render(){}
}
}
