<?php
include_once(SphpBase::sphp_settings()->slib_path ."/apps/permis/PermisGate.php");

class mebProfilePermission extends PermisGate {

    public function onstart() {
        global $mebmasterf;
        $this->getAuthenticate("ADMIN,MEMBER");
        $this->page->getAuthenticatePerm("view");
        $this->setTableName("profile_permission");
        //$this->Client->session("appName", "Profile Permission");
        $this->genFormFront = new FrontFile($this->mypath . "/fronts/mebProfilePermission-edit.front");
        $this->showallFront = new FrontFile($this->mypath . "/fronts/mebProfilePermission-list.front");
         
        $this->defWhere = " WHERE profile_permission.parentid = '". $this->Client->session('parentid') ."' ORDER BY profile_permission.id ASC ";
        $this->showallFront->getComponent('showall')->fu_setWhere($this->defWhere);
        
        $this->genFormFront->addMetaData('pageName','Profile Form');
        $this->showallFront->addMetaData('pageName','Manage Profiles');
        $this->setMasterFile($mebmasterf);
    }
    
    public function page_new(){
        $this->setFrontFile($this->showallFront);
    }       
    
    public function page_insert() {
        $this->extra[]['sid'] = $this->Client->session('sid');
        $permission_id = implode(",", $this->Client->request('permissionlist'));
        $this->extra[]['status'] = '0';
        $this->extra[]['permission_id'] = $permission_id;
        parent::page_insert();
    } 
    
    public function page_update() {
        $permission_id = implode(",", $_REQUEST['permissionlist']);
        $this->extra[]['permission_id'] = $permission_id;
        parent::page_update();
    } 
            
    public function showApplicationList() {
        $list = '';
        $list .= '<ul style="list-style: none;">';
        $appName = '';
        $no = 1;
        
        $eventParam = $this->page->getEventParameter();
        $ar1 = array();
        if($eventParam != '') {
            $result1 = $this->dbEngine->executeQueryQuick("SELECT * FROM profile_permission WHERE id = '$eventParam' ");
            if($this->dbEngine->is_rows($result1)) {
                $row =  $this->dbEngine->row_fetch_assoc($result1);
                $ar2 = explode(",", $row["permission_id"]);
                foreach ($ar2 as $key => $value2) {
                    $ar1[$value2] = true;
                }
            }
        }
       /* 
        foreach(SphpBase::sphp_api()->getRegisteredApps() as $key => $armain) { 
            if($armain[3] !== null){
            foreach($armain[3] as $key2 => $permission) {
                if(is_array($permission)){
                    $a1[$key . "-" . $permission[0]] = true;
                }else{
                    $a1[$key . "-" . $permission] = true;                        
                }
            }
            }
        }
*/
        $permission = array();
        $lih = "";
        $lih2 = "";
        foreach(SphpBase::sphp_api()->getRegisteredApps() as $key => $armain) {
            $lih = "";
            $lih2 = "";
            if($armain[3] !== null){
                $lih = '<li>'
                        . '<label style="font-weight: bold;">'.$armain[2].'</label>'
                    . '</li>';
            foreach($armain[3] as $key2 => $permission2) {        
                if(is_array($permission2)){
                    if(count($permission2)>1){
                        $permission = $permission2;
                    }else{
                        $permission[1] = $permission2[0];
                    }
                }else{
                    $permission[0] = $permission2;
                    $permission[1] = $permission2;
                }
                    $id = $key . "-" . $permission[0];
                // permission will not show if login user don't have
                if(SphpBase::sphp_permissions()->hasPermission($id)){
                $cls = '';
                    //$cls = '';
                    if(isset($ar1[$id])) {
                        $cls = 'checked=""';
                    }


                $lih2 .= '<li>'
                            . '<span style="padding-left: 20px;">&nbsp;</span>'
                            . '<input '.$cls.' name="permissionlist[]" id="'.$no.'" value="'.$id.'" type="checkbox">'
                            . '<label for='.$no.' style="padding-left: 5px;">'.$permission[1].'</label>'
                        . '</li>';
                $no++;
            }
            
            } // for
            // extend list
            if($lih2 != "") $list .= $lih . $lih2;
        } // if perm found
        
        }
        $list .= '</ul>';
                          
        return $list;
        
    }         
}

