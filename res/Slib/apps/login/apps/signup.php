<?php
/**
 * Description of login
 *
 * @author SARTAJ
 */
// app settings
$auth = "GUEST,MEMBER";
// default table values for all components
$tblName = "usert";
// check athentication type of user if not match with $auth then forward application
// according to getWelcome function in global.php file
$page->Authenticate();
//$page->sesSecure();
// include section if we want use inbuilt in other panels then we include that panel here
$dynData = new TempFile("apps/auth/forms/signup.php");

if($page->isevent)
{
switch($page->sact){
case "showall" :{
$blngetFront = true;
$formNo = 1;
break;
}
case "veri" :{
if($mysql->isRecordExist("SELECT userID FROM usert WHERE id='". $_REQUEST['uid']."' AND validationNum='". $page->evtp."' AND NOT validation")){
$extra[]['validation'] = '1';
$extra[]['status'] = 'DONE';
$extra[]['logDate'] = date('Y-m-d');
$extra[]['logIP'] = $_SERVER['REMOTE_ADDR'];
$extra[]['logBrowser'] = $_SERVER['HTTP_USER_AGENT'];
$page->updateData($extra,$_REQUEST['uid']);
$page->forward(getAppPath('login'));
}
else{
setErr('app', "User ID ". $txtuserID->getValue()." Already Exist Please Select Other User ID!");
$blngetFront = true;
$formNo = 1;
}

break;
}

case "chk" :{
if(!getCheckErr()){
if($mysql->isRecordExist("SELECT userID FROM usert WHERE userID='". $_REQUEST['txtuserID']."' OR email='".$_REQUEST['email']."'")){
print "Not Available, If you forget password then go to login form and click on forget password and fill your email and click on Get Password Button ";
}else{print "Available ". $_REQUEST['txtuserID'];
}
}else{
if($email->getValue()==''){
print "Not Valid ID, Please also fill email address";
    }else{
print "Not Valid ID";
    }
}
break;
}
}

 }


if($page->isdelete)
{
//$page->deleteRec();
$blngetFront = true;
$formNo = 2;
 }

if($page->isview)
{
$page->viewData($page->form);
$blngetFront = true;
$formNo = 1;

 }

if($page->isaction)
{
//print "Action event <br>";
 }

if($page->issubmit)
{

}

if($page->isupdate)
{
$blngetFront = true;
$formNo = 1;
}

if($page->isinsert)
{
if(preg_replace('/[a-zA-Z0-9]/', '', $txtuserID->getValue())){
setErr('app', "Chracters in UserID Is not Valid!");
}
if(!getCheckErr()){
    if(!$mysql->isRecordExist("SELECT userID FROM usert WHERE userID='". $txtuserID->getValue()."' OR email='".$email->getValue()."'")){
$verificationNum = time();
$extra[]['validation'] = '0';
$extra[]['validationNum'] = $verificationNum;
$extra[]['atype'] = 'MEMBER';
$extra[]['sacheme'] = 'FREE';
$extra[]['status'] = 'BAN';
$extra[]['logDate'] = date('Y-m-d');
$extra[]['createDate'] = date('Y-m-d');
$extra[]['expDate'] = date('Y-m-d');
$extra[]['logIP'] = $_SERVER['REMOTE_ADDR'];
$extra[]['logBrowser'] = $_SERVER['HTTP_USER_AGENT'];
//$extra[]['logOS'] = '';
//$extra[]['logMotherBoard'] = '';
$newid = $page->insertData($extra);
$blngetFront = true;
$formNo = 2;
}
else{
setErr('app', "User ID ". $txtuserID->getValue()." or Email ". $email->getValue()." Already Exist Please Select Other User ID or unique Email!");
$blngetFront = true;
$formNo = 1;
}

}
else{
$blngetFront = true;
$formNo = 1;
}
 }

if($page->isnew)
{
$blngetFront = true;
$formNo = 1;
 }

if ($blngetFront == true ){
switch($formNo){
    case 1:{
$title = "Sartaj PHP Framework Signup System";
$metakeywords = "sartaj,sartaj singh amritsar,srtaj framework,sartaj php framework";
$metadescription = "Sartaj PHP Framework Login System.";
$metaclassification = "Software Company";
$dynData->run();
include_once("temp/master.php");
    break;
	}
    case 2:{
$title = "Sartaj PHP Framework Signup System";
$metakeywords = "sartaj,sartaj singh amritsar,srtaj framework,sartaj php framework";
$metadescription = "Sartaj PHP Framework Login System.";
$metaclassification = "Software Company";
$paraRepeated = 0;
$dynData->TempFile('apps/auth/forms/signupsubmit.frm.php');
$dynData->run();
include_once("temp/master.php");
    break;
	}
}
}

?>
