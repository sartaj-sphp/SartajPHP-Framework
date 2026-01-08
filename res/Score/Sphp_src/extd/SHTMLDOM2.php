<?php
namespace Sphp\tools{
/**
 * Description of SHTMLDOMOld
 *
 * @author Sartaj
 */
use Sphp\tools\HTMLDOM2;

class SHTMLDOM2 {
    private $stack = array();
    private $stack2 = array();
    public $root = null;
    private $parent = null;
    private $compparent = null;
    public $dhtmlparser = null;
    public $htmlparser = null;

    public function __construct($dhtmlparser) {
        $this->dhtmlparser = $dhtmlparser;
        $this->htmlparser = new HTMLDOM2();
    }

    public function load($str){
        $strtag = "";
        $strtagtype = "text";
        $this->root = new NodeTag();
        $this->root->type = "root";
        $this->parent = $this->root;
        $findchar = array("<?php","?>","->");
        $replacechar = array("#{","}#","-#");
        $str = str_replace($findchar, $replacechar, $str);
        $this->htmlparser->load($str);
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
    public function parseobj() {
        $this->parseObjectLoop($this->htmlparser->root->childNodes);
    }
    public function parseObjectLoop2($domNode) {
        $c = 0;
        foreach ($domNode as $n){ 
            $c++; echo $n->nodeName . $c . $n->nodeType;
            if($n->hasChildNodes()){ echo "call back <br>";
                $this->parseObjectLoop($n->childNodes);
            }

        }
    }
    public function parseObjectLoop($domNode) {
        $c = getDebug();
        foreach ($domNode as $n){ //$c++; echo $n->nodeName . $c . $n->nodeType;
//            echo $n->tagName . " " . $n->nodeName . " start 
  //                   ";
//            $c->println($n->nodeType);
            if($n->nodeType == 1){
//            echo $n->tag . " start ";
                $obj = new NodeTag();
                if(count($this->stack)>0){
                    $this->parent = $this->stack[count($this->stack)-1];
                }else{
                    $this->parent = $this->root;
                }
                $obj->tagName = $n->tagName;
                $obj->checkSelfClose();
                $obj->attributes = $n->getAttributes();
                $obj->setParent($this->parent);
                $this->parent->appendChild($obj);
                if($obj->hasAttribute("runat")){
                    $obj->setLineNo($n->getLineNo());
                if(count($this->stack2)>0){
                    $this->compparent = $this->stack2[count($this->stack2)-1];
                }else{
                    $this->compparent = null;
                }
                }
                $this->dhtmlparser->setupcomp($obj,$this->compparent);
                if(!$obj->isSelfClose()){
                    $this->pushStack($obj);
                    $this->parent = $obj;
                    if($obj->hasAttribute("runat")){
                        array_push($this->stack2, $obj);
                    }
                    if($n->hasChildNodes()){ 
                        $this->parseObjectLoop($n->childNodes);
                    }

    //                echo $n->tag . " end ";
                    if(count($this->stack)>0){
                        $this->parent = $this->popStack();
                    }else{
                        $this->parent = $this->root;
                    }
                    $this->parent->closeTag();
                    if($this->parent->hasAttribute("runat")){
                    if(count($this->stack2)>1){
                        $this->parent = array_pop($this->stack2);
                        $this->compparent = array_pop($this->stack2);
                    }else{
                        $this->compparent = null;
                    }
                    }
                    $this->dhtmlparser->endupcomp($this->parent,$this->compparent);
                }else{
                    $this->dhtmlparser->endupcomp($obj,$this->compparent);                    
                }
                
            }else { 
  //echo $n->nodeName  . '<br>' . $n->childNodes->length; 
                $txtobj = new NodeText();
                $txtobj->init($this->outertext($n));
                if(count($this->stack)>0){
                    $this->parent = $this->stack[count($this->stack)-1];
                }else{
                    $this->parent = $this->root;
                }
                $this->parent->appendChild($txtobj);

            }
//                echo $n->tag . " end 
//                         ";
        }
    }
    private function outertext($node) {
        $innerHTML = ""; 
        $innerHTML .= html_entity_decode($this->htmlparser->doc->saveXML($node));
        return $innerHTML;

    }
    private function renderObjectLoop($domNode,$parent=null) {
        foreach ($domNode as $index=>$node)
        {
            if($node->myclass == "Sphp\\tools\\NodeTag"){
            $this->dhtmlparser->startrender($node,$parent); 

            if($node->hasChildren()){
                if($node->getAttribute("runat") == "server"){
                    $this->renderObjectLoop($node->getChildren(),$node);
                }else{
                    $this->renderObjectLoop($node->getChildren(),$parent);
                }
            }
            $this->dhtmlparser->endrender($node,$parent);
            }    
        }
    }
    public function renderobj() {
        $this->renderObjectLoop($this->root->getChildren());
    }
    public function rendercompobj($compelement) {
        $this->renderObjectLoop($compelement->getChildren());
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
