<!DOCTYPE html>
<html>
<head lang="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php echo getHeaderHTML(); ?>
<link href="<?php echo $respath . '/' . $slibversion . '/'; ?>masters/default/css/framework.css" rel="stylesheet"  type="text/css" />
<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo $respath . '/' . $slibversion . '/'; ?>masters/default/imgs/android-icon-192x192.png" />
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $respath . '/' . $slibversion . '/'; ?>masters/default/imgs/favicon-32x32.png" />
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo $respath . '/' . $slibversion . '/'; ?>masters/default/imgs/favicon-96x96.png" />
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $respath . '/' . $slibversion . '/'; ?>masters/default/imgs/favicon-16x16.png" />
</head>
<body>
    <div class="container">
        <div class="row"><div class="col panel">
        <div class="row"><div class="col">
    <h2 class="heading" style="font-size:36px;"><?php print $cmpname; ?></h2>
    </div>
            </div>
<div class="row"><div class="col">        
<?php SphpBase::$dynData->render(); ?>
</div>
<div class="row"><div class="col">        
    <?php echo getFooterHTML(); print traceError(); print traceErrorInner(); ?>
    </div>
</div>
            </div></div></div>
</body>
</html>
