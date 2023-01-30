<?php
namespace{
class TempFile extends Sphp\tools\TempFile { }
class Control extends Sphp\tools\Control { }
function getAppPath($ControllerName,$extra="",$newbasePath="",$blnSesID=false){
return SphpBase::sphp_router()->getAppURL($ControllerName,$extra,$newbasePath,$blnSesID);
}
function getThisPath($extra="",$blnSesID=false){
return SphpBase::sphp_router()->getThisURL($extra,$blnSesID);
}
function getEventPath($eventName,$evtp="",$ControllerName="",$extra="",$newbasePath="",$blnSesID=false){
return SphpBase::sphp_router()->getEventURL($eventName,$evtp,$ControllerName,$extra,$newbasePath,$blnSesID);
}
function getCurrentRequest(){
return SphpBase::sphp_router()->getCurrentRequest();
}
function isRegisterCurrentRequest(){
return SphpBase::sphp_router()->isRegisterCurrentRequest();
}
function registerCurrentRequest($apppath,$s_namespace=""){
SphpBase::sphp_router()->registerCurrentRequest($apppath,$s_namespace);
}
function registerCurrentController($ctrl){
SphpBase::sphp_router()->registerCurrentController($ctrl);
}
function registerApp($ctrl,$apppath,$s_namespace=""){
SphpBase::sphp_api()->registerApp($ctrl,$apppath,$s_namespace);
}
function isRegisterApp($ctrl){
return SphpBase::sphp_api()->isRegisterApp($ctrl);
}
function setSession($lType,$uid1){
SphpBase::sphp_session()->setSession($lType,$uid1);
}
function destSession(){
SphpBase::sphp_session()->destSession();
}
function addFileLink($fileURL,$renderonce=false,$aname="",$ext="",$ver="0"){
SphpBase::sphp_api()->addFileLink($fileURL,$renderonce,$aname,$ext,$ver);
}
function updateFileLink($fileURL,$renderonce=false,$aname="",$ext="",$ver="0"){
SphpBase::sphp_api()->updateFileLink($fileURL,$renderonce,$aname,$ext,$ver);
}
function removeFileLink($fileURL,$renderonce=false,$aname="",$ext=""){
SphpBase::sphp_api()->removeFileLink($fileURL,$renderonce,$aname,$ext);
}
function addFileLinkCode($name,$code,$renderonce=false){
SphpBase::sphp_api()->addFileLinkCode($name,$code,$renderonce);
}
function issetFileLink($filename, $ext, $renderonce = false) {
return SphpBase::sphp_api()->issetFileLink($filename, $ext,$renderonce);
}
function isHeaderJSFunctionExist($funname, $rendertype = "private") {
return SphpBase::sphp_api()->isHeaderJSFunctionExist($funname, $rendertype);
}
function isFooterJSFunctionExist($funname, $rendertype = "private") {
return SphpBase::sphp_api()->isFooterJSFunctionExist($funname, $rendertype);
}
function addHeaderJSFunction($funname, $startcode, $endcode, $renderonce = false) {
SphpBase::sphp_api()->addHeaderJSFunction($funname, $startcode, $endcode, $renderonce);
}
function addFooterJSFunction($funname, $startcode, $endcode, $renderonce = false) {
SphpBase::sphp_api()->addFooterJSFunction($funname, $startcode, $endcode, $renderonce);
}
function addHeaderJSFunctionCode($funname, $name, $code, $renderonce = false) {
SphpBase::sphp_api()->addHeaderJSFunctionCode($funname, $name, $code, $renderonce);
}
function addFooterJSFunctionCode($funname, $name, $code, $renderonce = false) {
SphpBase::sphp_api()->addFooterJSFunctionCode($funname, $name, $code, $renderonce);
}
function addHeaderJSCode($name, $code, $renderonce = false) {
SphpBase::sphp_api()->addHeaderJSCode($name, $code, $renderonce);
}
function addHeaderCSS($name, $code, $renderonce = false) {
SphpBase::sphp_api()->addHeaderCSS($name, $code, $renderonce);
}
function addFooterJSCode($name, $code, $renderonce = false) {
SphpBase::sphp_api()->addFooterJSCode($name, $code, $renderonce);
}
function getHeaderHTML($htmltag=true,$global=true,$blockJSCode = 0){
return SphpBase::sphp_api()->getHeaderHTML($htmltag,$global,$blockJSCode);    
}
function getFooterHTML($htmltag = true, $global = true,$blockJSCode = 0) {
return SphpBase::sphp_api()->getFooterHTML($htmltag,$global,$blockJSCode);     
}
function traceError($blnDontJS = false) {
return SphpBase::sphp_api()->traceError($blnDontJS);    
}
function setErr($name, $msg) {
SphpBase::sphp_api()->setErr($name, $msg);    
}
function getCheckErr() {
return SphpBase::sphp_api()->getCheckErr();    
}
function unsetCheckErr() {
SphpBase::sphp_api()->unsetCheckErr();    
}
function getErrMsg($name) {
return SphpBase::sphp_api()->getErrMsg($name);    
}
function traceMsg($blnDontJS = false) {
return SphpBase::sphp_api()->traceMsg($blnDontJS);        
}
function setMsg($name, $msg) {
SphpBase::sphp_api()->setMsg($name, $msg);    
}
function getMsg($name) {
return SphpBase::sphp_api()->getMsg($name);    
}
function traceErrorInner($blnDontJS = false) {
return SphpBase::sphp_api()->traceErrorInner($blnDontJS);    
}
function setErrInner($name, $msg) {
SphpBase::sphp_api()->setErrInner($name, $msg);    
}
function getErrMsgInner($name) {
return SphpBase::sphp_api()->getErrMsgInner($name);    
}
function setFrontPlacePath($frontname, $basepath, $secname = "left", $type = "TempFile") {
SphpBase::sphp_api()->setFrontPlacePath($frontname, $basepath, $secname , $type);    
}
function removeFrontPlace($frontname, $secname = "left") {
SphpBase::sphp_api()->removeFrontPlace($frontname, $secname);    
}
function addFrontPlace($frontname, $filepath = "", $secname = "left", $type = "TempFile") {
SphpBase::sphp_api()->addFrontPlace($frontname, $filepath , $secname , $type);    
}
function getFrontPlace($frontname, $secname = "left") {
return SphpBase::sphp_api()->getFrontPlace($frontname, $secname);    
}
function runFrontPlace($frontname, $secname = "left") {
SphpBase::sphp_api()->runFrontPlace($frontname, $secname);    
}
function renderFrontPlace($frontname, $secname = "left") {
SphpBase::sphp_api()->renderFrontPlace($frontname, $secname);    
}
function runFrontSection($secname = "left") {
SphpBase::sphp_api()->runFrontSection($secname);    
}
function addrunFrontSection($secname = "left") {
SphpBase::sphp_api()->addrunFrontSection($secname);    
}
function ListNotrenderFrontSection($secname = "left") {
SphpBase::sphp_api()->ListNotrenderFrontSection($secname);    
}
function renderFrontSection($secname = "left") {
SphpBase::sphp_api()->renderFrontSection($secname);    
}
function encrypt($string, $key = "BA007231") {
return SphpBase::sphp_api()->encrypt($string, $key);    
}
function decrypt($string, $key = "BA007231") {
return SphpBase::sphp_api()->decrypt($string, $key);    
}
function endec($str, $ky = "") {
return SphpBase::sphp_api()->endec($str, $ky);    
}
function is_valid_num($val,$datatype){
return SphpBase::sphp_api()->is_valid_num($val,$datatype);    
}
function is_valid_email($email){
return SphpBase::sphp_api()->is_valid_email($email);    
}
function executePHPScript($strPHPScript) {
extract($GLOBALS, EXTR_REFS);
if (strpos($strPHPScript, "?php") > 0) {
ob_start();
eval("?>" . $strPHPScript);
$result = ob_get_contents();
ob_end_clean();
return($result);
} else {
return $strPHPScript;
}
}
function executePHPCode($strPHPCode,$blnNoGlobal=true) {
if($blnNoGlobal){
extract($GLOBALS, EXTR_REFS);
}
try{ 
ob_start(); 
eval('?>' . $strPHPCode);
$result = ob_get_contents();
ob_end_clean();        
return($result);
} catch (\Throwable $e) {
throw new Exception($e->getMessage() . ' in File:- ' . $e->getFile() . ' line:- ' . $e->getLine());
}catch(\Exception $e){
throw new Exception($e->getMessage() . ' in File:- ' . $e->getFile() . ' line:- ' . $e->getLine());
}
}
function executePHP($strPHPCode) {
extract(getGlobals(), EXTR_REFS);
ob_start();
eval($strPHPCode);
$result = ob_get_contents();
ob_end_clean();
return($result);
}
function executePHPGlobal($strPHPCode) {
extract(getGlobals(), EXTR_REFS);
eval($strPHPCode);
}
function executePHPFunc($strPHPCode) {
extract(getGlobals(), EXTR_REFS);
ob_start();
eval("$" . "retpfuphp = " . $strPHPCode);
$result = ob_get_contents();
ob_end_clean();
$retpfuphp = $this->getGlobal("retpfuphp");
return $result . $retpfuphp;
}
function getKeyword(){
return SphpBase::sphp_settings()->getKeyword();
}
function genAutoText($para,$paraRepeated=1,$startIndex=1){
return SphpBase::sphp_settings()->genAutoText($para,$paraRepeated,$startIndex);
}
function stopOutput(){
SphpBase::engine()->stopOutput();
}
}
