
<?php
    // you can reorder panel at here.
    $this->load->view('ChangeManagement/results/panel_change_title',$title_panel);
    $this->load->view('ChangeManagement/results/panel_change_list',$change_panel);
    $this->load->view('ChangeManagement/results/panel_affect_fr',$aff_fr_panel);
    $this->load->view('ChangeManagement/results/panel_affect_schema',$aff_schema_panel);
    $this->load->view('ChangeManagement/results/panel_affect_testcase',$aff_testcase_panel);
?>

<div class="row">
    <!-- parameter for use in this page -->
    <input id="projectId_result" type="hidden" value='<?php echo $projectId; ?>'/>

    <div class="col-sm-11"></div><div class="col-sm-1"><button type="button" class="btn btn-success" id="btnConfirmResult">Confirm</button></div>
</div>

<script>
    $(function(){
        $("#btnConfirmResult").on("click",function(){
            // get param from this page or other page
            var projectId = $("#projectId_result").val();
            alert("Project ID"+projectId);
            
            //logic in javascript

        });
    });
</script>