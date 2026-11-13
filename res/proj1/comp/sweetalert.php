<?php
class sweetalert extends \Sphp\Tools\Component{
    private $options = '{}';
    private $msg = 'Hi';
    private $type = 'success';

    public function setMsg($msg){
        $this->msg = $msg;        
    }

    public function onjsrender(){
        $this->fu_unsetRender();
        if($this->element->hasAttribute('type')){
            $this->type = $this->getAttribute('type');
        }
        addFileLink('https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js');
        addHeaderJsFunctionCode("ready",$this->name,"swal('". SphpBase::sphpSettings()->title ."','{$this->msg}','{$this->type}',{$this->options});");
    }
}
