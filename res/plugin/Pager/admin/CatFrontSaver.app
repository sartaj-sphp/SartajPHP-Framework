<?php
/**
 * Description of PageFrontSaver
 *
 * @author sartaj
 */
class CatFrontSaver extends \Sphp\tools\BasicApp{
    private $tmp1 = null;
    
    public function onstart() {
        global $tblName ;
        $tblName = "pagcategory";
        $this->setTableName($tblName);
        $this->getAuthenticate("ADMIN,MEMBER");
        $this->tmp1 = new TempFile($this->apppath . "/forms/catfrontsaver.front");
    }
    
    public function getGenForm() {
        global $formFields,$libpath,$genForm,$formHead,$cmpid;
        $formHead = "Add Edit Web Pages";
        
$formFields = ' $genForm = $this; 
$genForm->setField("atype","Category Type","select","Parent,Sub");
$genForm->setField("aparent","Category Parent","select");
$genForm->setField("aname","Category Name","text","r","3","200");
$genForm->setField("rank","Category Rank","num","","","4");
$genForm->setField("spcmpid"," ","hidden");
';

$tmp2 = new TempFile($this->apppath . "/forms/GenForm.front");
$tmp2->aparent->setOptionsFromTable('aname','','pagcategory',"WHERE spcmpid='$cmpid' ORDER BY aname");
$tmp2->aparent->unsetOptionsKeyArray();
$tmp2->aparent->setOptions("NONE," . $tmp2->aparent->getOptions());

return $tmp2;
    }    
    public function page_event_pgnew($param) {
        $tmp2 = $this->getGenForm();
        $tmp2->genForm->firecompcreate();
        $tmp2->form2->action = getEventURL('pgins');
        $this->JSServer->addJSONTemp($tmp2,'sdpage_editor');
        $this->JSServer->addJSONJSBlock('$("#sdpage_dlg").dialog("open");');
    } 
    public function page_event_pgedit($param) {
        $tmp2 = $this->getGenForm();
        $tmp2->genForm->firecompcreate();
        $this->page->viewData($tmp2->form2,$this->Client->request("txtid"));
        $tmp2->aname->setPreTag('<input type="hidden" name="aname2" value="'. $tmp2->aname->value .'" />');
        $tmp2->form2->action = getEventURL('pgup');
        //$tmp2 = new TempFile($this->apppath . "forms/pagefront2.front");
        $this->JSServer->addJSONTemp($tmp2,'sdpage_editor');
        $this->JSServer->addJSONJSBlock('$("#sdpage_dlg").dialog("open");');
    } 
    public function page_event_pgup($param) {
        $tmp2 = $this->getGenForm();
        $tmp2->genForm->firecompcreate();
        if(!getCheckErr()){
        //$this->JSServer->addJSONTemp($tmp2,'sdpage_editor');
            $this->page->updateData();
                //$this->JSServer->addJSONHTMLBlock('frmerrdet',"update ". $txtid .traceError(true) . traceErrorInner(true));                
            if(!getCheckErr()){
                $sql = "UPDATE pagdet SET catname='". $tmp2->aname->value ."' WHERE catname='". $this->Client->request("aname2") . "'";
                //SphpBase::debug()->println($sql);
                $this->dbEngine->executeQueryQuick($sql);
                $this->JSServer->addJSONJSBlock('$("#sdpage_dlg").dialog("close"); window.location.reload();');
            }else{
                $this->JSServer->addJSONHTMLBlock('frmmsgdet',traceMsg(true));
                $this->JSServer->addJSONHTMLBlock('frmerrdet',traceError(true).traceErrorInner(true));                
            }
        }else{
            setErr('app1','Can not Update Data' );
            $this->JSServer->addJSONHTMLBlock('frmmsgdet',traceMsg(true));
            $this->JSServer->addJSONHTMLBlock('frmerrdet',traceError(true).traceErrorInner(true));
        }
        
    }    
    public function page_event_pgins($param) {
        global $cmpid;
        $tmp2 = $this->getGenForm();
        $tmp2->genForm->firecompcreate();
        if($this->dbEngine->isRecordExist("SELECT aname FROM pagcategory WHERE spcmpid='$cmpid' AND aname='". $tmp2->aname->value ."'")){
            setErr('Catname', 'You can not add more Category with same name!');
            $this->JSServer->addJSONHTMLBlock('frmerrdet','You can not add more pages with same name!');
        }else{
            $tmp2->spcmpid->value = $_SESSION['uid'];
            $tmp2->spcmpid->setDataBound();
            if(!getCheckErr()){
                $this->page->insertData();
                $this->JSServer->addJSONJSBlock('$("#sdpage_dlg").dialog("close"); window.location.reload();');
                //setMsg('app1','New Data Record is Inserted, want more record add fill form again' );
            }else{
                setErr('app1','Can not Insert Data' );
            }
            $this->JSServer->addJSONHTMLBlock('frmmsgdet',traceMsg(true));
            $this->JSServer->addJSONHTMLBlock('frmerrdet',traceError(true).traceErrorInner(true));
        }

    }    
    public function page_event_pgdel($param) {
        $tmp2 = $this->getGenForm();
        $tmp2->genForm->firecompcreate();
        $txtid = $this->Client->request("txtid");
        $this->page->evtp = $txtid;
        //$this->page->viewData($tmp2->form2,$txtid);
        if(!getCheckErr()){
            $this->page->deleteRec();
        }else{
            
        }
    }
}
