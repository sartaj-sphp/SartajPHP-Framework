<?php
namespace Sphp\comp\ajax{

/**
 * Description of Ajaxsenddata
 *
 * @author SARTAJ
 */
class Ajaxsenddata extends \Sphp\tools\Control {

    private $url = '';
    private $data = '';
    private $dataa = array();
    private $compa = array();
    private $datacomp = '';
    private $outid = '';
    private $method = 'GET';
    private $mime = '';
    private $onrecieve = '';

    public function __construct($name = '', $fieldName = '', $tableName = '') {
        $this->init($name, $fieldName, $tableName);
        $this->setHTMLName("");
    }

    public function setURL($val) {
        $this->url = $val;
    }

    public function setData($val) {
        $this->data = $val;
    }

    public function setDataFromComps($val) {
        $this->compa = explode(',', $val);
    }

    public function setOutID($val) {
        $this->outid = $val;
    }

    public function setOnReceive($val) {
        $this->onrecieve = $val;
    }

    public function setMethodPost() {
        $this->method = 'POST';
    }

    public function setMIME($val) {
        $this->mime = $val;
    }

    public function call() {
        return "a_$this->name();";
    }

    public function postData($url, $data, $cache = 'false', $dataType = 'json') {
        return "aj_$this->name('$url',$data,$cache,'$dataType');";
    }

    public function addJSONBlock($sact, $evtp, $dataar) {
        \SphpBase::$JSServer->addJSONBlock($sact, $evtp, $dataar);
    }

    public function addJSONJSBlock($jsdata = '') {
        \SphpBase::$JSServer->addJSONJSBlock($jsdata);
    }

    public function echoJSON() {
        \SphpBase::$JSServer->echoJSON();
    }

    public function onjsrender() {
        $ajax = new \Sphp\kit\Ajax();
        \SphpBase::$JSServer->getAjax();
        $valobj = null;
        foreach ($this->compa as $key => $val2) {
            $valobj = readGlobal($val2);
            if ($this->method == 'POST') {
                $this->dataa[] = $valobj;
            } else {
                $this->datacomp .= "&" . $valobj->name . "='+ encodeURIComponent(" . $valobj->getJSValue() . ")+'";
            }
        }

        $code = "function a_$this->name(){";
        if ($this->url != '') {
            $code .= "document.getElementById('$this->name').style.visibility = 'visible';";
            if (strpos($this->url, '?')) {
                $chr = '&';
            } else {
                $chr = '?';
            }
            if ($this->method == 'POST') {
                $code .= $ajax->postDataAjax($this->url . $chr . $this->name . "=" . $this->data, $this->outid, "a_e" . $this->name, $this->dataa, $this->mime);
            } else {
                $code .= $ajax->getDataAjax($this->url . $chr . $this->name . "=" . $this->data . $this->datacomp, $this->outid, "a_e" . $this->name);
            }
        }
        $code .= "}
function aj_$this->name(url,data,cache,dataType){
sartajgt('$this->name',url,data,cache,dataType);
        }
        ";
        $code .= "
function a_e$this->name(){
document.getElementById('$this->name').style.visibility = 'hidden';
$this->onrecieve
}
";
        addFooterJSCode($this->name, $code);
    }

    public function onrender() {
        if ($this->innerHTML == '') {
            $this->innerHTML = '<img src="' . $this->myrespath . '/res/ajax-loader.gif" />';
        }
        $this->setAttribute('style', "visibility:hidden;" . $this->getAttribute('style'));
        $this->tagName = 'div';
    }

// javascript functions used by ajax control and other control
    public function getJSValue() {
        return "document.getElementById('$this->name').value";
    }

    public function setJSValue($exp) {
        return "document.getElementById('$this->name').value = $exp;";
    }

}

}
