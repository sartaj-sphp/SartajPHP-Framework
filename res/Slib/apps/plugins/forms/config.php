<div class="paghead"><?php print traceError(true); ?></div>
<div class="paghead"><?php print traceMsg(true); ?></div>
<br />
<div class="row"><div class="col">
        <h3>Commands</h3>
<?php if($this->tempobj->parentapp->isPlugExist()){ ?>
<a href="<?php print getEventPath('update',$page->evtp,'installer'); ?>">Update Plugin</a><br/>
<a href="<?php print getEventPath('rmp',$page->evtp,'installer'); ?>">Uninstall Plugin</a>
<?php }else{?>
<a href="<?php print getEventPath('config',$page->evtp,'installer'); ?>">install Plugin</a>
<?php } ?>

</div></div>
