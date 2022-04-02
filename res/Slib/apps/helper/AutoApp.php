<?php
/**
 * Description of AutoApp
 *
 * @author Sartaj
 */
include_once("{$libpath}/dev/QueryBuilder.php");
// may use div tag id edtFormHolder for editor form

class AutoApp extends \Sphp\tools\BasicApp {

    /**
     *
     * @var type TempFile
     */
    protected $genFormTemp = null;

    /**
     *
     * @var type TempFile
     */
    protected $showallTemp = null;
    public $heading = "heading";
    public $footer = "set footer property of app, for logo image set logoimg";
    public $logoimg = "apps/helper/forms/logo.png";
    protected $insertedid = -1;

    public $extra = array();
    public $recID = "";
    public $recWhere = "";
    public $printstyle = "test";
    public $printstylefile = __DIR__ ."/forms/style.css";

    public function onstart() {
        $this->logoimg = SphpBase::$sphp_settings->res_path ."/apps/helper/forms/logo.png";
        $this->showallTemp->getComponent('showall')->unsetRenderTag();
        $this->genFormTemp->getComponent('btnDel')->unsetRender();
        $this->showallTemp->getComponent('showall')->setPerPageRows(10);
    }

    public function page_event_loadform($evtp) {
        $this->showallTemp->getComponent('showall')->setRenderTag();
        //$this->JSServer->addJSONTemp($this->genFormTemp,'showall_editor');
        $this->JSServer->addJSONTemp($this->showallTemp, 'listFormHolder');
//      $this->JSServer->addJSONBlock('html','listheading',$listheading->innerHTML);
//      $this->JSServer->addJSONBlock('html','editheading',$editheading->innerHTML);
    }

    public function page_new() {
        $this->showallTemp->getComponent('showall')->setRenderTag();
        //$tmp = new TempFile('This is not a standalone Application!', true);
        //trigger_error('This is not a standalone Application!');
        $this->setTempFile($this->showallTemp);
    }

// user event handling start here
    public function page_event_test($param) {
        $this->setTempFile($this->showallTemp);
    }

    public function page_event_showall_show($param) {
        $showall = $this->showallTemp->getComponent('showall');
        $this->JSServer->addJSONComp($showall, 'showall');
        $this->JSServer->addJSONBlock('html', 'pagebar', $showall->getPageBar());
    }

    public function page_event_print($param) {
        $this->printstyle = \SphpBase::$sphp_api->getDynamicContent($this->printstylefile);
        $showall = $this->showallTemp->getComponent('showall');
        require($this->phppath . '/classes/base/reports/html2pdf/Temp2PDF.php');
        $showsingleTemp = new Sphp\tools\TempFileChild(__DIR__ ."/forms/pdf_temp.temp",false,null,$this->showallTemp);
        $showall->unsetAddButton();
        $showall->unsetDialog();
        $showall->unsetPageBar();
//        $showsingleTemp->addMetaData('uni_id',"FF45678");
        $pdf = new Temp2PDF($showsingleTemp);
        $pdf->setDefaultFont('Arial');
        $pdf->render('sample.pdf', 'I');
    }

    public function page_event_usersrch($param) {
        $showall = $this->showallTemp->getComponent('showall');
        if (!getCheckErr()) {
            if (!getCheckErr()) {
                $this->JSServer->addJSONComp($showall, 'showall');
                //$this->JSServer->addJSONTemp($this->genFormTemp, 'showall_editor');
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
        $this->Client->session("formType", "Edit");
        $this->page->viewData($this->genFormTemp->getComponent('form2'));
        $this->genFormTemp->getComponent('btnDel')->setRender();
        $this->JSServer->addJSONJSBlock('$( "#showall_dlg" ).dialog( "open" );');
        $this->JSServer->addJSONTemp($this->genFormTemp, 'showall_editor');
//        $this->JSServer->addJSONBlock('html','frmstatus',"Form is on Update Mode!");
    }

    public function page_event_showall_newa($param) {
        $this->page_event_addform($param);
    }
    public function page_event_addform($param) {
	if(isset($_SESSION['curtrec'])){
            unset($_SESSION['curtrec']);
        }
        $this->Client->session("formType", "Add");
        $this->JSServer->addJSONTemp($this->genFormTemp, 'showall_editor');
    }

// user event handling end here
    public function page_event_crossclick($param) {
        $this->page->viewData($this->genFormTemp->getComponent('form2'));
        $this->genFormTemp->getComponent('btnDel')->setRender();
        $extupdate = array();
        $extupdate["up"] = 12;
        $extupdate["previd"] = $this->Client->request("previd");
        $extupdate["prevctrl"] = $this->Client->request("prevctrl");
        $this->Client->session("extupdate", $extupdate);
        $this->JSServer->addJSONTemp($this->genFormTemp, 'showall_editor');
    }

    public function page_insert() {
        global $cmpid;
        $this->extra[]['spcmpid'] = $cmpid;
        $blnsendList = $this->checkCrossCall();
        if (!getCheckErr()) {
            $this->insertedid = $this->page->insertData($this->extra);
            if (!getCheckErr()) {
                //setMsg('app1','New Data Record is Inserted, want more record add fill form again' );
                //$JSServer->addJSONBlock('jsp','proces','$( "#showall_dlg" ).dialog( "close" );');
                if ($blnsendList) {
                    $this->JSServer->addJSONComp($this->showallTemp->getComponent('showall'), 'showall');
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
        $this->JSServer->addJSONJSBlock("getURL('" . getEventPath("rowclick", $extupdate['previd'], $extupdate["prevctrl"]) . "');");
    }

    public function page_update() {
        $blnsendList = $this->checkCrossCall();
        if (!getCheckErr()) {
            $this->page->updateData($this->extra, $this->recID, $this->recWhere);
            if (!getCheckErr()) {
                if ($blnsendList) {
                    $this->JSServer->addJSONComp($this->showallTemp->getComponent('showall'), 'showall');
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
        $blnsendList = $this->checkCrossCall();
        $this->page->deleteRec();
        if (!getCheckErr()) {
            if ($blnsendList) {
                $this->JSServer->addJSONComp($this->showallTemp->getComponent('showall'), 'showall');
                $this->JSServer->addJSONTemp($this->genFormTemp, 'showall_editor');
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

    public function page_event_efillstate($param) {
        $this->Client->session('country', $this->Client->request('country'));
        $this->JSServer->addJSONComp($this->genFormTemp->getComponent('state'), 'edit_state_box');
        $this->JSServer->addJSONComp($this->genFormTemp->getComponent('city'), 'edit_city_box');
    }

    public function page_event_efillcity($param) {
        $this->Client->session('country', $this->Client->request('country'));
        $this->Client->session('state', $this->Client->request('state'));
        $this->JSServer->addJSONComp($this->genFormTemp->getComponent('city'), 'edit_city_box');
    }

    /// Search
    public function page_event_efillstates($param) {
        $this->JSServer->addJSONComp($this->showallTemp->getComponent('searchby_state'), 'edit_state_boxs');
        $this->JSServer->addJSONComp($this->showallTemp->getComponent('searchby_city'), 'edit_city_boxs');
    }

    public function page_event_efillcitys($param) {
        $this->JSServer->addJSONComp($this->showallTemp->getComponent('searchby_city'), 'edit_city_boxs');
    }

}
