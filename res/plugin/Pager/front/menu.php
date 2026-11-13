<div id="sqlCat" runat="server" fursetSQL="<?php
global $sql2;
$sqlm1 = "SELECT id,aname FROM pagcategory WHERE spcmpId='$cmpId' AND aname!='Hidden' AND atype='Parent' ORDER BY rank";
$sql2 = "SELECT id,pagename,catname,menuname FROM pagdet WHERE spcmpId='$cmpId'";
print $sqlm1;
?>
" path="libpath/comp/data/SearchQuery.php" funsetCacheTime="-1">
<menu id="pager1" runat="server" caption="<?php print $sqlCat->getField('aname'); ?>" href="#" >
<?php global $catp; $catp = $sqlCat->row['aname']; $mnut = new FrontFile("{$resourcePath}/plugin/Pager/front/menusub.php"); $mnut->run(); 
$mnut->render(); ?>
  <div id="sql1" runat="server" funsetSQL="<?php print $sql2; ?> AND catname='<?php print $sqlCat->getField('aname'); ?>' AND pagestatus='NO' AND menustatus='YES' ORDER BY rank" path="libpath/comp/data/SearchQuery.php" funsetCacheTime="-1">
<menuitem id="menuipag1" runat="server" href="<?php print getEventUrl($sql1->row['pagename'],'','page') ; ?>" ><?php print $sql1->row['menuname']; ?></menuitem>
  </div>
</menu>
</div>
