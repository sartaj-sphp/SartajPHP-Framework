<?php

SphpBase::dbEngine()->connect();
$sql = "CREATE TABLE IF NOT EXISTS pagcategory(id INT NOT NULL AUTO_INCREMENT,aname VARCHAR(200),atype VARCHAR(10),aparent VARCHAR(200),rank INT,spcmpid VARCHAR(20), PRIMARY KEY(id));";
SphpBase::dbEngine()->createTable($sql);

$sql = "CREATE TABLE IF NOT EXISTS pagdet(id INT NOT NULL AUTO_INCREMENT,pagename VARCHAR(100),catname VARCHAR(200),catid INT,filepath1 VARCHAR(100),filepath2 VARCHAR(100),pagesubttitle VARCHAR(300),pagetitle VARCHAR(70),pagedes VARCHAR(150),pagekey VARCHAR(850),spcmpid VARCHAR(20),pagestatus VARCHAR(3),menustatus VARCHAR(3),menuname VARCHAR(40),rank INT,PRIMARY KEY(id));";
SphpBase::dbEngine()->createTable($sql);


SphpBase::dbEngine()->disconnect();

global $libpath;
include_once "{$libpath}/lib/DIR.php";
DIR::directoryCreate("pagres");
?>