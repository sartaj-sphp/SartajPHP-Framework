<?php 
switch(SphpBase::page()->getAuthenticateType()){
case 'GUEST':{
$menupath = SphpBase::sphp_settings()->slib_path ."/masters/default/menu.php";
break;
}
case 'ADMIN':{
$menupath = SphpBase::sphp_settings()->slib_path ."/masters/default/admmenu.php";
break;
}
case 'MEMBER':{
$menupath = SphpBase::sphp_settings()->slib_path."/masters/default/mebmenu.php"; 
break;
}
default:{
    $menupath = SphpBase::sphp_settings()->slib_path ."/masters/default/menu.php";
    break;    
}

}
include_once($menupath);
$menu = new MenuUi();
$menu->run();

//addFrontPlace('videomenu');
runFrontPlace('frontEditor',"footer");
?><!DOCTYPE html>
<html>
<head lang="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php 
SphpJsM::addBootStrap();  
echo getHeaderHTML(); ?>
<link href="<?php echo SphpBase::sphp_settings()->slib_res_path ; ?>/masters/default/css/framework.css" rel="stylesheet"  type="text/css" />
<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo SphpBase::sphp_settings()->slib_res_path ; ?>/masters/default/imgs/android-icon-192x192.png" />
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo SphpBase::sphp_settings()->slib_res_path ; ?>/masters/default/imgs/favicon-32x32.png" />
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo SphpBase::sphp_settings()->slib_res_path ; ?>/masters/default/imgs/favicon-96x96.png" />
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo SphpBase::sphp_settings()->slib_res_path ; ?>/masters/default/imgs/favicon-16x16.png" />
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
<?php 
renderFrontPlace('frontEditor',"footer"); 
echo getFooterHTML(); 
echo traceError(); echo traceErrorInner(); ?>
</body>
</html>
