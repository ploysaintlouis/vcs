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
		return $this->db->affected_rows();
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
			ORDER BY requestDate";
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

}

?>