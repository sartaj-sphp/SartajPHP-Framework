<?php

/**
 * Description of Select
 *
 * @author SARTAJ
 */

namespace Sphp\comp\html{

class Select extends \Sphp\tools\Control {

    public $options = '';
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

    public function oninit() {
        $this->tagName = "select";
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

    public function setForm($val) {
        $this->formName = $val;
    }

    public function setMsgName($val) {
        $this->msgName = $val;
        $this->setAttribute('placeholder', $val);
    }

    public function setFirstValue($val) {
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

    public function setSelectedIndex($val) {
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

    public function setNotValue($val) {
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
    public function setOptions($val) {
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
    public function setOptionsJSON($val) {
        $this->opt = json_decode($val,true);
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

    public function setOptionsFromTable($valueField, $textField = '', $tableName = '', $logic = '', $sql = '', $cacheTime = '0') {
        $tblName = \SphpBase::page()->tblName;
        $mysql = \SphpBase::dbEngine();
        $blnMultiTextField = false;
        $blnMultiValField = false;
        $arr1 = Array();
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
            $sql = "SELECT $valueField FROM $tableName $logic";
        } else {
            $sql = "SELECT $valueField,$textField FROM $tableName $logic";
        }
        }

        $result = $mysql->fetchQuery($sql, $cacheTime, '', $valueField);
        foreach ($result as $index2 => $row2) {
            foreach ($row2 as $index => $row) {
                $strv1 = "";
                $strt1 = "";
                if ($blnMultiTextField) {
                    foreach ($ar1 as $key => $value) {
                        $strt1 .= $row[$value] . ' ';
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
            }
        }
        $this->setOptionsKeyArray();
        $this->setOptionsArray($arr1);
    }

    public function onprejsrender() {
        if ($this->formName != '' && $this->notvalue != '') {
            $jscode = "if(blnSubmit==true && " . $this->getJSValue() . "=='" . $this->notvalue . "'){
    blnSubmit = false ;
alert('Please Select One Option From " . $this->msgName . "');
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

    public function onrender() {
        $HTMLParser = new \Sphp\tools\HTMLParser();
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
    }

    public function getOptionsHTML() {
        $vals = $this->value;
        $strOut = '';
        $CF = 0;
        $arr1 = Array();

        if ($this->strFirstValue != "null") {
            $stra = explode(',', $this->strFirstValue);
            if (count($stra) > 1) {
                $arr1[] = Array($stra[0], $stra[1]);
            } else {
                $arr1[] = Array($stra[0], $stra[0]);
            }
            $holder = array_merge($arr1, $this->opt);
        } else {
            $holder = $this->opt;
        }


        if ($vals != '') {
            $holder2 = $vals;
            foreach ($holder as $key2 => $val) {
                $key = $val[0];
                if (!$this->blnuseasoc) {
                    $key = $val[1];
                }

                if ($key == $holder2) {
                    $strOut .= "<option value=\"$key\" selected>" . $val[1] . "</option>";
                } else {
                    $strOut .= "<option value=\"$key\">" . $val[1] . "</option>";
                }
            }
        } else {
            foreach ($holder as $key2 => $val) {
                $key = $val[0];
                if (!$this->blnuseasoc) {
                    $key = $val[1];
                }
                if ($CF == $this->selectedIndex) {
                    $this->value = $key;
                    $strOut .= "<option value=\"$key\" selected>" . $val[1] . "</option>";
                } else {
                    $strOut .= "<option value=\"$key\">" . $val[1] . "</option>";
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
