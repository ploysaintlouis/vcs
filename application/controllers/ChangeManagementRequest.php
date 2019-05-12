<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Change Management Controller
**/
class ChangeManagementRequest extends CI_Controller {
    var $data;
    var $projectId;
    var $functionId;

    function __construct(){
        parent::__construct();
        $this->data = array();
		$this->load->model('RTM_model', 'mRTM');
		$this->load->model('Project_model', 'mProject');
		$this->load->model('TestCase_model', 'mTestCase');
		$this->load->model('DatabaseSchema_model', 'mDB');
		$this->load->model('Miscellaneous_model', 'mMisc');
		$this->load->model('ChangeManagement_model', 'mChange');
		$this->load->model('FunctionalRequirement_model', 'mFR');
		$this->load->model('Running_model', 'mRunning');
		$this->load->model('User_model', 'mUser');
		$this->load->model('VersionControl_model', 'mVersion');

		$this->load->library('form_validation', null, 'FValidate');
		$this->load->library('session');
    }
		
		function loadPage($errorMessage, $projectId, $functionId, $functionVersion = ''){
    $resultHeader = array();
		$resultList = array();
		$inputChangeList = array();

		$userId = $this->session->userdata('userId'); //echo $_SESSION['userId'] ;
		$staffflag = $this->session->userdata('staffflag'); //echo $_SESSION['staffflag'] ;
        
        $data = array();
        $projectId = $this->projectId;
        $functionId = $this->functionId;
		if(!empty($projectId) && !empty($functionId)){
			$projectInfo = $this->mProject->searchProjectDetail($projectId);
			$data['projectInfo'] = $projectInfo;
			
			$param = (object) array('projectId' => $projectId, 'functionId' => $functionId);
			$resultList = $this->mFR->searchFunctionalRequirementDetail($param);
			if(null != $resultList && 0 < count($resultList)){
				
				$resultHeader = (object) array(
				'functionId' => $resultList[0]['functionId'],
				'functionNo' => $resultList[0]['functionNo'],
				'functionDescription' => $resultList[0]['functionDescription'],
				'functionVersion' => $resultList[0]['functionVersion'],
				'schemaVersionId' => $resultList[0]['schemaVersionId']);

				$functionVersion = (!empty($functionVersion)? $functionVersion : $resultList[0]['functionVersion']);
//echo $functionVersion;
				//get temp change list
				$criteria = (object) array('userId' => $userId, 'functionId' => $functionId, 'functionVersion' => $functionVersion);
				$inputChangeList = $this->mChange->searchTempFRInputChangeList($criteria);
				$inputChangeConfirm = $this->mChange->searchTempFRInputChangeConfirm($criteria);
//print_r($inputChangeConfirm);
			}else{
				$error_message = ER_MSG_012;
			}
		}else{
			$error_message = ER_MSG_011;
		}
	//	echo $functionVersion;
		$hfield = array(
			'projectId' => $projectId, 
		'functionId' => $functionId, 
		'functionVersion' => $functionVersion
		);
		$data['hfield'] = $hfield;
		$data['error_message'] = '';
		$data['resultHeader'] = $resultHeader;
		$data['resultDetail'] = $resultList;
		$data['staffflag'] = $staffflag;
    $data['inputChangeList'] = $inputChangeList;
		$data['inputChangeConfirm'] = $inputChangeConfirm;
       
        $this->data = $data;
		}
		
    private function openView($data, $view){
		if('search' == $view){
			$data['html'] = 'ChangeManagement/changeRequestSearch_view';
			$data['projectCombo'] = $this->mProject->searchStartProjectCombobox();
		}else if('result' == $view){
			$data['html'] = 'ChangeManagement/changeRequestResult_view';
		}
		else{
			$data['html'] = 'ChangeManagement/changeRequestDetail_view_new';
		}
		
		$data['active_title'] = 'ChangeManagement';
		$data['active_page'] = 'trns001';
        $this->load->view('template/header');
        $this->load->view('template/body_javascript');
		$this->load->view('template/body', $data);
		$this->load->view('template/footer');
    }
    
    function view_detail($projectId, $functionId){
        $this->projectId = $projectId;
        $this->functionId = $functionId;

        $this->loadPage('', $projectId, $functionId);
        $this->openView($this->data, 'detail');
		}
		
    function add_detail($projectId,$functionId,$functionVersion,$schemaVersionId){

			$param = (object) array(
				'projectId' => $projectId, 
				'functionId' => $functionId, 
				'functionVersion' => $functionVersion,
				'schemaVersionId' => $schemaVersionId
			);

			//echo $functionVersion;
			$fucntionHeader = $this->mFR->searchFunctionalRequirementHeaderInfo($param);
			foreach ($fucntionHeader as $value) {
					$functionNo = $value['functionNo'];
			}
			//echo $functionNo;
			$data = array();
			$data['projectId'] = $projectId;
			$data['functionNo'] = $functionNo;
			$data['functionId'] = $functionId;
			$data['functionVersion'] = $functionVersion;
			$data['schemaVersionId'] = $schemaVersionId;
			$data['dataTypeCombo'] = $this->mMisc->searchMiscellaneous('','');

			$this->load->view('ChangeManagement/popup/add',$data);

		}
		
    function edit_detail($keyId,$functionVersion){
		if(null !== $keyId && !empty($keyId)){
			//echo $keyId;
			$keyList = explode("%7C", $keyId);
			//inputid
			$param = (object) array(
				'projectId' => $keyList[0], 
				'dataId' => $keyList[1], 
				'schemaVersionId' => $keyList[2], 
				'functionId' => $keyList[3], 
				'typeData' => $keyList[4]
			);
		}		
		$param_new = (object) array(
			'functionVersion' => $functionVersion,
		);

		$data = array();
		$ListofEdit = $this->mFR->ListofEditChange($param,$param_new);
		foreach ($ListofEdit as $value) {
			//var_dump($value) ;
		}
		//echo $ListofEdit['projectId'];
        $data["projectId"] = $param->projectId;
		$data["dataId"] = $param->dataId;
		$data["functionId"] = $param->functionId;
		$data["functionVersion"] = $param_new->functionVersion;
		$data["functionNo"] = $value['functionNo'];
		$data["typeData"] = $value['typeData'];
		$data["dataName"] = $value['dataName'];
		$data["dataType"] = $value['dataType'];
		$data["dataLength"] = $value['dataLength'];
		$data["decimalPoint"] = $value['decimalPoint'];
		$data["constraintUnique"] = $value['constraintUnique'];
		$data["constraintNull"] = $value['constraintNull'];
		$data["constraintDefault"] = $value['constraintDefault'];
		$data["constraintMinValue"] = $value['constraintMinValue'];
		$data["constraintMaxValue"] = $value['constraintMaxValue'];
		$data["schemaVersionId"] = $value['schemaVersionId'];
		$data["refTableName"] = $value['refTableName'];
		$data["refColumnName"] = $value['refColumnName'];

		$data['dataTypeCombo'] = $this->mMisc->searchMiscellaneous('','');

		$this->load->view('ChangeManagement/popup/edit',$data);
    }
    function delete_detail($id){
		$data = array();
		$data['keyid'] = $id;
		echo $id;
		if(null !== $id && !empty($id)){
			//echo $keyId;
			$keyList = explode("%7C", $id);
			//inputid
			$param = (object) array(
				'projectId' => $keyList[0], 
				'dataId' => $keyList[1], 
				'schemaVersionId' => $keyList[2], 
				'functionId' => $keyList[3], 
				'typeData' => $keyList[4]
			);
		}	
		$userId = $this->session->userdata('userId');
		$user = $this->session->userdata('username');

		//echo $param->functionId;
		$dataDelete = $this->mMisc->searchMiscellaneous('','');
		foreach ($dataDelete as $value) {
			var_dump($value) ;
		}
    }	

	function saveTempFRInput_edit($dataName){
		$output = '';
		$error_message = '';
		echo 'HEOOL"';
	}

	function bind_data_title($param){
		$data = array();
		$data['change_title'] = array();
		/// *** call model and bind data here.
		$ChangeRequestNo = $this->mRunning->running_ch();
		$Change_title = "CH";
		$ChangeRequestNo->changeRequestId = str_pad($ChangeRequestNo->changeRequestId, 2,'0',STR_PAD_LEFT);
		$UserName = $this->mUser->UserName($param->userId);
		//$rowResult = $this->mRunning->Update_Running_ch();

		$data['change_title']['CH_NO'] = $Change_title.$ChangeRequestNo->changeRequestId;
		$data['change_title']['FR_Request'] = $param->functionNo;
		$data['change_title']['FR_Description'] = $param->fnDesc;
		$data['change_title']['FR_Version'] = $param->functionVersion;
		$data['change_title']['username'] = $UserName->username;
		
		return $data;
	}

	function bind_data_change_list($param){
		$data = array();
		$data['change_list'] = array();
		/// *** call model and bind data here.
		$row = array(); //อยากจะส่ง $RelateResultSCHEMA,$RelateResultNotSCHEMA ไป display 
		//echo $param->functionId;
		
		$RelateResultSCHEMA = $this->mChange->searchChangeRequestrelateSCHEMA($param);
		$i=1;
		foreach ($RelateResultSCHEMA as $value) {
			$row["no"] = $i++;
			$row["typeData"]= $value["typeData"];
			$row["dataName"]= $value["dataName"];
			$row["newDataType"]= $value["newDataType"];
			$row["newDataLength"]= $value["newDataLength"];
			$row["newScaleLength"] = $value["newScaleLength"];
			$row["newUnique"]= $value["newUnique"];
			$row["newNotNull"]= $value["newNotNull"];
			$row["newDefaultValue"]= $value["newDefaultValue"];
			$row["newMinValue"] = $value["newMinValue"];
			$row["newMaxValue"] = $value["newMaxValue"];
			$row["tableName"]= $value["tableName"];
			$row["columnName"]= $value["columnName"];
			$row["changeType"]= $value["changeType"];
			array_push($data['change_list'],$row);
		}

		$RelateResultNotSCHEMA  = $this->mChange->searchChangeRequestNotrelateSCHEMA($param);
		foreach ($RelateResultNotSCHEMA as $value) {
			$row["no"] = $i++;
			$row["typeData"]= $value["typeData"];
			$row["dataName"]= $value["dataName"];
			$row["newDataType"]= $value["newDataType"];
			$row["newDataLength"]= $value["newDataLength"];
			$row["newScaleLength"] = $value["newScaleLength"];
			$row["newUnique"]= $value["newUnique"];
			$row["newNotNull"]= $value["newNotNull"];
			$row["newDefaultValue"]= $value["newDefaultValue"];
			$row["newMinValue"] = $value["newMinValue"];
			$row["newMaxValue"] = $value["newMaxValue"];
			$row["tableName"]= $value["tableName"];
			$row["columnName"]= $value["columnName"];
			$row["changeType"]= $value["changeType"];
			array_push($data['change_list'],$row);
		}
		
		return $data;
	}
	

	function bind_data_aff_functionalrequirement($param){
		$data = array();
		$data['aff_fr_list'] = array();
		/// *** call model and bind data here.
		$row=array();
		$ListofAffectFRRelateSchema = $this->mChange->checkChangeRequestrelateSCHEMA($param);
		$i = 1;
		$frId = "";
		$frVersion = "";
		$change_title = "edit";

		foreach($ListofAffectFRRelateSchema as $value){
			//echo $change_title;

			if($frId != $value["functionId"] && $frVersion != $value['functionVersion']){
				$row["no"] = $i++;
				$row["frId"]= $value["functionId"];
				$row["fr_no"] =$param->functionNo;
				$changetype = $this->mChange->searchTempFRInputChangeList($param);
				foreach($changetype as $new_type){
					if($change_title != $new_type['changeType']&& "edit" != $new_type['changeType']){
						$change_title = $new_type['changeType'];
					}
					if(('add' == $new_type["changeType"]) || ('delete' == $new_type["changeType"])) {
							$change_title = "delete";
					}										
				}
				$row["change_type"]= $change_title;
				$row["version"]= $value['functionVersion'];
				$frNo = $value["functionId"];
				$frVersion = $value['functionVersion'];
				array_push($data['aff_fr_list'],$row);
			}
		}
		
		$ListofAffectFRNotRelateSchema = $this->mChange->checkChangeRequestNotRelateSchema($param);
		foreach($ListofAffectFRNotRelateSchema as $value){

			//echo $change_title;

			if($frId != $value["functionId"] && $frVersion != $value['functionVersion']){
				$row["no"] = $i++;
				$row["frId"]= $value["functionId"];
				$row["fr_no"]= $param->functionNo;
				$changetype = $this->mChange->searchTempFRInputChangeList($param);
				foreach($changetype as $new_type){
					if($change_title != $new_type['changeType']&& "edit" != $new_type['changeType']){
						$change_title = $new_type['changeType'];
					}
					if(('add' == $new_type["changeType"]) || ('delete' == $new_type["changeType"])) {
							$change_title = "delete";
					}										
				}
				$row["change_type"]= $change_title;
				$row["version"]= $value['functionVersion'];
				array_push($data['aff_fr_list'],$row);
			}
		}

		//ListofAffectOthFr = $this->callImpactOthFunction($param);
		$ListofChangeSchemaOthFr = $this->mChange->checkChangeRequestrelateSCHEMAOtherFr($param);
		$fr_title = $frId.$frVersion ;
		$change_title = "edit";
		foreach($ListofChangeSchemaOthFr as $value){
			if($frId.$frVersion  != $value["FROth_Id"].$value["FROth_Version"] ){
				if($change_title != $value['changeType']&& "edit" != $value['changeType']){
					$change_title = $value['changeType'];
				}
				if(('add' == $value["changeType"]) || ('delete' == $value["changeType"])) {
						$change_title = "delete";
				}			
				$row['change_type'] = $change_title;
				$row["no"] = $i++;
				$row["fr_id"]= $value["FROth_Id"];
				$row["fr_no"]= $value["FROth_NO"];
				$row["version"]= $value['FROth_Version'];
				array_push($data['aff_fr_list'],$row);
				$frId = $value["FROth_Id"];
			}
		}
//print_r($data);
		return $data;
	}	

	function bind_data_aff_testcase($param){
		$data = array();
		$data['aff_testcase_list'] = array();
		/// *** call model and bind data here.
		$row=array();
		$ListofChangeSchemaOthFr = $this->mChange->checkOtherFr($param);
		//print_r($ListofChangeSchemaOthFr);
		$ListofTCAffected= $this->mChange->checkTestCaseAffected($param,$ListofChangeSchemaOthFr);
		//print_r($ListofTCAffected);
		$i = 1;
		$testNo = "";
		$testVersion = "";
		foreach($ListofTCAffected as $value)
		{
			$test_title = $testNo.$testVersion;
			if($test_title != $value["testCaseNo"].$value['testcaseVersion'] ){
				if($value["testCaseNo"] != ""){
					$row["no"] = $i++;
					$testNo = $row["test_no"]= $value["testCaseNo"];
					$testVersion = $row["version"]= $value['testcaseVersion'];
					if($value["tctype"] == 'Oth'){
						$changetype = "edit";
						$ListofAffectFRRelateSchema = $this->mChange->checkChangeRequestrelateSCHEMA($param);
						foreach($ListofAffectFRRelateSchema as $value){
							if($changetype != $value["changeType"] ){
								$changetype = $value['changeType'];
							}
						}					
					}else{
						$changetype = "edit";
						$RelateResultSCHEMA = $this->mChange->searchChangeRequestrelateSCHEMA($param);
						foreach($RelateResultSCHEMA as $value){
							if($changetype  != $value["changeType"] ){
								if(('add' == $value["changeType"]) || ('delete' == $value["changeType"])) {
									$changetype = "delete";
								}
							}
						}
						$RelateResultNotSCHEMA  = $this->mChange->searchChangeRequestNotrelateSCHEMA($param);
						foreach($RelateResultNotSCHEMA as $value){
							if(('add' == $value["changeType"]) || ('delete' == $value["changeType"])) {
								$changetype = "delete";
							}
						}
					}
					$row['change_type'] = $changetype;
					array_push($data['aff_testcase_list'],$row);
				}
			}
		}
//print_r($data);
		return $data;
	}

	function bind_data_aff_schema($param){
		$data = array();
		$data['aff_schema_list'] = array();
		/// *** call model and bind data here.
		$row=array();
		// $ListofAffectedSchema = $this->callImpactSchema($param);
		$ListofSchemaAffected= $this->mChange->checkSchemaAffted($param);
		$i = 1;
		foreach($ListofSchemaAffected as $value)
		{
			//for($i=1;$i<3;$i++){
			$row["no"] = $i++;
			$row["table_name"]= $value["tableName"];
			$row["column_name"]= $value["columnName"];
			$row["change_type"]= $value["changeType"];
			$row["version"]= $value["schemaVersionNumber"];

			array_push($data['aff_schema_list'],$row);
		}
		return $data;
	}

	function doChangeProcess(){ //requestChangeFRInputs
		$errorFlag = false;
		$success_message = '';
		$error_message = '';

		$functionNo = '';
		$changeRequestNo = '';
		$userId = $this->session->userdata('userId');
		$projectId = $this->input->post('projectId');
		$functionId = $this->input->post('functionId');
		$functionVersion = $this->input->post('functionVersion');

		//see this function to bind load data to template view
		//url -> ChangeManagementRequest/view_change_result/{projectId}
		$dataForPage = array();
		//echo $RelateResultSCHEMA->functionId;
		//for use query something and send to page

		//$this->load->library('common');
		//echo $functionId;
		try{
			/** 1.Validate
			*** 1.1 Check Temp Change List Data
			**/
			$criteria = (object) array('userId' => $userId, 'functionId' => $functionId, 'functionVersion' => $functionVersion);
			$resultExistTempChangeList = $this->mChange->searchTempFRInputChangeList($criteria);
			if(null == $resultExistTempChangeList || 0 == count($resultExistTempChangeList)){
				$error_message = ER_TRN_010;
				//$this->reloadPage($error_message, $projectId, $functionId, $functionVersion);
				$this->loadpage($error_message, $projectId, $functionId, $functionVersion);
				return false;
			}

			/* 1.2 Check status of Requirement Header */
			$criteria->status = '1';
			$resultReqHeader = $this->mFR->searchFunctionalRequirementHeaderInfo($criteria);
			if(null == $resultReqHeader || 0 == count($resultReqHeader)){
				$error_message = ER_TRN_011;
				$this->loadpage($error_message, $projectId, $functionId, $functionVersion);

//				$this->reloadPage($error_message, $projectId, $functionId, $functionVersion);
				return false;
			}else{
				$functionNo = $resultReqHeader[0]['functionNo'];
			}

			/** 2.Call Change API */
			$param = (object) array(
				'projectId' 	  => $projectId,
				'functionId' 	  => $functionId,
				'functionNo' 	  => $functionNo,
				'functionVersion' => $functionVersion,
				'changeRequestNo' => '',
				'userId'		  => $userId,
				'type' 	 		  => 1, //1 = Change, 2 = Cancel
				'fnDesc'		  => $resultReqHeader[0]['fnDesc']
			);

			$title = $this->bind_data_title($param);
			$chglist = $this->bind_data_change_list($param);
			$affFrList = $this->bind_data_aff_functionalrequirement($param);
			$affSchemalist = $this->bind_data_aff_schema($param);
			$affTestCaseList = $this->bind_data_aff_testcase($param);

			$dataForPage["functionId"] = $param->functionId;
			$dataForPage["projectId"] = $param->projectId;

			//send to page result/index 
			$dataForPage["title_panel"]= $title;
			$dataForPage["change_panel"]=$chglist;
			$dataForPage["aff_fr_panel"]=$affFrList;
			$dataForPage["aff_testcase_panel"]=$affTestCaseList;
			$dataForPage["aff_schema_panel"] = $affSchemalist;

			$this->load->view('template/header');
			$data = array();
			$data['active_title'] = 'ChangeManagement';
			$data['active_page'] = 'trns001';
			$data['html'] = 'ChangeManagement/results/index';//$this->load->view('ChangeManagement/results/index',$dataForPage);
			$data['dataForPage']= $dataForPage;
			$this->load->view('template/menu',$data);
			$this->load->view('template/body_javascript');

			$this->load->view('template/footer');

		}catch(Exception $e){
			$errorFlag = true;
			$error_message = $e;
		}

		$data['success_message'] = $success_message;
		$data['error_message'] = $error_message;
	}
	/*
	function callChangeRelate($param){//แยก รายการ change ที่ realte
	//print_r($param);
		//กรองรายการ change ที่สัมพันธ์กับ SCHEMA
		$RelateResultSCHEMA = $this->mChange->searchChangeRequestrelateSCHEMA($param);
		foreach ($RelateResultSCHEMA as $value) {
			$param_schema = (object) array(
				'lineNumber' 	  	=> $value['lineNumber'],
				'userId' 	  		=> $value['userId'],
				'functionId' 	  	=> $value['functionId'],
				'functionVersion' 	=> $value['functionVersion'],
				'typeData' 			=> $value['typeData'],
				'dataName'		  	=> $value['dataName'],
				'schemaVersionId' 	=> $value['schemaVersionId'],
				'newDataType' 	  	=> $value['newDataType'],
				'newDataLength'  	=> $value['newDataLength'],
				'newScaleLength' 	=> $value['newScaleLength'],
				'newUnique' 		=> $value['newUnique'],
				'newNotNull'		=> $value['newNotNull'],
				'newDefaultValue' 	=> $value['newDefaultValue'],
				'newMinValue' 	  	=> $value['newMinValue'],
				'newMaxValue' 		=> $value['newMaxValue'],
				'tableName' 		=> $value['tableName'],
				'columnName'		=> $value['columnName'],
				'changeType' 	 	=> $value['changeType'],
				'createUser'		=> $value['createUser'],
				'createDate' 	  	=> $value['createDate'],
				'dataId' 	  		=> $value['dataId'],
				'confirmflag' 		=> $value['confirmflag'],
				'approveflag' 		=> $value['approveflag']
				);	
		}
		return $param_schema;
	}
	function callChangenotRelate($param){//แยก รายการ change ที่ไม่ relate
		//กรองรายการ change ที่ไม่สัมพันธ์กับ SCHEMA
		$NotRelateResultSCHEMA = $this->mChange->searchChangeRequestNotrelateSCHEMA($param);
		foreach ($NotRelateResultSCHEMA as $value) {
			$param_notschema = (object) array(
				'lineNumber' 	  	=> $value['lineNumber'],
				'userId' 	  		=> $value['userId'],
				'functionId' 	  	=> $value['functionId'],
				'functionVersion' 	=> $value['functionVersion'],
				'typeData' 			=> $value['typeData'],
				'dataName'		  	=> $value['dataName'],
				'schemaVersionId' 	=> $value['schemaVersionId'],
				'newDataType' 	  	=> $value['newDataType'],
				'newDataLength'  	=> $value['newDataLength'],
				'newScaleLength' 	=> $value['newScaleLength'],
				'newUnique' 		=> $value['newUnique'],
				'newNotNull'		=> $value['newNotNull'],
				'newDefaultValue' 	=> $value['newDefaultValue'],
				'newMinValue' 	  	=> $value['newMinValue'],
				'newMaxValue' 		=> $value['newMaxValue'],
				'tableName' 		=> $value['tableName'],
				'columnName'		=> $value['columnName'],
				'changeType' 	 	=> $value['changeType'],
				'createUser'		=> $value['createUser'],
				'createDate' 	  	=> $value['createDate'],
				'dataId' 	  		=> $value['dataId'],
				'confirmflag' 		=> $value['confirmflag'],
				'approveflag' 		=> $value['approveflag']
				);	
		}
		return $param_notschema;
	}
		#======START FUNCTIONAL REQUIREMENT=======
	function callImpactFunctionRelate($param){
		//เช็ครายการเปลี่ยนแปลง โดยมีชื่อ tableName กับ tablecolumn เหมือนกัน สัมพันธ์กับ SCHEMA
		$ListofFRRelateSchema = $this->mChange->checkChangeRequestrelateSCHEMA($param);
			foreach ($ListofFRRelateSchema as $value) {
				$param_Fr_relate = (object) array(
					'lineNumber' 	  	=> $value['lineNumber'],
					'userId' 	  		=> $value['userId'],
					'functionId' 	  	=> $value['functionId'],
					'functionVersion' 	=> $value['functionVersion'],
					'typeData' 			=> $value['typeData'],
					'dataName'		  	=> $value['dataName'],
					'schemaVersionId' 	=> $value['schemaVersionId'],
					'newDataType' 	  	=> $value['newDataType'],
					'newDataLength'  	=> $value['newDataLength'],
					'newScaleLength' 	=> $value['newScaleLength'],
					'newUnique' 		=> $value['newUnique'],
					'newNotNull'		=> $value['newNotNull'],
					'newDefaultValue' 	=> $value['newDefaultValue'],
					'newMinValue' 	  	=> $value['newMinValue'],
					'newMaxValue' 		=> $value['newMaxValue'],
					'tableName' 		=> $value['tableName'],
					'columnName'		=> $value['columnName'],
					'changeType' 	 	=> $value['changeType'],
					'createUser'		=> $value['createUser'],
					'createDate' 	  	=> $value['createDate'],
					'dataId' 	  		=> $value['dataId'],
					'confirmflag' 		=> $value['confirmflag'],
					'approveflag' 		=> $value['approveflag'],
					'FR_NAME'			=> $value['FR_NAME']
					);		
				}
			return $param_Fr_relate;
	}


	function callImpactFunctionNotRelate($param){
		//รายการเปลี่ยนแปลงที่ไม่ relate กับ schema
		$ListofChangeNotSchema = $this->mChange->checkChangeRequestNotRelateSchema($param);
		if(0 < count($ListofChangeNotSchema)){
			foreach ($ListofChangeNotSchema as $value) {
				$param_Fr_Notrelate = (object) array(
					'lineNumber' 	  	=> $value['lineNumber'],
					'userId' 	  		=> $value['userId'],
					'functionId' 	  	=> $value['functionId'],
					'functionVersion' 	=> $value['functionVersion'],
					'typeData' 			=> $value['typeData'],
					'dataName'		  	=> $value['dataName'],
					'schemaVersionId' 	=> $value['schemaVersionId'],
					'newDataType' 	  	=> $value['newDataType'],
					'newDataLength'  	=> $value['newDataLength'],
					'newScaleLength' 	=> $value['newScaleLength'],
					'newUnique' 		=> $value['newUnique'],
					'newNotNull'		=> $value['newNotNull'],
					'newDefaultValue' 	=> $value['newDefaultValue'],
					'newMinValue' 	  	=> $value['newMinValue'],
					'newMaxValue' 		=> $value['newMaxValue'],
					'tableName' 		=> $value['tableName'],
					'columnName'		=> $value['columnName'],
					'changeType' 	 	=> $value['changeType'],
					'createUser'		=> $value['createUser'],
					'createDate' 	  	=> $value['createDate'],
					'dataId' 	  		=> $value['dataId'],
					'confirmflag' 		=> $value['confirmflag'],
					'approveflag' 		=> $value['approveflag'],
					'FR_NAME'			=> $value['FR_NAME']
					);
				}	
		}else{
			$param_Fr_Notrelate = null;
		}
		return $param_Fr_Notrelate;
	}
	
	function callImpactOthFunction($param){
		// รายการเปลี่ยนแปลงที่กระทบกับ FR อื่นๆ ที่มี SCHEMA เดียวกัน
		$ListofChangeSchemaOthFr = $this->mChange->checkChangeRequestrelateSCHEMAOtherFr($param);
		if(0 < count($ListofChangeSchemaOthFr)){
			foreach ($ListofChangeSchemaOthFr as $value) {
				$param_OthFr = (object) array(
					'lineNumber' 	  	=> $value['lineNumber'],
					'userId' 	  		=> $value['userId'],
					'functionId' 	  	=> $value['functionId'],
					'functionVersion' 	=> $value['functionVersion'],
					'typeData' 			=> $value['typeData'],
					'dataName'		  	=> $value['dataName'],
					'schemaVersionId' 	=> $value['schemaVersionId'],
					'newDataType' 	  	=> $value['newDataType'],
					'newDataLength'  	=> $value['newDataLength'],
					'newScaleLength' 	=> $value['newScaleLength'],
					'newUnique' 		=> $value['newUnique'],
					'newNotNull'		=> $value['newNotNull'],
					'newDefaultValue' 	=> $value['newDefaultValue'],
					'newMinValue' 	  	=> $value['newMinValue'],
					'newMaxValue' 		=> $value['newMaxValue'],
					'tableName' 		=> $value['tableName'],
					'columnName'		=> $value['columnName'],
					'changeType' 	 	=> $value['changeType'],
					'createUser'		=> $value['createUser'],
					'createDate' 	  	=> $value['createDate'],
					'dataId' 	  		=> $value['dataId'],
					'confirmflag' 		=> $value['confirmflag'],
					'approveflag' 		=> $value['approveflag'],
					'FR_NAME'			=> $value['FR_NAME'],
					'FROth_Id'		=> $value['FROth_Id'],
					'FROth_Version'	 => $value['FROth_Version'],
					'FROth_functionNo'	=> $value['FROth_NO']
					);
			}		
		}else{
			$param_OthFr = null;
		}
		return $param_OthFr;
	}
	
		#========START TESTCASE AFFECTED====
	function callImpactTestCase($param,$ListofChangeSchemaOthFr){
		$ListofTCAffected= $this->mChange->checkTestCaseAffected($param,$ListofChangeSchemaOthFr);
		if(0 < count($ListofTCAffected)){
			foreach ($ListofTCAffected as $value) {
				$param_TC = (object) array(
					'testCaseId' 	  		=> $value['testCaseId'],
					'testCaseNo' 	  		=> $value['testCaseNo'],
					'testcaseVersion' 	  	=> $value['testcaseVersion'],
					'typeData' 				=> $value['typeData'],
					'TC_NAME' 				=> $value['TC_NAME'],
					'testData'		  		=> $value['testData'],
					'CH_NAME' 	  			=> $value['CH_NAME'],
					'changeType' 	  		=> $value['changeType'],
					'newdataType' 	  		=> $value['newdataType'],
					'newDataLength' 		=> $value['newDataLength'],
					'newScaleLength' 		=> $value['newScaleLength'],
					'newUnique'		  		=> $value['newUnique'],
					'newDefaultValue' 	  	=> $value['newDefaultValue'],
					'newMinValue' 	  		=> $value['newMinValue'],
					'newMaxValue' 			=> $value['newMaxValue']
					);		
			}			
		}else{
			$param_TC = null;
		}
		return $param_TC;
	}
		#========START SCHEMA AFFECTED======
	function callImpactSchema($param){
		//เก้บ SCHEMA ที่ได้รับผลกระทบ
		$ListofSchemaAffected= $this->mChange->checkSchemaAffted($param);
		if(0 < count($ListofSchemaAffected)){
			foreach ($ListofSchemaAffected as $value) {
				$param_schema = (object) array(
					'functionId' 	  		=> $value['functionId'],
					'functionversion' 	  	=> $value['functionversion'],
					'changeType'				=> $value['changeType'],
					'projectId' 	  		=> $value['projectId'],
					'schemaVersionId'		=> $value['schemaVersionId'],
					'schemaVersionNumber'		=> $value['schemaVersionNumber'],
					'tableName' 			=> $value['tableName'],
					'columnName' 			=> $value['columnName']
					);				
				}
		}else{
			$param_schema = null;
		}
		return $param_schema;
	}
	*/
	function testscript(){
		$prjId = $this->input->post('projectId');
		$funId = $this->input->post('functionId');
		$CH_NO = $this->input->post('CH_NO');
		$FR_Version = $this->input->post('FR_Version');
		$FR_Description = $this->input->post('FR_Description');
		$data = array(
			'success' => true,
			'result'=> 'test',
		);
		echo json_encode($data);
	}

	function testfunction(){
/*		$param = (object) array(
			'projectId' 	  => "2" ,
			'functionId' 	  => "25",
			'functionNo' 	  => "OS_FR_03",
			'functionVersion' => "1",
			'changeRequestNo' => "CH01",
			'userId'		  => "0001",
			'type' 	 		  => 1, //1 = Change, 2 = Cancel
			'fnDesc'		  => "Create Order List"
		);*/
		$prjId = $this->input->post('projectId');
		$funId = $this->input->post('functionId');
		$funNo = $this->input->post('functionNo');
		$CH_NO = $this->input->post('CH_NO');
		$FR_Version = $this->input->post('FR_Version');
		$FR_Description = $this->input->post('FR_Description');
		$userId = $this->session->userdata('userId');

		$param = (object) array(
			'projectId' 	  => $prjId ,
			'functionId' 	  => $funId,
			'functionNo' 	  => $funNo,
			'functionVersion' => $FR_Version,
			'changeRequestNo' => $CH_NO,
			'type' 	 		  => 1, //1 = Change, 2 = Cancel
			'userId'				=> 	$userId,
			'fnDesc'		  => $FR_Description
		);
		$ListChange = $this->callChangeRelate($param);
			//print_r($ListChange);
		
	}

	function aff_functionalrequirement($param){
		$data = array();
		$data['aff_fr_list'] = array();
		/// *** call model and bind data here.
		$row=array();
		$ListofAffectFRRelateSchema = $this->mChange->checkChangeRequestrelateSCHEMA($param);
		$i = 1;
		$frId = "";
		$frVersion = "";
		$change_title = "edit";

		foreach($ListofAffectFRRelateSchema as $value){
			//echo $change_title;

			if($frId != $value["functionId"] && $frVersion != $value['functionVersion']){
				$row["no"] = $i++;
				$row["frId"]= $value["functionId"];
				$row["fr_no"] =$param->functionNo;
				$changetype = $this->mChange->searchTempFRInputChangeList($param);
				foreach($changetype as $new_type){
					if($change_title != $new_type['changeType']&& "edit" != $new_type['changeType']){
						$change_title = $new_type['changeType'];
					}
					if(('add' == $new_type["changeType"]) || ('delete' == $new_type["changeType"])) {
							$change_title = "delete";
					}										
				}
				$row["change_type"]= $change_title;
				$row["version"]= $value['functionVersion'];
				$frNo = $value["functionId"];
				$frVersion = $value['functionVersion'];
				array_push($data['aff_fr_list'],$row);
			}
		}
		
		$ListofAffectFRNotRelateSchema = $this->mChange->checkChangeRequestNotRelateSchema($param);
		foreach($ListofAffectFRNotRelateSchema as $value){

			//echo $change_title;

			if($frId != $value["functionId"] && $frVersion != $value['functionVersion']){
				$row["no"] = $i++;
				$row["frId"]= $value["functionId"];
				$row["fr_no"]= $param->functionNo;
				$changetype = $this->mChange->searchTempFRInputChangeList($param);
				foreach($changetype as $new_type){
					if($change_title != $new_type['changeType']&& "edit" != $new_type['changeType']){
						$change_title = $new_type['changeType'];
					}
					if(('add' == $new_type["changeType"]) || ('delete' == $new_type["changeType"])) {
							$change_title = "delete";
					}										
				}
				$row["change_type"]= $change_title;
				$row["version"]= $value['functionVersion'];
				array_push($data['aff_fr_list'],$row);
			}
		}
		return $data;

}

function aff_Oth_functionalrequirement($param){
	$data = array();
	$data['aff_fr_list'] = array();
	/// *** call model and bind data here.
	$row=array();
	$i = 1;
	$frId = "";
	$frVersion = "";
	$change_title = "edit";

		$ListofChangeSchemaOthFr = $this->mChange->checkChangeRequestrelateSCHEMAOtherFr($param);
		$fr_title = $frId.$frVersion ;
		$change_title = "edit";
		foreach($ListofChangeSchemaOthFr as $value){
			if($frId.$frVersion  != $value["FROth_Id"].$value["FROth_Version"] ){
				if($change_title != $value['changeType']&& "edit" != $value['changeType']){
					$change_title = $value['changeType'];
				}
				if(('add' == $value["changeType"]) || ('delete' == $value["changeType"])) {
						$change_title = "delete";
				}			
				$row['change_type'] = $change_title;
				$row["no"] = $i++;
				$row["fr_id"]= $value["FROth_Id"];
				$row["fr_no"]= $value["FROth_NO"];
				$row["version"]= $value['FROth_Version'];
				$row["fnDesc"]= $value['FROth_Desc'];
				array_push($data['aff_fr_list'],$row);
				$frId = $value["FROth_Id"];
			}
		}

		return $data;
	}

	function aff_testcase($param){
		$data = array();
		$data['aff_testcase_list'] = array();
		/// *** call model and bind data here.
		$row=array();
		$ListofChangeSchemaOthFr = $this->mChange->checkOtherFr($param);
		//print_r($ListofChangeSchemaOthFr);
		$ListofTCAffected= $this->mChange->checkTestCaseAffected($param,$ListofChangeSchemaOthFr);
		//print_r($ListofTCAffected);
		$i = 1;
		$testNo = "";
		$testVersion = "";
		foreach($ListofTCAffected as $value)
		{
			$test_title = $testNo.$testVersion;
			if($test_title != $value["testCaseNo"].$value['testcaseVersion'] ){
				if($value["testCaseNo"] != ""){
					$row["no"] = $i++;
					$testNo = $row["test_no"]= $value["testCaseNo"];
					$testVersion = $row["version"]= $value['testcaseVersion'];
					if($value["tctype"] == 'Oth'){
						$changetype = "edit";
						$ListofAffectFRRelateSchema = $this->mChange->checkChangeRequestrelateSCHEMA($param);
						foreach($ListofAffectFRRelateSchema as $value){
							if($changetype != $value["changeType"] ){
								$changetype = $value['changeType'];
							}
						}					
					}else{
						$changetype = "edit";
						$RelateResultSCHEMA = $this->mChange->searchChangeRequestrelateSCHEMA($param);
						foreach($RelateResultSCHEMA as $value){
							if($changetype  != $value["changeType"] ){
								if(('add' == $value["changeType"]) || ('delete' == $value["changeType"])) {
									$changetype = "delete";
								}
							}
						}
						$RelateResultNotSCHEMA  = $this->mChange->searchChangeRequestNotrelateSCHEMA($param);
						foreach($RelateResultNotSCHEMA as $value){
							if(('add' == $value["changeType"]) || ('delete' == $value["changeType"])) {
								$changetype = "delete";
							}
						}
					}
					$row['change_type'] = $changetype;
					array_push($data['aff_testcase_list'],$row);
				}
			}
		}
//print_r($data);
		return $data;
	}

	function confirm_change_request(){
		$prjId = $this->input->post('projectId');
		$funId = $this->input->post('functionId');
		$funNo = $this->input->post('functionNo');
		$CH_NO = $this->input->post('CH_NO');
		$FR_Version = $this->input->post('FR_Version');
		$FR_Description = $this->input->post('FR_Description');
		$userId = $this->session->userdata('userId');
		$user = $this->session->userdata('username');

		$param = (object) array(
			'projectId' 	  => $prjId ,
			'functionId' 	  => $funId,
			'functionNo' 	  => $funNo,
			'functionVersion' => $FR_Version,
			'changeRequestNo' => $CH_NO,
			'userId'				=> 	$userId,			
			'type' 	 		  => 1, //1 = Change, 2 = Cancel
			'fnDesc'		  => $FR_Description,
			'user'				=> $user
		);

	//	$affFrList = $this->bind_data_aff_functionalrequirement($param);
		$affSchemalist = $this->bind_data_aff_schema($param);
		foreach($affSchemalist as $land => $data){
			foreach($data as $detail => $value)
			{
				$schema_list_aff = (object) array(
					'changeRequestNo' 		=> $CH_NO,
					'tableName'						=> $value['table_name'],
					'columnName'					=> $value['column_name'],
					'changeType'					=> $value['change_type'],
					'version'							=> $value['version']					
				);	
				$this->mVersion->insertlogAffSchema($schema_list_aff);
			}		
		}			

		$affTestCaseList = $this->bind_data_aff_testcase($param);
		foreach($affTestCaseList as $land => $data){
			foreach($data as $detail => $value)
			{
				$test_list_aff = (object) array(
					'changeRequestNo' 		=> $CH_NO,
					'testcaseNo'					=> $value['test_no'],
					'testcaseVersion'			=> $value['version'],
					'changeType'					=> $value['change_type']
				);
				//print_r($test_list_aff);
				$this->mVersion->insertlogAffTestcase($test_list_aff);
					//5.Control Version TESTCASE
				if(0 < count($test_list_aff)){
					$recordUpdate  = $this->mVersion->updateTestcaseHeader($param,$test_list_aff);
					$recordUpdate1 = $this->mVersion->updateTestcaseDetail($param,$test_list_aff);		
				}

				if($test_list_aff->changeType != 'edit'){
					$New_testcaseVersion = '1'
				}
			}		
		}
		
		$newCurrentDate = date('Y-m-d H:i:s');

		//1. save change request header.
		$paramInsert = (object) array(
			'changeRequestNo' => $param->changeRequestNo,
			'changeUser' => $param->userId,
			'changeDate' => $newCurrentDate,
			'projectId' => $param->projectId,
			'changeFunctionId' => $param->functionId,
			'changeFunctionNo' => $param->functionNo,
			'changeFunctionVersion' => $param->functionVersion,
			'changeStatus' => $param->type,
			'user' => $param->user,
			'currentDate' => $newCurrentDate
		);
		$this->mChange->insertChangeRequestHeader($paramInsert);

		//2. save change request details.
		$i = 1;
		$RelateResultSCHEMA = $this->mChange->searchChangeRequestrelateSCHEMA($param);
		foreach ($RelateResultSCHEMA as $value) {
			$paramInsert = (object) array(
				'changeRequestNo' => $param->changeRequestNo,
				'sequenceNo' => $i++,
				'typeData'	=> $value['typeData'],
				'changeType' => $value['changeType'],
				'dataId' => $value['dataId'],
				'dataName' => $value['dataName'], 
				'schemaVersionId' => $value['schemaVersionId'],
				'dataType' => $value['newDataType'],
				'dataLength' => $value['newDataLength'],
				'scale' => $value['newScaleLength'],
				'unique' => $value['newUnique'],
				'notNull' => $value['newNotNull'],
				'default' => $value['newDefaultValue'],
				'min' => $value['newMinValue'],
				'max' => $value['newMaxValue'],
				'tableName' => $value['tableName'],
				'columnName' => $value['columnName']);
			$this->mChange->insertChangeRequestDetail($paramInsert);		
		}

		$RelateResultNotSCHEMA  = $this->mChange->searchChangeRequestNotrelateSCHEMA($param);
		foreach ($RelateResultNotSCHEMA as $value) {
			$paramInsert = (object) array(
				'changeRequestNo' => $param->changeRequestNo,
				'sequenceNo' => $i++,
				'changeType' => $value['changeType'],
				'typeData'	=> $value['typeData'],
				'dataId' => $value['dataId'],
				'dataName' => $value['dataName'], 
				'schemaVersionId' => $value['schemaVersionId'],
				'dataType' => $value['newDataType'],
				'dataLength' => $value['newDataLength'],
				'scale' => $value['newScaleLength'],
				'unique' => $value['newUnique'],
				'notNull' => $value['newNotNull'],
				'default' => $value['newDefaultValue'],
				'min' => $value['newMinValue'],
				'max' => $value['newMaxValue'],
				'tableName' => $value['tableName'],
				'columnName' => $value['columnName']);
			$this->mChange->insertChangeRequestDetail($paramInsert);				
		}

		//3. save change history requirement header
		$rowUpdate = $this->mVersion->updateRequirementsHeader($param);
		//print_r($rowUpdate);

		//3.1 save change history requirement detail
		$rowUpdate = $this->mVersion->updateChange_RequirementsDetail($param);

		//3.2 save change New requirement header
		$data = $this->aff_functionalrequirement($param);
		//print_r($data);
		foreach($data as $value ){
			$Change_FR_type = $value[0]['change_type'];
		}
		//print_r($Change_FR_type);
		if($Change_FR_type != 'edit'){
			$New_FunctionId = $this->mVersion->InsertNewRequirementsHeader($param);
		}else{
			$New_FunctionId = $this->mVersion->InsertRequirementsHeader($param);
		}
		//print_r($New_FunctionId);
		$NewFR = $this->mVersion->SearchRequirementsDetail($param,$New_FunctionId);
		foreach($NewFR as $value){
				$New_param = (object) array(
					'projectId'		=> $value['projectId'],
						'functionNo' => $value['functionNo'],
						'functionversion'   => $value['functionVersion'],
						'functionId'	 => $value['functionId']
				);
		}
		$MAP_FR = $this->mVersion->MapFRVersion($param,$New_param);

		//print_r($New_param);
		//3.3 save change New requirement detail
		$InsertNew = $this->mVersion->InsertChange_RequirementsDetail($param,$New_param);
		if(0 < count($InsertNew)){
		//	print_r($InsertNew);
		$RelateResultSCHEMA = $this->mChange->searchChangeRequestrelateSCHEMA($param);
		//print_r($RelateResultSCHEMA);
					foreach ($RelateResultSCHEMA as $value){
					$paramUpdate = (object) array(
						'changeType' => $value['changeType'],
						'dataId' => $value['dataId'],
						'typeData'	=> $value['typeData'],
						'dataName' => $value['dataName'], 
						'newDataType' => $value['newDataType'],
						'newDataLength' => $value['newDataLength'],
						'newScaleLength' => $value['newScaleLength'],
						'newUnique' => $value['newUnique'],
						'newNotNull' => $value['newNotNull'],
						'newDefaultValue' => $value['newDefaultValue'],
						'newMinValue' => $value['newMinValue'],
						'newMaxValue' => $value['newMaxValue'],
						'tableName' => $value['tableName'],
						'columnName' => $value['columnName']);
//print_r($paramUpdate);
			//print_r($paramUpdate->changeType);		
			
						if($paramUpdate->changeType == 'edit'){
							$recordUpdate = $this->mVersion->updateChangeRequestDetail($param,$paramUpdate,$New_FunctionId);		
							}else if($paramUpdate->changeType == 'delete'){
							$recordDelete = $this->mVersion->deleteChangeRequestDetail($param,$paramUpdate,$New_FunctionId);		
						}else if($paramUpdate->changeType == 'add'){
							$recordAdd = $this->mVersion->addChangeRequestDetail($param,$paramUpdate,$New_FunctionId);		
						}
				
				}
	
		$RelateResultNotSCHEMA = $this->mChange->searchChangeRequestNotrelateSCHEMA($param);
				foreach ($RelateResultNotSCHEMA as $value){
					$paramUpdate = (object) array(
						'changeType' => $value['changeType'],
						'dataId' => $value['dataId'],
						'typeData'	=> $value['typeData'],
						'dataName' => $value['dataName'], 
						'newDataType' => $value['newDataType'],
						'newDataLength' => $value['newDataLength'],
						'newScaleLength' => $value['newScaleLength'],
						'newUnique' => $value['newUnique'],
						'newNotNull' => $value['newNotNull'],
						'newDefaultValue' => $value['newDefaultValue'],
						'newMinValue' => $value['newMinValue'],
						'newMaxValue' => $value['newMaxValue'],
						'tableName' => $value['tableName'],
						'columnName' => $value['columnName']);
						//print_r($paramUpdate->changeType);		

						if($paramUpdate->changeType == 'edit'){
							$recordUpdate = $this->mVersion->updateChangeRequestDetail($param,$paramUpdate,$New_FunctionId);		
							}else if($paramUpdate->changeType == 'delete'){
							$recordDelete = $this->mVersion->deleteChangeRequestDetail($param,$paramUpdate,$New_FunctionId);		
						}else if($paramUpdate->changeType == 'add'){
							$recordAdd = $this->mVersion->addChangeRequestDetail($param,$paramUpdate,$New_FunctionId);		
						}
				
				}

			}
		
		$data = $this->aff_Oth_functionalrequirement($param);
		//print_r($data);
	if(0 < count($data)){
			foreach($data as $value){
				$param_Oth = (object) array (
					'projectId' 	  => $prjId ,
					'functionId' 			=> $value[0]['fr_id'],
					'functionVersion'	=> $value[0]['version'],
					'functionNo'			=> $value[0]['fr_no'],
					'changeRequestNo' => $CH_NO,
					'type' 	 		  		=> 1, //1 = Change, 2 = Cancel
					'userId'					=> $userId,
					'user'						=> $user,
					'fnDesc'		  		=> $value[0]['fnDesc'],
					'Change_FR_type' 	=> $value[0]['change_type']
					);
			}
			
			//print_r($param_Oth);
				//3.4 save change history requirement header  ของ Oth FR
				$rowUpdate = $this->mVersion->updateRequirementsHeader($param_Oth);
				//print_r($rowUpdate);

				//3.5 save change history requirement detail ของ Oth FR
				$rowUpdate = $this->mVersion->updateChange_RequirementsDetail($param_Oth);			

				//print_r($Change_FR_type);
				if($param_Oth->Change_FR_type != 'edit'){
					$New_FunctionId = $this->mVersion->InsertNewRequirementsHeader($param_Oth);
				}else{
					$New_FunctionId = $this->mVersion->InsertRequirementsHeader($param_Oth);
				}
				//print_r($New_FunctionId);

				$NewFR = $this->mVersion->SearchRequirementsDetail($param_Oth,$New_FunctionId);
				foreach($NewFR as $value){
						$New_param_Oth = (object) array(
								'projectId' 	  		=> $prjId ,
								'functionNo' 				=> $value['functionNo'],
								'functionversion'   => $value['functionVersion'],
								'functionId'	 			=> $value['functionId'],
								'fnDesc'		  			=> $value['functionDescription'],
								'changeRequestNo' 	=> $CH_NO,
								'type' 	 		  			=> 1, //1 = Change, 2 = Cancel
								'userId'						=> $userId,
								'user'							=> $user			
						);
				}
				$MAP_FR = $this->mVersion->MapFRVersion($param_Oth,$New_param_Oth);

				//print_r($New_param);
				//3.7 save change New requirement detail ของ Oth FR
					$InsertNew = $this->mVersion->InsertChange_RequirementsDetail($param_Oth,$New_param_Oth);
				if(0 < count($InsertNew)){
					//print_r($InsertNew);
			$RelateResultSCHEMA = $this->mChange->searchChangeRequestrelateSCHEMA($param);
				//print_r($RelateResultSCHEMA);
							foreach ($RelateResultSCHEMA as $value){
							$paramUpdate = (object) array(
								'changeType' => $value['changeType'],
								'dataId' => $value['dataId'],
								'typeData'	=> $value['typeData'],
								'dataName' => $value['dataName'], 
								'newDataType' => $value['newDataType'],
								'newDataLength' => $value['newDataLength'],
								'newScaleLength' => $value['newScaleLength'],
								'newUnique' => $value['newUnique'],
								'newNotNull' => $value['newNotNull'],
								'newDefaultValue' => $value['newDefaultValue'],
								'newMinValue' => $value['newMinValue'],
								'newMaxValue' => $value['newMaxValue'],
								'tableName' => $value['tableName'],
								'columnName' => $value['columnName']);
		//print_r($paramUpdate);
					//print_r($paramUpdate->changeType);		
					
								if($paramUpdate->changeType == 'edit'){
									$recordUpdate = $this->mVersion->updateChangeRequestDetail($param_Oth,$paramUpdate,$New_FunctionId);		
									}else if($paramUpdate->changeType == 'delete'){
									$recordDelete = $this->mVersion->deleteChangeRequestDetail($param_Oth,$paramUpdate,$New_FunctionId);		
								}else if($paramUpdate->changeType == 'add'){
									$recordAdd = $this->mVersion->addChangeRequestDetail($param_Oth,$paramUpdate,$New_FunctionId);		
								}
						
						}
			
				$RelateResultNotSCHEMA = $this->mChange->searchChangeRequestNotrelateSCHEMA($param_Oth);
						foreach ($RelateResultNotSCHEMA as $value){
							$paramUpdate = (object) array(
								'changeType' => $value['changeType'],
								'dataId' => $value['dataId'],
								'typeData'	=> $value['typeData'],
								'dataName' => $value['dataName'], 
								'newDataType' => $value['newDataType'],
								'newDataLength' => $value['newDataLength'],
								'newScaleLength' => $value['newScaleLength'],
								'newUnique' => $value['newUnique'],
								'newNotNull' => $value['newNotNull'],
								'newDefaultValue' => $value['newDefaultValue'],
								'newMinValue' => $value['newMinValue'],
								'newMaxValue' => $value['newMaxValue'],
								'tableName' => $value['tableName'],
								'columnName' => $value['columnName']);
								//print_r($paramUpdate->changeType);		

								if($paramUpdate->changeType == 'edit'){
									$recordUpdate = $this->mVersion->updateChangeRequestDetail($param_Oth,$paramUpdate,$New_FunctionId);		
									}else if($paramUpdate->changeType == 'delete'){
									$recordDelete = $this->mVersion->deleteChangeRequestDetail($param_Oth,$paramUpdate,$New_FunctionId);		
								}else if($paramUpdate->changeType == 'add'){
									$recordAdd = $this->mVersion->addChangeRequestDetail($param_Oth,$paramUpdate,$New_FunctionId);		
								}
						
						}
					}
			}

			//4.Control Version SCHEMA
			$RelateResultSCHEMA = $this->mVersion->searchTablerelateSCHEMA($param);
			//print_r($RelateResultSCHEMA);
			foreach ($RelateResultSCHEMA as $value) {
				$paramInsert = (object) array(
					'tableName' => $value['tableName']
				);
				//print_r($paramInsert);
			$recordUpdate  = $this->mVersion->updateDatabaseSchemaVersion($param,$paramInsert);
			$recordUpdate1 = $this->mVersion->updateDatabaseSchemaInfo($param,$paramInsert);		
			$recordUpdate2 =	$this->mVersion->insertDatabaseSchemaVersion($param,$paramInsert);
			$recordUpdate3 =	$this->mVersion->insertDatabaseSchemaInfo($param,$paramInsert);
			}
			//print_r($rowUpdate);
	
	//4.1 save MAP DB
			$NewDB = $this->mVersion->SearchDatabaseSchemaDetail($param,$paramInsert);
			foreach($NewDB as $value){
					$New_param_DB = (object) array(
						'tableName'			=> $value['tableName'],
							'schemaVersionNumber' => $value['schemaVersionNumber']
						);
			}
			if(0 < count($New_param)){
				$MAP_FR = $this->mVersion->MapDBVersion($New_param,$New_param_DB);
			}
			if(0 < count($New_param_Oth)){
				$MAP_FR = $this->mVersion->MapDBVersion($New_param_Oth,$New_param_DB);
			}
		
			//4.2 save change history DB detail		
			$RelateResultSCHEMA = $this->mChange->searchChangeRequestrelateSCHEMA($param);
			//print_r($RelateResultSCHEMA);
			if(0 < count($RelateResultSCHEMA)){
				foreach ($RelateResultSCHEMA as $value){
					$paramUpdate_DB = (object) array(
						'changeType' => $value['changeType'],
						'dataId' => $value['dataId'],
						'typeData'	=> $value['typeData'],
						'dataName' => $value['dataName'], 
						'newDataType' => $value['newDataType'],
						'newDataLength' => $value['newDataLength'],
						'newScaleLength' => $value['newScaleLength'],
						'newUnique' => $value['newUnique'],
						'newNotNull' => $value['newNotNull'],
						'newDefaultValue' => $value['newDefaultValue'],
						'newMinValue' => $value['newMinValue'],
						'newMaxValue' => $value['newMaxValue'],
						'tableName' => $value['tableName'],
						'columnName' => $value['columnName']
					);
	//print_r($paramUpdate);				
						if($paramUpdate->changeType == 'edit'){
							$recordUpdate = $this->mVersion->updateDatabaseSchemaInfoDetail($New_param_DB,$paramUpdate_DB);		
						}else if($paramUpdate->changeType == 'delete'){
							$recordDelete = $this->mVersion->deleteCDatabaseSchemaInfoDetail($New_param_DB,$paramUpdate_DB);		
							$recordDelete1 = $this->mVersion->deleteCDatabaseSchemaVersionDetail($New_param_DB,$paramUpdate_DB);
						}
				}
			}



					//return;
					//print_r($param);
					//if (!isset($param)){

					//มัน error ตรงนี้ ไม่แน่ใจมีค่าอะไรที่ยังไม่มี
					//ปกติแล้วมันจะไม่ catch เพรวะว่า function callChangeRelate มันไม่ throw ex ออกมา 
					//ถ้าต้องการดูว่า error อะไร  หน้า index.php javascript ทีเปน  ajax ใส่ dataType:"text",
					//แล้ว debugger ดู data ตอนมันทำเสร็จ
					//ถ้าไม่ error แล้วให้เปลี่ยน dataType:"json" แล้วไม่ต้อง print_r ออกไป
					//ตอนนี้มันยัง error อยู่
					
						//$resultChange = $this->mVersion>saveChangeList($ListChange);
					//}
		$data = array(
			'success' => true,
			'result'=> $param,
		);
		//echo json_encode($data);

	}
}
	