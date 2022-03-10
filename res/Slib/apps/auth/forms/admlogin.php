<div class="heading">Admin Login Form</div>

<form id='form2' runat="server" action="<?php print getAppPath('admin');?>">
<table align="center">
<tr><td>
User ID
</td><td>
<input name="txtuserID" type="text" class="inputpass" runat="server" funsetForm="form2" funsetMinLen="4" funsetRequired="" funsetMsgName="User ID">
</td></tr>
<tr><td>
Password
</td><td>
<input name="txtpass" type="password" class="inputpass" runat="server" funsetForm="form2" funsetMinLen="4" funsetRequired="" funsetMsgName="Password">
</td></tr>
<tr><td>
Remember me
</td><td>
    <input name="chkremb" type="checkbox" class="inputpass" value="yes" />
</td></tr>

<tr><td>
&nbsp;</td><td>
              <input type="submit" value="Login">
</td></tr>
<tr><td>
&nbsp;</td><td>
						<p align="left"><font color="#FF0000"> <?php print $msg; ?></font></p>
</td></tr>
</table>
            
</form>
<br>