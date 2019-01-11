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

 <div id="container_payroll">
        
	
      <h4><?php echo $title; ?></h4> 
            <div class="search">
		<fieldset>
			<form>
				<table>
			
			
				</table>
        
			</form>
		</fieldset>
    
            <div class="paging"><?php echo $pagination; ?></div>
            <div class="data" id="datas"><?php echo $table; ?></div>
            <div class="paging"><?php echo $pagination; ?></div>
                 
  </div>  	
            <br />
    	    

			  &nbsp;&nbsp;&nbsp;&nbsp;
            
            
            
            <?php echo $link_back;?>  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;   <?php echo $print_report; ?>




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
			  
			  
			  
              
              
              ?>

			   
          
            
             
        	<br /><br /><br />
           
    		