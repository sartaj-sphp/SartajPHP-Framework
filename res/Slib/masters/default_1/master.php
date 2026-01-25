<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php 
addFrontPlace("main_master",__DIR__ . '/main.front','centersp1');
runFrontPlace('main_master','centersp1');
SphpBase::SphpJsM()::addBootStrap();  echo SphpBase::sphp_api()->getHeaderHTML(); 
?>
<link href="<?php echo SphpBase::sphp_settings()->slib_res_path; ?>/masters/default/css/custom.css" rel="stylesheet"  type="text/css" />
</head>
<body class="h-100">
<?php echo renderFrontPlace('main_master','centersp1'); ?>
<?php  echo SphpBase::sphp_api()->getFooterHTML(); 
echo SphpBase::sphp_api()->traceError(true) . SphpBase::sphp_api()->traceErrorInner(true); ?>
</body>    
</html>