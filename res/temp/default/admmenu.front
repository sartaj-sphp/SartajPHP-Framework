<menubar id="menubar1" runat="server" funsetNavbarCSS="navbar navbar-expand-md navbar-dark bg-sphp-dark">

<menu id="menu1" runat="server" caption="Admin" href="#">
<menuitem id="menui1" runat="server" href="<?php print getAppPath('admhome') ; ?>">Admin Home</menuitem>
<menuitem id="menui1" runat="server" href="<?php print getAppPath('installer') ; ?>">Plugin Home</menuitem>
<menuitem id="menui1" runat="server" href="<?php print getEventPath('logout','','admlogin','','',true); ?>">Log Out</menuitem>
</menu>
<?php $mnu = new TempFile("plugin/cadmmenu.php"); $mnu->run(); $mnu->render(); ?>
</menubar>
