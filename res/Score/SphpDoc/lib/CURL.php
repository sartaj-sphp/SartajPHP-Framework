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
{}
/**
* Get List of Directories,Files From FTPES (FTP explicit SSL) FTP Server
* @param type $url
* @param type $username
* @param type $password
* @return array 
*/
public function get_ftp_file_list($url,$username,$password){}
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
{} 
public function post_data($post, $posturl, $n=false, $session=false, $referer="")
{} 
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
public function curl_grab_page($url,$ssl=false,$headers=array(),$post=false,$postdata=array(),$ref_url='',$session=false,$proxy='',$proxystatus=false){}
}
}
