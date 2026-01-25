<?php
/**
 * Description of IncludeFront
 *
 * @author SARTAJ
 */

namespace Sphp\comp\html{

class IncludeFront extends \Sphp\tools\Component {
private $frontobj2 = null;

    protected function genhelpPropList() {
        $this->addHelpPropFunList('setFrontFile','Include Other Front File','','$filepath');
    }

   
public function fu_setFrontFile($filepath){
    $filepath = $this->frontobj->HTMLParser->resolvePathVar($filepath);
    $this->frontobj2 = new \Sphp\tools\FrontFile($filepath,false,null, $this->frontobj->parentapp);
}
protected function onrender() {
    $this->unsetrenderTag();
    $strOut = "";
    $this->frontobj2->run();
    $strOut .= $this->frontobj2->getOutput();
    $this->setInnerHTML($strOut);
}
    
}
}