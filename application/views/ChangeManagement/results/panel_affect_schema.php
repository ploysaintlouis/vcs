<div class='col-md-12'>
    <div class="box box-success">
        <div class="box-header">
            <h3 class="box-title">The Affected Database Schema</h3>
        </div>
        <div class="box-body">
            <table id="aff_schema_result" class="table table-striped table-responsive no-padding">
                <tr>
                    <th style="text-align: left;">#</th>
                    <th>Table Name</th>
                    <th>Column Name</th>
                    <th>Change Type</th>
                    <th>Old Version</th>
                </tr>

                <?php
                    $version_title = "V.";
                    // start loop for each 
                    foreach($aff_schema_list as $val)
                    {
                ?>
                    <tr>
                        <td><?php echo $val["no"]; ?></td>
                        <td><?php echo $val["table_name"]; ?></td>
                        <td><?php echo $val["column_name"]; ?></td>
                        <td><?php echo $val["change_type"]; ?></td>
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