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


<div class="col-lg-12">
  	
        <div id="container_popup">
			<div class="content">
			<h4><?php echo $title; ?></h4>
			
			<?php echo validation_errors(); ?>
			<?php echo form_open($action); ?>
			<div class="data">
               	<table>
                    <tr>
                        <td>Year<span style="color:red;">*</span></td>
                        <td><input type="text" name="year"  required class="text" value="<?php echo set_value('year')?set_value('year'):$Users['year']; ?>"/>
                        <?php echo form_error('year'); ?>
                        </td>
                    </tr>
                                        
                    <tr>
                        <td>Month<span style="color:red;">*</span></td>
                        
                        <td>
                        <?php 
                        $options1 = array('January' => 'January', 
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

                        //$mon ="echo set_value('month')?set_value('month'):$Users['month']";

                                        
                        ?>
                        <?php echo form_dropdown('month', $options1, set_value('month')?set_value('month'):$Users['month'] );?>      
                        <?php echo form_error('month'); ?>
                        </td>
                        
                        <?php echo form_error('month'); ?>
                        </td>
                    </tr>
                     
                   





                    <tr>
                        <td>Period<span style="color:red;">*</span></td>
                        <td>
                        <?php 
                        $options2 = array('1' => '1 (1 - 15 of the month)', 
                                        '2' => '2 (16 - end of the month)', 
                                       
                                        );
                        ?>
                        <?php echo form_dropdown('period', $options2, set_value('period')?set_value('period'):$Users['period']);?>   
                        
                        <?php echo form_error('period'); ?>
                        </td>
                    </tr>
                     <tr>
                        <td>Type<span style="color:red;">*</span></td>
                        
                        
                        <td>
                        <?php 
                        $options3 = array('Normal' => 'Normal', 
                                        'Special' => 'Special', 
                                       
                                        );
                        ?>
                        <?php echo form_dropdown('payrollrun_type', $options3, set_value('payrollrun_type')?set_value('payrollrun_type'):$Users['payrollrun_type']);?>   
                        
                        <?php echo form_error('payrollrun_type'); ?>
                        </td>
                    </tr>
                  <!--  <tr>
                        <td>Description<span style="color:red;">*</span></td>
                        <td><input type="text" name="description"  required class="text" value="<?php //echo (isset($Users['description']))?$Users['description']:''; echo ""; ?>"/>
                        
                        </td>
                    </tr>
                                    -->
                    <tr>
                        <td>Payout Date</td>
                        <td><input type="text" name="transact_date"   id="datepicker" placeholder="YYYY-MM-DD"  value="<?php echo set_value('transact_date')?set_value('transact_date'):$Users['transact_date']; ?>"/>
                        <?php echo form_error('transact_date'); ?>
                        </td>
                    </tr>
                       <!--  
                    <tr>
                        <td>Status</td>
                        <td>
                        <?php 
                        $options4 = array('Posted' => 'Posted', 
                                        'Unposted' => 'Unposted', 
                                       
                                        );
                        ?>
                        <?php echo form_dropdown('status', $options4, set_value('status')?set_value('status'):$Users['status']  );?>   
                        
                        <?php echo form_error('status'); ?>
                        </td>
                    </tr>
                    -->

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

