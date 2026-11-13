<?php
namespace Sphp\Gates{
/**
* Description of SessionClass
*
* @author Sartaj Singh
*/
/**
* SessionClass provides a base class for persisting object property values
* into the user session automatically. On construction it restores previously
* saved values, and on destruction it saves the current property values back
* to the session under a configurable session key.
*/
class SessionClass{
/**
* Constructor. Sets the session key name, restores saved values from the
* session, and calls onstart() for subclass initialization.
*
* @param string $name Session key under which this object's values are stored.
* @return void
*/
/**
* Get or set a session value by name.
*
* @param string $name Session variable name.
* @param string $value Value to store; empty string means read the value.
* @return mixed The session value when reading, void when writing.
*/
/**
* Hook called after values are restored in the constructor. Override in
* subclasses for startup logic.
*
* @return void
*/
public function onstart() {}
/**
* Hook called in the destructor before values are saved. Override in
* subclasses for shutdown logic.
*
* @return void
*/
public function onend() {}
/**
* Restore object property values from the session storage.
*
* @return void
*/
/**
* Save all object property values to the session storage.
*
* @return void
*/
/**
* Destructor. Calls onend() and then saves the current property values
* back to the session.
*
* @return void
*/
}
}
