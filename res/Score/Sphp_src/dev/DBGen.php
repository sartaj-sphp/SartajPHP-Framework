<?php
/**
 * Description of DBGen
 *
 * @author Sartaj
 */
namespace Sphp\dev{

class DBGen {
    //put your code here
    
    public function getEditForm($tablename) {
        global $dbEngine;
        $dbfields = $dbEngine->getTableColumns($tablename);
        $strout = '<div id="msg1" runat="server" ></div>
<form id="form2" class="form-horizontal form-striped" runat="server" action="<?php echo getAppURL(\''. $actrl->value .'\'); ?>">
                ';
        foreach ($dbfields as $key => $dbfield) {
            if($key!="id" && $key!="spcmpid" && substr($key,0,3)!="nan"){
                $strout .= $this->getEditFormFieldLabel($dbfield);
            }
        }
    $strout .= '<div class="form-group">
    <input type="submit" value="Save" />
</div>
</form>';
        return $strout ;
    }
    
    public function getShowForm($tablename,$Appgatename="") {
        global $dbEngine;
        $dbfields = $dbEngine->getTableColumns($tablename);
        $blnFirst = true;
        $col = 0;
        $strsearch = '<panel id="pnlSearch" funsetLabel="Search '.$this->convertFieldName($Appgatename).'" runat="server" path="component/bootstrap3/SearchPanel.php">
<form id="frmSearch" class="form-horizontal" runat="server" funsetAJAX="" action="<?php echo getEventURL(\'usersrch\',\'\',\''.$Appgatename.'\'); ?>">
';
        $strgridhead = '
<panel id="pnlBrowse" runat="server" path="component/bootstrap3/BrowsePanel.php">
      <!-- grid start here -->                          
      <table class="table table-striped table-bordered table-condensed"><thead><tr>';
        $strgrid = '         <tr onclick="rowclick(this,\'<?php echo getEventURL("rowclick",$showall->row[\'id\'],"'.$Appgatename.'"); ?>\');" style="cursor: pointer;">
';
        $strgridflds = '';
        $strgridheader = '';
        
        foreach ($dbfields as $key => $dbfield) {
            if($key!="id" && $key!="spcmpid"){
                      $strfield = $this->getEditFormField($dbfield, "frmSearch","searchby_");
            $strgridhead .= '<th class="girdhead-bg">
                      <a href="#" onclick="return getSortBy(this,\''.$dbfield['Field'].'\',\'<?php echo getEventURL(\'sortby\',\'\',\''.$Appgatename.'\'); ?>\');">'. $this->convertFieldName($strfield[1]).'<span class="pull-right hidden-xs showopacity fa fa-download"></span></a></th>
                ';
            $strgrid .= '             <td class="col-md-1"><?php echo $showall->row[\''.$dbfield['Field'].'\']; ?> </td>
';
        $strgridflds .= $dbfield['Field'] .',';
        $strgridheader .= $this->convertFieldName($strfield[1]) .',';
                if($col==0){
                    $blnFirst = false;
                    $strsearch .= '    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label id="lbl1" path="component/bootstrap3/HLabel.php" fupsetLabel="'. $this->convertFieldName($strfield[1]).',|searchby_'.$dbfield['Field'].'" runat="server" funsetSize="col-md-4,|col-md-8">
                '.$strfield[0].'
            </label>
        </div>
';
                    $col += 1;
                }else{
                    $strsearch .= '        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label id="lbl1" path="component/bootstrap3/HLabel.php" fupsetLabel="'. $this->convertFieldName($strfield[1]).',|searchby_'.$dbfield['Field'].'" runat="server" funsetSize="col-md-4,|col-md-8">
                '.$strfield[0].'
            </label>
        </div>
</div>';
        $col = 0;
                }
                
            }
        }
$colwidth = intval(100 / (count(explode(',', $strgridflds)) - 1)) ;       
        $strgrid = '     </tr></thead><tbody id="showall" runat="server" path="component/common/Grid/Grid.php" funsetFieldNames="'.substr($strgridflds, 0,strlen($strgridflds)-1).'" funsetHeaderNames="'.substr($strgridheader, 0,strlen($strgridheader)-1).'" funsetColWidths="'.$colwidth.'%" dtable="'.$tablename.'" funsetAJAX=""  
            >
' .$strgrid .'</tr></tbody><tfoot>
          <tr><td><div id="pagebar"><?php echo $showall->getPageBar() ; ?></div></td></tr>
      </tfoot>
    </table>
      <!-- grid end here -->                          
                </panel> 
';
if($col > 0){
    $strsearch .= '</div>';
}   
$strsearch .= '<div class="align-right"><br />
              <input type="submit" value="Search" class="btn btn-primary btn-small" />
              <input type="reset" value="Clear" class="btn btn-primary btn-small" />
          </div>
      </form></panel>' ;
return $strsearch . $strgridhead .$strgrid;
    }
   public function getApp($tablename,$Appgatename="") {
        $strout = '<?php
include_once("classes/AutoApp.php");

class '. $Appgatename.' extends AutoApp{
// call before object initialize 
    public function onstart(){
        global $mebmasterf;
        $this->getAuthenticate("GUEST");
        $this->setTableName("'.$tablename.'");
        $this->setMasterFile($mebmasterf);
        $this->appclass = "'. $Appgatename .'";
        parent::onstart();
        $this->showallFront->getComponent(\'showall\')->setWhere("WHERE deluid=\'" . $this->Client->session(\'unumid\') ."\'");
    }
    // call after every object initialize 
    public function onready(){
    }
    
    public function page_event_usersrch($param) {
        $showall = $this->showallFront->getComponent(\'showall\');
        $searchby_aname = $this->showallFront->getComponent(\'searchby_aname\');
        $showall->setWhere("WHERE aname LIKE \'%{$searchby_aname->value}%\' ");
        parent::page_event_usersrch($param);
    }
     
}
     ';
        return $strout;
    }
    private function convertFieldName($fieldname){
        $fieldname = str_replace("_", " ", $fieldname);
        return ucwords($fieldname);
    }
    public function getEditFormFieldLabel($dbfield,$formid="form2",$idprefix="") {
      $strfield = $this->getEditFormField($dbfield, $formid,$idprefix);
      $strout = '            <label for="'. $idprefix . $dbfield['Field'] .'">'. $this->convertFieldName($strfield[1]) .'</label>
	  '. $strfield[0] .'
';
        return $strout;
    }

    public function getEditFormField($dbfield,$formid="form2",$idprefix="") {
        $name = $dbfield['Field'];
        $msgname = $dbfield['Field'];
        $type = $dbfield['Type']; // varchar(50)
        $null = $dbfield['Null']; // YES,NO
        $key = $dbfield['Key']; // PRI == Primary and Index
        $default = $dbfield['Default']; // Default Value
        $extra = $dbfield['Extra']; // extra information like auto_increment
        $fronta = explode("(",$type);
        $datatype = strtoupper($fronta[0]);
        if(isset($fronta[1])){
            $datalen = str_replace(")", "", $fronta[1]);
        }else{
            $datalen = 4;
        }
        $comptype = "text";
        $blnnotfound = false;
        switch (substr($name,0,3)){
            case "slt":{
                $comptype = "Select";
                break;
            }
            case "txa":{
                $comptype = "TextArea";
                break;
            }
            case "txt":{
                $comptype = "Text";
                break;
            }
            case "num":{
                $comptype = "Numeric";
                break;
            }
            case "rad":{
                $comptype = "Radio";
                break;
            }
            case "eml":{
                $comptype = "Email";
                break;
            }
            case "dat":{
                $comptype = "Date";
                break;
            }
            case "chk":{
                $comptype = "CheckBox";
                break;
            }
            case "nan":{
                $comptype = "";
                break;
            }
        default :{
            $blnnotfound = true;
        }
        }
if($blnnotfound){
if($datatype=="DATE" || $datatype=="DATETIME"){
    $comptype = "Date";
}else if($datalen<14){
    $comptype = "Select";
}else if($datalen>200){
    $comptype = "TextArea";
}else{
    $comptype = "Text";
  }
}else{
    $msgname = substr($name,3);
}            

switch ($comptype){
            case "Select":{
        $strfield = '<select id="'.$idprefix.$name.'" runat="server" dfield="'.$name.'" class="form-control" funsetForm="'.$formid.'" funsetMsgName="'. $this->convertFieldName($msgname).'" funsetOptions="'.$datalen.'" ></select>
';
                break;
            }
            case "TextArea":{
        $strfield = '<textarea id="'.$idprefix.$name.'" runat="server" dfield="'.$name.'" class="form-control" funsetForm="'.$formid.'" funsetMsgName="'. $this->convertFieldName($msgname).'" funsetMaxLen="'.$datalen.'" ></textarea>
';
                break;
            }
            case "Date":{
        $strfield = '<input id="'.$idprefix.$name.'" runat="server" type="date" dfield="'.$name.'" class="form-control" funsetForm="'.$formid.'" funsetMsgName="'. $this->convertFieldName($msgname).'" funsetMaxLen="'.$datalen.'" />
';            
                break;
            }
            case "Numeric":{
        $strfield = '<input id="'.$idprefix.$name.'" runat="server" type="text" dfield="'.$name.'" class="form-control" funsetForm="'.$formid.'" funsetMsgName="'. $this->convertFieldName($msgname).'" funsetMaxLen="'.$datalen.'" funsetNumeric="" />
';            
                break;
            }
            case "Email":{
        $strfield = '<input id="'.$idprefix.$name.'" runat="server" type="text" dfield="'.$name.'" class="form-control" funsetForm="'.$formid.'" funsetMsgName="'. $this->convertFieldName($msgname).'" funsetMaxLen="'.$datalen.'" funsetEmail="" />
';            
                break;
            }
            case "CheckBox":{
        $strfield = '<input id="'.$idprefix.$name.'" runat="server" type="checkbox" value="value1" dfield="'.$name.'" class="form-control" funsetForm="'.$formid.'" funsetMsgName="'. $this->convertFieldName($msgname).'" />
';            
                break;
            }
            case "Radio":{
        $strfield = '<input id="'.$idprefix.$name.'" runat="server" type="radio" value="value1" dfield="'.$name.'" class="form-control" funsetForm="'.$formid.'" funsetMsgName="'. $this->convertFieldName($msgname).'" />
';            
                break;
            }
        default :{
                $strg = "";
                if($datatype=="INT"){
                $strg = 'funsetNumeric=""';
                }
        $strfield = '<input id="'.$idprefix.$name.'" runat="server" type="text" dfield="'.$name.'" class="form-control" funsetForm="'.$formid.'" funsetMsgName="'. $this->convertFieldName($msgname).'" funsetMaxLen="'.$datalen.'" '.$strg.' />
';            
            }
       }
       return array($strfield,$msgname);
    }

    
}
}
