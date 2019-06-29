<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Functional Requirement ApproveChange
* Create Date: 2017-06-08
*/
class ApproveChange extends CI_Controller{
	
	function __construct(){
		parent::__construct();

		$this->load->model('VersionManagement_model', 'mVerMng');
		$this->load->model('RTM_model', 'mRTM');
		$this->load->model('Project_model', 'mProject');
		$this->load->model('TestCase_model', 'mTestCase');
		$this->load->model('DatabaseSchema_model', 'mDB');
		$this->load->model('Miscellaneous_model', 'mMisc');
		$this->load->model('ChangeManagement_model', 'mChange');
		$this->load->model('FunctionalRequirement_model', 'mFR');
		$this->load->library('form_validation', null, 'FValidate');
	}

	public function index(){
		$data['projectCombo'] = $this->mProject->searchStartProjectCombobox();

		$data['projectId'] = '';
		$data['fnReqId'] = '';
		$data['fnReqVersionId'] = '';

		$data['resultList'] = null;
		$this->openView($data, 'search');
	}

	public function getRelatedFnReq(){
		$output = '';
		$error_message = '';

		if(!empty($_POST)){
			$projectId = $this->input->post('projectId');

			$criteria = (object) array('projectId' => $projectId);
			$fnReqList = $this->mVerMng->searchRelatedFunctionalRequirements($criteria);

			$output .= "<option value=''>".PLEASE_SELECT."</option>";
			foreach($fnReqList as $value){
				$output .= "<option value='".$value['functionId']."'>".$value['functionNo'].": ".$value['functionDescription']."</option>";
			}
		}
		echo $output;
	}

	public function getRelatedFnReqVersion(){
		$output = '';
		if(!empty($_POST)){
			$projectId = $this->input->post('projectId');
			$fnReqId = $this->input->post('functionId');

			$criteria = (object) array('projectId' => $projectId, 'functionId' => $fnReqId);
			$fnReqVersionList = $this->mVerMng->searchRelatedFunctionalRequirementVersion($criteria);
			$output .= "<option value=''>".PLEASE_SELECT."</option>";
			foreach($fnReqVersionList as $value){
				$output .= "<option value='".$value['functionVersionId']."'>"."Version ".$value['functionVersionNumber']."</option>";
			}
		}
		echo $output;
	}

	public function search(){
		$error_message = '';
		$result = null;

		$projectId = $this->input->post('inputProject');
		//print_r($projectId);
		$this->FValidate->set_rules('inputProject', null, 'required');
		if($this->FValidate->run()){
			$param = (object) array('projectId' => $projectId, 'status' => ACTIVE_CODE);
			//$result = $this->mFR->searchFunctionalRequirementHeaderInfo($param);
            $result = $this->mChange->searchTempFRChangeList($param);
	
			if(0 == count($result)){
				$error_message = ER_MSG_006;
			}

			$data['selectedProjectId'] = $projectId;
		}
		$formObj = (object) array('projectId' => $projectId);
		$data['formData'] = $formObj;
		$data['functionList'] = $result;
		$data['error_message'] = $error_message;
		$this->openView($data, 'search');
	}

	public function reset(){
		$this->index();
	}

	private function initialComboBox($projectId, $fnReqId, &$data){
		$data['projectCombo'] = $this->Project->searchStartProjectCombobox();
		if(null != $projectId && !empty($projectId)){
			$criteria = (object) array('projectId' => $projectId);
			$fnReqList = $this->mVerMng->searchRelatedFunctionalRequirements($criteria);
			$data['fnReqCombo'] = $fnReqList;
		}
		if(null != $fnReqId && !empty($fnReqId)){
			$criteria = (object) array('projectId' => $projectId, 'functionId' => $fnReqId);
			$fnReqVersionList = $this->mVerMng->searchRelatedFunctionalRequirementVersion($criteria);
			$data['fnReqVersionCombo'] = $fnReqVersionList;
		}
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

	function delete_detail($id){
		$data = array();
		$data['keyid'] = $id;
	//	echo $id;
		if(null !== $id && !empty($id)){
			//echo $keyId;
			$keyList = explode("%7C", $id);
			//inputid
			$param = (object) array(
				'projectId' => $keyList[0], 
				'functionId' => $keyList[1], 
				'functionVersion' => $keyList[2]
			);
		}	
		$userId = $this->session->userdata('userId');
		$user = $this->session->userdata('username');

		//echo $param->functionId;
		$dataDelete = $this->mChange->deleteTempFRInputChangeList($param);
		
	}			
	
    function view_detail($projectId, $functionId){
        $this->projectId = $projectId;
        $this->functionId = $functionId;

        $this->loadPage('', $projectId, $functionId);
        $this->openView($this->data, 'detail');
	}

    private function openView($data, $view){
		if('search' == $view){
			$data['html'] = 'Approve/ApproveChangeSearch_view';
			$data['projectCombo'] = $this->mProject->searchStartProjectCombobox();
		}else if('result' == $view){
			$data['html'] = 'Approve/ApproveChangeResult_view';
		}
		else{
			$data['html'] = 'Approve/ApproveChangeDetail_view';
		}
		
		$data['active_title'] = 'Approve';
		$data['active_page'] = 'trns001';
        $this->load->view('template/header');
        $this->load->view('template/body_javascript');
		$this->load->view('template/body', $data);
		$this->load->view('template/footer');
    }

}

?>