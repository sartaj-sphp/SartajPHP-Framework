<?php
/**
 * Description of IncludeFrontPlace
 *
 * @author SARTAJ
 */

namespace Sphp\comp\html{

class IncludePlace extends \Sphp\tools\Component {
    private $front_name = "dynData";
    private $section = "left";
    
    protected function genhelpPropList() {
        $this->addHelpPropFunList('setFrontPlaceFile','Include Front Place','','$filepath');
    }

   
public function fu_setFrontPlaceFile($filepath,$front_name="main_master",$section="centersp1"){
    $filepath = $this->frontobj->HTMLParser->resolvePathVar($filepath);
    $this->front_name = $front_name;
    $this->section = $section;
    \addFrontPlace($fornt_name,$filepath,$section);
}
protected function onrender() {
   if ($this->front_name != "dynData") \runFrontPlace($this->front_name,$this->section);
    $strOut = \renderFrontPlaceManually($this->front_name,$this->section);
    $this->setInnerHTML($strOut);
}
    
}
}