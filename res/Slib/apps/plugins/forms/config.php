<div class="paghead"><?php print traceError(true); ?></div>
<div class="paghead"><?php print traceMsg(true); ?></div>
<br />
<div class="row"><div class="col">
        <h3>Commands</h3>
<?php if($this->tempobj->parentapp->isPlugExist()){ ?>
<a href="<?php print getEventPath('update',SphpBase::page()->evtp,'installer'); ?>">Update Plugin</a><br/>
<a href="<?php print getEventPath('rmp',SphpBase::page()->evtp,'installer'); ?>">Uninstall Plugin</a>
<?php }else{?>
<a href="<?php print getEventPath('config',SphpBase::page()->evtp,'installer'); ?>">install Plugin</a>
<?php } ?>

</div></div>
