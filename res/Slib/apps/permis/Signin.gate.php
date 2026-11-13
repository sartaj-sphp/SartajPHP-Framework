<?php
// read if settings in comp.php file
global $google_oauth_client_id,$googleOauthclientSecret,$google_oauth_redirect_uri,$google_oauth_version;

// set redirect URL for google to Event "gauthr" of this App (Current Registered App) 
$google_oauth_redirect_uri = getEventUrl("gauthr"); 
$google_oauth_version = 'v3';

class Signin extends \Sphp\Tools\BasicGate {

    protected $signinvar = null;
    protected $extra = array();

    public function onstart() {
        //echo $this->page->getAuthenticateType();
        //$this->getAuthenticate("GUEST,MEMBER,ADMIN");
        //$this->page->getAuthenticatePerm("GUEST,ADMIN,MEMBER"); 
        $this->setTableName("member");
        $this->signinvar = new FrontFile("login");
        // comp.php setting about default master file for Guest User
        $this->setMasterFile(readGlobal('masterf')); 
    }

    public function page_new() {
        if($this->client->cookie("algdec") != "dome1") {
            // delete all authentication related session variables
            destSession();
            // send login form to browser
            $this->setFrontFile($this->signinvar);
        }else{
            // restore login from cookie if exist and valid
            $authcookie = json_decode(decryptme($this->client->cookie("algdec2"),'ab7291df5v4d'),true);
            $this->client->session('sid',intval($authcookie['sid']));            
            $this->client->session('parentid',intval($authcookie['parentid'])); 
            $this->client->session('admin-name',$authcookie['admin-name']);            
            $this->client->session('email',$authcookie['email']);            
            $this->client->session('usertype',$authcookie['usertype']);  
            $this->client->session('profile_id',$authcookie['profile_id']);            
            $this->client->session('lstpermis',$authcookie['lstpermis']);  
            if($authcookie['profile_id'] == 0){
                setSession('ADMIN', intval($authcookie['sid']));
            }else{
                setSession('MEMBER', intval($authcookie['sid']));                
            }
            // call function in comp.php project settings file
            getWelcome();
        }
    }

    /**
     * Handler of PageEvent Submit
     * login or signin form submission handle here
     *  comp.php settings
     * @global string $cmpId
     * @global string $adminUser
     * @global string $adminPass
     */
    public function page_submit() {
        global $cmpId,$adminUser,$adminPass;
        if(! getCheckErr()){
        $authcookie = array();
       // print_r($_REQUEST); 
        //$this->debug->println("Call Signin Event");
        $uname = $this->signinvar->getComponent("uname")->getValue();
        $pword = $this->signinvar->getComponent("pword")->getValue();
        //$this->debug->println('user ' . $uname . ' = ' . $adminUser);
        if ($uname == $adminUser && $pword == $adminPass) {
            $this->client->session('sid', '0');
            $this->client->session('parentid', '0');
            
            $this->client->session('admin-name', 'Super Admin');
            $this->client->session('email', '');
            $this->client->session('usertype', 'ADMIN');
            $this->client->session('profile_id', '0');
            $this->client->session('lstpermis', "");
            $authcookie['sid'] = '0';            
            $authcookie['parentid'] = '0';            
            $authcookie['admin-name'] = 'Super Admin';            
            $authcookie['email'] = '';            
            $authcookie['usertype'] = 'ADMIN';            
            $authcookie['profile_id'] = '0';            
            $authcookie['lstpermis'] = '';            
            $number_of_days = 10 ;
            $date_of_expiry = time() + 60 * 60 * 24 * $number_of_days ;
            if($this->client->isRequest("chkremb")) {
                $this->client->cookie("algdec", "dome1",false, $date_of_expiry );
                $this->client->cookie("algdec2", encryptme(json_encode($authcookie),'ab7291df5v4d'),false, $date_of_expiry );
            }
            setSession('ADMIN', 0);
            // enable session on sphp app mode
            if(SphpBase::sphpSettings()->useSession && SphpBase::sphpRequest()->isNativeApp()){
                // Generate a unique session id
                $sid = session_create_id();
                $this->client->cookie(SphpBase::sphpSettings()->getSessionName(), $sid,false, $date_of_expiry);
            }
            //print_r($_SESSION);
            getWelcome();
        } else {
            $result = $this->dbEngine->executeQueryQuick("SELECT member.id,member.parentid,fname,lname,email,usertype,profile_id,permission_id,member.spcmpId FROM member,profile_permission WHERE username = '$uname' AND password = '$pword' AND member.status = '1' AND profile_id=profile_permission.id ");
            if ($this->dbEngine->isRows($result)) {
                $row = $this->dbEngine->rowFetchAssoc($result);
                $this->setAuthUser($row);
                    getWelcome();
                } else {
                    setErr('app2', 'Invalid User or Password');
                    $this->setFrontFile($this->signinvar);
                }
        }
        } else {
                setErr('app2', 'Invalid Data');
                $this->setFrontFile($this->signinvar);
        }
    }

    private function setAuthUser($row) {
        $authcookie = array();
        if (!getCheckErr()) {
            $this->client->session('sid', $row['id']);

            if ($row['parentid'] == 0) {
                $this->client->session('parentid', $row['id']);
            } else {
                $this->client->session('parentid', $row['parentid']);
            }

            $this->client->session('admin-name', $row['fname'] . " " . $row['lname']);
            $this->client->session('email', $row['email']);
            $this->client->session('usertype', $row['usertype']);
            $this->client->session('profile_id', $row['profile_id']);
            $this->client->session('lstpermis', $row['permission_id']);
            $this->client->session('compid', $row['spcmpId']);

            //This is for permission management---------------------
            //This is for permission management---------------------

            //$usertype = $row['usertype'];
            $authcookie['sid'] = $this->client->session('sid');            
            $authcookie['parentid'] = $this->client->session('parentid'); 
            $authcookie['admin-name'] = $this->client->session('admin-name');            
            $authcookie['email'] = $this->client->session('email');            
            $authcookie['usertype'] = $this->client->session('usertype');  
            $authcookie['profile_id'] = $this->client->session('profile_id');            
            $authcookie['lstpermis'] = $this->client->session('lstpermis');            
            $number_of_days = 10 ;
            $date_of_expiry = time() + 60 * 60 * 24 * $number_of_days ;

            if($this->client->isRequest("chkremb")) {
                $this->client->cookie("algdec", "dome1",false, $date_of_expiry );
                $this->client->cookie("algdec2", encryptme(json_encode($authcookie)),false, $date_of_expiry );
            }

            setSession('MEMBER', $row['id']);
        }  
    }
    
    public function getAuthGoogle(){
        global $googleOauthclientSecret;
        if($googleOauthclientSecret == null || strlen($googleOauthclientSecret) < 4) $this->signinvar->getComponent("divgog")->fu_unsetRender();
    }
     public function page_event_gauth($param) {
         global $google_oauth_client_id,$googleOauthclientSecret,$google_oauth_redirect_uri,$google_oauth_version;
        // set in your comp.php file 
        //$google_oauth_client_id = 'YOUR_CLIENT_ID';
        //$googleOauthclientSecret = 'YOUR_CLIENT_SECRET';
        //$google_oauth_redirect_uri = getEventUrl("gauthr") ;
        
        // Define params and redirect to Google Authentication page
    $params = [
        'response_type' => 'code',
        'client_id' => $google_oauth_client_id,
        'redirect_uri' => $google_oauth_redirect_uri,
        'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
        'access_type' => 'offline',
        'prompt' => 'consent'
    ];
    //header('Location: https://accounts.google.com/o/oauth2/auth?' . http_build_query($params));
    $this->page->forward('https://accounts.google.com/o/oauth2/auth?' . http_build_query($params));
     }

     private function generatePassword($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
        $charactersLength = strlen($characters);
        $randomPassword = '';
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomPassword;
    }
     // google redirect event
     public function page_event_gauthr($param) {
         global $google_oauth_client_id,$googleOauthclientSecret,$google_oauth_redirect_uri,$google_oauth_version,$cmpId;
         //print_r($_REQUEST);
         // If the captured code param exists and is valid
        if (isset($_GET['code']) && !empty($_GET['code'])) {
            // Execute cURL request to retrieve the access token
            $params = [
                'code' => $_GET['code'],
                'client_id' => $google_oauth_client_id,
                'client_secret' => $googleOauthclientSecret,
                'redirect_uri' => $google_oauth_redirect_uri,
                'grant_type' => 'authorization_code'
            ];
            $response = $this->postToUrl('https://accounts.google.com/o/oauth2/token',$params); 
           // print_r($response);
                // Make sure access token is valid
            if (isset($response['access_token']) && !empty($response['access_token'])) {
                // Execute cURL request to retrieve the user info associated with the Google account
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/oauth2/' . $google_oauth_version . '/userinfo');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $response['access_token']]);
                $response = curl_exec($ch);
                curl_close($ch);
                $profile = json_decode($response, true);
                // Make sure the profile data exists
                if (isset($profile['email'])) {
                    $result = $this->dbEngine->executeQueryQuick("SELECT member.id,member.parentid,fname,lname,email,usertype,profile_id,permission_id,member.spcmpId FROM member,profile_permission WHERE username='". $profile['email'] ."' AND member.status = '1' AND profile_id=profile_permission.id ");
                    if ($this->dbEngine->isRows($result)) {

                        $rows = $this->dbEngine->rowFetchAssoc($result);
                        $this->setAuthUser($rows);
                        getWelcome();
                        
                    }else{
                    $google_name_parts = [];
                    $google_name_parts[0] = isset($profile['given_name']) ? preg_replace('/[^a-zA-Z0-9]/s', '', $profile['given_name']) : '';
                    $google_name_parts[1] = isset($profile['family_name']) ? preg_replace('/[^a-zA-Z0-9]/s', '', $profile['family_name']) : '';

                    $this->extra['member']['userid'] = '0';
                    $this->extra['member']['parentid'] = '0';
                    $this->extra['member']['spcmpId'] = $cmpId;
                    $this->extra['member']['submit_timestamp'] = time();
                    $this->extra['member']['update_timestamp'] = time();
                    $this->extra['member']['email'] =$profile['email'];
                    $this->extra['member']['username'] =$profile['email'];
                    $this->extra['member']['password'] = $this->generatePassword(8);
                    $this->extra['member']['fname'] =$google_name_parts[0];
                    $this->extra['member']['lname'] =$google_name_parts[1];
                    $this->extra['member']['pic'] = isset($profile['picture']) ? $profile['picture'] : '';
                    $this->extra['member']['usertype'] ='MEMBER';
                    $this->extra['member']['varification'] ='1';
                    $this->extra['member']['profile_id'] ='1'; // use profile id=1 so create carefully
                    $this->extra['member']['status'] ='1'; // account active
            
                    //$this->debug->println("Call Insert Event");
                    if (!getCheckErr()) {
                        $insertedid = $this->page->insertData($this->extra);            
                        if (!getCheckErr()) {
                            $result = $this->dbEngine->executeQueryQuick("SELECT member.id,member.parentid,fname,lname,email,usertype,profile_id,permission_id,member.spcmpId FROM member,profile_permission WHERE username='". $profile['email'] ."' AND member.status = '1' AND profile_id=profile_permission.id ");
                            $rows = $this->dbEngine->rowFetchAssoc($result);
                            $this->setAuthUser($rows);
                            getWelcome();
                            
                           // setMsg('app1', 'Added Successfully');
                            // send Welcome Email with password
                            
                        }
                    }
                    }
                    
                    // Redirect to profile page
                } else {
                    echo 'Could not retrieve profile information! Please try again later!';
                }
            } else {
                echo 'Invalid Google token! Please try again later!';
            }
        }else{
            echo 'Invalid Google Response';
        } 
     }

    private function postToUrl($url,$params) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            return json_decode($response, true);    
    }
    
    public function page_event_logout($param) {
        $number_of_days = 2 ;
        $date_of_expiry = time() - 60 * 60 * 24 * $number_of_days ;
        $this->client->cookie( "algdec", "", false, $date_of_expiry );
        $this->client->cookie("algdec2", "", false, $date_of_expiry );
        destSession();
        $this->page->forward(getAppURL("index"));
    }

}
