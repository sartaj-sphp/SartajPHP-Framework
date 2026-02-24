<?php
SphpBase::sphp_api()->addMenu("Pages","","","root",false,"ADMIN");
SphpBase::sphp_api()->addMenuLink("Add Category",getGateURL('pagecat','','',true),"","Pages");
SphpBase::sphp_api()->addMenuLink("List Category",getEventURL('show','','pagecat','','',true),"","Pages");
SphpBase::sphp_api()->addMenuLink("Add Page",getGateURL('pagea','','',true),"","Pages");
SphpBase::sphp_api()->addMenuLink("List Pages",getEventURL('show','','pagea','','',true),"","Pages");
?>