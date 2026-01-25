<?php
include_once(SphpBase::sphp_settings()->slib_path ."/apps/permis/PermisApp.php");

class mebProfile extends PermisApp {

    public function onstart() {
        global $mebmasterf;
        $this->getAuthenticate("ADMIN,MEMBER");
        $this->page->getAuthenticatePerm("view");
        $this->setTableName("member");
        $this->genFormFront = new FrontFile($this->mypath . "/forms/mebProfile-edit.front");
        $this->showallFront = new FrontFile($this->mypath . "/forms/mebProfile-list.front");

        $this->showallFront->getComponent('showall')->fu_setPerPageRows(50);

        $this->defWhere = " WHERE member.parentid = '". $this->Client->session('parentid') ."' AND usertype = 'MEMBER' AND profile_permission.id = member.profile_id AND member.id != '". $this->Client->session('sid') ."' ORDER BY member.id DESC ";
        $this->showallFront->getComponent('showall')->fu_setWhere($this->defWhere);
        // set Form Title
        $this->genFormFront->addMetaData('pageName','User Form');
        $this->showallFront->addMetaData('pageName','Manage Users');
        $this->setMasterFile($mebmasterf);
        
    }
    
    public function page_insert() {
        $profile_id = $this->Client->request('profile_id');
        $username = $this->Client->request('username');
        $email = $this->Client->request('email');
        //$checkUserName = $this->checkUserName($username);
        $checkUserEmail = $this->checkUserEmail($email);
        if($checkUserEmail) {
            setErr('App', 'This Email already exist!!');
            $this->setFrontFile($this->genFormFront); 
       /* } elseif($checkUserName) {
            setErr('App', 'This username already exist!!');
            $this->setFrontFile($this->genFormFront); 
        * 
        */
        } elseif($profile_id == 'Select Profile') {
            setErr('App', 'Select Profile');
            $this->setFrontFile($this->genFormFront);            
        } else {            
            $this->extra[]['varification'] = '1';
            $this->extra[]['username'] = $email;
            $this->extra[]['usertype'] = 'MEMBER';
            parent::page_insert();
        }        
    }
}
