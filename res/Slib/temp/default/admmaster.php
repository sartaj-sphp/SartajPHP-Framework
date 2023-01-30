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
    <div class="container-fluid">
        <div class="row"><div class="col-md-3 col-sm-hd bg-dark">
 <?php print $menu->render(); ?>
      </div>
    <div class="col-md-9 col-sm-12 bg-white">
       <div class="row"><div class="col">
<h2 class="heading" style="font-size:36px;"><?php print $cmpname; ?></h2>
            </div></div>
 <div class="row"><div class="col">
<?php $dynData->render(); ?>
     </div></div>
<div class="row"><div class="col">        
        footer
</div>
</div>
            </div></div></div>
<?php print getFooterHTML(); print traceError(); print traceErrorInner(); ?>
</body>
</html>
