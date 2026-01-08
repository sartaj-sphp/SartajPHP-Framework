<?php
namespace Sphp\kit {
class JSServer {
public $json = null;
public $ajaxrender = false;
public $jsonready = false;
public $jsonplain = false;
/**
* Advance function 
*/
public function init() {}
/**
* Enable ajax JS library.
*/
public function getAJAX() {}
/**
* Read json data from browser post key 
* @param string $post_data_key
* @return json
*/
public function getJSON($post_data_key) {}
/**
* Advance function to enable JSON response
*/
public function startJSONOutput() {}
/**
* Advance function 
*/
public function sendData($data, $contenttype = "") {}
/**
* Send string to browser and display in html tag with an $tagid
* @param string $tagid <p>
* HTML Tag ID where to set html
* </p>
* @param string $dataar
*/
public function addJSONHTMLBlock($tagid, $dataar) {}
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
*/
public function addJSONBlock($sact, $evtp, $dataar) {}
/**
* Call JS Function from Server
* @param string $jsfun
* @param mixed $dataa
*/
public function callJsFunction($jsfun, $dataa) {}
/**
* Send Component object inside a HTML Tag
* @param \Sphp\tools\Component $obj
* @param string $outid <p>
* HTML Tag id where to display html of Component
* </p>
* @param boolean $innerHTML Optional <p>
* Default = false:- Not send Inner Components
* true:- mean send all Inner Components also
* </p>
*/
public function addJSONComp($obj, $outid = "outid", $innerHTML = false) {}
/**
* Send only Inner Components of Object
* @param \Sphp\tools\Component $obj
* @param string $outid
*/
public function addJSONCompChildren($obj, $outid = "outid") {}
/**
* Get Component HTML Output
* @param \Sphp\tools\Component $obj
* @return string
*/
public function getJSONComp($obj) {}
/**
* Send FrontFile Object to HTML Tag id
* @param \Sphp\tools\FrontFile $frontobj
* @param string $outid <p>
* HTML Tag ID where to display HTML of temfile object
* </p>
*/
public function addJSONFront($frontobj, $outid = "outid") {}
/**
* Send FrontFile Object with all file links to HTML Tag id
* @param \Sphp\tools\FrontFile $frontobj
* @param string $outid <p>
* HTML Tag ID where to display HTML of temfile object
* </p>
*/
public function addJSONFrontFull($frontobj, $outid = "outid") {}
/**
* Send Data as inter process communication
* @param string $aname
* @param array $structure
*/
public function addJSONIpcBlock($aname, $structure) {}
/**
* Advance Function         * 
* @param string $type <p>
* default is jsonweb. You can create your own custom type also.
* </p>
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
*/
public function addJSONJSBlock($jsdata = "", $type = "jsp") {}
/**
* Send data to getAJAX callback function.
* getAJAX('index-test.html',{},true,function(ret){
*  console.log('server return data' + ret);
* });
* @param array|string $data
*/
public function addJSONReturnBlock($data) {}
/**
* Advance Function
* Return all response of Server as JSON
* @return string
*/
public function getResponse() {}
/**
* Advance Function
* Send all response of Server as JSON to browser.
* if application run continiously then you can send intermediate data
*  
*/
public function flush() {}
public function callServer($jsfun, $url, $imgid = "''") {}
public function postServer($url, $data = "{}", $imgid = "''", $cache = false, $dataType = "'json'") {}
}
/**
* Description of JQuery
*
* @author Sartaj Singh
*/
class JQuery {
public $jq = null;
public function setJSFunctionName($jsfun, $funtype = false) {}
public function stripQuot($val) {}
public function safeJSString($val) {}
public function stripNewLineChar($val) {}
public function getJSString($val) {}
public function log($msg) {}
public function info($msg) {}
public function warn($msg) {}
public function error($msg) {}
public function setEventHandler() {}
public function fetchQuery($sql, $timesec = 0) {}
public function ajax($fun, $url, $data = "''", $cache = false) {}
public function StartTimeLine($aname) {}
public function addTimeLineCMD($aname, $at_time, $val) {}
public function fun() {}
public function funseq() {}
public function funargs() {}
public function runTimeLine($aname) {}
public function Queue($aname) {}
public function addQueue($aname, $val) {}
public function addFade($id) {}
public function addExplode($id) {}
public function addBounce($id) {}
public function getJQKit() {}
public function pngFix() {}
public function stringtoargu($strpara) {}
public function stringtophpargu($strpara) {}
public function phpstring($str) {}
}
}
