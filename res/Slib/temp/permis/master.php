<?php 
addFrontPlace('mastertemp1',__DIR__ . "/template1.front","template");
runFrontPlace("mastertemp1","template");
//addFrontPlace('videomenu');
//runFrontPlace('frontEditor',"footer");
?><!DOCTYPE html>
<html>
<head lang="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php SphpJsM::addBootStrapKit5();  echo getHeaderHTML(); ?>
<link href="<?php echo SphpBase::sphp_settings()->slib_res_path ; ?>/temp/permis/css/framework.css" rel="stylesheet"  type="text/css" />
<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo SphpBase::sphp_settings()->slib_res_path ; ?>/temp/default/imgs/android-icon-192x192.png" />
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo SphpBase::sphp_settings()->slib_res_path ; ?>/temp/default/imgs/favicon-32x32.png" />
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo SphpBase::sphp_settings()->slib_res_path ; ?>/temp/default/imgs/favicon-96x96.png" />
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo SphpBase::sphp_settings()->slib_res_path ; ?>/temp/default/imgs/favicon-16x16.png" />
</head>
<body>
    <div class="container-fluid">
<?php renderFrontPlace("mastertemp1","template"); ?>        
</div>
<?php renderFrontPlace('frontEditor',"footer"); echo getFooterHTML(); echo traceError(); echo traceErrorInner(); ?>
</body>
</html>
