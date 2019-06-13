<section class="content-header">
	<h1>
		<span class="glyphicon glyphicon-refresh"></span>
		Rollback of the Change
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
		<li><a href="#">Change Management</a></li>
		<li class="active">Rollback</li>
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
			<div class="box box-primary">
				<form role="form" action="<?php echo base_url() ?>index.php/ApproveRollback/search/" method="post">
					<input type="hidden" id="selectedProjectId" value="<?php echo isset($selectedProjectId)? $selectedProjectId : '' ?>">
					<div class="box-body">
						<div class="row">
							<div class="form-group">
								<div class="col-sm-8">
									<label for="inputProject">Project's name<span style="color:red;">*</span>:</label>
									<select name="inputProject" class="form-control select2" style="width: 100%;" value="<?php echo $criteria->projectId ?>">
										<option value="">--Please Select--</option>
										<?php if(null != $projectCombo) {  ?>
											<?php foreach($projectCombo as $value): ?>
	            								<option value="<?php echo $value['projectId']; ?>" <?php echo set_select('inputProject', $value['projectId'], ( !empty($formData->projectId) && $formData->projectId == $value['projectId'] ? TRUE : FALSE )); ?>>
	            									<?php echo $value['projectNameAlias']; ?>: <?php echo $value['projectName']; ?>
	        									</option>
	            							<?php endforeach; ?>
										<?php } ?>
									</select>
									<?php echo form_error('inputProject', '<font color="red">','</font><br>'); ?>
								</div>
								<div class="col-sm-4">
				  					<br/>
				  					<button type="submit" class="btn bg-primary" style="width: 100px;margin-top: 5px;">
	                					<i class="fa fa-search"></i>
	                					Search
	                				</button>
				  				</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

<?php if(isset($waitList) and 0 < count($waitList)){ ?>
	<div class="row">
		<div class="col-md-12">
			<div class="box box-success" style="margin-top: -10px;">
				<div class="box-header">
					<h3 class="box-title">Waiting Rollback</h3>
				</div>

				<div class="box-body table-responsive no-padding" style="margin-top: -10px;">
					<table id="resultTbl" class="table table-striped">
						<tbody>
							<tr>
								<th class="col-md-1">#</th>
								<th class="col-md-2">Change Request No.</th>
								<th class="col-md-1">Request Date</th>
								<th class="col-md-1">User</th>
								
								<th class="col-md-3">reason</th>
							</tr>
							<?php 
							$i = 1;
							foreach($waitList as $value){ ?>
							<tr>
								<td><?php echo $i++ ?></td>
								<td><?php echo $value['ChangeRequestNo'] ?></td>
								<td><?php echo $value['requestDate'] ?></td>
								<td><?php echo $value['Firstname'].' '.$value['lastname'] ?></td>
								<td><?php echo $value['reason'] ?></td>
								<?php if ($_SESSION['staffflag'] == '3') { ?>
								<td>
									<button class="btn btn-block btn-default btn-xs" name = "viewChangeDetail" onclick="viewChangeDetail('<?php echo $value['ChangeRequestNo'] ?>')">
										<i class="fa fa-fw fa-file-text-o"></i>	
										See Detail
									</button>
								</td>
								<?php } ?>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<script type="text/javascript">
		function viewChangeDetail(changeRequestNo){
			var projectId = $('#selectedProjectId').val();
			window.location  = baseUrl + "index.php/Rollback/viewDetail/"+ projectId+"/" +changeRequestNo;
		}
	</script>
</section>