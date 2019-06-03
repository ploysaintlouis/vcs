<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Rollback Change Controller
*/
class Rollback extends CI_Controller{
	
	function __construct(){
		parent::__construct();

		$this->load->model('Project_model', 'mProject');
		$this->load->model('ChangeManagement_model', 'mChange');
		$this->load->model('Rollback_model', 'mRollback');

		$this->load->library('form_validation', null, 'FValidate');
		$this->load->library('session');
	}

	public function index(){
		$data['error_message'] = '';
		$this->openView($data, 'search');
	}

		/* Method for searching All Changes Information*/
		public function search(){
			$error_message = '';
			$changeList = null;
			$waitList = null;

			$projectId = $this->input->post('inputProject');
			$this->FValidate->set_rules('inputProject', null, 'required');
			if($this->FValidate->run()){
				$criteria = (object) array(
					'projectId' 	=> $projectId,
					'changeStatus' 	=> '1');
				$changeList = $this->mRollback->searchChangesInformationForRollback($criteria);
				if(0 == count($changeList)){
					$error_message = ER_MSG_006;
				}
				$waitList = $this->mRollback->searchSaveProcessRollback($criteria);

				$data['selectedProjectId'] = $projectId;
			}
			$formObj = (object) array('projectId' => $projectId);
			$data['criteria'] = $formObj;
			$data['waitList'] = $waitList;
			$data['changeList'] = $changeList;
			$data['error_message'] = $error_message;
			$this->openView($data, 'search');
		}

		public function viewDetail($projectId = '', $changeRequestNo = ''){
			$error_message = '';
			
			$headerInfo = array();
			$detailInfo = array();
			
			$affectedFnReqList = array();
			$affectedTCList = array();
			$affectedSchemaList = array();
			$affectedRTMList = array();
	
			if(!empty($changeRequestNo) && !empty($projectId)){
				
				$data['keyParam'] = array(
					'changeRequestNo' => $changeRequestNo, 'projectId' => $projectId);
	
				//Get All Change Request Data
				$this->getAllChangeRequestData($changeRequestNo, $projectId, $error_message, $data);
	
			}else{
				$error_message = ER_MSG_011;
			}
	
			$data['reason'] = '';
			$data['error_message'] = $error_message;
			$this->openView($data, 'view');
		}
	
	private function getAllChangeRequestData($changeRequestNo, $projectId, &$error_message, &$data){

		$criteria = (object) array(
				'projectId' 	  => $projectId,
				'changeStatus' 	  => '1',
				'changeRequestNo' => $changeRequestNo);
		$changeHeaderResult = $this->mRollback->searchChangesInformationForRollback($criteria);
		if(0 < count($changeHeaderResult)){
			$headerInfo = array(
				'changeRequestNo' 	=> $changeHeaderResult[0]['changeRequestNo'],
				'changeUser' 		=> $changeHeaderResult[0]['changeUser'],
				'changeDate' 		=> $changeHeaderResult[0]['changeDate'],
				'changeStatus'		=> '1',
				'fnReqId' 			=> $changeHeaderResult[0]['changeFunctionId'],
				'fnReqNo' 			=> $changeHeaderResult[0]['changeFunctionNo'],
				'fnReqVer' 			=> $changeHeaderResult[0]['changeFunctionVersion'],
				'fnReqDesc' 		=> $changeHeaderResult[0]['functionDescription'],
			);

			//search change detail
			$detailInfo = $this->mRollback->getChangeRequestInputList($changeRequestNo);

			$affectedFnReqList = $this->mRollback->getChangeHistoryFnReqHeaderList($changeRequestNo);

			$affectedTCList = $this->mRollback->getChangeHistoryTestCaseList($changeRequestNo);

			$affectedSchemaList = $this->mRollback->getChangeHistoryDatabaseSchemaList($changeRequestNo);

			$affectedRTMList = $this->mRollback->getChangeHistoryRTM($changeRequestNo);

		}else{
			$error_message = ER_MSG_017;
			return false;
		}

		$data['headerInfo'] = $headerInfo;
		$data['detailInfo'] = $detailInfo;

		$data['affectedFnReqList'] = $affectedFnReqList;
		$data['affectedTCList'] = $affectedTCList;
		$data['affectedSchemaList'] = $affectedSchemaList;
		$data['affectedRTMList'] = $affectedRTMList;
		return true;
	}

	public function saveProcess(){
		$error_message = '';
		$success_message = '';

		$changeRequestNo = $this->input->post('changeRequestNo');
		$projectId = $this->input->post('projectId');
		$reason = $this->input->post('inputReason');
		$userId = $this->input->post('userId');
//echo $changeRequestNo;
		try{
			$this->FValidate->set_rules('inputReason', null, 'trim|required');
			
			if($this->FValidate->run()){
				$saveRollback = $this->mRollback->saveProcess($changeRequestNo, $projectId, $reason,$userId);
			}else{
				$error_message = str_replace("{0}", "Input Reason", ER_MSG_019);
			}
		}catch(Exception $e) {
			$error_message = $e->getMessage();
		}

		$data['reason'] = $reason;
		$data['error_message'] = $error_message;
		$data['success_message'] = $success_message;
		$this->openView($data, 'search');
	}

	public function doCancelProcess(){
		$error_message = '';
		$success_message = '';

		$changeRequestNo = $this->input->post('changeRequestNo');
		$projectId = $this->input->post('projectId');
		$user = $_SESSION['username'];

		try{

				/** 1. Get FR Change Details */
				$changeFRInfo = $this->mRollback->getChangeRequestFunctionalRequirement($changeRequestNo);
				//print_r($changeFRInfo);
				foreach ($changeFRInfo as $value) {
					$param_FR = (object) array(
						'projectId'  => $projectId,
						'status' 	 => 1,
						'user'		=>$user,
						'changeRequestNo' => $changeRequestNo,
						'functionId' => $value['FR_Id'],
						'functionNo' 	  => $value['FR_No'],
						'functionVersion' => $value['FR_Version'],
						'New_FR_Id'	=>$value['New_FR_Id'],
						'New_FR_Version' =>$value['New_FR_Version']
						);
						//print_r($param_FR);
						if (0 < count($param_FR)){
							$UpdateStatusFR_New = $this->mRollback->updateRollback_FRHeader($param_FR);
							$UpdateStatusFR_Old = $this->mRollback->updateRequirementsHeader($param_FR);
							$UpdateStatusFRDetail_New = $this->mRollback->updateRollback_FRDetail($param_FR);
							$UpdateStatusFRDetail_Old = $this->mRollback->updateRequirementsDetail($param_FR);
						}
				}
				//print_r($param_FR->user);

				/** 2. Get TC Change Details */
				$changeTCInfo = $this->mRollback->getChangeRequestTestCase($changeRequestNo);
				foreach ($changeTCInfo as $value) {
					$param_TC = (object) array(
						'projectId'  => $projectId,
						'status' 	 => 1,
						'user'		=>$user,
						'changeRequestNo' => $changeRequestNo,
						'testCaseId' => $value['testcaseId'],
						'testcaseNo' 	  => $value['testcaseNo'],
						'testcaseVersion' => $value['testcaseVersion'],
						'New_testCaseId' => $value['New_TC_Id'],
						'New_testcaseVersion' => $value['New_TC_Version']		
						);		
						if (0 < count($param_TC)){
							$UpdateStatusTC_New = $this->mRollback->updateRollback_TCHeader($param_TC);
							$UpdateStatusTC_Old = $this->mRollback->updateTestcaseHeader($param_TC);
							$UpdateStatusTCDetail_New = $this->mRollback->updateRollback_TCDetail($param_TC);
							$UpdateStatusTCDetail_Old = $this->mRollback->updateTestcaseDetail($param_TC);
						}	
				}		
			
				/** 3. Get SCHEMA Change Details */
				$changeDBInfo = $this->mRollback->getChangeRequestSchema($changeRequestNo);
				foreach ($changeDBInfo as $value) {
					$param_DB = (object) array(
						'projectId'  => $projectId,
						'status' 	 => 1,
						'user'		=>$user,
						'changeRequestNo' => $changeRequestNo,
						'SchemaVersionId' => $value['SchemaVersionId'],
						'tableName' 	  => $value['tableName'],
						'Version' => $value['Version'],
						'New_SchemaVersionId' => $value['New_SchemaVersionId'],
						'New_Version' => $value['New_Schema_Version']
						);
						if (0 < count($param_DB)){
							$UpdateStatusDB_New = $this->mRollback->updateRollback_DBHeader($param_DB);
							$UpdateStatusDB_Old = $this->mRollback->updateSchemaHeader($param_DB);
							$UpdateStatusDBDetail_New = $this->mRollback->updateRollback_DBDetail($param_DB);
							$UpdateStatusDBDetail_Old = $this->mRollback->updateSchemaDetail($param_DB);
						}
					}	

				/** 4. Get RTM Change Details */
				$changeRTMInfo = $this->mRollback->getChangeRequestSRTM($changeRequestNo);
				foreach ($changeRTMInfo as $value) {	
					$param_RTM = (object) array(
						'projectId'  => $projectId,
						'status' 	 => 1,
						'user'		=>$user,
						'changeRequestNo' => $changeRequestNo,
						'functionId' => $value['functionId'],
						'functionVersion' 	  => $value['functionVersion'],
						'testCaseId' => $value['testcaseId'],
						'testcaseVersion' => $value['testcaseVersion']
						);	
						if (0 < count($param_RTM)){
							$UpdateStatusRTM_New = $this->mRollback->updateRollback_RTMHeader($param_RTM);
							$UpdateStatusRTM_Old = $this->mRollback->updateRTMDetail($param_TC,$param_FR);
						}
				}

					/** 5. Display Result */
					$this->displayResult($changeRequestNo,$projectId);

		}catch(Exception $e) {
			$error_message = $e->getMessage();
		}
/*
		$data['keyParam'] = array(
			'changeRequestNo' => $changeRequestNo, 
			'projectId' 	  => $projectId);

		//Get All Change Request Data
		$this->getAllChangeRequestData($changeRequestNo, $projectId, $error_message, $data);

		$data['error_message'] = $error_message;
		$this->openView($data, 'view');*/
	}
	
	private function displayResult($changeRequestNo, $projectId){
		$success_message = '';
		$error_message = '';
		$reason = '';

		$Rollback_reason = $this->mRollback->RollbackReason($changeRequestNo,$projectId);

		$criteria = (object) array(
				'projectId' 	  => $projectId,
				'changeStatus' 	  => '1',
				'changeRequestNo' => $changeRequestNo);
		$Update_Rollback = $this->mRollback->updatestatusRolback($criteria);
		$changeHeaderResult = $this->mRollback->searchChangesInformationForCancelling($criteria);
		if(0 < count($changeHeaderResult)){
			$headerInfo = array(
				'changeRequestNo' 	=> $changeHeaderResult[0]['changeRequestNo'],
				'changeUser' 		=> $changeHeaderResult[0]['changeUser'],
				'changeDate' 		=> $changeHeaderResult[0]['changeDate'],
				'changeStatus'		=> $changeHeaderResult[0]['changeStatus'],
				'fnReqNo' 			=> $changeHeaderResult[0]['changeFunctionNo'],
				'fnReqVer' 			=> $changeHeaderResult[0]['changeFunctionVersion'],
				'fnReqDesc' 		=> $changeHeaderResult[0]['functionDescription'],
				);
			
			$reason = $Rollback_reason[0]['reason'];
			
			//search change detail
			$detailInfo = $this->mRollback->getChangeRequestInputList($changeRequestNo);

			$success_message = IF_MSG_001;
		}else{
			$error_message = ER_MSG_017;
		}

		$data['headerInfo'] = $headerInfo;
		$data['detailInfo'] = $detailInfo;

		$data['reason'] = $reason;
		$data['error_message'] = $error_message;
		$data['success_message'] = $success_message;
		$this->openView($data, 'result');
	}

    private function openView($data, $view){
		if('search' == $view){
			$data['html'] = 'RollbackManagement/RollbackSearch_view';
			$data['projectCombo'] = $this->mProject->searchStartProjectCombobox();
		}else if('view' == $view){
			$data['html'] = 'RollbackManagement/RollbackDetail_view';
		}else{
			$data['html'] = 'RollbackManagement/RollbackResult_view';
		}
		
		$data['active_title'] = 'changeManagement';
		$data['active_page'] = 'trns002';
		$this->load->view('template/header');
		$this->load->view('template/body', $data);
		$this->load->view('template/footer');
    }
    
}

?>