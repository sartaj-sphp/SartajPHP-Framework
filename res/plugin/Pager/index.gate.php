<?php

class index extends \Sphp\Tools\BasicGate{
    private $temp1 = "";
    public $eventname = "home";
    private $record = array();
    
    public function onstart() {
     $this->setTableName('pagdet');
     // enable permission system
     $this->page->getAuthenticatePerm();
     $this->temp1 = new FrontFile($this->myPath . "/forms/infradet.front");
    }

    public function onready() {
        global $cmpId;
        $cmpId2 = $cmpId;
        $this->eventname = SphpBase::page()->getEvent(); 
        if($this->page->isevent){
            if($this->eventname == "home") $cmpId2 = "demo";
             $this->setFrontFile($this->temp1);
        }else{ // home page
            $cmpId2 = "demo";
            $this->eventname = "home";
            $this->setFrontFile($this->temp1);
        }
        // don't show breadcromb on home page
         if($this->eventname == "home") $this->temp1->getComponent("spn4")->fu_unsetRender();
        $this->getRecord($cmpId2);
        if($this->page->checkAuth("ADMIN,MEMBER")){
            $this->getDialogBox();
        }
    }
    
    private function getRecord($cmpId2){
        global $cacheTime;
            $sql = "SELECT * FROM pagdet WHERE spcmpId='$cmpId2' AND  pagename='$this->eventname'";
            $result = SphpBase::dbEngine()->fetchQuery($sql,$cacheTime);
            $this->record = current($result["news"]);
            if($this->record == false){
                $this->record = array();
                $this->record["catname"] = '1,Error';
            }
    }
    public function getRow($col){
        if(isset($this->record[$col])){
            return $this->record[$col];
        }else{
            return "";
        }
    }
    /**
     * Tiny Editor on Render event handle
     */
    public function comp_tinydetails_on_startrender($evtargs){
        if(file_exists('pagres/a' . $this->getRow('id') . '.html')){
            $this->temp1->getComponent("tinydetails")->fu_setValue(file_get_contents('pagres/a' . $this->getRow('id') .'.html'));
        }
    }
    private function getDialogBox(){
        SphpBase::SphpJsM()->addJqueryUI();
    $c1 = SphpBase::sphpSettings()->slibPath . "/comp/html/HTMLForm";
    include_once($c1 .'.php');
    $htform = new \Sphp\comp\html\HTMLForm();
    $htform->setupJSLib();
    $stro = '$("#sdpage_dlg").dialog({
autoOpen: false,
width: "auto",
height: "auto",
show: {
        effect: "blind",
        duration: 0
},
hide: {
        effect: "explode",
        duration: 1000
},
position: {
   my: "center",
   at: "center",
   of: window
},
title: "Grid Editor Form",
create: function(event, ui) { 
      var widget = $(this).dialog("widget");
      $(".ui-dialog-titlebar-close", widget)
          .html(\'<span class="ui-button-icon ui-icon ui-icon-closethick"></span><span class="ui-button-icon-space"> </span>\')
          .addClass("ui-button ui-corner-all ui-widget ui-button-icon-only ui-dialog-titlebar-close");
   },
closeText: "",
modal: true,
beforeClose: function(){
    $("#sdpage_editor").html("");
}
    });
';
addHeaderJsFunctionCode("ready","sdpage",$stro);

}

}