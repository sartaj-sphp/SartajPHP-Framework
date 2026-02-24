<?php 
$arr = $parentgate->directoryCount(SphpBase::sphp_settings()->php_path . "/plugin");
foreach($arr as $key=>$val){
 ?>
<div class="card mb-3">
    <div class="card-header">
        <a href="<?php echo getEventURL('vw',$val,'installer'); ?>"><?php echo $val; ?></a>
    </div>
    <div class="card-body">
<div class="paghead"><?php print traceError(true); ?></div>
<div class="paghead"><?php print traceMsg(true); ?></div>
<br />
<?php include_once("{$phppath}/plugin/$val/doc/des.php"); ?>
</div>
</div>
<?php 
}
 ?>