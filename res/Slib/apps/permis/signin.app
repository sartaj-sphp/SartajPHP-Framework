<?php

class signin extends \Sphp\tools\BasicApp {

    private $signinvar = null;

    public function onstart() {
        global $masterf;
        //echo $this->page->getAuthenticateType();
        //$this->getAuthenticate("GUEST,MEMBER,ADMIN");
        //$this->page->getAuthenticatePerm("GUEST,ADMIN,MEMBER"); 
        $this->setTableName("member");
        $this->signinvar = new TempFile($this->apppath . "/forms/signin.front", false, $this);
        $this->setMasterFile($masterf);
    }

    public function page_new() {
        if(!$this->Client->isCookie("algdec")) {
            destSession();
            $this->setTempFile($this->signinvar);
        }else{
            $authcookie = json_decode(decrypt($this->Client->cookie("algdec2")),true);
            $this->Client->session('sid',intval($authcookie['sid']));            
            $this->Client->session('parentid',intval($authcookie['parentid'])); 
            $this->Client->session('admin-name',$authcookie['admin-name']);            
            $this->Client->session('email',$authcookie['email']);            
            $this->Client->session('usertype',$authcookie['usertype']);  
            $this->Client->session('profile_id',$authcookie['profile_id']);            
            $this->Client->session('lstpermis',$authcookie['lstpermis']);  
            if($authcookie['profile_id'] == 0){
                setSession('ADMIN', intval($authcookie['sid']));
            }else{
                setSession('MEMBER', intval($authcookie['sid']));                
            }
            getWelcome();
        }
    }

    public function page_submit() {
        global $cmpid,$admuser,$admpass;
        if(! getCheckErr()){
        $authcookie = array();
        $this->debug->println("Call Signin Event");
        $uname = $this->signinvar->getComponent("uname")->getValue();
        $pword = $this->signinvar->getComponent("pword")->getValue();

        if ($uname == $admuser && $pword == $admpass) {
            $this->Client->session('sid', '0');
            $this->Client->session('parentid', '0');
            
            $this->Client->session('admin-name', 'Super Admin');
            $this->Client->session('email', '');
            $this->Client->session('usertype', 'ADMIN');
            $this->Client->session('profile_id', '0');
            $this->Client->session('lstpermis', "");
            $authcookie['sid'] = '0';            
            $authcookie['parentid'] = '0';            
            $authcookie['admin-name'] = 'Super Admin';            
            $authcookie['email'] = '';            
            $authcookie['usertype'] = 'ADMIN';            
            $authcookie['profile_id'] = '0';            
            $authcookie['lstpermis'] = '';            
            $number_of_days = 10 ;
            $date_of_expiry = time() + 60 * 60 * 24 * $number_of_days ;
            if($this->Client->isRequest("chkremb")) {
                $this->Client->cookie("algdec", "dome1",false, $date_of_expiry );
                $this->Client->cookie("algdec2", encrypt(json_encode($authcookie)),false, $date_of_expiry );
            }
            setSession('ADMIN', 0);
            //print_r($_SESSION);
            getWelcome();
        } else {
            $result = $this->dbEngine->executeQueryQuick("SELECT member.id,member.parentid,fname,lname,email,usertype,profile_id,permission_id,member.spcmpid FROM member,profile_permission WHERE username = '$uname' AND password = '$pword' AND member.status = '1' AND profile_id=profile_permission.id ");
            $num = mysqli_num_rows($result);
            if ($num > 0) {
                $rows = mysqli_fetch_assoc($result);
                if (!getCheckErr()) {
                    $this->Client->session('sid', $rows['id']);

                    if ($rows['parentid'] == 0) {
                        $this->Client->session('parentid', $rows['id']);
                    } else {
                        $this->Client->session('parentid', $rows['parentid']);
                    }

                    $this->Client->session('admin-name', $rows['fname'] . " " . $rows['lname']);
                    $this->Client->session('email', $rows['email']);
                    $this->Client->session('usertype', $rows['usertype']);
                    $this->Client->session('profile_id', $rows['profile_id']);
                    $this->Client->session('lstpermis', $rows['permission_id']);
                    $this->Client->session('compid', $rows['spcmpid']);

                    //This is for permission management---------------------
                    //This is for permission management---------------------

                    $usertype = $rows['usertype'];
                    $authcookie['sid'] = $this->Client->session('sid');            
                    $authcookie['parentid'] = $this->Client->session('parentid'); 
                    $authcookie['admin-name'] = $this->Client->session('admin-name');            
                    $authcookie['email'] = $this->Client->session('email');            
                    $authcookie['usertype'] = $this->Client->session('usertype');  
                    $authcookie['profile_id'] = $this->Client->session('profile_id');            
                    $authcookie['lstpermis'] = $this->Client->session('lstpermis');            
                    $number_of_days = 10 ;
                    $date_of_expiry = time() + 60 * 60 * 24 * $number_of_days ;
                    
                    if($this->Client->isRequest("chkremb")) {
                        $this->Client->cookie("algdec", "dome1",false, $date_of_expiry );
                        $this->Client->cookie("algdec2", encrypt(json_encode($authcookie)),false, $date_of_expiry );
                    }
                    
                    setSession('MEMBER', $rows['id']);
                    getWelcome();
                } else {
                    setErr('app2', 'Invalid User or Password');
                    $this->setTempFile($this->signinvar);
                }
            } else {
                setErr('app2', 'Invalid Username or Password');
                $this->setTempFile($this->signinvar);
            }
        }
        } else {
                setErr('app2', 'Invalid Username or Password');
                $this->setTempFile($this->signinvar);
        }
    }

    public function page_event_logout($param) {
        $number_of_days = -1 ;
        $date_of_expiry = time() + 60 * 60 * 24 * $number_of_days ;
        $this->Client->cookie( "algdec", "dome1", false, $date_of_expiry );
        $this->Client->cookie("algdec2", "", false, $date_of_expiry );
        destSession();
        $this->page->forward("index.html");
    }

}
