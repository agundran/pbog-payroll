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
  	
        <div id="container_popup">
			<div class="content">
			<h4><?php echo $title; ?></h4>
			<?php echo $message; ?>
			<?php echo validation_errors(); ?>
			<?php echo form_open($action); ?>
			<div class="data">
			               	<table>

                                        <tr>
                                            <td>Type<span style="color:red;">*</span></td>
                                            <td><input type="text" name="type"  required class="text" value="<?php //echo (isset($Users['type']))?$Users['type']:''; echo ""; ?>"/>
                                            <?php echo form_error('type'); ?>
                                        
                                        </td>
                                        </tr>
                                        
                                        <tr>
                                        
                                            <td>Rate<span style="color:red;">*</span></td>
                                              <td><input type="text" name="rate"  required class="text" value="<?php //echo (isset($Users['rate']))?$Users['rate']:''; echo ""; ?>"/>
                                              <?php echo form_error('rate'); ?>
                                        </td>
                                        </tr>
                                        
                                         <tr>
                                            <td>OT<span style="color:red;">*</span></td>
                                             <td><input type="text" name="OT"  required class="text" value="<?php //echo (isset($Users['OT']))?$Users['OT']:''; echo ""; ?>"/>
                                             <?php echo form_error('OT'); ?>
                                        </td>
                                        </tr>
                                        
                                         <tr>
                                            <td>ND</td>
                                              <td><input type="text" name="ND"   value="<?php //echo (isset($Users['ND']))?$Users['ND']:''; echo ""; ?>"/>
                                              <?php echo form_error('middle_name'); ?>
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

