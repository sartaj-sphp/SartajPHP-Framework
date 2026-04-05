<div class="card">
        <div class="card-header">
        Plugin:- ##{$page->getEventParameter()}# 
        ##{raw:($parentgate->isPlugExist()) ? '<span class="text-success"> - Installed</span>' : '<span class="text-danger"> - Not Installed</span>' }# 
    </div>

    <div class="card-body">
<div class="paghead">##{raw:traceError(true) }#</div>
<div class="paghead">##{raw:traceMsg(true) }#</div>
<br />
<div class="row">
    <div class="col-12">
            <include_place id="inc1" runat="server" 
                fur-setFrontPlaceFile="##{'' . $sphp_settings->php_path . '/plugin/' . $page->getEventParameter() . '/doc/des.front'}#" ></include_place>        
    </div>
</div>
<div class="card mt-3 mb-3">
        <div class="card-header">
        <h3>Commands</h3>
        </div>
    <div class="card-body">
#{if($parentgate->isPlugExist()) }#
<a href="##{getEventURL('update',$page->evtp,'installer')}#">Update Plugin</a><br/>
<a href="##{getEventURL('rmp',$page->evtp,'installer')}#">Uninstall Plugin</a>
#{else}#
<a href="##{getEventURL('config',$page->evtp,'installer')}#">install Plugin</a>
#{endif}#
    </div>
</div></div>
</div>
