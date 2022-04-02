<?php
/**
 * Description of createTables
 *
 * @author SARTAJ
 */
class CreateTables {

public function createAdminTable(){
global $mysql;
$sql = "CREATE TABLE admin ( id INT NOT NULL AUTO_INCREMENT ,
			userID VARCHAR(20), pass VARCHAR(20), atype VARCHAR(20), dispName  VARCHAR(50),
			PRIMARY KEY(id))";
$mysql->createTable($sql);
}

public function createUserTable(){
global $mysql;
	$sql = "CREATE TABLE usert ( id INT NOT NULL AUTO_INCREMENT ,
			userID VARCHAR(20) , pass VARCHAR(20), email VARCHAR(100), mobile VARCHAR(12), phone VARCHAR(12),
			validation boolean, pic VARCHAR(200), dispName  VARCHAR(50), address VARCHAR(200), city VARCHAR(50),
			atype VARCHAR(20), status VARCHAR(20), sacheme VARCHAR(20), country VARCHAR(50), validationNum VARCHAR(20),
 logDate DATE, createDate DATE, expDate DATE, logIP VARCHAR(50),
			logBrowser VARCHAR(200), logOS VARCHAR(50), logMotherBoard VARCHAR(50),
			PRIMARY KEY(id))";
$mysql->createTable($sql);
}

public function createVarTable(){
global $mysql;
	$sql = "CREATE TABLE vars ( id INT NOT NULL AUTO_INCREMENT ,
			userID VARCHAR(20), aname VARCHAR(20), val VARCHAR(1024),
			PRIMARY KEY(id))";
    $mysql->createTable($sql);
}

public function createPermissionTable(){
global $mysql;
	$sql = "CREATE TABLE permission ( id INT NOT NULL AUTO_INCREMENT ,
			userID VARCHAR(20), atype VARCHAR(20), details VARCHAR(100), val VARCHAR(2048),
            atable VARCHAR(20), afield VARCHAR(20),
			PRIMARY KEY(id))";
$mysql->createTable($sql);
}


}
$CreateTables = '';
$CreateTables = new CreateTables();

?>
