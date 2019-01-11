<!--<script>
function closepopup()
   {
	 	window.onunload = function(){
  				window.opener.location.reload();
		};
         window.close ();
        
		}

</script>
-->

<div id="page-content-wrapper">
  <div class="container-fluid">
  	<div class="row">


<div class="col-lg-12">
  	
        <div id="container">
			<div class="content">
			<h4><?php echo $title; ?></h4>
			<?php echo $message; ?>
			<?php echo validation_errors(); ?>
			<?php echo form_open($action); ?>
			<div class="data">
			               	<table>

                                        <tr>
                                            <td>ID<span style="color:red;">*</span></td>
                                            <td><input type="text" name="tbl_id"  required class="text" value="<?php //echo (isset($Users['type']))?$Users['type']:''; echo ""; ?>"/>
                                            <?php echo form_error('tbl_id'); ?>
                                        
                                        </td>
                                        </tr>
                                        
                                        <tr>
                                        
                                            <td>Min Range<span style="color:red;">*</span></td>
                                              <td><input type="text" name="min_range"  required class="text" value="<?php //echo (isset($Users['rate']))?$Users['rate']:''; echo ""; ?>"/>
                                              <?php echo form_error('min_range'); ?>
                                        </td>
                                        </tr>
                                        
                                         <tr>
                                            <td>Max Range<span style="color:red;">*</span></td>
                                             <td><input type="text" name="max_range"  required class="text" value="<?php //echo (isset($Users['OT']))?$Users['OT']:''; echo ""; ?>"/>
                                             <?php echo form_error('max_range'); ?>
                                        </td>
                                        </tr>
                                        
                                         <tr>
                                            <td>Salary Credit</td>
                                              <td><input type="text" name="salary_credit"   value="<?php //echo (isset($Users['ND']))?$Users['ND']:''; echo ""; ?>"/>
                                              <?php echo form_error('salary_credit'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>SS-ER<span style="color:red;">*</span></td>
                                            <td><input type="text" name="ss_er"  required class="text" value="<?php //echo (isset($Users['type']))?$Users['type']:''; echo ""; ?>"/>
                                            <?php echo form_error('ss_er'); ?>
                                        
                                        </td>
                                        </tr>
                                        
                                        <tr>
                                        
                                            <td>SS-EE<span style="color:red;">*</span></td>
                                              <td><input type="text" name="ss_ee"  required class="text" value="<?php //echo (isset($Users['rate']))?$Users['rate']:''; echo ""; ?>"/>
                                              <?php echo form_error('ss_ee'); ?>
                                        </td>
                                        </tr>
                                        
                                         <tr>
                                            <td>SS-Total<span style="color:red;">*</span></td>
                                             <td><input type="text" name="ss_total"  required class="text" value="<?php //echo (isset($Users['OT']))?$Users['OT']:''; echo ""; ?>"/>
                                             <?php echo form_error('ss_total'); ?>
                                        </td>
                                        </tr>
                                        
                                         <tr>
                                            <td>EC-ER</td>
                                              <td><input type="text" name="ec_er"   value="<?php //echo (isset($Users['ND']))?$Users['ND']:''; echo ""; ?>"/>
                                              <?php echo form_error('ec_er'); ?>
                                            </td>
                                        </tr>
                                   
                                        <tr>
                                            <td>Total Contribution/td>
                                              <td><input type="text" name="total_contri"   value="<?php //echo (isset($Users['ND']))?$Users['ND']:''; echo ""; ?>"/>
                                              <?php echo form_error('total_contri'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>SE/VM/OFW TC</td>
                                              <td><input type="text" name="se_vm_ofw_total_contri"   value="<?php //echo (isset($Users['ND']))?$Users['ND']:''; echo ""; ?>"/>
                                              <?php echo form_error('se_vm_ofw_total_contri'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Effective Date</td>
                                              <td><input type="text" name="effectivedate"   value="<?php //echo (isset($Users['ND']))?$Users['ND']:''; echo ""; ?>"/>
                                              <?php echo form_error('effectivedate'); ?>
                                            </td>
                                        </tr>
                                   
                                  
                                        
                                        <tr>
                                      
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

