<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Rollback Model
*/
class Rollback_model extends CI_Model{
	
	function __construct(){
		parent::__construct();

		$this->load->model('ChangeManagement_model', 'mChange');
        $this->load->model('Version_model', 'mVersion');
		$this->load->model('FunctionalRequirement_model', 'mFR');
		$this->load->model('TestCase_model', 'mTestCase');
		$this->load->model('DatabaseSchema_model', 'mDB');
		$this->load->model('RTM_model', 'mRTM');
	}

	public function searchApproveInformationForRollback($param){
		
		if(isset($param->projectId) && !empty($param->projectId)){
			$where[] = "h.projectId = '$param->projectId' ";
		}

		if(isset($param->changeRequestNo) && !empty($param->changeRequestNo)){
			$where[] = "h.changeRequestNo = '$param->changeRequestNo'";
		}

		if(isset($param->changeStatus) && !empty($param->changeStatus)){
			$where[] = "h.changeStatus = '$param->changeStatus'";
		}
		$where_condition = implode(" AND ", $where);

		/*
		$sqlStr = "
			SELECT 
				h.changeRequestNo,
				h.changeDate,
				CONCAT(u.firstname, '   ', u.lastname) as changeUser,
				h.changeFunctionId,
				h.changeFunctionNo,
				h.changeFunctionVersion,
				fh.functionDescription,
				h.changeRequestNo,
				h.changeStatus,
				h.changeStatus as changeStatusMisc,
				h.reason
			FROM T_CHANGE_REQUEST_HEADER h 
			INNER JOIN M_USERS u 
			ON h.changeUserId = u.userId
			INNER JOIN TEMP_ROLLBACK a
			ON a.ChangeRequestNo <> h.changeRequestNo
			INNER JOIN M_FN_REQ_HEADER fh 
			ON h.changeFunctionId = fh.functionId
			WHERE $where_condition
			ORDER BY h.changeDate desc";
			*/
			$sqlStr = "SELECT 
			h.changeRequestNo,
			h.changeDate,
			CONCAT(u.firstname, '   ', u.lastname) as changeUser,
			h.changeFunctionId,
			h.changeFunctionNo,
			h.changeFunctionVersion,
			fh.functionDescription,
			h.changeRequestNo,
			h.changeStatus,
			h.changeStatus as changeStatusMisc,
			h.reason
		FROM T_CHANGE_REQUEST_HEADER h ,M_USERS u ,M_FN_REQ_HEADER fh
		WHERE h.changeUserId = u.userId
					AND h.changeFunctionId = fh.functionId
					AND h.changeFunctionVersion = fh.functionVersion
		AND  h.changeRequestNo  IN (SELECT ChangeRequestNo FROM TEMP_ROLLBACK)
		AND $where_condition
		ORDER BY h.changeDate desc
		
";
		//	print_r($sqlStr);
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

	public function searchChangesInformationForRollback($param){
		
		if(isset($param->projectId) && !empty($param->projectId)){
			$where[] = "h.projectId = '$param->projectId' ";
		}

		if(isset($param->changeRequestNo) && !empty($param->changeRequestNo)){
			$where[] = "h.changeRequestNo = '$param->changeRequestNo'";
		}

		if(isset($param->changeStatus) && !empty($param->changeStatus)){
			$where[] = "h.changeStatus = '$param->changeStatus'";
		}
		$where_condition = implode(" AND ", $where);

			$sqlStr = "SELECT 
			h.changeRequestNo,
			h.changeDate,
			CONCAT(u.firstname, '   ', u.lastname) as changeUser,
			h.changeFunctionId,
			h.changeFunctionNo,
			h.changeFunctionVersion,
			fh.functionDescription,
			h.changeRequestNo,
			h.changeStatus,
			h.changeStatus as changeStatusMisc,
			h.reason
		FROM T_CHANGE_REQUEST_HEADER h ,M_USERS u ,M_FN_REQ_HEADER fh
		WHERE h.changeUserId = u.userId
					AND h.changeFunctionId = fh.functionId
					AND h.changeFunctionVersion = fh.functionVersion
		AND $where_condition
		ORDER BY h.changeDate desc
		
";
		//	print_r($sqlStr);
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

	public function getChangeRequestInputList($changeRequestNo){
		$sqlStr = "SELECT *
			FROM T_CHANGE_REQUEST_DETAIL
			WHERE changeRequestNo = '$changeRequestNo' 
			ORDER BY sequenceNo";
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

	public function getFRList($headerInfo){
		$functionId = $headerInfo['fnReqId'];
		$functionVersion = $headerInfo['fnReqVer'];	
		$sqlStr = "SELECT * 
			FROM M_FN_REQ_DETAIL
			WHERE functionId = '$functionId' 
			AND functionVersion = '$functionVersion'  ";
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

	public function getFRRollbackList($param){

		$sqlStr = "SELECT DISTINCT functionId,functionVersion
				FROM MAP_RTM
				WHERE changeRequestNo = '$param->changeRequestNo'
				AND projectId = '$param->projectId'
				ORDER BY 1,2";
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

	public function getTCRollbackList($param){

		$sqlStr = "SELECT DISTINCT testcaseId,testcaseVersion
				FROM MAP_RTM
				WHERE changeRequestNo = '$param->changeRequestNo'
				AND projectId = '$param->projectId'
				ORDER BY 1,2";
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

		public function getDBRollbackList($param){

		$sqlStr = "SELECT DISTINCT schemaVersionId,schemaVersion,tableName
				FROM MAP_SCHEMA
				WHERE changeRequestNo = '$param->changeRequestNo'
				AND projectId = '$param->projectId'
				ORDER BY 1,2";
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

	public function getRTMRollbackList($param){

		$sqlStr = "SELECT DISTINCT b.functionNo,b.functionVersion,c.testCaseNo,c.testcaseVersion,'1' activeflag
				FROM MAP_RTM a,M_FN_REQ_HEADER b,M_TESTCASE_HEADER c
				WHERE a.changeRequestNo = '$param->changeRequestNo'
				AND a.projectId = '$param->projectId'
				AND a.functionId = b.functionId
				AND a.functionVersion = b.functionVersion
				AND a.projectId = b.projectId
				AND a.testcaseId = c.testCaseId
				AND a.testcaseVersion = c.testcaseVersion
				AND a.projectId = c.projectId
				ORDER BY 1,2";
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

	public function getAffFR($param){

		$sqlStr = "SELECT DISTINCT b.functionId,b.functionNo,b.functionVersion,b.functionDescription,'0' activeflag
				FROM  MAP_RTM a,M_FN_REQ_HEADER b
				WHERE a.changeRequestNo = '$param->changeRequestNo'
				AND a.projectId = '$param->projectId'
				AND a.projectId = b.projectId
				AND a.functionId = b.functionId
				AND a.functionVersion = b.functionVersion
				AND b.activeflag = '1'
				UNION
				SELECT DISTINCT b.functionId,b.functionNo,b.functionVersion,b.functionDescription,'1' activeflag
				FROM  MAP_RTM a,M_FN_REQ_HEADER b
				WHERE a.changeRequestNo = '$param->changeRequestNo'
				AND a.projectId = '$param->projectId'
				AND a.projectId = b.projectId
				AND a.functionId = b.functionId
				AND a.functionVersion = b.functionVersion
				AND b.activeflag = '0'
				ORDER BY 1,2";
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}
	
	public function getAffTC($param){

		$sqlStr = "SELECT DISTINCT b.testCaseId,b.testCaseNo,b.testcaseVersion,b.testCaseDescription,'0' activeflag
				FROM  MAP_RTM a,M_TESTCASE_HEADER b
				WHERE a.changeRequestNo = '$param->changeRequestNo'
				AND a.projectId = '$param->projectId'
				AND a.projectId = b.projectId
				AND a.testcaseId = b.testCaseId
				AND a.testcaseVersion = b.testcaseVersion
				AND b.activeflag = '1'
				UNION
				SELECT DISTINCT b.testCaseId,b.testCaseNo,b.testcaseVersion,b.testCaseDescription,'1' activeflag
				FROM  MAP_RTM a,M_TESTCASE_HEADER b
				WHERE a.changeRequestNo = '$param->changeRequestNo'
				AND a.projectId = '$param->projectId'
				AND a.projectId = b.projectId
				AND a.testcaseId = b.testCaseId
				AND a.testcaseVersion = b.testcaseVersion
				AND b.activeflag = '0'
				ORDER BY 1,2";
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

	public function getAffDB($param){

		$sqlStr = "SELECT DISTINCT b.schemaVersionId,b.schemaVersionNumber,b.tableName,'0' activeflag
				FROM  MAP_SCHEMA a,M_DATABASE_SCHEMA_VERSION b
				WHERE a.changeRequestNo = '$param->changeRequestNo'
				AND a.projectId = '$param->projectId'
				AND a.projectId = b.projectId
				AND a.schemaVersionId <> b.schemaVersionId
				AND a.schemaVersion <> b.schemaVersionNumber
				AND b.activeflag = '1'
				UNION
				SELECT DISTINCT b.schemaVersionId,b.schemaVersionNumber,b.tableName,'1' activeflag
				FROM  MAP_SCHEMA a,M_DATABASE_SCHEMA_VERSION b
				WHERE a.changeRequestNo = '$param->changeRequestNo'
				AND a.projectId = '$param->projectId'
				AND a.projectId = b.projectId
				AND a.schemaVersionId = b.schemaVersionId
				AND a.schemaVersion = b.schemaVersionNumber
				AND b.activeflag = '0'
				ORDER BY 1,2";
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

	function getChangeHistoryFnReqHeaderList($changeRequestNo){
		$sqlStr = "SELECT c.*,m.New_FR_Id,m.Old_FR_Version,m.NEW_FR_No,m.New_FR_Version,
		f.functionDescription 
		FROM AFF_FR c 
		INNER JOIN M_FN_REQ_HEADER f 
		ON c.FR_Id = f.functionId
		AND c.FR_Version = f.functionVersion
		INNER JOIN MAP_FR_VERSION M 
		ON c.FR_Id = m.Old_FR_Id
		AND c.FR_Version = m.Old_FR_Version
		WHERE c.changeRequestNo = '$changeRequestNo'
		UNION
		SELECT c.Id,c.projectId,c.changeRequestNo,m.New_FR_Id FR_Id,m.New_FR_No FR_No,
		'' FR_Version,'' changeType ,m.New_FR_Id,'' Old_FR_Version,
		m.NEW_FR_No,m.New_FR_Version, f.functionDescription 
		FROM AFF_FR c 
		INNER JOIN M_FN_REQ_HEADER f 
		ON c.FR_Id = f.functionId
		AND c.FR_Version = f.functionVersion
		INNER JOIN MAP_FR_VERSION M 
		ON c.FR_Id = m.Old_FR_Id
		AND c.FR_Version = m.Old_FR_Version
		AND m.New_FR_Id <> c.FR_Id
		WHERE c.changeRequestNo = '$changeRequestNo'";
		$result = $this->db->query($sqlStr);
		return $result->result_array();	
	}

	function getChangeHistoryTestCaseList($changeRequestNo){
		$sqlStr = "SELECT ht.*,m.New_TC_Id,m.New_TC_No,m.New_TC_Version,rh.functionNo
		FROM AFF_TESTCASE ht
		INNER JOIN M_RTM_VERSION r
		ON ht.testcaseId = r.testCaseId
		AND ht.testcaseVersion = r.testCaseVersion
		INNER JOIN M_FN_REQ_HEADER rh
		ON r.functionId = rh.functionId
		AND r.functionVersion = rh.functionVersion
		INNER JOIN MAP_TC_VERSION m
		ON r.testCaseId = m.Old_TC_Id
		WHERE ht.ChangeRequestNo = '$changeRequestNo'
		UNION
		SELECT ht.id,ht.ChangeRequestNo,m.New_TC_Id testcaseId,m.New_TC_No testcaseNo,'' testcaseVersion,
		'add' changeType,m.New_TC_Id,m.New_TC_No,m.New_TC_Version,rh.functionNo
		FROM AFF_TESTCASE ht
		INNER JOIN M_RTM_VERSION r
		ON ht.testcaseId = r.testCaseId
		AND ht.testcaseVersion = r.testCaseVersion
		INNER JOIN M_FN_REQ_HEADER rh
		ON r.functionId = rh.functionId
		AND r.functionVersion = rh.functionVersion
		INNER JOIN MAP_TC_VERSION m
		ON r.testCaseId = m.Old_TC_Id
		AND m.New_TC_Id <> ht.testcaseId
		WHERE ht.ChangeRequestNo = '$changeRequestNo'
		ORDER BY testcaseNo";
		//echo $sqlStr;
		$result = $this->db->query($sqlStr);
		return $result->result_array();	
	}
	
	function getChangeHistoryDatabaseSchemaList($changeRequestNo){
		$sqlStr = "SELECT DISTINCT a.*,b.New_Schema_Version
			 FROM AFF_SCHEMA a,MAP_SCHEMA_VERSION b
			WHERE a.changeRequestNo = '$changeRequestNo'
			  AND a.changeType <> ''
			  AND a.schemaVersionId = b.Old_schemaVersionId
			  AND b.Old_Schema_Version = a.Version
			ORDER BY tableName, columnName
			";
		$result = $this->db->query($sqlStr);
		return $result->result_array();	
	}

	function getChangeHistoryRTM($changeRequestNo){
		$sqlStr = "SELECT 
				h.ChangeRequestNo, 
				h.testcaseId,
				h.testcaseNo,
				h.testcaseVersion,
				h.functionId,
				h.functionNo,
				h.functionVersion
			FROM AFF_RTM h
			WHERE h.changeRequestNo = '$changeRequestNo'
			ORDER BY h.functionNo, h.testCaseNo";
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

	function saveProcess($changeRequestNo, $projectId, $reason,$userId) {
		$currentDateTime = date('Y-m-d H:i:s');

		$strsql = "INSERT INTO TEMP_ROLLBACK 
		(projectid,ChangeRequestNo,status,userId,requestDate,reason)
		VALUES('$projectId','$changeRequestNo','0','$userId','$currentDateTime','$reason')
		";
    $result = $this->db->query($strsql);
   if($result){
    $query = $this->db->query("SELECT MAX(Id) AS last_id FROM TEMP_ROLLBACK");
       $resultId = $query->result();
       return $resultId[0]->last_id;
   }
   return NULL;
	} 
	
	function searchSaveProcessRollback($param){
		$sqlStr = "SELECT 
				a.ChangeRequestNo, 
				a.status,
				b.Firstname,
			  b.lastname,
				a.requestDate,
				a.reason
			 FROM TEMP_ROLLBACK a,M_USERS b
			WHERE a.userId = b.userId
			AND a.status = '0'
			AND projectId = '$param->projectId'
			ORDER BY requestDate";
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

	public function getChangeRequestFunctionalRequirement($changeRequestNo){

			$sqlStr = "SELECT h.*,fh.New_FR_Id,fh.New_FR_Version
			FROM AFF_FR h,MAP_FR_VERSION fh
			WHERE h.FR_Id = fh.Old_FR_Id
			AND h.FR_Version = fh.Old_FR_Version
			AND h.ChangeRequestNo = '$changeRequestNo'";
		//	print_r($sqlStr);
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}
	
	public function getChangeRequestTestCase($changeRequestNo){

			$sqlStr = "SELECT h.*,fh.New_TC_Id,fh.New_TC_Version
			FROM AFF_TESTCASE h,MAP_TC_VERSION fh
			WHERE h.testcaseId = fh.Old_TC_ID
			AND h.testcaseVersion = fh.Old_TC_Version
			AND h.ChangeRequestNo = '$changeRequestNo'";
		//	print_r($sqlStr);
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

	public function getChangeRequestSchema($changeRequestNo){

			$sqlStr = "SELECT DISTINCT a.SchemaVersionId,a.tableName,a.Version,
			b.New_SchemaVersionId,b.New_Schema_Version
			FROM AFF_SCHEMA a,MAP_SCHEMA_VERSION b
			WHERE b.Old_SchemaVersionId = a.SchemaVersionId 
			AND b.Old_Schema_Version = a.Version
			AND a.ChangeRequestNo = '$changeRequestNo' ";
		//	print_r($sqlStr);
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

	public function getChangeRequestSRTM($changeRequestNo){

			$sqlStr = "SELECT *
			FROM AFF_RTM
			WHERE ChangeRequestNo = '$changeRequestNo'";
		//	print_r($sqlStr);
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

	public function RollbackReason($changeRequestNo,$projectId){

		$sqlStr = "SELECT reason
		FROM TEMP_ROLLBACK
		WHERE ChangeRequestNo = '$changeRequestNo'
		AND projectId = '$projectId' ";
	//	print_r($sqlStr);
	$result = $this->db->query($sqlStr);
	return $result->result_array();
}

	function updateRollback_FRHeader($param_FR){

		$currentDateTime = date('Y-m-d H:i:s');

		$sqlStr = "UPDATE M_FN_REQ_HEADER
			SET activeflag = '1',
				updateDate 	 = '$currentDateTime',
				updateUser 	 = '$param_FR->user'
			WHERE functionId = '$param_FR->functionId'
			AND functionversion = '$param_FR->functionVersion'
			AND projectid = '$param_FR->projectId'
      AND activeflag = '0' ";
			//print_r($sqlStr);
            $result = $this->db->query($sqlStr);
            return $this->db->affected_rows();
    
		}

		function updateRequirementsHeader($param_FR){

			$currentDateTime = date('Y-m-d H:i:s');
	
			$sqlStr = "UPDATE M_FN_REQ_HEADER
				SET activeflag = '0',
					updateDate 	 = '$currentDateTime',
					updateUser 	 = '$param_FR->user'
				WHERE functionId = '$param_FR->New_FR_Id'
				AND functionversion = '$param_FR->New_FR_Version'
				AND projectid = '$param_FR->projectId'
							AND activeflag = '1' ";
				//print_r($sqlStr);
							$result = $this->db->query($sqlStr);
							return $this->db->affected_rows();
			
			}

		function updateRollback_FRDetail($param_FR) {
			$currentDateTime = date('Y-m-d H:i:s');
		
				$strsql = "UPDATE M_FN_REQ_DETAIL 
					SET effectiveEndDate = '$currentDateTime',
					updateDate = '$currentDateTime',
					updateUser = '$param_FR->user',
					activeFlag = '1'
					WHERE functionVersion = '$param_FR->functionVersion' 
					AND functionId = '$param_FR->functionId'
					AND activeflag = '0' 
					AND projectid = '$param_FR->projectId' 
			";
			$result = $this->db->query($strsql);
			return $this->db->affected_rows();
		} 

		function updateRequirementsDetail($param_FR) {
			$currentDateTime = date('Y-m-d H:i:s');
				
				$strsql = "UPDATE M_FN_REQ_DETAIL 
					SET effectiveEndDate = '$currentDateTime',
					updateDate = '$currentDateTime',
					updateUser = '$param_FR->user',
					activeFlag = '0'
					WHERE functionVersion = '$param_FR->New_FR_Version' 
					AND functionId = '$param_FR->New_FR_Id'
					AND activeflag = '1' 
					AND projectid = '$param_FR->projectId' 
				";
			$result = $this->db->query($strsql);
			return $this->db->affected_rows();
		} 				

		function updateTestcaseHeader($param_TC){
			$currentDateTime = date('Y-m-d H:i:s');

			$sqlStr = "UPDATE M_TESTCASE_HEADER
					SET activeFlag = '0', 
					updateDate = '$currentDateTime', 
					updateUser = '$param_TC->user' 
					WHERE projectId = '$param_TC->projectId'
					AND testCaseId = '$param_TC->New_testCaseId'
					AND testcaseVersion = '$param_TC->New_testcaseVersion' ";
//print_r($sqlStr);
			$result = $this->db->query($sqlStr);
			return $this->db->affected_rows();
	} 

	function updateRollback_TCHeader($param_TC){
		$currentDateTime = date('Y-m-d H:i:s');

		$sqlStr = "UPDATE M_TESTCASE_HEADER
				SET activeFlag = '1', 
				updateDate = '$currentDateTime', 
				updateUser = '$param_TC->user' 
				WHERE projectId = '$param_TC->projectId'
				AND testCaseId = '$param_TC->testCaseId'
				AND testcaseVersion = '$param_TC->testcaseVersion' ";
//print_r($sqlStr);
		$result = $this->db->query($sqlStr);
		return $this->db->affected_rows();
	} 

	function updateRollback_TCDetail($param_TC){
		$currentDateTime = date('Y-m-d H:i:s');

		$sqlStr = "UPDATE M_TESTCASE_DETAIL
			SET effectiveEndDate = '$currentDateTime', 
				activeFlag = '0', 
				updateDate = '$currentDateTime', 
				updateUser = '$param_TC->user' 
						WHERE projectId = '$param_TC->projectId'
						AND testCaseId = '$param_TC->New_testCaseId'
						AND testcaseVersion = '$param_TC->New_testcaseVersion' ";
		//print_r($sqlStr);
				$result = $this->db->query($sqlStr);
		return $this->db->affected_rows();
} 

function updateTestcaseDetail($param_TC){
	$currentDateTime = date('Y-m-d H:i:s');

	$sqlStr = "UPDATE M_TESTCASE_DETAIL
		SET effectiveEndDate = '$currentDateTime', 
			activeFlag = '1', 
			updateDate = '$currentDateTime', 
			updateUser = '$param_TC->user' 
					WHERE projectId = '$param_TC->projectId'
					AND testCaseId = '$param_TC->testCaseId'
					AND testcaseVersion = '$param_TC->testcaseVersion' ";
	//print_r($sqlStr);
			$result = $this->db->query($sqlStr);
	return $this->db->affected_rows();
} 

	function updateRollback_DBHeader($param_DB){
		$currentDateTime = date('Y-m-d H:i:s');

	$sqlStr = "UPDATE M_DATABASE_SCHEMA_VERSION
	SET effectiveEndDate = '$currentDateTime', 
		activeFlag = '1', 
		updateDate = '$currentDateTime', 
		updateUser = '$param_DB->user' 
				WHERE projectId = '$param_DB->projectId'
				AND schemaVersionId = '$param_DB->SchemaVersionId'
				AND schemaVersionNumber = '$param_DB->Version'
				AND activeflag = '0' ";
	//print_r($sqlStr);
		$result = $this->db->query($sqlStr);
	return $this->db->affected_rows();
	} 

	function updateSchemaHeader($param_DB){
		$currentDateTime = date('Y-m-d H:i:s');

	$sqlStr = "UPDATE M_DATABASE_SCHEMA_VERSION
	SET effectiveEndDate = '$currentDateTime', 
		activeFlag = '0', 
		updateDate = '$currentDateTime', 
		updateUser = '$param_DB->user' 
				WHERE projectId = '$param_DB->projectId'
				AND schemaVersionId = '$param_DB->New_SchemaVersionId'
				AND schemaVersionNumber = '$param_DB->New_Version'
				AND activeflag = '1' ";
	//print_r($sqlStr);
		$result = $this->db->query($sqlStr);
	return $this->db->affected_rows();
	} 

	function updateRollback_DBDetail($param_DB){

		$sqlStr = "UPDATE M_DATABASE_SCHEMA_INFO
			SET activeflag = '1'
            WHERE projectId = '$param_DB->projectId'
						AND schemaVersionId = '$param_DB->SchemaVersionId'
						AND Version = '$param_DB->Version'
            AND activeflag = '0' ";
//print_r($sqlStr);
        $result = $this->db->query($sqlStr);
		return $this->db->affected_rows();
		} 	
		
		function updateSchemaDetail($param_DB){

			$sqlStr = "UPDATE M_DATABASE_SCHEMA_INFO
				SET activeflag = '0'
							WHERE projectId = '$param_DB->projectId'
							AND schemaVersionId = '$param_DB->New_SchemaVersionId'
							AND Version = '$param_DB->New_Version'
							AND activeflag = '1' ";
	//print_r($sqlStr);
					$result = $this->db->query($sqlStr);
			return $this->db->affected_rows();
			}		

	function updateRollback_RTMHeader($param_RTM){
		$currentDateTime = date('Y-m-d H:i:s');
		
		$sqlStr = "UPDATE M_RTM_VERSION
			SET activeflag = '1',
				updateDate 	 = '$currentDateTime',
				updateUser 	 = '$param_RTM->user'
			WHERE functionId = '$param_RTM->functionId'
			AND functionversion = '$param_RTM->functionVersion'
			AND projectid = '$param_RTM->projectId'
			AND testCaseId = '$param_RTM->testCaseId'
			AND testCaseversion = '$param_RTM->testcaseVersion'
			AND activeflag = '0' ";
					//print_r($sqlStr);
			$result = $this->db->query($sqlStr);
			return $this->db->affected_rows();
	}		

	function updateRTMDetail($param_TC,$param_FR){
		$currentDateTime = date('Y-m-d H:i:s');
		
		$sqlStr = "UPDATE M_RTM_VERSION
			SET activeflag = '0',
				updateDate 	 = '$currentDateTime',
				updateUser 	 = '$param_FR->user'
			WHERE functionId = '$param_FR->functionId'
			AND functionversion = '$param_FR->functionVersion'
			AND projectid = '$param_FR->projectId'
			AND testCaseId = '$param_TC->testCaseId'
			AND testCaseversion = '$param_TC->testcaseVersion'
			AND activeflag = '1' ";
					//print_r($sqlStr);
			$result = $this->db->query($sqlStr);
			return $this->db->affected_rows();
	}	

	function updatestatusRolback($criteria) {
		$currentDateTime = date('Y-m-d H:i:s');

		$strsql = "UPDATE TEMP_ROLLBACK SET
		 status = '$criteria->changeStatus'
		WHERE projectId = '$criteria->projectId'
		AND changeRequestNo =  '$criteria->changeRequestNo'
		AND status = '0'
		";
		$result = $this->db->query($strsql);
		return $this->db->affected_rows();
	} 


	public function searchChangesInformationForCancelling($param){
		
		if(isset($param->projectId) && !empty($param->projectId)){
			$where[] = "h.projectId = $param->projectId";
		}

		if(isset($param->changeRequestNo) && !empty($param->changeRequestNo)){
			$where[] = "h.changeRequestNo = '$param->changeRequestNo'";
		}

		if(isset($param->changeStatus) && !empty($param->changeStatus)){
			$where[] = "h.changeStatus = '$param->changeStatus'";
		}
		$where_condition = implode(" AND ", $where);

		$sqlStr = "SELECT 
		h.changeRequestNo,
		h.changeDate,
		CONCAT(u.firstname, '   ', u.lastname) as changeUser,
		h.changeFunctionId,
		h.changeFunctionNo,
		h.changeFunctionVersion,
		fh.functionDescription,
		h.changeRequestNo,
		h.changeStatus,
		h.changeStatus as changeStatusMisc,
		h.reason
	FROM T_CHANGE_REQUEST_HEADER h ,M_USERS u ,M_FN_REQ_HEADER fh
	WHERE h.changeUserId = u.userId
	AND h.changeFunctionId = fh.functionId
	AND h.changeFunctionVersion = fh.functionVersion
	AND $where_condition
	AND  h.changeRequestNo NOT IN (SELECT ChangeRequestNo FROM TEMP_ROLLBACK WHERE status = '1')
  ORDER BY h.changeDate desc";
	//echo $sqlStr;
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}


}

?>