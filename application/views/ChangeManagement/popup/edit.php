<div id="edit_input_modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content" style="border-radius:6px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Change Input/Output of Functional Requirements ID: 
                        <b> <?php echo $functionNo; ?> </b>
					</h4>
				</div>
				<?php
						if ($typeData == 1 ) {
							$displayInput = 'Input Name';
						} else {
							$displayInput = 'Output Name';
						}
						
				?>

				<form method="post" id="changeInput_form" >
				<input type="hidden" name="changeType" id="changeType" value="edit">
				<input type="hidden" id="inputTableName" name="inputTableName" value= " <?php echo $refTableName ?> " >
				<input type="hidden" id="inputColumnName" name="inputColumnName" value="<?php echo $refColumnName ?> ">
				<input type="hidden" name="oldDataType" id="oldDataType"	value="<?php echo $dataType ?> ">
				<input type="hidden" name="oldDataLength" id="oldDataLength"	value="<?php echo $dataLength ?>">
				<input type="hidden" name="oldScale" 	id="oldScale"	value=" <?php echo $decimalPoint ?>" >
				<input type="hidden" name="oldDefaultValue" id="oldDefaultValue" value="<?php echo $constraintDefault ?> ">
				<input type="hidden" name="oldMin" id="oldMin"	value="<?php echo $constraintMinValue ?> ">
				<input type="hidden" name="oldMax" 	id="oldMax" value="<?php echo $constraintMaxValue ?> ">
				<input type="hidden" id="oldNotNullValue" name="oldNotNullValue" value="<?php echo $constraintNull ?> ">
				<input type="hidden" id="oldUniqueValue" name="oldUniqueValue" value="<?php echo $constraintUnique ?> ">
				<input type="hidden" name="changeFunctionId" id="changeFunctionId" value="<?php echo $functionId ?> ">
				<input type="hidden" name="changeFunction" id="changeFunction" value="<?php echo $functionVersion ?> ">
				<input type="hidden" name="changedataId" id="changedataId" value="<?php echo $dataId ?> ">
				<input type="hidden" name="changeSchemaVersionId" id="changeSchemaVersionId" value="<?php echo $schemaVersionId ?> ">
				<input type="hidden" name="userId" id="userId"  value="<?php echo $_SESSION['userId'] ?> ">
				<input type="hidden" name="user" id="user"  value="<?php echo $_SESSION['username'] ?> ">

					<div class="modal-body" id="input_detail" align="center">
						<table style="width:100%">
							<tr height="40">
								<td>
									<label > <?php echo $displayInput ?>
									<p class="text-green" style="margin:0;"><?php echo $dataName ?></p>
									</label>
								</td>
								<td>
									<input type="text" name="dataName" id="dataName" class="form-control" value= "<?php echo $dataName ?>">
								</td>	
							</tr>
							<tr height="40">
								<td>
									<label>Data Type:
									<p class="text-green" style="margin:0;"><?php echo $dataType ?></p>
									</label>
								</td>
								<td>
								<select name="inputDataType" class="form-control select2" style="width: 100%;" id="inputDataType" value="<?php echo $miscValue1 ?>">
										<option value="">--Please Select--</option>
	            						<?php if(null != $dataTypeCombo) {  ?>
											<?php foreach($dataTypeCombo as $value): ?>
	            								<option value="<?php echo $value['miscValue1']; ?> ">
	            									<?php echo $value['miscValue1']; ?> 
	        									</option>
											<?php endforeach; ?>
	            						<?php } ?> 
					            </select>
								</td>
							</tr>
								<tr height="40">
									<td>
										<label>Data Length: 
										<p class="text-green" style="margin:0;"><?php echo $dataLength ?></p>
										</label>
									</td>
									<td>
										<input type="number" min="1" step="1" name="inputDataLength" id="inputDataLength" class="form-control"/>
									</td>
								</tr>	
								<tr height="40">
									<td>
										<label>Scale (if any*)
										<p class="text-green" style="margin:0;"> <?php echo $decimalPoint ?> </p>
										</label>
									</td>
									<td>
										<input type="number" min="1" step="1" name="inputScale" id="inputScale" class="form-control" placeholder="Enter when data Type is \'Decimal\'"/>
									</td>
								</tr>	
								<tr height="40">
									<td>&nbsp;</td>
									<td>
										<div class="checkbox">
											<label style="font-weight:700;">
											<input type="checkbox" id="inputUnique" name="inputUnique[]" value="Y" <?php ($constraintUnique == "Y")? 'checked' : ''; ?> >Unique
											<p class="text-green" style="margin:0;"><?php echo $constraintUnique ?> </p>
											</label>											
											<label style="font-weight:700;">
											<input type="checkbox" id="inputNotNull" name="inputNotNull[]" value="Y" <?php ($constraintNull == "Y")? 'checked' : ''; ?> >NOT NULL
											<p class="text-green" style="margin:0;"> <?php echo $constraintNull ?> </p>
											</label>
										</div>
									</td>
								</tr>	
								<tr height="40">
									<td>
										<label>Default Value:
										<p class="text-green" style="margin:0;"><?php echo $constraintDefault ?></p>
										</label>
									</td>
									<td>
										<input type="text" id="inputDefault" name="inputDefault" class="form-control"/>
									</td>
								</tr>
								<tr height="40">
									<td>
										<label>Min Value:
										<p class="text-green" style="margin:0;"><?php echo $constraintMinValue ?></p>
										</label>
									</td>
									<td>
										<input type="number" step="0.01" id="inputMinValue" name="inputMinValue" class="form-control"/>
									</td>
								</tr>															
							<tr height="40">
								<td>
									<label>Max Value:
									<p class="text-green" style="margin:0;"><?php echo $constraintMaxValue ?></p>
									</label>
								</td>
								<td>
									<input type="number" step="0.01" id="inputMaxValue" name="inputMaxValue" class="form-control"/>
								</td>
							</tr>
							<tr height="40">
								<td>
									<label>Table Name: 
									<p class="text-green" style="margin:0;"><?php echo $refTableName ?></p>
									</label>
								</td>
							</tr>
							<tr height="40">
								<td>
									<label>Column Name:
									<p class="text-green" style="margin:0;"><?php echo $refColumnName ?></p>
									</label>
								</td>
							</tr>
						</table>	
                    </div>
					<div class="box-body" align="left">
				 	<button type="button" name="saveChange" id="saveChange" class="btn btn-primary">
				 		<i class="fa fa-save"></i> Save
					 </button>
			 	</div>
                </form>
		</div>
	</div>
	<script>
			
			$('#saveChange').on("click", function(event){

				var newUnique = ($('#inputUnique').is(":checked"))? "Y": "N";
				var newNotNull = ($('#inputNotNull').is(":checked"))? "Y": "N";
/*
					if(($('#inputDataType').val() != "int") || ($('#inputDataType').val() != "INT")
					&& ($('#inputDataLength').val() == "")) {
						alert("Please enter at DataType or DataLength field.");
						return false;						
					} */

					if(($('#inputDataType').val() == "")
					&& ($('#inputDataLength').val() == "")
					&& ($('#inputDataLength').val() == "")
					&& ($('#inputScale').val() == "")
					&& ($('#inputScale').val() == "")
					&& (newUnique == $('#oldUniqueValue').val() )
					&& (newNotNull == $('#oldNotNullValue').val() )){
						alert("Please enter at least one field.");
						return false;						
					} else{
						if($('#inputDataType').val() == "" || $('#dataName').val() == "" )
						{
						alert("Please enter all required fields.");
						return false;
						}
					}
					
				//Pass Validation
				$.ajax({
					url: "<?php echo base_url(); ?>index.php/ChangeManagement/saveTempFRInput_edit/",
					method: "POST",
					data: $("#changeInput_form").serialize(),
					success: function(data){
						if(null != data){
							alert(data);
							var result = data.split("|");
							if("error" == result[0]){
								alert(result[1]);
								return false;
							}else{
								//alert(result[1]);
								$('#changeInput_form')[0].reset();  
     							$('#edit_input_modal').modal('hide');
     							$('#inputChangeListTbl').html(data);  
							}
						}else{
							
							alert("There is a problem when save data, Please try to save again.");
							return false; 
						}
					},
					error: function(){ 
						alert("There is a problem when save data, Please try to save again.");

					return true;
					}
				});
			});

	</script>
	
	