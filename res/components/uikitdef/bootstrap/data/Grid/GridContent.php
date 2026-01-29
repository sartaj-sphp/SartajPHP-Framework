<?php
/**
 * Description of GridContent
 *
 * @author SARTAJ
 */


class GridContent extends Component{
public $type = "content";
public $strFormat = "";
public $row = array();
public $result = array();

public function oncreate($element){
unset($element->attr['id']);
unset($element->attr['dtable']);
unset($element->attr['parentobj']);
unset($element->attr['path']);
unset($element->attr['runat']);
unset($element->attr['pathres']);
unset($element->attr['phpclass']);
unset($element->attr['dfield']);
$this->strFormat = $element->outertext;
//$element->outertext = '';
        $this->fu_unsetRenderTag();
}

public function getField($column){
    return $this->row[$column];
}
public function onrender() {
    $strOut = "";
 foreach($this->result as $key1=>$keyar){
 foreach($keyar as $index=>$this->row){
$tmpf = new FrontFile($this->strFormat,true);
$tmpf->run();
    $strOut .= $tmpf->data;
 }
 
 }
$this->setInnerHTML($strOut);

}
    
}