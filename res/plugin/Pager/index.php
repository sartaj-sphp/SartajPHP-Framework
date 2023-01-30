<?php
$masterFile = $masterf;
$tblName = "pagdet";
addFrontPlace("pager","{$dphppath}/plugin/Pager/forms/infradet.front",'pager');
$dynData = getFrontPlace('pager','pager');
$dynData->run();
include_once("$masterFile");
?>