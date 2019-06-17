<div id="edit_input_modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content" style="border-radius:6px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Delete: 
                        <b> <?php echo $functionNo; ?> </b>
					</h4>

                </div>
            </div>
        </div>
</div>
	<script type="text/javascript">
		var baseUrl = '<?php echo base_url(); ?>'; 

       $(function(){
			$(document).on('click', '.deleteTmpFRInputChg', function(){
				var lineNo = $(this).attr("id");
				var msg = "Are you sure to delete?";
				if(confirm(msg)){
					var functionId = $('input[name=functionId]').val();
					var functionVersion = $('input[name=functionVersion]').val();

					$.ajax({
						url:"<?php echo base_url(); ?>index.php/ChangeManagement/deleteTempFRInputList/",
						method:"POST",
						data:{lineNumber: lineNo, functionId: functionId, functionVersion: functionVersion},
						success:function(data){
							//alert(data);
							if("" != data){
								var result = data.split("|");
								if("error" == result[0]){
									alert(result[1]);
									return false;
								}else{
									$('#inputChangeListTbl').html(data); 
									location.reload();

								}
							}
							return false;
						}
					});	
				}
			});  
       });

    </script>