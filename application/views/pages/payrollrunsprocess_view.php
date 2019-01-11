<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Payroll, #Payrollruns').addClass('open');
$('#Payroll, #Payrollruns').children('ul').slideDown();

 $(document).ready(function() { 
		        $("#Range").change(function(){
            		var mydata = $(this).val();
					var post_url = "<?php echo base_url(); ?>index.php/employeelist/get_discount/"+ mydata;
                   
					
					$.ajax({
                   		url:post_url,
						type: "POST",
						dataType:'json',
                		data: mydata,
					  	success: function(result){
                  			$("#datas").val(result);},
        				error: function(result ) {
						     alert(result);	}
                    
                    });
                });
	     }).change();

   


</script>


<div id="page-content-wrapper">
  <div class="container-fluid">
  	<div class="row">

 <div id="container">
        
	        
			<h4><?php echo $title; ?></h4>
	   		
            <div class="search">
		<fieldset>
		<form name='search' action=<?=site_url('payrollruns/index');?> method='post'>
		<table>
			<tr>
        		<th></th>
				<th></th>	
                <th></th>	
            </tr>
			<tr>
									
			   <!-- <td><input name="SysCode"  type='text' id="SysCode"  value="<?php echo $selectedSysCode; ?>" /></td>					
				-->
				<td>
                
                </td>
                
                <td>
                </td>
			</tr>
		</table>
        
		</form>
	</fieldset>
</div>
    
            <div class="paging"><?php //echo $pagination; ?></div>
            <div class="data" id="datas"><?php //echo $table; ?></div>
            <div class="paging"><?php //echo $pagination; ?></div>
    
    	
            <br />
    	    
              <?php 
			  
			  $attrib = array(
				
              'width'      => '1500',
              'height'     => '1000',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'no',
              'screenx'   =>  '10',
    		  'screeny'   =>  '10',
            );
			  
			  
			  
			  echo anchor_popup('payrollruns/new_payrollrun/', 'Process Payroll',array('class'=>'new_payrollrun'),$attrib) ?>

			   
            &nbsp;&nbsp;&nbsp;&nbsp;
            
            
            
            <?php// echo $print_me; ?>
            
            <?php//





//echo form_dropdown('sel', $options,'');
?>

 
         
            
            
        	<br /><br /><br />
           
    		