<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Employee, #Employeelist').addClass('open');
$('#Employee, #Employeelist').children('ul').slideDown();

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
        
	        <center>
			<h4><?php echo $title; ?></h4>
	   		</center>
            
            <div class="search">
			<fieldset>
			<form name='search' action=<?=site_url('employeelist/index');?> method='post'>
				<table>
				<tr>
        			<th></th>
					<th></th>	
                	<th></th>	
           		 </tr>
				<tr> 
					<td>Search</td>
					<td><input name="ShortName" type='text' id="ShortName" class="ShortName" placeholder="Enter Last Name"  /></td>					
			   		<td><input type='submit' class="btn btn-primary btn-lg active"  id='filter' name='' value='Filter' style=""></td>
                    
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
			  
			  
			  
			  echo anchor_popup('employeelist/new_employee/', 'Add new employee',array('class'=>'new_employee'), $attrib) ?>

			   
            &nbsp;&nbsp;&nbsp;&nbsp;
            
            
            
            <?php echo $print_me; ?>
            
           

 
         
            
            
        	<br /><br /><br />
           
    		