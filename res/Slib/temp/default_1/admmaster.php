<?php 
switch(SphpBase::page()->getAuthenticateType()){
case 'GUEST':{
$menupath = "{$slibpath}/temp/default/menu.php";
break;
}
case 'ADMIN':{
$menupath = "{$slibpath}/temp/default/admmenu.php";
break;
}
case 'MEMBER':{
$menupath = "{$slibpath}/temp/default/mebmenu.php"; 
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
<link href="<?php print $slibrespath; ?>/temp/default/css/framework.css" rel="stylesheet"  type="text/css" />
<link rel="icon" type="image/gif" href="<?php print $basepath; ?>/favicon.gif" />
</head>
<body>
    <div class="container-fluid padding-top">
               <div class="row"><div class="col">
<h1 class="heading padding-top padding-bottom">
    <img src="<?php print $slibrespath; ?>/temp/default/imgs/favicon-32x32.png" />&nbsp;&nbsp;<?php print $cmpname; ?></h1>
            </div></div>

        <div class="row"><div class="col">
 <?php print $menu->render(); ?>
      </div>
        </div><div class="row">
    <div class="col">
 <div class="row"><div class="col">
<?php SphpBase::$dynData->render(); ?>
     </div></div>
<div class="row"><div class="col footer navbar-fixed-bottom">        
        <h2 class="heading padding-top padding-bottom text-center"><a class="text-white" href="https://www.sartajphp.com">Power By SartajPHP</a></h2>
</div>
</div>
            </div></div></div>
<?php print getFooterHTML(); print traceError(); print traceErrorInner(); ?>
</body>
</html>
