<div class='col-md-12'>
    <div class="box box-success">
        <div class="box-header">
            <h3 class="box-title">The Affected Functional Requirement</h3>
        </div>
        <div class="box-body">
            <table id="aff_fr_panel" class="table table-striped table-responsive no-padding">
                <tr>
                    <th style="text-align: left;">#</th>
                    <th>Functional Req No.</th>
                    <th>Change Type</th>
                    <th>Old Version</th>
                </tr>

                <?php
                    // start loop for each 
                    foreach($aff_fr_panel as $val)
                    {
                ?>
                    <tr>
                        <td><?php echo $val["no"]; ?></td>
                        <td><?php echo $val["fr_no"]; ?></td>
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