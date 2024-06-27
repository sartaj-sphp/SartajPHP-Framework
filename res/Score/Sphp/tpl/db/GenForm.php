<div class="paghead text-danger" id="frmerrdet"><?php print traceError(true); ?></div>
<div class="paghead text-info" id="frmmsgdet"><?php print traceMsg(true); ?></div>
<h1 id="frmformhead"><?php print $formHead; ?></h1>
<form id="form2" runat="server" action="<?php echo getThisURL('',true); ?>">
<div id="genForm" path="libpath/comp/data/DTable.php" dtable="usert" runat="server" funsetForm="form2" funsetDontUseFormat=""
 on-create="true"></div>
    <div align="center" class="pagbar"><input type="submit" value="Submit" class="btn btn-primary" /></div>
</form>
<div class="pagfooter">&nbsp;</div>
