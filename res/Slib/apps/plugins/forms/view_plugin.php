<div class="paghead">##{raw:traceError(true) }#</div>
<div class="paghead">##{ raw:traceMsg(true) }#</div>
<br />
<code on-init="true">
#{ 
    $arrt = $parentgate->directoryCount($sphp_settings->php_path . "/plugin"); 
}#
</code>
<div id="pluginLoop" runat="server" path="slibpath/comp/server/ForEachLoop.php" fun-setObject="arrt">
    <div class="card mb-3">
        <div class="card-header">
            <a href="##{getEventURL('vw',$pluginLoop->item,'installer') }#">##{$pluginLoop->item}#</a>
        </div>
        <div class="card-body">
            <include_place id="inc1" runat="server" fur-setFrontPlaceFile="##{($pluginLoop->item) ? '' . $sphp_settings->php_path . '/plugin/' . $pluginLoop->item . '/doc/des.front' : ''}#" ></include_place>
        </div>
    </div>
</div> 
