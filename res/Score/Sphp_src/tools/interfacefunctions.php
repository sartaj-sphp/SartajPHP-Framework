<?php
namespace{
// dummy interface classess for old files
class FrontFile extends Sphp\tools\FrontFile { }
//class WebApp extends Sphp\tools\WebApp { }
//class DTable extends Sphp\comp\data\DTable { }
//class Ajaxsenddata extends Sphp\comp\ajax\Ajaxsenddata { }
/**
 * Generate URL for a Appgate
 * @param string $AppgateName Appgate like index
 * @param string $extra <P> Extra query string in URL 
 * $extra = 'test=1&mpid=13'
 * </p>
 * @param string $newbasePath <p> new domain url
 * $newbasePath = 'https://domain.com/test
 * </p>
    * @param boolean $blnSesID Add session id default false, url expired with session (App can allow expired url)
    * @param string $ext change url file extension as app default empty and use html or set in comp file.
    * @param boolean $noncache default false, if true, cache can not save this url in browser or in proxy
 * @return string
 */
function getAppURL($AppgateName,$extra="",$newbasePath="",$blnSesID=false,$ext='',$noncache=false){
    return SphpBase::sphp_router()->getAppURL($AppgateName,$extra,$newbasePath,$blnSesID,$ext,$noncache);
}
/**
 * Generate URL for Current Application
 * @param string $extra <P> Extra query string in URL 
 * $extra = 'test=1&mpid=13'
 * </p>
    * @param boolean $blnSesID Add session id default false, url expired with session (App can allow expired url)
    * @param string $ext change url file extension as app default empty and use html or set in comp file.
    * @param boolean $noncache default false, if true, cache can not save this url in browser or in proxy
 * @return string
 */
function getThisURL($extra="",$blnSesID=false,$ext='',$noncache=false){
    return SphpBase::sphp_router()->getThisURL($extra,$blnSesID,$ext,$noncache);
}

/**
 * Generate Secure URL for a Event of Application
 * @param string $eventName <p> Name of Event
 * class index extends Sphp\tools\BasicApp{
 * public function page_event_test($evtp){
 * 
 * }
 * }
 * $eventName = test
 * $AppgateName = index
 * Registered Application = apps/index.app
 * </p>
 * @param string $evtp Event Parameter pass to URL
 * @param string $AppgateName Appgate like index
 * @param string $extra <P> Extra query string in URL 
 * $extra = 'test=1&mpid=13'
 * </p>
 * @param string $newbasePath <p> new domain url
 * $newbasePath = 'https://domain.com/test
 * </p>
    * @param boolean $blnSesID Add session id default false, url expired with session (App can allow expired url)
    * @param string $ext change url file extension as app default empty and use html or set in comp file.
    * @param boolean $noncache default false, if true, cache can not save this url in browser or in proxy
 * @return string
 */
function getEventURLSecure($eventName,$evtp="",$AppgateName="",$extra="",$newbasePath="",$blnSesID=false,$ext='',$noncache=false){
    return SphpBase::sphp_router()->getEventURLSecure($eventName,$evtp,$AppgateName,$extra,$newbasePath,$blnSesID,$ext,$noncache);
}

/**
 * Generate URL for a Event of Application
 * @param string $eventName <p> Name of Event
 * class index extends Sphp\tools\BasicApp{
 * public function page_event_test($evtp){
 * 
 * }
 * }
 * $eventName = test
 * $AppgateName = index
 * Registered Application = apps/index.app
 * </p>
 * @param string $evtp Event Parameter pass to URL
 * @param string $AppgateName Appgate like index
 * @param string $extra <P> Extra query string in URL 
 * $extra = 'test=1&mpid=13'
 * </p>
 * @param string $newbasePath <p> new domain url
 * $newbasePath = 'https://domain.com/test
 * </p>
    * @param boolean $blnSesID Add session id default false, url expired with session (App can allow expired url)
    * @param string $ext change url file extension as app default empty and use html or set in comp file.
    * @param boolean $noncache default false, if true, cache can not save this url in browser or in proxy
 * @return string
 */
function getEventURL($eventName,$evtp="",$AppgateName="",$extra="",$newbasePath="",$blnSesID=false,$ext='',$noncache=false){
    return SphpBase::sphp_router()->getEventURL($eventName,$evtp,$AppgateName,$extra,$newbasePath,$blnSesID,$ext,$noncache);
}
function getCurrentRequest(){
   return SphpBase::sphp_router()->getCurrentRequest();
}
function isRegisterCurrentRequest(){
   return SphpBase::sphp_router()->isRegisterCurrentRequest();
}
function registerCurrentRequest($apppath,$s_namespace="",$permtitle="",$permlist=null){
   SphpBase::sphp_router()->registerCurrentRequest($apppath,$s_namespace,$permtitle,$permlist);
}
function registerCurrentAppgate($ctrl){
   SphpBase::sphp_router()->registerCurrentAppgate($ctrl);
}
function registerApp($ctrl,$apppath,$s_namespace="",$permtitle="",$permlist=null){
   SphpBase::sphp_api()->registerApp($ctrl,$apppath,$s_namespace,$permtitle,$permlist);
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
function addFileLink($fileURL,$renderonce=false,$aname="",$ext="",$ver="0",$assets=array()){
    SphpBase::sphp_api()->addFileLink($fileURL,$renderonce,$aname,$ext,$ver,$assets);
}
function updateFileLink($fileURL,$renderonce=false,$aname="",$ext="",$ver="0",$assets=array()){
    SphpBase::sphp_api()->updateFileLink($fileURL,$renderonce,$aname,$ext,$ver,$assets);
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

function setFrontPlacePath($frontname, $basepath, $secname = "left", $type = "FrontFile") {
    SphpBase::sphp_api()->setFrontPlacePath($frontname, $basepath, $secname , $type);    
}

function removeFrontPlace($frontname, $secname = "left") {
    SphpBase::sphp_api()->removeFrontPlace($frontname, $secname);    
}

function addFrontPlace($frontname, $filepath = "", $secname = "left", $type = "FrontFile") {
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

function renderFrontPlaceManually($frontname, $secname = "left") {
    return SphpBase::sphp_api()->renderFrontPlaceManually($frontname, $secname);    
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
/**
 * 
 * @param string $string
 * @param string $key
 * @return string
 */
function encryptme($string, $key = "BA007231") {
    return SphpBase::sphp_api()->encrypt($string, $key);    
}
/**
 * 
 * @param string $str
 * @param string $ky
 * @return string
 */
function endec($str, $ky = "CD098ABA") {
    return SphpBase::sphp_api()->endec($str, $ky);    
}
function is_valid_num($val,$datatype){
    return SphpBase::sphp_api()->is_valid_num($val,$datatype);    
}
function is_valid_email($email){
    return SphpBase::sphp_api()->is_valid_email($email);    
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
