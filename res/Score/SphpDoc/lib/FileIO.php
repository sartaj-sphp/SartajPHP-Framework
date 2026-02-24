<?php
/**
* Description of FileIO
*
* @author SARTAJ
*/
class FileIO {
public static function fileExists($filePath){}
public static function fileCreate($filePath){}
public static function fileCopy($src,$dst,$overwrite=false){}
public static function fileCopyChanges($src,$dst){}
public static function isSrcFileChange($src,$dst){}
public static function fileWrite($fileURL,$data){}
public static function fileAppend($fileURL,$data){}
public static function fileRead($fileURL){}
public static function getFileExtentionName($fileURL){}
public static function getFileName($fileURL){}
public function isFileExpired($filename,$ttl=0){}
public function openFileBytes($filepath){}
}
?>