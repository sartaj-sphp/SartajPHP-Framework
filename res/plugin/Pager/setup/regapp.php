<?php
$plugpath = SphpBase::sphp_api()->getRootPath(__FILE__); 
// permissions use for plugin like pagea-add mean Add Page permission 
registerApp('pagea',"{$plugpath}/plugin/Pager/admin/page.php","","Web Page",array(["add","Add Page"],["edit","Edit Page"],
    ["del","Delete Page"],["catadd","Add Menu"],["catedit","Edit Menu"],["catdel","Delete Menu"]));
registerApp('pagecat', "{$plugpath}/plugin/Pager/admin/categoriesw.php");
registerApp('page', "{$plugpath}/plugin/Pager/index.app");
registerApp('pageplg', "{$plugpath}/plugin/Pager/indexplg.app");
registerApp('pagefrm', "{$plugpath}/plugin/Pager/indexfrm.app");
registerApp('index', "{$plugpath}/plugin/Pager/index.app");
registerApp('pagefsav', "{$plugpath}/plugin/Pager/admin/PageFrontSaver.app");
registerApp('catfsav', "{$plugpath}/plugin/Pager/admin/CatFrontSaver.app");

