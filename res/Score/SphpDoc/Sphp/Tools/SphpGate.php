<?php
namespace Sphp\Tools{
/**
* SphpGate
*
* The SphpGate class acts as a central gateway for managing front-end file
* registration, event handling, and server-side communication features.
* It provides mechanisms for:
* - Registering and triggering gate events across front-end files
* - Creating front-end parser files with optional prefixes
* - Setting up component event handlers with fixed naming conventions
* - Enabling Server-Sent Events (SSE) for real-time server-to-client communication
* - Creating Web Workers for background JavaScript processing
* - Generating JavaScript code for AJAX-based event handling
*
* @author Sartaj Singh
*/
class SphpGate {
/**
* @var array List of registered front-end file objects
*/
/**
* Register a front-end file object for gate event processing.
*
* Adds the provided front-end object to the internal list of front files
* so that gate events can be triggered across all registered files.
*
* @param object $frontobj The front-end file object to register
* @return void
*/
/**
* Trigger a gate event across all registered front-end files.
*
* Iterates through all registered front-end file objects and invokes
* their _onGateEvent method to propagate the gate event.
*
* @return void
*/
protected function _triggerGateEvent() {}
/**
* Start a quick response by closing the current session.
*
* Closes the current Sphp session to allow parallel processing
* for the same session, enabling faster response times.
*
* @return void
*/
public function startQuickResponse() {}
/**
* Create a new front-end parser file.
*
* Instantiates a FrontParser object for the given file path with
* an optional prefix for naming conventions.
*
* @param string $filepath The path to the front-end file
* @param string $prefix Optional prefix for the file (default: "")
* @return \Sphp\Tools\FrontParser The created front-end parser instance
*/
public function createFrontFile($filepath,$prefix="") {}
/**
* This features is disabled use SetEventHandler method.
*
* Fix component event handlers by reflecting on class methods and
* registering handlers for methods with the 'comp' prefix.
*
* @param \Sphp\Tools\FrontParser $frontobj The front-end parser object
* @return void
*/
protected function _fixCompEventHandlers($frontobj) {}
/**
* Register as Gate Class Method as handler of Component Event.
* if Event is registered and Trigger by Component then It will trigger method as fixed name
* as comp_{$comp_name}_$event .
*
* Registers a component event handler using a fixed naming convention
* based on the component name and event name. The handler method name
* is constructed as "comp_{componentName}_{eventName}".
*
* @param \Sphp\Tools\Component $component Component Object
* @param string $event Event Name
* @return void
*/
protected function setEventHandler($component,$event){}
/**
* Set up Server-Sent Events (SSE) for real-time server-to-client communication.
*
* Adds JavaScript functions to the page header that enable EventSource
* based server-sent events. The client will listen for messages from
* the provided event URL and process them via the sphpeventfun handler.
*
* @param string $eventurl The URL endpoint for server-sent events
* @return void
*/
public function setServerSentEvent($eventurl) {}
/**
* Create a Web Worker for background JavaScript processing.
*
* Adds JavaScript functions to the page header that enable a Web Worker
* for the given JavaScript file. The worker's messages are processed
* via the provided JavaScript function name.
*
* @param string $jsfunname The name of the JavaScript function to handle worker messages
* @param string $jsfileurl The URL of the JavaScript file to run in the worker
* @return void
*/
public function createWebWorker($jsfunname,$jsfileurl) {}
/**
* Generate JavaScript code for AJAX-based event handling.
*
* Reflects on class methods with the 'js' prefix and generates
* JavaScript code that binds event handlers to DOM elements.
* Each generated handler sends AJAX requests to the server
* using the sartajgt function with the provided event and AJAX names.
*
* @param string $eventname The name of the event for the AJAX request
* @param string $ajaxname The name of the AJAX endpoint
* @return void
*/
protected function genSjsCode($eventname, $ajaxname) {}
}
}
