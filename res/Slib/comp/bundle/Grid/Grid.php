<?php
/**
 * Description of Grid
 *
 * @author SARTAJ
 */

include_once(SphpBase::sphp_settings()->slib_path . "/comp/ajax/Ajaxsenddata.php");
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
public $ordersortby = '';
public $whereDef = '';
public $app = '';
public $blnEdit = false;
public $blnDelete = false;
public $cacheTime = 0;
public $eventName = 'show';
public $editeventName = 'view';
public $deleventName = 'delete';
private $evtp='';
private $ctrl='';
private $extra='page=';
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
private $handleeventapp = false;
public $content_section = null;
private $roote = null;
public $sesbasename = "";


public function oncreate($element) {
    $this->sesbasename = \SphpBase::sphp_router()->ctrl . $this->name;
if(\SphpBase::page()->isSesSecure){
$this->sesID = true;
}
if(\SphpBase::sphp_request()->isRequest('page')){
\SphpBase::sphp_request()->session($this->sesbasename.'p',\SphpBase::sphp_request()->request('page'));
\SphpBase::sphp_request()->session($this->sesbasename.'pc', \SphpBase::sphp_router()->ctrl);
}else{
\SphpBase::sphp_request()->request('page',false, 1);
if(isset($_SESSION[$this->sesbasename.'pc']) && $_SESSION[$this->sesbasename.'pc'] == \SphpBase::sphp_router()->ctrl){
\SphpBase::sphp_request()->request('page',false,$_SESSION[$this->sesbasename.'p']);
}
}
$this->pageNo = \SphpBase::sphp_request()->request('page') - 1;

if($this->dtable == ''){
    $parentapp = $this->tempobj->getBindApp();
    if($parentapp !== null){
        $this->dtable = $parentapp->getTableName();
    }
}
$this->setHTMLName('');
    if($element->innertext != ""){
        $this->strFormat = "datajfjfh";
    }

}

public function getEventURL($eventName, $evtp='', $ControllerName='', $extra='', $newBasePath='', $blnSesID=false){
$this->eventName = $eventName;
$this->evtp=$evtp;
$this->ctrl=$ControllerName;
if($extra!=''){
$this->extra=$extra.'&page=';
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
\SphpBase::sphp_request()->session($this->sesbasename.'p',$val);
\SphpBase::sphp_request()->session($this->sesbasename.'pc', \SphpBase::sphp_router()->ctrl);
\SphpBase::sphp_request()->request('page',false, $val);
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
$this->ajax = new \Sphp\comp\ajax\Ajaxsenddata($this->name."ajax1");
$this->ajax->oncompcreate(array());
$this->eventName = $this->name ."_show";
$this->editeventName = $this->name ."_view";
$this->deleventName = $this->name ."_delete";
SphpJsM::addjQueryUI();
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
public function getRow($field) {
       if(isset($this->row[$field])){
           return $this->row[$field];
       }else{
           return "";
       }
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
public function setHandleEvent(){
    $this->handleeventapp = true;
}

public function executeSQL(){
  $mysql = \SphpBase::dbEngine();
  $libpath = \SphpBase::sphp_settings()->lib_path;
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
//$mysql->disconnect();
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
$stro .= "<td width=\"25\"><a href=\"#\" onclick=\"pagiedit_$this->name('". getEventURLSecure($this->editeventName,$row['id'],$this->app,$this->extraData,'',true)."');\" title=\"Click to Edit This Record\"><img src=\"{$this->myrespath}/res/editBTN.gif\" border=\"0\" /></a></td>";
}
if($this->blnDelete){
$stro .= "<td width=\"25\"><a href=\"#\" onClick=\"confirmDel_$this->name('".getEventURLSecure($this->deleventName,$row['id'],$this->app,$this->extraData,'',true)."')\" title=\"Click to Delete This Record\"><img src=\"{$this->myrespath}/res/del.jpg\" border=\"0\" /></a></td>";
}

$stro .= "</tr>";
}
}
$stro .= "</table>"; 
if($this->blnpagebar){
$stro .= $this->getPaging(); 
}
}else if($this->strFormat!=''){
    $stro = ""; 
    // SphpBase::debug()->println($this->sql . " grid " . $this->name);
if($this->roote == null){
    $this->roote = $this->tempobj->getChildrenWrapper($this);
}
foreach($this->result as $key1=>$keyar){
    foreach($keyar as $index=>$this->row){ 
        //$tmpf = new TempFile($this->strFormat,true,false,$this->tempobj->parentapp);
        //$tmpf->run();
        //$stro .= $tmpf->data;
        $stro .= $this->tempobj->parseComponentChildren($this->roote); 
    } 
}
//$this->unsetrenderTag();
if($this->blnpagebar){
$strom = $this->getPaging();
}
}

}
} 
 //SphpBase::debug()->println(" where " . $this->sql . $startat);
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
 //$strstart = "<div class=\"pfloat-left\">";
$strstart = "";
 $pg = $this->pageNo + 1;
for ($k=$startPage; $k<=$endPage; $k++) {
        if ($k != $pg) {
if($this->blnajax){
         $lynx .= $strstart. "<li class=\"page-item\"><a class=\"page-link\" href=\"#\" onclick=\"getURL('". getEventURL($this->eventName,$this->evtp,$this->ctrl,$this->extra.$k,$this->baseName,$this->sesID)
  ."'); return false;\">".($k)."</a></li>";
}else{
         $lynx .= $strstart."<li class=\"page-item\"><a class=\"page-link\" href=\"". getEventURL($this->eventName,$this->evtp,$this->ctrl,$this->extra.$k,$this->baseName,$this->sesID)."\">".($k)."</a></li>";    
}
        } else {
         $lynx .= $strstart . "<li class=\"page-item active\"><span class=\"page-link\"  >".($k)."</span></li>";
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
    $strlinkP = "<li class=\"page-item\"><a class=\"page-link\"  href=\"#\" onclick=\"getURL('". getEventURL($this->eventName,$this->evtp,$this->ctrl,$this->extra.$prev,$this->baseName,$this->sesID)."');return false;\" aria-label=\"Previous\"><span aria-hidden=\"true\">&laquo;</span></a></li>";
}else{
    $strlinkP = "<li class=\"page-item\"><a class=\"page-link\"  href=\"". getEventURL($this->eventName,$this->evtp,$this->ctrl,$this->extra.$prev,$this->baseName,$this->sesID)."\" aria-label=\"Previous\"><span aria-hidden=\"true\">&laquo;</span></a></li>";    
}
}
if($blnEndP){
$strlinkN = "";
}else{
if($this->blnajax){
    $strlinkN = "<li class=\"page-item\"><a class=\"page-link\"   href=\"#\" onclick=\"getURL('".getEventURL($this->eventName,$this->evtp,$this->ctrl,$this->extra.$next,$this->baseName,$this->sesID)."');return false;\" aria-label=\"Next\"><span aria-hidden=\"true\">&raquo;</span></a></li>";
}else{
    $strlinkN = "<li class=\"page-item\"><a class=\"page-link\"  href=\"".getEventURL($this->eventName,$this->evtp,$this->ctrl,$this->extra.$next,$this->baseName,$this->sesID)."\" aria-label=\"Next\"><span aria-hidden=\"true\">&raquo;</span></a></li>";    
}
}

if($blnStartP && $blnEndP){
$strout = '';
}else{
$strlink = $strlinkP . $strlinkN ;
$this->buttonnext = $strlinkN;
$this->buttonprev = $strlinkP;
if($strlink!=''){
$strout = '<nav aria-label="pagination"><ul class="pagination pagination-lg">'. $strlinkP . $lynx . $strlinkN . '</ul></nav>';
}
} 
$this->links = $strout;

return $strout;
}

public function onaftercreate(){
    if(!$this->handleeventapp){
        $this->handleEvent();
    }
}
    protected function genhelpPropList() {
        $this->addHelpPropFunList('getEventURL','Set Event Path to get page', getEventURL($this->eventName, $this->evtp, $this->ctrl, $this->extra, $this->baseName, $this->sesID),'$eventName, $evtp="", $ControllerName="", $extra="", $newBasePath="", $blnSesID=false');
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

public function handleEvent(){
    if(\SphpBase::page()->getEvent()== $this->name . "_sortby"){
        $this->unsetRenderTag();
        if(\SphpBase::sphp_request()->request('dir')=='1'){
            $this->ordersortby = "ORDER BY ". \SphpBase::sphp_request()->request('sortby'). " DESC";
        }else{
            $this->ordersortby = "ORDER BY ". \SphpBase::sphp_request()->request('sortby') . " ASC";            
        }
        \SphpBase::JSServer()->addJSONComp($this, $this->name);     
    }
}

public function startAJAX(){
$opendlg = "";
if($this->blndlg){
addHeaderJSFunctionCode('ready',$this->name,'
$("#'.$this->name.'_dlg").dialog({
autoOpen: false,
width: "auto",
height: "700",
show2: {
        effect: "blind",
        duration: 300
},
hide2: {
        effect: "explode",
        duration: 300
},
position: { my: "center", at: "center", of: window },
title: "Grid Editor Form",
create: function(event, ui) { 
        $("#'.$this->name.'_dlg").dialog("moveToTop");
      var widget = $(this).dialog("widget");
      $(".ui-dialog-titlebar-close", widget)
          .html(\'<span class="ui-button-icon ui-icon ui-icon-closethick"></span><span class="ui-button-icon-space"> </span>\')
          .addClass("ui-button ui-corner-all ui-widget ui-button-icon-only ui-dialog-titlebar-close");
   },
closeText: "",
modal: true,
beforeClose: function(){
    $("#'.$this->name.'_editor").html("");
}
    });
    var maxZI = Math.max.apply(null, 
    $.map($(\'body *\'), function(el,index) {
      if ($(el).css(\'position\') != \'static\')
        return parseInt($(el).css(\'z-index\')) || 0;
  }));
$("#'.$this->name.'_dlg").parent(".ui-dialog").css("z-index",maxZI+1);
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
window['confirmDel_$this->name'] = function(link){
confirmDel(link,$jsAjax);
        }    
var {$this->name}_setg = {
sortby: '',
dir: 1
};
window['getSortBy'] = function(obj,field,link){
var data = {};
var setg = {$this->name}_setg ;
var span1 = $(obj).children('span:first');
if(setg.sortby!=field){
setg.sortby = field;
setg.dir = 1;
$('.fa-upload').addClass('fa-download');
$('.fa-upload').removeClass('fa-upload');
span1.removeClass('fa-download');
span1.addClass('fa-upload');
}else if(setg.sortby==field){
if(setg.dir == 1){
setg.dir = 0;
$('.fa-upload').addClass('fa-download');
$('.fa-upload').removeClass('fa-upload');
}else{
setg.dir = 1;
$('.fa-upload').addClass('fa-download');
$('.fa-upload').removeClass('fa-upload');
span1.removeClass('fa-download');
span1.addClass('fa-upload');
}
}
data['sortby'] = field;
data['dir'] = setg.dir;
{$this->name}_setg = setg;

getURL(link,data);
return false;
 };
    window['rowclick'] = function(obj,link,data){
        if(data==undefined){
            data = {};
        }
        $('table').find('tr.highlight').removeClass('highlight');
        $(obj).addClass('highlight');
        getURL(link,data);
    };
    window['setFormAsNew'] = function(formid){
        readyFormAsNew(formid);
        $('table').find('tr.highlight').removeClass('highlight');
        $('#btnDel').css('display','none');
    };
    window['readyFormAsNew'] = function(formid){
        $('#' + formid).find('input[name=\"txtid\"]').val('');
        $(':input','#' + formid)
        .not(':button, :submit, :reset, :hidden')
        .val('').attr('value','')
        .removeAttr('checked')
        .removeAttr('selected');
        $('select', '#' + formid).each(function(i,e){selectByValue(e,\"empt\")});
        $('textarea', '#' + formid).each(function(i,e) { $(e).val(''); $(e).html(''); });
    };
window['runanierr'] = function (type){
    $(\"#sphp\" + type).fadeIn(1);
    $(\"#sphp\" + type).css(\"display\",\"block\");
    $(\"#sphp\" + type).delay(5000).fadeOut(\"slow\", function () { $(this).css(\"display\",\"none\"); });            
};
window['pagiedit_$this->name'] = function(link){
$opendlg
pagiedit(link,$jsAjax);
        };    
window['paginew_$this->name'] = function(link){
$opendlg
pagiedit(link,$jsAjax);
        };    
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
$(\"#btnadd{$this->name}\").on('click',function(){paginew_{$this->name}('" . getEventURL($this->name.'_newa','','','','',true) . "');});
");

//if($this->blnadd){
$ptag = '<div id="'.$this->name.'_dlg" class="dragdrop">
<div id="'.$this->name.'_editor" style="width:100%;height:100%;" ></div>    
</div><div id="'.$this->name.'_toolbar" class="pb-4">';
//}else{
//$ptag = '<div id="'.$this->name.'_toolbar">';    
//}
if($this->blnadd){
$ptag .= '<input id="btnadd'. $this->name .'" class="btn btn-primary" type="button" value="Add"  />';
}
$msg1 = '<div style="position: fixed; z-index: 2000;width: 500px;">
    <div id="sphpwarning" class="alert alert-warning" style="display: none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Warning!</strong> <span id="sphpwarningmsg"></span>
    </div>
    <div id="sphperror" class="alert alert-danger" style="display: none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Error!</strong> <span id="sphperrormsg"></span>
    </div>
    <div id="sphpsuccess" class="alert alert-success" style="display: none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Success!</strong> <span id="sphpsuccessmsg"></span>
    </div>
    <div id="sphpinfo" class="alert alert-info" style="display: none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Note!</strong> <span id="sphpinfomsg"></span>
    </div>
</div><div id="srvmsg"></div>';
    $divt = "$ptag</div>". $msg1 ."<div id=\"{$this->name}_list\">";     
    if($this->tagName == "tbody"){
        $p1 = $this->element->parentNode;
    }else{
        $p1 = $this->element;
    }
    $p1->setPreTag($divt . $p1->pretag);    
    $p1->setPostTag('</div>'.$p1->posttag);

}


public function onjsrender(){
$opendlg = "";
if(!\SphpBase::JSServer()->ajaxrender){
    addHeaderCSS("gridhighlight", " .highlight{
 font-size: 16px;
 color: #000000;
 font-weight: bold;
 background-color: #DEECFA
}
");
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
$('.fa-upload').addClass('fa-download');
$('.fa-upload').removeClass('fa-upload');
span1.removeClass('fa-download');
span1.addClass('fa-upload');
}else if(setg.sortby==field){
if(setg.dir == 1){
setg.dir = 0;
$('.fa-upload').addClass('fa-download');
$('.fa-upload').removeClass('fa-upload');
}else{
setg.dir = 1;
$('.fa-upload').addClass('fa-download');
$('.fa-upload').removeClass('fa-upload');
span1.removeClass('fa-download');
span1.addClass('fa-upload');
}
}
data['sortby'] = field;
data['dir'] = setg.dir;
{$this->name}_setg = setg;

getURL(link,data);
return false;
 }
    function rowclick(obj,link,data){
        if(data==undefined){
            data = {};
        }
        $('table').find('tr.highlight').removeClass('highlight');
        $(obj).addClass('highlight');
        getURL(link,data);
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
$Client = \SphpBase::sphp_request();
$ctrl = \SphpBase::sphp_router();
// set default values
$commaPos = strpos($this->dtable, ",");
$spacePos = strpos($this->dtable, " ");
if($spacePos !== false && ($commaPos === false || $spacePos < $commaPos)){
    $spt = explode(' ', $this->dtable,2);    
}else{
    $spt = explode(',', $this->dtable,2);
}

if(count($spt)>0){
    $idf = $spt[0].".id";
}else{
    $idf = "id";
}
$storesql = $Client->session($this->sesbasename .'store');
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
if(stripos($this->where,"WHERE")===false){
        $this->where = $this->whereDef;
}

if($this->pageCountSQL==''){
$this->pageCountSQL = "SELECT count($idf) FROM ".$this->dtable." ".$this->where;
} 
if($this->sql==''){
    if(stripos($this->where,"ORDER BY") !== false){
        if(stripos($this->ordersortby,"ORDER BY") !== false) $this->ordersortby = str_ireplace("ORDER BY",",",$this->ordersortby);
    }
$this->sql = "SELECT $idf,$this->fieldNames FROM ".$this->dtable." ".$this->where. " " . $this->ordersortby;
}
$storesql['lastsql'] = $this->sql;
$storesql['lastpagecountsql'] = $this->pageCountSQL;
$storesql['lastapp'] = $ctrl->ctrl;
$storesql['sortby'] = $this->ordersortby;
$storesql['whereby'] = $this->where;
$Client->session($this->sesbasename .'store',$storesql);

$this->element->appendAttribute('class', ' pag');
if($this->content_section===null){ 
$this->setInnerHTML($this->header. $this->executeSQL() . $this->footer);
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
    //echo "event " . $event;
}
public function onparse($event,$element) {
     //echo "parse event " . $event; 
}
    public function onholder($obj) {
        if(isset($this->row[$obj->getAttribute("dfield")])){
            $obj->setInnerHTML($this->row[$obj->getAttribute("dfield")]);
        }else{
            $obj->setInnerHTML('');
        }
    }

}

