<?php
namespace Sphp\Dev{
use Sphp\Tools\FrontParser;
/**
* Installer Gate
* Handles plugin installation, update, removal and viewing for the SartajPHP framework.
* It manages plugin registration files, menu files and cache lists.
*/
class Installer extends \Sphp\Gates\BasicGate{
/**
* onstart
* Initialize gate: authenticate, set master file and create FrontParser objects for installer, config and plugin view.
* @return void
*/
public function onstart() {}
/**
* directoryCount
* Count/list directories inside a source path.
* @param string $src source directory path
* @return array list of directory names
*/
public function directoryCount($src){}
/**
* isPlugExist
* Check if a plugin exists in the plugin list.
* @return boolean true if plugin exists
*/
public function isPlugExist(){}
/**
* addPlug
* Add a plugin to the plugin list and run its install script if present.
* @param string $plugpath plugin folder path
* @param string $pfrom plugin source path
* @return boolean
*/
/**
* updatePlug
* Update a plugin in the plugin list and run its update script if present.
* @param string $plugpath plugin folder path
* @param string $pfrom plugin source path
* @return boolean
*/
/**
* removePlug
* Remove a plugin from the plugin list and run its uninstall script if present.
* @param string $plugpath plugin folder path
* @return void
*/
/**
* createInstaller
* Create installer files (menu, registration) from the plugin list.
* @param array $plug plugin list
* @return void
*/
/**
* page_event_config
* Handle plugin install event.
* @param string $param plugin name
* @return void
*/
public function page_event_config($param) {}
/**
* page_event_update
* Handle plugin update event.
* @param string $param plugin name
* @return void
*/
public function page_event_update($param) {}
/**
* page_event_rmp
* Handle plugin uninstall event.
* @param string $param plugin name
* @return void
*/
public function page_event_rmp($param) {}
/**
* page_event_vw
* Handle plugin view event.
* @param string $param plugin name
* @return void
*/
public function page_event_vw($param) {}
/**
* page_new
* Handle new page event.
* @return void
*/
public function page_new() {}
/**
* page_event_view
* Handle view event: show plugin view data.
* @return void
*/
public function page_event_view() {}
}
}
