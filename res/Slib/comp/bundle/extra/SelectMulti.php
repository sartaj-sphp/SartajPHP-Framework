<?php

include_once(SphpBase::sphp_settings()->slib_path . "/comp/html/Select.php");

class SelectMulti extends Sphp\comp\html\Select{
    
    public function oninit(){
        parent::oninit();
        //$this->setHTMLID($this->name . "comp");
        $this->setHTMLName($this->name ."comp");
    }
    
    public function onrender(){
        parent::onrender();
        $event1 = "click";
        if($this->blnsearch){
            addFileLink(\SphpBase::sphp_settings()->slib_res_path . "/comp/html/jslib/select2.min.css");
            addFileLink(\SphpBase::sphp_settings()->slib_res_path . "/comp/html/jslib/select2.min.js");
            $event1 = "select2:select";
        }
        if($this->value == "0") $this->value = '{ }';
        $vala = json_decode($this->value); 
        //\SphpBase::debug()->println(SphpBase::sphp_api()->getJSArrayAss($this->name, $vala));
        addHeaderJSFunctionCode('ready',$this->name .'rd', "  " . SphpBase::sphp_api()->getJSArrayAss($this->name, $vala) .
           " ;window['{$this->name}delete'] = function(i){ delete $this->name[i]; {$this->name}rndr(); };
                var {$this->name}add = function(){
                    var v1 = $('#{$this->name}').val().split(','); 
                {$this->name}[v1[0]] = $('#{$this->name}').val();
                {$this->name}rndr();
                }; 
        $('#{$this->name}').on('$event1',function(e){ if($('#{$this->name}').val() != 0) {$this->name}add(); }); 
        var {$this->name}rndr = function(){  $('input[name=\"{$this->name}\"]').val(JSON.stringify({$this->name})); $('#{$this->name}d').html('');
        $.each($this->name, function(i,v){ 
        $('#{$this->name}d').append('<div class=\"border border-success mb-1\">'+ v +'<i class=\"fa-solid fa-rectangle-xmark\" onclick=\"{$this->name}delete(' + i + ')\"></i></div>'); 
        }); 
        };{$this->name}rndr(); 
        ");
         $this->setPostTag($this->getPostTag(). '<input name="'. $this->name .'" type="hidden" value="" /><div id="'. $this->name .'d"></div>');
    }
    
}
