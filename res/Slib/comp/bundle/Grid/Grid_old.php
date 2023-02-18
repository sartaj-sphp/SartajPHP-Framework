<?php
/**
 * Description of Grid
 *
 * @author SARTAJ
 */


class Grid extends Control{
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
private $ctrl='';
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

public function __construct($name='',$fieldName='',$tableName='') {
global $page,$ctrl,$tblName,$JSServer,$Client;
if(SphpBase::page()->isSesSecure){
$this->sesID = true;
}
$this->init($name,'','');
$this->blnajax = true;
$this->eventName = $name ."_show";
$JSServer->getAJAX();
if($Client->request($name.'page')!=''){
$_SESSION[$name.'p'] = $_REQUEST[$name.'page'];
$_SESSION[$name.'pc'] = $ctrl;
}else{
if($Client->session($name.'pc') == $ctrl){
$_REQUEST[$name.'page'] = $_SESSION[$name.'p'];
}
}
$this->pageNo = $Client->request($name.'page') - 1;
if($tableName==''){
$this->dtable = $tblName;
}else{
$this->dtable = $tableName;
    }
$this->setHTMLName('');
}

function handleEvents(){
    extract($GLOBALS);
if(SphpBase::page()->isevent)
{
switch(SphpBase::page()->sact){
case $this->name.'_show':{
$JSServer->addJSONComp($this,'showalledtif');
break;
}
case $this->name.'_newa':{
$JSServer->addJSONTemp($genFormTemp,'showalledtif');
break;
}
}
}

}

public function getEventURL($eventName, $evtp='', $ControllerName='', $extra='', $newBasePath='', $blnSesID=false){
$this->eventName = $eventName;
$this->evtp=$evtp;
$this->ctrl=$ControllerName;
if($extra!=''){
$this->extra=$extra.'&'.$this->name.'page=';
}
$this->baseName=$newBasePath;
$this->sesID=$blnSesID;
    }

     public function setMsgName($val) { $this->msgName = $val;}
public function setSQL($sql){
$this->sql = $sql;
}
public function setPageCountSQL($sql){
$this->pageCountSQL = $sql;
}
public function setPerPageRows($val){
$this->perPageRows = intval($val);
}
public function setExtraData($val){
$this->extraData = $val;
}
public function setPageNo($val){
$this->pageNo = $val - 1;
}
public function getPageNo(){
return $this->pageNo + 1;
}
public function setLinkNo($val){
$this->linkno = $val;
}
public function setCacheFile($val){
$this->cachefile = $val;
}
public function setCacheSave(){
$this->cachesave = true;
}
public function setCacheKey($val){
$this->cachekey = $val;
}
public function setCacheTime($val){
$this->cacheTime = intval($val);
}
public function setFieldNames($val){
$this->fieldNames = $val;
}
public function setHeaderNames($val){
$this->headNames = $val;
}
public function setColWidths($val){
$this->colwidths = $val;
}
public function setWhere($val){
$this->where = $val;
}
public function setApp($val){
$this->app = $val;
}
public function setEdit(){
$this->blnEdit = true;
}
public function setDelete(){
$this->blnDelete = true;
}
public function getPageBar(){
    return $this->getPaging();
}
public function setHeader($val){
$this->header = $val;
}
public function setFooter($val){
$this->footer = $val;
}
public function unsetDialog(){
$this->blndlg = false;
}

public function executeSQL(){
  global $mysql;
  global $libpath;
  $HTMLParser = new \Sphp\tools\HTMLParser();
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
$stro .= "<td><a href=\"#\" onclick=\"pagiedit_$this->name('". getEventURL($this->name."_view",$row['id'],$this->app,$this->extraData,'',true)."');\" title=\"Click to Edit This Record\"><img src=\"{$this->myrespath}/res/editBTN.gif\" border=\"0\" /></a></td>";
}
if($this->blnDelete){
$stro .= "<td><a href=\"#\" onClick=\"confirmDel_$this->name('".getEventURL($this->name."_delete",$row['id'],$this->app,$this->extraData,'',true)."')\" title=\"Click to Delete This Record\"><img src=\"{$this->myrespath}/res/del.jpg\" border=\"0\" /></a></td>";
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
$tmpf = new TempFile($'.$this->name.'->strFormat,true);
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
        if ($k != $_REQUEST[$this->name.'page']) {
if($this->blnajax){
         $lynx .= "<div style=\"float:left;\"><a href=\"#\" onclick=\"getURL('". getEventURL($this->eventName,$this->evtp,$this->ctrl,$this->extra.$k,$this->baseName,$this->sesID)."');\">".($k)."</a></div>";
}else{
         $lynx .= "<div style=\"float:left;\"><a href=\"". getEventURL($this->eventName,$this->evtp,$this->ctrl,$this->extra.$k,$this->baseName,$this->sesID)."\">".($k)."</a></div>";    
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
    $strlinkP = "<a class=\"pagprev\" href=\"#\" onclick=\"getURL('". getEventURL($this->eventName,$this->evtp,$this->ctrl,$this->extra.$prev,$this->baseName,$this->sesID)."');\">Prev</a>&nbsp;&nbsp;";
}else{
    $strlinkP = "<a class=\"pagprev\" href=\"". getEventURL($this->eventName,$this->evtp,$this->ctrl,$this->extra.$prev,$this->baseName,$this->sesID)."\">Prev</a>&nbsp;&nbsp;";    
}
}
if($blnEndP){
$strlinkN = "";
}else{
if($this->blnajax){
    $strlinkN = "<a class=\"pagnext\"  href=\"#\" onclick=\"getURL('".getEventURL($this->eventName,$this->evtp,$this->ctrl,$this->extra.$next,$this->baseName,$this->sesID)."');\">Next</a>";
}else{
    $strlinkN = "<a class=\"pagnext\" href=\"".getEventURL($this->eventName,$this->evtp,$this->ctrl,$this->extra.$next,$this->baseName,$this->sesID)."\">Next</a>";    
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

public function oncreate($element){
$this->strFormat = $element->innertext;
$element->innertext = '';
}

public function startAJAX(){
global $jquerypath,$JSClient,$JSServer;
addFileLink($jquerypath.'themes/base/jquery.ui.all.css');
addFileLink($jquerypath.'themes/base/jquery.ui.dialog.css');
addFileLink($jquerypath.'ui/jquery.ui.core.min.js');
addFileLink("{$jquerypath}/ui/jquery.ui.widget.min.js");
addFileLink("{$jquerypath}/ui/jquery.ui.mouse.min.js");
addFileLink($jquerypath.'ui/jquery.ui.draggable.min.js');
addFileLink("{$jquerypath}/ui/jquery.ui.position.min.js");
addFileLink($jquerypath.'ui/jquery.ui.resizable.min.js');
addFileLink($jquerypath.'ui/jquery.ui.button.min.js');
addFileLink($jquerypath.'ui/jquery.ui.dialog.min.js');
addFileLink($jquerypath.'ui/jquery.ui.effect.min.js');
addFileLink($jquerypath.'ui/jquery.ui.effect-blind.min.js');
addFileLink($jquerypath.'ui/jquery.ui.effect-explode.min.js');
$opendlg = "";
if($this->blndlg){
addHeaderJSFunctionCode('ready',$this->name,'
$("#'.$this->name.'_dlg").dialog({
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
$opendlg = "$(\"#{$this->name}_dlg\").dialog(\"open\");";
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

public function onjsrender(){
global $jquerypath,$JSClient,$JSServer;
if(!$JSServer->ajaxrender){
if($this->blnajax){
$this->startAJAX();
}
}


}

public function onrender(){
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
?>