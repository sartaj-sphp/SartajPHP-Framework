<?php
namespace Sphp\tools{
/**
* Description of MobileApp
*
* @author Sartaj Singh
*/
require_once(\SphpBase::sphp_settings()->lib_path . "/lib/DIR.php");
require_once(\SphpBase::sphp_settings()->lib_path . "/lib/FileIO.php");
include_once(\SphpBase::sphp_settings()->lib_path . "/lib/HtmlMinifier.php");
class MobileGate extends BasicGate{
public $mobappversion = "0.0.1";    
public $mobappname = "HelloSphp";
public $mobappid = "com.sartajphp.view";
public $mobappdes = "A sample SartajPhp app that run on Android Mobile.";
public $mobappauthor = "SartajPhp Team";
public $mobappauthoremail = "sartaj@sartajsingh.com";
public $mobappauthorweb = "https://sartajphp.com";
public $minSdkVersion = "25";
public $targetSdkVersion = "34";
public $compileSdkVersion = "34";
public $sjsobj = array();
public $blnsjsobj = true;
public $sphp_api = null;
public $cfilename = "";
public $dir = null;
public $fileio = null;
public $curdirpath = "";
public $compoutpath = "";
public function setGenRootFolder($param) {}
public function setSpecialMetaTag($val) {}
/**
* Set Distribute multi js css files rather then single
*/
public function setMultiFiles() {}
public function addPage($pageobj) {}
public function addDistLib($folderpath) {}
/**
* Add Android Settings Line to build.gradle.kts file. You can over write with same line of code.
* Section Name $section_name define Array key to group related Items when use renderAndroidSettings
*  used Section Names list are:- permission(config.xml file permission code),
*  app(config.xml file app tag inner XML code),
*  plugins(build.gradle.kts file plugins code),
*  android(build.gradle.kts file android code),
*  dependency(build.gradle.kts file dependency code)
*  You can create your own
*  Example Pass as string:- 
* permission:-   <uses-permission android:name="android.permission.INTERNET"/>
*  Dependency:- implementation("androidx.core:core-ktx:1.10.0")
* Android setting:- composeOptions {
kotlinCompilerExtensionVersion = "1.5.1"
}
* 
* @param string $section_name where to insert code
* @param string $perm_line
*/
public function addAndroidSetting($section_name, $perm_line){}
public function renderAndroidSettings($section_name){}
/**
* Insert Lib File Android into libs folder
* @param string $srcfile file for copy from
* @param string $destdir Optional relative Dir for copy to sub folder under libs folder. Default is root of libs folder
*/
public function addAndroidLibFile($srcfile,$destdir=""){}
public function addAndroidLibDir($srcdir,$destdir=""){}
public function addKotlinGate($srcfile){}
public function addKotlinDir($srcdir){}
public function addCppDir($srcdir){}
public function addJavaDir($srcdir){}
public function process($frontobj){}
public function processEvent(){}
/**
* Force Copy and Generate Mobile app Files from Source. This can over write Android project files from
* source forcefully.
*/
protected function setForceCopyGen(){}
/**
* Project will compile and run by Android Studio
*/
protected function enableAndroidStudio(){}
protected function disableAndroidStudio(){}
protected function publishAndroidApp($curdirpath) {}
protected function sendRenderData() {}
public function setClassPath() {}
}
}
