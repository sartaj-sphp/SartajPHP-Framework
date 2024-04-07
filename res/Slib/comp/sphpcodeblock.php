<?php
final class SphpCodeBlock{
    private static $cb = array();
/**
 * Add Code Block for TempFile. use runcb="" and sphp-cb-blockName on tag
 * @param string $name Name of code block
 * @param type $callback function($element,$args,$lst1){}
 * @param type $css tag css classes
 * @param type $pclass parent tag css classes
 * @param type $pretag pre tag html
 * @param type $posttag post tag html
 * @param type $innerpretag tag start inner html
 * @param type $innerposttag tag end inner html
 * @return array
 */
public static function addCodeBlock($name,$callback=null,$css="",$pclass="",$pretag="",$posttag="",$innerpretag="",$innerposttag=""){
    // may be future version support js also
    $a1 = array("class"=>$css,"pclass"=>$pclass,"pretag"=>$pretag,"posttag"=>$posttag,"innerpretag"=>$innerpretag,"innerposttag"=>$innerposttag,"callback"=>$callback);
    SphpCodeBlock::$cb[$name] = $a1;
}
private static function genCodeBlock($callback=null,$css="",$pclass="",$pretag="",$posttag="",$innerpretag="",$innerposttag=""){
    // may be future version support js also
    $a1 = array("class"=>$css,"pclass"=>$pclass,"pretag"=>$pretag,"posttag"=>$posttag,"innerpretag"=>$innerpretag,"innerposttag"=>$innerposttag,"callback"=>$callback);
    return $a1;
}
public static function getCodeBlocks(){
    return SphpCodeBlock::$cb;
}
}

// start css blocks of temp file
SphpCodeBlock::addCodeBlock('btn-count',function($element,$args,$lst1){
        if(! isset($lst1['color'])){
            $element->appendAttribute('class',' btn-primary');
        }
    },'btn position-relative','','','','',
 '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary">+@arg0 <span class="visually-hidden">unread messages</span></span>'
); 
SphpCodeBlock::addCodeBlock('btn-marker',function($element,$args,$lst1){
        if(! isset($lst1['color'])){
            $element->appendAttribute('class',' btn-primary');
        }
    },'btn position-relative','','','','',
 '<svg width="1em" height="1em" viewBox="0 0 16 16" class="position-absolute top-100 start-50 translate-middle mt-1 bi bi-caret-down-fill" fill="#212529" xmlns="http://www.w3.org/2000/svg"><path d="M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/></svg>'
); 

// 2 args= width or style,color
SphpCodeBlock::addCodeBlock('border',function($element,$args,$lst1){
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
  
});

SphpCodeBlock::addCodeBlock('rounded',function($element,$args,$lst1){
    //rounded='' list:- 0 to 3, top,end,bootom,start,circle,pill
  if(isset($args[0])){
    $element->appendAttribute('class',' rounded-' . $args[0]);      
  }else{
    $element->appendAttribute('class',' rounded');      
  }
  
});

SphpCodeBlock::addCodeBlock('color',function($element,$args,$lst1){
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
});

SphpCodeBlock::addCodeBlock('position',function($element,$args,$lst1){
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
},'position-absolute','position-relative'); 

SphpCodeBlock::addCodeBlock('shadow',function($element,$args,$lst1){
    if(isset($args[0])){
        $ch = array(); $ch[1] = 'shadow-sm'; $ch[2] = 'shadow-lg';$ch[3] = 'shadow-none';
        $element->appendAttribute('class',' '. $ch[intval($args[0])]);  
    }else{
        $element->appendAttribute('class',' shadow');         
    }
}); 

SphpCodeBlock::addCodeBlock('size',function($element,$args,$lst1){
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

SphpCodeBlock::addCodeBlock('overflow',function($element,$args,$lst1){
    if(isset($args[0])){
        $ch = array(); $ch[1] = 'overflow-scroll'; $ch[2] = 'overflow-hidden';$ch[3] = 'overflow-visible';
        $element->appendAttribute('class',' '. $ch[intval($args[0])]);  
    }else{
        $element->appendAttribute('class',' overflow-auto');         
    }
}); 
SphpCodeBlock::addCodeBlock('text',function($element,$args,$lst1){
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
SphpCodeBlock::addCodeBlock('card',function($element,$args,$lst1){
        $str1 = '';
        $str3 = '';
        if(! $element->getParent()->hasAttributeValue("class","card")){
            $str1 .= '<div class="card">';
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
},'card-body'); 

SphpCodeBlock::addCodeBlock('label',function($element,$args,$lst1){
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

include_once(PROJ_PATH . "/temp/sphpcodeblock.php");
