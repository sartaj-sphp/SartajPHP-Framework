<div id="sqlCat" runat="server" fursetSQL="<?php
global $sql2;
$sqlr1 = "SELECT id,aname FROM pagcategory WHERE spcmpid='$cmpid' AND aname!='Hidden' AND atype='Parent' ORDER BY rank";
$sql2 = "SELECT id,pagename,catname,menuname FROM pagdet WHERE spcmpid='$cmpid'";
print $sqlr1;
?>
" path="libpath/comp/data/SearchQuery.php" funsetCacheTime="1">
<menu id="pager1" runat="server" caption="<?php print $sqlCat->getField('aname'); ?>" href="#" >
<?php global $catp; $catp = $sqlCat->getField('aname'); $mnut = new TempFile("{$dphppath}/plugin/Pager/front/menusubupdate.php"); $mnut->run(); 
$mnut->render(); ?>
  <div id="sql1" runat="server" funsetSQL="<?php print $sql2; ?> AND catname='<?php print $sqlCat->getField('aname'); ?>' AND pagestatus='NO' AND menustatus='YES' ORDER BY rank" path="libpath/comp/data/SearchQuery.php" funsetCacheTime="1">
<menuitem id="menuipag1" runat="server" href="<?php print getEventPath($sql1->getField('pagename'),'','page') ; ?>" ><?php print $sql1->getField('menuname'); ?></menuitem>
  </div>
</menu>
</div>
