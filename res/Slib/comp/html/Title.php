<?php

/**
 * Description of Title
 *
 * @author SARTAJ
 */

namespace Sphp\comp\html {

    class Title extends \Sphp\tools\Control {
        private $blnautoseo = false;
        
        public function autoSEO() {
            $this->blnautoseo = true;
        }
        private function autoSEO1($ar1) {
            foreach ($ar1 as $t1){
            if($t1->myclass == "Sphp\\tools\\NodeTag"){
                $this->optimizeTags($t1);
                if($t1->hasChildren()){
                    $this->autoSEO1($t1->getChildren());
                }
            }
            }
        }
        private function optimizeTags($element) {
            switch($element->tagName){
                case 'a':{
                    if(! $element->hasAttribute('title')) $element->setAttribute('title', \SphpBase::sphp_settings()->getKeyword());
                    break;
                }
                case 'img':{
                    if(! $element->hasAttribute('title')) $element->setAttribute('title', \SphpBase::sphp_settings()->getKeyword());
                    if(! $element->hasAttribute('alt')) $element->setAttribute('alt', \SphpBase::sphp_settings()->getKeyword());
                    break;
                }
            }
        }
        public function onrender() {
            global $cmpname;
            $this->unsetRenderTag();
            $hh1 = $this->getInnerHTML();
            $hh1 = $this->executePHPCode($hh1);
            // 70 characters
            \SphpBase::sphp_settings()->title = $hh1;
            if ($this->element->hasAttribute("metakeywords")) {
                \SphpBase::sphp_settings()->metakeywords = $this->getAttribute("metakeywords");
            } else {
                \SphpBase::sphp_settings()->metakeywords = $hh1;
            }
            // length = 150
            if ($this->element->hasAttribute("metadescription")) {
                \SphpBase::sphp_settings()->metadescription = $this->getAttribute("metadescription");
            } else {
                \SphpBase::sphp_settings()->metadescription = $hh1;
            }
            if ($this->element->hasAttribute("metaclassification")) {
                \SphpBase::sphp_settings()->metaclassification = $this->getAttribute("metaclassification");
            } else {
                \SphpBase::sphp_settings()->metaclassification = $hh1;
            }
            if ($this->element->hasAttribute("metaauthor")) {
                \SphpBase::sphp_settings()->metaauthor = $this->getAttribute("metaauthor");
            } else {
                \SphpBase::sphp_settings()->metaauthor = $cmpname;
            }
            if ($this->element->hasAttribute("keywords")) {
                \SphpBase::sphp_settings()->keywords = explode(",", $this->getAttribute("keywords"));
            } else {
                \SphpBase::sphp_settings()->keywords = \SphpBase::sphp_settings()->metakeywords;
            }
            $this->setInnerHTML('');
            if($this->blnautoseo){
                $dom = $this->tempobj->HTMLParser->dhtmldom;
                $this->autoSEO1($dom->root->getChildren());
            }

        }

    }

}
