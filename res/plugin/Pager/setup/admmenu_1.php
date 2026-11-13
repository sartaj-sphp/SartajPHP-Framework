<?php
SphpBase::sphpApi()->addMenu("Pages","","","root",false,"ADMIN");
SphpBase::sphpApi()->addMenuLink("Add Category",getGateUrl('pagecat','','',true),"","Pages");
SphpBase::sphpApi()->addMenuLink("List Category",getEventUrl('show','','pagecat','','',true),"","Pages");
SphpBase::sphpApi()->addMenuLink("Add Page",getGateUrl('pagea','','',true),"","Pages");
SphpBase::sphpApi()->addMenuLink("List Pages",getEventUrl('show','','pagea','','',true),"","Pages");
?>