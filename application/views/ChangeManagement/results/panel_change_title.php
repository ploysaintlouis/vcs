
<div class='col-md-12'>
    <div class="box box-primary">
        <div class="form-group">
            <h2 class="page-header">
                <i class="fa fa-tag"></i>
                	Change Request No. : 
                <b><?php echo isset($change_title['CH_NO'])? $change_title['CH_NO']: ""; ?></b>
                <small class="pull-right">
                	Change User: 
            	<b><?php echo isset($change_title['username'])? $change_title['username']: "";  ?></b>
                </small>
            </h2>
        </div>
	<?php $version_title = "V."; ?>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12">
                	<div class="form-group">
                		<table class="table-bordered" cellpadding="1px" cellspacing="1px" style="width: 100%;">
                			<tr>
                				<td height="10" style="background: #F2F3F4;width: 30%;text-align: left;">
                	    			<label for="functionNo" style="margin-right: 3px;margin-bottom: 0px;">Functional Requirement ID:</label>
                				</td>
                				<td height="10" style="width: 70%;">
                					<label for="projectName" style="margin-left: 5px;margin-bottom: 0px;"><?php echo $change_title['FR_Request']; ?></label>
                				</td>
                			</tr>
                	    	<tr>
                				<td height="10" style="background: #F2F3F4;width: 30%;text-align: left;">
                					<label for="functionNo" style="margin-right: 3px;margin-bottom: 0px;">Functional Requirement Description:</label>
                				</td>
                				<td height="10" style="width: 70%;">
                					<label for="projectName" style="margin-left: 5px;margin-bottom: 0px;"><?php echo $change_title['FR_Description']; ?></label>
                		    	</td>
                			</tr>
                			<tr>
                				<td height="10" style="background: #F2F3F4;width: 30%;text-align: left;">
                					<label for="functionNo" style="margin-right: 3px;margin-bottom: 0px;">Functional Requirement Version:</label>
                		    	</td>
                				<td height="10" style="width: 70%;">
                					<label for="projectName" style="margin-left: 5px;margin-bottom: 0px;"><?php echo $version_title.$change_title['FR_Version']; ?></label>
                				</td>
                			</tr>
                		</table>
                	</div>
            	</div>
        	</div>
     	</div>
    </div>
</div>
