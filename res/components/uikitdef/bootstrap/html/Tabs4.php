<?php




class Tabs4 extends Sphp\Tools\Component{
    private $activeli = 1;
    private $disabletabs = array();
    private $activeblock = 1;
    
    protected function oncreate($element) {
        $client = SphpBase::sphpRequest();
        if($client->request($this->name .'li')!="" && $client->request($this->name .'li')!="null"){
            $this->activeli = $client->request($this->name . 'li');
        }
    }
    public function fu_disableTabs($param) {
        $arr = explode(",",$param);
        foreach ($arr as $key => $value) {
            $this->disabletabs[$value] = $value;            
        }
    }
    protected function onchildevent($event, $obj){
        echo $event;
    }
    protected function onparse($event,$element) {
        global $gate;
//                $gate->debug->println("activeBlock set $event $element->tagName");
        if($event=="start"){
        static $countli;
        if($element->attributes['class']=="nav-link"){
            $countli += 1;
            $element->attributes['data-linum'] = $countli;
            if(isset($this->disabletabs[$countli])){
                $element->attributes['class'] =  $element->getAttribute("class") . " disabled";                
            }
            else if($this->activeli == $countli){
                $cls = "";
                if(isset($element->attributes['class'])){
                    $cls = $element->attributes['class'];
                }
                $element->attributes['class'] = $cls . " active " ;
                $this->activeblock = $countli;
            }
            if($this->activeblock == $countli){
                $this->activeblock = substr($element->attributes['href'],1);
            }
        }else if(isset($element->attributes['id']) && $element->attributes['id'] == $this->activeblock){
                $cls = "";
                if(isset($element->attributes['class'])){
                    $cls = $element->attributes['class'];
                }
                $element->attributes['class'] = $cls . " in active" ;
        }
            
        }
    }
    protected function onjsrender() {
        addHeaderJsFunctionCode('ready', 'tab1', ' $(".nav-tabs").on(\'show.bs.tab\', "li.disabled a", function(event) {
		event.stopImmediatePropagation();
        	return false;
    	});
    $(".nav-tabs").off(\'show.bs.tab\', "li:not(.disabled) a"); 
    $(\'.nav-tabs\').on(\'shown.bs.tab\', "li:not(.disabled) a", function(e){ 
        activeTab = $(e.target).data("linum"); 
        previousTab = $(e.relatedTarget).data("linum"); 
    });');
        addHeaderJsCode('tab1', ' activeTab = "'.$this->activeli.'"; previousTab = "null";');
    }
    protected function onrender(){
    global $gate;

        //$this->parseMe();
        $this->class .= "tabblock";
    }

}
