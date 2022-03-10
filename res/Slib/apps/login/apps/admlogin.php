 <?php
/**
 * Description of admlogin
 *
 * @author SARTAJ
 */
// app settings
$auth = "GUEST,ADMIN";
// default table values for all components
$tblName = "admin";
// check athentication type of user if not match with $auth then forward application 
// according to getWelcome function in global.php file
$page->Authenticate();
//$page->sesSecure();
// include section if we want use inbuilt in other panels then we include that panel here
$dynData = new TempFile("apps/auth/forms/admlogin.php");


if($page->isevent)
{
switch($page->sact){
case "showall" :{
$blngetFront = true;
$formNo = 1;
break;
}
case "logout" :{
    destSession();
    getWelcome();
    break;
}

}

 }


if($page->isdelete)
{
//$page->deleteRec();
$blngetFront = true;
$formNo = 1;
 }

if($page->isview)
{
$blngetFront = true;
$formNo = 1;

 }

if($page->isaction)
{
//print "Action event <br>";
 }

if($page->issubmit)
{
//print "Submit event <br>";
if(preg_replace('/[a-zA-Z0-9]/', '', $txtuserID->getValue())){
setErr('app', "Chracters in UserID Is not Valid!");
}
if(!getCheckErr()){
$sql = "SELECT userID,pass,atype FROM admin WHERE userID='".$txtuserID->getValue()."' AND pass='".$txtpass->getValue()."'";
$result = $mysql->executeQueryQuick($sql);
if(mysql_num_rows($result)){
$res = mysql_fetch_assoc($result);
setSession($res['atype'], $res['userID']);
getWelcome();
    }
else{
setErr('app', "UserID or Password Is not Valid!");
$blngetFront = true;
   }
}else{
$blngetFront = true;
}
$formNo = 1;
}

if($page->isupdate)
{
$blngetFront = true;
$formNo = 1;
}

if($page->isinsert)
{
if(!getCheckErr()){

}
else{

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
$title = "Sartaj PHP Framework Admin Login System";
$metakeywords = "sartaj,sartaj singh amritsar,srtaj framework,sartaj php framework";
$metadescription = "Sartaj PHP Framework Login System.";
$metaclassification = "Software Company";
$dynData->run();
$paraRepeated = 0;
include_once("temp/master.php");
    break;
	}
    case 2:{
$title = "Sartaj PHP Framework Admin Login System";
$metakeywords = "sartaj,sartaj singh amritsar,srtaj framework,sartaj php framework";
$metadescription = "Sartaj PHP Framework Login System.";
$metaclassification = "Software Company";
$dynData->TempFile('apps/auth/forms/loginsubmit.frm.php');
$dynData->run();
include_once("temp/master.php");
    break;
	}
}
}

?>