<!DOCTYPE html>
<html>
<head lang="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php SphpJsM::addjQuery1(true,true); SphpJsM::addBootStrap(); SphpJsM::addFontAwesome(); 
echo getHeaderHTML(true,true,1); ?>
<link href="<?php print $respath . $slibversion . '/'; ?>temp/default/css/framework.css" rel="stylesheet"  type="text/css" />
<link rel="icon" type="image/gif" href="<?php print $basepath; ?>favicon.gif" />
</head>
<body>
<?php $dynData->render(); ?>
<?php print getFooterHTML(true,true,1); print traceError(); print traceErrorInner(); ?>
</body>
</html>