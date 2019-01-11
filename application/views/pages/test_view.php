<script>
calculate = function()
{
    var resources = document.getElementById('a1').value;
    var minutes = document.getElementById('a2').value; 
    document.getElementById('a3').value = parseInt(resources)+ parseInt(minutes);
     
   }



 </script> 




  <div id="page-content-wrapper">
    <div class="container-fluid">
  	  <div class="row">
        <div class="container">
          <div class="row">
           <div class="col-sm">
              <div class="col-xs-12 col-sm-12 progress-container">
                  <div class="progress progress-striped active">
                    <div class="progress-bar progress-bar-success" style="width:0%"></div>
                           
                           <?php
                                    echo $Role ;
                                    echo $username

                                    
                           ?>

                    </div>
                  </div>          
           </div>
          </div>
        </div>
       </div>
    </div>
  </div>
