<div class="paghead flash  text-danger" id="showerrdet"><?php echo traceError(true); ?></div>
<div class="paghead flash  text-info" id="showmsgdet"><?php echo traceMsg(true); ?></div>
<h1 class="headerbar" id="showformhead"><?php echo $showformhead; ?> &nbsp;&nbsp;<a id="btnadd1" runat="server" href="##{ getThisURL() }#" class="btn btn-primary">Add</a></h1>
<div id="showall" path="libpath/comp/data/Pagination.php" runat="server"></div>
    