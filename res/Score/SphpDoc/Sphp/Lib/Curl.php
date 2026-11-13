<?php
namespace Sphp\Lib{
/**
* Curl
*
* A helper class wrapping PHP's cURL extension to fetch and post data over
* HTTP/HTTPS and FTPES (FTP explicit SSL). It provides methods to download
* URL content, list FTP server files, send JSON or form POST requests, and
* grab a page with optional SSL, proxy, session cookie and header handling.
*/
class Curl{
/**
* Fetch any url Data
* @param string $url
* @param boolean $bin default false
* @return string 
*/
public function getUrlData($url,$bin=false)
{}
/**
* Get List of Directories,Files From FTPES (FTP explicit SSL) FTP Server
* @param type $url
* @param type $username
* @param type $password
* @return array 
*/
public function getFtpFileList($url,$username,$password){}
/**
*
* @param array $post
* @param string $page
* @param boolean $n Folow Location
* @param boolean $session set cookie 
* @param string $referer url
* @return boolean 
*/
public function postDataJson($post, $posturl, $n=false, $session=false, $referer="",$header=array())
{} 
/**
* Send a form-encoded POST request to the given URL.
* @param array $post
* @param string $posturl
* @param boolean $n Folow Location
* @param boolean $session set cookie 
* @param string $referer url
* @return string|boolean
*/
public function postData($post, $posturl, $n=false, $session=false, $referer="")
{} 
/**
*
* @param string $url
* @param array $postdata post data
* @param string $refUrl 
* @param boolean $session
* @param string $proxy proxy server
* @param boolean $proxystatus use proxy default false
* @return string 
$curl = new CURL();
$headers = array('Content-Type:Gate/json');
$ret = $curl->curl_grab_page("https://im.com/api/Device/GetVersion?key=syrurr&imei=". $param,true);
*/
public function curlGrabPage($url,$ssl=false,$headers=array(),$post=false,$postdata=array(),$refUrl='',$session=false,$proxy='',$proxystatus=false){}
}
}
