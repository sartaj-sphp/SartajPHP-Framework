<?php
/**
* Description of FileIO
*
* @author SARTAJ
*/
class FileIO {
public static function fileExists($filePath){
$ret = false;
if(file_exists($filePath) && !is_dir($filePath)){
$ret = true;
}
return $ret;
}
public static function fileCreate($filePath){
$FileHandle = fopen($filePath, 'w') or die("can't create file $filePath");
fclose($FileHandle);
}
public static function fileCopy($src,$dst,$overwrite=false){
$ret = false;
if($overwrite){
$cop = copy($src,$dst);
}else{
if(!file_exists($src)){
$cop = copy($src,$dst);
}else{
error_log("$src File Already Exists", 0);
}
}
if($cop){
$ret = true;
}
return $ret;
}
public static function fileWrite($fileURL,$data){
$ret = false;
if(file_put_contents($fileURL, $data)){
$ret = true;
}
return $ret;
}
public static function fileAppend($fileURL,$data){
$ret = false;
if(file_put_contents($fileURL, $data, FILE_APPEND)){
$ret = true;
}
return $ret;
}
public static function fileRead($fileURL){
$strOut = file_get_contents($fileURL);
return $strOut;
}
public static function getFileExtentionName($fileURL){
$rt = strripos($fileURL,'.');
$ext = substr($fileURL,$rt+1,strlen($fileURL)-$rt-1);
return $ext;
}
public static function getFileName($fileURL){
$file = basename($fileURL);         
return $file;
}
public function isFileExpired($filename,$ttl=0){}
public function openFileBytes($filepath){}
}
?>