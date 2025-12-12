<title metakeywords="Contact Address" metadescription="Contact Address" metaclassification="Contacts" keywords="contact,address">Contact Address</title>

<div class="container"><div class="row py-4 px-4">
<h1>Inquiry Form</h1>
        <div class="col-12 col-sm-12 col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"></h5>    
                    <div class="card">
                        <div class="card-head">
                            <img class="img img-fluid" src="temp/images/logo.png" />
                        </div>
                        <div class="card-body">
                            <address>
                                <strong>##{$cmpname}#</strong><br>
                                #{ if($cmpaddress1 != "") echo $cmpaddress1 . "<br>" }#
                                #{ if($cmpaddress2 != "") echo $cmpaddress2 . "<br>" }#
                                      <a href="tel:##{$cmpphone1}#" class="btn btn-light d-none d-sm-inline-block"><i class="fas fa-phone"></i> Phone1</a>
                                      <a href="tel:##{$cmpphone2}#" class="btn btn-light d-none d-sm-inline-block"><i class="fas fa-phone"></i> Phone2</a>

                            </address>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-8">
<div class="card">
<div class="card-body">
<h5 class="card-title">Fill the Following Details:-</h5>    
<div class="error"><?php print traceError(true); ?></div>
<div class="msgerr"><?php print traceMsg(true); ?></div>

                    <form id='form2' runat="server" action="<?php print getEventURL('subquote','','index2');?>">
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