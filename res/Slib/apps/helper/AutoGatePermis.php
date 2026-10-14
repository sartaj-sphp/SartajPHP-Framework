<?php
/**
 * Description of AutoGatePermis
 * It extends BasicsGate Class and Add Search,Grid to Print as PDF, 
 * Add heading and footer for Front File and Printer Format. This class 
 * is also add AJAX base error and notification reply.
 * This Class helps to develop Gate Class easy as CRUD App with Permissions System.
 * It reduce coding to handle most of PageEvents to handle two Front Files.
 *    1. $genFormFront:- Front File to Insert/Edit Database Table Record.
 *    2. $showallFront:-  Front File to List All Record from Database Table With Grid or Pagination Component or PHP code
 */
include_once(SphpBase::sphp_settings()->lib_path . "/dev/QueryBuilder.php");

class AutoGatePermis extends Sphp\tools\BasicGate {
   /**
    * PDF and Front File Page Heading
    * @var string
    */
    public $heading = "heading";
   /**
    * PDF and Front File Page Footer
    * @var string
    */
    public $footer = "set footer property of app, for logo image set logoimg";
   /**
    * PDF and Front File Logo Image Path
    * @var string
    */
    public $logoimg = "apps/helper/fronts/logo.png";
    public $phone = "6AA-AAA-AAAA";    
    public $mobile = "AAA-AAA-AAAA";    
    public $address = "address";    
    public $city = "Mississauga";    
    public $country = "Canada";    
   /**
    * Temporary Disable permissions for Gate
    * @var bool
    */
    protected $blndisableperm = false;
    /**
     * DB Record ID for Update Record. It is optional and by default Form Component 
     * provide Record ID
     * @var int
     */
    public $recID = "";
    /**
     * DB Update SQL Where for Update Record. It is optional and by default Form Component 
     * provide Record ID=id
     * @var int
     */
    public $recWhere = "";
    public $printstyle = "test";
   /**
    * PDF Print Style CSS File Path Default __DIR__ ."/fronts/style.css"
    * @var string
    */
    public $printstylefile = __DIR__ ."/fronts/style.css";

    /**
     * $extra array as $extra[table][field] = value format. pass $extra value while 
     * insert,update data to database. this is extra data which is not provided by bound Components.
     * @var array
     */
    public $extra = array();
    /**
     * Set Last inserted record "id" value in database when insert operation process.
     * @var int
     */
    protected $insertedid = 0;
    /**
     * pass default WHERE login to Pagination Component to Search Records. It will only work when 
     * no other WHERE logic exists.
     * @var string
     */
    protected $defWhere = "";
    /**
     * Form Component ID to process Database bound Component for automatic INSERT,UPDATE and VIEW 
     * Database record.
     * @var string default value is form2
     */
    protected $formid = "form2";
    /**
     * This Front File provide Edit Form to use Insert and Update records
     *  @var \Sphp\tools\FrontFile
     */
    public $genFormFront = null;

    /**
     * This Front File provide List Records with Pagination + search Form
     *  @var \Sphp\tools\FrontFile
     */
    public $showallFront = null;

    /**
     * Handle LifeCycle Event onstart of Gate
     *  Setting up Basic Configurations and call from Child Class after 
     *  create Front Files Objects and name of object required showall, btnDel.
     */
    public function onstart() {
        $this->logoimg = SphpBase::sphp_settings()->slib_res_path ."/apps/helper/fronts/logo.png";
        /** Disable Render Component-Tag of Grid Component which will not stop Render Children of Grid */
        $this->showallFront->getComponent('showall')->fu_unsetRenderTag();
        /** Disable Render delete Button btnDel Component */
        $this->genFormFront->getComponent('btnDel')->fu_unsetRender();
        $this->showallFront->getComponent('showall')->fu_setPerPageRows(10);
        SphpBase::sphp_api()->addProp('page_title',$this->heading);
    }
    /**
     * Handle Event URL "loadform" AJAX Request of Gate
     * Update Front File showallFront with Grid Component to id=listFormHolder and reply via AJAX
     */
    public function page_event_loadform($evtp) {
        /** Enable Render Component-Tag of Grid Component */
        $this->showallFront->getComponent('showall')->fu_setRenderTag();
        /** Send showallFront Front-File to Tag id=listFormHolder */
        $this->JSServer->addJSONFront($this->showallFront, 'listFormHolder');
    }
    /**
     * Handle Landing URL GET Request of Gate
     *  Reply as Full Front File + Master File
     */
    public function page_new() {
        /** Enable Render Component-Tag of Grid Component */
        $this->showallFront->getComponent('showall')->fu_setRenderTag();
        //$tmp = new FrontFile('This is not a standalone Application!', true);
        //trigger_error('This is not a standalone Application!');
        $this->setFrontFile($this->showallFront);
    }

    /**
     * Handle Landing URL POST Request of Gate
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

    /**
     * Handle Event URL "showall_show" AJAX Request of Gate
     * Update Grid Component to id=showall and reply via AJAX
     */
    public function page_event_showall_show($evtp) {
        $showall = $this->showallFront->getComponent('showall');
        $showall->fu_unsetRenderTag();
        $this->JSServer->addJSONComp($showall, 'showall');
        $this->JSServer->addJSONHTMLBlock('pagebar', $showall->getPageBar());
    }

    /**
     * Check Permission
     * @return bool true if permission is given to Logged in User
     */
    public function hasPermission($p){
        return $this->page->hasPermission($p);
    }
    
    /**
     * Handle Event URL "print" Request of Gate
     * It Print Grid Component output as PDF file and send to browser
     */
    public function page_event_print($evtp) {
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

    /**
     * Handle Event URL "usersrch" Request of Gate.
     * It send Grid Component after change WHERE logic as User Search Form
     *  Send reply as AJAX
     */
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

    /**
     * Handle Event URL "rowclick" Request of Gate.
     * When click on row of Grid(tr) then this event handler process output and open 
     *  Record in genFormFront Form=form2 and send Front File in Dialog=showall_editor 
     * for editing. Send reply as AJAX
     */
    public function page_event_rowclick($evtp) {
        if($this->blndisableperm == true || $this->hasPermission("view")){
        $this->Client->session("formType", "Edit");
        // Fill Form Components from Database
        $this->page->viewData($this->genFormFront->getComponent('form2'));
        // Show btnDel Button in browser, by default hidden in onstart event
        $this->genFormFront->getComponent('btnDel')->fu_setRender();
        // Open Dialog of showall Grid or Pagination Component
        $this->JSServer->addJSONJSBlock('$( "#showall_dlg" ).dialog( "open" );');
        // display content in Dialog of showall Component
        $this->JSServer->addJSONFront($this->genFormFront, 'showall_editor');
        }else{
            setErr("app2", "Permission Denied");
            $this->sendError();
        }

    }
 
    /**
     * Handle Event URL "showall_newa" Request of Gate.
     * Display genFormFront Front File in id=showall_editor and this in dialog box 
     *  of Grid Component. So you can insert new record in DB. Send reply as AJAX
     */
    public function page_event_showall_newa($evtp) {
	if(isset($_SESSION['curtrec'])){
            unset($_SESSION['curtrec']);
        }
        $this->Client->session("formType", "Add");
        $this->JSServer->addJSONFront($this->genFormFront, 'showall_editor');
    }


    /**
     * Insert Data automatically to DB table with bind Components through 
     * $this->page->insertData
     * Display showall Grid Component to id=showall and 
     *  Close Dialog Box on success. Send reply as AJAX
     */
    public function insert() {
        global $cmpid;
        if($this->blndisableperm == false && !$this->hasPermission("add")){
            setErr("app2", "Permission Denied");
        }
        $this->extra[]['userid'] = $this->Client->session('sid');
        $this->extra[]['parentid'] = $this->Client->session('parentid');
        $this->extra[]['spcmpid'] = $cmpid;
        $this->extra[]['submit_timestamp'] = time();
        $this->extra[]['update_timestamp'] = time();
        
        if (!getCheckErr()) {
                $form2 = $this->genFormFront->getComponent($this->formid);
                $this->insertedid = $this->page->insertData($form2,$this->extra);            
            if (!getCheckErr()) {
                $this->JSServer->addJSONComp($this->showallFront->getComponent('showall'), 'showall');
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

    /**
     * Update Data automatically to DB table with bind Components through 
     * $this->page->updateData
     * Display showall Grid Component to id=showall and 
     *  Close Dialog Box on success. Send reply as AJAX
     */
    public function update() {
        if($this->blndisableperm == false && !$this->hasPermission("view")){
            setErr("app2", "Permission Denied");
        }
        if (!getCheckErr()) {
                $form2 = $this->genFormFront->getComponent($this->formid);
                $this->page->updateData($form2,$this->extra, $this->recID, $this->recWhere);
                if (!getCheckErr()) {
                    $this->JSServer->addJSONComp($this->showallFront->getComponent('showall'), 'showall');
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

    public function page_event_delete($evtp) {
        if($this->blndisableperm == false && !$this->hasPermission("delete")){
            setErr("app2", "Permission Denied");
        }
        if (!getCheckErr()) {
            $this->page->deleteRec();
            if (!getCheckErr()) {
                $this->JSServer->addJSONComp($this->showallFront->getComponent('showall'), 'showall');
                $this->JSServer->addJSONFront($this->genFormFront, 'showall_editor');
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
