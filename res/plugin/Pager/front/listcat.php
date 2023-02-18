<div id="sqlCat" runat="server" funsetCacheTime="<?php echo $maxtime; ?>" fuqsetSQL="<?php
global $sql2;
$sqlm1 = "SELECT id,aname FROM pagcategory WHERE spcmpid='$cmpid' ORDER BY rank";
$sql2 = "SELECT id,pagename,catname,menuname FROM pagdet";
print $sqlm1;
?>
" path="libpath/comp/data/SearchQuery.php">
<h2 class="headerbar"><?php print $sqlCat->row['aname']; ?></h2>
<ul>
<div id="sql1" runat="server" funsetSQL="<?php print $sql2 ." WHERE spcmpid='$cmpid' "; ?>  AND catname='<?php print $sqlCat->getField('aname'); ?>' ORDER BY pagename" path="libpath/comp/data/SearchQuery.php"  funsetCacheTime="<?php echo $maxtime; ?>">
<li class="heading"><a href="<?php print getEventURL($sql1->row['pagename'],'','page') ; ?>" ><?php print $sql1->row['menuname']; ?></a></li>
  </div>
  </ul>
</div>
