
	
<body>
	<?php
	
	$atts = array(
				
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'no',
              'screenx'   =>  '\'+((parseInt(screen.width) - 800)/2)+\'',
    		  'screeny'   =>  '\'+((parseInt(screen.height) - 600)/2)+\'',
            );

	
	
	
	?>
	
    
	
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
 	<script src="<?php echo base_url(); ?>js/script.js"></script>
    <script src="<?php echo base_url(); ?>js/mypopup.js"></script>
	
	<script type="text/javascript">
			 
		
		
	var Rolename = "<?php echo $Role; ?>";
	
	if(Rolename == "Administrators")					
	$(document).ready(function() 
	{
   			 $('#ChangePassword,#Admin,#AdminManagement,#Payroll-execom').hide();
				
			
	});
    
	else if(Rolename == "SuperAdmin")
		$(document).ready(function() {
			
			 $('').hide();
   			
			});


	else if(Rolename == "Execom")
		$(document).ready(function() {
			
			 $('#Admin,#Reports, #Payroll,#Payrollruns').hide();
   			
			});
		
		
	else if(Rolename == "Operators")
		$(document).ready(function() {
   			 $('#Admin, #Payroll-execom').hide();
			});
	
	
	else
		document.write("Access Denied!"); 
			
			
		
	
    </script> 
    
    
    <div id="wrapper">
        <div id="sidebar-wrapper">
        		<div id="cssmenu">
            		<ul>	
           		 <li>
                        <a href='#'><font size="2" face="verdana" color= "black">Welcome:
                        <font size="2" face="verdana" color="yellow">
                        	<span><?php 
							      echo( str_replace("."," ",($this->session->userdata('username')))); 
							
							      ?>
							</span>
                        	</font>
                            <br>
						
                             <font size="2" face="verdana" color="yellow">
                        	<span><?php //echo $this->session->userdata('role'); ?></span>
                        	</a>
                            </font>
                     	</font>         
                 </li>
                 <?php $data['Role']=$this->session->userdata('role') ?>
                 <li><a href="<?php echo site_url("site/".$data['Role']) ?>"><span><i class="fa fa-home" style="color:#000"></i> Home</span></a></li>
                 <li class='active has-sub' id="Admin"><a href='#'><span><i class="fa fa-laptop" style="color:#000"></i> Administration</span></a>
                    		<ul>
                       			<li class='last' id="AdminManagement"><a href="<?php echo site_url("manageuserlist") ?>"><span>Manage Users</span></a>
								   
                          	</ul>
							
                  </li>
				
				  
                  <li class='active has-sub' id="Settings"><a href='#'><span><i class="fa fa-cog" style="color:#000"></i> Settings </span></a>
                  	    	<ul>
                       				<li class='last' id="companyprofile"><a href="<?php echo site_url("companyprofile") ?> "><span>Company Profile</span></a>
									<li class='last' id="taxtable"><a href="<?php echo site_url("taxtable") ?> "><span>Tax Table</span></a>
									<li class='last' id="ssstable"><a href="<?php echo site_url("ssstable") ?> "><span>SSS Table</span></a>

									<li class='last' id="banktable"><a href="<?php echo site_url("banktable") ?> "><span>Bank List Table</span></a>
									
									<li class='last' id="ottable"><a href="<?php echo site_url("ottable") ?> "><span>Overtime Table</span></a>
									<li class='last' id="othersal"><a href="<?php echo site_url("othersal") ?> "><span>Other Salary Details</span></a>
									
								
							</ul>
                     </li>
                 
				    <li class='active has-sub' id="Employee"><a href='#'><span><i class="fa fa-users" style="color:#000"></i> Employees </span></a>
                  	    	<ul>
                       			<li class='last' id="Employeelist"><a href="<?php echo site_url("employeelist") ?> "><span>Employees</span></a>
									
                     		</ul>
                            		
                  </li>

				    
                  
				  <li class='active has-sub' id="Payroll"><a href='#'><span><i class="fa fa-pencil-square-o" style="color:#000"></i> Payroll Runs</span></a>
                  	    	<ul>
                       			<li class='last' id="Payrollruns"><a href="<?php echo site_url("payrollruns") ?> "><span>Payroll</span></a>
									
                     		</ul>
							
						
                            		
                  </li>
                 
				  <li class='active has-sub' id="Payroll-execom"><a href='#'><span><i class="fa fa-pencil-square-o" style="color:#000"></i> Payroll Runs</span></a>
                  	    	
							 <ul>
                       			<li class='last' id="Papproval"><a href="<?php echo site_url("payroll_execom") ?> "><span>Approval</span></a>
									
                     		</ul>
						
                            		
                  </li>
				 


					 <li class='active has-sub' id="Reports"><a href='#'><span><i class="fa fa-pencil-square-o" style="color:#000"></i> Reports</span></a>
                  	    	<ul>
                       			<li class='last' id="reportsummary"><a href="<?php echo site_url("reportsummary") ?> "><span>Summary</span></a>
									
                     		</ul>

							 <ul>
                       			<li class='last' id="exceltest"><a href="<?php echo site_url("samplereportexcel2") ?> "><span>Test Excel Program</span></a>
									
                     		</ul>
                            		
                  </li> 
					 
					
				   
				   <li><a  href="<?php echo site_url("site/logout")?> "><i class="fa fa-sign-out" style="color:#000"></i> Logout</a></li>
                   
				  
            			</ul>
                </div>         
        </div>   
</body>