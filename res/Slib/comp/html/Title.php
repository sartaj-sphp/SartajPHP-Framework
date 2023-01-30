<?php
/**
 * Description of Title
 *
 * @author SARTAJ
 */
namespace Sphp\comp\html{

class Title extends \Sphp\tools\Control{

public function onrender() {
    $this->unsetRenderTag();
    \SphpBase::sphp_settings()->title = $this->executePHPCode($this->getInnerHTML());
    \SphpBase::sphp_settings()->metakeywords = $this->getAttribute("metakeywords");
    \SphpBase::sphp_settings()->metadescription = $this->getAttribute("metadescription");
    \SphpBase::sphp_settings()->metaclassification = $this->getAttribute("metaclassification");
    \SphpBase::sphp_settings()->keywords = explode(",",$this->getAttribute("keywords"));
    $this->setInnerHTML('');
}


}
}
