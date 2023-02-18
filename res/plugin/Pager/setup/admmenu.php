<?php
SphpBase::sphp_api()->addMenu("Pages");
SphpBase::sphp_api()->addMenuLink("Add Category",getAppURL('pagecat','','',true),"","Pages");
SphpBase::sphp_api()->addMenuLink("List Category",getEventURL('show','','pagecat','','',true),"","Pages");
SphpBase::sphp_api()->addMenuLink("Add Page",getAppURL('pagea','','',true),"","Pages");
SphpBase::sphp_api()->addMenuLink("List Pages",getEventURL('show','','pagea','','',true),"","Pages");
?>