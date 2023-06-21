<?php
registerApp('index',"{$slibpath}/apps/index.app");
registerApp('error',"{$slibpath}/apps/err.php");
registerApp('admin',"{$slibpath}/apps/auth/admlogin.php");
registerApp('admlogin',"{$slibpath}/apps/auth/admlogin.php");
registerApp('admhome',"{$slibpath}/apps/auth/admhome.php");
registerApp('installer',"{$libpath}/dev/installer.app");
registerApp("autocomp", "{$slibpath}/apps/helper/autocomp.app");
registerApp("signin", "{$slibpath}/apps/permis/signin.app");
registerApp("mebhome", "{$slibpath}/apps/permis/mebhome.app","","Dash Board",array(["install","Install"]));
registerApp("mebProfile", "{$slibpath}/apps/permis/mebProfile.app","","Profile",
array(["view","Profile View"],["add","Add Record"],["delete","Delete Record"]));
registerApp("mebProfilePermission", "{$slibpath}/apps/permis/mebProfilePermission.app","","Permission",
array(["view","Permissions View"],["add","Add Record"],["delete","Delete Record"]));
//registerApp("seditor", "{$slibpath}/apps/helper/Seditor.app");
include_once(PROJ_PATH . "/plugin/creg.php");
include_once(PROJ_PATH . "/reg.php");
