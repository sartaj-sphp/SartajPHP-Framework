<?php
/**
 * Description of Grid
 *
 * @author SARTAJ
 */
//namespace Sphp\comp\data;
namespace{

class Grid extends \Sphp\tools\Component{
public $pageNo = -1;
public $totalPages = 1;
public $perPageRows = 10;
public $sql = '';
public $pageCountSQL = '';
public $result;
public $row;
public $linkno = 10;
public $extraData = '';
public $strFormat = '';
public $fieldNames = '';
public $headNames = '';
public $colwidths = '';
public $where = '';
public $app = '';
public $blnEdit = false;
public $blnDelete = false;
public $cacheTime = 0;
private $eventName = 'show';
private $evtp='';
private $gate='';
private $extra='page=';
private $baseName='';
private $sesID=false;
private $blnajax = false;
private $blndlg = true;
private $cachefile = '';
private $cachekey = 'id';
private $cachesave = false;
private $header = '';
private $footer = '';

protected function onit() {
$page = \SphpBase::page();
$sphp_router = \SphpBase::sphp_router();
$gate = $sphp_router->gate;
$tblName = \SphpBase::page()->tblName;
$JSServer = \SphpBase::JSServer();
$Client = \SphpBase::sphp_request();

if(SphpBase::page()->isSesSecure){
$this->sesID = true;
}
$this->blnajax = true;
$this->eventName = $name ."_show";
$JSServer->getAJAX();
if($Client->isRequest($name.'page')){
\SphpBase::sphp_request()->session($name.'p', \SphpBase::sphp_request()->request($name.'page'));
\SphpBase::sphp_request()->session($name.'pc', $gate);
}else{
if($Client->session($name.'pc') == $gate){
\SphpBase::sphp_request()->request($name.'page', \SphpBase::sphp_request()->session($name.'p'));
}
}
$this->pageNo = $Client->request($name.'page') - 1;
$this->dtable = $tblName;
$this->setHTMLName('');
}

public function handleEvents(){
    extract(getGlobals(), EXTR_REFS);
    $page = \SphpBase::page();
    $JSServer = \SphpBase::JSServer();
    $genFormFront = readGlobal("genFormFront");
if(SphpBase::page()->isevent)
{
switch(SphpBase::page()->getEvent()){
case $this->name.'_show':{
$JSServer->addJSONComp($this,'showalledtif');
break;
}
case $this->name.'_newa':{
$JSServer->addJSONFront($genFormFront,'showalledtif');
break;
}
}
}

}

public function getEventURL($eventName, $evtp='', $Appgate='', $extra='', $newBasePath='', $blnSesID=false){
$this->eventName = $eventName;
$this->evtp=$evtp;
$this->gate=$Appgate;
if($extra!=''){
$this->extra=$extra.'&'.$this->name.'page=';
}
$this->baseName=$newBasePath;
$this->sesID=$blnSesID;
    }

    protected function genhelpPropList() {
        $this->addHelpPropFunList('getEventURL','Set Event Path to get page', getEventURL($this->eventName, $this->evtp, $this->gate, $this->extra, $this->baseName, $this->sesID),'$eventName, $evtp="", $Appgate="", $extra="", $newBasePath="", $blnSesID=false');
        $this->addHelpPropFunList('setMsgName','Name Display in placeholder and Error','','$val');
        $this->addHelpPropFunList('setSQL','Set SQL Database Query','','$sql');
        $this->addHelpPropFunList('setPageCountSQL','Set SQL Query for Count Page, only need to set if you use setSQL','','$sql');
        $this->addHelpPropFunList('setPerPageRows','Set Per Page Rows Display','','$val');
        $this->addHelpPropFunList('setExtraData','Set Extra query string to post server with every page request','','$sql');
        $this->addHelpPropFunList('setCacheKey','Set Key for Cache default is id','','$val');
        $this->addHelpPropFunList('setCacheTime','Set Cache Expiry Time 0 mean no cache and -1 mean always data from cache','','$val');
        $this->addHelpPropFunList('setFieldNames','comma separated list for Database Table field name for auto sql, no need to setSQL','','$val');
        $this->addHelpPropFunList('setHeaderNames','comma separated list which is use to generate html table tag head section, match with filed list','','$val');
        $this->addHelpPropFunList('setColWidths','Set col width comma list for td tags','','$list');
        $this->addHelpPropFunList('setWhere','SQL Query logic like WHERE','','$val');
        $this->addHelpPropFunList('setApp','Bind with app controller','','$val');
        $this->addHelpPropFunList('setAjax','Enable AJAX','','');
        $this->addHelpPropFunList('setEdit','Enable Edit Button','','');
        $this->addHelpPropFunList('setDelete','Enable Delete Button','','');
        $this->addHelpPropFunList('setHeader','Set Header HTML','','$val');
        $this->addHelpPropFunList('setFooter','Set Footer HTML','','$val');
        $this->addHelpPropFunList('unsetDialog','Disable Dialog','','');
        //$this->addHelpPropFunList('unsetAddButton','Disable Add Record Button','','$val');
        $this->addHelpPropList('dtable','comma list for database tables to query');
    }

    public function fu_setMsgName($val) { $this->msgName = $val;}
public function fu_setSQL($sql){
$this->sql = $sql;
}
public function fu_setPageCountSQL($sql){
$this->pageCountSQL = $sql;
}
public function fu_setPerPageRows($val){
$this->perPageRows = intval($val);
}
public function fu_setExtraData($val){
$this->extraData = $val;
}
public function setPageNo($val){
$this->pageNo = intval($val) - 1;
}
public function getPageNo(){
return $this->pageNo + 1;
}
public function setLinkNo($val){
$this->linkno = $val;
}
public function fu_setCacheFile($val){
$this->cachefile = $val;
}
public function fu_setCacheSave(){
$this->cachesave = true;
}
public function fu_setCacheKey($val){
$this->cachekey = $val;
}
public function fu_setCacheTime($val){
$this->cacheTime = intval($val);
}
public function fu_setFieldNames($val){
$this->fieldNames = $val;
}
public function fu_setHeaderNames($val){
$this->headNames = $val;
}
public function fu_setColWidths($val){
$this->colwidths = $val;
}
public function fu_setWhere($val){
$this->where = $val;
}
public function setApp($val){
$this->app = $val;
}
public function fu_setEdit(){
$this->blnEdit = true;
}
public function fu_setDelete(){
$this->blnDelete = true;
}
public function getPageBar(){
    return $this->getPaging();
}
public function fu_setHeader($val){
$this->header = $val;
}
public function fu_setFooter($val){
$this->footer = $val;
}
public function fu_unsetDialog(){
$this->blndlg = false;
}

public function executeSQL(){
$mysql = \SphpBase::dbEngine();
  $HTMLParser = new \Sphp\tools\HTMLParser();
 $sphp_settings = \SphpBase::sphp_settings();
  $stro = "";
// count total page
$mysql->connect();
if($this->cachefile!=''){
$res = $mysql->fetchQuery($this->pageCountSQL,$this->cacheTime,$this->cachefile.'csql');
}else{
$res = $mysql->fetchQuery($this->pageCountSQL,$this->cacheTime);
    }
if ($res){
$row = current($res['news']);
//$totalRows = intval($row['count(id)']);
$totalRows = intval(current($row));
$this->totalPages = intval(($totalRows + $this->perPageRows - 1) / $this->perPageRows);
if($this->pageNo < 0){
$this->pageNo = 0;
}
else if($this->pageNo + 1 > $this->totalPages){
$this->pageNo = $this->totalPages - 1 ;
}

$startat = $this->pageNo * $this->perPageRows;
if($startat<0){$startat=0;}
$this->result = $mysql->fetchQuery($this->sql." LIMIT $startat,$this->perPageRows",$this->cacheTime,$this->cachefile,$this->cachekey,$this->cachesave);
$mysql->disconnect();
$stro = '';
if ($this->result){
if($this->fieldNames!='' && $this->strFormat==''){
$stro = '<table class="pagtable">';
if($this->headNames==''){
$this->headNames = $this->fieldNames;
}
$arr = explode(',',$this->headNames);
$lenw = -1;
$startw = 0;
$w = '';
if($this->colwidths!=''){
$arrw = explode(',',$this->colwidths);
$lenw = count($arrw)-1;
$startw = 0;
}
$stro .= "<tr class=\"paghead\">";
foreach($arr as $key=>$val){
if($lenw>=$startw){
$w = ' width="'.$arrw[$startw].'"';
$startw += 1;
}else{
 $w = '';
}
$stro .= "<th$w>$val</th>";
}
if($this->blnEdit){
$stro .= "<th width=\"10\">Edit</th>";
}
if($this->blnDelete){
$stro .= "<th width=\"10\">Delete</th>";
}
$stro .= "</tr>";
$blnf = true;
foreach($this->result as $key1=>$keyar){
foreach($keyar as $key=>$row){
$arr = explode(',',$this->fieldNames);
if($blnf){
$stro .= "<tr class=\"pagrow1\">";
$blnf = false;
}else{
$stro .= "<tr class=\"pagrow2\">";
$blnf = true;
    }
$startw = 0;
foreach($arr as $key=>$val){
if($lenw>=$startw){
$w = ' width="'.$arrw[$startw].'"';
$startw += 1;
}else{
 $w = '';
}
$stro .= "<td$w>".$row[$val]."</td>";
}
if($this->blnEdit){
$stro .= "<td><a href=\"#\" onclick=\"pagiedit_$this->name('". getEventURL($this->name."_view",$row['id'],$this->app,$this->extraData,'',true)."');\" title=\"Click to Edit This Record\"><img src=\"{$sphp_settings->comp_respath}/comp/data/res/editBTN.gif\" border=\"0\" /></a></td>";
}
if($this->blnDelete){
$stro .= "<td><a href=\"#\" onClick=\"confirmDel_$this->name('".getEventURL($this->name."_delete",$row['id'],$this->app,$this->extraData,'',true)."')\" title=\"Click to Delete This Record\"><img src=\"{$sphp_settings->comp_respath}/comp/data/res/del.jpg\" border=\"0\" /></a></td>";
}

$stro .= "</tr>";
}
}
$stro .= "</table>";
$stro .= $this->getPaging();
}
else if($this->strFormat!=''){
$stro = $HTMLParser->executePHPCode('<?php foreach($'. $this->name .'->result as $key1=>$keyar){
 foreach($keyar as $index=>$'.$this->name.'->row){
$tmpf = new FrontFile($'.$this->name.'->strFormat,true);
$tmpf->run();
print $tmpf->data;
 } } ?>');
$this->unsetrenderTag();
}
}
}
return $stro;

}

private function getPaging(){
    $lynx = "";
    $del = "";
$linkNo = $this->linkno;
$startPage = $this->getPageNo()- $linkNo;
$endPage = $this->getPageNo()+$linkNo;
if($startPage<1){
$startPage = 1;
}
if($endPage>$this->totalPages){
$endPage = $this->totalPages;
}
for ($k=$startPage; $k<=$endPage; $k++) {
        if ($k != \SphpBase::sphp_request()->request($this->name.'page')) {
if($this->blnajax){
         $lynx .= "<div style=\"float:left;\"><a href=\"#\" onclick=\"getURL('". getEventURL($this->eventName,$this->evtp,$this->gate,$this->extra.$k,$this->baseName,$this->sesID)."');\">".($k)."</a></div>";
}else{
         $lynx .= "<div style=\"float:left;\"><a href=\"". getEventURL($this->eventName,$this->evtp,$this->gate,$this->extra.$k,$this->baseName,$this->sesID)."\">".($k)."</a></div>";    
}
        } else {
         $lynx .= "<div style=\"float:left;\">".($k)."</div>";
        }
}
$startPage2 = $this->getPageNo();
$blnEndP = false;
$blnStartP = false;
if($startPage2>1){
$prev = $startPage2 - 1;
}else{
$prev = 1;
$blnStartP = true;
}
if($startPage2 >= $this->totalPages){
$next = $this->totalPages;
$blnEndP = true;
}else{
$next = $startPage2 + 1;
}
$edt = '';
/* use for multi delete functions
if($this->blnEdit){
    $edt = "&nbsp;&nbsp;<a class=\"pagedit\" href=\"". $this->linkURL. "?page=" . $next ."\">Edit</a>";
}
if($this->blnDelete){
    $del = "&nbsp;&nbsp;<a class=\"pagdelete\" href=\"". $this->linkURL. "?page=" . $next ."\">Delete</a>";
}
 *
 */
if($blnStartP){
$strlinkP = "";
}else{
if($this->blnajax){
    $strlinkP = "<a class=\"pagprev\" href=\"#\" onclick=\"getURL('". getEventURL($this->eventName,$this->evtp,$this->gate,$this->extra.$prev,$this->baseName,$this->sesID)."');\">Prev</a>&nbsp;&nbsp;";
}else{
    $strlinkP = "<a class=\"pagprev\" href=\"". getEventURL($this->eventName,$this->evtp,$this->gate,$this->extra.$prev,$this->baseName,$this->sesID)."\">Prev</a>&nbsp;&nbsp;";    
}
}
if($blnEndP){
$strlinkN = "";
}else{
if($this->blnajax){
    $strlinkN = "<a class=\"pagnext\"  href=\"#\" onclick=\"getURL('".getEventURL($this->eventName,$this->evtp,$this->gate,$this->extra.$next,$this->baseName,$this->sesID)."');\">Next</a>";
}else{
    $strlinkN = "<a class=\"pagnext\" href=\"".getEventURL($this->eventName,$this->evtp,$this->gate,$this->extra.$next,$this->baseName,$this->sesID)."\">Next</a>";    
}
}
$strlink = $strlinkP . $strlinkN ;

if($blnStartP && $blnEndP){
$strout = '';
}else{
$strout = '<div class="pagbar"><div class="pagnums">&nbsp; '.$lynx.'</div>
<div class="pagprevnext">'.
$strlink .$edt.$del.'
</div></div>
<div style="clear:both"></div>';
}

return $strout;
}

protected function oncreate($element){
$this->strFormat = $element->innertext;
$element->innertext = '';
}

public function startAJAX(){
$opendlg = "";
if($this->blndlg){
addHeaderJSFunctionCode('ready',$this->name,'jql("#'.$this->name.'_dlg").dialog({
autoOpen: false,
width: "auto",
height: "400",
show: {
        effect: "blind",
        duration: 1000
},
hide: {
        effect: "explode",
        duration: 1000
},
position: [10,10],
title: "Grid Editor Form"
    });
');
    addHeaderCSS('dragdrop', '
.dragdrop
{
position: relative; 
cursor: auto;
}
');
$opendlg = "jql(\"#". $this->name ."_dlg\").dialog(\"open\");";
}
if($this->blnajax){
$jsAjax = "true";
}else{
$jsAjax = "false";    
}
addHeaderJSCode($this->name,"
function confirmDel_$this->name(link){
confirmDel(link,$jsAjax);
        }    
function pagiedit_$this->name(link){
$opendlg
pagiedit(link,$jsAjax);
        }    
function paginew_$this->name(link){
$opendlg
pagiedit(link,$jsAjax);
        }    
");
    addHeaderJSCode('pagi',"
function confirmDel(link,jsajax){
var ans = confirm('Are You Sure to Delete This Record !') ;
if(ans){
if(jsajax){
getURL(link);
 }else{
window.location = link ; 
  }
}
}
function pagiedit(link,jsajax) {
if(jsajax){
getURL(link);
 }else{
window.location = link ; 
  }
return false;
	}
function paginew(link,jsajax){
if(jsajax){
getURL(link);
 }else{
window.location = link ; 
  }
}
");
$ptag = '<div id="'.$this->name.'_dlg" class="dragdrop">
<div id="'.$this->name.'_editor" style="width:100%;height:100%;"></div>    
</div><input type="button" value="Add" onclick="paginew_'.$this->name.'(\''.getEventURL($this->name.'_newa','','','','',true).'\');" />';
    $divt = "$ptag<div id=\"{$this->name}_list\">";     
    $this->setPreTag($divt.$this->getPreTag());    
    $this->setPostTag('</div>'.$this->getPostTag());
    
}

protected function onjsrender(){
    $JSServer = \SphpBase::JSServer();
if(! $JSServer->ajaxrender){
if($this->blnajax){
$this->startAJAX();
}
}


}

protected function onrender(){
// set default values
$spt = explode(',', $this->dtable);
if(count($spt)>0){
    $idf = $spt[0].".id";
}else{
    $idf = "id";
}
if($this->pageCountSQL==''){
$this->pageCountSQL = "SELECT count($idf) FROM ".$this->dtable." ".$this->where;
}
if($this->sql==''){
$this->sql = "SELECT $idf,$this->fieldNames FROM ".$this->dtable." ".$this->where;
}

$this->parameterA['class'] = 'pag';
$this->innerHTML = $this->header. $this->executeSQL() . $this->footer;
//$this->innerHTML = $this->header.$this->footer;
//$this->unsetrender();
}


}
}
