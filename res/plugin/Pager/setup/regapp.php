<?php
$plugpath = SphpBase::sphp_api()->getRootPath(__FILE__); 
registerApp('pagea',"{$plugpath}/plugin/Pager/admin/page.php");
registerApp('pagecat', "{$plugpath}/plugin/Pager/admin/categoriesw.php");
registerApp('page', "{$plugpath}/plugin/Pager/index.php");
