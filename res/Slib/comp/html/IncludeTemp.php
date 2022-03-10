<?php
/**
 * Description of IncludeTemp
 *
 * @author SARTAJ
 */

namespace Sphp\comp\html{

class IncludeTemp extends \Sphp\tools\Control {
private $tempobj2 = null;

    protected function genhelpPropList() {
        $this->addHelpPropFunList('setTempFile','Include Other Temp File','','$filepath');
    }

public function setTempFile($filepath){
    $this->tempobj2 = new \Sphp\tools\TempFile($filepath,false,null, $this->tempobj->parentapp);
}
public function onrender() {
    $this->unsetrenderTag();
    $strOut = "";
    $this->tempobj2->run();
    $strOut .= $this->tempobj2->data;
    $this->setInnerHTML($strOut);
}
    
}
}