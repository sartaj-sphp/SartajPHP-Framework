<?php
namespace{
class CURL{
/**
 * Fetch any url Data
 * @param string $url
 * @param boolean $bin default false
 * @return type 
 */
    public function get_url_data($url,$bin=false)
    {
$userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
$ch = curl_init();
    $timeout = 300;
    curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
curl_setopt($ch, CURLOPT_FAILONERROR, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_AUTOREFERER, true);
//curl_setopt($ch, CURLOPT_TIMEOUT, 10);
if($bin){
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
}
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    unset($ch);
    return $data;
    }
/**
 * Get List of Directories,Files From FTPES (FTP explicit SSL) FTP Server
 * @param type $url
 * @param type $username
 * @param type $password
 * @return array 
 */
public function get_ftp_file_list($url,$username,$password){
    $ftp_server = "ftp://" . $username . ":" . $password . "@" . $url;
    $ch = curl_init();
    //curl FTP
    curl_setopt($ch, CURLOPT_URL, $ftp_server);
    //For Debugging
    //curl_setopt($ch, CURLOPT_VERBOSE, TRUE);   
    //SSL Settings
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_FTP_SSL, CURLFTPSSL_TRY);
    //List FTP files and directories
    curl_setopt($ch, CURLOPT_FTPLISTONLY, TRUE);
    //Output to curl_exec
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
   $files = explode("\n", $output); 
   return $files;
}

/**
 *
 * @param array $post
 * @param string $page
 * @param boolean $n Folow Location
 * @param boolean $session set cookie 
 * @param string $referer url
 * @return boolean 
 */
public function post_data_json($post, $posturl, $n=false, $session=false, $referer="",$header=array())
    {
        if(!is_array($post))
        {
            trigger_error('Warning : CURL need array of data');
            return false;
        }
       
        $DATA_POST = curl_init($posturl);
        curl_setopt($DATA_POST, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($DATA_POST, CURLOPT_CUSTOMREQUEST, "POST");
        //curl_setopt($DATA_POST, CURLOPT_URL, $posturl);
        //curl_setopt($DATA_POST, CURLINFO_HEADER_OUT, true);
        //curl_setopt($DATA_POST, CURLOPT_POST, true);
        if($n)
        {
            curl_setopt($DATA_POST, CURLOPT_FOLLOWLOCATION, true);
        }
        if($session)
        {
         curl_setopt($DATA_POST, CURLOPT_COOKIEFILE, 'cookiefile.txt');
         curl_setopt($DATA_POST, CURLOPT_COOKIEJAR, 'cookiefile.txt');
        }
       
        if($referer != "")
        {
         curl_setopt($DATA_POST, CURLOPT_REFERER, $referer);
        }
        $payload = json_encode($post);
        //$payload = http_build_query($post);
        curl_setopt($DATA_POST, CURLOPT_POSTFIELDS, $payload);
        // Set HTTP Header for POST request 
        
        if(count($header)>0){
            curl_setopt($DATA_POST, CURLOPT_HTTPHEADER, $header );
        }else{
            curl_setopt($DATA_POST, CURLOPT_HTTPHEADER, array('Content-Type:application/json') );            
        }
         
        $data = curl_exec($DATA_POST);
        if($data == false)
        {
        trigger_error('Warning : ' . curl_error($DATA_POST));
         curl_close($DATA_POST);
         return false;
        }
        else
        {
         curl_close($DATA_POST);
         return $data;
        }
    } 
    
public function post_data($post, $posturl, $n=false, $session=false, $referer="")
    {
        if(!is_array($post))
        {
            trigger_error('Warning : CURL need array of data');
            return false;
        }
       
        $DATA_POST = curl_init($posturl);
        curl_setopt($DATA_POST, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($DATA_POST, CURLOPT_CUSTOMREQUEST, "POST");
        //curl_setopt($DATA_POST, CURLOPT_URL, $posturl);
        //curl_setopt($DATA_POST, CURLINFO_HEADER_OUT, true);
        //curl_setopt($DATA_POST, CURLOPT_POST, true);
        if($n)
        {
            curl_setopt($DATA_POST, CURLOPT_FOLLOWLOCATION, true);
        }
        if($session)
        {
         curl_setopt($DATA_POST, CURLOPT_COOKIEFILE, 'cookiefile.txt');
         curl_setopt($DATA_POST, CURLOPT_COOKIEJAR, 'cookiefile.txt');
        }
       
        if($referer != "")
        {
         curl_setopt($DATA_POST, CURLOPT_REFERER, $referer);
        }
        //$payload = json_encode($post);
        //$payload = http_build_query($post);
        curl_setopt($DATA_POST, CURLOPT_POSTFIELDS, $post);
        // Set HTTP Header for POST request 
        
        //curl_setopt($DATA_POST, CURLOPT_HTTPHEADER, array('Content-Type:application/json') );
         
        $data = curl_exec($DATA_POST);
        if($data == false)
        {
        trigger_error('Warning : ' . curl_error($DATA_POST));
         curl_close($DATA_POST);
         return false;
        }
        else
        {
         curl_close($DATA_POST);
         return $data;
        }
    } 
/**
 *
 * @param string $url
 * @param array $postdata post data
 * @param string $ref_url 
 * @param boolean $session
 * @param string $proxy proxy server
 * @param boolean $proxystatus use proxy default false
 * @return string 
         $curl = new CURL();
        $headers = array('Content-Type:application/json');
        $ret = $curl->curl_grab_page("https://im.com/api/Device/GetVersion?key=syrurr&imei=". $param,true);
 */
public function curl_grab_page($url,$ssl=false,$headers=array(),$post=false,$postdata=array(),$ref_url='',$session=false,$proxy='',$proxystatus=false){
    if($session) {
        $fp = fopen("cookie.txt", "w");
        fclose($fp);
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
//    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
    curl_setopt($ch, CURLOPT_TIMEOUT, 300);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    if ($proxystatus) {
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, TRUE);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
    }
    if($ssl){
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);        
    }else{
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_REFERER, $ref_url);

    if(count($headers)>0){
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers );
    }
    curl_setopt($ch, CURLOPT_USERAGENT, \SphpBase::sphp_request()->server('HTTP_USER_AGENT'));
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    if($post){
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    }
    $out = curl_exec ($ch); // execute the curl command
    curl_close ($ch);
    unset($ch);
    return $out;
}

}
}
