<?php

class Seditor extends \Sphp\tools\BasicApp{
    private $tmp1 = null;
    
    
    public function onstart() {
        $this->setMasterFile(SphpBase::$sphp_settings->slib_path . "/temp/default/softmaster.php");
        SphpBase::$sphp_settings->disableEditing();
        $this->tmp1 = new TempFile($this->apppath . "/forms/seditor_form1.front",false,null,$this);
        
    }
    
    public function page_new() {
        //echo $this->apppath;
        //$this->setTempFile($this->tmp1);
        echo "nmm";
    }

    public function page_event_findtempf($param) {
        $tempfname = decrypt($this->Client->request("tempfname"),SphpBase::$sphp_settings->defenckey);
        $tempappname = decrypt($this->Client->request("tempappname"),SphpBase::$sphp_settings->defenckey);
        
        addHeaderJSFunctionCode("afterSaveFile", "fileopen3", ' window.opener.ProcessSphpCM("reload");',true);
        $afile = basename($tempfname);
        $dir1 = dirname($tempfname);
        $atype = pathinfo($tempfname,PATHINFO_EXTENSION);
        addHeaderJSFunctionCode("ready", "fileopen1", '    addTabWithoutTree("'. getEventPath("openfile") .'","a1","'.$afile .'","'. $dir1 .'","'. $atype .'"); ');
        $afile = basename($tempappname);
        $dir1 = dirname($tempappname);
        $atype = pathinfo($tempappname,PATHINFO_EXTENSION);
        addHeaderJSFunctionCode("ready", "fileopen2", '    addTabWithoutTree("'. getEventPath("openfile") .'","a2","'.$afile .'","'. $dir1 .'","'. $atype .'"); ');
        $this->setTempFile($this->tmp1);
        
        //$this->JSServer->addJSONJSBlock('');
        //$this->JSServer->addJSONReturnBlock($this->Client->session("wproject") . "/" . $tempfname);
    }
    
    public function page_event_findmasterf($param) {
        if($this->Client->request("tempfname") !== ""){
            $tempfname = decrypt($this->Client->request("tempfname"),SphpBase::$sphp_settings->defenckey);
            $tempappname = decrypt($this->Client->request("tempappname"),SphpBase::$sphp_settings->defenckey);
            $afile = basename($tempfname);
            $dir1 = dirname($tempfname);
            $atype = pathinfo($tempfname,PATHINFO_EXTENSION);
            addHeaderJSFunctionCode("ready", "fileopen1", '    addTabWithoutTree("'. getEventPath("openfile") .'","a1","'.$afile .'","'. $dir1 .'","'. $atype .'"); ');
            $this->setTempFile($this->tmp1);
            //$this->JSServer->addJSONJSBlock('');
            //$this->JSServer->addJSONReturnBlock($this->Client->session("wproject") . "/" . $tempfname);
        }else{
            //$this->JSServer->addJSONJSBlock(' console.log("Project is not running in editor mode"); ');
        }
    }
    
}
