<div id="edit_input_modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content" style="border-radius:6px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Change Input/Output of Functional Requirements ID: 
                        <b> <?php echo $functionNo; ?> </b>
                        <div>Project id <input type="text" value=<?php echo utf8_decode($projectId) ?> /></div>
					</h4>
				</div>
				
				<div>
				
				</div>
				<form method="post" id="changeInput_form" >
					<div class="modal-body" id="input_detail" align="center">
					<?php foreach ($ListofEdit as $value): 
 echo $value['dataLength'];
 end foreach ?>
                    </div>
                </form>
		</div>
	</div>
<script>

</script>