<?php
namespace Sphp\Comp\Server{

/**
 * Description of Ajaxsenddata
 *
 * @author SARTAJ
 */
class Ajaxsenddata extends \Sphp\Tools\Component {

    private $url = '';
    private $data = '';
    private $dataa = array();
    private $compa = array();
    private $datacomp = '';
    private $outid = '';
    private $method = 'GET';
    private $mime = '';
    private $onrecieve = '';

    protected function oncreate($element) {
        $this->setHTMLName("");
    }

    public function fu_setURL($val) {
        $this->url = $val;
    }

    public function fu_setData($val) {
        $this->data = $val;
    }

    public function fu_setDataFromComps($val) {
        $this->compa = explode(',', $val);
    }

    public function fu_setOutID($val) {
        $this->outid = $val;
    }

    public function fu_setOnReceive($val) {
        $this->onrecieve = $val;
    }

    public function fu_setMethodPost() {
        $this->method = 'POST';
    }

    public function fu_setMIME($val) {
        $this->mime = $val;
    }

    public function call() {
        return "a_$this->name();";
    }

    public function postData($url, $data, $cache = 'false', $dataType = 'json') {
        return "aj_$this->name('$url',$data,$cache,'$dataType');";
    }

    public function addJsonBlock($sact, $evtp, $dataar) {
        \SphpBase::jsServer()->addJsonBlock($sact, $evtp, $dataar);
    }

    public function addJsonJsBlock($jsdata = '') {
        \SphpBase::jsServer()->addJsonJsBlock($jsdata);
    }

    public function echoJSON() {
        \SphpBase::jsServer()->echoJSON();
    }

    protected function onjsrender() {
        $ajax = new \Sphp\Kit\Ajax();
        \SphpBase::jsServer()->getAjax();
        $valobj = null;
        foreach ($this->compa as $key => $val2) {
            $valobj = readGlobal($val2);
            if ($this->method == 'POST') {
                $this->dataa[] = $valobj;
            } else {
                $this->datacomp .= "&" . $valobj->name . "='+ encodeURIComponent(" . $valobj->getJsValue() . ")+'";
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
        addFooterJsCode($this->name, $code);
    }

    protected function onrender() {
        if ($this->innerHTML == '') {
            $this->innerHTML = '<img src="' . $this->myUrl . '/assets/ajax-loader.gif" />';
        }
        $this->setAttribute('style', "visibility:hidden;" . $this->getAttribute('style'));
        $this->tagName = 'div';
    }

// javascript functions used by ajax control and other control
    public function getJsValue() {
        return "document.getElementById('$this->name').value";
    }

    public function setJSValue($exp) {
        return "document.getElementById('$this->name').value = $exp;";
    }

}

}
