<?php
namespace Sphp\tools{
/**
* Description of DHTMLParser
*
* @author SARTAJ
*/
use Sphp\tools\SHTMLDOMOld;
use Sphp\tools\SHTMLDOM;
use Sphp\tools\HTMLDOM;
class HTMLParser {
public $curelement = null;
public $curlineno = 0;
public $codebehind = array();
public $blncodebehind = false;
/**
* @var \Sphp\tools\TempFile
*/
public $tempobj;
public $dhtmldom;
/** @var Sphp\Settings */
public $sphp_settings = null;
public $phppath = "";
public $respath = "";
public $comppath = "" ;
public $slibpath = "" ;
public $debug = null;
public function getTempobj() {}
public function setTempobj($tempobj) {}
public function setCodebehind($codebehind) {}
public function parseHTML(){}
public function parseComponent($compobj,$innerHTML = false){}
public function createTagComponent($name="mycustomtag1",$tagname="div") {}
public function getChildrenWrapper($compobj){}
public function parseComponentChildren($wrapperElement){}
public function parseHTMLObj($strData, $obj) {}
public function parseHTMLTag($strData,$callbackfun,$obj){}
public function setupcomp($element,$parentelement) {}
public function endupcomp($element,$parentelement) {}    
public function startrender($element,$parentelement) {}    
public function endrender($element,$parentelement) {}
public function executeFun($compobj, $key, $val) {}
public function resolvePathVar($val){}
public function executePHPCode($strPHPCode,$compobj=null) {}
}
}
