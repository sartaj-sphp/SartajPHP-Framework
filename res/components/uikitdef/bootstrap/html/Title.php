<?php

/**
 * Description of Title
 *
 * @author SARTAJ
 */

namespace Sphp\Comp\Html {

    class Title extends \Sphp\tools\Component {
        private $blnautoseo = false;
        private static $blnrender = false;
        
        public function fu_autoSEO() {
            $this->blnautoseo = true;
        }
        public function fu_setMetaKeywords($v) {
            $this->setAttribute("metakeywords", $v);
        }
        public function fu_setMetaDescription($v) {
            $this->setAttribute("metadescription", $v);
        }
        public function fu_setMetaClassification($v) {
            $this->setAttribute("metaclassification", $v);
        }
        public function fu_setKeywords($v) {
            $this->setAttribute("keywords", $v);
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
        protected function onrender() {
            global $cmpname;
            // force render once
            if(! self::$blnrender){
                self::$blnrender = true;
            $this->fu_unsetRenderTag();
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
                \SphpBase::sphp_settings()->keywords = explode(",",\SphpBase::sphp_settings()->metakeywords);
            }
            // create social media og meta tags for sharing webpage
            $str1 = '<link rel="canonical" href="'. getThisGateURL() .'" /><meta property="og:locale" content="en_US" />
		<meta property="og:site_name" content="'. $cmpname .'" />
		<meta property="og:type" content="website" />
		<meta property="og:title" content="'. \SphpBase::sphp_settings()->title .'" />
		<meta property="og:description" content="'. \SphpBase::sphp_settings()->metadescription .'" />
		<meta property="og:url" content="'. getThisGateURL() .'" />';
            if ($this->element->hasAttribute("img")) {
                $str1 .= '<meta property="og:image" content="'. $this->element->getAttribute("img") .'" />';
            }else{
                $str1 .= '<meta property="og:image" content="'. \SphpBase::sphp_settings()->slib_res_path .'/masters/default/imgs/android-icon-192x192.png" />';                
            }
                $str1 .= '<meta property="og:image:width" content="600" />
		<meta property="og:image:height" content="600" />';
        // fb meta tags
            if ($this->element->hasAttribute("fb-admin")) {
                $this->element->setDefaultAttribute('article-time', '2019-01-22T11:10:05+00:00');
                $this->element->setDefaultAttribute('article-time-modified', '2020-01-22T11:10:05+00:00');
                $this->element->setDefaultAttribute('article-publisher', 'https://www.facebook.com/ITKruze/');
        $str1 .= '<meta property="fb:admins" content="'. $this->element->getAttribute("fb-admin") .'" />
            <meta property="article:published_time" content="'. $this->element->getAttribute("article-time") .'" />
            <meta property="article:modified_time" content="'. $this->element->getAttribute("article-time-modified") .'" />
            <meta property="article:publisher" content="'. $this->element->getAttribute("article-publisher") .'" />';
            }
        // twiter tags
            if ($this->element->hasAttribute("twitter-site")) {
                $this->element->setDefaultAttribute('twitter-image', \SphpBase::sphp_settings()->slib_res_path .'/masters/default/imgs/android-icon-192x192.png');
        $str1 .= '<meta name="twitter:card" content="summary_large_image" /><meta property="twitter:site" content="'. $this->element->getAttribute("twitter-site") .'" />
            <meta property=""twitter:title" content="'. \SphpBase::sphp_settings()->title .'" />
            <meta property="twitter:description" content="'. \SphpBase::sphp_settings()->metadescription .'" />
            <meta property="twitter:image" content="'. $this->element->getAttribute("twitter-image") .'" />';
            }
            
            addFileLinkCode('ogtag',$str1);
            $this->setInnerHTML('');
            if($this->blnautoseo){
                // component temp file
                $dom = $this->frontobj->HTMLParser->dhtmldom;
                $this->autoSEO1($dom->root->getChildren());
            }
            }else{ // render child temp file
            if($this->blnautoseo){
                // element temp file object because component is same in both file
                $dom = $this->element->frontobj->HTMLParser->dhtmldom;
                $this->autoSEO1($dom->root->getChildren());
            }                
            }
        }

    }

}
