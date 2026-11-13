<?php
/**
 * Description of PageFrontSaver
 *
 * @author sartaj
 */
class CatFrontSaver extends \Sphp\Tools\BasicGate{
    private $tmp1 = null;
    
    public function onstart() {
        global $tblName ;
        $tblName = "pagcategory";
        $this->setTableName($tblName);
        $this->getAuthenticate("ADMIN,MEMBER");
        $this->tmp1 = new FrontFile($this->apppath . "/forms/catfrontsaver.front");
    }
    
    public function getGenForm() {
        global $formFields,$libPath,$genForm,$formHead,$cmpId;
        $formHead = "Add Edit Web Pages";
        
$formFields = ' $genForm = $this; 
$genForm->setField("atype","Category Type","select","Parent,Sub");
$genForm->setField("aparent","Category Parent","select");
$genForm->setField("aname","Category Name","text","r","3","200");
$genForm->setField("rank","Category Rank","num","","","4");
$genForm->setField("spcmpId"," ","hidden");
';

$tmp2 = new FrontFile($this->apppath . "/forms/GenForm.front");
$tmp2->aparent->setOptionsFromTable('aname','','pagcategory',"WHERE spcmpId='$cmpId' ORDER BY aname");
$tmp2->aparent->unsetOptionsKeyArray();
$tmp2->aparent->setOptions("NONE," . $tmp2->aparent->getOptions());

return $tmp2;
    }    
    public function page_event_pgnew($param) {
        $tmp2 = $this->getGenForm();
        $tmp2->genForm->firecompcreate();
        $tmp2->form2->action = getEventUrl('pgins');
        $this->jsServer->addJsonTemp($tmp2,'sdpage_editor');
        $this->jsServer->addJsonJsBlock('$("#sdpage_dlg").dialog("open");');
    } 
    public function page_event_pgedit($param) {
        $tmp2 = $this->getGenForm();
        $tmp2->genForm->firecompcreate();
        $this->page->viewData($tmp2->form2,$this->client->request("txtid"));
        $tmp2->aname->setPreTag('<input type="hidden" name="aname2" value="'. $tmp2->aname->value .'" />');
        $tmp2->form2->action = getEventUrl('pgup');
        //$tmp2 = new FrontFile($this->apppath . "forms/pagefront2.front");
        $this->jsServer->addJsonTemp($tmp2,'sdpage_editor');
        $this->jsServer->addJsonJsBlock('$("#sdpage_dlg").dialog("open");');
    } 
    public function page_event_pgup($param) {
        $tmp2 = $this->getGenForm();
        $tmp2->genForm->firecompcreate();
        if(!getCheckErr()){
        //$this->jsServer->addJsonTemp($tmp2,'sdpage_editor');
            $this->page->updateData();
                //$this->jsServer->addJsonHtmlBlock('frmerrdet',"update ". $txtid .traceError(true) . traceErrorInner(true));                
            if(!getCheckErr()){
                $sql = "UPDATE pagdet SET catname='". $tmp2->aname->value ."' WHERE catname='". $this->client->request("aname2") . "'";
                //SphpBase::debug()->println($sql);
                $this->dbEngine->executeQueryQuick($sql);
                $this->jsServer->addJsonJsBlock('$("#sdpage_dlg").dialog("close"); window.location.reload();');
            }else{
                $this->jsServer->addJsonHtmlBlock('frmmsgdet',traceMsg(true));
                $this->jsServer->addJsonHtmlBlock('frmerrdet',traceError(true).traceErrorInner(true));                
            }
        }else{
            setErr('app1','Can not Update Data' );
            $this->jsServer->addJsonHtmlBlock('frmmsgdet',traceMsg(true));
            $this->jsServer->addJsonHtmlBlock('frmerrdet',traceError(true).traceErrorInner(true));
        }
        
    }    
    public function page_event_pgins($param) {
        global $cmpId;
        $tmp2 = $this->getGenForm();
        $tmp2->genForm->firecompcreate();
        if($this->dbEngine->isRecordExist("SELECT aname FROM pagcategory WHERE spcmpId='$cmpId' AND aname='". $tmp2->aname->value ."'")){
            setErr('Catname', 'You can not add more Category with same name!');
            $this->jsServer->addJsonHtmlBlock('frmerrdet','You can not add more pages with same name!');
        }else{
            $tmp2->spcmpId->value = $cmpId;
            $tmp2->spcmpId->setDataBound();
            if(!getCheckErr()){
                $this->page->insertData();
                $this->jsServer->addJsonJsBlock('$("#sdpage_dlg").dialog("close"); window.location.reload();');
                //setMsg('app1','New Data Record is Inserted, want more record add fill form again' );
            }else{
                setErr('app1','Can not Insert Data' );
            }
            $this->jsServer->addJsonHtmlBlock('frmmsgdet',traceMsg(true));
            $this->jsServer->addJsonHtmlBlock('frmerrdet',traceError(true).traceErrorInner(true));
        }

    }    
    public function page_event_pgdel($param) {
        $tmp2 = $this->getGenForm();
        $tmp2->genForm->firecompcreate();
        $txtid = $this->client->request("txtid");
        $this->page->evtp = $txtid;
        if($txtid == "1"){
            setErr("app1", "Home Category Can't Delete!");
        }else{
            $result = $this->dbEngine->executeQueryQuick("SELECT COUNT(*) AS total FROM pagdet WHERE catid='$txtid'");
            $row = mysqli_fetch_assoc($result);
            if($row["total"] > 0) setErr("app1", "First Remove All Pages From Category! Total Pages Found in this Category = " . $row["total"]);
        }
        //$this->page->viewData($tmp2->form2,$txtid);
        if(!getCheckErr()){
            $this->page->deleteRec();
        }else{
            $this->jsServer->addJsonHtmlBlock('app1',traceMsg(true) . traceError(true).traceErrorInner(true));            
        }
    }
}
