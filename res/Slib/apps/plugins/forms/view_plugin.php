<div class="paghead"><?php print traceError(true); ?></div>
<div class="paghead"><?php print traceMsg(true); ?></div>
<?php 
$arr = $this->tempobj->parentapp->directoryCount("{$phppath}/plugin");
foreach($arr as $key=>$val){
print "<div class=\"border\">
<a href=".getEventURL('vw',$val,'installer').">$val</a><br />";
include_once("{$phppath}/plugin/$val/doc/des.php");
print "</div>";
}
 ?>