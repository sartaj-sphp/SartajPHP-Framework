<?php

SphpBase::page()->tblName = "admin";
SphpBase::page()->Authenticate("ADMIN");
//SphpBase::page()->sesSecure();
$masterFile = $admmasterf;
$mypath = SphpBase::page()->gate_dir_path;

if (SphpBase::page()->isnew) {
    $formName = "admhome";
}


if (SphpBase::page()->isevent) {
    switch (SphpBase::page()->sact) {
        
    }
}

switch ($formName) {

    case "admhome": {
            SphpBase::sphp_settings()->title = "Super Admin";
            SphpBase::sphp_settings()->metakeywords = "";
            SphpBase::sphp_settings()->metadescription = "";
            SphpBase::sphp_settings()->metaclassification = "";
            SphpBase::sphp_settings()->keywords = "admin home,page";
            SphpBase::$dynData = new FrontFile("{$mypath}/forms/admhome.php");
            SphpBase::$dynData->_run();
            include_once("$masterFile");
            break;
        }
}
