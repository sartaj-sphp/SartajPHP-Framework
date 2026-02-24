<?php
registerGate('index',"{$slibpath}/apps/index.app");
// for pager plugin overwrite index app
registerGate('index2',"{$slibpath}/apps/index.app");
registerGate('error',"{$slibpath}/apps/err.php");
registerGate('admin',"{$slibpath}/apps/auth/admlogin.php");
registerGate('admlogin',"{$slibpath}/apps/auth/admlogin.php");
registerGate('admhome',"{$slibpath}/apps/auth/admhome.php");
registerGate('installer',"{$libpath}/dev/installer.app");
//registerGate("autocomp", "{$slibpath}/apps/helper/autocomp.app");
registerGate("signin", "{$slibpath}/apps/permis/signin.app");
registerGate("mebhome", "{$slibpath}/apps/permis/mebhome.app","","Dash Board",array(["install","Install"]));
registerGate("mebProfile", "{$slibpath}/apps/permis/mebProfile.app","","Profile",
array(["view","Profile View"],["add","Add Record"],["delete","Delete Record"]));
registerGate("mebProfilePermission", "{$slibpath}/apps/permis/mebProfilePermission.app","","Permission",
array(["view","Permissions View"],["add","Add Record"],["delete","Delete Record"]));
//registerGate("seditor", "{$slibpath}/apps/helper/Seditor.app");
include_once(PROJ_PATH . "/plugin/creg.php");
include_once(PROJ_PATH . "/reg.php");
