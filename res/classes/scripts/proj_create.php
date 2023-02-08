<?php
/**
 * @author Sartaj Singh <sartajphp.com>
 */
include_once(__DIR__ . "/DIR.php");
$dir = new DIR();
$src = realpath(__DIR__ . "/proj");
$dst = $argv[1];
$dir->directoryCopy($src,$dst);
echo "Project Created \n";
echo "Run:- composer install in project folder \n";
echo "Or install SphpDesk + Sphp Server Support with NPM:- npm install -g sphpdesk \n";
echo "For SphpDesk you need to edit start.php file and may be add app.sphp file \n";
