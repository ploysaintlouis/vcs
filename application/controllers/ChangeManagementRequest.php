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
				'Id' => $resultList[0]['Id'],
				'schemaVersionId' => $resultList[0]['schemaVersionId']);

				$functionVersion = (!empty($functionVersion)? $functionVersion : $resultList[0]['functionVersion']);
//echo $functionVersion;
				//get temp change list
				$criteria = (object) array('userId' => $userId, 'functionId' => $functionId, 'functionVersion' => $functionVersion);
				$inputChangeList = $this->mChange->searchTempFRInputChangeList($criteria);
				$inputChangeConfirm = $this->mChange->searchTempFRInputChangeConfirm($criteria);
//print_r($inputChangeList);
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
				'typeData' => $keyList[4],
				'functionVersion' => $keyList[5], 
				'schemaId' => $keyList[6]	
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
		$data["schemaId"] = $param->schemaId;

		$data['dataTypeCombo'] = $this->mMisc->searchMiscellaneous('','');

		$this->load->view('ChangeManagement/popup/edit',$data);
		}
		
    function delete_detail($id){
			$data = array();
			$data['keyid'] = $id;

			$userId = $this->session->userdata('userId');
			$user = $this->session->userdata('username');

			if(null !== $id && !empty($id)){
				//echo $id;
				$keyList = explode("%7C", $id);
				//inputid
				$param = (object) array(
					'projectId' => $keyList[0], 
					'dataId' => $keyList[1], 
					'schemaVersionId' => $keyList[2], 
					'functionId' => $keyList[3], 
					'typeData' => $keyList[4],
					'functionVersion' => $keyList[5],
					'schemaId' => $keyList[6],
					'userId'	=>$userId,
					'user' => $user
				);
			}	
			$recordDetail = $this->mFR->searchFunctionalRequirementDetail($param);
			foreach($recordDetail as $value){
				$paramdetail = (object) array(
					'tableName' => $value['refTableName'],
					'columnName' => $value['refColumnName'],
				'dataName' => $value['dataName'], 
				'dataType' => $value['dataType']
				);
			}

			$recordDelete = $this->deleteTempFRInputChangeList($param,$paramdetail);
			if(0 < $recordDelete){
			//	refresh Change List
				$output = 'Done';
			}else{
				$output = 'error|'.ER_MSG_015;
			}

    }	

		function deleteTempFRInputChangeList($param,$paramdetail){
			$currentDateTime = date('Y-m-d H:i:s');

			$sqlStr = "INSERT INTO T_TEMP_CHANGE_LIST (userId, functionId, functionVersion,typeData, dataName, schemaVersionId, newDataType, newDataLength, 
			newScaleLength, newUnique, newNotNull, newDefaultValue, newMinValue, newMaxValue, tableName, columnName, changeType, createUser, createDate,dataId,confirmflag,approveflag,
			schemaId) 
				VALUES (
					'$param->userId', 
					'$param->functionId',
					'$param->functionVersion',
					'$param->typeData',
					'$paramdetail->dataName',
					'$param->schemaVersionId',
				  '$paramdetail->dataType',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'$paramdetail->tableName',
					'$paramdetail->columnName',
					'delete',
					'$param->user', 
					'$currentDateTime',
					'$param->dataId',
					NULL,
					NULL,
					'$param->schemaId')";
			//echo $sqlStr;
			$result = $this->db->query($sqlStr);
			return $result;

		}

		
	function deleteTempFRInputList($id){

			$recordDelete = $this->deleteTempChangeList($id);
		if (0 <count($recordDelete)){
			return true;
		}
			
	}

	function deleteTempChangeList($id){
	
		$sqlStr = "DELETE FROM T_TEMP_CHANGE_LIST
			WHERE dataId = '$id' ";
			//echo $sqlStr;
		$result = $this->db->query($sqlStr);
		return $this->db->affected_rows();
	}

	function saveTempFRInput_edit($dataName){
		$output = '';
		$error_message = '';
		//echo 'HEOOL"';
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
	
	function bind_data_change_list_relate($param){
		$data = array();
		$data['change_list'] = array();
		/// *** call model and bind data here.
		$row = array(); //อยากจะส่ง $RelateResultSCHEMA,$RelateResultNotSCHEMA ไป display 
		//echo $param->functionId;
		
		$RelateResultSCHEMA = $this->mChange->searchChangeRequestrelateSCHEMA($param);
		$i=1;
		foreach ($RelateResultSCHEMA as $value) {
			$row["no"] = $i++;
			if ($value["typeData"] == '1'){
				$row["typeData"]= "input";
			}else{
				$row["typeData"]= "output";
			}
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
				$row["frId"]= $value["FROth_Id"];
				$row["fr_no"]= $value["FROth_NO"];
				$row["version"]= $value['FROth_Version'];
				array_push($data['aff_fr_list'],$row);
				$frId = $value["FROth_Id"];
			}
		}
//print_r($data);
		return $data;
	}	

	function bind_data_aff_functionalrequirement_relate($param){
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
				$row["frId"]= $value["FROth_Id"];
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
		$y=1;
		foreach($ListofChangeSchemaOthFr as $value){
				$paramothFR = (object) array(
					'FROth_Id' => $value['FROth_Id'],
					'FROth_Version' => $value['FROth_Version'],
					'FROth_NO'	=> $value['FROth_NO']
				);		//print_r($paramothFR);
				//print_r($ListofChangeSchemaOthFr);
			$ListofTCAffected= $this->mChange->checkTestCaseAffected($param,$paramothFR,$y);
		//	print_r($ListofTCAffected);
			$i = 1;
			$testNo = "";
			$testVersion = "";
			foreach($ListofTCAffected as $value)
			{//echo $value["testCaseNo"];
				$test_title = $testNo.$testVersion;
				if($test_title != $value["testCaseNo"].$value['testcaseVersion'] ){
					//echo $value["testCaseNo"].$value['testcaseVersion'];
					if($value["testCaseNo"] != ""){
						$row["no"] = $i++;
						$testNo = $row["test_id"]= $value["testCaseId"];
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
			$y++;}
		}
//print_r($data);
		return $data;
	}
	
	function bind_data_aff_testcase_relate($param){
		$data = array();
		$data['aff_testcase_list'] = array();
		/// *** call model and bind data here.
		$row=array();
		$ListofChangeSchemaOthFr = $this->mChange->checkOtherFr($param);
		//print_r($ListofChangeSchemaOthFr);
		$y=1;
		foreach($ListofChangeSchemaOthFr as $value){
			$paramothFR = (object) array(
				'FROth_Id' => $value['FROth_Id'],
				'FROth_Version' => $value['FROth_Version'],
				'FROth_NO'	=> $value['FROth_NO']
			);		//print_r($paramothFR);

			$ListofTCAffected= $this->mChange->checkTestCaseAffected($param,$paramothFR,$y);
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
						$testNo = $row["test_id"]= $value["testCaseId"];
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
						}
						$row['change_type'] = $changetype;
						array_push($data['aff_testcase_list'],$row);
					}
				}
			}
	$y++;	}
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
			$row["schemaVersionId"]= $value["schemaVersionId"];
			$row["table_name"]= $value["tableName"];
			$row["column_name"]= $value["columnName"];
			$row["change_type"]= $value["changeType"];
			$row["version"]= $value["Version"];

			array_push($data['aff_schema_list'],$row);
		}
		$ListofNewSchemaAffected= $this->mChange->checkNewSchemaAffted($param);
		$i = 1;
		foreach($ListofNewSchemaAffected as $value)
		{
			//for($i=1;$i<3;$i++){
			$row["no"] = $i++;
			$row["schemaVersionId"]= $value["schemaVersionId"];
			$row["table_name"]= $value["tableName"];
			$row["column_name"]= $value["columnName"];
			$row["change_type"]= $value["changeType"];
			$row["version"]= $value["schemaVersionNumber"];

			array_push($data['aff_schema_list'],$row);
		}

		return $data;
	}
	
	function bind_data_aff_rtm($param){
		$data = array();
		$data['aff_rtm_list'] = array();
		/// *** call model and bind data here.
		$row=array();
		$ListofChangeSchemaOthFr = $this->mChange->checkOtherFr($param);
		//print_r($ListofChangeSchemaOthFr);
		$y=1;
		foreach($ListofChangeSchemaOthFr as $value){
			$paramothFR = (object) array(
				'FROth_Id' => $value['FROth_Id'],
				'FROth_Version' => $value['FROth_Version'],
				'FROth_NO'	=> $value['FROth_NO']
			);//print_r($paramothFR);
			$ListofRTMAffected= $this->mVersion->checkRTMAffected($param,$paramothFR,$y);
			//print_r($ListofTCAffected);
			$i = 1;
			$testNo = "";
			$testVersion = "";
			foreach($ListofRTMAffected as $value)
			{
				$test_title = $testNo.$testVersion;
				if($test_title != $value["testCaseNo"].$value['testcaseVersion'] ){
					if($value["testCaseNo"] != ""){
						$row["no"] = $i++;
						$testId = $row["test_id"]= $value["testCaseId"];
						$testNo = $row["test_no"]= $value["testCaseNo"];
						$testVersion = $row["version"]= $value['testcaseVersion'];
						$testId = $row["fr_id"]= $value["functionId"];
						$testNo = $row["fr_no"]= $value["functionNo"];
						$testVersion = $row["fr_version"]= $value['functionVersion'];
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
						array_push($data['aff_rtm_list'],$row);
					}
				}
			}
			$y++;}
		return $data;
	}
	
	function bind_data_aff_rtm_relate($param){
		$data = array();
		$data['aff_rtm_list'] = array();
		/// *** call model and bind data here.
		$row=array();
		$ListofChangeSchemaOthFr = $this->mChange->checkOtherFr($param);
		//print_r($ListofChangeSchemaOthFr);
		$y=1;
		foreach($ListofChangeSchemaOthFr as $value){
			$paramothFR = (object) array(
				'FROth_Id' => $value['FROth_Id'],
				'FROth_Version' => $value['FROth_Version'],
				'FROth_NO'	=> $value['FROth_NO']
			);
			$ListofRTMAffected= $this->mVersion->checkRTMAffected($param,$paramothFR,$y);
			//print_r($ListofTCAffected);
			$i = 1;
			$testNo = "";
			$testVersion = "";
			foreach($ListofRTMAffected as $value)
			{
				$test_title = $testNo.$testVersion;
				if($test_title != $value["testCaseNo"].$value['testcaseVersion'] ){
					if($value["testCaseNo"] != ""){
						$row["no"] = $i++;
						$testId = $row["test_id"]= $value["testCaseId"];
						$testNo = $row["test_no"]= $value["testCaseNo"];
						$testVersion = $row["version"]= $value['testcaseVersion'];
						$testId = $row["fr_id"]= $value["functionId"];
						$testNo = $row["fr_no"]= $value["functionNo"];
						$testVersion = $row["fr_version"]= $value['functionVersion'];
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
						}
						$row['change_type'] = $changetype;
						array_push($data['aff_rtm_list'],$row);
					}
				}
			}
		$y++;}
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
//echo $functionId;
//echo $projectId;
//echo $functionVersion;
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
			$affRTMList = $this->bind_data_aff_rtm($param);

			$chglist_relete = $this->bind_data_change_list_relate($param);
			$data["title_panel"]= $title;
			$data["change_panel"]=$chglist_relete;
			$this->writeJsonFile_Input($data, $param->functionId);

			$dataForPage["functionId"] = $param->functionId;
			$dataForPage["projectId"] = $param->projectId;

			//send to page result/index 
			$dataForPage["title_panel"]= $title;
			$dataForPage["change_panel"]=$chglist;
			$dataForPage["aff_fr_panel"]=$affFrList;
			$dataForPage["aff_testcase_panel"]=$affTestCaseList;
			$dataForPage["aff_schema_panel"] = $affSchemalist;
			$dataForPage["aff_rtm_panel"] = $affRTMList;

			//echo json_encode($dataForPage);
			$affFrList_relate = $this->bind_data_aff_functionalrequirement_relate($param);
			$affTestCaseList_relate = $this->bind_data_aff_testcase_relate($param);
			$affSchemalist_relate = $this->bind_data_aff_schema($param);
			$affRTMList_relate = $this->bind_data_aff_rtm_relate($param);

			$data_response["title_panel"]= $title;
			$data_response["aff_fr_panel"]= $affFrList_relate;
			$data_response["aff_testcase_panel"]= $affTestCaseList_relate;
			$data_response["aff_schema_panel"] = $affSchemalist_relate;
			$data_response["aff_rtm_panel"] = $affRTMList_relate;
			$this->writeJsonFile_Output($data_response, $param->functionId);

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
			$error_message ='';
		}

		$data['success_message'] = $success_message;
		$data['error_message'] = $error_message;
	}

	private function writeJsonFile_Input($inputData, $changedFunctionId){
		try{
			$datetime = date('YmdHis');
			$outputFileName = "log/change/requestDataJson".$changedFunctionId."_".$datetime.".txt";

			//print_r($inputData);
			$encodedString = json_encode($inputData);
			file_put_contents($outputFileName, $encodedString);

		}catch(Exception $e){
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}

	private function writeJsonFile_Output($outputData, $changedFunctionId){
		try{
			$datetime = date('YmdHis');



			$encodedString = json_encode($outputData);
			$inputFileName = "log/change/responseDataJson_".$changedFunctionId."_".$datetime.".txt";
			file_put_contents($inputFileName, $encodedString);
		}catch(Exception $e){
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}

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

	function confirm_change_request(){
		$prjId = $this->input->post('projectId');
		$funId = $this->input->post('functionId');
		$funNo = $this->input->post('functionNo');
		$CH_NO = $this->input->post('CH_NO');
		$FR_Version = $this->input->post('FR_Version');
		$FR_Description = $this->input->post('FR_Description');
		$userId = $this->session->userdata('userId');
		$user = $this->session->userdata('username');
		$rowResult = $this->mRunning->Update_Running_ch();

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

		$newCurrentDate = date('Y-m-d H:i:s');
		//** save change request header.
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
		print_r($RelateResultSCHEMA);
		
		foreach ($RelateResultSCHEMA as $value) {
			$paramInsert = (object) array(
				'changeRequestNo' => $param->changeRequestNo,
				'sequenceNo' => $i++,
				'typeData'	=> $value['typeData'],
				'changeType' => $value['changeType'],
				'dataId' => $value['dataId'],
				'dataName' => $value['dataName'], 
				'schemaId' => $value['schemaId'],
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
		//print_r($RelateResultNotSCHEMA);
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

		//** MAP RTM */
		$affRTMList = $this->bind_data_aff_rtm($param);
		foreach($affRTMList as $land => $data){
			foreach($data as $detail => $value)
			{
				$rtm_list_aff = (object) array(
					'projectId' 	  			=> $prjId,
					'changeRequestNo' 		=> $CH_NO,
					'functionId'					=> $value['fr_id'],
					'functionNo'					=> $value['fr_no'],
					'functionVersion'			=> $value['fr_version'],	
					'testcaseId'					=> $value['test_id'],	
					'testcaseNo'					=> $value['test_no'],
					'testcaseVersion'			=> $value['version'],			
					'user'								=> $user
				);	
				//print_r($rtm_list_aff);
				$this->mVersion->insertlogAffRTM($rtm_list_aff);
			}
		}

		//** Control Version TESTCASE
		$affTestCaseList = $this->bind_data_aff_testcase($param);
		foreach($affTestCaseList as $land => $data){
			foreach($data as $detail => $value)
			{
				$test_list_aff = (object) array(
					'projectId' 	  			=> $prjId ,
					'changeRequestNo' 		=> $CH_NO,
					'testCaseId'					=> $value['test_id'],
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

				$record_TC  = $this->mVersion->SearchTestcaseHeader($param,$test_list_aff);	
				if(0 < count($record_TC)){
					foreach($record_TC as $value){
						$data_list = (object) array(
							'testCaseId'						=> $value['testCaseId'],
							'testCaseNo'						=> $value['testCaseNo'],
							'testcaseVersion'				=> $value['testcaseVersion'],
							'testCaseDescription'		=> $value['testCaseDescription'],
							'expectedResult'				=> $value['expectedResult']
						);
					}					
				}
//rint_r($data_list->testcaseVersion);
				if($test_list_aff->changeType != 'edit'){				
					$New_TCId =	$this->mVersion->InsertNewTestCaseHeader($param,$data_list);
				}else{
					$New_TCId =	$this->mVersion->InsertTestCaseHeader($param,$data_list);
				}
				//echo $New_TCId;
			
				$TC_Header =	$this->mVersion->SearchNewTestCaseHeader($param,$New_TCId);
				if(0 < count($TC_Header)){
					foreach($TC_Header as $value){
						$New_TC_HEADER = (object) array(
							'testCaseId'						=> $value['testCaseId'],
							'testCaseNo'						=> $value['testCaseNo'],
							'testcaseVersion'				=> $value['testcaseVersion'],				
						);
					}
				}
				$MAP_TC = $this->mVersion->MapTCVersion($test_list_aff,$New_TC_HEADER);

				//print_r($New_TC_HEADER);
				$detail_TC  = $this->mVersion->InsertTestcaseDetail($param,$New_TC_HEADER,$data_list);	
				//print_r($detail_TC);
				if(0 < count($detail_TC)){
					$ListChange = $this->mVersion->searchChangeRequestList($param);
					//print_r($ListChange);
								foreach ($ListChange as $value){
								$param_update_tc = (object) array(
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
			//print_r($param_update_tc);
						//print_r($param_update_tc->changeType);		
						if ($param_update_tc->changeType != 'delete'){
								$new_testdata = '';
								if (isset($param_update_tc->newMaxValue) or ($param_update_tc->newMaxValue == null )){
									$param_update_tc->newMaxValue = '100';
								}
								if (isset($param_update_tc->newMinValue) or ($param_update_tc->newMinValue == null )){
									$param_update_tc->newMinValue = '0';
								}
								$new_testdata = rand($param_update_tc->newMinValue,$param_update_tc->newMaxValue);
	
									//print_r($param_update_tc->newDataLength);
								if (($param_update_tc->newDataType == 'decimal') || ($param_update_tc->newDataType == 'DECIMAL')
								|| ($param_update_tc->newDataType == 'float') || ($param_update_tc->newDataType == 'FLOAT')
								|| ($param_update_tc->newDataType == 'double') || ($param_update_tc->newDataType == 'DOUBLE'))
								{
									if(($new_testdata == null) || ($new_testdata < $param_update_tc->newMaxValue) || ($new_testdata > $param_update_tc->newMinValue)){
											$chars = "0123456789";
											$ret_char = "";
											$num = strlen($chars);
											for($i = 0; $i < $param_update_tc->newDataLength ; $i++) {
												$ret_char.= $chars[rand()%$num];
												$ret_char.= ""; 
											}
											$first_num = $ret_char;

											$ret_char = "";
											$chars = "0123456789";
											$ret_char = "";
											$num = strlen($chars);
											for($i = 0; $i < $param_update_tc->newScaleLength ; $i++) {
												$ret_char.= $chars[rand()%$num];
												$ret_char.= ""; 
											}
											$round = $ret_char;
										$new_testdata = $first_num.".".$round;
										//echo $new_testdata;
									}
								}	
							if(($param_update_tc->newDataType == 'date') || ($param_update_tc->newDataType == 'DATE') ){
									$new_testdata = '';
								}
				
								if (($param_update_tc->newDataType == 'char') || ($param_update_tc->newDataType == 'CHAR')
								|| ($param_update_tc->newDataType == 'varchar') || ($param_update_tc->newDataType == 'VARCHAR')){
									$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
									$value = '';
									for ( $i = 0; $i < $param_update_tc->newDataLength; $i++ )
										 $value .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
									$new_testdata = $value;
								}			
//echo $new_testdata;
						}
								if($param_update_tc->changeType == 'edit'){
										$recordUpdate = $this->mVersion->updateChangeTestCaseDetail($param,$param_update_tc,$New_TC_HEADER,$new_testdata);		
								}else if(($param_update_tc->changeType == 'delete') && ($test_list_aff->changeType == 'delete')) {
										$recordDelete = $this->mVersion->deleteChangeTestCaseDetail($param,$param_update_tc,$New_TC_HEADER);		
								}else if(($param_update_tc->changeType == 'add') && ($test_list_aff->changeType == 'delete')){
										$recordAdd = $this->mVersion->addChangeTestCaseDetail($param,$param_update_tc,$New_TC_HEADER,$new_testdata);		
								}
							
						}	
				}
			}		
		}

		//** Control Version requirement */
		$affFrList = $this->bind_data_aff_functionalrequirement($param);
		foreach($affFrList as $land => $data){
			foreach($data as $detail => $value)
			{
				$fr_list_aff = (object) array(
					'projectId' 	  			=> $prjId,
					'changeRequestNo' 		=> $CH_NO,
					'functionId' 				  => $value['frId'],
					'functionNo'					=> $value['fr_no'],
					'functionVersion'			=> $value['version'],				
					'changeType'					=> $value['change_type'],
					'fnDesc'		  				=> '',
					'user'								=> $user
				);	
				//print_r($fr_list_aff);
				$this->mVersion->insertlogAffFr($fr_list_aff);
				//** 3. save change history requirement header
				$rowUpdate = $this->mVersion->updateRequirementsHeader($fr_list_aff);

				//** 3.1 save change history requirement detail
				$rowUpdate = $this->mVersion->updateChange_RequirementsDetail($fr_list_aff);

				//** 3.2 save change New requirement header
				if($fr_list_aff->changeType != 'edit'){
					$New_FunctionId = $this->mVersion->InsertNewRequirementsHeader($fr_list_aff);
				}else{
					$New_FunctionId = $this->mVersion->InsertRequirementsHeader($fr_list_aff);
				}
				
				$NewFR = $this->mVersion->SearchRequirementsDetail($fr_list_aff,$New_FunctionId);
				foreach($NewFR as $value){
						$New_param = (object) array(
							'projectId'		=> $value['projectId'],
								'functionNo' => $value['functionNo'],
								'functionversion'   => $value['functionVersion'],
								'functionId'	 => $value['functionId']
						);	
				}
				$MAP_FR = $this->mVersion->MapFRVersion($fr_list_aff,$New_param);

				//** save change New requirement detail
				$InsertNew = $this->mVersion->InsertChange_RequirementsDetail($fr_list_aff,$New_param);
				//print_r($InsertNew);
				if(0 < count($InsertNew)){
					$Result = $this->mVersion->searchChangeRequestList($param);
					//print_r($Result);
						foreach ($Result as $value){
							$paramUpdate = (object) array(
								'changeType' => $value['changeType'],
								'dataId' => $value['dataId'],
								'typeData'	=> $value['typeData'],
								'dataName' => trim($value['dataName']), 
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
			//print_r($paramUpdate->dataName);
						//print_r($paramUpdate->changeType);		

								if($paramUpdate->changeType == 'edit'){
									$recordUpdate = $this->mVersion->updateChangeRequestDetail($param,$paramUpdate,$New_param);		
								}
								if(($paramUpdate->changeType == 'delete') && ($fr_list_aff->changeType == 'delete')){
									$recordDelete = $this->mVersion->deleteChangeRequestDetail($param,$paramUpdate,$New_param);		
								}
								if(($paramUpdate->changeType == 'add') && ($fr_list_aff->changeType == 'delete')){
									$recordAdd = $this->mVersion->addChangeRequestDetail($param,$paramUpdate,$New_param);		
								}					
							}
						}
			}
		}	

		//** Control Version SCHEMA
		$affSchemalist = $this->bind_data_aff_schema($param);
	foreach($affSchemalist as $land => $data){
			foreach($data as $detail => $value)
			{
				$schema_list_aff = (object) array(
					'projectId' 	  			=> $prjId,
					'changeRequestNo' 		=> $CH_NO,
					'schemaVersionId'			=> $value['schemaVersionId'],
					'tableName'						=> $value['table_name'],
					'columnName'					=> $value['column_name'],
					'changeType'					=> $value['change_type'],
					'version'							=> $value['version'],
					'user'								=> $user
				);	
				$this->mVersion->insertlogAffSchema($schema_list_aff);

				//** 3. save change history SCHEMA
				$recordUpdate  = $this->mVersion->updateDatabaseSchemaVersion($schema_list_aff);
				$recordUpdate1 = $this->mVersion->updateDatabaseSchemaInfo($schema_list_aff);		

				if (($SAME_Table <> $paramInsert->tableName)){
					$RelateResultSCHEMA = $this->mVersion->searchTablerelateSCHEMA($param);
					if (0< count($RelateResultSCHEMA)){
						foreach ($RelateResultSCHEMA as $value) {
							$paramInsert = (object) array(
								'tableName'				  => $value['tableName'],
								'schemaVersionId'		=> $value['schemaVersionId']
							);
						$recordUpdate2 =	$this->mVersion->insertDatabaseSchemaVersion($param,$paramInsert);
						$recordUpdate3 =	$this->mVersion->insertDatabaseSchemaInfo($param,$paramInsert);
						}
					}
					//** save MAP DB
					$NewDB = $this->mVersion->SearchDatabaseSchemaDetail($param,$paramInsert);
					foreach($NewDB as $value){
						$New_param_DB = (object) array(
							'projectId' 	  			=> $prjId,
							'tableName'			=> $value['tableName'],
							'schemaVersionNumber' => $value['schemaVersionNumber'],
							'schemaVersionId'			=> $value['schemaVersionId'],
							'user'								=> $user
						);
					}
					$OldDB = $this->mVersion->SearchDatabaseSchemaOldDetail($schema_list_aff,$paramInsert);
					foreach($OldDB as $value){
						$Old_param_DB = (object) array(
							'projectId' 	  			=> $prjId,
							'tableName'			=> $value['tableName'],
							'schemaVersionNumber' => $value['Version'],
							'schemaVersionId'			=> $value['schemaVersionId']
						);
					}
					//print_r($Old_param_DB);
					if((0 < count($New_param_DB)) && ($SAME_Table <> $paramInsert->tableName)) {
						$MAP_FR = $this->mVersion->MapDBVersion($Old_param_DB,$New_param_DB);
						$SAME_Table = $paramInsert->tableName;
					}
				}

				//** save change history DB detail		
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

						if($paramUpdate_DB->changeType == 'edit'){
							$recordUpdate = $this->mVersion->updateDatabaseSchemaInfoDetail($New_param_DB,$paramUpdate_DB);		
						}
						if(($paramUpdate_DB->changeType == 'delete') && ($schema_list_aff->changeType == 'delete')){
							$recordDelete = $this->mVersion->deleteDatabaseSchemaInfoDetail($New_param_DB,$paramUpdate_DB);		
							$recordDelete1 = $this->mVersion->deleteCDatabaseSchemaVersionDetail($New_param_DB,$paramUpdate_DB);
						}
						if(($paramUpdate_DB->changeType == 'add') && ($schema_list_aff->changeType == 'delete')) {
							$recordAdd = $this->mVersion->addDatabaseSchemaInfoDetail($New_param_DB,$paramUpdate_DB);		
							$recordAdd1 = $this->mVersion->addDatabaseSchemaVersionDetail($New_param_DB,$paramUpdate_DB);		
						}					
						$recordUpdateFR = $this->mVersion->updateSchemaDetail($New_param_DB,$New_param);		
					}
				}
			}	
		}		

		//** Control Version RTM */
		$Map_RTM = $this->mVersion->searchAffRTM($param);
		if (0 < count($Map_RTM)){
			echo "0";
			foreach($Map_RTM as $value){
				$rtm_relate = (object) array(
					'projectId' 	  	=> $prjId,
					'functionId'			=> $value['functionId'],
					'functionNo'			=> $value['functionNo'],
					'functionVersion'	=> $value['functionVersion'],
					'testcaseId'			=> $value['testcaseId'],
					'testcaseNo'			=> $value['testcaseNo'],
					'testcaseVersion'	=> $value['testcaseVersion'],
					'user'						=> $user			
				);			
			//	echo "1";
			//	print_r($rtm_relate);
				$FrList = $this->mVersion->searchNewFR($rtm_relate);
				if(0 < count($FrList)){
					foreach($FrList as $value){
						$relate_new_fr = (object) array(
							'projectId' 	  	=> $prjId,
							'functionId'			=> $value['New_FR_Id'],
							'functionNo'			=> $value['New_FR_No'],
							'functionVersion'	=> $value['New_FR_Version'],
							'user'						=> $user
						);
					}
				}
				//print_r($relate_new_fr);

				$TCList = $this->mVersion->searchNewTC($rtm_relate);
				if(0 < count($TCList)){
					foreach($TCList as $value){
						$relate_new_tc = (object) array(
							'projectId' 	  	=> $prjId,
							'testcaseId'			=> $value['New_TC_Id'],
							'testcaseNo'			=> $value['New_TC_No'],
							'testcaseVersion'	=> $value['New_TC_Version']
						);
					}
				}
				//print_r($relate_new_fr);
				//print_r($relate_new_tc);
				//echo "2";
				$updateRTM = $this->mVersion->updateRTMVersion($rtm_relate);
				$Complete = $this->mVersion->insertRTMVersion($relate_new_fr,$relate_new_tc);
				if (0 <	count($Complete)){
					$DeleteTemp_change = $this->mVersion->deleteTempChange($param);
				}
			}
		}		

		$data = array(
			'success' => true,
			'result'=> $param
		);
		//echo json_encode($data);
	}
}
	