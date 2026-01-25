<?php 
// need to add icons with menu
global $cmpid,$dbEngine,$cache_time;
$dbEngine = SphpBase::dbEngine();
$dbEngine->connect();
$sqlm1 = "SELECT id,aname FROM pagcategory WHERE spcmpid='$cmpid' AND aname!='Hidden' AND atype='Parent' ORDER BY rank";
$result = $dbEngine->fetchQuery($sqlm1,$cache_time);
foreach ($result["news"] as $key => $row) { 
    SphpBase::sphp_api()->addMenu($row['aname'],"","","root");
    getPagerSubMenu($row['aname']);
    getPagerMenuLinks($row['aname'],$row['id']);
}
$dbEngine->disconnect();

function getPagerMenuLinks($catname,$catid){
    global $dbEngine,$cmpid,$cache_time;
    $sql2 = "SELECT id,pagename,catname,catid,menuname FROM pagdet WHERE spcmpid='$cmpid' AND catid='$catid' AND pagestatus='NO' AND menustatus='YES' ORDER BY rank";
    $result = $dbEngine->fetchQuery($sql2,$cache_time);
    foreach ($result["news"] as $key => $row) {
        if(isset($row['menuname'])){
            SphpBase::sphp_api()->addMenuLink($row['menuname'],getEventURL($row['pagename'],'','page'),"",$catname);
        }
    }

}
function getPagerSubMenu($catname){
    global $dbEngine,$cmpid,$cache_time;
    $sql1a = "SELECT id,aname FROM pagcategory WHERE spcmpid='$cmpid' AND atype='Sub' AND aparent='$catname' ORDER BY rank";
    $result = $dbEngine->fetchQuery($sql1a,$cache_time);
    foreach ($result["news"] as $key => $row) {
        SphpBase::sphp_api()->addMenu($row['aname'],"","",$catname);
        getPagerSubMenu($row['aname']);
        getPagerMenuLinks($row['aname'],$row['id']);
    }

}
 ?>