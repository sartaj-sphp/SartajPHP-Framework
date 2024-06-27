<?php 
global $cmpid,$dbEngine;
$cachetime = 1;
$dbEngine = SphpBase::dbEngine();
$dbEngine->connect();
$sqlm1 = "SELECT id,aname FROM pagcategory WHERE spcmpid='$cmpid' AND aname!='Hidden' AND atype='Parent' ORDER BY rank";
$result = $dbEngine->fetchQuery($sqlm1,$cachetime);
foreach ($result["news"] as $key => $row) {
    SphpBase::sphp_api()->addMenu($row['aname'],"","","root");
    getPagerSubMenu2($row['aname']);
    getPagerMenuLinks2($row['aname'],$row['id']);
}
$dbEngine->disconnect();
function getPagerMenuLinks2($catname,$catid){
    global $dbEngine,$cmpid,$cachetime;
    $sql2 = "SELECT id,pagename,catname,menuname FROM pagdet WHERE spcmpid='$cmpid' AND catid='$catid' AND pagestatus='NO' AND menustatus='YES' ORDER BY rank";
    $result = $dbEngine->fetchQuery($sql2,$cachetime);
    foreach ($result["news"] as $key => $row) {
        SphpBase::sphp_api()->addMenuLink($row['menuname'],getEventURL($row['pagename'],'','page'),"",$catname);
    }

}
function getPagerSubMenu2($catname){
    global $dbEngine,$cmpid,$cachetime;
    $sql1a = "SELECT id,aname FROM pagcategory WHERE spcmpid='$cmpid' AND atype='Sub' AND aparent='$catname' ORDER BY rank";
    $result = $dbEngine->fetchQuery($sql1a,$cachetime);
    foreach ($result["news"] as $key => $row) {
        SphpBase::sphp_api()->addMenu($row['aname'],"","",$catname);
        getPagerSubMenu2($row['aname']);
        getPagerMenuLinks2($row['aname'],$row['id']);
    }

}
 ?>