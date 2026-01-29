<?php

/**
 * Description of Select
 *
 * @author SARTAJ
 */

namespace Sphp\Comp\Form{

class Select extends \Sphp\tools\Component {

    public $options = '';
    private $separator = " ";
    private $blnopttxtreplace = false;
    private $opttxtreplace = array();
    public $opt = Array();
    public $blnuseasoc = false;
    public $selectedIndex = 0;
    private $formName = '';
    private $errmsg = '';
    private $msgName = '';
    private $notvalue = '';
// use for check static option tag == value or not found
    private $fstatic = false;
    private $strFirstValue = "null";
    private $cssfield = "";
    private $cssvals = array();
    public $blnsearch = false;

    protected function genhelpPropList() {
        parent::genhelpPropList();
        $this->addHelpPropFunList('setForm','Bind with Form JS Event','','$val');
        $this->addHelpPropFunList('setMsgName','Name Display in placeholder and Error','','$val');
        $this->addHelpPropFunList('setFirstValue','Set First Option to Display','','$val');
        $this->addHelpPropFunList('setOptionsKeyArray','Options as Associative Array, Option Text and value may be different','','');
        $this->addHelpPropFunList('unsetOptionsKeyArray','Options generate with same text and value','','');
        $this->addHelpPropFunList('setSelectedIndex','Set option selected','','');
        $this->addHelpPropFunList('setNotValue','Value that is not valid to submit','','$val');
        $this->addHelpPropFunList('setOptions','Set Options list as comma separated string value=text','','$val');
        $this->addHelpPropFunList('setOptionsArray','Set options as array','','$val');
        $this->addHelpPropFunList('setOptionsJSON','Set options as array via json string','','$json');
        $this->addHelpPropFunList('setOptionsFromTable','Set options from database','','$valueField,$textField:d"",$tableName:d"",$logic:d"", $sql:d"", $cacheTime:d0');
        $this->addHelpPropFunList('setOptionsElement','Over write option element','','$index, $value:d"", $text:d""');
        $this->addHelpPropFunList('removeOptionsElement','Remove option element','','$index');
    }

    protected function oninit() {
        $this->tagName = "select";
        if(!$this->element->hasAttribute("name")){
            $this->HTMLName = $this->name;
        }else{
            $this->HTMLName = $this->getAttribute("name");            
        }

        if($this->getAttribute("msgname") != ""){
            $this->msgName = $this->getAttribute("msgname");
        }        
    }
    public function setErrMsg($msg){
        $this->errmsg .= '<strong class="alert-danger">' . $msg . '</strong>';
        if(\SphpBase::sphp_request()->isAJAX()){
            \SphpBase::JSServer()->addJSONJSBlock('$("#'. $this->name .'").after("<strong class=\"alert-danger\">' . $msg . '! </strong>");');
        }
        setErr($this->name, $msg);
    }
    /**
     * Find and replace string in option text
     * @param type $find find string
     * @param type $rep replace string
     */
    public function fu_replace($find,$rep){
        $this->blnopttxtreplace = true;
        $this->opttxtreplace = array($find,$rep);
    }
/**
 * Separator for Option Text from multi fields of db with this Character
 * @param string $sepa default = " " 
 */
    public function fu_setSeparator($sepa){
        $this->separator = $sepa;
    }
    /**
     * DB Table Field use for set as class in option tag
     * @param string $tblfield DB Table field
     */
    public function fu_setCssField($tblfield){
        $this->cssfield = $tblfield;
    }
    /**
     * Make Select as Type-able and Searchable
     */
    public function fu_enableSearch(){
        $this->blnsearch = true;
    }
    public function fi_setForm($val) {
        $this->formName = $val;
    }

    public function fu_setMsgName($val) {
        $this->msgName = $val;
        $this->setAttribute('placeholder', $val);
    }

    public function fu_setFirstValue($val) {
        $this->strFirstValue = $val;
    }

    /**
     * Use Options as diffrent in show in html and in value html filed<br>
     * options[key] = val <br>
     * option value= key <br>
     * option text = val <br>
     * By default = false
     */
    public function setOptionsKeyArray() {
        $this->blnuseasoc = true;
    }

    public function getOptionsKeyArray() {
        return $this->blnuseasoc;
    }

    public function unsetOptionsKeyArray() {
        $this->blnuseasoc = false;
    }

    public function fu_setSelectedIndex($val) {
        $this->selectedIndex = $val;
    }

    public function getSelectedIndex() {
        return $this->selectedIndex;
    }
    
    public function getSelectedValue() {
        if(trim($this->value)!=""){
            return $this->value;            
        }else if(count($this->opt)>0){
            if($this->opt[0][0]!=""){
                return $this->opt[0][0];
            }else{
                return $this->opt[0][1];                
            }
        }

    }

    public function fi_setNotValue($val) {
        $this->notvalue = $val;
        if ($this->issubmit) {
            if ($this->notvalue == $this->getValue()) {
                $this->setErrMsg( $this->getAttribute("msgname") .' ' . "Please Select a Value");
            }
        }
    }

    /**
     * Pass parameter like $val = "vcd,dvd,mp3";<br>
     * @param String $val
     */
    public function fu_setOptions($val) {
        $this->unsetOptionsKeyArray();
        $this->options = $val;
        $this->opt = array();
        $this->genOptionArray();
    }

    public function getOptions() {
        return $this->options;
    }

    /**
     * Pass parameter like $val[] = Array('VCD','Code 1');<br>
     * $val[] = Array('DVD','Code 2');<br>
     * DVD = value of option tag and 'Code 2' = text<br>
     * @param Array $val
     */
    public function setOptionsArray($val) {
        $this->opt = $val;
        $this->options = '';
        $this->genOptionList();
    }
    /**
     * Set JSON String as key value pairs.
     * funsetOptionsJSON='[["0","Parent"], ["1", "Child"]]'
     * funsetOptionsJSON='{"0":"Parent", "1": "Child"}'
     * @param string $val json string
     */
    public function fu_setOptionsJSON($val) {
        //$val = trim($val);
        $opt2 = json_decode($val,true);
        $opt1 = array();
        if($val[0] == '{'){
            foreach($opt2 as $key=>$val){
                $opt1[] = [$key,$val];
            }
            $this->opt = $opt1;
        }else{
            $this->opt = $opt2;            
        }
        $this->options = '';
        $this->setOptionsKeyArray();
        $this->genOptionList();
    }

    public function getOptionsArray() {
        return $this->opt;
    }

    private function genOptionArray() {
        $str = explode(',', $this->options);
        foreach ($str as $index => $val) {
            $this->opt[] = Array('', $val);
        }
    }

    private function genOptionList() {
        $str = $this->opt;
        foreach ($str as $index => $val) {
            if ($this->options == '') {
                $this->options = $val[1];
            } else {
                $this->options .= "," . $val[1];
            }
        }
    }

    public function setOptionsElement($index, $value = '', $text = '') {
        $this->opt[$index] = Array($value, $text);
        $this->options = '';
        $this->genOptionList();
    }

    public function getOptionsElement($index) {
        return $this->opt[$index];
    }

    public function removeOptionsElement($index) {
        unset($this->opt[$index]);
        $this->options = '';
        $this->genOptionList();
    }

    public function fu_setOptionsFromTable($valueField, $textField = '', $tableName = '', $logic = '', $sql = '', $cacheTime = '0') {
        $tblName = \SphpBase::page()->tblName;
        $mysql = \SphpBase::dbEngine();
        $blnMultiTextField = false;
        $blnMultiValField = false;
        $arr1 = Array();
        $blncsfield = false;
        $csfield = "";
        
        if($this->cssfield != ""){
            $csfield = ',' . $this->cssfield;
            $blncsfield = true;
        }
        $ar1 = explode(",", $textField);
        if (count($ar1) > 1) {
            $blnMultiTextField = true;
        }
        $ar2 = explode(",", $valueField);
        if (count($ar2) > 1) {
            $blnMultiValField = true;
        }

        if ($tableName == '') {
            $tableName = $tblName;
        }
        if($sql==''){
        if ($textField == '') {
            if($blnMultiValField){
                $textField = $ar2[0];
            }else{
                $textField = $valueField;                
            }
            $sql = "SELECT $valueField $csfield FROM $tableName $logic";
        } else {
            $sql = "SELECT $valueField,$textField $csfield FROM $tableName $logic";
        }
        }

        $result = $mysql->fetchQuery($sql, $cacheTime, '', $valueField);
        foreach ($result as $index2 => $row2) {
            foreach ($row2 as $index => $row) {
                $strv1 = "";
                $strt1 = "";
                if ($blnMultiTextField) {
                    foreach ($ar1 as $key => $value) {
                        if($strt1 != ""){
                            $strt1 .= $this->separator . $row[$value] ;
                        }else{
                            $strt1 .= $row[$value] ;                            
                        }
                    }
                } else {
                    $strt1 = $row[$textField];
                }
                if ($blnMultiValField) {
                    foreach ($ar2 as $key => $value) {
                        $strv1 .= $row[$value] . ',';
                    }
                } else {
                    $strv1 = $row[$valueField];
                }
                $arr1[] = Array($strv1, $strt1);                    
                if($blncsfield) $this->cssvals[] = $row[$this->cssfield]; // use for set class attribute of option tag
            }
        }
        $this->setOptionsKeyArray();
        $this->setOptionsArray($arr1);
    }

    protected function onprejsrender() {
        if ($this->formName != '' && $this->notvalue != '') {
            $jscode = "if(blnSubmit==true && " . $this->getJSValue() . "=='" . $this->notvalue . "'){
    blnSubmit = false ;
displayValidationError(document.getElementById('$this->name'),'Please Select One Option From " . $this->msgName . "');
document.getElementById('$this->name').focus();
}";
            addHeaderJSFunctionCode("{$this->formName}_submit", "$this->name", $jscode);
        }
    }

    public function processStaticOptions($element) {
        if ($element->tag == 'option') {
            if (($element->hasAttribute('value') && strtolower($element->getAttribute('value')) == strtolower($this->value)) || strtolower($element->innertext) == strtolower($this->value)) {
                $element->attr[' selected'] = 'selected';
            }
                $this->fstatic = true;
        }
    }
    
    protected function onprerender() {
        if($this->blnsearch){
            addFileLink($this->myrespath . "/jslib/select2.min.css");
            addFileLink($this->myrespath . "/jslib/select2.min.js");
        }
    }

    protected function onrender() {
         if($this->getVisible()){
        $HTMLParser = new \Sphp\tools\HTMLParser();
        if($this->blnsearch){
            addHeaderJSFunctionCode("ready", "select2","$(\"#{$this->name}\").select2({
        theme: \"classic\",
        width: '100%',
        placeholder: \"{$this->placeholder}\",
        dropdownParent: $('body')
    });");
        }
        if($this->errmsg!=""){
            $this->setPostTag($this->errmsg);
        }        
        if ($this->getAttribute('class') == '') {
            $this->class = "form-control";
        }
        if ($this->options != '') {
            $this->innerHTML = $this->getOptionsHTML();
        } else {
            $this->innerHTML = $HTMLParser->parseHTMLTag($this->innerHTML, 'processStaticOptions', $this);
            if (!$this->fstatic) {
                $this->innerHTML .= '<option selected="selected">' . $this->value . '</option>';
            }
        }
        switch($this->styler){
            case 1:{
                $this->setPreTag('<div class="form-floating mb-3">');
                $this->setPostTag('<label for="'. $this->HTMLID .'" class="form-label">'. $this->msgName .'</label></div>');
                break;
            }case 2:{
                $this->setPreTag('<div class="mb-3">
                <label for="'. $this->HTMLID .'" class="form-label">'. $this->msgName .'</label>');
                $this->setPostTag('<div id="'. $this->HTMLID .'Help" class="form-text">'. $this->helptext .'</div></div>');
                break;
            }
        }
         }else{
             $this->setAttribute('value', $this->getSelectedValue());
         }
    }

    public function getOptionsHTML() {
        $vals = $this->value;
        $strOut = '';
        $CF = 0;
        $arr1 = Array();

        $blncsfield = false; 
        if(count($this->cssvals) > 0){
            $blncsfield = true;
        }

        if ($this->strFirstValue != "null") {
            $stra = explode(',', $this->strFirstValue);
            if (count($stra) > 1) {
                $arr1[] = Array($stra[0], $stra[1]);
            } else {
                $arr1[] = Array($stra[0], $stra[0]);
            }
            $holder = array_merge($arr1, $this->opt);
            $ar2 = array('firstopt');
            if($blncsfield) $this->cssvals = array_merge($ar2,$this->cssvals);
        } else {
            $holder = $this->opt;
        }

        
        if ($vals != '') {
            $holder2 = $vals;
            foreach ($holder as $key2 => $val) {
                $cssatr = "";
                if($blncsfield) $cssatr = 'class="'. $this->cssvals[$key2] .'"';
                
                $key = $val[0];
                if (!$this->blnuseasoc) {
                    $key = $val[1];
                }
                // replace text according to replace string
                if($this->blnopttxtreplace) $val[1] = str_replace($this->opttxtreplace[0],$this->opttxtreplace[1],$val[1]);

                if ($key == $holder2) {
                    $strOut .= "<option $cssatr value=\"$key\" selected>" . $val[1] . "</option>";
                } else {
                    $strOut .= "<option  $cssatr value=\"$key\">" . $val[1] . "</option>";
                }
            }
        } else {
            foreach ($holder as $key2 => $val) {
                $cssatr = "";
                if($blncsfield) $cssatr = 'class="'. $this->cssvals[$key2] .'"';

                $key = $val[0];
                if (!$this->blnuseasoc) {
                    $key = $val[1];
                }
                // replace text according to replace string
                if($this->blnopttxtreplace) $val[1] = str_replace($this->opttxtreplace[0],$this->opttxtreplace[1],$val[1]); 
                
                if ($CF == $this->selectedIndex) {
                    $this->value = $key;
                    $strOut .= "<option  $cssatr value=\"$key\" selected>" . $val[1] . "</option>";
                } else {
                    $strOut .= "<option  $cssatr value=\"$key\">" . $val[1] . "</option>";
                }
                $CF += 1;
            }
        }
        return $strOut;
    }

// javascript functions
    public function getJSValue() {
        return "document.getElementById('$this->name').options[document.getElementById('$this->name').selectedIndex].value";
    }

    public function setJSValue($exp) {
        return " jql(\"select#$this->name\").val($exp); ";
    }

    public function setJSOptionValue($exp) {
        return "document.getElementById('$this->name').options[document.getElementById('$this->name').selectedIndex] = $exp;";
    }

    public function getJSSelectedIndex() {
        return "document.getElementById('$this->name').selectedIndex";
    }

}
}
