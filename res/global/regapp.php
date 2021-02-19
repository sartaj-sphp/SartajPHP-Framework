<?php
registerApp('index',"{$phppath}apps/index.app");
registerApp('error',"{$phppath}apps/err.php");
registerApp('admin',"{$phppath}apps/auth/admlogin.php");
registerApp('admlogin',"{$phppath}apps/auth/admlogin.php");
registerApp('admhome',"{$phppath}apps/auth/admhome.php");
registerApp('installer',"{$libpath}global/installer.app");
include_once("plugin/creg.php");
