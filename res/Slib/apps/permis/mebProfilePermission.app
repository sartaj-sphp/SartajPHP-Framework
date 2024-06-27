<?php
include_once(__DIR__ ."/PermisApp.php");

class mebProfilePermission extends PermisApp {

    public function onstart() {
        global $mebmasterf;
        $this->page->getAuthenticatePerm("view");
        $this->setTableName("profile_permission");
        $this->Client->session("appName", "Profile Permission");
        $this->genFormTemp = new TempFile($this->apppath . "/forms/mebProfilePermission-edit.front", false, $this);
        $this->showallTemp = new TempFile($this->apppath . "/forms/mebProfilePermission-list.front", false, $this);
         
        $this->defWhere = " WHERE profile_permission.parentid = '".$_SESSION['parentid']."' ORDER BY profile_permission.id ASC ";
        $this->showallTemp->getComponent('showall')->setWhere($this->defWhere);

        $this->setMasterFile($mebmasterf);
        parent::onstart();
    }
    
    public function page_new(){
        $this->setTempFile($this->showallTemp);
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
            $num1 = mysqli_num_rows($result1);
            if($num1 > 0) {
                $row = mysqli_fetch_assoc($result1);
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

