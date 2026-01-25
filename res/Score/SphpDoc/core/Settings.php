<?php
namespace Sphp{
class Settings{
public $blnEditMode = false ;
public $editCtrl = "" ;
public $blnGlobalApp = false ;
public $translatermode = false ;
public $response_method = "NORMAL";
public $defenckey = "";
public $enable_log = false ;
public $error_page = "" ;
public $error_log = "" ;
public $js_protection = false ;
public $db_engine_path = "";
public $ddriver = "" ;
public $duser = "" ;
public $db = "" ;
public $dpass = "" ;
public $dhost = "" ;
public $ajaxready_max = 300;
public $mintime = 0 ;
public $midtime = 0 ;
public $maxtime = 0 ;
public $keywordIndex = -1;
public $keywords = array();
public $title = "";
public $metakeywords = "";
public $metadescription = "";
public $metadistribution = "global";
public $metaclassification = "";
public $metarobot = "index, follow";
public $metarating = "general";
public $metaauthor = "";
public $metapagerank = "10";
public $metarevisit = "15 days";
public $run_mode_not_extension = false;
public $run_hd_parser = false;
public $blnPreLibLoad = false;
public $blnStopResponse = false;
public $default_filelink_load = 0;
/**
* Advance Function, Internal Use
*/
/**
* Advance Function, Internal Use
*/
public function getTitle() {}
public function getMetakeywords() {}
public function getKeywordIndex() {}
public function getKeywords() {}
/** SEO Friendly
* Return one keyword from keywords array with internal index and increment index.
* So Every call return different keyword. Important for SEO of page content.   
* @return string
*/
public function getKeyword() {}    
/**
* Generate Auto Generated
* @param array $para
* @param int $paraRepeated
* @param int $startIndex
* @return string
*/
public function genAutoText($para,$paraRepeated=1,$startIndex=1){}
public function getMetadescription() {}
public function getMetadistribution() {}
public function getMetaclassification() {}
public function getMetarobot() {}
public function getMetarating() {}
public function getMetaauthor() {}
public function getMetapagerank() {}
public function getMetarevisit() {}
/**
* Set Title of web page
* @param string $title
*/
public function setTitle($title) {}
/**
* Set HTML Meta Keyword
* @param string $metakeywords
*/
public function setMetakeywords($metakeywords) {}
/**
* Set Keyword Index for keywords array for autogenerate text for SEO
* @param int $keywordIndex
*/
public function setKeywordIndex($keywordIndex) {}
/**
* Set SEO Keywords for generating onpage SEO
* @param array $keywords
*/
public function setKeywords($keywords) {}
/**
* Set HTML Meta Description
* @param string $metadescription
*/
public function setMetadescription($metadescription) {}
/**
* Set HTML Meta Distribution
* @param string $metadistribution
*/
public function setMetadistribution($metadistribution) {}
/**
* Set HTML Meta Classification
* @param string $metaclassification
*/
public function setMetaclassification($metaclassification) {}
/**
* Set HTML Meta Robot
* @param string $metarobot
*/
public function setMetarobot($metarobot) {}
/**
* Set HTML Meta Rating
* @param string $metadistribution
*/
public function setMetarating($metarating) {}
/**
* Set HTML Meta Author
* @param string $metaauthor
*/
public function setMetaauthor($metaauthor) {}
/**
* Set HTML Meta Page Rank
* @param string $metapagerank
*/
public function setMetapagerank($metapagerank) {}
/**
* Set HTML Meta Revisit
* @param string $metarevisit
*/
public function setMetarevisit($metarevisit) {}
public function getRes_path() {}
public function getPhp_path() {}
public function getJquery_path() {}
public function getComp_path() {}
public function getLib_path() {}
public function getBase_path() {}
public function getBase_url() {}
public function getServer_path() {}
public function getProj_path() {}
public function getStart_path() {}
public function getUse_session() {}
public function getSession_name() {}
public function getSession_path() {}
public function getSession_id() {}
public function getServ_language() {}
public function getDebug_mode() {}
public function getDebug_profiler() {}
public function getEnable_log() {}
public function getError_page() {}
public function getError_log() {}
public function getInject_protection() {}
public function getDdriver() {}
public function getDuser() {}
public function getDb() {}
public function getDpass() {}
public function getDhost() {}
public function getMintime() {}
public function getMidtime() {}
public function getMaxtime() {}
public function setSession_id($session_id) {}
public function setEnable_log($enable_log) {}
public function setError_page($error_page) {}
public function setError_log($error_log) {}
public function setDdriver($ddriver) {}
public function setDuser($duser) {}
public function setDb($db) {}
public function setDpass($dpass) {}
public function setDhost($dhost) {}
public function setMintime($mintime) {}
public function setMidtime($midtime) {}
public function setMaxtime($maxtime) {}
/**
* Advanced Function
*/
public function disableEditing() {}
/**
* Advanced Function
*/
public function enableEditing() {}
}
}
