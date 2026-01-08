<?php 
switch(SphpBase::page()->getAuthenticateType()){
case 'GUEST':{
$menupath = PROJ_PATH . "/temp/default/menu.php";
break;
}
case 'ADMIN':{
$menupath = PROJ_PATH . "/temp/default/admmenu.php";
break;
}
case 'MEMBER':{
$menupath = PROJ_PATH . "/temp/default/mebmenu.php"; 
break;
}
default:{
    $menupath = PROJ_PATH . "/temp/default/menu.php";
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
<?php SphpBase::SphpJsM()::addBootStrap();  echo SphpBase::sphp_api()->getHeaderHTML(); ?>
</head>
<body>
    <div class="container-fluid">
        <div class="row"><div class="col panel">
        <div class="row"><div class="col">
    <h2 class="heading" style="font-size:36px;"><?php echo $cmpname; ?></h2>
    </div>
            </div>
<div class="row"><div class="col">
<?php echo $menu->render(); ?>
    </div></div>
<div class="row"><div class="col">        
<?php SphpBase::$dynData->render(); ?>
</div>
</div>
            </div></div></div>
<?php  echo SphpBase::sphp_api()->getFooterHTML(); 
echo SphpBase::sphp_api()->traceError(true) . SphpBase::sphp_api()->traceErrorInner(true); ?>
</body>
</html>
