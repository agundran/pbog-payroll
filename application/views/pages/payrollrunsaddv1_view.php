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
                        <td>Year<span style="color:red;">*</span></td>
                        <td><input type="text" name="year"  required class="text" value="<?php //echo (isset($Users['year']))?$Users['year']:''; echo ""; ?>"/>
                        <?php echo form_error('year'); ?>
                        </td>
                    </tr>
                                        
                    <tr>
                        <td>Month<span style="color:red;">*</span></td>
                        <td><input type="text" name="month"  required class="text" value="<?php //echo (isset($Users['month']))?$Users['month']:''; echo ""; ?>"/>
                        <?php echo form_error('month'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Period<span style="color:red;">*</span></td>
                        <td><input type="text" name="period"  required class="text" value="<?php //echo (isset($Users['period']))?$Users['period']:''; echo ""; ?>"/>
                        <?php echo form_error('period'); ?>
                        </td>
                    </tr>
                     <tr>
                        <td>Type<span style="color:red;">*</span></td>
                        <td><input type="text" name="payrollrun_type"  required class="text" value="<?php //echo (isset($Users['payrollrun_type']))?$Users['payrollrun_type']:''; echo ""; ?>"/>
                        <?php echo form_error('payrollrun_type'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Description<span style="color:red;">*</span></td>
                        <td><input type="text" name="description"  required class="text" value="<?php //echo (isset($Users['description']))?$Users['description']:''; echo ""; ?>"/>
                        <?php echo form_error('description'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Transaction Date</td>
                        <td><input type="text" name="transact_date"   value="<?php //echo (isset($Users['transact_date']))?$Users['transact_date']:''; echo ""; ?>"/>
                        <?php echo form_error('transact_date'); ?>
                        </td>
                    </tr>
                </table>
		    </div>

                         
        <br />
                       
    </div>
        
            <div class="paging"><?php //echo $pagination; ?></div>
                    <div class="data" id="datas"><?php echo $table; ?></div>
                            <table>
                                  <tr>

                                      <td>
                                           
                                      </td>
                                      <td>
                                          
                                      </td>
                                      <td>
                                          
                                      </td>

                                      <td><input type="submit" class="btn btn-primary btn-lg active" value="Save" onclick=""/>
                                      </td>
                                 </tr>
                           	</table>

 <?php echo form_close(); ?>
</div>

<br  />
     				</div>
               </div>
 </div>


            
            
           
		<fieldset>
		<form name='search' action=<?=site_url('payrollruns/index');?> method='post'>
		       
		</form>
	</fieldset>
</div>
    
        
    <!-- /#page-content-wrapper -->

