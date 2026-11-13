<?php

/**
 * Description of PageFrontSaver
 *
 * @author sartaj
 */
class PageFrontSaver extends \Sphp\Tools\BasicGate {

    private $tmp1 = null;

    public function onstart() {   
        global $tblName;
        $tblName = "pagdet";
        $this->setTableName($tblName);
        $this->getAuthenticate("ADMIN,MEMBER");
        $this->tmp1 = new FrontFile($this->apppath . "/forms/pagefrontsaver.front");
    }

    public function getGenForm() {
        global $formFields, $libPath, $genForm, $formHead, $cmpId;
        $formHead = "Add Edit Web Pages";

        $formFields = ' $genForm = $this; 
$genForm->setField("pagesubttitle","Page Title","text","r","2","300");
$genForm->setField("pagetitle","Page Head","text","","","70");
$genForm->setField("pagedes","Meta Description","text","","","150");
$genForm->setField("pagekey","Meta Keywords","text","","","850");
$genForm->setField("catname","Category","select");
$genForm->setField("pagestatus","Ban","select","NO,YES");
$genForm->setField("menustatus","Show Menu","select","YES,NO");
$genForm->setField("menuname","Menu Name","text","","","40");
$genForm->setField("rank","Menu Rank","num","","","4");
$genForm->setField("spcmpId"," ","hidden");
$genForm->setField("pagename"," ","hidden");
';

        $tmp2 = new FrontFile($this->apppath . "/forms/GenForm.front");
        $tmp2->catname->setOptionsFromTable('id,aname', 'id,aname', 'pagcategory', "WHERE spcmpId='$cmpId' ORDER BY aname");

        if ($tmp2->pagename->blnSubmit) {
            $tmp2->pagename->value = str_replace(" ", "_", strtolower($tmp2->pagetitle->value));
            $tmp2->pagename->setDataBound();
        }

/* disable pictures
 * $genForm->setField("filepath1","FileName","file","","2","200000");
$genForm->setField("filepath2","FileName","file","","2","200000");
        $tmp2->filepath1->setFileSavePath("pagres/" . $tmp2->pagename->value . '-1.' . $tmp2->filepath1->getFileExtention());
        $tmp2->filepath2->setFileSavePath("pagres/" . $tmp2->pagename->value . '-2.' . $tmp2->filepath2->getFileExtention());
        $tmp2->filepath1->setFileTypesAllowed("image/pjpeg,image/jpeg,image/gif,image/x-png,image/png");
        $tmp2->filepath2->setFileTypesAllowed("image/pjpeg,image/jpeg,image/gif,image/x-png,image/png");
 * 
 */
        return $tmp2;
    }

    public function page_event_pgnew($param) {
        $tmp2 = $this->getGenForm();
        $tmp2->genForm->firecompcreate();
        $tmp2->form2->action = getEventUrl('pgins');
        $this->jsServer->addJsonTemp($tmp2, 'sdpage_editor');
        $this->jsServer->addJsonJsBlock('$("#sdpage_dlg").dialog("open");');
    }

    public function page_event_pgedit($param) {
        $tmp2 = $this->getGenForm();
        $tmp2->genForm->firecompcreate();
        $this->page->viewData($tmp2->form2, $this->client->request("txtid"));
        $tmp2->form2->action = getEventUrl('pgup');
        $tmp2->pagename->setPreTag('<input type="hidden" name="pagename2" value="' . $tmp2->pagename->value . '" />');
        //$tmp2 = new FrontFile($this->apppath . "forms/pagefront2.front");
        $this->jsServer->addJsonTemp($tmp2, 'sdpage_editor');
        $this->jsServer->addJsonJsBlock('$("#sdpage_dlg").dialog("open");');
    }

    public function page_event_pgup($param) {
        $tmp2 = $this->getGenForm();
        $tmp2->genForm->firecompcreate();
        if (!getCheckErr()) {
            if ($this->client->request("pagename2") == "home") {
                $tmp2->pagename->setDontUpdate();
                $tmp2->pagename->value = "home"; // never change home page name
            }
                $extra = array();
                $extra[]["catid"] = explode(",", $tmp2->catname->value)[0];
            //$this->jsServer->addJsonTemp($tmp2,'sdpage_editor');
            $this->page->updateData($extra);
            //$this->jsServer->addJsonHtmlBlock('frmerrdet',"update ". $txtid .traceError(true) . traceErrorInner(true));                
            if (!getCheckErr()) {
                // now no need rename, change html file name with id
                /*
                if ("pagres/" . $this->client->request("pagename2") . ".html" != "pagres/" . $tmp2->pagename->getValue() . ".html") {
                    $v = rename("pagres/" . $this->client->request("pagename2") . ".html", "pagres/" . $tmp2->pagename->getValue() . ".html");
                    if (!$v)
                        setErr('app1', 'Can not rename ' . $tmp2->pagename->getValue());
                }
                 * 
                 */
                $this->jsServer->addJsonJsBlock('$("#sdpage_dlg").dialog("close"); window.location.reload();');
                //$this->jsServer->addJsonJsBlock('$("#sdpage_dlg").dialog("close"); window.location.href = "'. getEventUrl($tmp2->pagename->getValue()) .'";');
            } else {
                $this->jsServer->addJsonHtmlBlock('frmmsgdet', traceMsg(true));
                $this->jsServer->addJsonHtmlBlock('frmerrdet', traceError(true) . traceErrorInner(true));
            }
        } else {
            setErr('app1', 'Can not Update Data');
            $this->jsServer->addJsonHtmlBlock('frmmsgdet', traceMsg(true));
            $this->jsServer->addJsonHtmlBlock('frmerrdet', traceError(true) . traceErrorInner(true));
        }
    }

    public function page_event_pgins($param) {
        global $cmpId;
        $tmp2 = $this->getGenForm();
        $tmp2->genForm->firecompcreate();
        if ($this->dbEngine->isRecordExist("SELECT pagename FROM pagdet WHERE spcmpId='$cmpId' AND pagename='" . $tmp2->pagename->value . "'")) {
            setErr('Pagename', 'You can not add more pages with same name!');
            $this->jsServer->addJsonHtmlBlock('frmerrdet', 'You can not add more pages with same name!');
        } else {
            $tmp2->spcmpId->value = $cmpId;
            $tmp2->spcmpId->setDataBound();
            if (!getCheckErr()) {
                $extra = array();
                $extra[]["catid"] = explode(",", $tmp2->catname->value)[0];
                $id1 = $this->page->insertData($extra);
                if (!getCheckErr()) {
                    file_put_contents("pagres/a{$id1}.html", 'demo content');
                    file_put_contents("pagres/b{$id1}.html", 'demo content');
                    $this->page->forward(getEventUrl($tmp2->pagename->getValue(), '', "page"));
                }
                $this->jsServer->addJsonJsBlock('$("#sdpage_dlg").dialog("close"); window.location.reload();');
                //setMsg('app1','New Data Record is Inserted, want more record add fill form again' );
            } else {
                setErr('app1', 'Can not Insert Data');
            }
            $this->jsServer->addJsonHtmlBlock('frmmsgdet', traceMsg(true));
            $this->jsServer->addJsonHtmlBlock('frmerrdet', traceError(true) . traceErrorInner(true));
        }
    }

    public function page_event_pgdata($param) {
        if ($this->tmp1->tinydetails->blnSubmit) {
            file_put_contents("pagres/a" . $this->client->request('txtidtiny') . ".html", $this->tmp1->tinydetails->getValue());
            file_put_contents("pagres/b" . $this->client->request('txtidtiny') . ".html", $this->tmp1->tinydetails->processSphpComp());
            $this->page->forward(getEventUrl($this->tmp1->pagename->getValue(), '', "page"));
        }
    }

    public function page_event_pgdel($param) {
        $tmp2 = $this->getGenForm();
        $tmp2->genForm->firecompcreate();
        $txtid = $this->client->request("txtid");
        $this->page->evtp = $txtid;
        if($txtid == "1"){
            setErr("app1", "Home Page Can't Delete!");
        }
        if(!getCheckErr()){
        //$this->page->viewData($tmp2->form2, $txtid);
            $pathf = "pagres/a" . $txtid . ".html";
            if (file_exists($pathf)) {
                unlink($pathf);
            }
            $pathf = "pagres/b" . $txtid . ".html";
            if (file_exists($pathf)) {
                unlink($pathf);
            }
            $this->page->deleteRec();
            if (!getCheckErr()) {
                $this->page->forward(SphpBase::sphpSettings()->projectUrl);
            }
        }else{
            $this->jsServer->addJsonHtmlBlock('app1',traceMsg(true) . traceError(true).traceErrorInner(true));                        
        }
    }
    
    // tinymce Component support
    
    public function page_event_propedit($evtp){
        $sj1 = SphpBase::SphpJsM();
        $sj1::addBootStrap(); 
       $this->setMasterFile(SphpBase::sphpSettings()->slibPath . "/masters/default/master_empty.php");
       $this->setFrontFile(new FrontFile(__DIR__ . "/../TinyEditor/forms/plgpropertyedt.front"));
       
    }
    
}
