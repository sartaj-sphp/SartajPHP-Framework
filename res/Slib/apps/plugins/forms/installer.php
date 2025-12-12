<div class="card">
        <div class="card-header">
       Configure Plugin:- <?php echo  SphpBase::page()->getEventParameter(); echo "<span class='text-success'> - Installed</span>"; ?>
    </div>

    <div class="card-body">

<div class="paghead"><?php print traceError(true); ?></div>
<div class="paghead"><?php print traceMsg(true); ?></div> 
<br />
<div id="mjk" runat="server" class="alert text-success">Plugin Installed Succesfully into Your Website</div>
<a href="<?php print getEventURL('vw',SphpBase::page()->evtp,'installer'); ?>">Click Here to configure Now</a>

    </div>
</div>
