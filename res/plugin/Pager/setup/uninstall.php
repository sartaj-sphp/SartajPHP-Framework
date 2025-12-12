<?php
// don't delete DB for safety so mannually delete
/*
SphpBase::dbEngine()->connect();
$sql = "DELETE FROM pagcategory WHERE spcmpid='".$_SESSION['uid']."'";
SphpBase::dbEngine()->createTable($sql);
$sql = "DELETE FROM pagdet WHERE spcmpid='".$_SESSION['uid']."'";
SphpBase::dbEngine()->createTable($sql);
//$mysql->dropTable('pagcategory');
//$mysql->dropTable('pagdet');

SphpBase::dbEngine()->disconnect();

global $libpath;
include_once "{$libpath}/lib/DIR.php";
$dr = new DIR();
$dr->directoryDelete("pagres");
*/
?>