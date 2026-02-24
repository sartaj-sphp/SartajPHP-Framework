<?php




class TabsB extends Sphp\tools\Component{
    private $activeli = 1;
    private $disabletabs = array();
    private $activeblock = 1;
    
    protected function oncreate($element) {
        global $Client;
        if($Client->request($this->name .'li')!="" && $Client->request($this->name .'li')!="null"){
            $this->activeli = $Client->request($this->name . 'li');
        }
    }
    public function fu_disableTabs($param) {
        $arr = explode(",",$param);
        foreach ($arr as $key => $value) {
            $this->disabletabs[$value] = $value;            
        }
    }
    protected function onparse($event,$element) {
        global $gate;
//                $gate->debug->println("activeBlock set");
        static $countli;
        if($element->tag=="li"){
            $countli += 1;
            $element->setAttribute('data-linum',$countli);
            if(isset($this->disabletabs[$countli])){
                $element->attr['class'] = "disabled";                
            }
            else if($this->activeli == $countli){
                $cls = "";
                if(isset($element->attr['class'])){
                    $cls = $element->attr['class'];
                }
                $element->attr['class'] = "active " . $cls ;
                $this->activeblock = $countli;
            }
        }else if($element->tag=="a"){
            $element->setAttribute('data-linum',$countli);
            if($this->activeblock == $countli){
                $this->activeblock = substr($element->attr['href'],1);
            }
        }else if(isset($element->attr['id']) && $element->attr['id'] == $this->activeblock){
                $cls = "";
                if(isset($element->attr['class'])){
                    $cls = $element->attr['class'];
                }
                $element->attr['class'] = $cls . " in active" ;
            
        }
    }
    protected function onjsrender() {
        addHeaderJSFunctionCode('ready', 'tab1', ' $(".nav-tabs").on(\'show.bs.tab\', "li.disabled a", function(event) {
		event.stopImmediatePropagation();
        	return false;
    	});
    $(".nav-tabs").off(\'show.bs.tab\', "li:not(.disabled) a"); 
    $(\'.nav-tabs\').on(\'shown.bs.tab\', "li:not(.disabled) a", function(e){ 
        activeTab = $(e.target).data("linum"); 
        previousTab = $(e.relatedTarget).data("linum"); 
    });');
        addHeaderJSCode('tab1', ' activeTab = "'.$this->activeli.'"; previousTab = "null";');
    }
    protected function onrender(){
        $this->innerHTML = $this->parseHTML($this->innerHTML);
    }

}
