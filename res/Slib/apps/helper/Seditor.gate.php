<?php

class Seditor extends \Sphp\Tools\BasicGate{
    private $tmp1 = null;
    
    
    public function onstart() {
        $this->setMasterFile(SphpBase::sphpSettings()->slibPath . "/masters/default/softmaster.php");
        SphpBase::sphpSettings()->disableEditing();
        $this->tmp1 = new FrontFile($this->apppath . "/fronts/seditor_form1.front",false,null,$this);
        
    }
    
    public function page_new() {
        //echo $this->apppath;
        //$this->setFrontFile($this->tmp1);
        echo "nmm";
    }

    public function page_event_findtempf($param) {
        $tempfname = decrypt($this->client->request("tempfname"),SphpBase::sphpSettings()->defenceKey);
        $tempappname = decrypt($this->client->request("tempappname"),SphpBase::sphpSettings()->defenceKey);
        
        addHeaderJsFunctionCode("afterSaveFile", "fileopen3", ' window.opener.ProcessSphpCM("reload");',true);
        $afile = basename($tempfname);
        $dir1 = dirname($tempfname);
        $atype = pathinfo($tempfname,PATHINFO_EXTENSION);
        addHeaderJsFunctionCode("ready", "fileopen1", '    addTabWithoutTree("'. getEventUrl("openfile") .'","a1","'.$afile .'","'. $dir1 .'","'. $atype .'"); ');
        $afile = basename($tempappname);
        $dir1 = dirname($tempappname);
        $atype = pathinfo($tempappname,PATHINFO_EXTENSION);
        addHeaderJsFunctionCode("ready", "fileopen2", '    addTabWithoutTree("'. getEventUrl("openfile") .'","a2","'.$afile .'","'. $dir1 .'","'. $atype .'"); ');
        $this->setFrontFile($this->tmp1);
        
        //$this->jsServer->addJsonJsBlock('');
        //$this->jsServer->addJsonReturnBlock($this->client->session("wproject") . "/" . $tempfname);
    }
    
    public function page_event_findmasterf($param) {
        if($this->client->request("tempfname") !== ""){
            $tempfname = decrypt($this->client->request("tempfname"),SphpBase::sphpSettings()->defenceKey);
            $tempappname = decrypt($this->client->request("tempappname"),SphpBase::sphpSettings()->defenceKey);
            $afile = basename($tempfname);
            $dir1 = dirname($tempfname);
            $atype = pathinfo($tempfname,PATHINFO_EXTENSION);
            addHeaderJsFunctionCode("ready", "fileopen1", '    addTabWithoutTree("'. getEventUrl("openfile") .'","a1","'.$afile .'","'. $dir1 .'","'. $atype .'"); ');
            $this->setFrontFile($this->tmp1);
            //$this->jsServer->addJsonJsBlock('');
            //$this->jsServer->addJsonReturnBlock($this->client->session("wproject") . "/" . $tempfname);
        }else{
            //$this->jsServer->addJsonJsBlock(' console.log("Project is not running in editor mode"); ');
        }
    }
    
}
