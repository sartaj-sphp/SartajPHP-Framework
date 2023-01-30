<?php
/**
* Description of DIR
*
* @author SARTAJ
*/
class DIR {
public $arr = Array();
public static function directoryExists($dirPath){
$ret = false;
if(file_exists($dirPath) && is_dir($dirPath)){
$ret = true;
}
return $ret;
}
public static function directoryCreate($dirPath){
$ret = false;
if(!file_exists($dirPath) && mkdir($dirPath)){
chmod($dirPath, 0775);
$ret = true;
}
return $ret;
}
public function directoriesCreate($dirPath){}
public function isIgnoreFolder($folder,$ignore_folder=array()) {}
public function isIgnoreFile($file,$ignore_file=array()) {}
public function isIgnoreFileExtention($extention,$ignore_file_extentions=array()) {}
public function isNotIgnoreFolder($folder,$lst_folder=array()) {}
public function directoryCopy($src,$dst,$fixdst="",$rev=false,$ignext=array(),$ignfiles=array(),$ignfolders=array()){}
public function directoryCopyChanges($src,$dst,$rev=false,$ignext=array(),$ignfiles=array(),$ignfolders=array()){}
public function directorySearch($path,$search,$rev=false,$ignext=array(),$ignfiles=array(),$ignfolders=array())
{}
public function directoryCount($src)
{}
public function fileCount($src)
{}
public function RecursiveSearch($basepath,$subpath,$callback=null){}
public function getParentDirectory($path) {}
public function getParentDirectoryName($path) {}
public function directoryDelete($dirname) {}
}
