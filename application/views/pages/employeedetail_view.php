

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
		  alert("User has been updated!");
          setTimeout("window.close();",1000);
		}


</script>


<script>
calculate = function()
{
    //var resources = document.getElementById('philhealt').value;
    var bs = document.getElementById('basic_salary').value;
    
    if (bs >= 15750){
       var sss_contri_default = 581.30;
      document.getElementById('sss_contri').value = sss_contri_default.toFixed(2);

    }




    if (bs <= 40000){ 
    var philh = (parseFloat(bs) * .0275)/2;  
    document.getElementById('philhealth_contri').value = philh.toFixed(2);
    
    var hdmf = 100;
    document.getElementById('hdmf_contri').value = hdmf.toFixed(2);
    
    //var net = parseFloat(bs) - parseFloat(sss_contri)- parseFloat(philh) - parseFloat(hdmf) ;
    //document.getElementById('net_taxable').value = net.toFixed(2);

    } else {
    var mbs = 40000;
    
    var philh = (parseFloat(mbs) * .0275)/2;  
    document.getElementById('philhealth_contri').value = philh.toFixed(2);
    
    var hdmf = 100;
    document.getElementById('hdmf_contri').value = hdmf.toFixed(2);
    
    //var net = parseFloat(bs) - parseFloat(sss_contri)- parseFloat(philh) - parseFloat(hdmf) ;
    //document.getElementById('net_taxable').value = net.toFixed(2);
    }

    if (bs >= 15750){
       var sss_contri_default = 581.30;
      document.getElementById('sss_contri').value = sss_contri_default.toFixed(2);

    }

    
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
                                            <td>Employee No.<span style="color:red;">*</span></td>
                                            <td><input type="text" name="employee_no" class="text" value="<?php echo set_value('employee_no')?set_value('employee_no'):$Users['employee_no']; ?>"/>
                                            <?php echo form_error('employee_no'); ?></td>
                                        </tr>    
                                        <tr>
                                            <td>Last Name<span style="color:red;">*</span></td>
                                            <td><input type="text" name="last_name" class="text" value="<?php echo set_value('last_name')?set_value('last_name'):$Users['last_name']; ?>"/>
                                            <?php echo form_error('last_name'); ?></td>
                                        </tr>
                                        
                                         <tr>
                                            <td>First Name<span style="color:red;">*</span></td>
                                            <td><input type="text" name="first_name" class="text" value="<?php echo set_value('first_name')?set_value('first_name'):$Users['first_name']; ?>"/>
                                            <?php echo form_error('first_name'); ?></td>
                                        </tr>
                                        
                                         <tr>
                                            <td>Middle Name<span style="color:red;">*</span></td>
                                            <td><input type="text" name="middle_name" class="text" value="<?php echo set_value('middle_name')?set_value('middle_name'):$Users['middle_name']; ?>"/>
                                            <?php echo form_error('middle_name'); ?></td>
                                        </tr>

                                    <tr>
                                            <td>Position<span style="color:red;">*</span></td>
                                            <td><input type="text" name="position" class="text" value="<?php echo set_value('position')?set_value('position'):$Users['position']; ?>"/>
                                            <?php echo form_error('position'); ?></td>
                                        </tr>
                                        
                                    <tr>

                                            <td>Department<span style="color:red;">*</span></td>
                                        
                                        
                                          


                                            <td><?php $department_name = $this->employeelistmodel->get_department();?>
                                               <?php echo form_dropdown('department', $department_name, set_value('department')?set_value('department'):$Users['department'] );?>
                                        
                                        </td>
                                        
                                        
                                        </tr>

                                    <tr>
                                            <td>Status<span style="color:red;">*</span></td>
                                            <td><?php $employee_status = $this->employeelistmodel->get_employee_status();?>
                                               <?php echo form_dropdown('status', $employee_status, set_value('status')?set_value('status'):$Users['status'] );?>
                                               </td>
                                        </tr>





                                        <tr>
                                            <td>Employment Type<span style="color:red;">*</span></td>
                                            <td><?php $employee_type = $this->employeelistmodel->get_employee_type();?>
                                               <?php echo form_dropdown('type', $employee_type, set_value('type')?set_value('type'):$Users['type'] );?>
                                               </td>
                                        </tr>

                                      <tr>
                                            <td>Date Hired<span style="color:red;">*</span></td>
                                            <td><input type="text" name="date_hire"  id="datepicker" placeholder="YYYY-MM-DD"  value="<?php echo set_value('date_hire')?set_value('date_hire'):$Users['date_hire']; ?>"/>
                                            <?php echo form_error('date_hire'); ?></td>
                                        </tr>

                                        <tr>
                                            <td>Bank Name<span style="color:red;">*</span></td>
                                            <td><?php $bank_name = $this->employeelistmodel->get_bank_details();?>
                                               <?php echo form_dropdown('bank_name', $bank_name, set_value('bank_name')?set_value('bank_name'):$Users['bank_name'] );?>
                                               </td>
                                        </tr>


                                        
                                        <tr>
                                            <td>Account #<span style="color:red;">*</span></td>
                                            <td><input type="text" name="bank_accnt_no" class="text" value="<?php echo set_value('bank_accnt_no')?set_value('bank_accnt_no'):$Users['bank_accnt_no']; ?>"/>
                                            <?php echo form_error('bank_accnt_no'); ?></td>
                                        </tr>
               


                                         <tr>
                                            <td>SSS No.<span style="color:red;">*</span></td>
                                            <td><input type="text" name="sss" class="text" value="<?php echo set_value('sss')?set_value('sss'):$Users['sss']; ?>"/>
                                            <?php echo form_error('sss'); ?></td>
                                        </tr>


                                           <tr>
                                            <td>HDMF No.<span style="color:red;">*</span></td>
                                            <td><input type="text" name="hdmf" class="text" value="<?php echo set_value('hdmf')?set_value('hdmf'):$Users['hdmf']; ?>"/>
                                            <?php echo form_error('hdmf'); ?></td>
                                        </tr>


                                          <tr>
                                            <td>Philhealth No.<span style="color:red;">*</span></td>
                                            <td><input type="text" name="philhealth" class="text" value="<?php echo set_value('philhealth')?set_value('philhealth'):$Users['philhealth']; ?>"/>
                                            <?php echo form_error('philhealth'); ?></td>
                                        </tr>
                                                                              
                                         <tr>
                                            <td>TIN<span style="color:red;">*</span></td>
                                            <td><input type="text" name="tin" class="text" value="<?php echo set_value('tin')?set_value('tin'):$Users['tin']; ?>"/>
                                            <?php echo form_error('tin'); ?></td>
                                        </tr>


                                                                               

                                          <tr>
                                            <td>Basic Salary<span style="color:red;">*</span></td>
                                            <td><input type="text" name="basic_salary" class="text" id="basic_salary"   value="<?php echo set_value('basic_salary')?set_value('basic_salary'):$Users['basic_salary']; ?>"/>
                                            <?php echo form_error('basic_salary'); ?></td>
                                        </tr>

                                            <tr>
                                            <td>De minimis (non-taxable)</td>
                                            <td><input type="text" name="de_minimis_non" class="text" id="de_minimis_non"   value="<?php echo set_value('de_minimis_non')?set_value('de_minimis_non'):$Users['de_minimis_non']; ?>"/>
                                            <?php echo form_error('de_minimis_non'); ?></td>
                                        </tr>

                                          <tr>
                                            <td>De minimis (taxable)</td>
                                            <td><input type="text" name="de_minimis_taxable" class="text" id="de_minimis_taxable"   value="<?php echo set_value('de_minimis_taxable')?set_value('de_minimis_taxable'):$Users['de_minimis_taxable']; ?>"/>
                                            <?php echo form_error('de_minimis_taxable'); ?></td>
                                        </tr>

                                        <tr>
                                      
                                            <td>&nbsp;</td>
                                            <td><input type="submit" class="btn btn-primary btn-lg active" value="Save" onclick="closepopup"/></td>
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



    


