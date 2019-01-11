<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Settings, #ssstable').addClass('open');
$('#Settings, #ssstable').children('ul').slideDown();

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




   		 <div id="container">
            
			<h4><?php echo $title; ?></h4>
	   		
            <div class="search">
				<fieldset>
					<form name='search' action=<?=site_url('ssstable/index');?> method='post'>
					<table>
					<tr>
        				<th></th>
						<th></th>	
                		<th></th>	
            		</tr>
					<tr>
						<td>              			 </td>
						<td><input name="ShortName" type='text' id="ShortName" class="ShortName" placeholder="Monthly Salary Credit"/></td>					
			  			<td><input type='submit' class="btn btn-primary btn-lg active"  id='filter' name='' value='Filter' style=""></td>
                
               			
						</tr>
						</table>
        			</form>
				</fieldset>
			</div>
    
            	<div class="paging"><?php //echo $pagination; ?></div>
            	<div class="data" id="datas"><?php echo $table; ?></div>
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
			  
			  
			  
			 // echo anchor_popup('ssstable/new_ssstable/', 'Add new SSS Data',array('class'=>'new_employee'), $attrib) ?>

			   
            
           
    		