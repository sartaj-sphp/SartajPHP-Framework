<?php
include_once(SphpBase::sphp_settings()->php_path . "/plugin/permis/apps/Universe.php");

class sale extends Universe {

    public $mainhome = null;
    public $showhome = null;

    public function onstart() {
        global $mebmasterf;
        $this->getAuthenticate("ADMIN,MEMBER");
        $this->setTableName("member");
        $this->mainhome = new FrontFile($this->apppath . "/fronts/mebProfile-edit.front", false, $this);
        $this->showhome = new FrontFile($this->apppath . "/fronts/mebProfile-list.front", false, $this);

        $this->showhome->getComponent('showall')->setPerPageRows(50);

        $this->defWhere = " WHERE member.parentid = '".$_SESSION['parentid']."' AND usertype = 'MEMBER' AND profile_permission.id = member.profile_id AND member.id != '".$_SESSION['sid']."' ORDER BY member.id DESC ";
        $this->showhome->getComponent('showall')->setWhere($this->defWhere);

        $this->setMasterFile($mebmasterf);
        parent::onstart();   
        
    }
    
    public function page_insert() {
        $profile_id = $this->Client->request('profile_id');
        $username = $this->Client->request('username');
        $email = $this->Client->request('email');
        $checkUserName = $this->checkUserName($username);
        $checkUserEmail = $this->checkUserEmail($email);
        if($checkUserEmail) {
            setErr('app1', 'This Email already exist!!');
            $this->setFrontFile($this->mainhome); 
        } elseif($checkUserName) {
            setErr('app1', 'This username already exist!!');
            $this->setFrontFile($this->mainhome); 
        } elseif($profile_id == 'Select Profile') {
            setErr('app1', 'Select Profile');
            $this->setFrontFile($this->mainhome);            
        } else {            
            $this->extra[]['varification'] = '1';
            $this->extra[]['usertype'] = 'MEMBER';
            parent::page_insert();
        }        
    }
}
