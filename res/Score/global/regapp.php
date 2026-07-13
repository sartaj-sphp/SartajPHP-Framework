<?php
registerGate('index',"{$slibpath}/apps/Index.gate.php","def");
// for pager plugin overwrite index app
registerGate('index2',"{$slibpath}/apps/Index.gate.php","def");
registerGate('error',"{$slibpath}/apps/err.php");
registerGate('aiinfo',"{$slibpath}/apps/helper/AiInfo.gate.php");
registerGate('admlogin',"{$slibpath}/apps/auth/AdminLogin.gate.php");
registerGate('admhome',"{$slibpath}/apps/auth/AdminIndex.gate.php");
registerGate('installer',"{$libpath}/dev/Installer.gate.php");
registerGate("autocomp", "{$slibpath}/apps/helper/AutoComp.gate.php");
registerGate("signin", "{$slibpath}/apps/permis/Signin.gate.php");
registerGate("admin", "{$slibpath}/apps/permis/Signin.gate.php");
registerGate("mebhome", "{$slibpath}/apps/permis/MebHome.gate.php","","Dash Board",array(["install","Install"]));
registerGate("mebProfile", "{$slibpath}/apps/permis/MebProfile.gate.php","","Profile",
array(["view","Profile View"],["add","Add Record"],["delete","Delete Record"]));
registerGate("mebProfilePermission", "{$slibpath}/apps/permis/MebProfilePermission.gate.php","","Permission",
array(["view","Permissions View"],["add","Add Record"],["delete","Delete Record"]));
//registerGate("seditor", "{$slibpath}/apps/helper/Seditor.app");
include_once(PROJ_PATH . "/plugin/creg.php");
include_once(PROJ_PATH . "/reg.php");
