<?php
/**
 * Description of IncludeFront
 *
 * @author SARTAJ
 */

namespace Sphp\Comp\Server{

class IncludeFront extends \Sphp\tools\Component {
private $frontobj2 = null;

    protected function oninit(){
        $this->fu_unsetrenderTag();
    }
    protected function genhelpPropList() {
        $this->addHelpPropFunList('setFrontFile','Include Other Front File','','$filepath');
    }

   
public function fi_setFrontFile($filepath){
    $filepath = $this->frontobj->HTMLParser->resolvePathVar($filepath);
    $this->frontobj2 = new \Sphp\tools\FrontFileChild($filepath,false,null, $this->frontobj);
    // apend children components
    foreach($this->frontobj2->getComponents() as $i=>$comp){
        $this->_addChild($comp);
    }
}
protected function onrender() {
    //$this->fu_unsetrenderTag();
    $this->tagName = "div";
    $strOut = "";
    $strOut .= $this->frontobj2->ProcessMe();
    $this->setInnerHTML($strOut);
}
    
}
}