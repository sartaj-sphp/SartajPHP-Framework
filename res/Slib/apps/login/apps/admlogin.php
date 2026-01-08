 <?php
/**
 * Description of admlogin
 *
 * @author SARTAJ
 */
// app settings
$auth = "GUEST,ADMIN";
// default table values for all components
SphpBase::page()->tblName = "admin";
// check athentication type of user if not match with $auth then forward application 
// according to getWelcome function in global.php file
SphpBase::page()->Authenticate();
//SphpBase::page()->sesSecure();
// include section if we want use inbuilt in other panels then we include that panel here
$dynData = new FrontFile("apps/auth/forms/admlogin.php");


if(SphpBase::page()->isevent)
{
switch(SphpBase::page()->sact){
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


if(SphpBase::page()->isdelete)
{
//SphpBase::page()->deleteRec();
$blngetFront = true;
$formNo = 1;
 }

if(SphpBase::page()->isview)
{
$blngetFront = true;
$formNo = 1;

 }

if(SphpBase::page()->isaction)
{
//print "Action event <br>";
 }

if(SphpBase::page()->issubmit)
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

if(SphpBase::page()->isupdate)
{
$blngetFront = true;
$formNo = 1;
}

if(SphpBase::page()->isinsert)
{
if(!getCheckErr()){

}
else{

}
 }

if(SphpBase::page()->isnew)
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
include_once("masters/master.php");
    break;
	}
    case 2:{
$title = "Sartaj PHP Framework Admin Login System";
$metakeywords = "sartaj,sartaj singh amritsar,srtaj framework,sartaj php framework";
$metadescription = "Sartaj PHP Framework Login System.";
$metaclassification = "Software Company";
$dynData->FrontFile('apps/auth/forms/loginsubmit.frm.php');
$dynData->run();
include_once("masters/master.php");
    break;
	}
}
}

?>