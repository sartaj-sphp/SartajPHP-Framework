<?php
/* set $blnPreLibCache = true; in comp or global file
 include this file in php.ini 
opcache.preload=D:/www/res/Sphp/preload_lib.php
opcache.preload_user=www-data
 */
//opcache_compile_file(__DIR__ . "/libsphp1.php");
//Or
require_once(__DIR__ . "/libsphp1.php");
