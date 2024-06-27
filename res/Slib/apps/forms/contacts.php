<div class="container"><div class="row d-flex justify-content-center"><div class="col-12 col-sm-12 col-md-8">
<title metakeywords="Contact Address" metadescription="Contact Address" metaclassification="Contacts" keywords="contact,address">Contact Address</title>
<h1>Contacts</h1>
<div class="card">
<div class="card-header">    
    <img src="##{SphpBase::sphp_settings()->slib_res_path}#/temp/default/assets/img/contact_address.webp" class="img img-fluid col-12 col-md-2" alt="Contacts Address" />
</div>
<div class="card-body">
<h5 class="card-title">Fill Query Form of <?php echo $cmpname; ?></h5>    
<div class="error"><?php print traceError(true); ?></div>
<div class="msgerr"><?php print traceMsg(true); ?></div>

                    <form id='form2' runat="server" action="<?php print getEventURL('page','quote-submit','index');?>">
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
                              <input name="Submit" value="Submit" type="submit" class="btn btn-primary" />
                              
                            </td>
                        </tr>
                      </tbody></table>
                    </form>
<br /><br />
</div>
        </div></div></div></div>