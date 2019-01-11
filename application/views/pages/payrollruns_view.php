<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Payroll, #Payrollruns').addClass('open');
$('#Payroll, #Payrollruns').children('ul').slideDown();

 
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
		<form name='search' action=<?=site_url('payrollruns/index');?> method='post'>
		<table>
			<tr>
        		<th></th>
				<th></th>	
                <th></th>	
            </tr>
			<tr>
				<td>Search by year</td>
				<td><input name="ShortName" type='text' id="ShortName" class="ShortName" placeholder="Year"  /></td>					
			   	<td><input type='submit' class="btn btn-primary btn-lg active"  id='filter' name='' value='Search' style=""> </td>
                
                
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
			  
			  
			  
			  
			?>

			   
            &nbsp;&nbsp;&nbsp;&nbsp;
            
            
            
            
            <?php echo anchor_popup('payrollruns/new_payrollrun/', 'Create new Payroll Run',array('class'=>'new_payrollrun'),$attrib) ?> 
            
            

 
         
            
            
        	<br /><br /><br />
           
    		