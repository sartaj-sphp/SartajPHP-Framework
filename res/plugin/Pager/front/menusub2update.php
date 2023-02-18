<div id="sqlCat3" runat="server" fursetSQL="<?php
global $sql2a2,$catp2;
$sql1a2 = "SELECT id,aname FROM pagcategory WHERE spcmpid='$cmpid' AND atype='Sub' AND aparent='$catp2' ORDER BY rank";
$sql2a2 = "SELECT id,pagename,catname,menuname FROM pagdet WHERE spcmpid='$cmpid'";
print $sql1a2;
?>
" path="libpath/comp/data/SearchQuery.php" funsetCacheTime="1">
<menu id="pager3" runat="server" caption="<?php print $sqlCat3->getField('aname'); ?>" href="#" >
  <div id="sql13" runat="server" funsetSQL="<?php print $sql2a2; ?> AND catname='<?php print $sqlCat3->getField('aname'); ?>' AND pagestatus='NO' AND menustatus='YES' ORDER BY rank" path="libpath/comp/data/SearchQuery.php" funsetCacheTime="1">
<menuitem id="menuipag1" runat="server" href="<?php print getEventURL($sql13->getField('pagename'),'','page') ; ?>" ><?php print $sql13->getField('menuname'); ?></menuitem>
  </div>
</menu>
</div>
