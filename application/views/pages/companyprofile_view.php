<script>

$('#Settings, #companyprofile').addClass('open');
$('#Settings, #companyprofile').children('ul').slideDown();



function closepopup()
   {
  		  //window.opener.location.reload();
		  alert("User has been updated!");
		}

</script>


 <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="container">
							<div class="content">
                                <h4><?php echo $title; ?></h4>
                                <?php //echo $message; ?>
                                <?php echo validation_errors(); ?>
                                <?php echo form_open($action); ?>
                                <div class="data">
                                	<table>

                                        <tr>
                                            <td>Company Name</td>
                                            <td><input type="text" name="co_name" class="text" value="<?php echo set_value('co_name')?set_value('co_name'):$Users['co_name']; ?>"/>
                                            <?php echo form_error('co_name'); ?></td>
                                        </tr>    
                                        <tr>
                                            <td>Nature of Business</td>
                                            <td><input type="text" name="nature_business" class="text" value="<?php echo set_value('nature_business')?set_value('nature_business'):$Users['nature_business']; ?>"/>
                                            <?php echo form_error('nature_business'); ?></td>
                                        </tr>
                                        
                                         <tr>
                                            <td>Address 1</td>
                                            <td><input type="textarea" name="address1" class="textarea" value="<?php echo set_value('address1')?set_value('address1'):$Users['address1']; ?>"/>
                                            <?php echo form_error('address1'); ?></td>
                                        </tr>
                                        
                                         <tr>
                                            <td>Address 2</td>
                                            <td><input type="textarea" name="address2" class="textarea" value="<?php echo set_value('address2')?set_value('address2'):$Users['address2']; ?>"/>
                                            <?php echo form_error('address2'); ?></td>
                                        </tr>

                                    <tr>
                                            <td>Zip Code</td>
                                            <td><input type="text" name="zip_code" class="text" value="<?php echo set_value('zip_code')?set_value('zip_code'):$Users['zip_code']; ?>"/>
                                            <?php echo form_error('zip_code'); ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td>RDO</td>
                                            <td><input type="text" name="rdo" class="text" value="<?php echo set_value('rdo')?set_value('rdo'):$Users['rdo']; ?>"/>
                                            <?php echo form_error('ss_total'); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td><input type="text" name="email" class="text" value="<?php echo set_value('email')?set_value('email'):$Users['email']; ?>"/>
                                            <?php echo form_error('email'); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Telephone</td>
                                            <td><input type="text" name="phones" class="text" value="<?php echo set_value('phones')?set_value('phones'):$Users['phones']; ?>"/>
                                            <?php echo form_error('phones'); ?></td>
                                        </tr>
                                        
                                         <tr>
                                            <td>Fax</td>
                                            <td><input type="text" name="fax" class="text" value="<?php echo set_value('fax')?set_value('fax'):$Users['fax']; ?>"/>
                                            <?php echo form_error('rate'); ?></td>
                                        </tr>
                                        
                                         

                                    <tr>
                                            <td>TIN No.</td>
                                            <td><input type="text" name="tin_no" class="text" value="<?php echo set_value('tin_no')?set_value('tin_no'):$Users['tin_no']; ?>"/>
                                            <?php echo form_error('tin_no'); ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td>SSS No.</td>
                                            <td><input type="text" name="sss_no" class="text" value="<?php echo set_value('sss_no')?set_value('sss_no'):$Users['sss_no']; ?>"/>
                                            <?php echo form_error('sss_no'); ?></td>
                                        </tr>

                                        <tr>
                                            <td>Philhealth No.</td>
                                            <td><input type="text" name="philhealth_no" class="text" value="<?php echo set_value('philhealth_no')?set_value('philhealth_no'):$Users['philhealth_no']; ?>"/>
                                            <?php echo form_error('philhealth_no'); ?></td>
                                        </tr>


                                        <tr>
                                            <td>HDMF</td>
                                            <td><input type="text" name="hdmf_no" class="text" value="<?php echo set_value('hdmf_no')?set_value('hdmf_no'):$Users['hdmf_no']; ?>"/>
                                            <?php echo form_error('hdmf_no'); ?></td>
                                        </tr>
                                        <tr>
                                      
                                            <td>&nbsp;</td>
                                            <td><input type="submit" class="btn btn-primary btn-lg active" value="Save" onclick=""/></td>
                                        </tr>
                           	 	</table>
						</div>

	</form>

                      
				<br /> 
					
						</div>
						          
						         
                       		 	<?php echo form_close(); ?>
								<?php echo validation_errors('<p class="error">'); ?>  
                        	<br  />
                        </div>
                         
                    </div>
                </div>
            </div>
        </div>
    <!-- /#page-content-wrapper -->



    


