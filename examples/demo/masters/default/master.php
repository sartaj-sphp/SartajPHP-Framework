<?php
/* Add menu.php file as Front Place in section "left" */
addFrontPlace("menu", __DIR__ . "/menu.php", "left");
/* Run Front Place in section "left" before SartajPHP header HTML Output */
runFrontPlace("menu", "left");
?>
<!DOCTYPE html>
<html>

<head lang="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
        /* Add SartajPHP Managed Bootstrap CSS Library */ 
        SphpBase::SphpJsM()::addBootStrap();
        /* Print All SartajPHP Header generated Required */
        echo SphpBase::sphp_api()->getHeaderHTML();
    ?>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col panel">
                <div class="row">
                    <div class="col">
                        <h2 class="heading" style="font-size:36px;"><?php echo $cmpname; ?></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?php 
                            /* Print Front Place "menu" Output */ 
                            renderFrontPlace("menu", "left"); 
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?php 
                            /* Print SartajPHP App generated Output with Front File Output */ 
                            SphpBase::getAppOutput(); 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        /* Print All SartajPHP Footer generated Required */ 
        echo SphpBase::sphp_api()->getFooterHTML();
        /* Print all errors related output for debug purposes */ 
        echo SphpBase::sphp_api()->traceError(true) . SphpBase::sphp_api()->traceErrorInner(true); 
    ?>
</body>

</html>