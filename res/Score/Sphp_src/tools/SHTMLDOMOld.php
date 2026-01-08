<?php
namespace Sphp\tools{
/**
 * Description of SHTMLDOMOld
 *
 * @author Sartaj
 */
use Sphp\tools\HTMLDOM;

class SHTMLDOMOld {
    private $stack = array();
    private $stack2 = array();
    public $root = null;
    private $parent = null;
    private $compparent = null;
    public $dhtmlparser = null;
    public $htmlparser = null;

    public function __construct($dhtmlparser) {
        $this->dhtmlparser = $dhtmlparser;
        $this->htmlparser = new HTMLDOM();
    }
    public function getDoc() {
        return $this->htmlparser->getDoc();
    }

    public function load($str){
        $strtag = "";
        $strtagtype = "text";
        $this->root = new NodeTag($this->dhtmlparser->frontobj);
        $this->root->type = "root";
        $this->parent = $this->root;
        $findchar = array("<?php","?>","->");
        $replacechar = array("#{","}#","-#");
//        $str = str_replace($findchar, $replacechar, $str);
        $this->htmlparser->load($str,false);
// Register the callback function with it's function name
//        $this->htmlparser->set_callback("parseback", $this);
//        $output = $this->htmlparser->save();
        
    }
    public function parseback2($element) {
        if($element->tag != "text"){
//            print_r($element);
            echo "tag " . $element->outertext . "<br> ";
//            echo "Line No. " . $this->htmlparser->pos . "<br> ";
//            echo "cursor. " . $this->htmlparser->cursor . "<br> ";
//            echo " data " . $element->innertext() . "<br> ";
        }else{
            echo "tax " . $element->outertext . "<br> ";
            echo "Line No. " . $this->htmlparser->pos . "<br> ";            
        }
    }
    // process front file object on construct here
    public function parseobj() { 
        $this->parseObjectLoop($this->htmlparser->root->nodes);
    }
    public function parseObjectLoop($domNode) {
        foreach ($domNode as $n){
//            echo $n->tag . " ". $n->isSelfClose(). " start 
//                     ";
            
            if($n->nodetype == 3){
                $txtobj = new NodeText();
                $txtobj->init($n->outertext());
                if(count($this->stack)>0){
                    $this->parent = $this->stack[count($this->stack)-1];
                }else{
                    $this->parent = $this->root;
                }
                $this->parent->appendChild($txtobj);

            }else if($n->nodetype == 1){
//            echo $n->tag . " start ";
                $obj = new NodeTag($this->dhtmlparser->frontobj);
                if(count($this->stack)>0){
                    $this->parent = $this->stack[count($this->stack)-1];
                }else{
                    $this->parent = $this->root;
                }
                $obj->tagName = $n->tag;
                $obj->blnselfclose = $n->isSelfClose();
                $obj->attributes = $n->attr;
                $obj->charpos = $n->charpos;
                $obj->_setParent($this->parent);
                $this->parent->appendChild($obj);
                if($obj->hasAttribute("runat")){
                if(count($this->stack2)>0){
                    $this->compparent = $this->stack2[count($this->stack2)-1];
                    //echo $this->compparent->attributes["id"] . ' child ' . $obj->attributes["id"] . ' , ';
                }else{
                    $this->compparent = null;
                }
                }
                $this->dhtmlparser->setupcomp($obj,$this->compparent);
                if(!$obj->isSelfClose()){
                    $this->pushStack($obj);
                    $this->parent = $obj;
                    if($obj->hasAttribute("runat")){
                        //echo "push " . $obj->attributes["id"] . ' ';
                        array_push($this->stack2, $obj);
                    }
                    if(count($n->nodes)>0){
                        $this->parseObjectLoop($n->nodes);
                    }

    //                echo $n->tag . " end ";
                    if(count($this->stack)>0){
                        $this->parent = $this->popStack();
                    }else{
                        $this->parent = $this->root;
                    }
                    $this->parent->closeTag();
                    if($obj->hasAttribute("runat")){
                    if(count($this->stack2)>0){
                        //echo "pop " . $obj->attributes["id"] . ' ';
                        //$this->parent = array_pop($this->stack2);
                        $this->compparent = array_pop($this->stack2);
                    }else{
                        $this->compparent = null;
                    }
                    }
                    $this->dhtmlparser->endupcomp($this->parent,$this->compparent);
                }else{
                    $this->dhtmlparser->endupcomp($obj,$this->compparent);                    
                }
                
            }
//                echo $n->tag . " end 
//                         ";
        }
    }
    private function renderObjectLoop($domNode,$parent=null) {
        foreach ($domNode as $index=>$node)
        {  
            if($node->myclass == "Sphp\\tools\\NodeTag"){ 
            $this->dhtmlparser->startrender($node,$parent); 

            if($node->hasChildren()){
                if($node->runat){
                    $this->renderObjectLoop($node->getChildren(),$node); 
                }else{
                    $this->renderObjectLoop($node->getChildren(),$parent);
                }
            }
            $this->dhtmlparser->endrender($node,$parent);
            }    
        }
    }
    private function renderObjectLoopComp($domNode,$parent=null) {
        foreach ($domNode as $index=>$node)
        {
            if($node->myclass == "Sphp\\tools\\NodeTag"){ 
            $this->dhtmlparser->startrender($node,$parent); 

            if($node->hasChildren()){
                if($node->runat){
                    $this->renderObjectLoopComp($node->getChildren(),$node); 
                }else{
                    $this->renderObjectLoopComp($node->getChildren(),$parent);
                }
            }
            $this->dhtmlparser->endrender($node,$parent);
            }   
        }
    }
    // render front file object here
    public function renderobj() { 
        $this->renderObjectLoop($this->root->getChildren());
    }
    public function rendercompobj($compelement) {  
        $this->renderObjectLoopComp($compelement->getChildren());
    }
    public function save() { 
        return $this->root->render();
    }
    public function savecomp($compelement) { 
        return $compelement->render();
    }
    private function pushStack($obj){
        array_push($this->stack, $obj);
    }
    private function popStack(){
        return array_pop($this->stack);
    }
    public function print_array($param) {
        $str = "";
        foreach($param as $key=>$val){
            if(is_array($val)){
                $str .= $this->print_array($val);
            }else{
                $str .= $key . "=" . $val . "
";
            }
        }
        return $str;
    }
    
}
}
