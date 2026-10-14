<?php
include_once(__DIR__ . "/../data/Grid/JQueryUIDialogDecorator.php");

/**
 * Description of DialogBox
 *
 * @author SARTAJ
 */

class DialogBox extends \Sphp\tools\Component{
    private $blnajax = false;
    
    
protected function oncreate($element){
$this->fu_setHTMLName("");
$this->fu_setHTMLID($this->name . '_dlg');
}

private function setDialogTheme(){
     $this->styler = 1;
        $dialogDecorator = new JQueryUIDialogDecorator(
            $this->name, 
            $this->styler,  // 1=Bootstrap, 2=Dark, 3=Minimal, 4=Custom
            'default'
        );

        // Optional: Add animations
        $dialogDecorator->animateDialog();
        $dialogDecorator->addResizableHandles();

        // For custom theme override
        if($this->styler == 4) {
            $dialogDecorator->setCustomStyle(
                '.ui-dialog-titlebar', 
                'background: #ff6b6b !important; color: white !important;'
            );
            $dialogDecorator->setCustomStyle(
                '.ui-dialog', 
                'border: 2px solid #ff6b6b !important; border-radius: 15px !important;'
            );
        }
    
}

public function sendAJAX($content){
    SphpBase::JSServer()->addJSONHTMLBlock($this->name . "_editor",$content);
}
public function sendFrontFile($frtfile){
     SphpBase::JSServer()->addJSONJSBlock('$("#modal1_dlg").dialog("open");');
    SphpBase::JSServer()->addJSONFront($frtfile, $this->name . "_editor");
}
public function fu_setAjax(){
$this->blnajax = true;
SphpJsM::addjQueryUI();
SphpBase::JSServer()->getAJAX();
}

protected function onjsrender(){
    $this->fu_setAjax();
    if($this->blnajax){
$jsAjax = "true";    
}else{
$jsAjax = "false";        
}
    $this->setDialogTheme();

    $this->setInnerHTML('');
addHeaderJSFunctionCode('ready',$this->name,'
$("#'.$this->name.'_dlg").dialog({
autoOpen: false,
width: "auto",
height: "700",
show2: {
        effect: "blind",
        duration: 300
},
hide2: {
        effect: "explode",
        duration: 300
},
position: [10,10],
title: "Grid Editor Form",
create: function(event, ui) { 
      var widget = $(this).dialog("widget");
      $(".ui-dialog-titlebar-close", widget)
          .html(\'<span class="ui-button-icon ui-icon ui-icon-closethick  btn btn-primary"></span><span class="ui-button-icon-space"> </span>\')
          .addClass("ui-button ui-corner-all ui-widget ui-button-icon-only ui-dialog-titlebar-close");
   },
closeText: "",
modal: true,
beforeClose: function(){
    $("#'.$this->name.'_editor").html("");
}
    });
');

 $opendlg = "$(\"#{$this->name}_dlg\").dialog(\"open\");";
addHeaderJSCode($this->name,"
window['confirmDel_$this->name'] = function(link){
confirmDel(link,$jsAjax);
        };
window['pagiedit_$this->name'] = function (link){
$opendlg
pagiedit(link,$jsAjax);
        };    
window['paginew_$this->name'] = function (link){
$opendlg
pagiedit(link,$jsAjax);
        };    
");

    addHeaderJSCode('pagi1',"
 window['rowclick'] = function(obj,link,data){
        if(data==undefined){
            data = {};
        }
        $('table').find('tr.highlight').removeClass('highlight');
        $(obj).addClass('highlight');
        getURL(link,data);
    }
    window['setFormAsNew'] = function(formid){
        readyFormAsNew(formid);
        $('table').find('tr.highlight').removeClass('highlight');
        $('#btnDel').css('display','none');
    }
    window['readyFormAsNew'] = function(formid){
        $('#' + formid).find('input[name=\"txtid\"]').val('');
        $(':input','#' + formid)
        .not(':button, :submit, :reset, :hidden')
        .val('').attr('value','')
        .removeAttr('checked')
        .removeAttr('selected');
        $('select', '#' + formid).each(function(i,e){selectByValue(e,\"empt\")});
        $('textarea', '#' + formid).each(function(i,e) { $(e).val(''); $(e).html(''); });
    }
window['runanierr'] = function(type){
    $(\"#sphp\" + type).fadeIn(1);
    $(\"#sphp\" + type).css(\"display\",\"block\");
    $(\"#sphp\" + type).delay(5000).fadeOut(\"slow\", function () { $(this).css(\"display\",\"none\"); });            
}
");

    addHeaderJSCode($this->name .'pagi1',"
function pagiedit_$this->name(link){
$opendlg
pagiedit(link,$jsAjax);
        }    
function paginew_$this->name(link){
$opendlg
pagiedit(link,$jsAjax);
        }    
");

    addHeaderJSCode('pagi',"
function confirmDel(link,jsajax){
var ans = confirm('Are You Sure to Delete This Record !') ;
if(ans){
if(jsajax){
getURL(link);
 }else{
window.location = link ; 
  }
}
}
function pagiedit(link,jsajax) {
if(jsajax){
getURL(link);
 }else{
window.location = link ; 
  }
return false;
	}
function paginew(link,jsajax){
if(jsajax){
getURL(link);
 }else{
window.location = link ; 
  }
}
");

$ptag = '<div id="'.$this->name.'_toolbar">';

$msg1 = '<div style="position: fixed; z-index: 2000;width: 500px;">
    <div id="sphpwarning" class="alert alert-warning" style="display: none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Warning!</strong> <span id="sphpwarningmsg"></span>
    </div>
    <div id="sphperror" class="alert alert-danger" style="display: none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Error!</strong> <span id="sphperrormsg"></span>
    </div>
    <div id="sphpsuccess" class="alert alert-success" style="display: none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Success!</strong> <span id="sphpsuccessmsg"></span>
    </div>
    <div id="sphpinfo" class="alert alert-info" style="display: none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Note!</strong> <span id="sphpinfomsg"></span>
    </div>
</div><div id="srvmsg"></div>';
        if(SphpBase::sphp_api()->getProp("alert") == true){
            $msg1 = "";
        }else{
            SphpBase::sphp_api()->addProp("alert", true);
        }
        $this->element->appendAttribute('class','dragdrop');
    $this->setInnerHTML('<div id="'.$this->name.'_editor" style="width:100%;height:100%;"></div>');
    $divt = "$ptag</div>". $msg1 ."<div id=\"{$this->name}_list\" class=\"container\"> ";     
    $this->setPreTag($divt.$this->getPreTag());    
    $this->setPostTag('</div>'.$this->getPostTag());


}


}
