<?php

class autocomp extends Sphp\tools\BasicApp{
    public $atype = "";
    public $aid = "";
    public $lblid = "";
    public $akey = "";
    public $apath = "";
    public $atext = "";
    public $afile = "";
    public $arow = 0;
    public $statement =  "";
    public $operator =  "";
    public $infunpara =  "";


    public function onstart() {
        if($this->Client->request("autocompkey") !== "FD45A279GH"){
            //exit();
        }
    }
    public function page_event_genautocompl($param) {
        //$b1 = new  Sphp\kit\Eventer();
        $this->getList(new SphpBase());
        $this->getList( new  Sphp\kit\Eventer());
        
        $this->getList(new Sphp\tools\BasicApp());
        //$this->getList($this);
        //$this->getList($this->JQuery);
        
        $this->getList($this->JSServer);
        $this->getList($this->Client);
        $this->getList($this->page);
        $this->getList(SphpBase::sphp_api());
        $this->getList(SphpBase::sphp_response());
        $this->getList(SphpBase::sphp_permissions());
        $this->getList(SphpBase::dbEngine());
        $this->getList(SphpBase::debug());
        $this->getList(SphpBase::sphp_router());
        $this->getList(SphpBase::sphp_session());
        $this->getList(SphpBase::sphp_settings());
        //$this->getList(SphpBase::);
        
    }
    public function page_event_global($param) {
        $v1 = $this->getListGlobal();
        $v2 = array();
        $v2["objtype"] = "nop";
        $v2["list"] = $v1;
        //print_r($v1);
        $this->JSServer->addJSONReturnBlock($v2);            
        //$this->debug->printAll();
    }
    public function page_event_test($param) {
        global $xyzo;
        //$this->loadRequest();
        $vo1 = $this->convertThis();
        //$v1 = $this->getListLive($vo1);
        if(is_object($vo1)){
            $v1 = $this->getListLive($vo1);
        }
        //print_r($xyzo);
        print_r($v1);
        $this->debug->printAll();
    }
    public function page_event_autocomp($param) {
        $this->loadRequest();
        //$v1 = array();
        $len1 = strlen($this->statement);
        if($len1 > 2){
            $ope = substr($this->statement,$len1-2);
            if($ope == "->" || $ope == "::"){
                $this->statement = substr($this->statement,0,$len1-2);
            }
            
            $s = $this->findObjType($this->statement);
            if(is_object($s)){
                $v1 = $this->getListLive($s);
                $this->JSServer->addJSONReturnBlock($v1);
            }else{
                $v2 = array();
                $v2["objtype"] = "error";
                $v2["list"] = $this->statement . " Object not found";
                $this->JSServer->addJSONReturnBlock($v2);            
                
            }         
        }else{
            $v1 = array();
            $v2 = array();
            $v1["static"] = array();
            $v1["member"] = array();
            $v2["objtype"] = "null";
            $v2["list"] = $v1;
            $this->JSServer->addJSONReturnBlock($v2);            
        }
        //$v1["SphpBase"] = array("int SphpBase(int number)","help1");
        //$v1["SphpBase2"] = array("int SphpBase(int number)","help2");
        //print_r($v1);
        //$this->debug->printAll();
    }

    private function findObjType($statement) {
        
    }
    private function findObjType_work($statement) {
        global $xyzo;
        if($this->atype == "app" || $this->atype == "php"){
            $v = $this->convertThis();
            $resvar = null;
            if(is_object($xyzo) && !is_array($xyzo)){
                $rcls1 = new \ReflectionClass($xyzo);
                $method = \SphpBase::sphp_api()->rtClassMethodFromFileLine($rcls1,$this->arow);
                if($method !== null){
                    $resvar =  \SphpBase::sphp_api()->rtClassMethodInvoke($method,$xyzo,null);
                    if($resvar !== null){
                        $v2 = array_keys($resvar);
                        foreach ($v2 as $key => $value) { 
                            \SphpBase::sphp_api()->setGlobal($value,$resvar[$value]);
                        }
                    }
                }
            }else if(is_array($xyzo)){
                $v2 = array_keys($xyzo); 
                foreach ($v2 as $key => $value) { 
                    \SphpBase::sphp_api()->setGlobal($value,$xyzo[$value]);
                }
            }
        }
        $statement = str_replace('$this', '$xyzo', $statement);
        $statement = str_replace("::", ",::,", $statement);
        $statement = str_replace("->", ",->,", $statement);
        //echo $statement;
        $stra1 = explode(",", $statement);
        $st1 = array();
        
        for($c =0; $c < count($stra1); $c++) {
            if($stra1[$c] == "::"){
                $st1[] = array($stra1[$c - 1],"::",substr($stra1[$c + 1],1));
            }else if($stra1[$c] == "->"){
                $st1[] = array($stra1[$c - 1],"->",$stra1[$c + 1]);
            }
        }
        $objvar = null;
        foreach ($st1 as $key => $value) {
            $obj = $value[0];
            $ope = $value[1];
            $prop = $value[2];
            if(strpos($obj, '$')!== false){
                $obj = \SphpBase::sphp_api()->getGlobal(substr($obj,1));
            }
            if($objvar !== null){
                $obj = $objvar;
            }
            if($ope == "::"){
                if(property_exists($obj,$prop)){
                    
                    $r = new ReflectionObject($obj);
                    $p = $r->getProperty($prop);
                    $p->setAccessible(true);
                    $objvar = $obj::${$prop};
                }else{
                    $objvar = null;
                    break;
                }
            }else if($ope == "->"){
                if(property_exists($obj,$prop)){ 
                    $r = new ReflectionObject($obj);
                    $p = $r->getProperty(str_replace('$',"",$prop));
                    $p->setAccessible(true);
                    $objvar = $obj->{$prop}; 
                }else{
                    $objvar = null;
                    break;
                }
            }
            
        }
        if(is_object($objvar)){
            return $objvar;
        }else if(count($st1) < 1){
            if($statement == '$xyzo'){
                return $xyzo;
            }else{
                return $this->findObjType3($statement);                
            }
        }
        return "error";
    }
    private function getAppClassName(){
        $filenpath = $this->apath . '/' . $this->atext;
        $apppatha = pathinfo($filenpath);
        $apppath = $apppatha["dirname"]."/";
        return $apppatha["filename"];        
    }
    private function getAppObject() {
        $filenpath = $this->apath . '/' . $this->atext;
        $apppatha = pathinfo($filenpath);
        $apppath = $apppatha["dirname"]."/";

        include_once($filenpath);
        $clsname = $apppatha["filename"];
        $mainclass = new $clsname();
        return $mainclass;

    }
    private function convertThisTest() {
        global $xyzo;
        //$filenpath = $this->apath . '/' . $this->atext;
        //$filenpath = str_replace(\SphpBase::sphp_settings()->server_path, "", $filenpath);
        $v1 = \SphpBase::sphp_api()->getRegisterAppClass("apps/index2.app",true);
        includeOnce($v1[1]);
        return new $v1[0];
        return null;
    }
    private function convertThis() {
        global $xyzo;
        $filenpath = $this->apath . '/' . $this->atext;
        //$filenpath = 'D:/www/demo/apps/index2.app';
        //$projpath = $this->Client->session("wproject");
        if($this->atype == "app"){
            writeAppPath($this->apath . '/');
            $v1 = \SphpBase::sphp_api()->getRegisterAppClass($filenpath,true);
        }else{
            $v1 = \SphpBase::sphp_api()->getRegisterAppClass($filenpath,false);            
        }
        $clsname = $v1[0];
        $objCreater = ' global $xyzo; if(class_exists("'. $clsname .'")){ $xyzo = new '. $clsname .'();} ';
        $projrootpath = $this->Client->session("wproject");
        if($projrootpath == ""){
            $projrootpath = \SphpBase::sphp_settings()->start_path;
        }
        $sta1 = '<?php chdir("'. $projrootpath . '"); ?>'; 
        // remove invalid
        $this->afile = str_replace("echo getHeaderHTML();", "", $this->afile);
        $this->afile = str_replace("print getHeaderHTML();", "", $this->afile);
        $this->afile = str_replace("echo getFooterHTML();", "", $this->afile);
        $this->afile = str_replace("print getFooterHTML();", "", $this->afile);
        $this->afile = str_replace('$dynData->render();', "", $this->afile);
        
        $flines = explode("\n", $sta1 . $this->afile . $objCreater);
        // find line in function or global code
        $funline = false;
        $block_count = 0;
        for($c=0; $c < $this->arow; $c++) {
            if(strpos($flines[$c], '{') !== false) $block_count += 1;
            if(strpos($flines[$c], '}') !== false) $block_count -= 1;
        }
        if($block_count > 0){
            $funline = true;
        }
        if($funline){
            $flines[$this->arow] = ' return get_defined_vars(); ';
        }else{
            $flines[$this->arow] = ' global $xyzo; $xyzo = get_defined_vars(); ';            
        }
        //file_put_contents("td2.txt",implode("\n",$flines));
        try{ 
            $v = "Output: " . executePHPCode(implode("\n",$flines),true);
        } catch (\Throwable $e) {
            $v = "Error: " . $e->getMessage();
        }catch(\Exception $e){
            $v = "Error: " . $e->getMessage();
        }
        return $v;
    }
    private function findObjType3($statement) {
        extract($GLOBALS, EXTR_REFS);
        if(strpos($statement, '$')!== false){
            $statement = substr($statement, 1);
        }
        if(isset($$statement)){
            // variable
            return $$statement;
        }else if(class_exists($statement)){
            return new $statement();
        }else{
            $v = executePHPCode("<?php if(gettype(" . $statement . ") == 'object'){" .
                ' echo get_class('. $statement .');}else{ echo "nop"; } ?>');
            if($v != "nop"){
                return new $v();
            }else{
                // variable
                return $$statement;
            }
            return "error";
        }
    }
    private function sendError($msg,$line){
        $data = array();
        $data["aid"] = $this->aid;
        $data["msg"] = $msg;
        $data["line"] = $line;
        $this->JSServer->callJsFunction("setErrorEditor",$data);
    }
    
    public function loadRequest() {
        $this->aid =  $this->Client->request('aid');
        $this->akey =  $this->Client->request('akey');
        $this->atext = $this->Client->request('atext');
        $this->apath = $this->Client->request('apath');
        $this->atype = $this->Client->request('atype');
        $this->afile = $this->Client->request('afile');
        $this->arow = intval($this->Client->request('arow'));
        $this->lblid =  $this->Client->request('lblid');
        $this->statement =  trim($this->Client->request('statement'));
        $this->operator =  $this->Client->request('operator');
        $this->infunpara =  $this->Client->request('infunpara');
        
        $filenpath = $this->apath . '/' . $this->atext;
        if($this->afile == "" && is_file($filenpath)){
            $this->afile = file_get_contents($filenpath);
        }
        
    }
    public function getListGlobal() {
        //extract($GLOBALS, EXTR_REFS);
        $xyz1 = get_declared_classes();
        $xyz2 = get_defined_constants(false);
        $xyz3 = get_defined_functions();
        $xyz4 = get_defined_vars();
        return \SphpBase::sphp_api()->rtScopeDefinedHelp($xyz1,$xyz2,$xyz3,$xyz4);
    }
    public function getListLive($clsobj) {
        //Instantiate the reflection object
        $reflector = new ReflectionClass($clsobj);
        $mainClass = get_class($clsobj);
        //$mainClass = $reflector->getName();
        $ar1 = array();
        $ar1["static"] = array();
        $ar1["member"] = array();
        $ar1["static"] = \SphpBase::sphp_api()->rtClassConstantHelp($mainClass,$reflector);
        \SphpBase::sphp_api()->rtClassPropertyHelp($mainClass,$clsobj,$reflector,$ar1);
        \SphpBase::sphp_api()->rtClassMethodHelp($mainClass,$reflector,$ar1);

        if (!isset($ar1["static"]))
            $ar1["static"] = array();
        if (!isset($ar1["member"]))
            $ar1["member"] = array();
        $mainClass2 = str_replace('\\', '\\\\', $mainClass);
        $arf = array();
        $arf["objtype"] = $mainClass2;
        $arf["list"] = $ar1;
        return $arf;
    }
    public function page_event_dbtvacdbtree1_dataroot($param) {
        //$this->sendJSONData(file_get_contents("{$this->myrespath}/dataroots.json"));
        $this->getTreeList();
    }
    public function page_event_dbtvacdbtree1_datachild($param) {
        //$this->sendJSONData(file_get_contents("{$this->myrespath}/datachildren.json"));
    
    }

    public function getTreeList() {
        $this->dbEngine->connect();
        $arrT = $this->genList(); 
        //$this->JSServer->sendData(json_encode($arrT));
        $this->dbEngine->disconnect();
        echo json_encode($arrT);
    }

    public function genList(){
        global $fileidcount;
        $arr = array();
        $arr1 = array();
        $arr3 = array();
        $arr2 = array();

        $folders = $this->dbEngine->getDbTables();
        if(count($folders)>0 && is_array($folders)){
        foreach ($folders as $key => $folder) { 
        $fileidcount = $fileidcount + 1;
        $arr1["id"] = "fold".$fileidcount;
        $arr1["text"] = $folder;
        $arr1["type"] = "folder";
        $arr1["apath"] = $folder;
        $arr1["icon"] = "fa fa-table";
        $arr2 = $this->genFieldList($folder);
        if(count($arr2)>0){
        $arr1["children"] = $arr2;
        }else if(isset($arr1["children"])){
            unset($arr1["children"]);
        }
        $arr[] = $arr1;
        }
    }


return $arr; 
//$str = "";
}
public function genFieldList($tableName) {
    global $fileidcount;
    $arr = array();
    $files = $this->dbEngine->getTableColumns($tableName);
    if(count($files)>0){
    foreach ($files as $key => $file) {
    $fileidcount = $fileidcount + 1;
    $arr3["id"] = "file".$fileidcount;
    $arr3["text"] = $file['Field'] . ' ' . $file['Type'] . ' ' . $file['Key'] . ' ' . $file['Extra'] . ' ' . $file['Default'];
    $arr3["type"] = "field";
    $arr3["apath"] = $file['Field'];
    $arr3["icon"] = "fa fa-columns";
    $arr[] = $arr3;
    }
    }
    return $arr; 

}

}
