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

		$this->load->library('form_validation', null, 'FValidate');
		$this->load->library('session');
    }
    private function loadPage(){
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

				//get temp change list
				$criteria = (object) array('userId' => $userId, 'functionId' => $functionId, 'functionVersion' => $functionVersion);
				$inputChangeList = $this->mChange->searchTempFRInputChangeList($criteria);
			}else{
				$error_message = ER_MSG_012;
			}
		}else{
			$error_message = ER_MSG_011;
		}

		$hfield = array('projectId' => $projectId, 'functionId' => $functionId, 'functionVersion' => $functionVersion);
		$data['hfield'] = $hfield;
		$data['error_message'] = '';
		$data['resultHeader'] = $resultHeader;
		$data['resultDetail'] = $resultList;
		$data['staffflag'] = $staffflag;
        $data['inputChangeList'] = $inputChangeList;
        
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

        $this->loadPage();
        $this->openView($this->data, 'detail');
    }
    function add_detail(){

    }
    function edit_detail($id){
        //$this->loadPage();
        //$this->openView($this->data, 'detail');

        //$this->load->view('ChangeManagement/popup/edit');
        $data = array();
        $data["projectId"] = $id;
        $data["functionNo"] = "test";
        //echo json_encode($data);
    
        $this->load->view('ChangeManagement/popup/edit',$data);
    }
    
}
	