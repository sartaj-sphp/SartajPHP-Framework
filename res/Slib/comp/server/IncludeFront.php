<?php
/**
 * Description of IncludeFront
 * Front File use Tag Like and Front file has suffix *.child.front 
 * <include id="customer-list" fun-setFrontFile="apps/pos/fronts/customer_list.child.front" runat="server" ></include>
 * @author SARTAJ
 */

namespace Sphp\Comp\Server{

class IncludeFront extends \Sphp\Tools\Component {
private $frontobj2 = null;
private $renderonce = true;

    protected function oninit(){
        $this->fu_unsetrenderTag();
    }
    protected function genhelpPropList() {
        $this->addHelpPropFunList('setFrontFile','Include Other Front File','','$filepath');
    }

   
public function fi_setFrontFile($filepath){
    if($filepath == "") return;
    $this->renderonce = true;
    $filepath = $this->frontobj->htmlParser->resolvePathVar($filepath);
    $this->frontobj2 = new \Sphp\Tools\FrontFileChild($filepath,$this->frontobj);
    // apend children components
    foreach($this->frontobj2->getComponents() as $i=>$comp){
        $this->_addChild($comp);
    }
}
protected function onrender() {
    //$this->fu_unsetrenderTag();
    $this->tagName = "div";
    $strOut = "";
    if($this->renderonce && is_object($this->frontobj2)) $strOut .= $this->frontobj2->ProcessMe();
    $this->setInnerHtml($strOut);
    $this->renderonce = false;
}
    
}
}