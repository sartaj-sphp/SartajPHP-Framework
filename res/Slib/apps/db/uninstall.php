<?php
$mysql->connect();
$sql = "DELETE FROM tblvars WHERE spcmpid='".$_SESSION['uid']."' AND plugname='$plugname'";
$mysql->executeQuery($sql);

$mysql->disconnect();

?>