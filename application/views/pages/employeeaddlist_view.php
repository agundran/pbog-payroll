<!--

<script>
function closepopup()
     alert("User has been updated!");


       setTimeout("window.close ();",2000);
        
		}

</script>

-->
 <script src="<?php echo base_url(); ?>js/jquery-ui.js"></script>
  <link href="<?php echo base_url(); ?>css/jquery-ui.css" rel="stylesheet">
 
<script>

 $( function() {
    $( "#datepicker" ).datepicker();
  } );

</script>



<script>
calculate = function()
{
    //var resources = document.getElementById('philhealt').value;
    var fn = document.getElementById('first_name').value;
    var ln = document.getElementById('last_name').value;
    var em = '@pboglobal.com.au';

      document.getElementById('Username').value = fn." ".ln;
      //document.getElementById('Email').value = fn." ".ln.em;

    
   }


 </script> 


<div id="page-content-wrapper">
  <div class="container-fluid">
  	<div class="row">


<div class="col-lg-12">
  	
        <div id="container_popup">
			<div class="content">
			<h4><?php echo $title; ?></h4>
			<?php echo $message; ?>
			<?php echo validation_errors(); ?>
			<?php echo form_open($action); ?>
			<div class="data">
			               	<table>

                                        <tr>
                                            <td>Employee No.<span style="color:red;">*</span></td>
                                            <td><input type="text" name="employee_no"  required class="text" value="<?php //echo (isset($Users['employee_no']))?$Users['employee_no']:''; echo ""; ?>"/>
                                            <?php echo form_error('employee_no'); ?>
                                        
                                        </td>
                                        </tr>
                                        
                                        <tr>
                                        
                                            <td>Last Name<span style="color:red;">*</span></td>
                                              <td><input type="text" name="last_name"  required class="text" value=""/>
                                              <?php echo form_error('last_name'); ?>
                                        </td>
                                        </tr>
                                        
                                         <tr>
                                            <td>First Name<span style="color:red;">*</span></td>
                                             <td><input type="text" name="first_name"  required class="text" value=""/>
                                             <?php echo form_error('first_name'); ?>
                                        </td>
                                        </tr>
                                        
                                         <tr>
                                            <td>Middle Name</td>
                                              <td><input type="text" name="middle_name"   value="<?php //echo (isset($Users['middle_name']))?$Users['middle_name']:''; echo ""; ?>"/>
                                              <?php echo form_error('middle_name'); ?>
                                            </td>
                                        </tr>

                                    <tr>
                                            <td>Position</td>
                                              <td><input type="text" name="position"   value="<?php //echo (isset($Users['position']))?$Users['position']:''; echo ""; ?>"/>
            							      <?php echo form_error('position'); ?>
                                        </td>
                                        </tr>
                                        
                                    <tr>
                                            <td>Department</td>

                                               <!--
                                              <td><input type="text" name="department"  value="<?php //echo (isset($Users['department']))?$Users['department']:''; echo ""; ?>"/>
                                              <?php //echo form_error('department'); ?>  -->

                                              <td><?php $department_name = $this->employeelistmodel->get_department();?>
                                               <?php echo form_dropdown('department', $department_name);?>
                                               </td>
                                        </td>
                                        </tr>

                                    <tr>
                                            <td>Status<span style="color:red;">*</span></td>


                                            
                                            <td><?php $employee_status = $this->employeelistmodel->get_employee_status();?>
                                               <?php echo form_dropdown('status', $employee_status);?>
                                               </td>
                                               

                                        </td>
                                        </tr>
                                          




                                        <!--
                                        <tr>
                                               <td valign="top">Username<span style="color:red;">*</span></td>
                                               <td><input type="text" name="Username"  required class="text" onclick="calculate" value="<?php //echo (isset($Users['Username']))?$Users['Username']:''; 
		                                          	echo ""; ?>"/>
                                               </td>
                                                </tr><tr>
                                                <td valign="top">Password<span style="color:red;">*</span></td>
                                                <td><input type="password" name="Password" class="text" required value="<?php// echo "";
		                                             //echo set_value($this->manageusermodel->decryptIt('Password'))?set_value($this->manageusermodel->decryptIt('Password')):$Users['Password']; ?>"/>
                                               <?php //echo form_error('Password'); ?>
                                                </td>
                                                  </tr>
                                                  
                                          -->        
                                                  
                                                  <tr>
                                               <td valign="top">Email<span style="color:red;">*</span></td>
                                                 <td><input type="text" name="Email" class="text" required value="<?php //echo set_value('Email')?set_value('Email'):$Users['Email']; ?>"/>
                                                 <?php echo form_error('Email'); ?>
                                                </td>
                                                   </tr>





                                       <tr>
                                        <td>Employment Type<span style="color:red;">*</span></td>
                                        <td><?php $employee_type = $this->employeelistmodel->get_employee_type();?>
                                               <?php echo form_dropdown('type', $employee_type);?>
                                               </td>
                                       </tr>     

                                      <tr>
                                            <td>Date Hired <span style="color:red;">*</span></td>
                                              <td>
                                              <input type="text" name="date_hire"  id="datepicker" required placeholder="YYYY-MM-DD"/>
                                              <?php echo form_error('date_hire'); ?>
                                        </td>

                                           <tr>
                                        <td>Bank Name</td>
                                        <td><?php $bank_name = $this->employeelistmodel->get_bank_details();?>
                                               <?php echo form_dropdown('bank_name', $bank_name);?>
                                               </td>
                                       </tr> 
                                             
                                       <tr>
                                            <td>Account #</td>
                                              <td><input type="text" name="bank_accnt_no"   value="<?php //echo (isset($Users['bank_accnt_no']))?$Users['bank_accnt_no']:''; echo ""; ?>"/>
                                              <?php echo form_error('bank_accnt_no'); ?>
                                        </td>
                                        </tr>   


                                        </tr>

                                         <tr>
                                            <td>SSS No.<span style="color:red;">*</span></td>
                                              <td><input type="text" name="sss"   value="<?php //echo (isset($Users['philhealth']))?$Users['philhealth']:''; echo ""; ?>"/>
                                              <?php echo form_error('sss'); ?>
                                        </td>
                                        </tr>

                                           <tr>
                                            <td>HDMF No.<span style="color:red;">*</span></td>
                                              <td><input type="text" name="hdmf"   value="<?php //echo (isset($Users['sss']))?$Users['sss']:''; echo ""; ?>"/>
                                              <?php echo form_error('hdmf'); ?>
                                        </td>
                                        </tr>


                                          <tr>
                                            <td>Philhealth No.<span style="color:red;">*</span></td>
                                              <td><input type="text" name="philhealth" id="philhealth"  value="<?php //echo (isset($Users['hdmf']))?$Users['hdmf']:''; echo ""; ?>"/>
                                              <?php echo form_error('philhealt'); ?>
                                        </td>
                                        </tr>
                                                                              
                                         <tr>
                                            <td>TIN<span style="color:red;">*</span></td>
                                              <td><input type="text" name="tin"   value="<?php //echo (isset($Users['tin']))?$Users['tin']:''; echo ""; ?>"/>
                                              <?php echo form_error('tin'); ?>
                                        </td>
                                        </tr>


                                         
                                        </tr>

                                          <tr>
                                            <td>Basic Salary<span style="color:red;">*</span></td>
                                               <!-- <td><input type="text" name="basic_salary"  id="basic_salary"  onblur="calculate()" value="<?php //echo (isset($Users['basic_salary']))?$Users['basic_salary']:''; echo ""; ?>"/>
                                                 -->
                                               <td><input type="text" name="basic_salary" required id="basic_salary"  value="<?php //echo (isset($Users['basic_salary']))?$Users['basic_salary']:''; echo ""; ?>"/>
                                              <?php echo form_error('basic_salary'); ?>
                                        </td>
                                        </tr>
                                         <tr>
                                            <td>De minimis (non-taxable)</td>
                                            <td><input type="text" name="de_minimis_non"  id="de_minimis_non"  value="<?php //echo (isset($Users['basic_salary']))?$Users['basic_salary']:''; echo ""; ?>"/>
                                            <?php echo form_error('de_minimis_non'); ?>
                                        </td>
                                        </tr>

                                           <tr>
                                            <td>De minimis (taxable)</td>
                                            <td><input type="text" name="de_minimis_taxable" id="de_minimis_taxable"  value="<?php //echo (isset($Users['basic_salary']))?$Users['basic_salary']:''; echo ""; ?>"/>
                                            <?php echo form_error('de_minimis_taxable'); ?>
                                        </td>
                                        </tr>

                                     
                                            <td>&nbsp;</td>
                                            <td><input type="submit" class="btn btn-primary btn-lg active" value="Save" onclick=""/></td>
                                        </tr>
                           	 	</table>
						</div>

                           
                            <br />
                          
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo validation_errors('<p class="error">'); ?>  
                            <br  />
     				</div>
               </div>
            </div>
        </div>
    <!-- /#page-content-wrapper -->

