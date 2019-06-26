<section class="content-header">
	<h1>
		<span class="glyphicon glyphicon-tasks"></span>
		Change Request Information
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
		<li><a href="#">Change Management</a></li>
		<li><a href="#">Rollback</a></li>
		<li class="active">Change Request Detail</li>
	</ol>

	<!-- Main content -->
	<div class="row">
		<div class="col-md-12">
			<?php if(!empty($success_message)) { ?>
			<div class="alert alert-success alert-dismissible" style="margin-top: 3px;margin-bottom: 3px;">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
				<?php echo $success_message; ?>
			</div>
			<?php } ?>
			<?php if(!empty($error_message)) { ?>
			<div class="alert alert-danger alert-dismissible" style="margin-top: 3px;margin-bottom: 3px;">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
				<?php echo $error_message; ?>
			</div>
			<?php } ?>
			<input type="hidden" id="headerchangeRequestNo" name="headerchangeRequestNo" value="<?php echo $headerInfo['changeRequestNo'] ?>">

			<div class="box box-solid">
                <div class="box-body">
                	<div class="row">
                		<div class="col-sm-12">
                			<div class="form-group">
                				<h2 class="page-header">
                					<i class="fa fa-tag"></i>
                					Change Request No. : 
                					<b>
                					<?php echo isset($headerInfo['changeRequestNo'])? $headerInfo['changeRequestNo']: ""; ?>
                					</b>
                					<small class="pull-right">
                						Status:
										<?php if($headerInfo['changeStatus'] == '1'){
											$status = 'Close';
										}else{
											$status = 'Not Complete';
										}?>
                						<span class="label label-info">
                							<b><?php echo $status;  ?></b>
                						</span>
                						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                						
                						Change User: 
                						<b><?php echo isset($headerInfo['changeUser'])? $headerInfo['changeUser']: "";  ?></b>
                						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                						
                						Change Date: 
                						<b><?php echo isset($headerInfo['changeDate'])? $headerInfo['changeDate']: "";  ?></b>
                						
                						<?php if(isset($headerInfo['isLatestChange']) && 'Y' == $headerInfo['isLatestChange']){ ?>
                							<img src="<?php echo base_url() ?>assets/img/label_black_new.png" style="width: 35px;height: 35px;">
                						<?php } ?>
                					</small>
                				</h2>
                			</div>
                		</div>
                	</div>

	                <div class="row">
	                	<div class="col-sm-12">
	                		<div class="form-group">
	                			<table class="table table-bordered" cellpadding="1px" cellspacing="1px">
	                				<tr>
	                					<td class="col-md-3" height="10" style="background: #F2F3F4;text-align: right;vertical-align: center;">
        									<label for="fnReqNo" style="margin-right: 3px;margin-bottom: 0px;">Functional Requirement ID:</label>
        								</td>
        								<td class="col-md-2" height="10" style="text-align: left;vertical-align: center;">
        									<label for="fnReqNo" style="margin-left: 5px;margin-bottom: 0px;"><?php echo isset($headerInfo['fnReqNo'])? $headerInfo['fnReqNo'] : "";  ?></label>
        								</td>
        								<td class="col-md-1" style="background: #F2F3F4;text-align: right;vertical-align: center;">
        									<label for="fnVersion" style="margin-right: 3px;margin-bottom: 0px;">Version :</label>
        								</td>
        								<td class="col-md-1">
        									<label for="fnVersion" style="margin-left: 5px;margin-bottom: 0px;"><?php echo isset($headerInfo['fnReqVer'])? $headerInfo['fnReqVer'] : "";  ?></label>
        								</td>
        								<td class="col-md-2" height="10" style="background: #F2F3F4;text-align: right;vertical-align: center;">
        									<label for="fnReqVer" style="margin-right: 3px;margin-bottom: 0px;">Description :</label>
        								</td>
        								<td class="col-md-3" height="10" style="text-align: left;vertical-align: center;">
        									<label for="fnReqVer" style="margin-left: 5px;margin-bottom: 0px;"><?php echo isset($headerInfo['fnReqDesc'])? $headerInfo['fnReqDesc']: "";  ?></label>
        								</td>
	                				</tr>
	                			</table>
		        			</div>
	                	</div>
	                </div>
	                <div class="row">
	                	<div class="col-sm-12">
	                		<div class="form-group table-responsive no-padding" style="margin-top: -5px;margin-bottom: -5px;">
	                			<h4>Change Functional Requirement's Inputs List</h4>
	                			<table class="table table-striped" cellpadding="1px" cellspacing="1px">
	                				<tbody>
	                					<tr>
	                						<th class="col-md-1">#</th>
	                						<th class="col-md-1">Change Type</th>
											<th class="col-md-1">Type of Data</th>
	            							<th class="col-md-1">Data Name</th>
	            							<th class="col-md-1">Data Type</th>
	            							<th class="col-md-1">Data Length</th>
	            							<th class="col-md-1">Scale</th>
	            							<th class="col-md-1">Unique</th>
	            							<th class="col-md-1">NOT NULL</th>
	            							<th class="col-md-1">Default</th>
	            							<th class="col-md-1">Min</th>
	            							<th class="col-md-1">Max</th>
	            							<th class="col-md-1">Table</th>
	            							<th class="col-md-1">Column</th>
	                					</tr>
	                					<!-- list -->
	                					<?php 
						                $define = 1;
						                foreach($detailInfo as $value): ?>
						                	<tr>
						                		<td>
							                		<?php echo $define++; ?>
							                	</td>
						                		<td>
                									<?php 
                									if('add' == $value['changeType']){
                										echo "<span class=' badge bg-green'>".$value['changeType']."</span>";
                									}else if('edit' == $value['changeType']){
                										echo "<span class='badge bg-orange'>".$value['changeType']."</span>";
                									}else{
                										echo "<span class='badge bg-red'>".$value['changeType']."</span>";
                									}
                									?>
                								</td>
												<?php if($value['typeData'] =='1'){
														$typeData = 'Input';
												}else{
														$typeData = 'Output';
												}?>
												<td>
                									<?php echo $typeData; ?>
                								</td>
							                	<td>
                									<?php echo $value['dataName']; ?>
                								</td>
                								<td>
                									<?php echo $value['dataType']; ?>
                								</td>
                								<td>
                									<?php echo $value['dataLength']; ?>
                								</td>
                								<td>
                									<?php echo $value['scale']; ?>
                								</td>
                								<td>
                									<?php echo $value['constraintUnique']; ?>
                								</td>
                								<td>
                									<?php echo $value['constraintNotNull']; ?>
                								</td>
                								<td>
                									<?php echo $value['constraintDefault']; ?>
                								</td>
                								<td>
                									<?php echo $value['constraintMin']; ?>
                								</td>
                								<td>
                									<?php echo $value['constraintMax']; ?>
                								</td>
                								<td>
                									<?php echo $value['refTableName']; ?>
                								</td>
                								<td>
                									<?php echo $value['refColumnName']; ?>
                								</td>
						                	</tr>
						                <?php endforeach ?>
										</tbody>
	                			</table>
								<h4>Functional Requirement Detail</h4>

										<table class="table table-striped" cellpadding="1px" cellspacing="1px">
	                					<tbody>
	                					<tr>
												<th>#</th>
	                							<th>Type of Data</th>
												<th>Data Name</th>
	                							<th>Data Type</th>
	                							<th>Data Length</th>
	                							<th>Scale</th>
	                							<th>Unique</th>
	                							<th>NOT NULL</th>
	                							<th>Default</th>
	                							<th>Min</th>
	                							<th>Max</th>
	                							<th>Table</th>
	                							<th>Column</th>
	                							<th> 
	                					</tr>
										<!--FR list -->
										<?php 
						                $define = 1;
						                foreach($FRdetailInfo as $value): ?>
						                	<tr>
						                		<td>
							                		<?php echo $define++; ?>
							                	</td>
						                		<?php 
												if ($value['typeData'] == 1) { 
													$value["typeData"] = "Input"; 
												}
												if ($value['typeData'] == 2) { 
													$value["typeData"] = "Output"; 
												}?>
												<td><?php echo $value['typeData']; ?> 
												</td>
                								<td>
                									<?php echo $value['dataName']; ?>
                								</td>
                								<td>
                									<?php echo $value['dataType']; ?>
                								</td>
                								<td>
                									<?php echo $value['dataLength']; ?>
                								</td>
                								<td>
                									<?php echo $value['decimalPoint']; ?>
                								</td>
                								<td>
                									<?php echo $value['constraintUnique']; ?>
                								</td>
                								<td>
                									<?php echo $value['constraintNull']; ?>
                								</td>
                								<td>
                									<?php echo $value['constraintDefault']; ?>
                								</td>
                								<td>
                									<?php echo $value['constraintMinValue']; ?>
                								</td>
                								<td>
                									<?php echo $value['constraintMaxValue']; ?>
                								</td>
                								<td>
                									<?php echo $value['refTableName']; ?>
                								</td>
                								<td>
                									<?php echo $value['refColumnName']; ?> 
                								</td>
						                	</tr>
						                <?php endforeach ?>

	                				</tbody>
	                			</table>
	                		</div>
	                	</div>
	                </div>
                </div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<ul class="timeline">
				<li class="time-label">
	                  <span class="bg-black">
	                    The Affected Data
	                  </span>
	            </li>
	            
	            <!-- timeline item -->
	            <!-- 1. Functional Requirement -->
	            <li>
	            	<i class="fa fa-file-text-o bg-gray"></i>
	            	<div class="timeline-item">
		            	<h3 class="timeline-header"><b>Functional Requirements</b></h3>
	            		<div class="timeline-body no-padding table-responsive">
	            			<table class="table table-condensed">
	            				<tbody>
									<tr>
										<th class="col-md-1">#</th>
										<th class="col-md-3">Functional Requirement ID</th>
										<th class="col-md-4">Description</th>
										<th class="col-md-2">Version</th>
										<th class="col-md-2">Action</th>
									</tr>
									<?php 
									$i = 1; 
									foreach($affectedFnReqList as $value){ ?>
									<tr>
										<td><?php echo $i++ ?></td>
										<td><?php echo $value['functionNo'] ?></td>
										<td><?php echo $value['functionDescription'] ?></td>

										<td class="hidden-sm hidden-xs">
										<?php if($value['activeflag'] == '0' ){  ?>
											<small class="label label-default"><?php echo $value['functionVersion'] ?></small>
											<?php } 
										if($value['activeflag'] == '1' ){  ?>
												<small class="label label-success"><?php echo $value['functionVersion'] ?></small>
										<?php } ?>
										</td>
										<td class="hidden-sm hidden-xs">

										<?php if($value['activeflag'] == '0' ){  ?>
											<small class="label label-default"><?php echo 'Not Active' ?></small>
										<?php } 
										if($value['activeflag'] == '1' ){  ?>
											<small class="label label-success"><?php echo 'Re-Active' ?></small>
										<?php } ?>

										</td>										
									</tr>
									<?php } ?>
								</tbody>
	            			</table>
	            		</div>
	            	</div>
	            </li>

	            <!-- timeline item -->
	            <!-- 2. Test Case -->
	            <li>
	            	<i class="fa fa-file-text-o bg-teal"></i>
	            	<div class="timeline-item">
	            		<h3 class="timeline-header"><b>Test Cases</b></h3>
	            		<div class="timeline-body no-padding table-responsive">
	            			<table class="table table-condensed">
	            				<tbody>
	            					<tr>
										<th class="col-md-1">#</th>
										<th class="col-md-2">Test Case ID</th>
									<!--	<th class="col-md-3">Related Requirement ID</th>  -->
										<th class="col-md-2">Description</th>
										<th class="col-md-2">Version</th>
										<th class="col-md-2">Action</th>
									</tr>
									<?php 
									$tcCount = 1;
									foreach($affectedTCList as $value){ ?>
										<tr>
											<td><?php echo $tcCount++ ?></td>
											<td><?php echo $value['testCaseNo'] ?></td>
											<td><?php echo $value['testCaseDescription'] ?></td>  

											<td class="hidden-sm hidden-xs">
											<?php if($value['activeflag'] == '0' ){  ?>
												<small class="label label-default"><?php echo $value['testcaseVersion'] ?></small>
												<?php } 
											if($value['activeflag'] == '1' ){  ?>
													<small class="label label-success"><?php echo $value['testcaseVersion'] ?></small>
											<?php } ?>
											</td>			

											<td class="hidden-sm hidden-xs">

											<?php if($value['activeflag'] == '0' ){  ?>
												<small class="label label-default"><?php echo 'Not Active' ?></small>
											<?php } 
											if($value['activeflag'] == '1' ){  ?>
												<small class="label label-success"><?php echo 'Re-Active' ?></small>
											<?php } ?>

											</td>												
										</tr>
									<?php } ?>
	            				</tbody>
	            			</table>
	            		</div>
	            	</div>
	            </li>

	            <!-- timeline item -->
	            <!-- 3. Database Schema -->
	            <li>
	            	<i class="fa fa-file-text-o bg-light-blue"></i>
	            	<div class="timeline-item">
	            		<h3 class="timeline-header"><b>Database Schema</b></h3>
	            		<div class="timeline-body no-padding table-responsive">
	            			<table class="table table-condensed">
	            				<tbody>
	            					<tr>
										<th class="col-md-1">#</th>
										<th class="col-md-2">Table Name</th>
										<th class="col-md-2">Version</th>
										<th class="col-md-3">Action</th>

									</tr>
									<?php 
									$dbCount = 1;
									foreach($affectedSchemaList as $value){ ?>
									<tr>
										<td><?php echo $dbCount++ ?></td>
										<td><?php echo $value['tableName'] ?></td>

										<td class="hidden-sm hidden-xs">
										<?php if($value['activeflag'] == '0' ){  ?>
											<small class="label label-default"><?php echo $value['schemaVersionNumber'] ?></small>
											<?php } 
										if($value['activeflag'] == '1' ){  ?>
												<small class="label label-success"><?php echo $value['schemaVersionNumber'] ?></small>
										<?php } ?>
										</td>	
										<td class="hidden-sm hidden-xs">

										<?php if($value['activeflag'] == '0' ){  ?>
											<small class="label label-default"><?php echo 'Not Active' ?></small>
										<?php } 
										if($value['activeflag'] == '1' ){  ?>
											<small class="label label-success"><?php echo 'Re-Active' ?></small>
										<?php } ?>

										</td>
									</tr>
									<?php } ?>
	            				</tbody>
	            			</table>
	            		</div>
	            	</div>
	            </li>

	            <!-- timeline item -->
	            <!-- 4. RTM -->
	            <li>
	            	<i class="fa fa-file-text-o bg-blue"></i>
	            	<div class="timeline-item">
	            		<h3 class="timeline-header">
	            			<b>Requirement Traceability Matrix</b>
	            			<?php if(isset($affectedRTMList) && 0 < count($affectedRTMList)){ ?>
	            	<!--		<span class="pull-right">
	            				Old Version: <small class="label label-default"><?php echo $affectedRTMList[0]['oldVersionNumber'] ?></small>
	            				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	            				New Version: <small class="label label-success"><?php echo $affectedRTMList[0]['newVersionNumber'] ?></small>
	            			</span> -->
	            			<?php } ?> 
	            		</h3>
	            		
	            		<div class="timeline-body no-padding table-responsive">
	            		<table class="table table-condensed">
	            				<tbody>
	            					<tr>
										<th class="col-md-1">#</th>
										<th class="col-md-3">Functional Requirement ID</th>
										<th class="col-md-2">Functional Version</th>
										<th class="col-md-2">Test Case ID</th>
										<th class="col-md-2">Test Case Version</th>
										<th class="col-md-2">Action</th> 
									</tr>
									<?php 
									$row = 1;
									foreach($affectedRTMList as $value){ ?>
									<tr>
										<td><?php echo $row++ ?></td>
										<td><?php echo $value['functionNo'] ?></td>
										<td><?php echo $value['functionVersion'] ?></td>
										<td><?php echo $value['testCaseNo'] ?></td>
										<td><?php echo $value['testcaseVersion'] ?></td>
										<td class="hidden-sm hidden-xs">

										<?php if($value['activeflag'] == '0' ){  ?>
											<small class="label label-default"><?php echo 'Not Active' ?></small>
										<?php } 
										if($value['activeflag'] == '1' ){  ?>
											<small class="label label-success"><?php echo 'Re-Active' ?></small>
										<?php } ?>

										</td>
									</tr>
									<?php } ?>
	            				</tbody>
	            			</table>
	            		</div>
	            	</div>
	            </li>
	            <!-- END timeline item -->
	            <li>
	              <i class="fa fa-clock-o bg-gray"></i>
	            </li>
			</ul>
		</div>
	</div>

	<?php if ($_SESSION['staffflag'] != '3') { ?>
	<div class="row">
		<div class="col-md-12">
			<form role="form" method="post" id="cancelChange_form" action="<?php echo base_url() ?>index.php/Rollback/saveProcess/">
				<input type="hidden" name="changeRequestNo" value="<?php echo $keyParam['changeRequestNo'] ?>">
        		<input type="hidden" name="projectId" value="<?php echo $keyParam['projectId'] ?>">
				<input type="hidden" name="userId" value="<?php echo $_SESSION['userId'] ?>">
				<div class="box box-solid" style="margin-top: 10px;">
					<div class="box-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group" id="_inputForm">
				        			<label>Please provide in this entry the reason for rollback the change.</label>

				        			<input type="text" class="form-control" id="inputReason" name="inputReason" value="<?php echo $reason ?>">
				        			<?php echo form_error('inputReason', '<font color="red">','</font><br>'); ?>

				        			<button type="submit" class="btn btn-danger" onclick="changeCancellation()" style="margin-top: 5px;">
					            		<i class="fa fa-fw fa-undo"></i>
					            		Save
					            	</button>
				        		</div>
							</div>
						</div>
					</div>
				</div>
	      	</form>	
		</div>
	</div>
	<?php } ?>

	<?php if ($_SESSION['staffflag'] == '3') { ?>
	<div class="row">
		<div class="col-md-12">
				<input type="hidden" name="changeRequestNo" value="<?php echo $keyParam['changeRequestNo'] ?>">
        		<input type="hidden" name="projectId" value="<?php echo $keyParam['projectId'] ?>">
				<input type="hidden" name="userId" value="<?php echo $_SESSION['userId'] ?>">
				<div class="box box-solid" style="margin-top: 10px;">
					<div class="box-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group" id="_inputForm">
				        			<label>The reason for rollback the change.</label>
								</div>
								<div>
											<?php	foreach($reasonRollback as $value){ ?>

											<input type="text" name="reason" id="reason" class="form-control" value= "<?php echo $value['reason'] ?>" disabled>

											<?php } ?>
				        		</div>
							</div>
						</div>
					</div>
				</div>
		</div>
	</div>
	<?php } ?>

	<!-- <div id="cancel_modal" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content" style="border-radius:6px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
        			<h4 class="modal-title">Change Cancellation</h4>
        			<form method="post" id="cancelChange_form" role="form">
	        			<div class="modal-body">
				        		<div class="form-group" id="_inputForm">
				        			<label>Please provide in this entry the reason for cancelling the change.</label>
				        			<input type="text" class="form-control" id="inputReason" name="inputReason">
				        			<span class="help-block" id="_errorMessage"></span>
				        		</div>
				     	</div>
				     	<div class="modal-footer">
					        <button type="button" class="btn btn-default" data-dismiss="modal">
					        	Close
					        </button>
					        <button type="submit" class="btn btn-primary">
					        	Save changes
					        </button>
				      	</div>
			      	</form>	
				</div>
			</div>
		</div>
	</div> -->

<?php if ($_SESSION['staffflag'] == '3') { ?>
	<div class="row">
		<div class="col-md-12">
			<form role="form" method="post" id="cancelChange_form" action="<?php echo base_url() ?>index.php/Rollback/doCancelProcess/">
				<input type="hidden" name="changeRequestNo" value="<?php echo $keyParam['changeRequestNo'] ?>">
        		<input type="hidden" name="projectId" value="<?php echo $keyParam['projectId'] ?>">
				<div class="box box-solid" style="margin-top: 10px;">
					<div class="box-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group" id="_inputForm">

												<button type="button" name="delete" id="<?php echo $keyParam['changeRequestNo'] ; ?>" class="btn btn-danger " style="margin-top: 5px;" >
												<i class="fa fa-fw fa-undo"></i>Not Approve Rollback Change</button> 

				        			<button type="submit" class="btn btn-success" onclick="changeCancellation()" style="margin-top: 5px;">
					            		<i class="fa fa-fw fa-undo"></i>
					            		Approve Rollback Change
					            	</button>
				        		</div>
							</div>
						</div>
					</div>
				</div>
	      	</form>	
		</div>
	</div>
<?php } ?>

</script>
											<script type="text/javascript">
												$(function() {

													$("button[name='delete']").bind( "click", function() {
														var msg = "Are you sure to Not Approve a Rollback Change ";
														if(confirm(msg))
														{
															var changeRequestNo = $('#headerchangeRequestNo').val();
															var url = baseUrl + "index.php/Rollback/delete_detail/"+changeRequestNo;
															$.ajax({url: url, 
															success: function(result){
																debugger
																if('' != result){
																	alert(result);
																	location.reload();
																}else{
																	alert("Delete Rollback Successfull");
																	window.location  = baseUrl+"index.php/Dashboard";
																}
															}});
														}
													});
												});
											</script>

</section>