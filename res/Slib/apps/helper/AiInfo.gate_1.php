<?php
/**
 * This Gate is helping Gate for AI Model.
 *  call with command line
 *  php -f start.php -- --gate aiinfo
 */
class AiInfo extends \Sphp\tools\BasicGate{
    
    public function onstart(){
        // only work on command line
        if ($this->Client->mode != "CLI"){
            echo "This Gate can't Call on Web";
            SphpBase::engine()->exitMe();
        }
        
    }
   /**
    * Send Intro of SartajPHP Framework in MD Document Format
    */
    public function page_new(){
        // Disable default Front File to Send in Basic Gate
        $this->showNotFrontFile();
        $this->sendToAiModel(file_get_contents($this->mypath . "/aidocs/intro.md"));
    }
    /**
     * Command line:- php -f start.php -- --gate aiinfo --evt lastten --evtp user
     * Send Last 10 Rows of Database Table name pass as $evtp 
     * of project which Database is setting up in comp.php file.
     * @param string $evtp Table Name 
     */
    public function page_event_lastten($evtp) {
        /** get last 10 rows */
        $result = $this->dbEngine->executeQueryQuick("SELECT * FROM $evtp ORDER BY id DESC LIMIT 10");
        if($this->dbEngine->is_rows($result)){
            $strrows = fopen('php://temp', 'r+');
           while($row = $this->dbEngine->row_fetch_assoc($result)){
               fputcsv($strrows, $row);
           } 
           rewind($strrows);
           $csvString = stream_get_contents($strrows);
           fclose($strrows);
           $this->sendToAiModel($csvString);
           return;
        }
        
        if (getCheckErr()){
            $this->sendError();
        }else{
           $this->sendToAiModel("No Record");                        
        }
    } 
    /**
     * Get List of Tables in Database
     * @param string $evtp not used
     */
    public function page_event_table_list($evtp) {
        $this->dbEngine->connect();
        $arrT = $this->genList(); 
        $this->dbEngine->disconnect();
        $this->sendToAiModel(json_encode($arrT), "json");
    }
   /**
    *  List All code Blocks Available for Project.
    * Code Blocks use in Front File for design the Tag
    *  Example:- Wrap p tag with bootstrap Card design:- <p sphp-cb-card="Title">This is a Para will be wrap in card layout in Browser</p> 
    * @param type $evtp not used
    */
    public function page_event_codeblocks_list($evtp) {
        include_once(\SphpBase::sphp_settings()->comp_uikit_path . "/sphpcodeblock.php");
            $sphpcodeblocks = \SphpCodeBlock::getCodeBlocks();
            if($sphpcodeblocks && count($sphpcodeblocks) > 0){
                $str1 = json_encode($sphpcodeblocks);
            }else{
                $str1 = '{}';
            }
            $this->sendToAiModel($str1, "json");
    }
    
   /**
    * Return List of Component Fusion methods
    *  Use:- php -f start.php -- --gate aiinfo --evt component_prop_list --evtp "txtname,<input id='txtname' type='text' runat='server' >"
    * @param string $evtp component tag id, tag
    */
    public function page_event_component_prop_list($evtp) {
        $arrcompcode = explode(",",$evtp);
        $tagid = $arrcompcode[0];
        $compcode = $arrcompcode[1];
        $tmp1 = new FrontFile($compcode,true);
        $comp1 = $tmp1->getComponentSafe($tagid);
        if($comp1 !== null){
            $arr = array();
            $arr['comp#' . $comp1->cfilename] = [array('comp' => ''),array($comp1->mypath => '', $comp1->getName() => '')];
            /*
            $files = $comp1->helpPropList();
            if(count($files)>0){
                foreach ($files as $key => $file) {
                    $arr[$key] = [array($key => ''),array($file[0] => '', $file[4] => '')];
                }
            }
            */
            $class_info = new \ReflectionClass($comp1);
            $mainClass = get_class($class_info);
            $sphp_api = \SphpBase::sphp_api();
            $ar = array();
            //$ar = $sphp_api->rtClassMethod($class_info);
            //$sphp_api()->rtClassMethodHelp($mainClass,$class_info,$ar);
            $methods = $class_info->getMethods(\ReflectionMethod::IS_PUBLIC | \ReflectionMethod::IS_ABSTRACT | \ReflectionMethod::IS_FINAL);
            //$methods = $reflector->getMethods(\ReflectionMethod::IS_PUBLIC);
            $banmethods = array('__construct', '__destruct', '__call', '__callStatic', 
            '__get', '__set', '__isset', '__unset', '__sleep', '__wakeup', '__toString',
             '__invoke', '__set_state', '__clone', '__debugInfo','onrender','onprerender',
             'render','prerender','loadScript','parseHTML',
            'onjsrender','onprejsrender','oncreate','oncompcreate','oninit','oncompinit',
            'executePHPCode','getDynamicContent','addDynamicFileLink','onaftercreate',
            'onappevent','renderLast','onchildevent','onholder','onparse','setClassPath',
            'init','helpPropList','setVersion','getVersion','setMinVersionSphp','getMinVersionSphp',
        'setMaxVersionSphp','getMaxVersionSphp','setMinVersionPHP','getMinVersionPHP',
        'setMaxVersionPHP','getMaxVersionPHP');
        $banmethodsa = array();
        //foreach ($banmethods as $key => $v1) {
         //    $banmethodsa[$v1] = '';
        //}
            foreach ($methods as $key2 => $method) {
				$methin = substr($method->getName(),0,3);
                if($methin == "fu_" || $methin == "fi_"){
                $strParam = $sphp_api->rtMethodParm($method);
                $ar[$method->getName()] = array('(' . $strParam[1] . ')', "Method " . $mainClass, "", $method->getName() . '($0' . $strParam[0] . ')', "Method");
                //break;
				}
            }

            foreach ($ar as $key => $val2) {
                $name = $key ;
                $arr[$name] = [array($name => ''),array($val2[4] => '', $val2[0] => '')];
            } 

            $this->sendToAiModel(json_encode($arr),"json");
        }else{
            $this->sendToAiModel("{}","json");
        }

    }
    
    /**
     *  Generate CRUD App for Database with AJAX
     * Generate Gate and Front Files from Database Table fields.
     * @param string $dbtable Database Table Name from which is use for generate Forms.
     */
    public function page_event_generateApp($dbtable) {
        $this->dbEngine->connect();
        include_once(__DIR__ . "/GenAppFromDb.php");
        $dbf = new GenAppFromDb($this->dbEngine);
        $aname = $dbtable;
        $gate = strtolower($aname);
        $atype = 'type';
        $filebase = PROJ_PATH . "/apps/";
        $editfile = "{$filebase}fronts/{$gate}-edit.front";
        $listfile = "{$filebase}fronts/{$gate}-list.front";
        $appfile = "{$filebase}". ucfirst($gate) .".app";
        $all = 0;
        if($atype == "Edit Form"){
            $all = 1;
        }else if($atype == "Both Form"){
            $all = 2;
        }else{
            $all = 3;
        }
        $str = "";
        if($all > 0){
            $str .= '##FILE Edit Front File Content Start##';
            $str .= $dbf->getEditForm("$aname",$gate);
            $str .= '##FILE Edit Front File Content End##';
        }
        if($all > 1){
            $str .= '##FILE List Front File Content Start##';
            $str .= $dbf->getShowForm("$aname",$gate);
            $str .= '##FILE List Front File Content End##';
        }
        if($all > 2){
            $str .= '##FILE Gate File Content Start##';
            $str .= $dbf->getGate("$aname",$gate);
            $str .= '##FILE Gate File Content End##';
        }
        
        $this->dbEngine->disconnect();
        $this->sendToAiModel($str);
    }

    
    private function genList(){
        $arr = array();
        $arr2 = array();
        
        $folders = $this->dbEngine->getDbTables(); 
        if(count($folders)>0 && is_array($folders)){
            foreach ($folders as $key => $folder) {
                $arr2 = $this->genFieldList($folder);
                if(count($arr2)>0){
                    $arr[$folder] = [array($folder=>''),$arr2];
                }else{
                    $arr[$folder] = array($folder=>'');
                }
            }
        }
        
        
        return $arr; 
        //$str = "";
        }
        private function genFieldList($tableName) {
            $arr = array();
            $files = $this->dbEngine->getTableColumns($tableName);
        if(count($files)>0){
            foreach ($files as $key => $file) {
                $arr[$file['Field']] = $file;
                //$arr3["text"] = $file['Field'] . ' ' . $file['Type'] . ' ' . $file['Key'] . ' ' . $file['Extra'] . ' ' . $file['Default'];
            }
        }
        return $arr; 
        
        }
    
    private function sendToAiModel($answer,$type="md"){
        $arrjson = array();
        $arrjson["id"] = time();
        $arrjson["data_type"] = $type;
        $arrjson["answer"] = $answer;
        echo json_encode($arrjson);
    }
    private function sendError(){
        $this->sendToAiModel("Error In Project, So couldn't help");
    }
}
