<?php
$plugpath = SphpBase::sphp_api()->getRootPath(__FILE__); 
// permissions use for plugin like pagea-add mean Add Page permission 
registerGate('pagea',"{$plugpath}/plugin/Pager/admin/page.gate.php","","Web Page",array(["add","Add Page"],["edit","Edit Page"],
    ["del","Delete Page"],["catadd","Add Menu"],["catedit","Edit Menu"],["catdel","Delete Menu"]));
registerGate('pagecat', "{$plugpath}/plugin/Pager/admin/categoriesw.gate.php");
registerGate('page', "{$plugpath}/plugin/Pager/index.gate.php");
registerGate('pageplg', "{$plugpath}/plugin/Pager/indexplg.gate.php");
registerGate('pagefrm', "{$plugpath}/plugin/Pager/indexfrm.gate.php");
registerGate('index', "{$plugpath}/plugin/Pager/index.gate.php");
registerGate('pagefsav', "{$plugpath}/plugin/Pager/admin/PageFrontSaver.gate.php");
registerGate('catfsav', "{$plugpath}/plugin/Pager/admin/CatFrontSaver.gate.php");

