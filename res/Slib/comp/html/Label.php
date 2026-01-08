<?php
namespace Sphp\comp\html;

/**
 * Description of label
 * use bootstrap grid
 * @author sartaj
 */
class Label extends \Sphp\tools\Component{
    static $size = array('col-md-4 col-xs-12','col-md-8 col-xs-12');
    
    public function fu_setLabel($param) {
        $param = str_replace('*', '<span class="text-danger">*</span>', $param);
        $this->element->appendPreTag('<div class="control-group">
<div class="row mb-3"><div class="'. self::$size[0] .' text-md-end text-xs-start my-auto">
        <label class="form-label" for="'. $this->HTMLID .'">&nbsp;'. $param.':-</label>
    </div><div class="'. self::$size[1] .'"><div class="controls">');
$this->element->appendPostTag('</div> 
    </div></div>
</div>');
    }
    public function fu_setSize($label,$comp) {
        Label::$size[0] = $label;
        Label::$size[1] = $comp;
    }
}
