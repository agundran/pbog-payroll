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
                        <div id="container_popup">
							<div class="content">
                                <h4><?php echo $title; ?></h4>
                                <?php //echo $message; ?>
                                <?php echo validation_errors(); ?>
                                <?php echo form_open($action); ?>
                                <div class="data">
                                	<table>

                                        <tr>
                                            <td>Overtime ID<span style="color:red;">*</span></td>
                                            <td><input type="text" name="ottable_id" class="text" value="<?php echo set_value('ottable_id')?set_value('ottable_id'):$Users['ottable_id']; ?>"/>
                                            <?php echo form_error('ottable_id'); ?></td>
                                        </tr>    
                                        <tr>
                                            <td>Type<span style="color:red;">*</span></td>
                                            <td><input type="text" name="type" class="text" value="<?php echo set_value('type')?set_value('type'):$Users['type']; ?>"/>
                                            <?php echo form_error('type'); ?></td>
                                        </tr>
                                        
                                         <tr>
                                            <td>Rate<span style="color:red;">*</span></td>
                                            <td><input type="text" name="rate" class="text" value="<?php echo set_value('rate')?set_value('rate'):$Users['rate']; ?>"/>
                                            <?php echo form_error('rate'); ?></td>
                                        </tr>
                                        
                                         <tr>
                                            <td>OT<span style="color:red;">*</span></td>
                                            <td><input type="text" name="OT" class="text" value="<?php echo set_value('OT')?set_value('OT'):$Users['OT']; ?>"/>
                                            <?php echo form_error('OT'); ?></td>
                                        </tr>

                                    <tr>
                                            <td>ND<span style="color:red;">*</span></td>
                                            <td><input type="text" name="ND" class="text" value="<?php echo set_value('ND')?set_value('ND'):$Users['ND']; ?>"/>
                                            <?php echo form_error('ND'); ?></td>
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



    


