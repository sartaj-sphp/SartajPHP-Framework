<?php

SphpBase::dbEngine()->connect();
$sql = "CREATE TABLE IF NOT EXISTS pagcategory(id INT NOT NULL AUTO_INCREMENT,aname VARCHAR(200),atype VARCHAR(10),aparent VARCHAR(200),rank INT,spcmpid VARCHAR(20), PRIMARY KEY(id));";
SphpBase::dbEngine()->createTable($sql);

$sql = "CREATE TABLE IF NOT EXISTS pagdet(id INT NOT NULL AUTO_INCREMENT,pagename VARCHAR(100),catname VARCHAR(200),catid INT,filepath1 VARCHAR(100),filepath2 VARCHAR(100),pagesubttitle VARCHAR(300),pagetitle VARCHAR(70),pagedes VARCHAR(150),pagekey VARCHAR(850),spcmpid VARCHAR(20),pagestatus VARCHAR(3),menustatus VARCHAR(3),menuname VARCHAR(40),rank INT,PRIMARY KEY(id));";
SphpBase::dbEngine()->createTable($sql);

if(!SphpBase::dbEngine()->isRecordExist("SELECT id FROM pagcategory WHERE id=1")){
    $sql = "INSERT INTO pagcategory(id,aname, atype, aparent, rank, spcmpid) VALUES (1,'Home', 'Parent', NULL, 1, 'demo'); ";
    SphpBase::dbEngine()->executeQuery($sql);
}
if(!SphpBase::dbEngine()->isRecordExist("SELECT id FROM pagdet WHERE id=1")){
    $sql = "INSERT INTO pagdet(id, pagename, catname, catid, filepath1, filepath2, pagesubttitle, pagetitle, pagedes, pagekey, spcmpid, pagestatus, menustatus, menuname, rank) VALUES (1, 'home', '1,Home,', 1, NULL, NULL, 'Home Page', '', 'Page Description', 'keyword1,keyword2', 'demo', 'NO', 'NO', NULL, 1); ";
    SphpBase::dbEngine()->executeQuery($sql);
}
SphpBase::dbEngine()->disconnect();

global $libpath;
include_once "{$libpath}/lib/DIR.php";
if(! file_exists(PROJ_PATH . "/pagres")){
    DIR::directoryCreate(PROJ_PATH ."/pagres");
}

if(! file_exists(PROJ_PATH . "/tiny_editor_imgs")){
    DIR::directoryCreate(PROJ_PATH . "/tiny_editor_imgs");
}
if(! file_exists(PROJ_PATH . "/pagres/b1.html")){
    file_put_contents("pagres/b1.html",'Welcome Home Page');
    file_put_contents("pagres/b.html",'<h1>Page not found</h1>');
}
?>