<!DOCTYPE html>
<html>
<head lang="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php echo getHeaderHTML(); ?>
</head>
<body>
    <div id="mainbody" class="container-fluid">
        <div class="row"><div class="col maincol">
<?php SphpBase::$dynData->render(); ?>
</div></div>
</div>
<?php 
echo getFooterHTML(); 
echo traceError(); echo traceErrorInner(); ?>
</body>
</html>
