<?php
namespace Sphp\tools{

/**
 * Description of NodeTag
 *
 * @author Sartaj
 */
class NodeTag extends \Sphp\tools\SNode{
    private $tagType = "";
    private $linenum = -1;
    public $tagName = "";
    public $type = "element";
    public $attributes = array();
    public $_a = array();
    public $charpos = 0;
    public $dyna_attr_marker = array();
    public $blnselfclose = false;
    public $blnclose = false;
    public $parentNode = null;
    public $comp = null;
    //true mean comp object created by another tag
    public $refcomptag = false;
    public $refcomptagelement = null;
    public $runat = false;
    public $blnrenderTag = true;
    public $blnrender = true;
    public $pretag = "";
    public $posttag = "";
    public $innerpretag = "";
    public $innerposttag = "";
    public $myclass = "Sphp\\tools\\NodeTag";
    public $frontobj = null;

    public function __construct($frontobj1 = null) {
        $this->frontobj = $frontobj1;
    }
    // not in use
    public function init($strtag){
        $stra = explode(" ",$strtag,2);
        $this->tagName = $stra[0];
        $this->checkSelfClose();
        if(isset($stra[1])){
            $this->fetchAttributes($stra[1]);
        }
    }
    public function _setRefComp($compobj) {
        $this->refcomptag = true;
        $this->tagName = $compobj->element->tagName;
        $this->blnselfclose = $compobj->element->blnselfclose;
        $this->blnclose = $compobj->element->blnclose;
        $this->attributes = array_merge($compobj->element->attributes,$this->attributes);
        $this->dyna_attr_marker = array_merge($compobj->element->dyna_attr_marker,$this->dyna_attr_marker);
        $this->refcomptagelement = $compobj->element;
        $this->comp = $compobj;
        $this->setAttribute("data-refcomp", $compobj->getName());
        $this->removeAttribute("id");
        $this->removeAttribute("name");
    }
    public function checkSelfClose(){
        switch(strtolower($this->tagName)){
            case "input":
            case "img":
            case "br":
            case "meta":
            case "link":
            case "hr":
            case "base":
            case "embed":
            case "spacer":{
                $this->blnselfclose = true;
                break;
            }
        }
    }
    public function isSelfClose(){
        return $this->blnselfclose;
    }
    public function _setParent($parent){
        $this->parentNode = $parent;
    }
    public function getParent(){
        return $this->parentNode;
    }
    public function _setLineNo($num){
        $this->linenum = $num;
    }
    public function getLineNo(){
        return $this->linenum;
    }
    public function closeTag(){
        $this->blnclose = true;
    }
    public function _setComponent($component) {
        $this->comp = $component;
    }
    public function getComponent() {
        return $this->comp ;
    }

    public function _fetchAttributes($strdata){
        $pattern = '/(\\w+)\s*=\\s*("[^"]*"|\'[^\']*\'|[^"\'\\s>]*)/';
        preg_match_all($pattern, $strdata, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            if (($match[2][0] == '"' || $match[2][0] == "'") && $match[2][0] == $match[2][strlen($match[2])-1]) {
                $match[2] = substr($match[2], 1, -1);
            }
            $this->attributes[$match[1]] = $match[2];
        }
    }
    public function _fetchAttributes3($strdata){
        $c = 0; $attrvalue = "";
        $ar = explode("=",$strdata);
        while($c < count($ar)){
            $attrname = trim($ar[$c]);
            if(isset($ar[$c+1])){
//                $attrvalue = $this->copyUntil($ar[$c+1]," ");
                $this->attributes[$attrname] = $attrvalue;
                $c += 2;
            }else{
                $c += 1;
            }
        }
        
    }
    public function _fetchAttributes2($strdata){
        $c = 0;
        while($c < strlen($strdata)){
            $attrname = $this->copyUntil($strdata,"=",$c);
            $attrvalue = $this->copyUntil($strdata," ",$attrname[0]+1);
            $this->attributes[$attrname[1]] = $attrvalue[1];
            $c = $attrvalue[0];
            $c += 1;
        }
        
    }
    public function getAttributesHTML(){ 
        $str = "";        
        /* if(\SphpBase::sphp_settings()->blnEditMode){
            
        foreach($this->attributes as $key=>$val){
            $str .= " " . $key . '="' . str_replace('"',"&quot;",$val) .'"';
        }
            
        }
         * 
         */
        foreach($this->attributes as $key=>$val){
            if(!isset($this->dyna_attr_marker[$key])){
                $str .= " " . $key . '="' . str_replace('"',"&quot;",$val) .'"';
            }
        }
        
        return $str;
    }
    public function getAttributesCat($prefix){ 
        $ar1 = array();
        foreach($this->attributes as $key=>$val){
            $l1 = strlen($key);
            $str1 = str_replace($prefix,'',$key);
            if($l1 > strlen($str1)){
                $ar1[$str1] =  $val;
            }
        }
        return $ar1;
    }
    public function createElement($taghtml) {
        $obj = new NodeTag();
        $obj->init($taghtml);
        return $obj;
    }
    
    public function render(){
        $strData = "";
        $strData = $this->innerpretag;
        //$debug = getDebug();
        if($this->blnrender){ 
        foreach($this->children as $child){ 
            $strData .= $child->render();
        }
        $strData .= $this->innerposttag;
        if($this->blnrenderTag && $this->tagName!=""){
            return $this->generateHTML($strData);
        }else{
            return $strData;
        }
        }else{ 
            return "";
        }
    }
    private function generateHTML($strData) {
        $strTag = $this->pretag;
        if(!$this->blnselfclose){
            $strTag .= "<" . $this->tagName . $this->getAttributesHTML() . ">";
            $strTag .= $strData;
            $strTag .= "</" . $this->tagName . ">";
        }else{
            $strTag .= "<" . $this->tagName . $this->getAttributesHTML() . " />";
            $strTag .= $strData; 
        }
        $strTag .= $this->posttag;
        return $strTag ;
    }
// start inter action functions
    public function hasAttribute($name){
        if(isset($this->attributes[$name])){
            return true;
        }else{
            return false;
        }
    }
    public function setDefaultAttribute($name,$val){
        if(! $this->hasAttribute($name)){
            $this->setAttribute($name, $val);
        }
    }
    public function getAttribute($name){
        if(isset($this->attributes[$name])){
            return $this->attributes[$name];
        }else{
            return "";
        }
    }
    public function removeAttribute($name){
        if(isset($this->attributes[$name])){
            unset($this->attributes[$name]);
        }
    }
    public function setAttribute($name,$val){ 
        $this->attributes[$name] = $val;
    }
    public function appendAttribute($name,$val){ 
        $this->attributes[$name] = $this->getAttribute($name) . $val;
    }
    public function hasAttributeValue($name,$val){ 
        if(strpos($this->getAttribute($name),$val) !== false){
            return true;
        }
        return false;
    }
    public function setAttributeDyna($name,$runonce=false){
        $this->dyna_attr_marker[$name] = array(true,$runonce);
    }
    public function isDynaAttrRun($name){
        return $this->dyna_attr_marker[$name][1];
    }
    public function getAttributes() {
        return $this->attributes;
    }
    /** Over write or remove html tag
     *  This can also Remove element
     * @param type $html
     */
    public function setOuterHTML($html){
        $this->removeChildren();
        $txtobj = new NodeText();
        $txtobj->init($html);
        $this->appendChild($txtobj);
        $this->blnrenderTag = false;
    }
    /**
     * Set Inner HTML as text. It will not parse HTML nodes.
     * If you want parse then use parseChildren method.
     * Parse children will append nodes and modify original document for further processing.
     * @param string $html
     */
    public function setInnerHTML($html){
        $this->removeChildren();
        $txtobj = new NodeText(); 
        $txtobj->init($html);
        $this->appendChild($txtobj);
    }
    public function getInnerHTML(){ 
        $innerHTML = ""; 
        foreach ($this->children as $child) 
        { 
            $innerHTML .= $child->render();
        }
        return $innerHTML; 
    } 
    public function getOuterHTML(){ 
        return $this->render();
    }
    public function setPreTag($tagdata) {
        $this->pretag = $tagdata;
    }
    public function setPostTag($tagdata) {
        $this->posttag = $tagdata;
    }
    public function setInnerPreTag($tagdata) {
        $this->innerpretag = $tagdata;
    }
    public function setInnerPostTag($tagdata) {
        $this->innerposttag = $tagdata;
    }
    public function appendPreTag($tagdata) {
        $this->pretag .= $tagdata;
    }
    public function appendPostTag($tagdata) {
        $this->posttag .= $tagdata;
    }
    public function appendInnerPreTag($tagdata) {
        $this->innerpretag .= $tagdata;
    }
    public function appendInnerPostTag($tagdata) {
        $this->innerposttag .= $tagdata;
    }
    public function setTagName($tagname) {
        $this->tagName = $tagname;
    }
    public function wrapTag($taghtml) {
        $newtag = $this->createElement($taghtml);
        $newtag->appendChild($this); 
        $newtag->parentNode = $this->parentNode;
        $this->parentNode = $newtag;
        $newtag->parentNode->replaceChild($newtag, $this);
        return $newtag;
    }
    public function wrapInnerTags($taghtml) {
        $newtag = $this->createElement($taghtml);
        $newtag->children = $this->children;
        $this->children = array();
        $newtag->parentNode = $this;
        $this->appendChild($newtag);
        return $newtag;
    }
    public function appendHTML($html){
        $txtobj = new NodeText();
        $txtobj->init($html);
        $this->appendChild($txtobj);
    }
    public function &__get($name) { 
        switch($name){
            case "innertext":{
                $ohtml = $this->getInnerHTML();
                return $ohtml;
                break;
            }
            case "outertext":{
                $ohtml = $this->getOuterHTML();
                return $ohtml;
                break;
            }
            default:{
                $a1 = $this->getAttribute($name);
                return $a1;
            }
        }
    }

    public function __set($name, $value) {
        switch($name){
            case "innertext":{
                $this->setInnerHTML($value);
                break;
            }
            case "outertext":{
                $this->setOuterHTML($value);
                break;
            }
            default:{
                $this->setAttribute($name, $value);
            }
        }
    }

    public function __isset($name) {
        //no value attr: nowrap, checked selected...
        return ($this->hasAttribute($name));
    }

    public function __unset($name) {
            $this->removeAttribute($name);
    }
    
}
}
