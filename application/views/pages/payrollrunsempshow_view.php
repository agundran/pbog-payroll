

<script src="<?php echo base_url(); ?>js/jquery2.min.js"></script>
<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Payroll, #Payrollruns').addClass('open');
$('#Payroll, #Payrollruns').children('ul').slideDown();

</script>




   		 <div id="container">
             <div class="search">
				<fieldset>
                
                
                <?php echo validation_errors(); ?>
			    <?php echo form_open($action); ?>
				<table>
					<tr>
        		<th><?php echo $title; ?></th>
				<th></th>	
                <th></th>	
           		 </tr>
			</table>
        

</div>
    

            <div class="paging"><?php echo $pagination; ?></div>
            <div class="data" id="datas"><?php echo $table; ?></div>
            <div class="paging"><?php echo $pagination; ?></div>



          

             <tr>
                    <td> </td>
                     <td><input type="submit" class="btn btn-primary btn-lg active" value="Proceed" onclick=""/></td>
            </tr>

            		 <?php echo form_close(); ?>
	            </fieldset>
            </table>

    	
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
             
            
                          <br />
                          <br />
            &nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            <?php echo $link_back; ?>
       

             <br />
             <br />
             <br />
             
            <?php
             
            //var_dump($choices);

            ?>

 
        	<br /><br /><br />
           
    		

            


            
            
            
           
            



                