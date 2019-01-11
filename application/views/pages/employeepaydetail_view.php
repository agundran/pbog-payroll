

<script src="<?php echo base_url(); ?>js/jquery-ui.js"></script>
  <link href="<?php echo base_url(); ?>css/jquery-ui.css" rel="stylesheet">
 
<script>
 $( function() {
    $( "#datepicker" ).datepicker();
  } );
</script>


<script type="text/javascript">
function closepopup()
   {
  		  //window.opener.location.reload();
		 // alert("User has been updated!");
         // delay(2000);
          mywindow.close();
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
                                <?php //echo validation_errors(); ?>
                                <?php echo form_open(); ?>
                                <div class="data">
                                	<table>

                                           <tr>
                                            <td>Employment Type</td>
                                            
                                            <td><input type="text" name="type" class="text" id="type"   readonly value="<?php echo set_value('type')?set_value('type'):$Users['type']; ?>"/>
                                            <?php echo form_error('type'); ?></td>

                                           <!-- <td><?php //$employee_type = $this->employeelistmodel->get_employee_type();?>
                                               <?php //echo form_dropdown('type', $employee_type, set_value('type')?set_value('type'):$Users['type'] );?>
                                               </td> -->


                                        </tr>
                                        
                                        
                                        <tr>
                                            <td>Basic Salary</td>
                                            <td><input type="text" name="basic_salary" class="text" id="basic_salary"   readonly value="<?php echo set_value('basic_salary')?set_value('basic_salary'):$Users['basic_salary']; ?>"/>
                                            <?php echo form_error('basic_salary'); ?></td>
                                        </tr>

                                         <tr>
                                            <td>De minimis (non-taxable)</td>
                                            <td><input type="text" name="de_minimis_non" class="text" id="de_minimis_non"   readonly value="<?php echo set_value('de_minimis_non')?set_value('de_minimis_non'):$Users['de_minimis_non']; ?>"/>
                                            <?php echo form_error('de_minimis_non'); ?></td>
                                        </tr>

                                         <tr>
                                            <td>De minimis (taxable)</td>
                                            <td><input type="text" name="de_minimis_taxable" class="text" id="de_minimis_taxable"   readonly value="<?php echo set_value('de_minimis_taxable')?set_value('de_minimis_taxable'):$Users['de_minimis_taxable']; ?>"/>
                                            <?php echo form_error('de_minimis_taxable'); ?></td>
                                        </tr>

                                         <tr>
                                            <td>Daily Rate</td>
                                            <td><input type="text" name="daily_rate" class="text" id="daily_rate"   readonly value="<?php echo set_value('daily_rate')?set_value('daily_rate'):$Users['daily_rate']; ?>"/>
                                            <?php echo form_error('daily_rate'); ?></td>
                                        </tr>

                                         <tr>
                                            <td>Hourly Rate</td>
                                            <td><input type="text" name="hourly_rate" class="text" id="hourly_rate"   readonly value="<?php echo set_value('hourly_rate')?set_value('hourly_rate'):$Users['hourly_rate']; ?>"/>
                                            <?php echo form_error('hourly_rate'); ?></td>
                                        </tr>


                                         <tr>
                                            <td>SSS Contribution</td>
                                             <td><input type="text" name="sss_contri" class="text" id="sss_contri"  readonly value="<?php echo set_value('sss_contri')?set_value('sss_contri'):$Users['sss_contri']; ?>"/>
                                            <?php echo form_error('sss_contri'); ?></td>
                                            
                                        
                                        </tr>                                        
                                           <tr>
                                            <td>Philhealth Contribution</td>
                                            <td><input type="text" name="philhealth_contri" class="text" id="philhealth_contri" readonly value="<?php echo set_value('philhealth_contri')?set_value('philhealth_contri'):$Users['philhealth_contri']; ?>"/>
                                            <?php echo form_error('philhealth_contri'); ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td>HDMF Contribution</td>
                                            <td><input type="text" name="hdmf_contri" class="text" id="hdmf_contri" readonly value="<?php echo set_value('hdmf_contri')?set_value('hdmf_contri'):$Users['hdmf_contri']; ?>"/>
                                            <?php echo form_error('hdmf_contri'); ?></td>
                                        </tr>

                                      
                                        
                                        <tr>
                                      
                                      <td>&nbsp;</td>


                                      <td><button onclick="closepopup()">Close</button></td>


                                      
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



    


