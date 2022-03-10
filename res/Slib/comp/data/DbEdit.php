<?php

class DbEdit extends \Sphp\tools\Control{
    private $type = "text";
    private $options = "";
    private $ctag = 0;
    
    public function oncreate($param) {
        $this->setHTMLID("");
        $this->setHTMLName("");

    }
    public function setOptions($param) {
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

    public function onrender() {
        if($this->type == "text"){
        $this->contenteditable = "true";
        $this->setAttribute("class", "dbedit");
        $this->setAttribute("oninput","fundbedit(this)");
        addHeaderJSCode('dbedit', ' function fundbedit(obj1){
            clearTimeout(this.tmr1);
            $(obj1).css("background-color","#FF0000");
            this.tmr1 = setTimeout(function(){
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
        }');
    }else if($this->type == "select"){
        if($this->ctag < 2){
            $this->ctag += 1;
        }else{
            $this->setPreTag('');
        }
        //$this->tagName = "select";
        $this->setAttribute("class", $this->name);
        $this->setAttribute("onmouseup","fundbedit2(this)");
        //$this->setInnerHTML($this->options);
        addHeaderJSCode($this->name , '
        function fundbedit2(obj1){
            //console.log(event);
            //let obj1 = event.target;
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
    }
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
