<div class="card">
        <div class="card-header">
        Plugin:- <?php echo  SphpBase::page()->getEventParameter(); if($parentapp->isPlugExist()) {echo "<span class='text-success'> - Installed</span>";}else{echo "<span class='text-danger'> - Not Installed</span>";} ?>
    </div>

    <div class="card-body">
<div class="paghead"><?php print traceError(true); ?></div>
<div class="paghead"><?php print traceMsg(true); ?></div>
<br />
<div class="row">
    <div class="col-12">
        <?php include_once(SphpBase::sphp_settings()->php_path ."/plugin/". SphpBase::page()->getEventParameter() ."/doc/des.php");
  ?>
    </div>
</div>
<div class="card mt-3 mb-3">
        <div class="card-header">
        <h3>Commands</h3>
        </div>
    <div class="card-body">
<?php if($parentapp->isPlugExist()){ ?>
<a href="<?php print getEventURL('update',SphpBase::page()->evtp,'installer'); ?>">Update Plugin</a><br/>
<a href="<?php print getEventURL('rmp',SphpBase::page()->evtp,'installer'); ?>">Uninstall Plugin</a>
<?php }else{?>
<a href="<?php print getEventURL('config',SphpBase::page()->evtp,'installer'); ?>">install Plugin</a>
<?php } ?>
    </div>
</div></div>
</div>
