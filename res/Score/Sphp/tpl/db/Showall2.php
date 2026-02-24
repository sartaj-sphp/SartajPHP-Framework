<?php
/**
 * Description of Showall
 *
 * @author Administrator
 */
include_once("{$phppath}/component/bundle/comp/data/Pagination.php");
include_once("{$phppath}/component/bundle/comp/data/DTable.php");
include_once("{$phppath}/component/bundle/comp/html/HTMLForm.php");

class Showall {
private $RenderComp;
private $peg1;
private $dt1;
public $form;

public function __construct($name=''){
global $tblName;
global $txtid;
$this->RenderComp = new RenderComp();
$this->peg1 = new Pagination($name.'peg1','',$tblName);
$this->dt1 = new DTable($name.'dt1','',$tblName);
if($_REQUEST['txtid']==''){
$txtid = $_REQUEST['evtp'];
$_REQUEST['txtid'] = $txtid;
}
$this->form = new HTMLForm($name,'','');
$this->peg1->tagName = 'div';
$this->dt1->tagName = 'div';
$this->form->tagName = 'form';
$this->form->parameterA['action'] = getThisGateURL('', true);
$this->dt1->setForm($name);
$this->dt1->setDontUseFormat();
$this->tbln = $tblName;
}
public function setSQL($sql){
$this->peg1->sql = $sql;
}
public function setPageCountSQL($sql){
$this->peg1->pageCountSQL = $sql;
}
public function setPerPageRows($val){
$this->peg1->perPageRows = $val;
}
public function setPageNo($val){
$this->peg1->pageNo = $val - 1;
}
public function getPageNo(){
return $this->peg1->pageNo + 1;
}
public function setLinkNo($val){
$this->peg1->linkno = $val;
}
public function setLinkURL($val){
$this->peg1->linkURL = $val;
}
public function setFieldNames($val){
$this->peg1->fieldNames = $val;
}
public function setHeaderNames($val){
$this->peg1->headNames = $val;
}
public function setColWidths($val){
$this->peg1->colwidths = $val;
}
public function setWhere($val){
$this->peg1->where = $val;
}
public function setApp($val){
$this->peg1->Gate = $val;
}
public function setEdit(){
$this->peg1->blnEdit = true;
}
public function setDelete(){
$this->peg1->blnDelete = true;
}
public function setTable($val){
$this->peg1->dtable = $val;
$this->dt1->dtable = $val;
}
public function setAction($val){
$this->form->setParameterA('action', $val);
}

public function setField($dfield,$label='',$type='',$req='',$min='',$max=''){
    $this->dt1->setField($dfield,$label,$type,$req,$min,$max);
}


public function renderShowall(){
return $this->RenderComp->render($this->peg1);
}
public function renderForm(){
$this->form->innerHTML = $this->RenderComp->render($this->dt1).'<div align="center"><input type="submit" value="Submit" ></div>';
return $this->RenderComp->render($this->form);
}

}
