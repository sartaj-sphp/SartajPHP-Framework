<?php
// don't delete DB for safety so mannually delete
/*
SphpBase::dbEngine()->connect();
$sql = "DELETE FROM pagcategory WHERE spcmpId='".$_SESSION['uid']."'";
SphpBase::dbEngine()->createTable($sql);
$sql = "DELETE FROM pagdet WHERE spcmpId='".$_SESSION['uid']."'";
SphpBase::dbEngine()->createTable($sql);
//$mysql->dropTable('pagcategory');
//$mysql->dropTable('pagdet');

SphpBase::dbEngine()->disconnect();

global $libPath;
include_once "{$libPath}/lib/DIR.php";
$dr = new \Sphp\Lib\Dir();
$dr->directoryDelete("pagres");
*/
?>