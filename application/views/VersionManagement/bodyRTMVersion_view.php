<body class="hold-transition skin-blue-light sidebar-mini">
	<?php $this->view('template/menu'); ?>
	<?php $this->view('template/body_javascript'); ?>
	
	<script type="text/javascript">
		var baseUrl = '<?php echo base_url(); ?>'; 
		$(function(){
			$(document).on('change','#projectCombo',function(){
				//Clear Function Combo
				$('#rtmVersionCombo').html(); 
				$('#rtmVersionCombo').html("<option value=''>--Please Select--</option>");

				var projectId = $(this).val();
				if('' != projectId){
					$.ajax({
						url: baseUrl+'index.php/VersionManagement_RTM/getRelatedRTMVersion/',
						data: {projectId : projectId},
						type: 'POST',
						success: function(result){
							//alert(result);
		                    $('#rtmVersionCombo').html();  
		                    $('#rtmVersionCombo').html(result);
	                   	}
					});
				}
			});

			$("#btnDiffVersion").click(function(){
				var projectId = $('#selectedProjectId').val();
				var versionId = $('#selectedVersionId').val();
				$.ajax({
					url: baseUrl+'index.php/VersionManagement_RTM/diffWithPreviousVersion',
					data: {projectId: projectId, rtmVersionId: versionId},
					type: 'POST',
					success: function(result){
						if("" != result){
							$('#diffVersionModal').modal('show');
							$('#diffVersionContent').html(result);
						}else{
							alert('This is an initial Version!!');
						}
						return false;
					}
				});
			});
		});
	</script>

</body>