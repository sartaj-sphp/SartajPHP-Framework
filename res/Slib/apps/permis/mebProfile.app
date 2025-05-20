<?php
include_once(__DIR__ ."/PermisApp.php");

class mebProfile extends PermisApp {

    public function onstart() {
        global $mebmasterf;
        $this->getAuthenticate("ADMIN,MEMBER");
        $this->page->getAuthenticatePerm("view");
        $this->setTableName("member");
        $this->genFormTemp = new TempFile($this->apppath . "/forms/mebProfile-edit.front", false, $this);
        $this->showallTemp = new TempFile($this->apppath . "/forms/mebProfile-list.front", false, $this);

        $this->showallTemp->getComponent('showall')->setPerPageRows(50);

        $this->defWhere = " WHERE member.parentid = '".$_SESSION['parentid']."' AND usertype = 'MEMBER' AND profile_permission.id = member.profile_id AND member.id != '".$_SESSION['sid']."' ORDER BY member.id DESC ";
        $this->showallTemp->getComponent('showall')->setWhere($this->defWhere);
        SphpBase::sphp_api()->addProp('page_title',"Manage Users");
        $this->setMasterFile($mebmasterf);
        
    }
    
    
    public function page_insert() {
        $profile_id = $this->Client->request('profile_id');
        $username = $this->Client->request('username');
        $email = $this->Client->request('email');
        //$checkUserName = $this->checkUserName($username);
        $checkUserEmail = $this->checkUserEmail($email);
        if($checkUserEmail) {
            setErr('app1', 'This Email already exist!!');
            $this->setTempFile($this->genFormTemp); 
       /* } elseif($checkUserName) {
            setErr('app1', 'This username already exist!!');
            $this->setTempFile($this->genFormTemp); 
        * 
        */
        } elseif($profile_id == 'Select Profile') {
            setErr('app1', 'Select Profile');
            $this->setTempFile($this->genFormTemp);            
        } else {            
            $this->extra[]['varification'] = '1';
            $this->extra[]['username'] = $email;
            $this->extra[]['usertype'] = 'MEMBER';
            parent::page_insert();
        }        
    }
}
