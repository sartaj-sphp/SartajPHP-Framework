<?php
/**
 * DbEdit by Sartaj
 * <td id="txtedit2" fursetHTMLID="##{ $this->frontobj->showall->getRow('id_c')}#d" 
 * path="libpath/comp/data/DbEdit.php" data-suburl="index-dbedit.html" 
                data-field="shipper_c" data-table="leads_cstm" value="##{ $this->frontobj->showall->getRow('shipper_c') }#"  
                fur_data-recidv="##{ $this->frontobj->showall->getRow('id_c') }#" 
 * fur_data-mval="##{ $this->frontobj->showall->getRow('shipper_c') }#" 
 * data-recid="id_c" runat="server">
 * ##{ $this->frontobj->parentgate->getShipList2($this->frontobj->showall->getRow('shipper_c')) }#
 * </td>
 */
class DbEdit extends \Sphp\tools\Component{
    private $type = "text";
    private $options = "";
    private $ctag = 0;
    
    protected function oncreate($element) {
        $this->setHTMLID("");
        $this->setHTMLName("");

    }
    public function fu_setOptions($param) {
        $this->type = "select";
        $this->options = "";
        if(is_string($param)){
            $p2 = explode(",",$param);
            foreach($p2 as $index=>$val){
                $this->options .= '<option value="'. $val .'">'. $val .'</option>';
            }
        }else{
            foreach($param as $index=>$val){
                $this->options .= '<option value="'. $index .'">'. $val .'</option>';
            }
        }
        //$this->setPreTag('<select id="slt'. $this->name .'" style="display:none; position: absolute;">'. $this->options .'</select>');
        addHeaderJSCode('slt2','$("body").append(\'<select id="slt'. $this->name .'" data-recid="" style="display:none; position: absolute;">'. $this->options .'</select>\');');
    }
        public function fu_setAuth($param) {
            $blnF = \SphpBase::page()->checkAuth($param);
            if (!$blnF) {
                $this->renderTag = false;
            }
        }

    protected function onrender() {
        if($this->renderTag) $this->renderT1();
    }
    private function renderT1() {
        if($this->type == "text"){
        $this->contenteditable = "true";
        $this->setAttribute("class", "dbedit");
        $this->setAttribute("oninput","fundbedit()");
        $this->setAttribute("onclick","return(false)");
        addHeaderJSCode('dbedit', ' window["fundbedit"] = function(){
            let obj1 = event.target;
            clearTimeout(obj1.tmr1);
            $(obj1).css("background-color","#FF0000");
            obj1.tmr1 = setTimeout(function(){
                let data = {};
                data["flid"] = $(obj1).data("recid");
                data["flidv"] = $(obj1).data("recidv");
                data["fld"] = $(obj1).data("field");
                data["fltbl"] = $(obj1).data("table");
                data["flval"] = $(obj1).text();
                getAJAX($(obj1).data("suburl"),data,false,function(ret){
                    $(obj1).css("background-color","");                    
                });
            },1000);
        };');
    }else if($this->type == "select"){
        if($this->ctag < 2){
            $this->ctag += 1;
        }else{
            $this->setPreTag('');
        }
        //$this->tagName = "select";
        $this->setAttribute("class", $this->name);
        $this->setAttribute("onmouseup","fundbedit2()");
        //$this->setInnerHTML($this->options);
        addHeaderJSCode($this->name , '
        window["fundbedit2"] = function(){
            //console.log(event);
            let obj1 = event.target;
            var offs = $(obj1).offset();
            $("#slt'. $this->name . '").css("left",offs.left + 10);
            $("#slt'. $this->name . '").css("top",offs.top + 10);
            $("#slt'. $this->name . '").css("display","block");
            $("#slt'. $this->name . '").data("recid",$(obj1).data("recid"));
            $("#slt'. $this->name . '").data("recidv",$(obj1).data("recidv"));
            $("#slt'. $this->name . '").data("field",$(obj1).data("field"));
            $("#slt'. $this->name . '").data("table",$(obj1).data("table"));
            $("#slt'. $this->name . '").data("suburl",$(obj1).data("suburl"));
            let slt1 = $(obj1).data("recidv") + "d";
            selectByValue($("#slt'. $this->name . '"),$("#" + slt1).data("mval"));
    };
        $("#slt'. $this->name .'").on("change",function(event){
            let obj1 = event.target;
            if($(obj1).data("recid") !== ""){
            $(obj1).css("background-color","#FF0000");
                let data = {};
                data["flid"] = $(obj1).data("recid");
                data["flidv"] = $(obj1).data("recidv");
                data["fld"] = $(obj1).data("field");
                data["fltbl"] = $(obj1).data("table");
                data["flval"] = getValue(obj1);
                let slt1 = $(obj1).data("recidv") + "d";
                $("#" + slt1).html(obj1.options[obj1.selectedIndex].text);
                $("#" + slt1).data("mval",obj1.options[obj1.selectedIndex].value);                
                getAJAX($(obj1).data("suburl"),data,false,function(ret){
                    $(obj1).css("background-color","");                    
                    $(obj1).css("display","none");
                });
                }
        });');
        
    }
    }
    
    
}
