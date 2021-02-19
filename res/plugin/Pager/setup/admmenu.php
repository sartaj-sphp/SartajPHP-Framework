<?php
SphpBase::$sphp_api->addMenu("Pages");
SphpBase::$sphp_api->addMenuLink("Add Category",getAppPath('pagecat','','',true),"","Pages");
SphpBase::$sphp_api->addMenuLink("List Category",getEventPath('show','','pagecat','','',true),"","Pages");
SphpBase::$sphp_api->addMenuLink("Add Page",getAppPath('pagea','','',true),"","Pages");
SphpBase::$sphp_api->addMenuLink("List Pages",getEventPath('show','','pagea','','',true),"","Pages");
?>