<?php




class IconSelect extends Control{
private $label = "";

public function oncompcreate($param) {
    $this->setHTMLID("");
    $this->setHTMLName("");
}
public function setLabel($label) {
    $this->label = $label;
}
public function onjsrender() {
    addHeaderJSCode("$this->name", " function {$this->name}_setvalue(obj){ "
    . "$('#$this->name').val($(obj).data('cls')); "
    . "$('#{$this->name}spn').removeClass(); "
    . "$('#{$this->name}spn').addClass($(obj).data('cls')); "
    
    . "}");
}
public function onrender(){
global $ctrl;

    $this->tagName = 'div';
    $this->setPreTag('<span id="'. $this->name .'spn" class="'.$this->value.'"></span><input id="'.$this->name.'" name="'.$this->name.'" value="'.$this->value.'" type="hidden" /><br />
');
    $this->class = "iconselectbody col-md-12 " . $this->class ; 
    $stra = explode(",", $this->innerHTML);
    $this->innerHTML = "";
    $str = "";
    foreach($stra as $key=>$value){
        $value = trim($value);
    $str .= '<a href="#" onclick="'.$this->name.'_setvalue(this); return false;" data-cls="'. $value .'"><span class="'.$value.'"></span></a>&nbsp;&nbsp;';
    }
    $this->innerHTML = $str;
}

}
