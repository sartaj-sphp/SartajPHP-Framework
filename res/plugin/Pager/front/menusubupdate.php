<div id="sqlCat2" runat="server" fursetSQL="<?php
global $sql2a,$catp;
$sql1a = "SELECT id,aname FROM pagcategory WHERE spcmpid='$cmpid' AND atype='Sub' AND aparent='$catp' ORDER BY rank";
$sql2a = "SELECT id,pagename,catname,menuname FROM pagdet WHERE spcmpid='$cmpid'";
print $sql1a;
?>
" path="libpath/comp/data/SearchQuery.php" funsetCacheTime="1">
<menu id="pager2" runat="server" caption="<?php print $sqlCat2->getField('aname'); ?>" href="#" >
<?php global $catp2; $catp2 = $sqlCat2->getField('aname'); $mnut = new FrontFile("{$dphppath}/plugin/Pager/front/menusub2update.php"); $mnut->run(); $mnut->render(); ?>
  <div id="sql12" runat="server" funsetSQL="<?php print $sql2a; ?> AND catname='<?php print $sqlCat2->getField('aname'); ?>' AND pagestatus='NO' AND menustatus='YES' ORDER BY rank" path="libpath/comp/data/SearchQuery.php" funsetCacheTime="1">
<menuitem id="menuipag1" runat="server" href="<?php print getEventURL($sql12->getField('pagename'),'','page') ; ?>" ><?php print $sql12->getField('menuname'); ?></menuitem>
  </div>
</menu>
</div>
