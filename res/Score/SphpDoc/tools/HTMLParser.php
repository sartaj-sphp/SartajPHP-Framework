<?php
namespace Sphp\tools{
/**
* Description of HTMLParser
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
* @var \Sphp\tools\FrontFile
*/
public $frontobj;
public $dhtmldom;
/** @var Sphp\Settings */
public $sphp_settings = null;
public $phppath = "";
public $respath = "";
public $comppath = "" ;
public $slibpath = "" ;
public $debug = null;
public function getFrontobj() {}
public function getSevalVar($name){}
public function parseHTMLObj($strData, $obj) {}
public function parseHTML(){}
public function parseComponent($compobj,$innerHTML = false){}
public function createTagComponent($name="mycustomtag1",$tagname="div") {}
public function getChildrenWrapper($compobj){}
public function parseComponentChildren($wrGateerElement){}
public function parseHTMLTag($strData,$callbackfun,$obj){}
public function setupcomp($element,$parentelement) {}
public function endupcomp($element,$parentelement) {}    
public function startrender($element,$parentelement) {}    
public function endrender($element,$parentelement) {}
public function resolvePathVar($val){}
/**
* Execute PHP code in Limited Container. Use only Template Tags ##{ }# or #{ }#
* @param string $strPHPCode PHP Template code
* @param \Sphp\tools\Component $compobj default null, Show debug information if Component
* run code
* @return string
*/
public function executePHPCode($strPHPCode,$compobj=null) {}
}
}
