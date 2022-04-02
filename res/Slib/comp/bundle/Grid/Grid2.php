<?php
/**
 * Description of Pagination
 *
 * @author SARTAJ
 */


class Grid2 extends Control{
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
public $whereDef = '';
public $ordersortby = '';
public $app = '';
public $blnEdit = false;
public $blnDelete = false;
public $cacheTime = 0;
public $eventName = 'show';
public $editeventName = 'view';
public $deleventName = 'delete';
private $evtp='';
private $ctrl='';
private $extra= 'page=';
private $baseName='';
private $sesID=false;
private $blnajax = false;
private $blndlg = true;
private $blnadd = true;
private $ajax = null;
private $cachefile = '';
private $cachekey = 'id';
private $cachesave = false;
private $header = '';
private $footer = '';
public $buttonnext = '';
public $buttonprev = '';
public $links = '';
private $sortby = false;
private $blnpagebar = true;

public function __construct($name='',$fieldName='',$tableName='') {
global $page,$ctrl,$tblName;
if($page->isSesSecure){
$this->sesID = true;
}
$this->init($name,'','');
$this->extra = $name . 'page='; 
if(isset($_REQUEST[$name . 'page'])){
$_SESSION[$name.'p'] = $_REQUEST[$name . 'page'];
$_SESSION[$name.'pc'] = $ctrl->ctrl;
}else{
$_REQUEST[$name . 'page'] = 1;
if(isset($_SESSION[$name.'pc']) && $_SESSION[$name.'pc'] == $ctrl->ctrl){
$_REQUEST[$name . 'page'] = $_SESSION[$name.'p'];
}
}
$this->pageNo = $_REQUEST[$name . 'page'] - 1;
if($tableName==''){
$this->dtable = $tblName;
}else{
$this->dtable = $tableName;
    }
$this->setHTMLName('');
}

public function getEventPath($eventName, $evtp='', $ControllerName='', $extra='', $newBasePath='', $blnSesID=false){
$this->eventName = $eventName;
$this->evtp=$evtp;
$this->ctrl=$ControllerName;
if($extra!=''){
$this->extra=$extra.'&'. $this->name .'page=';
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
public function setWhereDef($val){
$this->whereDef = $val;
}
public function setApp($val){
$this->app = $val;
}
public function setSortBy() {
    $this->sortby = true;
}
public function setAjax(){
$this->blnajax = true;
$this->ajax = new Ajaxsenddata($this->name."ajax1");
$this->ajax->oncompcreate(array());
$this->eventName = $this->name ."_show";
$this->editeventName = $this->name ."_view";
$this->deleventName = $this->name ."_delete";
}
public function setEdit(){
$this->blnEdit = true;
}
public function setDelete(){
$this->blnDelete = true;
}
public function getPageBar(){
return $this->links;
}
public function getButtonNext(){
return $this->buttonnext;
}
public function getButtonPrev(){
return $this->buttonprev;
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
public function unsetAddButton(){
$this->blnadd = false;
}
public function unsetPageBar(){
$this->blnpagebar = false;
}


public function executeSQL(){
  global $mysql;
  global $libpath;
  global $HTMLParser;
  $stro = "";
// count total page
$mysql->connect();
$row = true;
if ($row){
//$totalRows = intval($row['count(id)']);
$totalRows = $this->perPageRows + 8;
$this->totalPages = 2;
if($this->pageNo < 0){
$this->pageNo = 0;
}
else if($this->pageNo + 1 > $this->totalPages){
$this->pageNo = $this->totalPages - 1 ;
}

$startat = $this->pageNo * $this->perPageRows;
if($startat<0){$startat=0;}
$this->result = $mysql->executeQuery($this->sql." LIMIT $startat,$this->perPageRows");
$stro = '';
if ($this->result){
if($this->fieldNames!='' && $this->strFormat=='' && $this->content_section==null){
$stro = '<table class="pagtable">';
if($this->headNames==''){
$this->headNames = $this->fieldNames;
}
$arr = explode(',',$this->headNames);
$fieldcount = count($arr);
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
while($row = mysqli_fetch_assoc($this->result)){
$arr = explode(',',$this->fieldNames);
if($blnf){
$stro .= "<tr class=\"pagrow1\">";
$blnf = false;
}else{
$stro .= "<tr class=\"pagrow2\">";
$blnf = true;
    }
$startw = 0;
for($C=0; $C < $fieldcount; $C++){
$val =$arr[$C];
if($lenw>=$startw){
$w = ' style="width: '.$arrw[$startw].';"';
$startw += 1;
}else{
 $w = '';
}
$stro .= "<td$w>".$row[$val]."</td>";
}
if($this->blnEdit){
$stro .= "<td width=\"25\"><a href=\"#\" onclick=\"pagiedit_$this->name('". getEventPath($this->editeventName,$row['id'],$this->app,$this->extraData,'',true)."');\" title=\"Click to Edit This Record\"><img src=\"{$this->myrespath}/res/editBTN.gif\" border=\"0\" /></a></td>";
}
if($this->blnDelete){
$stro .= "<td width=\"25\"><a href=\"#\" onClick=\"confirmDel_$this->name('".getEventPath($this->deleventName,$row['id'],$this->app,$this->extraData,'',true)."')\" title=\"Click to Delete This Record\"><img src=\"{$this->myrespath}/res/del.jpg\" border=\"0\" /></a></td>";
}

$stro .= "</tr>";
}
$stro .= "</table>"; 
if($this->blnpagebar){
$stro .= $this->getPaging(); 
}
}else if($this->strFormat!=''){
//$tmpf = new TempFile($this->strFormat,true);
    while($this->row = mysqli_fetch_assoc($this->result)){ 
        $stro .= $this->getEval($this->strFormat);
 }
//$this->unsetrenderTag();
if($this->blnpagebar){
$strom = $this->getPaging();
}
}

}
}
//$mysql->disconnect();

return $stro;

}
private function getEval($strcode){
    extract($GLOBALS);
 ob_start();
eval("?>" . $strcode . "<?php ");
$this_string = ob_get_contents();
ob_end_clean();   
return $this_string;
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
 $strstart = "<div class=\"pfloat-left\">";
for ($k=$startPage; $k<=$endPage; $k++) {
        if ($k != $_REQUEST[$this->name . 'page']) {
if($this->blnajax){
         $lynx .= $strstart. "<a href=\"#\" onclick=\"getURL('". getEventPath($this->eventName,$this->evtp,$this->ctrl,$this->extra.$k,$this->baseName,$this->sesID)."'); return false;\">".($k)."</a></div>";
}else{
         $lynx .= $strstart."<a href=\"". getEventPath($this->eventName,$this->evtp,$this->ctrl,$this->extra.$k,$this->baseName,$this->sesID)."\">".($k)."</a></div>";    
}
        } else {
         $lynx .= $strstart.($k)."</div>";
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
    $strlinkP = "<a class=\"pagprev\" href=\"#\" onclick=\"getURL('". getEventPath($this->eventName,$this->evtp,$this->ctrl,$this->extra.$prev,$this->baseName,$this->sesID)."');return false;\">Prev</a>&nbsp;&nbsp;";
}else{
    $strlinkP = "<a class=\"pagprev\" href=\"". getEventPath($this->eventName,$this->evtp,$this->ctrl,$this->extra.$prev,$this->baseName,$this->sesID)."\">Prev</a>&nbsp;&nbsp;";    
}
}
if($blnEndP){
$strlinkN = "";
}else{
if($this->blnajax){
    $strlinkN = "<a class=\"pagnext\"  href=\"#\" onclick=\"getURL('".getEventPath($this->eventName,$this->evtp,$this->ctrl,$this->extra.$next,$this->baseName,$this->sesID)."');return false;\">Next</a>";
}else{
    $strlinkN = "<a class=\"pagnext\" href=\"".getEventPath($this->eventName,$this->evtp,$this->ctrl,$this->extra.$next,$this->baseName,$this->sesID)."\">Next</a>";    
}
}

if($blnStartP && $blnEndP){
$strout = '';
}else{
$strlink = $strlinkP . $strlinkN ;
$this->buttonnext = $strlinkN;
$this->buttonprev = $strlinkP;
$this->links = $lynx;
if($strlink!=''){
$strout = '<div class="pagbar"><div class="pagnums">&nbsp; '.$lynx.'</div>
<div class="pagprevnext">'.
$strlink .$edt.$del.'
</div></div>
<div style="clear:both"></div>';
}
}
return $strout;
}

public function oncreate($element){
$this->strFormat = $element->innertext;
$element->innertext = '';
}
public function onaftercreate(){
        $this->handleEvent();
}
public function handleEvent(){
    global $page,$Client,$JSServer,$showall;
    if($page->getEvent()== $this->name . "_sortby"){
        $this->unsetRenderTag();
        if($Client->request('dir')=='1'){
            $this->ordersortby = "ORDER BY ". $Client->request('sortby'). " DESC";
        }else{
            $this->ordersortby = "ORDER BY ". $Client->request('sortby') . " ASC";            
        }
        $JSServer->addJSONComp($this, $this->name);     
    }
}

public function startAJAX(){
global $jquerypath,$JSClient,$JSServer;
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

if($this->blnadd){
$ptag = '<div id="'.$this->name.'_dlg" class="dragdrop">
<div id="'.$this->name.'_editor" style="width:100%;height:100%;"></div>    
</div><div id="'.$this->name.'_toolbar">';
}else{
$ptag = '<div id="'.$this->name.'_toolbar">';    
}
if($this->blnadd){
$ptag .= '<input type="button" value="Add" onclick="paginew_'.$this->name.'(\''.getEventPath($this->name.'_newa','','','','',true).'\');" />';
}
    $divt = "$ptag</div><div id=\"{$this->name}_list\">";     
    $this->setPreTag($divt.$this->getPreTag());    
    $this->setPostTag('</div>'.$this->getPostTag());
    
}


public function onjsrender(){
global $jquerypath,$JSClient,$JSServer;
$opendlg = "";
if(!$JSServer->ajaxrender){
if($this->blnajax){
$this->eventName = $this->name."_show";
$this->editeventName = $this->name."_view";
$this->deleventName = $this->name."_delete";
$this->startAJAX();
}else{
$jsAjax = "false"; 
addHeaderJSCode($this->name,"
function confirmDel_$this->name(link){
confirmDel(link,$jsAjax);
        }    
var {$this->name}_setg = {
sortby: '',
dir: 1
};
function getSortBy(obj,field,link){
data = {};
var setg = {$this->name}_setg ;
var span1 = $(obj).children('span:first');
if(setg.sortby!=field){
setg.sortby = field;
setg.dir = 1;
$('.glyphicon-upload').addClass('glyphicon-download');
$('.glyphicon-upload').removeClass('glyphicon-upload');
span1.removeClass('glyphicon-download');
span1.addClass('glyphicon-upload');
}else if(setg.sortby==field){
if(setg.dir == 1){
setg.dir = 0;
$('.glyphicon-upload').addClass('glyphicon-download');
$('.glyphicon-upload').removeClass('glyphicon-upload');
}else{
setg.dir = 1;
$('.glyphicon-upload').addClass('glyphicon-download');
$('.glyphicon-upload').removeClass('glyphicon-upload');
span1.removeClass('glyphicon-download');
span1.addClass('glyphicon-upload');
}
}
data['sortby'] = field;
data['dir'] = setg.dir;
{$this->name}_setg = setg;

getURL(link,data);
return false;
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
}
}
}

public function onprerender(){
global $Client,$ctrl;
// set default values
$spt = explode(',', $this->dtable);
if(count($spt)>0){
    $idf = $spt[0].".id";
}else{
    $idf = "id";
}
$storesql = $Client->session($this->name .'store');
if(!is_array($storesql)) $storesql = array();
if(isset($storesql['lastapp']) && $storesql['lastapp'] == $ctrl->ctrl){
if($this->ordersortby==""){
    $this->ordersortby = $storesql['sortby']; 
}
if($this->where==""){
    if($storesql['whereby']!=""){
        $this->where = $storesql['whereby'];
    }else{
        $this->where = $this->whereDef;
    }
}
}
if(strpos($this->where,"WHERE")===false){
        $this->where = $this->whereDef;
}
if($this->pageCountSQL==''){
$this->pageCountSQL = "SELECT count($idf) FROM ".$this->dtable." ".$this->where;
} 
if($this->sql==''){
$this->sql = "SELECT $idf,$this->fieldNames FROM ".$this->dtable." ".$this->where. " " . $this->ordersortby;
}
$storesql['lastsql'] = $this->sql;
$storesql['lastpagecountsql'] = $this->pageCountSQL;
$storesql['lastapp'] = $ctrl->ctrl;
$storesql['sortby'] = $this->ordersortby;
$storesql['whereby'] = $this->where;
$Client->session($this->name .'store',$storesql);

$this->setAttribute("class", 'pag');
if($this->content_section===null){ 
$this->setInnerHTMLApp($this->header. $this->executeSQL() . $this->footer);
}else{
    $str = $this->executeSQL();
}


//$this->innerHTML = $this->header.$this->footer;
//$this->unsetrender();
}


public function onchildevent($event,$obj) {
    if($event=="oncreate" && $obj->type=='content'){
        //$this->content_section = $obj;     

       //   $this->strFormat = $obj->strFormat;
    }
}

}

