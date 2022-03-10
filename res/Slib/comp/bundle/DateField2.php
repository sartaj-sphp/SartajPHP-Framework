<?php
/**
 * Description of DateField
 *
 * @author SARTAJ
 */



class DateField2 extends Control{
public $datemin = '';
public $datemax = '';
private $appendText = 'dd-mm-yy';
private $image = "";
private $nomonth = "";
private $formName = '';
private $msgName = '';
private $req = false;

public function __construct($name='',$fieldName='',$tableName='') {
$this->init($name,$fieldName,$tableName);
if($this->value!=''){
$this->value = $this->dateToMySQLDate($this->value) ;
}
$this->unsetEndTag();
}

     public function setForm($val) { $this->formName = $val;}
     public function setMsgName($val) { $this->msgName = $val;}
     public function setRequired() {
if($this->issubmit){
if(strlen($this->value) < 1){
setErr($this->name,"Can not submit Empty");
            }
  }
$this->req = true;
}
private function dateToMySQLDate($date){
    $date1 = $this->createDate($this->appendText, $date, 'Y-m-d', 0, 0, 0);
    return $date1;
}
public function createDate($dformat, $beginDate, $outformat, $offsetd, $offsetm, $offsety)
    {
// find date separator
$dsep = ' ';
if(strpos($dformat, '/')>0){$dsep = '/';}
if(strpos($dformat, '-')>0){$dsep = '-';}
$date_parts2 = explode($dsep, $beginDate);
$date_parts3 = explode($dsep, $dformat);
if($date_parts3[0]=='mm' && $date_parts3[1]=='dd'){
    $date_parts1[0] = $date_parts2[1];
    $date_parts1[1] = $date_parts2[0];
    $date_parts1[2] = $date_parts2[2];
}
else if($date_parts3[0]=='mm' && $date_parts3[1]=='yy'){
    $date_parts1[0] = $date_parts2[2];
    $date_parts1[1] = $date_parts2[0];
    $date_parts1[2] = $date_parts2[1];
}
else if($date_parts3[0]=='yy' && $date_parts3[1]=='dd'){
    $date_parts1[0] = $date_parts2[1];
    $date_parts1[1] = $date_parts2[2];
    $date_parts1[2] = $date_parts2[0];
}
else if($date_parts3[0]=='yy' && $date_parts3[1]=='mm'){
    $date_parts1[0] = $date_parts2[2];
    $date_parts1[1] = $date_parts2[1];
    $date_parts1[2] = $date_parts2[0];
}
else if($date_parts3[0]=='dd' && $date_parts3[1]=='yy'){
    $date_parts1[0] = $date_parts2[0];
    $date_parts1[1] = $date_parts2[2];
    $date_parts1[2] = $date_parts2[1];
}else{
    $date_parts1 = $date_parts2;
}

 $date1  = date($outformat, mktime(0, 0, 0, $date_parts1[1] + $offsetm, $date_parts1[0] + $offsetd,  $date_parts1[2] + $offsety));
    return $date1;
    }

 public function mysqlDateToDate($df)
    {
if($df!=''){
$dformat = $this->appendText;
$dformat = str_replace('dd', 'd', $dformat);
$dformat = str_replace('mm', 'm', $dformat);
$dformat = str_replace('yy', 'Y', $dformat);

$date1 = date($dformat,strtotime($df));
    return $date1;
}
    }

public function setDateMin($val){$this->datemin = $val;}
public function setDateMax($val){$this->datemax = $val;}
public function setAppendText($val){$this->appendText=$val;}
public function setButtonImage($val){$this->image=$val;}
public function setNumMonths($val){$this->nomonth=$val;}

public function onjsrender(){
global $libpath;
global $respath;
global $jquerypath;
/*
addFileLink("{$jquerypath}/themes/base/jquery.ui.all.css");
addFileLink("{$jquerypath}/ui/jquery.ui.core.min.js");
addFileLink("{$jquerypath}/ui/jquery.ui.widget.min.js");
addFileLink("{$jquerypath}/ui/jquery.ui.datepicker.min.js");
 * 
 */
$str = '';
if($this->appendText!=''){$str .= ",appendText: '$this->appendText', dateFormat: '$this->appendText'";}
if($this->image==''){$this->image= "$respath/controls/sphp/res/calendar.gif";}
if($this->image!=''){$str .= ",showOn: 'button',buttonImageOnly: true, buttonImage: '$this->image'";}
if($this->datemax!=''){$str .= ",maxDate: '$this->datemax'";}
if($this->datemin!=''){$str .= ",minDate: '$this->datemin'";}
if($this->nomonth!=''){$str .= ",numberOfMonths: $this->nomonth";}
$this->setParameterA('class', $this->parameterA['class']." hasDatePicker2");
addHeaderJSFunctionCode('ready', "datepicker", "
$('.hasDatePicker2').datepicker({ changeMonth: true,changeYear: true $str});
");
if($this->formName!=''){
if($this->req){
addFooterJSFunctionCode("{$this->formName}_submit", "{$this->HTMLID}req", "
ctlReq['$this->HTMLID']= Array('$this->msgName','TextField');");
}
}
}

public function onrender(){
if($this->value!=''){
$this->parameterA['value'] = $this->mysqlDateToDate($this->value);
}
$this->parameterA['type'] = 'text';
$this->parameterA['readonly'] = ' ';

}


// javascript functions
public function getJSValue(){
return "document.getElementById('$this->name').value" ;
}

public function setJSValue($exp){
global $jsOut;
$jsOut .= "document.getElementById('$this->name').value = $exp;" ;
}

}
?>