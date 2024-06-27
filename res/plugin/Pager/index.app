<?php

class index extends \Sphp\tools\BasicApp{
    private $temp1 = "";
    
    public function onstart() {
     $this->setTableName('pagdet');
     // enable permission system
     $this->page->getAuthenticatePerm();
     $this->temp1 = new TempFile($this->mypath . "/forms/infradet.front");
    }

    public function onready() {
        if($this->page->isevent){
             $this->setTempFile($this->temp1);
        }
        if($this->page->checkAuth("ADMIN,MEMBER")){
            $this->getDialogBox();
        }
    }
    
    private function getDialogBox(){
        SphpBase::SphpJsM()->addJqueryUI();
    $c1 = SphpBase::sphp_settings()->slib_path . "/comp/html/HTMLForm";
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
addHeaderJSFunctionCode("ready","sdpage",$stro);

}

}