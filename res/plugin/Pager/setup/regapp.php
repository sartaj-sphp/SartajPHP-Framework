<?php
$plugpath = SphpBase::sphp_api()->getRootPath(__FILE__); 
// permissions use for plugin like pagea-add mean Add Page permission 
registerGate('pagea',"{$plugpath}/plugin/Pager/admin/page.php","","Web Page",array(["add","Add Page"],["edit","Edit Page"],
    ["del","Delete Page"],["catadd","Add Menu"],["catedit","Edit Menu"],["catdel","Delete Menu"]));
registerGate('pagecat', "{$plugpath}/plugin/Pager/admin/categoriesw.php");
registerGate('page', "{$plugpath}/plugin/Pager/index.app");
registerGate('pageplg', "{$plugpath}/plugin/Pager/indexplg.app");
registerGate('pagefrm', "{$plugpath}/plugin/Pager/indexfrm.app");
registerGate('index', "{$plugpath}/plugin/Pager/index.app");
registerGate('pagefsav', "{$plugpath}/plugin/Pager/admin/PageFrontSaver.app");
registerGate('catfsav', "{$plugpath}/plugin/Pager/admin/CatFrontSaver.app");

