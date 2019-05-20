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
	
				$data['selectedProjectId'] = $projectId;
			}
			$formObj = (object) array('projectId' => $projectId);
			$data['criteria'] = $formObj;
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

	public function doCancelProcess(){
		$error_message = '';
		$success_message = '';

		$changeRequestNo = $this->input->post('changeRequestNo');
		$projectId = $this->input->post('projectId');
		$reason = $this->input->post('inputReason');

		try{
			$this->FValidate->set_rules('inputReason', null, 'trim|required');
			
			if($this->FValidate->run()){
				/** 1. Get Change Details */
				$changeInfo = $this->mChange->getChangeRequestInformation($changeRequestNo);
				$param = (object) array(
					'projectId'  => $projectId,
					'status' 	 => 1,
					'functionId' => $changeInfo->changeFunctionId
					);
				$lastFRInfo = $this->mFR->searchFunctionalRequirementHeaderInfo($param);

				/** 2. Call Change API */
				$param = (object) array(
					'projectId' 	  => $projectId,
					'functionId' 	  => $changeInfo->changeFunctionId,
					'functionNo' 	  => $changeInfo->changeFunctionNo,
					'functionVersion' => $lastFRInfo[0]['functionVersion'],
					'changeRequestNo' => $changeRequestNo,
					'type' 			  => 2 //1 = Change, 2 = Cancel
					);
				$changeResult = $this->callChangeAPI($param);

				if('Y' == $changeResult->result->isSuccess){
					/** 3. Control Version */
					/** 4. Update Change Request's Status */
					$user = $this->session->userdata('username');

					$processData = array(
						'user' 				  => $user, 
						'changeRequestNo' 	  => $changeRequestNo, 
						'reason' 			  => $reason,
						'updateDateCondition' => $changeInfo->updateDate);

					$controlVersionResult = $this->mCancellation->cancelProcess($changeResult, $error_message, $processData);

					/** 5. Display Result */
					if($controlVersionResult == true){
						$this->displayResult($changeRequestNo, $projectId);
						return false;
					}
				}else{
					$error_message = $changeResult->result->error_message;
				}
			}else{
				$error_message = str_replace("{0}", "Input Reason", ER_MSG_019);
			}
		}catch(Exception $e) {
			$error_message = $e->getMessage();
		}

		$data['keyParam'] = array(
			'changeRequestNo' => $changeRequestNo, 
			'projectId' 	  => $projectId);

		//Get All Change Request Data
		$this->getAllChangeRequestData($changeRequestNo, $projectId, $error_message, $data);

		$data['reason'] = $reason;
		$data['error_message'] = $error_message;
		$data['success_message'] = $success_message;
		$this->openView($data, 'view');
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