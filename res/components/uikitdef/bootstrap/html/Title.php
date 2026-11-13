<?php

/**
 * Description of Title
 *
 * @author SARTAJ
 */

namespace Sphp\Comp\Html {

    class Title extends \Sphp\Tools\Component {
        private $blnautoseo = false;
        private static $blnrender = false;
        
        public function fu_autoSEO() {
            $this->blnautoseo = true;
        }
        public function fu_setMetaKeywords($v) {
            $this->setAttribute("metaKeywords", $v);
        }
        public function fu_setMetaDescription($v) {
            $this->setAttribute("metaDescription", $v);
        }
        public function fu_setMetaClassification($v) {
            $this->setAttribute("metaClassification", $v);
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
                    if(! $element->hasAttribute('title')) $element->setAttribute('title', \SphpBase::sphpSettings()->getKeyword());
                    break;
                }
                case 'img':{
                    if(! $element->hasAttribute('title')) $element->setAttribute('title', \SphpBase::sphpSettings()->getKeyword());
                    if(! $element->hasAttribute('alt')) $element->setAttribute('alt', \SphpBase::sphpSettings()->getKeyword());
                    break;
                }
            }
        }
        protected function onrender() {
            global $cmpName;
            // force render once
            if(! self::$blnrender){
                self::$blnrender = true;
            $this->fu_unsetRenderTag();
            $hh1 = $this->getInnerHtml();
            $hh1 = $this->executePhpCode($hh1);
            // 70 characters
            \SphpBase::sphpSettings()->title = $hh1;
            if ($this->element->hasAttribute("metaKeywords")) {
                \SphpBase::sphpSettings()->metaKeywords = $this->getAttribute("metaKeywords");
            } else {
                \SphpBase::sphpSettings()->metaKeywords = $hh1;
            }
            // length = 150
            if ($this->element->hasAttribute("metaDescription")) {
                \SphpBase::sphpSettings()->metaDescription = $this->getAttribute("metaDescription");
            } else {
                \SphpBase::sphpSettings()->metaDescription = $hh1;
            }
            if ($this->element->hasAttribute("metaClassification")) {
                \SphpBase::sphpSettings()->metaClassification = $this->getAttribute("metaClassification");
            } else {
                \SphpBase::sphpSettings()->metaClassification = $hh1;
            }
            if ($this->element->hasAttribute("metaAuthor")) {
                \SphpBase::sphpSettings()->metaAuthor = $this->getAttribute("metaAuthor");
            } else {
                \SphpBase::sphpSettings()->metaAuthor = $cmpName;
            }
            if ($this->element->hasAttribute("keywords")) {
                \SphpBase::sphpSettings()->keywords = explode(",", $this->getAttribute("keywords"));
            } else {
                \SphpBase::sphpSettings()->keywords = explode(",",\SphpBase::sphpSettings()->metaKeywords);
            }
            // create social media og meta tags for sharing webpage
            $str1 = '<link rel="canonical" href="'. getThisGateUrl() .'" /><meta property="og:locale" content="en_US" />
		<meta property="og:site_name" content="'. $cmpName .'" />
		<meta property="og:type" content="website" />
		<meta property="og:title" content="'. \SphpBase::sphpSettings()->title .'" />
		<meta property="og:description" content="'. \SphpBase::sphpSettings()->metaDescription .'" />
		<meta property="og:url" content="'. getThisGateUrl() .'" />';
            if ($this->element->hasAttribute("img")) {
                $str1 .= '<meta property="og:image" content="'. $this->element->getAttribute("img") .'" />';
            }else{
                $str1 .= '<meta property="og:image" content="'. \SphpBase::sphpSettings()->slibUrl .'/masters/default/imgs/android-icon-192x192.png" />';                
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
                $this->element->setDefaultAttribute('twitter-image', \SphpBase::sphpSettings()->slibUrl .'/masters/default/imgs/android-icon-192x192.png');
        $str1 .= '<meta name="twitter:card" content="summary_large_image" /><meta property="twitter:site" content="'. $this->element->getAttribute("twitter-site") .'" />
            <meta property=""twitter:title" content="'. \SphpBase::sphpSettings()->title .'" />
            <meta property="twitter:description" content="'. \SphpBase::sphpSettings()->metaDescription .'" />
            <meta property="twitter:image" content="'. $this->element->getAttribute("twitter-image") .'" />';
            }
            
            addFileLinkCode('ogtag',$str1);
            $this->setInnerHtml('');
            if($this->blnautoseo){
                // component temp file
                $dom = $this->frontobj->htmlParser->dhtmldom;
                $this->autoSEO1($dom->root->getChildren());
            }
            }else{ // render child temp file
            if($this->blnautoseo){
                // element temp file object because component is same in both file
                $dom = $this->element->frontobj->htmlParser->dhtmldom;
                $this->autoSEO1($dom->root->getChildren());
            }                
            }
        }

    }

}
