<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Settings, #ssstable').addClass('open');
$('#Settings, #ssstable').children('ul').slideDown();



   


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

			   
            
           
    		