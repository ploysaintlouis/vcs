<div class='col-md-12'>
    <div class="box box-success">
        <div class="box-header">
            <h3 class="box-title">Change Function Requirement List </h3>
        </div>
        <div class="box-body">
            <table id="change_result" class="table table-striped table-responsive no-padding">
                <tr>
                    <th style="text-align: left;">#</th>
                    <th>Type of data</th>
                    <th>Data name</th>
                    <th>Data type</th>
                    <th>Data length</th>
                    <th>Scale</th>
                    <th>Default</th>
                    <th>Not NULL</th>
                    <th>Unique</th>
                    <th>Min</th>
                    <th>Max</th>
                    <th>Table Name</th>
                    <th>Field Name</th>
                    <th>Change Type</th>
                </tr>
                <?php
                    // start loop for each 
                    foreach($change_list as $val)
                    {
                ?>
                    <tr>
                        <td><?php echo $val["no"]; ?></td>
                        <td><?php echo $val["type"]; ?></td>
                        <td><?php echo $val["name"]; ?></td>
                        <td><?php echo $val["data_type"]; ?></td>
                        <td><?php echo $val["data_length"]; ?></td>
                        <td><?php echo $val["scale"]; ?></td>
                        <td><?php echo $val["default"]; ?></td>
                        <td><?php echo $val["isNotNull"]; ?></td>
                        <td><?php echo $val["uniq"]; ?></td>
                        <td><?php echo $val["min"]; ?></td>
                        <td><?php echo $val["max"]; ?></td>
                        <td><?php echo $val["table_name"]; ?></td>
                        <td><?php echo $val["field_name"]; ?></td>
                        <td><?php 
                            //for example can add logic to change css and html here
                            echo $val["change_type"] == "Edit" ?
                                  "<button class='btn btn-block bg-orange btn-xs' disabled='disabled'>Edit</button>"
                                : "<button class='btn btn-block bg-green btn-xs' disabled='disabled'>".$val["change_type"]."</button>"; 
                        ?></td>
                    </tr>
                <?php
                    //to end loop for each
                    }
                ?>  
            </table>
        </div>
    </div>
</div>