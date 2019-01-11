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
                        <div id="container">
							<div class="content">
                                <h4><?php echo $title; ?></h4>
                                <?php //echo $message; ?>
                                <?php echo validation_errors(); ?>
                                <?php echo form_open($action); ?>
                                <div class="data">
                                	<table>

                                        <tr>
                                            <td>Salary Range<span style="color:red;">*</span></td>
                                            <td><input type="text" name="description" class="text" value="<?php echo set_value('description')?set_value('description'):$Users['description']; ?>"/>
                                            <?php echo form_error('description'); ?></td>
                                        </tr>    
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
                                            <td>Salary Base<span style="color:red;">*</span></td>
                                            <td><input type="text" name="salary_base" class="text" value="<?php echo set_value('salary_base')?set_value('salary_base'):$Users['salary_base']; ?>"/>
                                            <?php echo form_error('salary_base'); ?></td>
                                        </tr>

                                         <tr>
                                            <td>Total Monthly Contribution<span style="color:red;">*</span></td>
                                            <td><input type="text" name="total_monthly_premium" class="text" value="<?php echo set_value('total_monthly_premium')?set_value('total_monthly_premium'):$Users['total_monthly_premium']; ?>"/>
                                            <?php echo form_error('total_monthly_premium'); ?></td>
                                        </tr>

                                         <tr>
                                            <td>Employee Share<span style="color:red;">*</span></td>
                                            <td><input type="text" name="ee_share" class="text" value="<?php echo set_value('ee_share')?set_value('ee_share'):$Users['ee_share']; ?>"/>
                                            <?php echo form_error('ee_share'); ?></td>
                                        </tr>
                                        
                                         <tr>
                                            <td>Employer Share<span style="color:red;">*</span></td>
                                            <td><input type="text" name="er_share" class="text" value="<?php echo set_value('er_share')?set_value('er_share'):$Users['er_share']; ?>"/>
                                            <?php echo form_error('er_share'); ?></td>
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



    


