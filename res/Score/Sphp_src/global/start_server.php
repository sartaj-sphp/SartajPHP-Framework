<?php
//stop engine
//define("sphp_mannually_start_engine",true);
// same speed like web server
require  __dir__ .'/../../../classes/sphpnativelib/vendor/autoload.php';
use React\Http;
final class SartajPhpNative{
public static $exepath = "";
public static $projectpath = "";
public static $os_type = "WIN";

	public static function init(){
		SartajPhpNative::$exepath = realpath(__dir__ .'/../../../../');
		SartajPhpNative::$projectpath = getcwd();
                 if (substr(PHP_OS, 0, 3) == 'WIN'){
                     SartajPhpNative::$os_type = "WIN";
                 }else{
                     SartajPhpNative::$os_type = "LINUX";
                 }
	}
	public static function checkTcpPort($ip,$port){
		$conn = @fsockopen($ip, $port, $errno, $errstr, 2);
		if (is_resource($conn)){
			fclose($conn);
			//echo "Port $port is Used on $ip. ";
			return false;
		}else{
			//echo "Port $port is free on $ip. \n";
			return true;
		}
	}

}

class SappChildProcess {
        private $cmd;
        private $cwd;
        private $env;
        private $options;
        //private $enhanceSigchildCompatibility;
        private $pipes;
        private $process = null;
        private $isRunning = false;

        /**
         * Constructor.
         *
         * @param string $cmd     Command line to run
         * @param string $cwd     Current working directory or null to inherit
         * @param array  $env     Environment variables or null to inherit
         * @param array  $options Options for proc_open()
         * @throws RuntimeException When proc_open() is not installed
         */
        public function __construct($cmd, $cwd = null, array $env = null, array $options = array()) {
            if (!function_exists('proc_open')) {
                throw new \RuntimeException('The Process class relies on proc_open(), which is not available on your PHP installation.');
            }

            $this->cmd = $cmd;
            $this->cwd = $cwd;

            if (null !== $env) {
                $this->env = array();
                foreach ($env as $key => $value) {
                    $this->env[(binary) $key] = (binary) $value;
                }
            }

            $this->options = $options;
            //$this->enhanceSigchildCompatibility = $this->isSigchildEnabled();
            $cmd = $this->cmd;
            $fdSpec = array(
                array('pipe', 'r'), // stdin
                array('pipe', 'w'), // stdout
                array('pipe', 'w'), // stderr
            );


            $this->process = proc_open($cmd, $fdSpec, $this->pipes, $this->cwd, $this->env, $this->options);
            //echo "create process";
            if (!is_resource($this->process)) {
                throw new \RuntimeException('Unable to launch a new process.');
            } else {
                stream_set_blocking($this->pipes[1], 0);
                $this->isRunning = true;
            }
        }

        public function write($msg) {
            if (is_resource($this->process)) {
                fwrite($this->pipes[0], $msg);
                //stream_write_contents();
            }
        }

        public function read() {
            if (is_resource($this->process)) {
                $msg = trim(fgets($this->pipes[1]));
		if($msg !== ""){
                    $msg = hex2bin($msg);
                    return $msg;
		}
            }
            return "";
        }

        public function readErr() {
            if (is_resource($this->process)) {
                $msg = stream_get_contents($this->pipes[2]);
                return $msg;
            }
            return "";
        }

        public function run() {
            while ($this->getStatus()) {
                usleep(300000);
                echo "wait \n";
                echo "read:- " . $this->read();
                //ondata()
                echo " done \n";
            }
            $errmsg = $this->readErr();
            $this->closeProcess();
        }

        public function closeProcess() {
            if (is_resource($this->process)) {
                fclose($this->pipes[0]);
                fclose($this->pipes[1]);
                fclose($this->pipes[2]);
                $return_value = proc_close($this->process);
                //echo "command returned $return_value\n";
                return $return_value;
            }
        }

        public function getStatus() {
            if (is_resource($this->process)) {
            return proc_get_status($this->process)['running'];
            }
            return 0;
        }

        public function __destruct() {
             if (is_resource($this->process)) {
                 $this->closeProcess();
             }
        }
    }

class SappProcessManager{
    private $processes = null;
    
    public function __construct() {
        $this->processes = array();
    }
    
    public function addProcess($processid,$cmd, $cwd = null, array $env = null, array $options = array()) {
        $this->processes[$processid] = new SappChildProcess($cmd, $cwd,$env,$options);
    }
    public function getChildProcess($processid) {
        if(isset($this->processes[$processid])){
            return $this->processes[$processid];
        }else{
            $this->addProcess($processid, $cmd);
            return $this->processes[$processid];
        }
    }
    public function sendData($processid,$data) {
        $child_process = $this->getChildProcess($processid);
        $child_process->write(bin2hex($data) ."\n");
    }
    
    public function readData($processid) {
        $child_process = $this->getChildProcess($processid);
        if($child_process->getStatus()) {
            $dt1 =  $child_process->read();
            if(strlen($dt1) > 2){
                return $dt1;
            }else{
                return "";
            }
        }
    }
    
}

/**
 * chat.php
 * Send any incoming messages to all connected clients (except sender)
 */
class MyChat implements Ratchet\MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(Ratchet\ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(Ratchet\ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
         echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
        foreach ($this->clients as $client) {
            if ($from != $client) {
                $client->send($msg);
            }else{
                $client->send("RX:- " . $msg);
            }
        }
    }

    public function onClose(Ratchet\ConnectionInterface $conn) {
        $this->clients->detach($conn);
    }

    public function onError(Ratchet\ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }
}

class SphpWebSocketP{
    private $ip = "127.0.0.1";
    private $port = 8081;
    private $host = "";
    private $socketServer = null;
    
    public function __construct($ip="127.0.0.1",$port="8081") {
        $this->ip = $ip;
        $this->port = $port;
        $this->host = $this->ip . ":" . $this->port;  
    }
    public function start($loop) {
        //create websoket server
        $wsocket = new React\Socket\Server($this->host, $loop);
        $this->socketServer =  new Ratchet\Server\IoServer(new Ratchet\Http\HttpServer(
                new Ratchet\WebSocket\WsServer(
                        new MyChat()
                        )), $wsocket,$loop);
        //$this->socketServer->run(); 

    }
}

class SWebAppCall{
    	public $ip = "127.0.0.1";
	public $port = 8000;
	public $host = "";
	public $hosttype = "http";
        public $InternalServerMode = false; 
	
	public function __construct($obj){
            $this->ip = $obj->ip;
            $this->port = $obj->port;
            $this->host = $obj->host;
            $this->InternalServerMode = $obj->InternalServerMode;
	}

	public function callSingleProcess($exec){
            //chdir($path);
            if (substr(PHP_OS, 0, 3) == 'WIN'){
                $proc = popen('start /b ' . $exec, 'r');
            }else{
                $proc = popen($exec . ' &', 'r');
            }
            $data = "";
            while (!feof($proc)) {
                $data .= fgets($proc);
            }
            pclose($proc);
            return $data;
	}
	public function callSingleProcess2($exec){
            return $data;
        }
        public function callSartajPhpApp($ctrl="index",$evt="",$evtp="",$infodata="",$data=""){
            //$mphppath = SartajPhpNative::$exepath . "/php/php.exe";
            $mphppath = "php";
            $s1 = "". $mphppath . "/ -f start.php - " . "--aroot \"" . SartajPhpNative::$exepath .  "\" --ctrl " . $ctrl . " --evt " . $evt . " --evtp \"" . $evtp . "\"" . " --droot \"" . SartajPhpNative::$projectpath . "/\"" . " --idata \"" . $infodata . "\"" . " --cdata \"" . $data . "\"";
            $v = $this->callSingleProcess($s1);
            //echo $v;
            $v = json_decode($v,true);
            $v["content"] = hex2bin($v["content"]);
            //print_r($v);
            return $v;
        }
        public function urlToSphpEvent($url){
            $urla = array("index","","");
            if(strrpos($url, "/")!==false){
                $url = substr($url, strrpos($url, "/")+1);
            }
            if(strrpos($url, ".")!==false){
                $url = substr($url,0, strrpos($url, "."));
            }
            $urla2 = explode("-",$url,3);
            $urla[0] = $urla2[0];
            if(count($urla2)>1) $urla[1] = $urla2[1];
            if(count($urla2) == 3) $urla[2] = $urla2[2];
            
            return $urla;
        }
        public function getSphpInfoData($request){
            $arr1 = array();
            $arr2 = array();
            $arr_server = array();
            $uri = $request->getUri()->getPath() .'?' . $request->getUri()->getQuery();
            $arr1["URL"] = $this->hosttype . '://' . $this->host . $uri;
            $arr1["Method"] = $request->getMethod();
            $arr_server["HTTP_HOST"] = $this->host;
            $arr_server["PHP_SELF"] = $uri;
            $arr_server["SCRIPT_NAME"] = SartajPhpNative::$projectpath . '/start.php';
            $arr_server["SCRIPT_FILENAME"] = SartajPhpNative::$projectpath  . '/start.php';
            $arr1["Server"] = $arr_server;
            $arr2["sphp"] = "4";
            //print_r($request->getHeaders()); not used fill in arr2
            //$request->getCookies()
            $arr1["Header"] = $arr2;
            $v1 = json_encode($arr1);
            $v1 =  bin2hex($v1);
            //echo $v1;
            return $v1;
        }
        public function getSphpPostData($request){
            $arr1 = array();
            $arr2 = $request->getParsedBody();
            $arr1["postdata"] = $arr2;
            $v1 = json_encode($arr1);
            $v1 =  bin2hex($v1);
            return $v1;
            //print_r($request->getParsedBody());
            //return "";
        }
        public function getConsoleCall($request,$relpath) {
            $infodata = $this->getSphpInfoData($request);
            $pdata = $this->getSphpPostData($request);
            $urla = $this->urlToSphpEvent($relpath);
            $rs = $this->callSartajPhpApp($urla[0],$urla[1],$urla[2],$infodata,$pdata);
            //print_r($rs["headers"]);
            $header1 = array();
            if(count($rs["headers"]) > 0){
            foreach ($rs["headers"] as $headern => $headerv) {
                $header1[$headern] = $headerv[0];
            }
            }else{
                $header1["Content-Type"] = "text/html";
            }
            return array($header1,$rs["content"]);
        }
        public function getInbuiltCall_old($request) {
            extract($GLOBALS, EXTR_REFS);
            $_SERVER['HTTP_HOST'] = $this->host;
            $_SERVER["REQUEST_URI"] = $request->getUri();
            //$_SERVER["REQUEST_URI"] = "/";
            $_SERVER["PHP_SELF"] = $_SERVER["REQUEST_URI"];
            $_SERVER["REQUEST_METHOD"] = $request->getMethod();
            $_SERVER["SCRIPT_NAME"] =  getcwd(). "/start.php";
            $_SERVER["SCRIPT_FILENAME"] = $_SERVER["SCRIPT_NAME"];
            $stmycache = SphpBase::refreshCacheEngine();
            $postdata = array();
            $getdata = array();
            parse_str($request->getUri()->getQuery(), $arurl2);
            foreach($arurl2 as $key => $value) {
                $getdata[$key] = urldecode($value);
            }
            if(is_array($request->getParsedBody())){
                $postdata = $request->getParsedBody();
            }
            $_GET = $getdata;
            $_POST = $postdata;
            $_REQUEST = array_merge($getdata,$postdata);
            $outp = $stmycache->checkCache($postdata);
            if($outp!=""){
                return array(SphpBase::sphp_response()->getHeader(),$outp);
            }else{
                SphpBase::addNewRequest();
                $sphp_notglobalapp = SphpBase::engine()->executeinit();
                if(!$sphp_notglobalapp[0]){
                    include($sphp_notglobalapp[1]);
                    SphpBase::engine()->execute(true); 
                }else{
                    SphpBase::engine()->execute();
                }
                $header1 = array();
                if(count(SphpBase::sphp_response()->getHeader()) > 0){
                foreach (SphpBase::sphp_response()->getHeader() as $headern => $headerv) {
                    $header1[$headern] = $headerv[0];
                }
                }else{
                    $header1["Content-Type"] = "text/html";
                }
                //echo SphpBase::sphp_response()->getContent();
                return array($header1,SphpBase::sphp_response()->getContent());
            }

        }
        public function getInbuiltCall($request,$relpath) {
            global $argv;
            $infodata = $this->getSphpInfoData($request);
            $pdata = $this->getSphpPostData($request);
            $urla = $this->urlToSphpEvent($relpath);
            $s1 = "start.php - " . "--aroot " . SartajPhpNative::$exepath .  " --ctrl " . $urla[0] . " --evt " . $urla[1] . " --evtp " . $urla[2] . " --droot " . SartajPhpNative::$projectpath . "/ --idata " . $infodata . " --cdata " . $pdata;
            // argv console arguments
            $argv = explode(' ',$s1); 
            //echo " enter " .  $urla[0] . '-' . $urla[1];
            $stmycache = SphpBase::refreshCacheEngine();
            SphpBase::addNewRequest();
            $sphp_notglobalapp = SphpBase::engine()->executeinit();
            if(!$sphp_notglobalapp[0]){
                include($sphp_notglobalapp[1]);
                SphpBase::engine()->execute(true); 
            }else{
                SphpBase::engine()->execute();
            }
            $header1 = array();
            if(count(SphpBase::sphp_response()->getHeader()) > 0){
            foreach (SphpBase::sphp_response()->getHeader() as $headern => $headerv) {
                $header1[$headern] = $headerv[0];
            }
            }else{
                $header1["Content-Type"] = "text/html";
            }
            //echo " enter2 " .  $urla[0] . '-' . $urla[1];
            //echo SphpBase::sphp_response()->getContent();
            return array($header1,SphpBase::sphp_response()->getContent());

        }
    
}

class SphpWebServer{
	public $ip = "127.0.0.1";
	public $port = 8000;
	public $host = "";
	public $hosttype = "http";
        public $InternalServerMode = false; 
	
	public function __construct($ip,$port){
		$this->ip = $ip;
		$this->port = $port;
		$this->host = $this->ip . ":" . $this->port;
                if(defined("sphp_mannually_start_engine")){
                    $this->InternalServerMode = true;
                }
	}
	        
        private function mimetype($filename){
		
        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg.xml',
            'svgz' => 'image/svg.xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'm4p' => 'audio/mpeg2',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );
        $ad = explode('.',$filename);
        $ext = strtolower(array_pop($ad));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
        else {
            return 'application/octet-stream';
        }

	}
        
	public function start(){
$loop = React\EventLoop\Factory::create();
//$filesystem = React\Filesystem\Filesystem::create($loop);
$server = new React\Http\Server(function (Psr\Http\Message\ServerRequestInterface $request) {
    $p1 = $request->getUri()->getPath();
    if ($p1 == '/') {
            $p1 = '/index.html';
    }

    $ext1 = pathinfo($p1,PATHINFO_EXTENSION);
    $relpath = $p1;
    //$relpath = str_replace('http://' . $this->host, "", $p1);
    $header1 = array();

    if($ext1 == "html"){
     //echo " enter " . $p1;
    //file_put_contents("reqt.txt", json_encode($request));
        //$qs = $request->getUri()->getQuery();
        $myself = new SWebAppCall($this);
         $t1 = microtime(true);
        return new React\Promise\Promise(function ($resolve, $reject) use ($request,$relpath,$myself,$t1) {
        $arr2 = $request->getParsedBody();
        $rs = array();
        if($myself->InternalServerMode){
            //echo " enter ";
            try{
        $rs = $myself->getInbuiltCall($request,$relpath);
            } catch (\Throwable $e) {
    echo $e->getMessage() . ' File:- ' . $e->getFile() . ' Line:- ' . $e->getLine();
}catch(\Exception $e){
    echo $e->getMessage() . ' File:- ' . $e->getFile() . ' Line:- ' . $e->getLine();
}

        }else{
        $rs = $myself->getConsoleCall($request,$relpath); 
        }
         //$t2 = microtime(true);

    //$body = "The requested path is: " . $request->getUri()->getPath();
    $response2 = new React\Http\Response(200,$rs[0],$rs[1]);
    //return $response2;
    $resolve($response2);
        });
    }else{
    if(strpos($relpath, "~rs/")!==false){
        $relpath = SartajPhpNative::$exepath . '/' . substr($relpath, strpos($relpath, "~rs/")+4);
    }else{
        $relpath = SartajPhpNative::$projectpath .$relpath;        
    }
    if(strpos($relpath, "~furl/")!==false){
        $relpath = substr($relpath, strpos($relpath, "~furl/")+6);
    }
    
    if(file_exists($relpath)){
        $header1["Content-Type"] = $this->mimetype($relpath);
        /*
        $file = $filesystem->file($relpath);

        return $file->open('r')->then(
            function (React\Filesystem\Stream\ReadableStream $stream) use($header1) {
                return new Response(200, $header1, $stream);
            }
        );
         * 
         */
        return new React\Http\Response(200,$header1,file_get_contents($relpath));
    }else{
        $header1["Content-Type"] = "text/html"; 
        return new React\Http\Response(404,$header1,"URL not FOUND:- $relpath");        
    }
    }
    
     
  
});

// create websocket
//$websocket = new SphpWebSocketP();
//$websocket->start($loop);
//end websoket server code
$socket = new React\Socket\Server($this->host, $loop);
/* not working on window
$socket = new \React\Socket\SecureServer($socket, $loop, array(
    'local_cert' => SartajPhpNative::$exepath . '/res/rootSSL.pem'
));
 * 
 */
$server->listen($socket);
//echo  $socket->getAddress() . ' ';
$loop->run();
}
}

SartajPhpNative::init();
//echo SartajPhpNative::$exepath ."\n";
//echo SartajPhpNative::$projectpath ."\n";
$ip = "127.0.0.1";
$c=8000;
$respath = "~rs/res/";
define("sphp_mannually_start_engine", true);
// find tcp port
for($c=8000;$c<8005;$c++){
    if(SartajPhpNative::checkTcpPort($ip,$c)){
        break;
    }
}

$wserv1 = new SphpWebServer($ip,$c);
$_SERVER["argc"] = 3;
$_SERVER["HTTP_HOST"] = $ip . ':' . $c;
$_SERVER['DOCUMENT_ROOT'] = SartajPhpNative::$projectpath;
unset($_SERVER["SERVER_SOFTWARE"]);
if(defined("sphp_mannually_start_engine")){
// include sphp lib
include_once("{$phppath}/{$slibversion}/{$libversion}/global/start.php");
//run as webserver module not run as console app
//$_SERVER["SERVER_SOFTWARE"] = "REACTPHPHTTP";
// mannually send response data
//$blnStopResponse = true;
SphpBase::sphp_settings()->blnStopResponse = true;
SphpBase::sphp_settings()->sphp_use_session_storage = true;

//SphpBase::sphp_settings()->$response_method = "HEX";
}

$url1 = "http://{$ip}:{$c}";
echo "open $url1";
if(SartajPhpNative::$os_type == "WIN"){
    //shell_exec("start $url1");
}else if(SartajPhpNative::$os_type == "DARWIN"){
    shell_exec("open $url1");
}else{
    shell_exec("xdg-open $url1");    
}
$wserv1->start();
//$wserv1->callSartajPhpApp("index","captcha","");
//echo " exit ";
