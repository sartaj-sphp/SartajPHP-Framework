<?php
namespace Sphp\tools{
/**
 * Description of SNode
 * Parent Class of NodeTag
 * @author Sartaj
 */
class SNode {
     public $children = array();
     
    public function getChildren() {
        return $this->children;
    }
    public function isChildren() {
        if(count($this->children>0)){
            return true;
        }else{
            return false;
        }
    }
    /**
     *  Iterate through Children. Return Callback true to exit soon.
     * Callback($event,$child);
     * $event = true or false mean in and out
     * @param function $callback
     */
        public function iterateChildren($callback) {
            foreach($this->children as $child){ 
                if($callback(true,$child) == true){
                    return ;
                }else{
                    $child->iterateChildren($callback);
                    if($callback(false,$child) == true) return ;
                }
            }
        }
        /**
         * Append children from string of html
         * @param string $html
         */
        public function appendChildren($html) {
            $htmlparser = new \Sphp\tools\HTMLDOM();
            $htmlparser->load($html,false);     
            $this->parseObjectLoop($htmlparser->root->nodes);
        }
        /**
         *  parse html and Replace children from html text. 
         *  It will not allow  runas=holder type attributes.
         * Use only for html tags, Component tags will not work. for Components use frontfile object.
         * @param string $html
         */
        public function replaceChildren($html) {
            $this->removeChildren();
            $this->appendChildren($html);
        }
        public function parseObjectLoop($domNode,$parent = null) {
            if($parent == null) $parent = $this;
            foreach ($domNode as $n){

    //            echo $n->tag . " ". $n->isSelfClose(). " start 
    //                     ";

                if($n->nodetype == 3){
                    $txtobj = new NodeText(); // no bind with frontobj work for future
                    $txtobj->init($n->outertext());
                    $parent->appendChild($txtobj);
                    
                }else if($n->nodetype == 1){
                //\SphpBase::debug()->println("pagi " . $n->innertext);
    //            echo $n->tag . " start ";
                    $obj = new NodeTag();
                    $obj->tagName = $n->tag;
                    $obj->blnselfclose = $n->isSelfClose();
                    // stop holder for furthor process
                    if(isset($n->attr["runas"]) && $n->attr["runas"] == "holder") unset($n->attr["runas"]);
                    $obj->attributes = $n->attr;
                    $obj->charpos = $n->charpos;
                    $obj->setParent($parent);
                    $parent->appendChild($obj);
                    if(!$obj->isSelfClose()){
                        if(count($n->nodes)>0){
                            $this->parseObjectLoop($n->nodes,$obj);
                        }

        //                echo $n->tag . " end ";
                        $parent->closeTag();
                    }
                }
            
            }
        }
        
    public function replaceChild($newnode,$oldnode) {
        $index = array_search($oldnode,$this->children);
        $this->children[$index] = $newnode;
    }
    public function appendChild($node) {
        $this->children[] = $node;
    }
    public function setChildren($children) {
        $this->children = $children;
    }
    public function removeChildren() {
        foreach($this->children as $index=>$child){
            unset($this->children[$index]);
        }        
    }
    public function hasChildren() {
        if(count($this->children)>0){
            return true;
        }else{
            return false;
        }
    }
    
}

/**
 * Description of NodeText
 *
 * @author Sartaj
 */
class NodeText  extends \Sphp\tools\SNode{
    private $value;
    public $type = "text";
    public $tagName = "";
    public $myclass = "Sphp\\tools\\NodeText";
    
    
    public function init($val){
        $this->value = $val;
    }
    public function render(){
        return $this->value;
    }
    
}
}
