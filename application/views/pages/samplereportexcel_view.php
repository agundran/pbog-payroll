<div class="container">
    <table class="table table-hover tablesorter">
        <thead>
            <tr>
                <th class="header">Emp #</th>
                <th class="header">Last Name</th>                           
                <th class="header">First Name</th>                      
                <th class="header">position</th>
                <th class="header">Department</th>
                <th class="header">status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($employeeInfo) && !empty($employeeInfo)) {
                foreach ($employeeInfo as $key => $element) {
                    ?>
                    <tr>
                        <td><?php echo $element['employee_no']; ?></td>   
                        <td><?php echo $element['last_name']; ?></td> 
                        <td><?php echo $element['first_name']; ?></td>                       
                        <td><?php echo $element['position']; ?></td>
                        <td><?php echo $element['department']; ?></td>
                        <td><?php echo $element['status']; ?></td>
                        
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="5">There is no employee.</td>    
                </tr>
            <?php } ?>
 
        </tbody>
    </table>
    <a class="pull-right btn btn-primary btn-xs" href="<?php echo site_url()?>/samplereportexcel/createxls"><i class="fa fa-file-excel-o"></i> Export Data</a>
</div> 