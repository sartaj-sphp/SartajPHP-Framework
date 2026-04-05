<div class="card">
        <div class="card-header">
       Configure Plugin:- ##{$page->getEventParameter()}# 
       ##{raw:'<span class="text-success"> - Installed</span>'}#
    </div>

    <div class="card-body">

<div class="paghead">##{raw:traceError(true)}#</div>
<div class="paghead">##{raw:traceMsg(true)}#</div> 
<br />
<div id="mjk" runat="server" class="alert text-success">Plugin Installed Succesfully into Your Website</div>
<a href="##{getEventURL('vw',$page->evtp,'installer')}#">Click Here to configure Now</a>

    </div>
</div>
