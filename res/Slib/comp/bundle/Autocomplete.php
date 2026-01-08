<?php

/**
 * Description of Autocomplete
 *
 * @author SARTAJ
 * extra == send extra controls value to server with ajax request for autocomplete.
 * use comma separated string of id attributes 
 * <input id="txtmodel" runat="server" extra="maker,type" type="text" dfield="txtmodel" class="form-control" path="libpath/comp/bundle/Autocomplete.php" funsetForm="form2" funsetMsgName="Model" funsetMaxLen="20"  />
 * send data from server
 *         $sltmaker = $this->genFormFront->getComponent('sltcar_maker')->value;
        $s1 = $this->Client->request('term');
        $res = $this->dbEngine->executeQueryQuick("SELECT txtmodel FROM cartype WHERE sltcar_maker='$sltmaker' AND txtmodel LIKE '%$s1%'");
        $d1 = array();
        while($row = mysqli_fetch_assoc($res)){
            $d1[] = $row['txtmodel'];
        }
        $this->genFormFront->txtmodel->sendData($d1);
 */
include_once(SphpBase::sphp_settings()->slib_path . "/comp/html/TextField.php");
class Autocomplete extends \Sphp\comp\html\TextField {

    private $url = "";
    private $synccomp = '';
    private $minlen2 = 2;
    public $valuehid = "";

    protected function oninit() {
        parent::oninit();
        //$this->setHTMLName("");
        $this->url = getEventURL($this->name . '_autocomplete');
    }

    public function fu_setURL($val) {
        $this->url = $val;
    }

    public function sendData($val) {
        SphpBase::JSServer()->addJSONBlock('js', 'proces', '
   ' . SphpBase::sphp_api()->getJSArray("data", $val) . '
  var term = "' . SphpBase::sphp_request()->post('term') . '" ;
' . $this->name . '_cache[term] = data;    
' . $this->name . '_response(data);
    ');
    }

    protected function onjsrender() {
        parent::onjsrender();
        /*
          addFileLink($jquerypath.'themes/base/jquery.ui.all.css');
          addFileLink($jquerypath.'themes/base/jquery.ui.accordion.css');
          addFileLink($jquerypath.'ui/jquery.ui.core.min.js');
          addFileLink($jquerypath.'ui/jquery.ui.widget.min.js');
          addFileLink($jquerypath.'ui/jquery.ui.position.min.js');
          addFileLink($jquerypath.'ui/jquery.ui.menu.min.js');
          addFileLink($jquerypath.'ui/jquery.ui.autocomplete.min.js');
         * 
         */
        $str1 = '';
        if($this->element->hasAttribute('extra')){
            $extra = explode(',',$this->getAttribute('extra'));
            foreach ($extra as $key => $val) {
                $str1 .= 'request["'. $val .'"] = $("#'. $val .'").val();';                
            }
        }
        addHeaderJSFunction($this->name . '_autocomplete', "function " . $this->name . '_autocomplete(request){ ', "
    clearTimeout(this.tmr1); this.tmr1 = setTimeout(function(){
    $str1
getURL('$this->url',request);    
    },800);
}");

        addHeaderJSCode($this->name, ' window["' . $this->name . '_cache"] = {}; window["' . $this->name . '_response"] = null;');
        addHeaderJSFunctionCode('ready', $this->name, '
    $("#' . $this->name . '").autocomplete({
    minLength: ' . $this->minlen2 . ',
    source: function( request, response ) {
            var term = request.term;
            if ( term in ' . $this->name . '_cache ) {
                    response(' . $this->name . '_cache[term]);
                    return;
            }
' . $this->name . '_response = response;
 ' . $this->name . '_autocomplete(request);
            
    },
    select: function(event,ui){
        $("#'. $this->name .'1").val(ui.item.label);
    }
});        
    ');
        if($this->valuehid == '')  $this->valuehid = $this->value;
        $this->addPreTag('<input id="'. $this->name .'1" name="'. $this->name .'1" type="hidden" value="'. $this->valuehid .'" />');
    }

}
