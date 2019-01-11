
        
        <!-- /#sidebar-wrapper -->

      <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-10">
                        
                        <?php 
                               
                               echo '<h3>'.$title .':</h3>';
                               echo '<h1>'.$Users['co_name'].'</h1>';

                               echo '<h4> Nature of Business :'.$Users['nature_business'].'</h4>';
                               echo '<h4> Company Address :'.$Users['address1']. '</h4>';
                               echo '<h4>  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp&nbsp &nbsp&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp' . $Users['address2'].''. $Users['zip_code'].'</h4>';
                               echo '<h4> RDO :'.$Users['rdo'].'</h4>';
                               echo '<h4> email :'.$Users['email'].'</h4>';
                                
                               
                               echo '<h4> Contact Info :</h4>';

                               echo '<h4> &nbsp &nbsp '.$Users['phones'].'&nbsp &nbsp(AU)</h4>';


                               if ($Users['fax'] != "") {
                               echo '<h4> &nbsp &nbsp ' .$Users['fax'].'(fax)</h4>';
                               }
                               echo '<h4>&nbsp</h4>';

                               echo '<h4> TIN :'.$Users['tin_no'].'</h4>';
                               echo '<h4> SSS :'.$Users['sss_no'].'</h4>';
                               echo '<h4> Philhealth :'.$Users['philhealth_no'].'</h4>';
                               echo '<h4> HDMF :'.$Users['hdmf_no'].'</h4>';
                              
                               if ($Role == "Administrators"){
                                echo anchor('companyprofile/update/', 'Update',array('class'=>'new_employee')) ;}
                               
                        ?>
                              
                         
					
                       
                  
                   
                </div>
            </div>
        </div>
    </div>


           	