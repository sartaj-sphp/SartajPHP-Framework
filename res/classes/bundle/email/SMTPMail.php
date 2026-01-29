<?php
/**
 * Description of SMTPMail
 *
 * @author SARTAJ
 */
include_once(__DIR__ . "/PHPMailer.php");
include_once(__DIR__ . "/SMTP.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
//use PHPMailer\PHPMailer\Exception;

class SMTPMail {
public $mail;
public $StartText='Dear Sir/Madam,';

public function __construct(){
global $mailServer;
global $mailUser;
global $mailPass;
global $mailPort,$mailServerName;

$this->mail = new PHPMailer();
// send via SMTP
$this->mail->IsSMTP();
// turn on SMTP authentication
$this->mail->SMTPAuth = true;
$this->mail->WordWrap = 50;  // set word wrap
$this->mail->IsHTML(true);  // send as HTML
$this->mail->Port = $mailPort;
$this->mail->Host = $mailServer;
$this->mail->Username = $mailUser;   //  SMTP username
$this->mail->Password = $mailPass; // SMTP password
//$this->mail->SMTPDebug = true;
$this->mail->Hostname = $mailServerName;

//$mail->AddAttachment("Path to Attachment ");      // attachment

//$mail->AddReplyTo("You@yourdomain.com","Your Name");
//if($row['email'] !=""){
//$mail->AddAddress($rowt['email'],$rowt['aname']);	//$mail->AddReplyTo("You@yourdomain.com","Your Name");
//}
    }

public function setPortNo($val){
$this->mail->Port = $val;
    }
public function setHost($val){
$this->mail->Host = $val;
    }
public function setUser($userName,$password){
$this->mail->Username = $userName;   //  SMTP username
$this->mail->Password = $password; // SMTP password
    }
public function setFrom($fromName,$fromEmail){
$this->mail->From     = $fromEmail;
$this->mail->FromName = $fromName;
    }
public function setWelcomeText($val){
$this->StartText = $val;
    }

public function sendMail($subject,$toEmail,$toName,$Msg){
$ret = true;
$Msg1 = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title>".$this->mail->FromName."</title>
</head>

<body style=\"font-family:Verdana, Arial, Helvetica, sans-serif;\">
<div style=\"padding:10px;\">".$this->mail->FromName."</div>

<div style=\"font-size:10px; padding:30px; border:solid 1px #333333; width:600px;\" >
<strong>$this->StartText</strong>
<div style=\"padding-top:10px;\">". $Msg ."</div>
<div style=\"padding-top:50px;\">Thanks,<br /><strong>".$this->mail->FromName."</strong></div></div>
</body>
</html>";

$this->mail->Subject  =  $subject;
$this->mail->AddAddress($toEmail,$toName);
$this->mail->Body     =  $Msg1;
$this->mail->AltBody  =  $Msg;
if(!$this->mail->Send())
{
$ret = false;
setErr("mailer","Mailer Error: " . $this->mail->ErrorInfo);
}
return $ret;
}

public function sendMailRaw($subject,$toEmail,$toName,$Msg){
$ret = true;
$this->mail->Subject  =  $subject;
$this->mail->AddAddress($toEmail,$toName);
$this->mail->Body     =  $Msg;
//$this->mail->AltBody  =  $Msg;
if(!$this->mail->Send()){
$ret = false;
setErr("mailer","Mailer Error: " . $this->mail->ErrorInfo);
}
return $ret;
}

}
?>