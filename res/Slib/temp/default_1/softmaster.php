<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link href="<?php echo $slibrespath . '/';  ?>temp/default/css/framework.css" rel="stylesheet" type="text/css" />
<?php SphpJsM::addBootStrap(); SphpJsM::addFontAwesome();
 print getHeaderHTML(); ?>
</head>
<body>
<?php SphpBase::$dynData->render(); ?>
<?php print getFooterHTML(); print traceError(); print traceErrorInner(); ?>
</body>
</html>