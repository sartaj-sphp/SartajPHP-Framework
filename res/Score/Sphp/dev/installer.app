<?php

class installer extends \Sphp\tools\BasicApp{
private $installer1 = null;
private $config1 = null;
private $prop1 = null;

public function onstart() {
    global $admmasterf;
$this->getAuthenticate("ADMIN");
//$this->getSesSecurity();
$this->setMasterFile($admmasterf);
$this->installer1 = new TempFile(SphpBase::$sphp_settings->slib_path . "/apps/plugins/forms/installer.php",false,null,$this);
$this->config1 = new TempFile(SphpBase::$sphp_settings->slib_path . "/apps/plugins/forms/config.php",false,null,$this);
$this->prop1 = new TempFile(SphpBase::$sphp_settings->slib_path . "/apps/plugins/forms/view_plugin.php",false,null,$this);

}
public function directoryCount($src){
$arr=array();
$dir = opendir($src);
while(false !== ( $file = readdir($dir)) ) {
if (( $file != '.' ) && ( $file != '..' )) {
if ( is_dir($src . '/' . $file) ) {
$arr[]= $file;
}

}
}
closedir($dir);
return $arr;
}

public function isPlugExist(){
$plugpath = "plugin/plugin.php";
include_once $plugpath;
if(isset($plug[$this->page->evtp])){
return true;
}else{return false;}
}

private function addPlug($plugpath,$pfrom){
$plugpathf = $plugpath ."plugin.php";
include_once $plugpathf;
$plug[$this->page->evtp] = "$pfrom";
$plugroot = $plug[$this->page->evtp];
if(file_exists("$plugroot/setup/install.php")){
getPluginDB();
include_once("$plugroot/setup/install.php");
getSPDB();
}
$pcode = '<?php
';
$pcode2 = '<?php
';
foreach ($plug as $key=>$val){
if(file_exists("$val/setup/cachelist.php")){
$pcode2 .= file_get_contents("$val/setup/cachelist.php");
}
$pcode .= '$plug["'.$key.'"] = "'.$val.'";
';
}
$pcode .= '?>';
$pcode2 .= '?>';
file_put_contents($plugpathf, $pcode);
file_put_contents($plugpath."ccachelist.php", $pcode2);
$this->createInstaller($plug);
return true;
}

private function updatePlug($plugpath,$pfrom){
$plugpathf = $plugpath ."plugin.php";
include_once $plugpathf;
$plug[$this->page->evtp] = "$pfrom";
$plugroot = $plug[$this->page->evtp];
if(file_exists("$plugroot/setup/update.php")){
getPluginDB();
include_once("$plugroot/setup/update.php");
getSPDB();
}
$pcode = '<?php
';
$pcode2 = '<?php
';
foreach ($plug as $key=>$val){
if(file_exists("$val/setup/cachelist.php")){
$pcode2 .= file_get_contents("$val/setup/cachelist.php");
}
$pcode .= '$plug["'.$key.'"] = "'.$val.'";
';
}
$pcode .= '?>';
$pcode2 .= '?>';
file_put_contents($plugpathf, $pcode);
file_put_contents($plugpath."ccachelist.php", $pcode2);
$this->createInstaller($plug);
return true;
}

private function removePlug($plugpath){
$plugpathf = $plugpath ."plugin.php";
include_once $plugpathf;
if(is_array($plug)){
$plugroot = $plug[$this->page->evtp];
if(file_exists("$plugroot/setup/uninstall.php")){
getPluginDB();
include_once("$plugroot/setup/uninstall.php");
getSPDB();
}
unset($plug[$this->page->evtp]);
$pcode = '<?php
';
$pcode2 = '<?php
';
foreach ($plug as $key=>$val){
if(file_exists("$val/setup/cachelist.php")){
$pcode2 .= file_get_contents("$val/setup/cachelist.php");
}
$pcode .= '$plug["'.$key.'"] = "'.$val.'";
';
}
$pcode .= '?>';
$pcode2 .= '?>';
file_put_contents($plugpathf, $pcode);
file_put_contents($plugpath."ccachelist.php", $pcode2);
$this->createInstaller($plug);
}
}

private function createInstaller($plug){
// count plugin installed
// create files
$mnucode = '';
$mnucodemeb = '';
$mnucodeadm = '';
$permis = '';
$regcode = '<?php
';
foreach ($plug as $key=>$val){
if(file_exists("$val/setup/permis.php")){
$permis .= file_get_contents("$val/setup/permis.php");
}
if(file_exists("$val/setup/menu.php")){
$mnucode .= file_get_contents("$val/setup/menu.php");
}
if(file_exists("$val/setup/admmenu.php")){
$mnucodeadm .= file_get_contents("$val/setup/admmenu.php");
}
if(file_exists("$val/setup/mebmenu.php")){
$mnucodemeb .= file_get_contents("$val/setup/mebmenu.php");
}

if(strpos(" $val",'res')){
$regcode .= 'include_once("'.$this->phppath.'/plugin/'.$key.'/setup/regapp.php");
';
}else{
$regcode .= 'include_once("plugin/'.$key.'/setup/regapp.php");
';
}

}
$regcode .= '
?>';
file_put_contents("plugin/cpermis.php", $permis);
file_put_contents("plugin/cmenu.php", $mnucode);
file_put_contents("plugin/cadmmenu.php", $mnucodeadm);
file_put_contents("plugin/cmebmenu.php", $mnucodemeb);
file_put_contents("plugin/creg.php", $regcode);
}

public function page_event_config($param) {
$plugpath = "plugin/";
$plugpathf = $plugpath ."plugin.php";
$pfrom = "{$this->phppath}/plugin/". $param;
if(file_exists($plugpathf)){
if($this->addPlug($plugpath,$pfrom)){
setMsg('app', "Plugin Installed Succesfully into Your Website");
$this->setTempFile($this->installer1);
}else{
setErr('app', "You are Required fund in your account to purchase this plugin");
$this->setTempFile($this->prop1);
}
}
else{
$this->setTempFile($this->prop1);
}

}

public function page_event_update($param) {
$plugpath = "plugin/";
$plugpathf = $plugpath ."plugin.php";
$pfrom = "{$this->phppath}/plugin/". $param;
if(file_exists($plugpathf)){
if($this->updatePlug($plugpath,$pfrom)){
setMsg('app', "Plugin Updated Succesfully into Your Website");
$this->setTempFile($this->installer1);
}else{
setErr('app', "You are Required fund in your account to purchase this plugin");
$this->setTempFile($this->prop1);
}
}
else{
$this->setTempFile($this->prop1);
}
}

public function page_event_rmp($param) {
$plugpath = "plugin/";
setMsg('dir', "Plugin Uninstalled");
$this->removePlug($plugpath);
//$this->createInstaller();
$this->setTempFile($this->prop1);
}
public function page_event_vw($param) {
$this->setTempFile($this->config1);
}

public function page_new() {
$this->setTempFile($this->prop1);
}
public function page_view() {
$this->page->viewData($form2);
$this->setTempFile($this->prop1);
}



}

