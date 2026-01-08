<?php
namespace Sphp\core{

class Response {

    private $method = "HTTP";
    private $status_code = 200;
    private $content = "";
    private $headers = array();
    private $cookies = array();
    
    public function __construct() {
        $this->init();
    }
    /**
     * Advance Function, Internal use
     */
    public function init(){
        $this->method = "HTTP";
        $this->status_code = 200;
        $this->content = "";
        $this->headers = array();
        $this->addHttpHeader("Content-Type", "text/html;charset=UTF-8"); 
        if(\SphpBase::sphp_settings()->response_method !== "HEX"){
            $this->addSecurityHeaders();
        } 
    }
    /**
     * Generate Security Policy for Browser
     * @param string $extrahost host list
     * @param string $extrawshost Web Socket host list
     * @return array
     */
    public function getSecurityPolicy($extrahost="",$extrawshost="") {
        $policy = array();
        $url = parse_url(\SphpBase::sphp_settings()->base_url);
        $host = $url["host"];
        $ws = 'ws://' . $host . ' ws://*.' . $host . ':* wss://' . $host . ' wss://*.' . $host . ':* ' . $extrawshost;
        $lsthosts = " 'self' ". 'http://' . $host . ' http://*.' . $host . ':* https://' . $host . ' https://*.' . $host . ':* ';
        $lsthosts .= "https://fonts.gstatic.com/ https://fonts.googleapis.com "  . $extrahost;
        $policy["default-src"] = "data: blob: ". $lsthosts ." 'unsafe-inline' ". $lsthosts ." 'unsafe-eval' ". $lsthosts ."";
        /*
        $policy["script-src"] = "". $lsthosts ." 'unsafe-inline' 'unsafe-eval' blob: data: ". $lsthosts ."";
        $policy["style-src"] = $lsthosts . " https://fonts.gstatic.com/ https://fonts.googleapis.com 'unsafe-inline' " . $lsthosts;
        $policy["connect-src"] = $lsthosts . ' ' . $ws;
        $policy["font-src"] = "data: https://fonts.gstatic.com/ https://fonts.googleapis.com " . $lsthosts;
        $policy["img-src"] = $lsthosts  . ' data:';
        $policy["media-src"] = $lsthosts . ' data:';
        $policy["frame-src"] = $lsthosts;
        $policy["worker-src"] = "blob: ". $lsthosts;
         * 
         */
        return $policy;
    }
    /**
     * Add Security Policy into Browser
     * @param array $policy
     * @param string $policyExtra
     * @param string $reportURL error reporting url
     */
    public function addSecurityHeaders($policy = array(),$policyExtra="",$reportURL="") {
        $strpolicy = "";
        if(count($policy) === 0){
            $policy = $this->getSecurityPolicy();
        }
        //if($policyExtra == "") $policyExtra = "block-all-mixed-content;upgrade-insecure-requests;";
        if($policyExtra == "") $policyExtra = "block-all-mixed-content;";
        if($reportURL == "") $reportURL = \SphpBase::sphp_settings()->base_path ."/index-reporting.html?minimize=0";
        $policyReport = "report-uri $reportURL;";
        foreach ($policy as $key=>$val) $strpolicy .= $key . ' '. $val . ';';

        $this->addHttpHeader('Strict-Transport-Security', 'max-age=15552000; preload');
        $this->addHttpHeader('Content-Security-Policy', $strpolicy . $policyExtra);
        $this->addHttpHeader('Content-Security-Policy-Report-Only', $strpolicy . $policyReport);
        $this->addHttpHeader('Cross-Origin-Opener-Policy', 'same-origin-allow-popups');
        $this->addHttpHeader('X-Frame-Options', 'SAMEORIGIN');
        $this->addHttpHeader('X-Content-Type-Option', 'nosniff');
        $this->addHttpHeader('X-Xss-Protection', '0');
        
    }
    /**
     * Advance Function, Internal use
     */
    public function setContent($data){
        $this->content = $data;
    }
    /**
     * Advance Function, Internal use
     */
    public function getContent(){
        return $this->content;
    }
    /**
     * Set Status Code of Server
     * @param int $code
     */
    public function setStatusCode($code){
        $this->status_code = $code;
    }
    /**
     * Read Status Code of Server
     * @return int
     */
    public function getStatusCode(){
        return $this->status_code;
    }
    /**
     * Add HTTP Header and send to browser
     * SphpBase::sphp_response()->addHttpHeader("Cache-control", "public, max-age=864000, must-revalidate");
     * @param string $key
     * @param string $val
     * @param int $statuscode
     */
    public function addHttpHeader($key,$val,$statuscode=0) { 
        $this->headers[strtolower($key)] = array($val,true,$statuscode);
    }
    /**
     * Remove HTTP Header from Response
     * SphpBase::sphp_response()->removeHttpHeader("Cache-control")
     * @param string $key
     */
    public function removeHttpHeader($key) { 
        unset($this->headers[strtolower($key)]);
    }
    /**
     * Get All Response Headers
     * @return array
     */
    public function getHeader() {
        return $this->headers;
    }
    /**
     * Advance Function, Internal use
     */
    public function sendHeaders() { 
        foreach ($this->headers as $key => $value) { 
            if($value[2]==0){
                header($key . ':' . $value[0],$value[1]);            
            }else{
                header($key . ':' . $value[0],$value[1],$value[2]);
            }
        }
    }
    /**
     * Write Cookie
     * @param string $name key
     * @param string $value
     * @param int $expire -1 mean calculate expire time
     * @param string $path
     * @param string $domain
     * @param boolean $secure
     * @param boolean $httponly
     */
    public function setCookie($name,$value="",$expire=-1,$path='/',$domain="",$secure=false,$httponly=false) {
        if($expire == -1) $expire = time()+60*60*24*30;
        $this->cookies[$name] = array($value,$expire,$path,$domain,$secure,$httponly);
        setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
    }
    private function saveCache($data){
        if(!\SphpBase::$stmycache->blnPost && \SphpBase::$stmycache->blnCash){
            file_put_contents(\SphpBase::$stmycache->htmlfileName, $data);
        }

    }

    private function sanitize_output($buffer) {
        $search = array(
            '/\>[^\S ]+/s',      // strip whitespaces after tags, except space
            '/[^\S ]+\</s',      // strip whitespaces before tags, except space
            '/(\s)+/s',          // shorten multiple whitespace sequences
            '/<!--(.|\s)*?-->/', // Remove HTML comments
                    '/\>\s+\</'         // Remove Extra space between Tags
        );

        $replace = array(
            '>',
            '<',
            '\\1',
            '',
                    '><'
        );

        $buffer = preg_replace($search, $replace, $buffer);

        return $buffer;
    }
    
    /**
     * Advance Function, Internal use
     */
    public function send($sendheader=true) { 
        $request = \SphpBase::engine()->getRequest();
        if(\SphpBase::sphp_settings()->response_method == "HEX"){ 
            $ar1 = array();
            $ar1["headers"] = $this->headers;
            $ar1["sessions"] = array();
            $ar1["cookies"] = $this->cookies;
            $ar1["content"] = bin2hex($this->content);
            //file_put_contents("p2hex.txt", $ar1["content"]);
            //file_put_contents("p2bin.txt", hex2bin($ar1["content"]));
            $datao = json_encode($ar1) . "\n";
            $this->saveCache($datao);
            echo $datao;
        }else{ 
            if($request->mode != "CLI" && $sendheader){
                $this->sendHeaders();
            }
            // use less to minify use gzip
            //$this->content = $this->sanitize_output($this->content);
            $this->saveCache($this->content);
            echo $this->content;
            
        }
        $this->content = "";
    }
}
}
