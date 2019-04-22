<section class="content-header">
	<h1>
		<span class="glyphicon glyphicon-list-alt"></span>
		Inquiry RTM
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Version Management</a></li>
		<li class="active">Inquiry RTM by Version </li>
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
				<form class="form-horizontal" action="<?php echo base_url() ?>index.php/VersionManagement_RTM/search/" method="post">
					<input type="hidden" id="selectedProjectId" value="<?php echo $projectId; ?>">
					<!-- <input type="hidden" id="selectedVersionId" value="<?php echo $rtmVersionId; ?>"> -->
					<div class="box-body">
						<div class="form-group">
							<label for="inputProjectName" class="col-sm-2 control-label">
 								Project's name
        						<span style="color:red;">*</span>:
        					</label>
        					<div class="col-sm-5">
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
        				<!--	<label for="inputVersion" class="col-sm-2 control-label">
 								Version
        						<span style="color:red;">*</span>:
        					</label> 
        					<div class="col-sm-3">
        						<select id="rtmVersionCombo" name="inputVersion" class="form-control select2" style="width: 100%;" value="<?php echo $rtmVersionId; ?>">
            						<option value="">--Please Select--</option>
            						<?php 
            						if(isset($rtmVersionCombo) && 0 < count($rtmVersionCombo)){
            							foreach($rtmVersionCombo as $value){ ?>
            								<option value="<?php echo $value['rtmVersionId']; ?>" <?php echo set_select('inputVersion', $value['rtmVersionId'], (!empty($rtmVersionId) && $rtmVersionId == $value['rtmVersionId']? TRUE : FALSE )); ?>>
	            								<?php echo 'Version '.$value['rtmVersionNumber']; ?>
	        								</option>
            						<?php 
            							} 
            						} ?>
            					</select>
            					<?php echo form_error('inputVersion', '<font color="red">','</font><br>'); ?>
        					</div> -->
						</div>
						<div class="form-group">
							<div class="col-md-12" align="right">
        						<a href="<?php echo base_url(); ?>index.php/VersionManagement_RTM/reset/">
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
	 			<div class="box-body no-padding">
	 				<div class="row">
	 					<!--<div class="col-sm-12">
	 						<div class="pull-right">
								<button id="btnDiffVersion">Diff with Previous Version</button>
							</div>
	 					</div> -->
	 					<div class="col-sm-12">
	 						 <div class="form-group">
	 						 	<table id="resultTbl" class="table table-striped">
	 						 	  	<tbody>
	 						 	  		<tr>
	 						 	  			<th>#</th>
	                                        <th>Functional Requirements ID</th>
											<th>Functional Requirement Version</th>
											<th>Test Case ID</th>
	                                        <th>Test Case Version</th>
											<th>Status</th>
	 						 	  		</tr>
                                        <?php 
                                            $define = 1;
                                            foreach ($resultList as $value): ?>
                                            <tr>
                                            	<td><?php echo $define++; ?></td>
												
                                                <td><?php if(isset($value['functionNo'])){
													echo $value['functionNo']; } ?>
												</td>
                                                <td><?php if(isset($value['functionversion'])) {
													echo $value['functionversion'];}?>
												</td>
                                                <td><?php if(isset($value['testCaseNo'])) {
													echo $value['testCaseNo'];}?>
												</td>
                                                <td><?php if(isset($value['testCaseversion'])) {
													echo $value['testCaseversion'];}?>
												</td>
                                                <td>
                                                    <?php if(isset($value['activeFlag'])) {
                                                    if("1" == $value['activeFlag']){
                                                        echo "<span class='label label-success'>".constant("ACTIVE_STATUS")."</span>";
                                                    }else{
                                                        echo "<span class='label label-danger'>".constant("UNACTIVE_STATUS")."</span>";
                                                    } }?>    
                                                </td>
                                            </tr>
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