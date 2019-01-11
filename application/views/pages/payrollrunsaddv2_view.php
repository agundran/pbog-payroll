
  <script src="<?php echo base_url(); ?>js/jquery-ui.js"></script>
  <link href="<?php echo base_url(); ?>css/jquery-ui.css" rel="stylesheet">
   
  

  


<script>

//$(document).ready(function(){
//Datepicker Popups calender to Choose date


//$(function(){
  //  $( "#datepicker" ).datepicker();
	//Pass the user selected date format 
    //$( "#format" ).change(function() {
     // $( "#datepicker" ).datepicker( "option", "dateFormat", $(this).val() );
    //});
  //});
  
//});

 $( function() {
    $( "#datepicker" ).datepicker();
  } );
</script>


<div id="page-content-wrapper">
  <div class="container-fluid">
  	<div class="row">




<div class="container">
  <div class="row">
    
    <div class="col-sm">
    <p>
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
                        <td>
                        <?php 
                        $options = array('January' => 'January', 
                                        'February' => 'February', 
                                        'March' => 'March',
                                        'April' => 'April', 
                                        'May' => 'May',
                                        'June' => 'June', 
                                        'July' => 'July',
                                        'August' => 'August', 
                                        'September' => 'September',
                                        'October' => 'October', 
                                        'November' => 'November',
                                        'December' => 'December', 
                                        );
                        ?>
                        <?php echo form_dropdown('month', $options);?>      
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
                        <td><input type="text" name="transact_date" id="datepicker" placeholder="YYYY-MM-DD"  value="<?php //echo (isset($Users['transact_date']))?$Users['transact_date']:''; echo ""; ?>"/>
                        <?php echo form_error('transact_date'); ?>
                        </td>
                    </tr>

                   
                </table>
		    </div>
    </div>
    
    
    <div class="col-sm">
   
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

                        </div>
</div>
    
  </div>
</div>


</div>
</div>

</div>





<!--cut off   -->




