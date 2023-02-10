<?php
define("sphp_mannually_start_engine",true);
$strp = $argv[1];
$p1 = $argv[2];
$p2 = pathinfo($strp);
$extn = $p2['extension'];
chdir($p1); 
require_once($p1 . "/start.php");
if($extn == "front" || $extn == "temp"){
    $tmp1 = new TempFile($strp);
    $tmp1->run();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<?php 
 echo SphpBase::sphp_api()->getHeaderHTML(); ?>
</head>
<body>
<?php $tmp1->render(); ?>
<?php echo SphpBase::sphp_api()->getFooterHTML(); echo traceError(); echo traceErrorInner(); ?>
</body>
</html><?php
}else if($extn == "app"){
    SphpBase::sphp_api()->runApp($strp);
}else{
include_once($strp);
}
?>
