<?php
include_once(SphpBase::sphpSettings()->resourcePath . "/classes/bundle/email/SMTPMail.php");

class emailer extends \Sphp\Tools\Component{
    private $tempcomp = null;
    
    public function onchildevent($event,$obj){
        if($event == "oncreate"){
            // set child control for future process onafterprocess
            $this->tempcomp = $obj;
        }
    }
    // because onholder run on render and we want send email on temp ready
    public function onaftercreate(){
        global $mailUser,$cmpEmail,$cmpName;
        if($this->blnSubmit && !getCheckErr() && $this->tempcomp != null){
                $str1 = $this->handleHolder($this->tempcomp);
                $subject = $this->tempcomp->Subject == '' ? 'Query': $this->tempcomp->Subject;
                $toemail = $this->tempcomp->ToEmail == '' ? $cmpEmail: $this->tempcomp->ToEmail;
                $toname = $this->tempcomp->ToName == '' ? 'itkruze.com': $this->tempcomp->ToName;
                
                $mail = new SMTPMail();
                $mail->setFrom("$cmpName", $mailUser);
                $r1 = $mail->sendMail($subject,$toemail, $toname, $str1);
                if(!$r1){
                    setErr("app1","Couldn't send email");
                }
             
        }
        
    }
    
    // disable runas=holder in favour of set data on comp is easy in TinyMCE
    public function onaftercreate_disable(){
        global $mailUser,$cmpEmail,$cmpName;
        if($this->blnSubmit && !getCheckErr()){
            // first find holder tag and read inner html
            $str1 =  $this->parseElement($this->element->children);   
            //SphpBase::debug()->println($str1);
            //echo $str1;
            include_once(SphpBase::sphpSettings()->resourcePath . "/classes/base/email/mail/SMTPMail.php");
            $mail = new SMTPMail();
            $mail->setFrom("$cmpName", $mailUser);
            $r1 = $mail->sendMail('Query',$cmpEmail, 'itkruze.com', $str1);
            if(!$r1){
                setErr("app1","Couldn't send email");
            }
        }
        
    }
    //no use
    private function parseElement($elements){
        $str1 = "";
        foreach($elements as $key=>$tag){            
            if($tag->hasChildren()){
                $str1 = $this->parseElement($tag->children);
            }
            //skip text element 
            if($tag->type == "element" && $tag->getAttribute("runas") == "holder"){
                // process only one single holder
                $str1 = $this->handleHolder($tag);
            }
        }
        return $str1;
    }
   
    private function handleHolder($element){
        $str2 = $element->getInnerHtml();
        foreach($_REQUEST as $key=>$val){
            if(isset($this->frontobj->comp_list[$key])){
                $str2 = str_replace('$'. $key,$this->frontobj->comp_list[$key]->getValue(),$str2);
            }
        }
        return $str2;
    }
    
    public function onrender(){
        // replace html
        $this->fu_unsetRenderTag();
        $this->setInnerHtml('<input type="hidden" name="'. $this->name .'" value="l" />');
    }
    
}
