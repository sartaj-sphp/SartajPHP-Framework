<?php
/**
 * Description of AutoGate
 *
 * @author Sartaj
 */
include_once("{$libpath}/dev/QueryBuilder.php");
// may use div tag id edtFormHolder for editor form

class AutoGate extends \Sphp\tools\BasicGate {

    /**
     *  @var \Sphp\tools\FrontFile
     */
    protected $genFormFront = null;

    /**
     *  @var \Sphp\tools\FrontFile
     */
    protected $showallFront = null;
    public $heading = "heading";
    public $footer = "set footer property of app, for logo image set logoimg";
    public $logoimg = "apps/helper/fronts/logo.png";
     public $phone = "6AA-AAA-AAAA";    
    public $mobile = "AAA-AAA-AAAA";    
    public $address = "address";    
    public $city = "Mississauga";    
    public $country = "Canada";    

    protected $insertedid = -1;
    protected $formid = "form2";

    public $extra = array();
    public $recID = "";
    public $recWhere = "";
    public $printstyle = "test";
    public $printstylefile = __DIR__ ."/fronts/style.css";

    public function onstart() {
        $this->logoimg = SphpBase::sphp_settings()->slib_res_path ."/apps/helper/fronts/logo.png";
        $this->showallFront->getComponent('showall')->fu_unsetRenderTag();
        $this->genFormFront->getComponent('btnDel')->fu_unsetRender();
        $this->showallFront->getComponent('showall')->fu_setPerPageRows(10);
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


    public function page_event_showall_show($evtp) {
        $showall = $this->showallFront->getComponent('showall');
        $this->JSServer->addJSONComp($showall, 'showall');
        $this->JSServer->addJSONBlock('html', 'pagebar', $showall->getPageBar());
    }

    public function page_event_print($evtp) {
        $this->printstyle = \SphpBase::sphp_api()->getDynamicContent($this->printstylefile);
        $showall = $this->showallFront->getComponent('showall');
        require($this->phppath . '/classes/bundle/reports/html2pdf/Front2PDF.php');
        $showsingleFront = new Sphp\tools\FrontFileChild(__DIR__ ."/fronts/pdf_temp.front",false,null,$this->showallFront);
        $showall->unsetAddButton();
        $showall->unsetDialog();
        $showall->unsetPageBar();
//        $showsingleFront->addMetaData('uni_id',"FF45678");
        $pdf = new Front2PDF($showsingleFront);
        $pdf->setDefaultFont('Arial');
        $pdf->render('sample.pdf', 'I');
    }

    public function page_event_usersrch($evtp) {
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

    public function page_event_up($evtp) {
        // Forward Request to submit event as Form Submit
        $this->page_submit();
    }
    /**
     * Browser Post Data on Landing URL. If Form is submitted Then 
     * Forward request to update or insert Database.
     */
    public function page_submit() {
        /** @var Sphp\Comp\Form\HTMLForm */
        $cmpForm = $this->genFormFront->getComponent($this->formid);
        if ($cmpForm->isUpdateRequest()) {
            $this->update();
        } else {
            $this->insert();
        }
    }

    public function page_event_rowclick($evtp) {
        $this->Client->session("formType", "Edit");
        $this->page->viewData($this->genFormFront->getComponent($this->formid));
        $this->genFormFront->getComponent('btnDel')->fu_setRender();
        $this->JSServer->addJSONJSBlock('$( "#showall_dlg" ).dialog( "open" );');
        $this->JSServer->addJSONFront($this->genFormFront, 'showall_editor');
//        $this->JSServer->addJSONBlock('html','frmstatus',"Form is on Update Mode!");
    }

    public function page_event_showall_newa($evtp) {
        $this->page_event_addform($evtp);
    }
    public function page_event_addform($evtp) {
	if(isset($_SESSION['curtrec'])){
            unset($_SESSION['curtrec']);
        }
        $this->Client->session("formType", "Add");
        $this->JSServer->addJSONFront($this->genFormFront, 'showall_editor');
    }

// user event handling end here
    public function page_event_crossclick($evtp) {
        $this->page->viewData($this->genFormFront->getComponent($this->formid));
        $this->genFormFront->getComponent('btnDel')->fu_setRender();
        $extupdate = array();
        $extupdate["up"] = 12;
        $extupdate["previd"] = $this->Client->request("previd");
        $extupdate["prevctrl"] = $this->Client->request("prevctrl");
        $this->Client->session("extupdate", $extupdate);
        $this->JSServer->addJSONFront($this->genFormFront, 'showall_editor');
    }

    public function insert() {
        global $cmpid;
        $this->extra[]['spcmpid'] = $cmpid;
        $blnsendList = $this->checkCrossCall();
        if (!getCheckErr()) {
            $this->insertedid = $this->page->insertData($this->genFormFront->getComponent($this->formid),$this->extra);
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

    public function update() {
        $blnsendList = $this->checkCrossCall();
        if (!getCheckErr()) {
            $this->page->updateData($this->genFormFront->getComponent($this->formid),$this->extra, $this->recID, $this->recWhere);
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

    public function page_event_delete() {
        $blnsendList = $this->checkCrossCall();
        if (!getCheckErr()) {
            $this->page->deleteRec();
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

    public function page_event_efillstate($evtp) {
        $this->Client->session('country', $this->Client->request('country'));
        $this->JSServer->addJSONComp($this->genFormFront->getComponent('state'), 'edit_state_box');
        $this->JSServer->addJSONComp($this->genFormFront->getComponent('city'), 'edit_city_box');
    }

    public function page_event_efillcity($evtp) {
        $this->Client->session('country', $this->Client->request('country'));
        $this->Client->session('state', $this->Client->request('state'));
        $this->JSServer->addJSONComp($this->genFormFront->getComponent('city'), 'edit_city_box');
    }

    /// Search
    public function page_event_efillstates($evtp) {
        $this->JSServer->addJSONComp($this->showallFront->getComponent('searchby_state'), 'edit_state_boxs');
        $this->JSServer->addJSONComp($this->showallFront->getComponent('searchby_city'), 'edit_city_boxs');
    }

    public function page_event_efillcitys($evtp) {
        $this->JSServer->addJSONComp($this->showallFront->getComponent('searchby_city'), 'edit_city_boxs');
    }

}
