<?php
/**
 * Description of AutoAppPermis
 *
 * @author Sartaj
 */
include_once(SphpBase::sphp_settings()->lib_path . "/dev/QueryBuilder.php");
include_once(SphpBase::sphp_settings()->slib_path . "/apps/permis/PermisGate.php");
// may use div tag id edtFormHolder for editor form

class AutoGatePermis extends PermisGate {

    public $heading = "heading";
    public $footer = "set footer property of app, for logo image set logoimg";
    public $logoimg = "apps/helper/fronts/logo.png";
    public $phone = "6AA-AAA-AAAA";    
    public $mobile = "AAA-AAA-AAAA";    
    public $address = "address";    
    public $city = "Mississauga";    
    public $country = "Canada";    
    protected $insertedid = -1;
    protected $blndisableperm = false;

    public $extra = array();
    public $recID = "";
    public $recWhere = "";
    public $printstyle = "test";
    public $printstylefile = __DIR__ ."/fronts/style.css";


    public function onstart() {
        $this->logoimg = SphpBase::sphp_settings()->slib_res_path ."/apps/helper/fronts/logo.png";
        $this->showallFront->getComponent('showall')->fu_unsetRenderTag();
        $this->genFormFront->getComponent('btnDel')->fu_unsetRender();
        $this->showallFront->getComponent('showall')->setPerPageRows(10);
        SphpBase::sphp_api()->addProp('page_title',$this->heading);
    }

    public function page_event_loadform($evtp) {
        $this->showallFront->getComponent('showall')->fu_setRenderTag();
        //$this->JSServer->addJSONFront($this->genFormFront,'showall_editor');
        $this->JSServer->addJSONFront($this->showallFront, 'listFormHolder');
//      $this->JSServer->addJSONBlock('html','listheading',$listheading->innerHTML);
//      $this->JSServer->addJSONBlock('html','editheading',$editheading->innerHTML);
    }

    public function page_new() {
        $this->showallFront->getComponent('showall')->fu_setRenderTag();
        //$tmp = new FrontFile('This is not a standalone Application!', true);
        //trigger_error('This is not a standalone Application!');
        $this->setFrontFile($this->showallFront);
    }

// user event handling start here
    public function page_event_test($param) {
        $this->setFrontFile($this->showallFront);
    }

    public function page_event_showall_show($param) {
        $showall = $this->showallFront->getComponent('showall');
        $this->JSServer->addJSONComp($showall, 'showall');
        $this->JSServer->addJSONBlock('html', 'pagebar', $showall->getPageBar());
    }

    public function page_event_print($param) {
        $this->printstyle = \SphpBase::sphp_api()->getDynamicContent($this->printstylefile);
        $showall = $this->showallFront->getComponent('showall');
        require($this->phppath . '/classes/bundle/reports/html2pdf/Front2PDF.php');
        $showsingleFront = new Sphp\tools\FrontFileChild(__DIR__ ."/fronts/pdf_temp.front",false,null,$this->showallFront);
        $showall->unsetAddButton();
        $showall->unsetDialog();
        $showall->unsetPageBar();
//        $showsingleFront->addMetaData('uni_id',"FF45678");
        //$showsingleFront->run();
        //echo $showsingleFront->data;
        
        $pdf = new Front2PDF($showsingleFront);
        $pdf->setDefaultFont('Arial');
        $pdf->render('sample.pdf', 'I');
          
         
    }

    public function page_event_usersrch($param) {
        $showall = $this->showallFront->getComponent('showall');
        if (!getCheckErr()) {
            if (!getCheckErr()) {
                $this->JSServer->addJSONComp($showall, 'showall');
                //$this->JSServer->addJSONFront($this->genFormFront, 'showall_editor');
                $this->JSServer->addJSONBlock('html', 'pagebar', $showall->getPageBar());
            } else {
                setErr('app1', 'Can not Search Data');
                $this->sendError();
            }
        } else {
            setErr('app1', 'Can not Search Data');
            $this->sendError();
        }
    }

    public function page_event_up($param) {
        if ($this->Client->request('txtid') != "") {
            $this->update();
        } else {
            $this->insert();
        }
    }

    public function page_event_rowclick($param) {
        if($this->blndisableperm == true || $this->hasPermission("view")){
        $this->Client->session("formType", "Edit");
        $this->page->viewData($this->genFormFront->getComponent('form2'));
        $this->genFormFront->getComponent('btnDel')->fu_setRender();
        $this->JSServer->addJSONJSBlock('$( "#showall_dlg" ).dialog( "open" );');
        $this->JSServer->addJSONFront($this->genFormFront, 'showall_editor');
//        $this->JSServer->addJSONBlock('html','frmstatus',"Form is on Update Mode!");
        }else{
            setErr("app2", "Permission Denied");
            $this->sendError();
        }

    }
 
    public function page_event_showall_newa($param) {
        $this->page_event_addform($param);
    }
    public function page_event_addform($param) {
	if(isset($_SESSION['curtrec'])){
            unset($_SESSION['curtrec']);
        }
        $this->Client->session("formType", "Add");
        $this->JSServer->addJSONFront($this->genFormFront, 'showall_editor');
    }

// user event handling end here
    public function page_event_crossclick($param) {
        $this->page->viewData($this->genFormFront->getComponent('form2'));
        $this->genFormFront->getComponent('btnDel')->fu_setRender();
        $extupdate = array();
        $extupdate["up"] = 12;
        $extupdate["previd"] = $this->Client->request("previd");
        $extupdate["prevctrl"] = $this->Client->request("prevctrl");
        $this->Client->session("extupdate", $extupdate);
        $this->JSServer->addJSONFront($this->genFormFront, 'showall_editor');
    }

    public function page_insert() {
        global $cmpid;
        if($this->blndisableperm == false && !$this->hasPermission("add")){
            setErr("app2", "Permission Denied");
        }
        $this->extra[]['userid'] = $this->Client->session('sid');
        $this->extra[]['parentid'] = $this->Client->session('parentid');
        $this->extra[]['spcmpid'] = $cmpid;
        $this->extra[]['submit_timestamp'] = time();
        $this->extra[]['update_timestamp'] = time();
        
        $blnsendList = $this->checkCrossCall();
        if (!getCheckErr()) {
            $this->insertedid = $this->page->insertData($this->extra);
            if (!getCheckErr()) {
                //setMsg('app1','New Data Record is Inserted, want more record add fill form again' );
                //$JSServer->addJSONBlock('jsp','proces','$( "#showall_dlg" ).dialog( "close" );');
                if ($blnsendList) {
                    $this->JSServer->addJSONComp($this->showallFront->getComponent('showall'), 'showall');
                } else {
                    $this->sendCrossCall();
                }
                //$this->JSServer->addJSONBlock('jsp', 'proces', '$("#editform").modal("hide");');
                $this->JSServer->addJSONBlock('jsp','proces','$( "#showall_dlg" ).dialog( "close" );');
                $this->sendSuccess('Data is inserted in Database');
                $this->sendError();
            } else {
                setErr('app1', 'Can not add Data');
                $this->sendError();
            }
        } else {
            setErr('app1', 'Can not add Data');
            $this->sendError();
        }
        
    }

    public function checkCrossCall() {
        $extupdate = $this->Client->session("extupdate");
        if (isset($extupdate["up"]) && $extupdate["up"] == 12) {
            $extupdate["up"] = 11;
            $this->Client->session("extupdate", $extupdate);
            return false;
        } else {
            return true;
        }
    }

    public function sendCrossCall() {
        $extupdate = $this->Client->session("extupdate");
        $this->JSServer->addJSONJSBlock("getURL('" . getEventURL("rowclick", $extupdate['previd'], $extupdate["prevctrl"]) . "');");
    }

    public function page_update() {
        if($this->blndisableperm == false && !$this->hasPermission("view")){
            setErr("app2", "Permission Denied");
        }
        $blnsendList = $this->checkCrossCall();
        if (!getCheckErr()) {
            $this->page->updateData($this->extra, $this->recID, $this->recWhere);
            if (!getCheckErr()) {
                if ($blnsendList) {
                    $this->JSServer->addJSONComp($this->showallFront->getComponent('showall'), 'showall');
                    //$this->JSServer->addJSONJSBlock(" setFormAsNew('form2');");
                } else {
                    $this->sendCrossCall();
                }
                //$this->JSServer->addJSONBlock('jsp', 'proces', '$("#editform").modal("hide");');
                $this->JSServer->addJSONBlock('jsp','proces','$( "#showall_dlg" ).dialog( "close" );');
                $this->sendSuccess('Record is updated');
            } else {
                setErr('app1', 'Record can not update');
                $this->sendError();
            }
        } else {
            setErr('app1', 'Record can not update');
            $this->sendError();
        }
    }

    public function page_delete() {
        if($this->blndisableperm == false && !$this->hasPermission("delete")){
            setErr("app2", "Permission Denied");
        }
        $blnsendList = $this->checkCrossCall();
        if (!getCheckErr()) {
            $this->page->deleteRec();
        if (!getCheckErr()) {
            if ($blnsendList) {
                $this->JSServer->addJSONComp($this->showallFront->getComponent('showall'), 'showall');
                $this->JSServer->addJSONFront($this->genFormFront, 'showall_editor');
            } else {
                $this->sendCrossCall();
            }
            //$this->JSServer->addJSONBlock('jsp', 'proces', '$("#editform").modal("hide");');
            $this->JSServer->addJSONBlock('jsp','proces','$( "#showall_dlg" ).dialog( "close" );');
            $this->sendSuccess('Record is Deleted');
        } else {
            setErr('app1', 'Record could not be deleted');
            $this->sendError();
        }
        } else {
            setErr('app1', 'Record could not be deleted P');
            $this->sendError();
        }
    }

    public function sendSuccess($msg) {
        $this->JSServer->addJSONBlock('html', 'sphpsuccessmsg', $msg);
        $this->JSServer->addJSONJSBlock('runanierr("success");');
    }

    public function sendWarning($msg) {
        $this->JSServer->addJSONBlock('html', 'sphpwarningmsg', $msg);
        $this->JSServer->addJSONJSBlock('runanierr("warning");');
    }

    public function sendError($errorInner = "") {
        $msg = traceMsg(true);
        $err = traceError(true);
        if ($errorInner == "") {
            $erri = traceErrorInner(true);
            if ($erri != "") {
                $errorInner = "Something goes wrong!";
            } 
        }
        if ($msg != "") {
            $this->JSServer->addJSONBlock('html', 'sphpinfomsg', $msg);
            $this->JSServer->addJSONJSBlock('runanierr("info");');
        }
        if ($err != "" || $errorInner != "") {
            $this->JSServer->addJSONBlock('html', 'sphperrormsg', $err . ' ' . $errorInner);
            $this->JSServer->addJSONJSBlock('runanierr("error");');
        }
    }

    public function sendInfo($msg) {
        $msg1 = traceMsg(true);
        $this->JSServer->addJSONBlock('html', 'sphpinfomsg', $msg . $msg1);
        $this->JSServer->addJSONJSBlock('runanierr("info");');
    }


}
