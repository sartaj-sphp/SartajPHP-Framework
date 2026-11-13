<?php 
// need to add icons with menu
global $cmpId,$dbEngine,$cacheTime;
$dbEngine = SphpBase::dbEngine();
$dbEngine->connect();
$sqlm1 = "SELECT id,aname FROM pagcategory WHERE spcmpId='$cmpId' AND aname!='Hidden' AND atype='Parent' ORDER BY rank";
$result = $dbEngine->fetchQuery($sqlm1,$cacheTime);
foreach ($result["news"] as $key => $row) { 
    SphpBase::sphpApi()->addMenu($row['aname'],"","","root");
    getPagerSubMenu($row['aname']);
    getPagerMenuLinks($row['aname'],$row['id']);
}
$dbEngine->disconnect();

function getPagerMenuLinks($catname,$catid){
    global $dbEngine,$cmpId,$cacheTime;
    $sql2 = "SELECT id,pagename,catname,catid,menuname FROM pagdet WHERE spcmpId='$cmpId' AND catid='$catid' AND pagestatus='NO' AND menustatus='YES' ORDER BY rank";
    $result = $dbEngine->fetchQuery($sql2,$cacheTime);
    foreach ($result["news"] as $key => $row) {
        if(isset($row['menuname'])){
            SphpBase::sphpApi()->addMenuLink($row['menuname'],getEventUrl($row['pagename'],'','page'),"",$catname);
        }
    }

}
function getPagerSubMenu($catname){
    global $dbEngine,$cmpId,$cacheTime;
    $sql1a = "SELECT id,aname FROM pagcategory WHERE spcmpId='$cmpId' AND atype='Sub' AND aparent='$catname' ORDER BY rank";
    $result = $dbEngine->fetchQuery($sql1a,$cacheTime);
    foreach ($result["news"] as $key => $row) {
        SphpBase::sphpApi()->addMenu($row['aname'],"","",$catname);
        getPagerSubMenu($row['aname']);
        getPagerMenuLinks($row['aname'],$row['id']);
    }

}
 ?>