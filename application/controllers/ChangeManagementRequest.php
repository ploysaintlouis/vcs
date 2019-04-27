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
		//echo $keyId;
        //$this->openView($this->data, 'detail');
		if(null !== $keyId && !empty($keyId)){
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
			var_dump($value) ;
		}

        $data["projectId"] = $projectId;
		$data["dataId"] = $param->dataId;
		$data["functionId"] = $functionId;
		$data["functionVersion"] = $functionVersion;
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

        //echo json_encode($data);
    
        $this->load->view('ChangeManagement/popup/edit',$data);
    }
	
function callChangeAPI($param){//แยก รายการ change 
	
	//กรองรายการ change ที่สัมพันธ์กับ SCHEMA
	$RelateResultSCHEMA = $this->mChange->searchChangeRequestrelateSCHEMA($param);
	foreach ($RelateResultSCHEMA as $value) {
		//var_dump($value) ;
	}
	//กรองรายการ change ที่ไม่สัมพันธ์กับ SCHEMA
	$NotRelateResultSCHEMA = $this->mChange->searchChangeRequestNotrelateSCHEMA($param);
	foreach ($NotRelateResultSCHEMA as $value) {
		//var_dump($value) ;
	}
	$this->callImpactFunction($param);
}
	#======START FUNCTIONAL REQUIREMENT=======
function callImpactFunction($param){
	//เช็ครายการเปลี่ยนแปลง โดยมีชื่อ tableName กับ tablecolumn เหมือนกัน สัมพันธ์กับ SCHEMA
	$ListofChangeSchema = $this->mChange->checkChangeRequestrelateSCHEMA($param);
	foreach ($ListofChangeSchema as $value) {
		//var_dump($value) ;
	}

	//รายการเปลี่ยนแปลงที่ไม่ relate กับ schema
	$ListofChangeNotSchema = $this->mChange->checkChangeRequestNotRelateSchema($param);
	foreach ($ListofChangeNotSchema as $value) {
		//var_dump($value) ;
	}	

	// รายการเปลี่ยนแปลงที่กระทบกับ FR อื่นๆ ที่มี SCHEMA เดียวกัน
	$ListofChangeSchemaOthFr = $this->mChange->checkChangeRequestrelateSCHEMAOtherFr($param);
	foreach ($ListofChangeSchemaOthFr as $value) {
		//var_dump($value) ;
	}
	$this->callImpactTestCase($param,$ListofChangeSchemaOthFr);
}

	#========START TESTCASE AFFECTED====
function callImpactTestCase($param,$ListofChangeSchemaOthFr){
	$ListofTCAffected= $this->mChange->checkTestCaseAffected($param,$ListofChangeSchemaOthFr);
	foreach ($ListofTCAffected as $value) {
		//var_dump($value) ;
	}
	$this->callImpactSchema($param);
}
	#========START SCHEMA AFFECTED======
function callImpactSchema($param){
	//เก้บ SCHEMA ที่ได้รับผลกระทบ
	$ListofSchemaAffected= $this->mChange->checkSchemaAffted($param);
	foreach ($ListofSchemaAffected as $value) {
		var_dump($value) ;
	}
}

}
	