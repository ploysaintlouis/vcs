


<div class="row" style="padding:10px;">
    <!-- parameter for use in this page -->
    <input id="projectId_result" type="hidden" value='<?php echo $projectId; ?>'/>
    <input id="functionId_result" type="hidden" value='<?php echo $functionId; ?>'/>

    <!--title_panel -->
    <input id="CHNO_result" type="hidden" value='<?php echo $title_panel['change_title']['CH_NO']; ?>'/>
    <input id="FR_Version_result" type="hidden" value='<?php echo $title_panel['change_title']['FR_Version']; ?>'/>
    <input id="FR_desc_result" type="hidden" value='<?php echo $title_panel['change_title']['FR_Description']; ?>'/>

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
            var CH_NO = $("#CHNO_result").val();
            var FR_Version = $("#FR_Version_result").val();
            var FR_Description = $("#FR_desc_result").val();
            var baseUrl = '<?php echo base_url(); ?>';

            //logic in javascript
            $("#loadingPage").modal('show');
            setTimeout(() => {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/ChangeManagementRequest/confirm_change_request",
                    method: "POST",
                    dataType:"json",
                    data: {projectId : projectId , functionId : functionId, CH_NO : CH_NO, FR_Version : FR_Version, FR_Description : FR_Description},
                    success: function(data){

                    
                        if(data.success){
                            //$("#loadingPage").modal('hide');
                            //alert(data.result);
                            alert(data.FR_Description);
                            //alert(baseUrl);
                            window.location  = baseUrl+"index.php/Dashboard";
                        }
                    }
                });
            },1000);
           
            
        });
    });
</script>