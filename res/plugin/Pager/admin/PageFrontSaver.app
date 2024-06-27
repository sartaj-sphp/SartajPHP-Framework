<?php
/**
 * Description of PageFrontSaver
 *
 * @author sartaj
 */
class PageFrontSaver extends \Sphp\tools\BasicApp{
    private $tmp1 = null;
    
    public function onstart() {
        global $tblName ;
        $tblName = "pagdet";
        $this->setTableName($tblName);
        $this->getAuthenticate("ADMIN,MEMBER");
        $this->tmp1 = new TempFile($this->apppath . "/forms/pagefrontsaver.front");
    }
    
    public function getGenForm() {
        global $formFields,$libpath,$genForm,$formHead,$cmpid;
        $formHead = "Add Edit Web Pages";
        
$formFields = ' $genForm = $this; 
$genForm->setField("pagesubttitle","Web Title","text","r","2","300");
$genForm->setField("pagetitle","Page Title","text","","","70");
$genForm->setField("pagedes","Meta Description","text","","","150");
$genForm->setField("pagekey","Meta Keywords","text","","","850");
$genForm->setField("catname","Category","select");
$genForm->setField("pagestatus","Ban","select","NO,YES");
$genForm->setField("menustatus","Show Menu","select","YES,NO");
$genForm->setField("menuname","Menu Name","text","","","40");
$genForm->setField("rank","Menu Rank","num","","","4");
$genForm->setField("filepath1","FileName","file","","2","200000");
$genForm->setField("filepath2","FileName","file","","2","200000");
$genForm->setField("spcmpid"," ","hidden");
$genForm->setField("pagename"," ","hidden");
';

$tmp2 = new TempFile($this->apppath . "/forms/GenForm.front");
$tmp2->catname->setOptionsFromTable('aname','','pagcategory',"WHERE spcmpid='$cmpid' ORDER BY aname");
        
$tmp2->filepath1->setFileSavePath("pagres/". $tmp2->pagename->value .'-1.'.$tmp2->filepath1->getFileExtention());
$tmp2->filepath2->setFileSavePath("pagres/". $tmp2->pagename->value .'-2.'.$tmp2->filepath2->getFileExtention());
$tmp2->filepath1->setFileTypesAllowed("image/pjpeg,image/jpeg,image/gif,image/x-png,image/png");
$tmp2->filepath2->setFileTypesAllowed("image/pjpeg,image/jpeg,image/gif,image/x-png,image/png");
if($tmp2->pagename->issubmit){
$tmp2->pagename->value = str_replace(" ", "_",  strtolower($tmp2->pagetitle->value));
$tmp2->pagename->setDataBound();
}

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
        $tmp2->form2->action = getEventURL('pgup');
        $tmp2->pagename->setPreTag('<input type="hidden" name="pagename2" value="'. $tmp2->pagename->value .'" />');
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
             if("pagres/". $this->Client->request("pagename2") .".html" != "pagres/". $tmp2->pagename->getValue().".html"){
                $v = rename("pagres/". $this->Client->request("pagename2") .".html", "pagres/". $tmp2->pagename->getValue().".html");
                if(!$v) setErr('app1', 'Can not rename ' . $tmp2->pagename->getValue());
             }
                //$this->JSServer->addJSONJSBlock('$("#sdpage_dlg").dialog("close"); window.location.reload();');
                $this->JSServer->addJSONJSBlock('$("#sdpage_dlg").dialog("close"); window.location.href = "'. getEventURL($tmp2->pagename->getValue()) .'";');
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
        if($this->dbEngine->isRecordExist("SELECT pagename FROM pagdet WHERE spcmpid='$cmpid' AND pagename='". $tmp2->pagename->value ."'")){
            setErr('Pagename', 'You can not add more pages with same name!');
            $this->JSServer->addJSONHTMLBlock('frmerrdet','You can not add more pages with same name!');
        }else{
            $tmp2->spcmpid->value = $_SESSION['uid'];
            $tmp2->spcmpid->setDataBound();
            if(!getCheckErr()){
                $this->page->insertData();
                if(!getCheckErr()){
                        file_put_contents("pagres/". $tmp2->pagename->getValue().".html",'demo content');
                        $this->page->forward(getEventURL($tmp2->pagename->getValue(),'',"page"));
                }                
                $this->JSServer->addJSONJSBlock('$("#sdpage_dlg").dialog("close"); window.location.reload();');
                //setMsg('app1','New Data Record is Inserted, want more record add fill form again' );
            }else{
                setErr('app1','Can not Insert Data' );
            }
            $this->JSServer->addJSONHTMLBlock('frmmsgdet',traceMsg(true));
            $this->JSServer->addJSONHTMLBlock('frmerrdet',traceError(true).traceErrorInner(true));
        }

    }    
    public function page_event_pgdata($param) {
        if($this->tmp1->tinydetails->issubmit){
            file_put_contents("pagres/". $this->tmp1->pagename->getValue().".html",$this->tmp1->tinydetails->getValue());
            $this->page->forward(getEventURL($this->tmp1->pagename->getValue(),'',"page"));
        }

    }
    public function page_event_pgdel($param) {
        $tmp2 = $this->getGenForm();
        $tmp2->genForm->firecompcreate();
        $txtid = $this->Client->request("txtid");
        $this->page->evtp = $txtid;
        $this->page->viewData($tmp2->form2,$txtid);
        $pathf = "pagres/".$tmp2->pagename->getValue().".html";
        if(file_exists($pathf)){unlink($pathf);}
        $this->page->deleteRec();
        if(!getCheckErr()){
            $this->JSServer->addJSONJSBlock('window.location.reload();');
        }
    }
}
