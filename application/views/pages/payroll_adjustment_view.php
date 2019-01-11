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
                                            <td>Salary Adjustments</td>
                                            <td><input type="text" name="salary_adjust" class="text" readonly="readonly" value="<?php echo set_value('salary_adjust')?set_value('salary_adjust'):$Employee_paydetails['salary_adjust']; ?>"/>
                                            <?php echo form_error('salary_adjust'); ?></td>
                                        </tr>    
                                        
                                        <tr>
                                            <td>Day(s) Absent Deductions</td>
                                            <td><input type="number" name="days_absent" class="text" readonly="readonly" value="<?php echo set_value('days_absent_rate')?set_value('days_absent_rate'):$Employee_paydetails['days_absent_rate']; ?>"/>
                                            <?php echo form_error('days_absent_rate'); ?></td>
                                        </tr> 

                                        <tr>
                                            <td>Minute(s) Late Deductions</td>
                                            <td><input type="number" name="minutes_late" class="text" readonly="readonly" value="<?php echo set_value('minutes_late_rate')?set_value('minutes_late_rate'):$Employee_paydetails['minutes_late_rate']; ?>"/>
                                            <?php echo form_error('minutes_late_rate'); ?></td>
                                        </tr> 
                                        
                                        
                                        <tr>


                                            <td>SSS Loan</td>
                                            <td><input type="text" name="sss_loan" class="text"readonly="readonly"  value="<?php echo set_value('sss_loan')?set_value('sss_loan'):$Employee_paydetails['sss_loan']; ?>"/>
                                            <?php echo form_error('sss_loan'); ?></td>
                                        </tr>
                                        
                                         <tr>
                                            <td>HDMF Loan</td>
                                            <td><input type="text" name="hdmf_loan" class="text" readonly="readonly" value="<?php echo set_value('hdmf_loan')?set_value('hdmf_loan'):$Employee_paydetails['hdmf_loan']; ?>"/>
                                            <?php echo form_error('hdmf_loan'); ?></td>
                                        </tr>
                                        
                                         <tr>
                                            <td>Other Deductions</td>
                                            <td><input type="text" name="other_deduc" class="text" readonly="readonly" value="<?php echo set_value('other_deduc')?set_value('other_deduc'):$Employee_paydetails['other_deduc']; ?>"/>
                                            <?php echo form_error('other_deduc'); ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td>Notes</td>
                                            <td><input type="text" name="notes" class="text" readonly="readonly" value="<?php echo set_value('notes')?set_value('notes'):$Employee_paydetails['notes']; ?>"/>
                                            <?php echo form_error('notes'); ?></td>
                                        </tr>
                                        <!--
                                        <tr>
                                            <td>Notes</td>
                                            <td><textarea rows="2" cols="10" name="notes" class="text" value="<?php echo set_value('notes')?set_value('notes'):$Employee_paydetails['notes']; ?>">
                                            <?php //echo form_error('notes'); ?></td>
                                        </tr>
                                        
                                        <tr>
                                      
                                            <td>&nbsp;</td>
                                            <td><input type="submit" class="btn btn-primary btn-lg active" value="Save" onclick=""/></td>
                                        </tr>-->
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



    


