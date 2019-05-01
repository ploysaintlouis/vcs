


<div class="row" style="padding:10px;">
    <!-- parameter for use in this page -->
    <input id="projectId_result" type="hidden" value='<?php echo $projectId; ?>'/>
    <input id="functionId_result" type="hidden" value='<?php echo $functionId; ?>'/>
    
    <?php
        $this->load->view("template/loading");
        // you can reorder panel at here.
        $this->load->view('ChangeManagement/results/panel_change_title',$title_panel);
        $this->load->view('ChangeManagement/results/panel_change_list',$change_panel);
        $this->load->view('ChangeManagement/results/panel_affect_fr',$aff_fr_panel);
        $this->load->view('ChangeManagement/results/panel_affect_schema',$aff_schema_panel);
        $this->load->view('ChangeManagement/results/panel_affect_testcase',$aff_testcase_panel);
    ?>
    <div class="col-sm-11"></div><div class="col-sm-1"><button type="button" class="btn btn-success" id="btnConfirmResult">Confirm</button></div>
    
</div>

<script>
    $(function(){
    
        $("body").addClass("skin-blue-light sidebar-mini");
        $("#btnConfirmResult").on("click",function(){
            // get param from this page or other page
            var projectId = $("#projectId_result").val();
            var functionId = $("#functionId_result").val();
            
            
            //logic in javascript
            $("#loadingPage").modal('show');
            setTimeout(() => {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/ChangeManagementRequest/confirm_change_request",
                    method: "POST",
                    dataType:"json",
                    data: {projectId : projectId , functionId : functionId},
                    success: function(data){

                        if(data.success){
                            $("#loadingPage").modal('hide');
                            alert(data.result);
                        }
                    }
                });
            },1000);
           
            
        });
    });
</script>