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
                                            <td>Name<span style="color:red;">*</span></td>
                                            <td><input type="text" name="name" class="text" value="<?php echo set_value('name')?set_value('name'):$Users['name']; ?>"/>
                                            <?php echo form_error('name'); ?></td>
                                        </tr>    
                                        <tr>
                                            <td>Rate<span style="color:red;">*</span></td>
                                            <td><input type="text" name="rate" class="text" value="<?php echo set_value('rate')?set_value('rate'):$Users['rate']; ?>"/>
                                            <?php echo form_error('rate'); ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td>Description<span style="color:red;">*</span></td>
                                            <td><input type="text" name="description" class="description" value="<?php echo set_value('description')?set_value('description'):$Users['description']; ?>"/>
                                            <?php echo form_error('description'); ?></td>
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



    


