<!DOCTYPE html>
<html>
    <head lang="en">
        <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php
            $myUrl = getMyResPath(__FILE__);
        ?>
        <link href="<?php echo $myUrl; ?>/css/framework.css" rel="stylesheet"  type="text/css" />
        <link href="<?php echo $jsLibUrl; ?>/twitter/bootstrap5/bootstrap.min.css" rel="stylesheet"  type="text/css" />
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo $myUrl; ?>/imgs/android-icon-192x192.png" />
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $myUrl; ?>/imgs/favicon-32x32.png" />
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $myUrl; ?>/imgs/favicon-96x96.png" />
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $myUrl; ?>/imgs/favicon-16x16.png" />
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col  px-4 py-4">
                    <div class="card">
                        <div class="card-header">
                            <h1><?php print $cmpName; ?></h1>
                        </div>

                        <div class="card-body">        
                            <?php echo SphpBase::sphpApi()->getProp("content_err_page"); 
                            SphpBase::debug()->printAll(); ?>
                        </div>
                        <div class="card-footer">
                            <?php
                            echo traceError() . traceErrorInner();
                            ?>                        
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
