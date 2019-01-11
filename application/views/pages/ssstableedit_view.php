<script>
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
                        <div id="container_popup">
							<div class="content">
                                <h4><?php echo $title; ?></h4>
                                <?php //echo $message; ?>
                                <?php echo validation_errors(); ?>
                                <?php echo form_open($action); ?>
                                <div class="data">
                                	<table>

                                        <tr>
                                            <td>Min Range<span style="color:red;">*</span></td>
                                            <td><input type="text" name="min_range" class="text" value="<?php echo set_value('min_range')?set_value('min_range'):$Users['min_range']; ?>"/>
                                            <?php echo form_error('min_range'); ?></td>
                                        </tr>    
                                        <tr>
                                            <td>Max Range<span style="color:red;">*</span></td>
                                            <td><input type="text" name="max_range" class="text" value="<?php echo set_value('max_range')?set_value('max_range'):$Users['max_range']; ?>"/>
                                            <?php echo form_error('max_range'); ?></td>
                                        </tr>
                                        
                                         <tr>
                                            <td>Salary Credit<span style="color:red;">*</span></td>
                                            <td><input type="text" name="salary_credit" class="text" value="<?php echo set_value('salary_credit')?set_value('salary_credit'):$Users['salary_credit']; ?>"/>
                                            <?php echo form_error('salary_credit'); ?></td>
                                        </tr>
                                        
                                         <tr>
                                            <td>SS-ER<span style="color:red;">*</span></td>
                                            <td><input type="text" name="ss_er" class="text" value="<?php echo set_value('ss_er')?set_value('ss_er'):$Users['ss_er']; ?>"/>
                                            <?php echo form_error('ss_er'); ?></td>
                                        </tr>

                                    <tr>
                                            <td>SS-EE<span style="color:red;">*</span></td>
                                            <td><input type="text" name="ss_ee" class="text" value="<?php echo set_value('ss_ee')?set_value('ss_ee'):$Users['ss_ee']; ?>"/>
                                            <?php echo form_error('ss_ee'); ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td>SS-Total<span style="color:red;">*</span></td>
                                            <td><input type="text" name="ss_total" class="text" value="<?php echo set_value('ss_total')?set_value('ss_total'):$Users['ss_total']; ?>"/>
                                            <?php echo form_error('ss_total'); ?></td>
                                        </tr>
                                        <tr>
                                            <td>EC-ER<span style="color:red;">*</span></td>
                                            <td><input type="text" name="ec_er" class="text" value="<?php echo set_value('ec_er')?set_value('ec_er'):$Users['ec_er']; ?>"/>
                                            <?php echo form_error('ss_total'); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Total Contribution<span style="color:red;">*</span></td>
                                            <td><input type="text" name="total_contri" class="text" value="<?php echo set_value('total_contri')?set_value('total_contri'):$Users['total_contri']; ?>"/>
                                            <?php echo form_error('ec_er'); ?></td>
                                        </tr>
                                        
                                         <tr>
                                            <td>SE/VM/OFW TC<span style="color:red;">*</span></td>
                                            <td><input type="text" name="se_vm_ofw_total_contri" class="text" value="<?php echo set_value('se_vm_ofw_total_contri')?set_value('se_vm_ofw_total_contri'):$Users['se_vm_ofw_total_contri']; ?>"/>
                                            <?php echo form_error('rate'); ?></td>
                                        </tr>
                                        
                                         

                                    <tr>
                                            <td>Effective Date<span style="color:red;">*</span></td>
                                            <td><input type="text" name="effectivedate" class="text" value="<?php echo set_value('effectivedate')?set_value('effectivedate'):$Users['effectivedate']; ?>"/>
                                            <?php echo form_error('effectivedate'); ?></td>
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



    


