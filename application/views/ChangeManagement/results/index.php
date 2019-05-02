


<div class="row" style="padding:10px;">
    <!-- parameter for use in this page -->
    <input id="projectId_result" type="hidden" value='<?php echo $projectId; ?>'/>
    <input id="functionId_result" type="hidden" value='<?php echo $functionId; ?>'/>

    <!--title_panel -->
    <input id="CH_result" type="hidden" value='<?php echo $title_panel['change_title']['CH_NO']; ?>'/>
    <input id="username_result" type="hidden" value='<?php echo $title_panel['change_title']['username']; ?>'/>
    <input id="FR_Request_result" type="hidden" value='<?php echo $title_panel['change_title']['FR_Request']; ?>'/>
    <input id="FR_Description_result" type="hidden" value='<?php echo $title_panel['change_title']['FR_Description']; ?>'/>
    <input id="FR_Version_result" type="hidden" value='<?php echo $title_panel['change_title']['FR_Version']; ?>'/>

    <!--aff_fr_panel -->
    <input id="FR_no_result" type="hidden" value='<?php echo $aff_fr_panel['aff_fr_list']['fr_no']; ?>'/>
    <input id="FR_changetype_result" type="hidden" value='<?php echo $aff_fr_panel['aff_fr_list']['change_type']; ?>'/>
    <input id="FR_version_result" type="hidden" value='<?php echo $aff_fr_panel['aff_fr_list']['version']; ?>'/>

    <!--aff_schema_panel -->
    <input id="BD_tablename_result" type="hidden" value='<?php echo $aff_schema_panel['aff_schema_list']['table_name']; ?>'/>
    <input id="DB_columnname_result" type="hidden" value='<?php echo $aff_schema_panel['aff_schema_list']['column_name']; ?>'/>
    <input id="DB_changetype_result" type="hidden" value='<?php echo $aff_schema_panel['aff_schema_list']['change_type']; ?>'/>
    <input id="DB_version_result" type="hidden" value='<?php echo $aff_schema_panel['aff_schema_list']['version']; ?>'/>
<?php
//$aff_testcase_panel['aff_testcase_list'][1]['test_no'] มันมี ทั้ง [1]กับ [0] ทำยังไง??
    print_r ($aff_testcase_result);
    echo $aff_testcase_panel['aff_testcase_list'][1]['test_no'];
?>
    <!--aff_testcase_list -->
    <input id="TC_No_result" type="hidden" value='<?php echo $aff_testcase_panel['aff_testcase_list']['test_no']; ?>'/>
    <input id="TC_changetype_result" type="hidden" value='<?php echo $aff_testcase_panel['aff_testcase_list']['change_type']; ?>'/>
    <input id="TC_version_result" type="hidden" value='<?php echo $aff_testcase_panel['aff_testcase_list']['version']; ?>'/>

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
            var CH_NO = $("#CH_result").val();
    
            //logic in javascript
            $("#loadingPage").modal('show');
            setTimeout(() => {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/ChangeManagementRequest/confirm_change_request",
                    method: "POST",
                    dataType:"json",
                    data: {projectId : projectId , functionId : functionId, CH_NO : CH_NO },
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