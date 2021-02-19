<?php 
switch($page->getAuthenticateType()){
case 'GUEST':{
$menupath = "{$phppath}temp/default/menu.php";
break;
}
case 'ADMIN':{
$menupath = "{$phppath}temp/default/admmenu.php";
break;
}
case 'MEMBER':{
$menupath = "{$phppath}temp/default/mebmenu.php"; 
break;
}

}
include_once($menupath);
$menu = new MenuUi();
$menu->run();

?><!DOCTYPE html>
<html>
<head lang="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php SphpJsM::addjQueryUI(); SphpJsM::addBootStrap();  print getHeaderHTML(); ?>
<link href="<?php print $respath; ?>temp/default/css/framework.css" rel="stylesheet"  type="text/css" />
<link rel="icon" type="image/gif" href="<?php print $basepath; ?>favicon.gif" />
</head>
<body>
    <div class="container">
        <div class="row"><div class="col panel">
        <div class="row"><div class="col">
<h2 class="heading" style="font-size:36px;"><?php print $cmpname; ?></h2>
            </div></div>
 <div class="row"><div class="col">
<?php print $menu->render(); ?>
    </div></div>
<div class="row"><div class="col">        
<?php $dynData->render(); ?>
</div>
</div>
            </div></div></div>
<?php print getFooterHTML(); print traceError(); print traceErrorInner(); ?>
</body>
</html>
