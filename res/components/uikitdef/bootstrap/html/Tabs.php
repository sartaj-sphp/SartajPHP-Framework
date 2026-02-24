<?php




class Tabs extends Sphp\tools\Component{
    private $activeli = 1;
    private $disabletabs = array();
    private $activeblock = 1;
    private $tabhead = '<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Home</button>
    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</button>
    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</button>
    <button class="nav-link" id="nav-disabled-tab" data-bs-toggle="tab" data-bs-target="#nav-disabled" type="button" role="tab" aria-controls="nav-disabled" aria-selected="false" disabled>Disabled</button>
  </div>
</nav>
';
    
    protected function oncreate($element) {
        $Client = SphpBase::sphp_request();
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
    protected function onjsrender2() {
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
        $this->class .= " tabblock";
        $tabgroup = "tab";
        $tabgroup2 = "nav-tabs";
        $tabgroup3 = "";
         switch($this->styler){
            case 1:{ $tabgroup = "pill"; $tabgroup2 = "nav-pills"; break;}
            case 2:{ $tabgroup = "pill"; $tabgroup2 = "flex-column nav-pills me-3"; $tabgroup3 = 'aria-orientation="vertical"';  $this->class .= " d-flex align-items-start"; break;}
            case 3:{ $tabgroup = "underline"; $tabgroup2 = "nav-underline"; break;}
         }
        $tabhead1 = "";
        $this->element->iterateChildren(function($event,$ele1) use(&$tabhead1,$tabgroup){
        if(!$event && $ele1->tagName == "tab"){
            if(! $ele1->hasAttribute("id")) $ele1->setAttribute("id", 'nav-'. strtolower($ele1->getAttribute("text"))); 
            $ele1->appendAttribute("class"," tab-pane fade");
            $ele1->tagName = 'div';
            $active = "";
            $ele1->setAttribute("role","tabpanel");
            $ele1->setAttribute("aria-labelledby","btn-" . $ele1->getAttribute("id"));
            $ele1->setAttribute("tabindex","0");
        if($ele1->hasAttribute("active")) {$active = " active"; $ele1->appendAttribute("class"," show active");}
            $ele1->setInnerPreTag('<div class="card"><div class="card-body">');
            $ele1->setInnerPostTag('</div></div>');
                $tabhead1 .= '  <li class="nav-item" role="presentation">'
                        . '<button class="nav-link'. $active .'" id="btn-'. $ele1->getAttribute("id") .'" data-bs-toggle="'. $tabgroup .'" data-bs-target="#'. $ele1->getAttribute("id") .'" type="button" role="tab" aria-controls="'. $ele1->getAttribute("id") .'" aria-selected="false">'. $ele1->getAttribute("text") .'</button></li>';
            }
        }
        );
        
        $this->element->setInnerPreTag('<ul class="nav '. $tabgroup2 .'" id="nav-'. $this->name .'" role="tablist" '. $tabgroup3 .'>' . $tabhead1 . '</ul>
<div class="tab-content" id="nav-'. $this->name .'-content">
');
        $this->element->setInnerPostTag('</div>');
    }

}
