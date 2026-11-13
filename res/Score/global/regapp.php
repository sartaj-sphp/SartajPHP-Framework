<?php
registerGate('index',"{$slibPath}/apps/Index.gate.php","def");
// for pager plugin overwrite index app
registerGate('index2',"{$slibPath}/apps/Index.gate.php","def");
registerGate('error',"{$slibPath}/apps/err.php");
registerGate('aiinfo',"{$slibPath}/apps/helper/AiInfo.gate.php");
registerGate('admlogin',"{$slibPath}/apps/auth/AdminLogin.gate.php");
registerGate('admhome',"{$slibPath}/apps/auth/AdminIndex.gate.php");
registerGate('installer',"{$libPath}/dev/Installer.gate.php");
registerGate("autocomp", "{$slibPath}/apps/helper/AutoComp.gate.php");
registerGate("signin", "{$slibPath}/apps/permis/Signin.gate.php");
registerGate("admin", "{$slibPath}/apps/permis/Signin.gate.php");
registerGate("mebhome", "{$slibPath}/apps/permis/MebHome.gate.php","","Dash Board",array(["install","Install"]));
registerGate("mebProfile", "{$slibPath}/apps/permis/MebProfile.gate.php","","Profile",
array(["view","Profile View"],["add","Add Record"],["delete","Delete Record"]));
registerGate("mebProfilePermission", "{$slibPath}/apps/permis/MebProfilePermission.gate.php","","Permission",
array(["view","Permissions View"],["add","Add Record"],["delete","Delete Record"]));
//registerGate("seditor", "{$slibPath}/apps/helper/Seditor.app");
include_once(PROJ_PATH . "/plugin/creg.php");
include_once(PROJ_PATH . "/reg.php");
