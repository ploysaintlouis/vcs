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
								<select name="inputDataType" class="form-control select2" style="width: 100%;" id="inputDataType" value="<?php echo $dataTypeCombo['miscValue1'] ?>">
										<option value="">--Please Select--</option>
	            						<?php if(null != $dataTypeCombo) {  ?>
	            						<?php foreach($dataTypeCombo as $value): ?>
	            								<option value="<?php echo $value['miscValue1']; ?> "">
	            									<?php echo $value['miscValue1']; ?>: <?php echo $value['miscValue1']; ?>
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
                </form>
		</div>
	</div>
<script>

</script>