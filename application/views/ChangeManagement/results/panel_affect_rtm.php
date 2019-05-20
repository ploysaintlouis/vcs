<div class='col-md-12'>
    <div class="box box-success">
        <div class="box-header">
            <h3 class="box-title">The Affected RTM</h3>
        </div>
        <div class="box-body">
            <table id="aff_rtm_result" class="table table-striped table-responsive no-padding">
                <tr>
                    <th style="text-align: left;">#</th>
                    <th>Function No.</th>
                    <th>Function Version</th>
                    <th>Test case No.</th>
                    <th>Test Case Version</th>
                </tr>

                <?php
                $version_title = 'V.';
                    // start loop for each 
                    foreach($aff_rtm_list as $val)
                    {
                ?>
                    <tr>
                        <td><?php echo $val["no"]; ?></td>
                        <td><?php echo $val["fr_no"]; ?></td>
                        <td><?php echo $version_title.$val["fr_version"]; ?></td>
                        <td><?php echo $val["test_no"]; ?></td>
                        <td><?php echo $version_title.$val["version"]; ?></td>
                    </tr>
                <?php
                    //to end loop for each
                    }
                ?>  
            </table>
        </div>
    </div>
</div>