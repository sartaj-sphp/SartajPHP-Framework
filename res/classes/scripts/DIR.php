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

public function directoriesCreate($dirPath){
$ret = false;
$pt = $this->getParentDirectory($dirPath);
if(DIR::directoryExists($pt)){
DIR::directoryCreate($dirPath);    
$ret = true;
    }else{
$this->directoriesCreate($pt);        
DIR::directoryCreate($dirPath);    
$ret = true;
    }
    return $ret;

}
public function isIgnoreFolder($folder,$ignore_folder=array()) {
        return false;
}
public function isIgnoreFile($file,$ignore_file=array()) {
        return false;
}
public function isIgnoreFileExtention($extention,$ignore_file_extentions=array()) {
        return false;
}
public function isNotIgnoreFolder($folder,$lst_folder=array()) {
        return true;
}

public function directoryCopy($src,$dst,$fixdst="",$rev=false,$ignext=array(),$ignfiles=array(),$ignfolders=array()){
    $dir = opendir($src);
    if(!file_exists($dst) && !is_dir($dst)){
        $this->directoriesCreate($dst);
    }
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file)) {
                if($rev && $this->isNotIgnoreFolder($file,$ignfolders)){
                    $this->directoryCopy($src . '/' . $file,$dst . '/' . $file,$fixdst,$rev,$ignext,$ignfiles,$ignfolders);                    
                }else if(! $rev && ! $this->isIgnoreFolder($file,$ignfolders)){
                    $this->directoryCopy($src . '/' . $file,$dst . '/' . $file,$fixdst,$rev,$ignext,$ignfiles,$ignfolders);                    
                }
            }
            else {
                $extname = pathinfo($src.'/'.$file,PATHINFO_EXTENSION);
                $ndst = $dst;
                if($fixdst != "") $ndst = $fixdst; 
                if($rev && ($this->isIgnoreFileExtention($extname,$ignext) || $this->isIgnoreFile($file,$ignfiles))){
                    if(copy($src . '/' . $file,$ndst . '/' . $file)){
                        $this->arr[$file] = $dst . '/' . $file ;
                    }
                }else if(! $rev && ! $this->isIgnoreFileExtention($extname,$ignext) && ! $this->isIgnoreFile($file,$ignfiles)){
                    if(copy($src . '/' . $file,$ndst . '/' . $file)){
                        $this->arr[$file] = $dst . '/' . $file ;
                    }
                }
            }
        }
    }
    closedir($dir);
    return true;
}
public function directoryCopyChanges($src,$dst,$rev=false,$ignext=array(),$ignfiles=array(),$ignfolders=array()){
    $dir = opendir($src);
    if(!file_exists($dst) && !is_dir($dst)){
        $this->directoriesCreate($dst);
    }
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file)) {
                if($rev && $this->isNotIgnoreFolder($file,$ignfolders)){
                    $this->directoryCopyChanges($src . '/' . $file,$dst . '/' . $file,$rev,$ignext,$ignfiles,$ignfolders);
                }else if(! $rev && ! $this->isIgnoreFolder($file,$ignfolders)){
                    $this->directoryCopyChanges($src . '/' . $file,$dst . '/' . $file,$rev,$ignext,$ignfiles,$ignfolders);
                }
            }
            else {
                $extname = pathinfo($src.'/'.$file,PATHINFO_EXTENSION);
                if($rev && ($this->isIgnoreFileExtention($extname,$ignext) || $this->isIgnoreFile($file,$ignfiles))){
                    if((!file_exists($dst . '/' . $file) || (filemtime($src . '/' . $file) > filemtime($dst . '/' . $file))) && copy($src . '/' . $file,$dst . '/' . $file)){
                    }
                }else if(! $rev && ! $this->isIgnoreFileExtention($extname,$ignext) && ! $this->isIgnoreFile($file,$ignfiles)){
                    if((!file_exists($dst . '/' . $file) || (filemtime($src . '/' . $file) > filemtime($dst . '/' . $file))) && copy($src . '/' . $file,$dst . '/' . $file)){
                    }
                }
            }
        }
    }
    closedir($dir);
    return true;
}
public function directorySearch($path,$search,$rev=false,$ignext=array(),$ignfiles=array(),$ignfolders=array())
    {
    $arrf = array();
    $dir = opendir($path);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($path . '/' . $file) ) {
                if($rev && $this->isNotIgnoreFolder($file,$ignfolders)){
                   $arrf = array_merge($arrf,$this->directorySearch($path . '/' . $file,$search,$rev,$ignext,$ignfiles,$ignfolders));
                }else if(!$rev && ! $this->isIgnoreFolder($file,$ignfolders)){
                   $arrf = array_merge($arrf,$this->directorySearch($path . '/' . $file,$search,$rev,$ignext,$ignfiles,$ignfolders));
                }
            }
            else {
                if(stripos(" $file",$search)>0){
                    $extname = pathinfo($path.'/'.$file,PATHINFO_EXTENSION);
                    if($rev && ($this->isIgnoreFileExtention($extname,$ignext) || $this->isIgnoreFile($file,$ignfiles))){
                        $arrf[] = array($path ,$file) ;
                    }else if(!$rev && ! $this->isIgnoreFileExtention($extname,$ignext) && ! $this->isIgnoreFile($file,$ignfiles)){
                        $arrf[] = array($path ,$file) ;
                    }
                }
            }
        }
    }
    closedir($dir);
    return $arrf;
}
public function directoryCount($src)
    {
$arr=array();
$dir = opendir($src);
if($dir){
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                $arr[$file]= $file;
            }

        }
    }
}
    closedir($dir);
    sort($arr);
    return $arr;
}
public function fileCount($src)
    {
$arr = array();
$dir = opendir($src);
if($dir){
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_file($src . '/' . $file) ) {
                $arr[$file]= $file;
            }
        }
    }
}
    closedir($dir);
    sort($arr);
    return $arr;
}
public function RecursiveSearch($basepath,$subpath,$callback=null){
    $path = $basepath . '/' . $subpath;
    $dir = opendir($path);
    if($dir){
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($path . '/' . $file) ) {
               $this->RecursiveSearch($basepath,$subpath . '/' . $file,$callback);
            }else {
                if($callback != null){
                    $callback($subpath,$file) ;
                }
            }
        }
    }
    closedir($dir);
    }
}
public function getParentDirectory($path) {
    // Detect backslashes
$convert_backslashes = false;
$backslash = false;
if( strstr($path, '\\') ) $backslash = true;
    // Convert backslashes to forward slashes
    $path = str_replace('\\', '/', $path);
    // Add trailing slash if non-existent
    if( substr($path, strlen($path) - 1) != '/' ) $path .= '/';
    // Determine parent path
    $path = substr($path, 0, strlen($path) - 1);
    $path = substr( $path, 0, strrpos($path, '/') ) . '/';
    // Convert backslashes back
    if( !$convert_backslashes && $backslash ) $path = str_replace('/', '\\', $path);
    return $path;
}

public function getParentDirectoryName($path) {
    // Detect backslashes
    $path = $this->getParentDirectory($path);

$dirName = explode('/',$path);
return $dirName[count($dirName)-2];
}

public function directoryDelete($dirname) {
    if (is_dir($dirname))
       $dir_handle = opendir($dirname);
    if (!$dir_handle)
       return false;
    while($file = readdir($dir_handle)) {
       if ($file != "." && $file != "..") {
          if (!is_dir($dirname."/".$file))
             unlink($dirname."/".$file);
          else
             $this->directoryDelete($dirname.'/'.$file);
       }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
 }

}

