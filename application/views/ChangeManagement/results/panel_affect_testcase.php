<div class='col-md-12'>
    <div class="box box-success">
        <div class="box-header">
            <h3 class="box-title">The Affected Database Schema</h3>
        </div>
        <div class="box-body">
            <table id="aff_testcase_result" class="table table-striped table-responsive no-padding">
                <tr>
                    <th style="text-align: left;">#</th>
                    <th>Test case No.</th>
                    <th>Change Type</th>
                    <th>Old Version</th>
                </tr>

                <?php
                    // start loop for each 
                    foreach($aff_testcase_list as $val)
                    {
                ?>
                    <tr>
                        <td><?php echo $val["no"]; ?></td>
                        <td><?php echo $val["test_no"]; ?></td>
                        <td><?php echo $val["change_type"]; ?></td>
                        <td><?php echo $val["version"]; ?></td>
                    </tr>
                <?php
                    //to end loop for each
                    }
                ?>  
            </table>
        </div>
    </div>
</div>