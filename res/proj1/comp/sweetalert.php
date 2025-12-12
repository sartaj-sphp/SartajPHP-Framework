<?php
class sweetalert extends \Sphp\tools\Control{
    private $options = '{}';
    private $msg = 'Hi';
    private $type = 'success';

    public function setMsg($msg){
        $this->msg = $msg;        
    }

    public function onjsrender(){
        $this->unsetRender();
        if($this->element->hasAttribute('type')){
            $this->type = $this->getAttribute('type');
        }
        addFileLink('https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js');
        addHeaderJSFunctionCode("ready",$this->name,"swal('". SphpBase::sphp_settings()->title ."','{$this->msg}','{$this->type}',{$this->options});");
    }
}
