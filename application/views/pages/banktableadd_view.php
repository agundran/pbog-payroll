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
                                            <td>Bank name<span style="color:red;">*</span></td>
                                            <td><input type="text" name="name"  required class="text" value="<?php //echo (isset($Users['name']))?$Users['name']:''; echo ""; ?>"/>
                                            <?php echo form_error('name'); ?>
                                        
                                        </td>
                                        </tr>
                                        
                                        <tr>
                                        
                                            <td>Code<span style="color:red;">*</span></td>
                                              <td><input type="text" name="code"  required class="text" value="<?php //echo (isset($Users['code']))?$Users['code']:''; echo ""; ?>"/>
                                              <?php echo form_error('code'); ?>
                                        </td>
                                        </tr>
                                        
                                         <tr>
                                            <td>Remarks<span style="color:red;">*</span></td>
                                             <td><input type="text" name="remarks"  required class="text" value="<?php //echo (isset($Users['remarks']))?$Users['remarks']:''; echo ""; ?>"/>
                                             <?php echo form_error('remarks'); ?>
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

