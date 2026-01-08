<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link rel="icon" type="image/gif" href="<?php print $basepath; ?>favicon.gif" />
<link href="<?php echo "$respath"; ?>styles/framework.css" rel="stylesheet"  type="text/css" />
<?php include_once("{$comppath}/jquery.php");
print getHeaderHTML(); ?>
</head>
<body>
<div>
<?php $dynData->render(); ?>
</div>
<?php print getFooterHTML(); print traceError(); print traceErrorInner(); ?>
</body>
</html>
