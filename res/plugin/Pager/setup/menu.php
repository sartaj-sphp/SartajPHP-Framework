<?php 
global $cmpid,$dbEngine;
//$dbEngine = SphpBase::engine()->getDBEngine();
$dbEngine->connect();
$sqlm1 = "SELECT id,aname FROM pagcategory WHERE spcmpid='$cmpid' AND aname!='Hidden' AND atype='Parent' ORDER BY rank";
$result = $dbEngine->fetchQuery($sqlm1,600);
foreach ($result["news"] as $key => $row) {
    SphpBase::sphp_api()->addMenu($row['aname'],"","","root");
    getPagerSubMenu($row['aname']);
    getPagerMenuLinks($row['aname']);
}
$dbEngine->disconnect();
function getPagerMenuLinks($catname){
    global $dbEngine,$cmpid;
    $sql2 = "SELECT id,pagename,catname,menuname FROM pagdet WHERE spcmpid='$cmpid' AND catname='$catname' AND pagestatus='NO' AND menustatus='YES' ORDER BY rank";
    $result = $dbEngine->fetchQuery($sql2,600);
    foreach ($result["news"] as $key => $row) {
        SphpBase::sphp_api()->addMenuLink($row['menuname'],getEventPath($row['pagename'],'','page'),"",$catname);
    }

}
function getPagerSubMenu($catname){
    global $dbEngine,$cmpid;
    $sql1a = "SELECT id,aname FROM pagcategory WHERE spcmpid='$cmpid' AND atype='Sub' AND aparent='$catname' ORDER BY rank";
    $result = $dbEngine->fetchQuery($sql1a,600);
    foreach ($result["news"] as $key => $row) {
        SphpBase::sphp_api()->addMenu($row['aname'],"","",$catname);
        getPagerSubMenu($row['aname']);
        getPagerMenuLinks($row['aname']);
    }

}
 ?>