<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Settings, #ottable').addClass('open');
$('#Settings, #ottable').children('ul').slideDown();


</script>




   		 <div id="container">
        
	        <center>
			<h4><?php echo $title; ?></h4>
	   		</center>
            
            <div class="search">
		<fieldset>
		<form name='search' action=<?=site_url('ottable/index');?> method='post'>
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
    
            <div class="paging"><?php echo $pagination; ?></div>
            <div class="data" id="datas"><?php echo $table; ?></div>
            <div class="paging"><?php echo $pagination; ?></div>
    
    	
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
			  
			  
			  
			  echo anchor_popup('ottable/new_ottabledata/', 'Add new Overtime Data',array('class'=>'new_employee'), $attrib) ?>

			   
            &nbsp;&nbsp;&nbsp;&nbsp;
            
            
            
      

 
         
            
            
        	<br /><br /><br />
           
    		