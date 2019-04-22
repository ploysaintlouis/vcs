<section class="content-header">
	<h1>
		<span class="glyphicon glyphicon-list-alt"></span>
		Functional Requirements
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Master Management</a></li>
		<li class="active">Functional Requirements Search</li>
	</ol>

	<!-- Main content -->
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
	 			<div class="box-header with-border">
             		<h3 class="box-title">Search Criteria</h3>
            	</div>
	            <form role="form" action="<?php echo base_url() ?>index.php/FunctionalRequirement/search/" method="post">
	            	<input type="hidden" id="selectedProjectId" value="<?php echo isset($selectedProjectId)? $selectedProjectId : '' ?>">
	            	<div class="box-body">
	            		<div class="row">
	            			<div class="col-sm-12">
	            				<div class="form-group">
	            					<label for="inputProjectName">Project's name<span style="color:red;">*</span>:</label>
	            					<select id="inputProjectName" name="inputProjectName" class="form-control select2" style="width: 100%;" value="<?php echo $formData->projectId ?>">
										<option value="">--Please Select--</option>
										<?php if(null != $projectCombo) {  ?>
	            						<?php foreach($projectCombo as $value): ?>
	            								<option value="<?php echo $value['projectId']; ?>" <?php echo set_select('inputProjectName', $value['projectId'], ( !empty($formData->projectId) && $formData->projectId == $value['projectId'] ? TRUE : FALSE )); ?>>
	            									<?php echo $value['projectNameAlias']; ?>: <?php echo $value['projectName']; ?>
	        									</option>
	            						<?php endforeach; ?>
										<?php } ?>
										<!-- <option selected="selected">Alabama</option> -->
					                </select>
					                <?php echo form_error('inputProjectName', '<font color="red">','</font><br>'); ?>
	            				</div>
		            		</div>
	        					<!-- <div class="col-sm-6"> 
	        						<label for="inputStatus">Functional Requirements Status: </label>
	            					&nbsp;&nbsp;&nbsp;
		            				<label>
					                	<input type="radio" name="inputStatus" class="minimal" value="1" <?php echo set_radio('inputStatus', '1', TRUE); ?>>
					                	Active 
					                </label>
					                <label>
					                	<input type="radio" name="inputStatus" class="minimal" value="0" <?php echo set_radio('inputStatus', '0'); ?>>
					                	Inactive
					                </label>
					                 <label>
					                	<input type="radio" name="inputStatus" class="minimal" value="2" <?php echo set_radio('inputStatus', '2'); ?>>
					                	All
					                </label>
	        					</div> -->
		            		<div class="form-group">
	        					<div class="col-sm-12">
	        						<div align="right">
	        							<button type="button" class="btn bg-olive" style="width: 100px;" onclick="doOpenAddMoreScreen();">
											<i class="fa fa-plus"></i> 
											Import
										</button>
	            						<a href="<?php echo base_url(); ?>index.php/FunctionalRequirement/reset/">
	            							<button type="button" class="btn bg-orange" style="width: 100px;">
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
	            		</div>
	            	</div>
	            </form>
	        </div>
		</div>
	</div>

	<?php if(isset($searchFlag) && 'Y' == $searchFlag){ ?>
	<!-- Start: Search Result Section -->
	<div class="row">
		<div class="col-md-12">
			<div class="box box-success" style="margin-top: -10px;">
				<div class="box-header">
					<h3 class="box-title">Search Result</h3>
				</div>

				<div class="box-body" style="margin-top: -10px;">
					<table id="resultTbl" class="table table-bordered">
						<tbody>
			            	<tr style="background: #CACFD2;">
								<th>#</th>
								<th>Functional Requirement ID</th>
								<th>Functional Requirement Description</th>
								<th>Version</th>
								<th>Status</th>
			                </tr>
		                <?php if(null != $result and 0 < count($result)){ ?>
			                <?php 
			                $define = 1;
			                foreach($result as $value): 
			                	$classRow = (0 == $define%2)? 'even' : 'odd'; ?>
			                	<tr class="<?php echo $classRow; ?>">
			                		<td><?php echo $define++; ?></td>
			                		<td><?php echo $value['functionNo'] ?></td>
									<?php echo $value['fnDesc']; ?>
			                		<!-- <td><?php echo iconv('UCS-2LE', 'UTF-8', $value['fnDesc']); ?></td> -->
			                		<td><?php echo $value['fnDesc']; ?></td>									
			                		<td><?php echo $value['functionVersion'] ?></td>
			                		<td><?php if('0' == $value['functionStatus'] ) { ?>
			                			<span class="label label-danger"><?php echo UNACTIVE_STATUS; ?> </span>
			                			<?php } else { ?>
			                			<span class="label label-success"><?php echo ACTIVE_STATUS; ?></span>
			                			<?php } ?>
			                		</td>
			                	</tr>
			                <?php endforeach; ?>
		                <?php } else { ?>
		                	<tr>
		                		<td colspan="6" style="text-align: center;"><span style="color: red;">Search Not Found!!</span></td>
		                	</tr>
		                <?php } ?>
		                </tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- End: Search Result Section -->
	<?php } ?>
	<script type="text/javascript">
		function doOpenAddMoreScreen(){
			var projectId = $('#inputProjectName').val();
			if('' != projectId){
				window.location  = baseUrl + "index.php/FunctionalRequirement/addMore/" + projectId;
				return false;
			}else{
				alert("Please select project's name!");
				return false;
			}
		}
	</script>
</section>