<?php
namespace Sphp\Gates{
/**
* Description of MobileApp
*
* @author Sartaj Singh
*/
require_once(\SphpBase::sphpSettings()->libPath . "/Sphp/Lib/Dir.php");
require_once(\SphpBase::sphpSettings()->libPath . "/Sphp/Lib/Dir.php");
include_once(\SphpBase::sphpSettings()->libPath . "/Sphp/Lib/HtmlMinifier.php");
/**
* MobileGate is a gate class for building mobile (Android) applications with SartajPHP.
* It extends BasicGate and provides support for generating Android project files,
* managing mobile app metadata, publishing Android apps, and handling mobile-specific
* events and resource distribution.
*/
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
public $sphpApi = null;
public $cfilename = "";
public $dir = null;
public $fileio = null;
public $curdirpath = "";
public $compoutpath = "";
/**
* Constructor for MobileGate.
* Initializes the gate with mobile app settings, sets up directories,
* and prepares the environment for mobile app generation.
*/
/**
* Sets the root folder for generated files.
* @param string $param The root folder path.
*/
public function setGenRootFolder($param) {}
/**
* Sets the special meta tag for the mobile app.
* @param string $val The meta tag content.
*/
public function setSpecialMetaTag($val) {}
/**
* Set Distribute multi js css files rather then single
*/
public function setMultiFiles() {}
/**
* Sets up the front object for the gate.
* @param object $frontobj The front object to set up.
*/
/**
* Adds a page to the mobile app.
* @param object $pageobj The page object to add.
*/
public function addPage($pageobj) {}
/**
* Adds a distribution library folder.
* @param string $folderpath The folder path to add.
*/
public function addDistLib($folderpath) {}
/**
* Add Android Settings Line to build.gradle.kts file. You can over write with same line of code.
* Section Name $sectionName define Array key to group related Items when use renderAndroidSettings
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
* @param string $sectionName where to insert code
* @param string $permLine
*/
public function addAndroidSetting($sectionName, $permLine){}
/**
* Renders Android settings for a given section.
* @param string $sectionName The section name to render.
* @return string The rendered settings string.
*/
public function renderAndroidSettings($sectionName){}
/**
* Insert Lib File Android into libs folder
* @param string $srcfile file for copy from
* @param string $destdir Optional relative Dir for copy to sub folder under libs folder. Default is root of libs folder
*/
public function addAndroidLibFile($srcfile,$destdir=""){}
/**
* Adds an Android library directory.
* @param string $srcdir The source directory.
* @param string $destdir The destination directory.
*/
public function addAndroidLibDir($srcdir,$destdir=""){}
/**
* Adds a Kotlin gate file.
* @param string $srcfile The source file path.
*/
public function addKotlinGate($srcfile){}
/**
* Adds a Kotlin directory.
* @param string $srcdir The source directory.
*/
public function addKotlinDir($srcdir){}
/**
* Adds a C++ directory.
* @param string $srcdir The source directory.
*/
public function addCppDir($srcdir){}
/**
* Adds a Java directory.
* @param string $srcdir The source directory.
*/
public function addJavaDir($srcdir){}
/**
* Shifts component generated files.
*/
/**
* Copies component generated directories.
* @param array $arr The array of directories to copy.
* @param string $dest The destination path.
*/
/**
* Copies component generated files.
* @param array $arr The array of files to copy.
* @param string $dest The destination path.
*/
/**
* Processes the front object.
* @param object $frontobj The front object to process.
*/
public function process($frontobj){}
/**
* Processes events for the gate.
*/
public function processEvent(){}
/**
* Calls page events for the gate.
*/
protected function callPageEvents(){}
/**
* Compiles and runs the project.
*/
/**
* Gets the auto version for the mobile app.
*/
/**
* Force Copy and Generate Mobile app Files from Source. This can over write Android project files from
* source forcefully.
*/
protected function setForceCopyGen(){}
/**
* Project will compile and run by Android Studio
*/
protected function enableAndroidStudio(){}
/**
* Enables Sphp Mobile support.
*/
protected function enableSphpMobile(){}
/**
* Disables Android Studio support.
*/
protected function disableAndroidStudio(){}
/**
* Publishes the Android app.
* @param string $curdirpath The current directory path.
*/
protected function publishAndroidApp($curdirpath) {}
/**
* Generates auto register JSON for Kotlin gates.
* @param array $patha The paths to scan for Kotlin gates.
* @param string $outputpath The output path for the JSON file.
*/
/**
* Sends render data for the mobile app.
*/
protected function sendRenderData() {}
/**
* Runs the gate.
*/
/**
* Renders the gate.
*/
/**
* Sets the class path for the gate.
*/
public function setClassPath() {}
/**
* Sets up mobile events for the gate.
*/
/**
* Loads a JavaScript library.
* @param string $filename The filename to write to.
* @param string $subpath The subpath to load from.
* @param bool $overwrite Whether to overwrite the file.
*/
/**
* Creates combo files for the mobile app.
*/
/**
* Loads a JavaScript PHP library.
* @param string $filename The filename to write to.
* @param string $subpath The subpath to load from.
* @param bool $overwrite Whether to overwrite the file.
*/
}
}
