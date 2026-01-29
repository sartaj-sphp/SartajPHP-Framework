<?php




class EditPanel extends Sphp\tools\Component{
private $label = "";
private $lstcomp = "";

public function fu_setLabel($label,$tfield="") {
    $this->label = $label;
    $this->lstcomp = $tfield;
}
private function setLabel2($label,$tfield="") {
    if(SphpBase::page()->getEvent() == 'view' || SphpBase::page()->getEvent() == 'rowclick'){
        if($tfield != ""){
            $v1 = explode(",", $tfield);
            $tfield = "";
            foreach($v1 as $i => $col){
            $tfield .= " " . $this->frontobj->getComponent($col)->value;      
            }
            //$tfield = SphpBase::sphp_request()->request("txtid");
        }
        $label = "Edit " . $label . $tfield;
    }else{
        $label = "Add " . $label;
    }
    $this->label = $label;
}
protected function onrender(){
    $this->setLabel2($this->label,$this->lstcomp);
    $this->tagName = 'div';
    $this->setPreTag('<div class="card card-primary">
  <div class="card-header">
      <h3 class="card-title"><span style="font-size:16px;" class="pull-left hidden-xs showopacity fa fa-user"></span> &nbsp;<span id="editheading">'.$this->label.'</span></h3>
  </div>
  <div class="card-block">
    <div class="block">
  
');
    $this->class = "content px-4 py-4"; 
    $this->setPostTag('</div></div></div>');        
    
}

}
