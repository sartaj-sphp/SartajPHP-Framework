<!DOCTYPE html>
<html>
    <head lang="en">
        <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php
            $myrespath = getMyResPath(__FILE__);
            SphpJSM::addBootStrap();
            echo getHeaderHTML();
        ?>
        <link href="<?php echo $myrespath; ?>/css/framework.css" rel="stylesheet"  type="text/css" />
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo $myrespath; ?>/imgs/android-icon-192x192.png" />
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $myrespath; ?>/imgs/favicon-32x32.png" />
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $myrespath; ?>/imgs/favicon-96x96.png" />
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $myrespath; ?>/imgs/favicon-16x16.png" />
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col  px-4 py-4">
                    <div class="card">
                        <div class="card-header">
                            <h1><?php print $cmpname; ?></h1>
                        </div>

                        <div class="card-body">        
                            <?php SphpBase::getAppOutput(); ?>
                        </div>
                        <div class="card-footer">
                            <?php
                            echo getFooterHTML();
                            print traceError();
                            print traceErrorInner();
                            ?>                        
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
