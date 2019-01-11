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
                                            <td>Bank Name<span style="color:red;">*</span></td>
                                            <td><input type="text" name="name" class="text" value="<?php echo set_value('name')?set_value('name'):$Users['name']; ?>"/>
                                            <?php echo form_error('name'); ?></td>
                                        </tr>    
                                        <tr>
                                            <td>Code <span style="color:red;">*</span></td>
                                            <td><input type="text" name="code" class="text" value="<?php echo set_value('code')?set_value('code'):$Users['code']; ?>"/>
                                            <?php echo form_error('code'); ?></td>
                                        </tr>
                                        
                                         <tr>
                                            <td>Remarks<span style="color:red;">*</span></td>
                                            <td><input type="text" name="remarks" class="text" value="<?php echo set_value('remarks')?set_value('remarks'):$Users['remarks']; ?>"/>
                                            <?php echo form_error('pwt'); ?></td>
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



    


