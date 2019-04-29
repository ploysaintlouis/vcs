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
                        <?php if($val["typeData"] == '1'){
                            $typeData = "Input";
                        }else{
                            $typeData = "Output";               
                        }
                        ?>
                        <td><?php echo $typeData; ?></td>
                        <td><?php echo $val["dataName"]; ?></td>
                        <td><?php echo $val["newDataType"]; ?></td>
                        <td><?php echo $val["newDataLength"]; ?></td>
                        <td><?php echo $val["newScaleLength"]; ?></td>
                        <td><?php echo $val["newDefaultValue"]; ?></td>
                        <td><?php echo $val["newNotNull"]; ?></td>
                        <td><?php echo $val["newUnique"]; ?></td>
                        <td><?php echo $val["newMinValue"]; ?></td>
                        <td><?php echo $val["newMaxValue"]; ?></td>
                        <td><?php echo $val["tableName"]; ?></td>
                        <td><?php echo $val["columnName"]; ?></td>
                        <td><?php 
                            //for example can add logic to change css and html here
                            echo $val["changeType"] == "Edit" ?
                                  "<button class='btn btn-block bg-orange btn-xs' disabled='disabled'>Edit</button>"
                                : "<button class='btn btn-block bg-green btn-xs' disabled='disabled'>".$val["changeType"]."</button>"; 
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