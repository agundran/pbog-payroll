<script>
function closepopup()
   {
  		  //window.opener.location.reload();
		  alert("User has been updated!");
          
          setTimeout("window.close();",1000);

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
                                            <td>Min Salary<span style="color:red;">*</span></td>
                                            <td><input type="text" name="salary_min" class="text" value="<?php echo set_value('salary_min')?set_value('salary_min'):$Users['salary_min']; ?>"/>
                                            <?php echo form_error('salary_min'); ?></td>
                                        </tr>    
                                        <tr>
                                            <td>Max Salary<span style="color:red;">*</span></td>
                                            <td><input type="text" name="salary_max" class="text" value="<?php echo set_value('salary_max')?set_value('salary_max'):$Users['salary_max']; ?>"/>
                                            <?php echo form_error('salary_max'); ?></td>
                                        </tr>
                                        
                                         <tr>
                                            <td>Prescribed Withholding Tax<span style="color:red;">*</span></td>
                                            <td><input type="text" name="pwt" class="text" value="<?php echo set_value('pwt')?set_value('pwt'):$Users['pwt']; ?>"/>
                                            <?php echo form_error('pwt'); ?></td>
                                        </tr>
                                        
                                         <tr>
                                            <td>+ Percentage<span style="color:red;">*</span></td>
                                            <td><input type="text" name="multiplier" class="text" value="<?php echo set_value('multiplier')?set_value('multiplier'):$Users['multiplier']; ?>"/>
                                            <?php echo form_error('multiplier'); ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td>Description<span style="color:red;">*</span></td>
                                            <td><input type="text" name="tax_desc" class="text" value="<?php echo set_value('tax_desc')?set_value('tax_desc'):$Users['tax_desc']; ?>"/>
                                            <?php echo form_error('tax_desc'); ?></td>
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



    


