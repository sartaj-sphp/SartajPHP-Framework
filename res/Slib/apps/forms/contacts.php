<title metakeywords="Contact Address" metadescription="Contact Address" metaclassification="Contacts" keywords="contact,address">Contact Address</title>
<h2>Contacts</h2>
<div class="panel">
<p>
<b><?php print $cmpname; ?></b><br />
<?php 
/*
$str = $row['cmpaddr1'].'<br />'; 
$str .= $row['cmpaddr2'].'<br />'; 
$str .= "City:-".$row['cmpcity'].'<br />'; 
$str .= "District:-".$row['cmpdistrict'].'<br />';
$str .= "State:-".$row['cmpstate'].'<br />';
$str .= "Country:-".$row['cmpcountry'].'<br />'; 
$str .= "Phone:-".$row['cmpphone'].','.$row['cmpmobile'].'<br />'; 
$str .= "Fax:-".$row['cmpfax'].'<br />'; 
print $str;
 * 
 */
?>
</p>
<div class="error"><?php print traceError(true); ?></div>
<div class="msgerr"><?php print traceMsg(true); ?></div>
<p class="heading">Query Form</p>

                    <form id='form2' runat="server" action="<?php print getEventPath('page','quote-submit','index');?>">
                      <table border="0" width="80%" align="center">
                        <tbody><tr> 
                          <td>Name:</td>
                        </tr>
                        <tr> 
 <td><input name="qname" type="text" runat="server" funsetForm="form2" funsetMinLen="2" funsetMsgName="Name" funsetRequired="" /></td>
                        </tr>
                        <tr> 
                          <td>Email:</td>
                        </tr>
                        <tr> 
                          <td>
                            <input name="qemail" type="text" runat="server" funsetForm="form2" funsetMinLen="5" funsetEmail="" funsetMsgName="Email" funsetRequired="" />
                            </td>
                        </tr>
                        <tr>
                          <td>Phone:</td>
                        </tr>
                        <tr>
                          <td>
                            <input name="qphone" type="text" runat="server" funsetForm="form2" funsetMinLen="10" funsetNumeric="" funsetMsgName="Phone" funsetRequired="" />
                            </td>
                        </tr>
                        <tr>
                          <td>Address:</td>
                        </tr>
                        <tr>
                          <td>
<textarea name="qadd" runat="server" funsetForm="form2" funsetMinLen="5" funsetMsgName="Address" funsetRequired="" cols="10" rows="3"></textarea>
                            </td>
                        </tr>
                        <tr> 
                          <td>Comments / Requirements :</td>
                        </tr>
                        <tr> 
                          <td>
<textarea name="qcomments" runat="server" funsetForm="form2" funsetMinLen="12" funsetMsgName="Comments" funsetRequired=""></textarea>
</td>
                        </tr>
                        <tr> 
                          <td>Please type the characters in the Security code box.(Not case-sensitive)</td>
                        </tr>
                        <tr> 
                          <td>
<input type="text" runat="server" id="catcaha" path="controls/bundle/captcha/Captcha.php"  funsetMaxLen="5" funsetRequired="" funsetForm="form2" funsetMsgName="Secure Code">
</td>
                        </tr>
                        <tr> 
                          <td>
<input name="Submit" value="Submit" type="button" onclick="form2_submit('');" />
                            </td>
                        </tr>
                      </tbody></table>
                    </form>
</div>
