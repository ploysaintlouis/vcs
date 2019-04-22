<section class="content-header">
	<h1>
		<span class="glyphicon glyphicon-list-alt"></span>
		Inquiry Test Case by Version
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Version Management</a></li>
		<li class="active">Inquiry Test Case by Version </li>
	</ol>
	<!-- Main content -->
	<div class="row">
		<div class="col-md-12">

			<?php if(!empty($error_message)) { ?>
			<div class="alert alert-danger alert-dismissible" style="margin-top: 3px;margin-bottom: 3px;">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
				<?php echo $error_message; ?>
			</div>
			<?php } ?>

			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Search Criteria</h3>
				</div>
				<form class="form-horizontal" action="<?php echo base_url() ?>index.php/VersionManagement_TestCase/search/" method="post">
					<input type="hidden" id="selectedProjectId" value="<?php echo $projectId; ?>">
					<input type="hidden" id="selectedTestCaseId" value="<?php echo $testCaseId; ?>">
				<!--	<input type="hidden" id="selectedTestCaseVersion" value="<?php echo $testCaseVersion; ?>"> -->

					<div class="box-body">
            			<div class="form-group">
    						<label for="inputProjectName" class="col-sm-2 control-label">
 								Project's name
        						<span style="color:red;">*</span>:
        					</label>
        					<div class="col-sm-10">
        						<select id="projectCombo" name="inputProjectName" class="form-control select2" style="width: 100%;" value="<?php echo $projectId; ?>">
    							<option value="">--Please Select--</option>
    							<?php if(null != $projectCombo) {  ?>
    							<?php foreach($projectCombo as $value): ?>
    								<option value="<?php echo $value['projectId']; ?>" <?php echo set_select('inputProjectName', $value['projectId'], (!empty($projectId) && $projectId == $value['projectId']? TRUE : FALSE )); ?>>
        									<?php echo $value['projectNameAlias']; ?>: <?php echo $value['projectName']; ?>
    								</option>
    							<?php endforeach; ?>
        						<?php } ?>
    						</select>
    						<?php echo form_error('inputProjectName', '<font color="red">','</font><br>'); ?>
        					</div>
    					</div>
    					<div class="form-group">
    						<label for="inputTestCase" class="col-sm-2 control-label">
 								Test Cases
        						<span style="color:red;">*</span>:
        					</label>
        					<div class="col-sm-10">
        						<select id="testCaseCombo" name="inputTestCase" class="form-control select2" style="width: 100%;" value="<?php echo $testCaseId; ?>">
            						<option value="">--Please Select--</option>
            						<?php 
            						if(isset($testCaseCombo) && 0 < count($testCaseCombo)){
            							foreach($testCaseCombo as $value){ ?>
            								<option value="<?php echo $value['testCaseId']; ?>" <?php echo set_select('inputTestCase', $value['testCaseId'], (!empty($testCaseId) && $testCaseId == $value['testCaseId']? TRUE : FALSE )); ?>>
	            									<?php echo $value['testCaseNo']; ?>: <?php echo $value['testCaseDescription']; ?>
	        								</option>
            						<?php 
            							} 
            						} ?>
            					</select>
            					<?php echo form_error('inputTestCase', '<font color="red">','</font><br>'); ?>
        					</div>
    					</div>
    					<div class="form-group">
    						<label for="inputVersion" class="col-sm-2 control-label">
 								Version
        						<span style="color:red;">*</span>:
        					</label>
        					<div class="col-sm-10">
        						<select id="testCaseVersionCombo" name="inputVersion" class="form-control select2" style="width: 100%;" value="<?php echo $testCaseVersion; ?>">
            						<option value="">--Please Select--</option>
            						<?php if(isset($testCaseVersionCombo) && 0 < count($testCaseVersionCombo)){ 
            							foreach($testCaseVersionCombo as $value){ ?>
            								<option value="<?php echo $value['testCaseVersion']; ?>" <?php echo set_select('inputVersion', $value['testCaseVersion'], (!empty($testCaseVersion) && $testCaseVersion == $value['testCaseVersion']? TRUE : FALSE )); ?>>
	            									<?php echo 'Version '.$value['testCaseVersion']; ?>
	        								</option>
            						<?php } } ?>
            					</select>
            					<?php echo form_error('inputVersion', '<font color="red">','</font><br>'); ?>
        					</div>
    					</div>
    					<div class="form-group">
 							<div class="col-md-12" align="right">
        						<a href="<?php echo base_url(); ?>index.php/VersionManagement_TestCase/reset/">
        							<button id="btnReset" type="button" class="btn bg-orange" style="width: 100px;">
            							<i class="fa fa-refresh"></i> 
            							Reset
        							</button>	
        						</a>
                				<button type="submit" class="btn bg-primary" style="width: 100px;">
                					<i class="fa fa-search"></i>
                					Search
                				</button>
        					</div>
 						</div>
            		</div>
				</form>
			</div>
		</div>
	</div>
	
	<!-- Result Session -->
	<?php if(null != $resultList && 0 < count($resultList)){ ?>
	<div class="row">
		<div class="col-md-12">
			<div class="box box-success box-solid">
				<div class="box-body" style="padding: 3px;">
					<div class="row">
						<!-- <div class="form-group">
							
						</div> -->
						<div class="col-sm-3">
							<div class="form-group">
								<dl>
									<dt>Test Case ID:</dt>
									<dd><?php echo $resultList[0]['testCaseNo'] ?></dd>
								</dl>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<dl>
									<dt>Test Case Description:</dt>
									<dd><?php echo $resultList[0]['testCaseDescription'] ?></dd>
								</dl>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<dl>
									<dt>Version:</dt>
									<dd><?php echo $resultVersionInfo->testCaseVersion; ?></dd>
								</dl>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<dl>
									<dt>Status:</dt>
									<dd>
									<?php 
									if("1" == $resultVersionInfo->activeFlag){
										echo "<span class='badge bg-green'>".constant("ACTIVE_STATUS")."</span>";
									}else{
										echo "<span class='badge bg-red'>".constant("UNACTIVE_STATUS")."</span>";
									} ?>
								<!--	<div class="pull-right">
										<button id="btnDiffVersion">Diff with Previous Version</button>
									</div> -->
									
									</dd>
								</dl>
							</div>
						</div>
					</div>
				</div>
				<div class="box-body no-padding">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<table class="table table-striped">
									<tbody>
										<tr>
											<th>#</th>
											<th>Input Name</th>
											<th>Test Data</th>
										</tr>
										<?php 
	                						$define = 1;
	                						foreach ($resultList as $value): ?>
											<?php if ($value['typeData'] == 1) { ?>
	                						<tr>
	                							<td><?php echo $define++; ?></td>
	                							<td><?php echo $value['refdataName']; ?></td>
	                							<td><?php echo $value['testData']; ?></td>
	                						</tr>
											<?php } ?>
												<?php if ($value['typeData'] == 2) { 
													$lineout = 1; ?>

													<?php if ($lineout==1){ ?>
													<th>#</th>
													<th>Output Name</th>
													<th>Test Data</th>
													<?php } ?>
													<tr>
														<td><?php echo $lineout++; ?></td>
														<td><?php echo $value['refdataName']; ?></td>
														<td><?php echo $value['testData']; ?></td>	
													</tr>													
												<?php } ?>						
	                					<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>

	<!-- Modal -->
	<div class="modal fade" id="diffVersionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Diff with Previous Version</h4>
				</div>
				<div class="modal-body" id="diffVersionContent">

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</section>