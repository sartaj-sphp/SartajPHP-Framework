<?php
class Settings{
public function createTables(){
global $mysql;
$mysql->connect();
$sql = "CREATE TABLE  IF NOT EXISTS tblvars(id INT NOT NULL AUTO_INCREMENT,aname VARCHAR(10),avalue VARCHAR(100),plugname VARCHAR(20),spcmpid VARCHAR(20),PRIMARY KEY(id));";
$mysql->createTable($sql);
$mysql->disconnect();
}

public function setValue($aname,$avalue,$plugname){
global $mysql,$cmpid;
$sql = "INSERT INTO tblvars (aname,avalue,plugname,spcmpid) VALUES('$aname','$avalue','$plugname','$cmpid')";
$mysql->executeQueryQuick($sql);	
}
public function updateValue($aname,$avalue,$plugname){
global $mysql,$cmpid;
$sql = "UPDATE tblvars avalue='$avalue' WHERE spcmpid='$cmpid' AND plugname='$plugname' AND aname='$aname'";
$mysql->executeQueryQuick($sql);	
}
}
?>