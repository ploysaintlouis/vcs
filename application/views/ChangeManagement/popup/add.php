<div id="edit_input_modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content" style="border-radius:6px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add New Input/Output of Functional Requirements ID: 
                        <b> <?php echo $functionNo; ?> </b>
					</h4>

                    <form method="post" id="changeInput_form" >
					
						<div class="modal-body" id="input_detail" align="center">
							<input type="hidden" name="changeProjectId" id="changeProjectId" value=<?php echo $projectId ?> >
							<input type="hidden" name="changeFunctionId" id="changeFunctionId" value=<?php echo $functionId ?> >
							<input type="hidden" name="changeFunction" id="changeFunction" value= <?php echo $functionVersion ?> >
							<input type="hidden" name="changeType" id="changeType" value="add">
							<input type="hidden" name="changeSchemaVersionId" id="changeSchemaVersionId" value=""  >
							<input type="hidden" name="changedataId" id="changedataId" value="999999">
				
							<input type="hidden" name="userId" id="userId"  value=<?php echo $_SESSION['userId'] ?> >
							<input type="hidden" name="user" id="user"  value=<?php echo $_SESSION['username'] ?> >
							<input type="hidden" name="changeSchemaId" id="changeSchemaId" value= "" >

							<table style="width:100%">
							<tr height="40">
					
								<td>
									<div class="radio">
										<label style="font-weight:700;">
										<input type="radio" id="changetypeData" name="changetypeData" value="1">Input Name
										</label>
														
										<label style="font-weight:700;">
										<input type="radio" id="changetypeData" name="changetypeData" value="2">Output Name
										</label>
				
									</div>
								</td>	
								<td>
									<input type="text" name="dataName" id="dataName" class="form-control">
								</td>	
							</tr>
							<tr height="40">
								<td>
									<label>Data Type:
									<p class="text-green" style="margin:0;"></p>
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
									<p class="text-green" style="margin:0;"></p>
									</label>
								</td>
								<td>
									<input type="number" min="1" step="1" name="inputDataLength" id="inputDataLength" class="form-control"/>
								</td>
							</tr>
							<tr height="40">
								<td>
									<label>Scale (if any*)
									<p class="text-green" style="margin:0;"></p>
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
										<input type="checkbox" id="inputUnique" name="inputUnique[]" >Unique
										<p class="text-green" style="margin:0;"></p>
										</label>
										
										<label style="font-weight:700;">
										<input type="checkbox" id="inputNotNull" name="inputNotNull[]" >NOT NULL
										<p class="text-green" style="margin:0;"></p>
										</label>
									</div>
								</td>
							</tr>
							<tr height="40">
								<td>
									<label>Default Value:
									<p class="text-green" style="margin:0;"></p>
									</label>
								</td>
								<td>
									<input type="text" id="inputDefault" name="inputDefault" class="form-control"/>
								</td>
							</tr>
							<tr height="40">
								<td>
									<label>Min Value:
									<p class="text-green" style="margin:0;"></p>
									</label>
								</td>
								<td>
									<input type="number" step="0.01" id="inputMinValue" name="inputMinValue" class="form-control"/>
								</td>
							</tr>
							<tr height="40">
								<td>
									<label>Max Value:
									<p class="text-green" style="margin:0;"></p>
									</label>
								</td>
								<td>
									<input type="number" step="0.01" id="inputMaxValue" name="inputMaxValue" class="form-control"/>
								</td>
							</tr>
							<tr height="40">
								<td>
									<label>Table Name:
									<p class="text-green" style="margin:0;"></p>
									</label>
								</td>
								<td>
									<input type="text" id="inputTableName" name="inputTableName" class="form-control" />
								</td>
							</tr>
							<tr height="40">
								<td>
									<label>Column Name:
									<p class="text-green" style="margin:0;"></p>
									</label>
								</td>
								<td>
									<input type="text" id="inputColumnName" name="inputColumnName" class="form-control"/>
								</td>
							</tr>
							</table>						
						</div>
							<div class="col-sm-1">
							<button type="button" name="saveChange" id="saveChange" class="btn btn-primary">
								<i class="fa fa-save"></i>Save
							</button>
							</div>
                	</form>
		</div>
	</div>
	
<script>
    //$(function(){
		$('#saveChange').on("click", function(event){

                $.ajax({
					url: "<?php echo base_url(); ?>index.php/ChangeManagement/saveTempFRInput_add/",
                    method: "POST",
					data: $("#changeInput_form").serialize(),
					//alert(data);
					success: function(data){
						
						if(null != data){
							alert(data);
							var result = data.split("|");
							if("error" == result[0]){
								alert(result[1]);
								return false;
							}else{
								//alert(result[1]);
								//alert(data);
								alert("Done.");
								$('#changeInput_form')[0].reset();  
     							$('#edit_input_modal').modal('hide');
     							$('#inputChangeListTbl').html(data);  
							}
						}else{
							alert("There is a problem when save Data, Please try to save again.");
							return false; 
						}
					},
					error: function(){
						//alert(data);
						alert("There is a problem when save data, Please try to save again.");
						return false;
					}
				});
		});
	//});
</script>