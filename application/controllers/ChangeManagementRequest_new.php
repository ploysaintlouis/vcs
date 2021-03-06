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

			$this->load->view('ChangeManagement/popup/add',$data);
			$dataTypeCombo = $this->mMisc->searchMiscellaneous('','');
			foreach ($dataTypeCombo as $value) {
				$this->load->view('ChangeManagement/popup/add',$dataTypeCombo);
			}

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

		$dataTypeCombo = $this->mMisc->searchMiscellaneous('','');
		foreach ($dataTypeCombo as $value) {
			//var_dump($value) ;
		}
		
		$this->load->view('ChangeManagement/popup/edit',$data);
		$this->load->view('ChangeManagement/popup/edit',$dataTypeCombo);
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

	function bind_data_title(){
		$data = array();
		$data['change_title'] = array();
		/// *** call model and bind data here.
		$data['change_title']['CH_NO'] = "CH01";
		$data['change_title']['FR_Request'] = "FR01";
		$data['change_title']['FR_Description'] = "Can simulate for calculate value stock";
		$data['change_title']['FR_Version'] = "V.1";
		return $data;
	}
	function bind_data_change_list(){
		$data = array();
		$data['change_list'] = array();
		/// *** call model and bind data here.
		$row = array();
		for($i=1;$i<5;$i++){
			$row["no"] = $i;
			$row["type"]= "input";
			$row["name"]= $i%3 == 0 ? "Stock" : "Unit";
			$row["data_type"]= "decimal";
			$row["data_length"]= "20";
			$row["scale"] ="";
			$row["default"]="";
			$row["isNotNull"]= false;
			$row["uniq"]="";
			$row["min"] = "10";
			$row["max"] = "9999";
			$row["table_name"]="";
			$row["field_name"]="";
			$row["change_type"]= $i%3 == 0 ? "Add" : "Edit";

			array_push($data['change_list'],$row);
		}
	
		return $data;
	}
	function bind_data_aff_testcase(){
		$data = array();
		$data['aff_testcase_list'] = array();
		/// *** call model and bind data here.
		$row=array();
		for($i=1;$i<3;$i++){
			$row["no"] = $i;
			$row["test_no"]= "Test Case 01";
			$row["change_type"]= "Edit";
			$row["version"]="V.2";

			array_push($data['aff_testcase_list'],$row);
		}
		return $data;
	}
	function bind_data_aff_schema(){
		$data = array();
		$data['aff_schema_list'] = array();
		/// *** call model and bind data here.
		$row=array();
		for($i=1;$i<3;$i++){
			$row["no"] = $i;
			$row["table_name"]= "Stock";
			$row["column_name"]= "StockName";
			$row["change_type"]= "Edit";
			$row["version"]="V.1";

			array_push($data['aff_schema_list'],$row);
		}
		return $data;
	}


	function view_change_result($RelateResultSCHEMA ){
		//see this function to bind load data to template view
		//url -> ChangeManagementRequest/view_change_result/{projectId}
		$dataForPage = array();
//echo $RelateResultSCHEMA ->functionId;
		//for use query something and send to page
		$dataForPage["projectId"] = $projectId;

		//bind data for mockup 
		//see in function parameter relate field in all view
		$title = $this->bind_data_title();
		$chglist = $this->bind_data_change_list();
		$affSchemalist = $this->bind_data_aff_schema();
		$affTestCaseList = $this->bind_data_aff_testcase();
		
		//send to page result/index 
		$dataForPage["title_panel"]= $title;
		$dataForPage["change_panel"]=$chglist;
		$dataForPage["aff_schema_panel"]=$affSchemalist;
		$dataForPage["aff_testcase_panel"] = $affTestCaseList;

		//template/header,template/body_javascript,template/footer ไม่จำเป็นต้องโหลดซ้ำ ถ้าหน้า อื่นโหลดมาให้แล้ว
		$this->load->view('template/header');
		$this->load->view('template/body_javascript');
		$this->load->view('ChangeManagement/results/index',$dataForPage);
		$this->load->view('template/footer');
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
				'type' 	 		  => 1 //1 = Change, 2 = Cancel
				);
			$RelateResultSCHEMA = $this->callChangeRelate($param);
			$RelateResultNotSCHEMA = $this->callChangeNotRelate($param);
			$ListofAffectFRRelateSchema = $this->callImpactFunctionRelate($param);
			$ListofAffectFRNotRelateSchema = $this->callImpactFunctionNotRelate($param);
			$ListofAffectOthFr = $this->callImpactOthFunction($param);
			$ListofAffectedTestCase = $this->callImpactTestCase($param,$ListofAffectOthFr);
			$ListofAffectedSchema = $this->callImpactSchema($param);

			//เรียก view_change_result 
			$this->view_change_result($RelateResultSCHEMA);

		}catch(Exception $e){
			$errorFlag = true;
			$error_message = $e;
		}

		$data['success_message'] = $success_message;
		$data['error_message'] = $error_message;
	}
	
	function callChangeRelate($param){//แยก รายการ change ที่ realte
	
		//กรองรายการ change ที่สัมพันธ์กับ SCHEMA
		$RelateResultSCHEMA = $this->mChange->searchChangeRequestrelateSCHEMA($param);
		foreach ($RelateResultSCHEMA as $value) {
			$param_schema = (object) array(
				'lineNumber' 	  => $value['lineNumber'],
				'userId' 	  		=> $value['userId'],
				'functionId' 	  => $value['functionId'],
				'functionVersion' => $value['functionVersion'],
				'typeData' 			=> $value['typeData'],
				'dataName'		  => $value['dataName'],
				'schemaVersionId' 	  => $value['schemaVersionId'],
				'newDataType' 	  		=> $value['newDataType'],
				'newDataLength' 	  => $value['newDataLength'],
				'newScaleLength' => $value['newScaleLength'],
				'newUnique' 			=> $value['newUnique'],
				'newNotNull'		  => $value['newNotNull'],
				'newDefaultValue' 	  		=> $value['newDefaultValue'],
				'newMinValue' 	  => $value['newMinValue'],
				'newMaxValue' => $value['newMaxValue'],
				'tableName' 			=> $value['tableName'],
				'columnName'		  => $value['columnName'],
				'changeType' 	 		  => $value['changeType'],
				'createUser'		  => $value['createUser'],
				'createDate' 	  		=> $value['createDate'],
				'dataId' 	  => $value['dataId'],
				'confirmflag' => $value['confirmflag'],
				'approveflag' 			=> $value['approveflag']
				);	
		}
		return $param_schema;
	}
	function callChangenotRelate($param){//แยก รายการ change ที่ไม่ relate
		//กรองรายการ change ที่ไม่สัมพันธ์กับ SCHEMA
		$NotRelateResultSCHEMA = $this->mChange->searchChangeRequestNotrelateSCHEMA($param);
		foreach ($NotRelateResultSCHEMA as $value) {
			$param_notschema = (object) array(
				'lineNumber' 	  => $value['lineNumber'],
				'userId' 	  		=> $value['userId'],
				'functionId' 	  => $value['functionId'],
				'functionVersion' => $value['functionVersion'],
				'typeData' 			=> $value['typeData'],
				'dataName'		  => $value['dataName'],
				'schemaVersionId' 	  => $value['schemaVersionId'],
				'newDataType' 	  		=> $value['newDataType'],
				'newDataLength' 	  => $value['newDataLength'],
				'newScaleLength' => $value['newScaleLength'],
				'newUnique' 			=> $value['newUnique'],
				'newNotNull'		  => $value['newNotNull'],
				'newDefaultValue' 	  		=> $value['newDefaultValue'],
				'newMinValue' 	  => $value['newMinValue'],
				'newMaxValue' => $value['newMaxValue'],
				'tableName' 			=> $value['tableName'],
				'columnName'		  => $value['columnName'],
				'changeType' 	 		  => $value['changeType'],
				'createUser'		  => $value['createUser'],
				'createDate' 	  		=> $value['createDate'],
				'dataId' 	  => $value['dataId'],
				'confirmflag' => $value['confirmflag'],
				'approveflag' 			=> $value['approveflag']
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
					'lineNumber' 	  => $value['lineNumber'],
					'userId' 	  		=> $value['userId'],
					'functionId' 	  => $value['functionId'],
					'functionVersion' => $value['functionVersion'],
					'typeData' 			=> $value['typeData'],
					'dataName'		  => $value['dataName'],
					'schemaVersionId' 	  => $value['schemaVersionId'],
					'newDataType' 	  		=> $value['newDataType'],
					'newDataLength' 	  => $value['newDataLength'],
					'newScaleLength' => $value['newScaleLength'],
					'newUnique' 			=> $value['newUnique'],
					'newNotNull'		  => $value['newNotNull'],
					'newDefaultValue' 	  		=> $value['newDefaultValue'],
					'newMinValue' 	  => $value['newMinValue'],
					'newMaxValue' => $value['newMaxValue'],
					'tableName' 			=> $value['tableName'],
					'columnName'		  => $value['columnName'],
					'changeType' 	 		  => $value['changeType'],
					'createUser'		  => $value['createUser'],
					'createDate' 	  		=> $value['createDate'],
					'dataId' 	  => $value['dataId'],
					'confirmflag' => $value['confirmflag'],
					'approveflag' 			=> $value['approveflag'],
					'FR_NAME'					=> $value['FR_NAME']
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
					'lineNumber' 	  => $value['lineNumber'],
					'userId' 	  		=> $value['userId'],
					'functionId' 	  => $value['functionId'],
					'functionVersion' => $value['functionVersion'],
					'typeData' 			=> $value['typeData'],
					'dataName'		  => $value['dataName'],
					'schemaVersionId' 	  => $value['schemaVersionId'],
					'newDataType' 	  		=> $value['newDataType'],
					'newDataLength' 	  => $value['newDataLength'],
					'newScaleLength' => $value['newScaleLength'],
					'newUnique' 			=> $value['newUnique'],
					'newNotNull'		  => $value['newNotNull'],
					'newDefaultValue' 	  		=> $value['newDefaultValue'],
					'newMinValue' 	  => $value['newMinValue'],
					'newMaxValue' => $value['newMaxValue'],
					'tableName' 			=> $value['tableName'],
					'columnName'		  => $value['columnName'],
					'changeType' 	 		  => $value['changeType'],
					'createUser'		  => $value['createUser'],
					'createDate' 	  		=> $value['createDate'],
					'dataId' 	  => $value['dataId'],
					'confirmflag' => $value['confirmflag'],
					'approveflag' 			=> $value['approveflag'],
					'FR_NAME'					=> $value['FR_NAME']
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
					'lineNumber' 	  => $value['lineNumber'],
					'userId' 	  		=> $value['userId'],
					'functionId' 	  => $value['functionId'],
					'functionVersion' => $value['functionVersion'],
					'typeData' 			=> $value['typeData'],
					'dataName'		  => $value['dataName'],
					'schemaVersionId' 	  => $value['schemaVersionId'],
					'newDataType' 	  		=> $value['newDataType'],
					'newDataLength' 	  => $value['newDataLength'],
					'newScaleLength' => $value['newScaleLength'],
					'newUnique' 			=> $value['newUnique'],
					'newNotNull'		  => $value['newNotNull'],
					'newDefaultValue' 	  		=> $value['newDefaultValue'],
					'newMinValue' 	  => $value['newMinValue'],
					'newMaxValue' => $value['newMaxValue'],
					'tableName' 			=> $value['tableName'],
					'columnName'		  => $value['columnName'],
					'changeType' 	 		  => $value['changeType'],
					'createUser'		  => $value['createUser'],
					'createDate' 	  		=> $value['createDate'],
					'dataId' 	  => $value['dataId'],
					'confirmflag' => $value['confirmflag'],
					'approveflag' 			=> $value['approveflag'],
					'FR_NAME'					=> $value['FR_NAME']
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
					'testCaseId' 	  => $value['testCaseId'],
					'testCaseNo' 	  		=> $value['testCaseNo'],
					'testcaseVersion' 	  => $value['testcaseVersion'],
					'typeData' => $value['typeData'],
					'TC_NAME' 			=> $value['TC_NAME'],
					'testData'		  => $value['testData'],
					'CH_NAME' 	  => $value['CH_NAME'],
					'changeType' 	  		=> $value['changeType'],
					'newdataType' 	  => $value['newdataType'],
					'newDataLength' => $value['newDataLength'],
					'newScaleLength' 			=> $value['newScaleLength'],
					'newUnique'		  => $value['newUnique'],
					'newDefaultValue' 	  		=> $value['newDefaultValue'],
					'newMinValue' 	  => $value['newMinValue'],
					'newMaxValue' => $value['newMaxValue']
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
					'functionId' 	  => $value['functionId'],
					'functionversion' 	  		=> $value['functionversion'],
					'projectId' 	  => $value['projectId'],
					'tableName' => $value['tableName'],
					'columnName' 			=> $value['columnName'],
					'schemaVersionId'		  => $value['schemaVersionId'],
					'dataType' 	  => $value['dataType'],
					'dataLength' 	  		=> $value['dataLength'],
					'decimalPoint' 	  => $value['decimalPoint'],
					'constraintPrimaryKey' => $value['constraintPrimaryKey'],
					'constraintUnique' 			=> $value['constraintUnique'],
					'constraintDefault'		  => $value['constraintDefault'],
					'constraintNull' 	  		=> $value['constraintNull'],
					'constraintMinValue' 	  => $value['constraintMinValue'],
					'constraintMaxValue' => $value['constraintMaxValue']
					);				
				}
		}else{
			$param_schema = null;
		}
		return $param_schema;
	}
		
}
	