<?php
namespace Sphp\Kit {
/**
* JsServer class
*
* Server side JSON/AJAX response builder. It collects HTML, JS, CSS and data blocks
* during Gate execution and sends them to the browser as a JSON response, supporting
* plain data output, chunked keep-alive flushing and inter process communication blocks.
*/
class JsServer {
public $json = null;
public $ajaxRender = false;
public $jsonReady = false;
public $jsonPlain = false;
/**
* Advance function 
* @return void
*/
public function init() {}
/**
* Enable ajax JS library.
* @return void
*/
public function getAjax() {}
/**
* Read json data from browser post key 
* @param string $postDataKey
* @return json
*/
public function getJson($postDataKey) {}
/**
* Advance function to enable JSON response
* @return void
*/
public function startJsonOutput() {}
/**
* Advance function 
* @param mixed $data
* @param string $contenttype
* @return void
*/
public function sendData($data, $contenttype = "") {}
/**
* Send string to browser and display in html tag with an $tagid
* @param string $tagid <p>
* HTML Tag ID where to set html
* </p>
* @param string $dataar
* @return void
*/
public function addJsonHtmlBlock($tagid, $dataar) {}
/**
* Advance Function
* Send and Data type to browser
* @param string $sact <p>
* it may be and process order wise:- jss,js1,html,js,jsp,jsf
* </p>
* @param type $evtp <p>
* It is a key of value like in $sact=html then it is a tag id. 
* If $sact=jsf then it will be JS function name
* </p>
* @param mixed $dataar <p>
* data need to send browser
* </p>
* @return void
*/
public function addJsonBlock($sact, $evtp, $dataar) {}
/**
* Call JS Function from Server
* @param string $jsfun
* @param mixed $dataa
* @return void
*/
public function callJsFunction($jsfun, $dataa) {}
/**
* Send Component object inside a HTML Tag
* @param \Sphp\Tools\Component $obj
* @param string $outid <p>
* HTML Tag id where to display html output of Component
* </p>
* @param boolean $OnlyinnerHTML Optional <p>
* Default = false:- send full html output with Component Tag
* true:- mean send only Inner html output Component
* </p>
* @return void
*/
public function addJsonComp($obj, $outid = "outid", $OnlyinnerHTML = false) {}
/**
* Send only Inner Components of Object 
* same as addJsonComp with pass $OnlyinnerHTML=true
* @param \Sphp\Tools\Component $obj
* @param string $outid
* @return void
*/
public function addJsonCompChildren($obj, $outid = "outid") {}
/**
* Get Component HTML Output
* @param \Sphp\Tools\Component $obj
* @return string
*/
public function getJsonComp($obj) {}
/**
* Send FrontFile Object to HTML Tag id
* @param \Sphp\Tools\FrontFile $frontobj
* @param string $outid <p>
* HTML Tag ID where to display HTML of temfile object
* </p>
* @return void
*/
public function addJsonFront($frontobj, $outid = "outid") {}
/**
* Send FrontFile Object with all file links to HTML Tag id
* @param \Sphp\Tools\FrontFile $frontobj
* @param string $outid <p>
* HTML Tag ID where to display HTML of temfile object
* </p>
* @return void
*/
public function addJsonFrontFull($frontobj, $outid = "outid") {}
/**
* Send Data as inter process communication
* @param string $aname
* @param array $structure
* @return void
*/
public function addJsonIpcBlock($aname, $structure) {}
/**
* Advance Function         * 
* @param string $type <p>
* default is jsonweb. You can create your own custom type also.
* </p>
* @return void
*/
public function setBlockType($type = "jsonweb") {}
/**
* Send JS Code to browser
* @param string $jsdata <p>
* JS code as string, send to browser.
* </p>
* @param string $type <p>
* value may be order wise :- jss, jsfl, js, jsp or jsf
* jss has highest priority
* </p>
* @return void
*/
public function addJsonJsBlock($jsdata = "", $type = "jsp") {}
/**
* Send data to getAjax callback function.
* getAjax('index-test.html',{},true,function(ret){
*  console.log('server return data' + ret);
* });
* @param array|string $data
* @return void
*/
public function addJsonReturnBlock($data) {}
/**
* Add header and footer HTML of application into response buffer.
* @return void
*/
/**
* Get session token from browser cookie, fallback to default token.
* @return string
*/
/**
* Advance Function
* Return all response of Server as JSON
* @return string
*/
public function getResponse() {}
/**
* Recursively apply a callback to every value of an array.
* @param callable $callback
* @param array|mixed $array
* @return mixed
*/
/**
* Advance Function
* Send all response of Server as JSON to browser.
* if Gate run continiously then you can send intermediate data
*  
* @return void
*/
public function flush() {}
/**
* Build JS code that calls a server URL and returns the call expression.
* @param string $jsfun
* @param string $url
* @param string $imgid
* @return string
*/
public function callServer($jsfun, $url, $imgid = "''") {}
/**
* Build JS code that posts data to a server URL.
* @param string $url
* @param string $data
* @param string $imgid
* @param bool $cache
* @param string $dataType
* @return string
*/
public function postServer($url, $data = "{}", $imgid = "''", $cache = false, $dataType = "'json'") {}
}
}
