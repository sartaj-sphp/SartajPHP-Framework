<?php

// start css blocks of temp file
SphpCodeBlock::addCodeBlock('btn-count',function($element,$args,$lstOther_CB){
        if(! isset($lstOther_CB['color'])){
            $element->appendAttribute('class',' btn-primary'); 
        }
    },array('class'=> 'btn position-relative','innerposttag'=>
 '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary">+@arg0 <span class="visually-hidden">unread messages</span></span>'
,"documentation" => 'Create Unread Counter Button of Bootstrap. Use Color CB for set Colors')); 
    
SphpCodeBlock::addCodeBlock('btn-marker',function($element,$args,$lstOther_CB){
        if(! isset($lstOther_CB['color'])){
            $element->appendAttribute('class',' btn-primary');
        }
    },array('class'=> 'btn position-relative','innerposttag'=>
 '<svg width="1em" height="1em" viewBox="0 0 16 16" class="position-absolute top-100 start-50 translate-middle mt-1 bi bi-caret-down-fill" fill="#212529" xmlns="http://www.w3.org/2000/svg"><path d="M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/></svg>'
)); 

// 2 args= width or style,color
SphpCodeBlock::addCodeBlock('border',function($element,$args,$lstOther_CB){
  if(isset($args[0])){
  if(is_numeric($args[0])){
      //  border='' width list:- 0 to 5, top-0, top,end,bootom,start
    $element->appendAttribute('class',' border border-' . $args[0]);      
  }else{
    $element->appendAttribute('class',' border-' . $args[0]);       
  }
  }else{
    $element->appendAttribute('class',' border');      
  }
  if(isset($args[1])){
      //color
    $element->appendAttribute('class',' border-' . $args[1]);      
  }else{
    $element->appendAttribute('class',' border-primary');
  }
  
},array("documentation"=> 'Take 2 args= width or style,color, arg0=border=width list:- 0 to 5, top-0, top,end,bootom,start '
    . 'arg1=color=primary= bootstrap border color name or your custom css class like border-babypink then pass color as babypink'));

SphpCodeBlock::addCodeBlock('align',function($element,$args,$lstOther_CB){
    //align='' left,center,right
  if(isset($args[0])){
    $element->appendAttribute('class',' d-flex justify-content-' . $args[0]);      
  }else{
    $element->appendAttribute('class',' d-flex justify-content-center');      
  }
  
},array('documentation' => ' Take only one arg0=left,center or right'));

SphpCodeBlock::addCodeBlock('rounded',function($element,$args,$lstOther_CB){
    //rounded='' list:- 0 to 3, top,end,bootom,start,circle,pill
  if(isset($args[0])){
    $element->appendAttribute('class',' rounded-' . $args[0]);      
  }else{
    $element->appendAttribute('class',' rounded');      
  }
  
},array('documentation' => 'Take one arg0=rounded= values:- 0 to 3, top,end,bootom,start,circle,pill'));

SphpCodeBlock::addCodeBlock('color',function($element,$args,$lstOther_CB){
 // color:- primary,secondary,success,danger,warning,info,light,dark,white,body,transparent
  if(isset($args[0])){
      // text color
    $element->appendAttribute('class',' text-' . $args[0]);       
  }
  if(isset($args[1])){
      // bg color
    if($element->hasAttributeValue("class","btn")){
      $element->appendAttribute('class',' btn-' . $args[1]);      
    }else{
      $element->appendAttribute('class',' bg-' . $args[1]);       
    }
  }
  if(isset($args[2])){
      // enable =1 bg color gradient
    $element->appendAttribute('class',' bg-gradient'); 
  }
},array('documentation' => 'Take 3 Args, arg0=text color, arg1=bg color, arg2=1 mean enable gradiant, '
    . 'Values:- primary,secondary,success,danger,warning,info,light,dark,white,body,transparent'));

SphpCodeBlock::addCodeBlock('parallax',function($element,$args,$lstOther_CB){
    $element->appendAttribute("class"," cbv parallax"); 
    if(isset($args[0])){
        $element->setInnerPreTag('<img src="'. $args[0] .'" class="parallax-img" /><div class="container py-4">');
    }else{
        $r1 = null;
        $element->iterateChildren(function($event,$ele1) use (&$r1){
            if($ele1->tagName == "img") {
                $r1 = $ele1;
                return true;
            }
            return false;
        });
        if($r1 != null){
            $r1->appendAttribute("class","parallax-img");
            $element->setInnerPreTag($r1->render() . '<div class="container py-4">'); 
            $r1->setOuterHTML(''); // remove tag
        }else{
            $element->setInnerPreTag('<img src="'. SphpBase::sphp_settings()->comp_uikit_res_path .'/masters/default/assets/img/cta-bg.jpg"  class="parallax-img" /><div class="container py-4">');
        }
    }
    $element->setInnerPostTag("</div>");
    
},array('documentation' => 'Create Parallax Effect on Image, arg0=image url')); 

SphpCodeBlock::addCodeBlock('teamlist',function($element,$args,$lstOther_CB){
    $r1 = array();
    $element->iterateChildren(function($event,$ele1) use(&$r1){
        if(!$event){
            switch($ele1->tagName){
                case 'member':{
                    $ele1->appendAttribute("class"," px-4 py-4 member");
                    $ele1->appendPreTag('<div class="col-12 col-sm-12 col-md-6 col-lg-4">');
                    $ele1->appendPostTag('</div>');
                    $ele1->setDefaultAttribute("data-aos","fade-up");
                    $ele1->setDefaultAttribute("data-aos-delay", rand(100, 300));
                    // wrap memeber info name post and detail
                    if(count($r1) > 0){
                        $elef = $r1[0];
                        $elel = $r1[count($r1) - 1];
                        $elef->setPreTag('<div class="member-info text-center" >');
                        $elel->setPostTag('</div>');
                    }
                     $ele1->tagName = "div";
                    break;
                }
                case 'pic':{
                    // scoial not implemented
                    $social = '<div class="social">
                <a href="#"><i class="bi bi-twitter"></i></a>
                <a href="#"><i class="bi bi-facebook"></i></a>
                <a href="#"><i class="bi bi-instagram"></i></a>
                <a href="#"><i class="bi bi-linkedin"></i></a>
              </div>';
                    $ele1->setPreTag('<div class="member-img">');
                    //$ele1->setPostTag($social . '</div');
                    $ele1->setPostTag('</div>');
                    $ele1->appendAttribute("class"," img-fluid");
                     $ele1->tagName = "img";
                    break;
                }case 'name':{
                    $r1[] = $ele1;
                    $ele1->tagName = "h4";
                    break;
                }case 'post':{
                    $r1[] = $ele1;
                    $ele1->tagName = "span";
                    break;
                }case 'detail':{
                    $r1[] = $ele1;
                    $ele1->tagName = "p";
                    break;
                }
            }
        }else if($ele1->tagName == 'member'){
                $r1 = array(); 
        }
            return false; // iterate all
        });
    
    $element->appendAttribute("class"," cbv team section"); 
    $pre = "";
    if(isset($args[0])){
        $pre .= '<h2>'. $args[0] .'</h2>';
    }
    if(isset($args[1])){
        $pre .= '<p>'. $args[1] .'</p>';        
    }
    $pre = '<div class="container section-title" data-aos="fade-up">' . $pre . '</div>';
    //$element->setPreTag($pre);
    $element->setInnerPreTag($pre . '<div class="container"><div class="row gy-5">');
    $element->setInnerPostTag('</div></div>');
},array('documentation' => 'Create Team List, also need special children custom tags, arg0=heading in h2 arg1=paragraph. Example:- <div runcb="true" sphp-cb-teamlist="Our Services,|personal use, we tailor solutions" >
    
    <member>
       <pic src="masters/images/fixping.png"  />
       <name>Fix Ping</name>
       <post>Team Leader</post>
       <detail>Fix Ping is good Team Leader</detail>
    </member>    
    
</div>
')); 

SphpCodeBlock::addCodeBlock('position',function($element,$args,$lstOther_CB){
    $align = "left";
    if(isset($args[0])) $align = $args[0];
    switch($align){
        case 'topcenter': {
            $element->appendAttribute('class',' top-0 start-50'); break;            
        }case 'middle': {
            $element->appendAttribute('class',' top-50 start-50'); break;            
        }case 'topcenter': {
            $element->appendAttribute('class',' top-0 start-50'); break;            
        }case 'topright': {
            $element->appendAttribute('class',' top-0 start-100'); break;            
        }case 'bottomcenter': {
            $element->appendAttribute('class',' top-100 start-50'); break;            
        }default:{
            $element->appendAttribute('class',' top-0 start-0');
        }
    }
},array('class'=>'position-absolute','pclass'=>'position-relative')); 

SphpCodeBlock::addCodeBlock('shadow',function($element,$args,$lstOther_CB){
    if(isset($args[0])){
        $ch = array(); $ch[1] = 'shadow-sm'; $ch[2] = 'shadow-lg';$ch[3] = 'shadow-none';
        $element->appendAttribute('class',' '. $ch[intval($args[0])]);  
    }else{
        $element->appendAttribute('class',' shadow');         
    }
}); 

SphpCodeBlock::addCodeBlock('size',function($element,$args,$lstOther_CB){
    if(isset($args[0])){
        $ch = array(); $ch[1] = 'w-25'; $ch[2] = 'w-50';$ch[3] = 'w-75';$ch[4] = 'w-100';$ch[5] = 'w-auto';
        $element->appendAttribute('class',' '. $ch[intval($args[0])]);  
    }else{
        $element->appendAttribute('class',' w-50'); 
    }
    if(isset($args[1])){
        $ch = array(); $ch[1] = 'h-25'; $ch[2] = 'h-50';$ch[3] = 'h-75';$ch[4] = 'h-100';$ch[5] = 'h-auto';
        $element->appendAttribute('class',' '. $ch[intval($args[1])]);  
    }else{
        $element->appendAttribute('class',' h-100'); 
    }
}); 

SphpCodeBlock::addCodeBlock('overflow',function($element,$args,$lstOther_CB){
    if(isset($args[0])){
        $ch = array(); $ch[1] = 'overflow-scroll'; $ch[2] = 'overflow-hidden';$ch[3] = 'overflow-visible';
        $element->appendAttribute('class',' '. $ch[intval($args[0])]);  
    }else{
        $element->appendAttribute('class',' overflow-auto');         
    }
}); 
SphpCodeBlock::addCodeBlock('text',function($element,$args,$lstOther_CB){
    if(count($args)>0){
    if(isset($args[0])){
        // align 1 to 3
        $ch = array(); $ch[1] = 'text-start'; $ch[2] = 'text-center';$ch[3] = 'text-end';
        $element->appendAttribute('class',' '. $ch[intval($args[0])]);  
    }
    if(isset($args[1])){
        // font size 1 to 5
        $element->appendAttribute('class',' fs-'. $args[1]);  
    }
    if(isset($args[2])){
        // font weight 1 to 6
        $ch = array(); $ch[1] = 'fw-bold'; $ch[2] = 'fw-bolder';$ch[3] = 'fw-normal';
        $ch[4] = 'fw-light';$ch[5] = 'fw-lighter';$ch[6] = 'fst-italic';
        $element->appendAttribute('class',' '. $ch[intval($args[2])]);  
    }
    if(isset($args[3])){
        // Line height 1 to 4
        $ch = array(); $ch[1] = 'lh-1'; $ch[2] = 'lh-sm';$ch[3] = 'lh-base';
        $ch[4] = 'lh-lg';
        $element->appendAttribute('class',' '. $ch[intval($args[3])]);  
    }
    }else{
        $element->appendAttribute('class',' text-start text-wrap text-break ');        
    }
}); 
//$cb['card'] = SphpCodeBlock::addCodeBlock(null,'p','para text-primary','<p>@arg1</p>','<span>@arg2</span>','<i>@arg3</i>','<b>@arg0</b>'); 

//big items start
SphpCodeBlock::addCodeBlock('card',function($element,$args,$lstOther_CB){
        $str1 = '';
        $str3 = '';
        if(! $element->getParent()->hasAttributeValue("class","card")){
            $str1 = '<div class="card">';
            $str3 = '</div>';
        }
    if(isset($args[0])){
        // header image or header title
        if(strpos($args[0],'.')){
    $str1 .= '<img src="'. $args[0] .'" class="card-img-top" alt="'. $element->title .'" title="'. $element->title .'" />';
        }else{
    $str1 .= '<div class="card-header" title="'. $element->title .'" >' . $args[0] . '</div>';            
        }
    }
    $element->appendPreTag($str1);
    $str1 = '';         
    if(isset($args[1])){
        $str1 .= '<div class="card-footer text-muted" title="'. $element->title .'" >' . $args[1] . '</div>';          
    }
    $element->appendPostTag($str1 . $str3);
    if($element->title != "") $element->appendInnerPreTag('<h5 class="card-title">'. $element->title .'</h5>');
},array('class'=>'card-body')); 

SphpCodeBlock::addCodeBlock('label',function($element,$args,$lstOther_CB){
    if(isset($args[0])){
        $param  = $args[0];
        $param = str_replace('*', '<span class="text-danger">*</span>', $param);
    $size = array('col-md-4 col-xs-12','col-md-8 col-xs-12');
    if(isset($args[1])){
        $size[0] = $args[1];
    }
    if(isset($args[2])){
        $size[1] = $args[2];
    }
    $id = "";
    if(! $element->hasAttribute('placeholder')) $element->setAttribute('placeholder',$args[0]);
    if($element->getComponent() != null){
        $id = $element->getComponent()->HTMLID;
    }
    $param = str_replace('*', '<span class="text-danger">*</span>', $param);
        $element->setPreTag('<div class="control-group">
<div class="row mb-3"><div class="'. $size[0] .' text-md-end text-xs-start my-auto">
        <label class="form-label" for="'. $id .'">&nbsp;'. $param.'</label>
    </div><div class="'. $size[1] .'"><div class="controls">' . $element->pretag);
$element->setPostTag($element->posttag . '</div> 
    </div></div>
</div>');
    }
}); 

SphpCodeBlock::addCodeBlock('aos',function($element,$args,$lstOther_CB){
    // not work in ajax mode
    addFileLink(SphpBase::sphp_settings()->comp_uikit_res_path . '/assets/aos.css',true);
    addFileLink(SphpBase::sphp_settings()->comp_uikit_res_path . '/assets/aos.js',true);
    addHeaderJSCode('aos', 'AOS.init();',true);
    if(isset($args[0])){
        $element->setAttribute("data-aos",$args[0]);
    }else{
        $element->setAttribute("data-aos","fade-up");        
    }
    if(isset($args[1])){
        $element->setAttribute("data-aos-delay",$args[1]);
    }
}); 

SphpCodeBlock::addCodeBlock('counter',function($element,$args,$lstOther_CB){
    // precounter https://github.com/srexi/purecounterjs
    if(! $element->hasAttribute("sphp-cb-aos")){
        $cb1 = SphpCodeBlock::getCodeBlock("aos");
        $cb1["callback"]($element,[],$lstOther_CB);
    }
    addHeaderJSCode('purecounter', '  var prcounter = new PureCounter();',true);
    $spn1 = '<span class="purecounter" data-purecounter-start="';
    if($element->hasAttribute("data-purecounter-start")){
        $spn1 .= $element->getAttribute("data-purecounter-start") . '"';
    }else{
        $spn1 .= '0"';
    }
    if(isset($args[0])){
        $spn1 .= ' data-purecounter-end="' . $args[0] .'"';
    }else{
        $spn1 .= ' data-purecounter-end="250"';
    }
    if(isset($args[1])){
        $spn1 .= ' data-purecounter-duration="' . $args[1] .'"';
    }else{
        $spn1 .= ' data-purecounter-end="1"';
    }
    $spn1 .= '></span>';
    $element->setInnerHTML($spn1);
    $element->tagName = "div";
}); 
/**
 * arg:- 0-> bounce,fold,puff,pulsate,shake,size,slide
 * arg: 1-> JS Event to Trigger default mouseenter
 * arg: 2-> extra options for effect as {} array
 * arg 3-> timer1 in ms
 * arg 4-> timer2 in ms
 * More:- https://api.jqueryui.com/category/effects/
 */
SphpCodeBlock::addCodeBlock('jui',function($element,$args,$lstOther_CB){
    $evt1 = "click";
    $effect1 = "shake";
    $opt1 = "{}";
    $timer1 = 2000;
    $timer2 = 1000;
    SphpBase::JQuery()->getJQKit();
    if(isset($args[0])) $effect1 = $args[0];
    if(isset($args[1])) $evt1 = $args[1];
    if(isset($args[2])) $opt1 = $args[2];
    if(isset($args[3])) $timer1 = $args[3];
    if(isset($args[4])) $timer2 = $args[4];
 
    $element->appendAttribute("class"," $effect1");
    addHeaderJSFunctionCode('ready', "jui" . $effect1, ' $(".'. $effect1 .'").on("'. $evt1 .'",function(){$(this).toggle("'. $effect1 .'",'. $opt1.','. $timer1 .',function(){$(this).toggle("'. $effect1 .'",{},'. $timer2.');});});');
    
}); 
/**
 * arg0:- color1 in hex code like #FFFFFF or rgb like 238,174,202
 * arg1:- color2 in hex code or rgb
 * arg2:- radial or linear 
 * arg3:- 90deg or circle or any 
 */
SphpCodeBlock::addCodeBlock('bggrad',function($element,$args,$lstOther_CB){
    $color1 = "238,174,202";
    $color2 = "148,187,233";
    $type1 = "radial";
    $deg1 = "circle";
    if(isset($args[0])){
        $r = $g = $b = 235;
        if($args[0][0] == '#'){
            list($r, $g, $b) = sscanf($args[0], "#%02x%02x%02x");
        }else{
            list($r,$g,$b) = explode(',', $args[0]);
        }
        $color1 = "$r,$g,$b";
        $r += intval($r * 0.25);
        $g += intval($g * 0.25);
        $b += intval($b * 0.25);
        if($r>255) $r = 255 - ($r - 255);
        if($g>255) $g =255 - ($g - 255);
        if($b>255) $b = 255 - ($b - 255);
        $color2 = "$r,$g,$b";
    }
    if(isset($args[1])){
        $r = $g = $b = 235;
        if($args[1][0] == '#'){
            list($r, $g, $b) = sscanf($args[1], "#%02x%02x%02x");
        }else{
            list($r,$g,$b) = explode(',', $args[1]);
        }
        $color2 = "$r,$g,$b";
    }
    if(isset($args[2])) $type1 = $args[2];
    if(isset($args[3])){
        $deg1 = $args[3];
    }else if($type1 == "linear"){
        $deg1 = "90deg";
    }else{
        $deg1 = "circle";
    }
    $bg1 = "background: rgb($color1);background: $type1-gradient($deg1, rgba($color1,1) 0%, rgba($color2,1) 100%);";
    $element->appendAttribute("style"," $bg1");
}); 

include_once(PROJ_PATH . "/masters/sphpcodeblock.php");
