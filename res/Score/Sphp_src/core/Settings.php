<?php
namespace Sphp{

class Settings{
    public $blnEditMode = false ;
    public $editCtrl = "" ;
    public $blnGlobalApp = false ;
    public $translatermode = false ;
    public $response_method = "NORMAL";
    public $defenckey = "";
    
    private $res_path = "" ;
    private $php_path = "" ;
    private $slib_path = "" ;
    private $slib_version = "";
    private $slib_res_path = "" ;
    private $jquery_path = "" ;
    private $comp_path = "" ;
    private $comp_res_path = "" ;
    private $lib_path = "" ;
    private $lib_version = "" ;
    private $base_path = "" ;
    private $base_url = "" ;
    private $server_path = "" ;
    private $start_path = "" ;
    private $use_session = false ;
    private $sphp_use_session_storage = false;
    private $sphp_use_session_cookie = false;
    private $session_name = "" ;
    private $session_path = "" ;
    private $session_id = "" ;
    private $serv_language = "ENGLISH" ;
    private $debug_mode = 0 ;
    private $debug_profiler = "" ;
    
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
    // cashe time in sec
    public $mintime = 0 ;
    public $midtime = 0 ;
    public $maxtime = 0 ;
    // keywords for seo repeated in alt tag title etc.use getKeyword()
    public $keywordIndex = -1;
    public $keywords = array();
    // title tag of page
    public $title = "";
    
    // meta tag of keywords
    public $metakeywords = "";
    // meta tag of description
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
    // 2= defer, 1= async, 0=nop
    public $default_filelink_load = 0;

    public function __construct() {
        extract($GLOBALS, EXTR_REFS);
        $this->start_path = start_path;
        $this->base_path = $basepath;
        if (isset($_SERVER["HTTPS"]) && ( $_SERVER["HTTPS"] === "on" || $_SERVER["HTTPS"] === 1)){
            $this->base_url = "https://".$_SERVER['HTTP_HOST'];
        }else{
            $this->base_url = "http://".$_SERVER['HTTP_HOST'];    
        }
        if($this->base_path !== ""){
            $t1 = str_replace("https:", "http:", $this->base_path);
            $t2 = str_replace("https:", "http:", $this->base_url);
            $this->base_path = str_replace($t2, "", $t1);
            $this->base_path = $this->base_url . $this->base_path;
        }else{
            $this->base_path = $this->base_url;
        }
        
        $this->translatermode = $translatermode;
        $this->blnEditMode = $blnEditMode; //set by request class on by native server
        $this->defenckey = $defenckey;
        $this->res_path = $respath;
        $this->php_path = $phppath;
        $this->slib_path = $slibpath;
        $this->slib_version = $slibversion;
        $this->slib_res_path = "{$respath}/{$slibversion}";
        $this->jquery_path = $jquerypath;
        $this->comp_path = $comppath;
        $this->lib_path = $libpath;
        $this->lib_version = $libversion;
        $this->server_path = $serverpath;
        $this->use_session = $sphp_use_session;
        $this->sphp_use_session_storage = $sphp_use_session_storage;
        $this->sphp_use_session_cookie = $sphp_use_session_cookie;
        $this->session_name = $SESSION_NAME;
        $this->session_path = $SESSION_PATH;
        $this->serv_language = $serv_language;
        $this->debug_mode = $debugmode;
        $this->debug_profiler = $debugprofiler;
        $this->enable_log = $errorLog;
        $this->js_protection = $jsProtection;
        $this->db_engine_path = $db_engine_path;
        $this->ddriver = $ddriver;
        $this->duser = $duser;
        $this->db = $db;
        $this->dpass = $dpass;
        $this->dhost = $dhost;
        $this->run_mode_not_extension = true;
        $this->run_hd_parser = $run_hd_parser;
        $this->blnPreLibLoad = $blnPreLibLoad;
        $this->blnStopResponse = $blnStopResponse;
        $this->response_method = $response_method;
        $this->ajaxready_max = $ajaxready_max;
        $this->default_filelink_load = $default_filelink_load;
    }

    /**
     * Advance Function, Internal Use
     */
    public  function __get($key){
        if(isset($this->{$key}) ){
            return $this->{$key};
        }
        throw new \Exception('Undefined property '.__CLASS__.'->'.$key);
    }
    /**
     * Advance Function, Internal Use
     */
    public  function __set($key,$val){
        //$this->{$key} = $val;
        throw new \Exception('You can\'t change value of a Readonly property '.__CLASS__.'->'.$key);
    }    
    
    public function getTitle() {
        return $this->title;
    }

    public function getMetakeywords() {
        return $this->metakeywords;
    }
    
    public function getKeywordIndex() {
        return $this->keywordIndex;
    }

    public function getKeywords() {
        return $this->keywords;
    }
    /** SEO Friendly
     * Return one keyword from keywords array with internal index and increment index.
     * So Every call return different keyword. Important for SEO of page content.   
     * @return string
     */
    public function getKeyword() {
        if($this->keywordIndex >= count($this->keywords)-1){
            $this->keywordIndex = 0;
        }else{
            $this->keywordIndex += 1;
            }
            if(isset($this->keywords[$this->keywordIndex])){
        return $this->keywords[$this->keywordIndex];
            }else{
                return "";
            }
    }    
    /**
     * Generate Auto Generated
     * @param array $para
     * @param int $paraRepeated
     * @param int $startIndex
     * @return string
     */
    public function genAutoText($para,$paraRepeated=1,$startIndex=1){
        $T = $this->keywordIndex;
        $D = $startIndex;
        $max = count($para);
        $maxr = $max * $paraRepeated;
        for($C=1;$C<=$maxr;$C++){
           $str = $this->getKeyword();
            if($str!=''){
                $stri .= '<b>'. $str .'</b>'. $para[$D-1];
            }else{
                $stri .= $para[$D-1];
            }
            if($D>=$max){$D = 1;}else{$D += 1;}

        }
        $this->keywordIndex = $T;
        return $stri;
    }
    public function getMetadescription() {
        return $this->metadescription;
    }

    public function getMetadistribution() {
        return $this->metadistribution;
    }

    public function getMetaclassification() {
        return $this->metaclassification;
    }

    public function getMetarobot() {
        return $this->metarobot;
    }

    public function getMetarating() {
        return $this->metarating;
    }

    public function getMetaauthor() {
        return $this->metaauthor;
    }

    public function getMetapagerank() {
        return $this->metapagerank;
    }

    public function getMetarevisit() {
        return $this->metarevisit;
    }
    /**
     * Set Title of web page
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }
    /**
     * Set HTML Meta Keyword
     * @param string $metakeywords
     */
    public function setMetakeywords($metakeywords) {
        $this->metakeywords = $metakeywords;
    }
    /**
     * Set Keyword Index for keywords array for autogenerate text for SEO
     * @param int $keywordIndex
     */
    public function setKeywordIndex($keywordIndex) {
        $this->keywordIndex = $keywordIndex;
    }
    /**
     * Set SEO Keywords for generating onpage SEO
     * @param array $keywords
     */
    public function setKeywords($keywords) {
        $this->keywords = $keywords;
    }
    /**
     * Set HTML Meta Description
     * @param string $metadescription
     */
    public function setMetadescription($metadescription) {
        $this->metadescription = $metadescription;
    }
    /**
     * Set HTML Meta Distribution
     * @param string $metadistribution
     */
    public function setMetadistribution($metadistribution) {
        $this->metadistribution = $metadistribution;
    }
    /**
     * Set HTML Meta Classification
     * @param string $metaclassification
     */
    public function setMetaclassification($metaclassification) {
        $this->metaclassification = $metaclassification;
    }
    /**
     * Set HTML Meta Robot
     * @param string $metarobot
     */
    public function setMetarobot($metarobot) {
        $this->metarobot = $metarobot;
    }
    /**
     * Set HTML Meta Rating
     * @param string $metadistribution
     */
    public function setMetarating($metarating) {
        $this->metarating = $metarating;
    }
    /**
     * Set HTML Meta Author
     * @param string $metaauthor
     */
    public function setMetaauthor($metaauthor) {
        $this->metaauthor = $metaauthor;
    }
    /**
     * Set HTML Meta Page Rank
     * @param string $metapagerank
     */
    public function setMetapagerank($metapagerank) {
        $this->metapagerank = $metapagerank;
    }
    /**
     * Set HTML Meta Revisit
     * @param string $metarevisit
     */
    public function setMetarevisit($metarevisit) {
        $this->metarevisit = $metarevisit;
    }

    public function getRes_path() {
        return $this->res_path;
    }

    public function getPhp_path() {
        return $this->php_path;
    }

    public function getJquery_path() {
        return $this->jquery_path;
    }

    public function getComp_path() {
        return $this->comp_path;
    }

    public function getLib_path() {
        return $this->lib_path;
    }

    public function getBase_path() {
        return $this->base_path;
    }

    public function getBase_url() {
        return $this->base_url;
    }
    
    public function getServer_path() {
        return $this->server_path;
    }

    public function getUse_session() {
        return $this->use_session;
    }

    public function getSession_name() {
        return $this->session_name;
    }

    public function getSession_path() {
        return $this->session_path;
    }

    public function getSession_id() {
        return $this->session_id;
    }

    public function getServ_language() {
        return $this->serv_language;
    }

    public function getDebug_mode() {
        return $this->debug_mode;
    }

    public function getDebug_profiler() {
        return $this->debug_profiler;
    }

    public function getEnable_log() {
        return $this->enable_log;
    }

    public function getError_page() {
        return $this->error_page;
    }

    public function getError_log() {
        return $this->error_log;
    }

    public function getInject_protection() {
        return $this->inject_protection;
    }

    public function getDdriver() {
        return $this->ddriver;
    }

    public function getDuser() {
        return $this->duser;
    }

    public function getDb() {
        return $this->db;
    }

    public function getDpass() {
        return $this->dpass;
    }

    public function getDhost() {
        return $this->dhost;
    }

    public function getMintime() {
        return $this->mintime;
    }

    public function getMidtime() {
        return $this->midtime;
    }

    public function getMaxtime() {
        return $this->maxtime;
    }


    public function setSession_id($session_id) {
        $this->session_id = $session_id;
    }

    public function setEnable_log($enable_log) {
        $this->enable_log = $enable_log;
    }

    public function setError_page($error_page) {
        $this->error_page = $error_page;
    }

    public function setError_log($error_log) {
        $this->error_log = $error_log;
    }

    public function setDdriver($ddriver) {
        $this->ddriver = $ddriver;
    }

    public function setDuser($duser) {
        $this->duser = $duser;
    }

    public function setDb($db) {
        $this->db = $db;
    }

    public function setDpass($dpass) {
        $this->dpass = $dpass;
    }

    public function setDhost($dhost) {
        $this->dhost = $dhost;
    }

    public function setMintime($mintime) {
        $this->mintime = $mintime;
    }

    public function setMidtime($midtime) {
        $this->midtime = $midtime;
    }

    public function setMaxtime($maxtime) {
        $this->maxtime = $maxtime;
    }
    /**
     * Advanced Function
     */
    public function disableEditing() {
        $this->blnEditMode = false;
        addHeaderJSFunctionCode("ready", "enbledt1", ' ',true);
    }
    /**
     * Advanced Function
     */
    public function enableEditing() {
        $this->blnEditMode = true;
        addHeaderJSFunctionCode("ready", "enbledt1", 'document.ondblclick = function(event) { 
    if($(event.target).closest(".sfront").length > 0){
        var sfront1 = $(event.target).closest(".sfront");
        //var data = {};
        //data["frontfname"] = $(sfront1).data("frontfname");
        //data["frontappname"] = $(sfront1).data("frontappname");
        //getAJAX("'. getEventURL("findfrontf","","seditor") .'",data,true,function(ret){
             //console.log("all done " + ret);
             //clickTreeFileFromPath(ret);
        //});
        frontfname = $(sfront1).data("frontfname");
        frontappname = $(sfront1).data("frontappname");
        window.open("'. getEventURL("findfrontf","","seditor") .'?frontfname=" + frontfname + "&frontappname=" + frontappname, frontfname, "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=200,width=800,height=800");
       
    }else if($(this).contents().find("meta[name=\'generator\']").length > 0){
        var masterf = $(this).contents().find("meta[name=\'generator\']");
    //console.log(masterf);
        //var data = {};
        //data["frontfname"] = $(masterf).data("masterf");
        //data["frontappname"] = $(masterf).data("mappname");
        //getAJAX("'. getEventURL("findmasterf","","seditor") .'",data,true,function(ret){
             //clickTreeFileFromPath(ret);
        //});
        frontfname = $(masterf).data("masterf");
        frontappname = $(masterf).data("mappname");
        window.open("'. getEventURL("findmasterf","","seditor") .'?frontfname=" + frontfname + "&frontappname=" + frontappname, frontfname, "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=200,width=800,height=800");
    }
    window["ProcessSphpCM"] = function(message) {
        if(message == "reload"){
            window.location.reload(true);
        }
	console.log(message);
    };
};',true);
    }

}
}
