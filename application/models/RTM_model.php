<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Requirements Traceability Matrix Model
*/
class RTM_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
		$this->load->model('FunctionalRequirement_model', 'mFR');
		$this->load->model('TestCase_model', 'mTestCase');
	}

	function searchRTMInfoByCriteria($projectId,$functionId,$functionVersion){

	$sqlStr = "SELECT 
					a.testCaseversion,b.testCaseNo,
					a.functionversion,a.functionId,c.functionNo,
					a.effectiveStartDate as createDate
					FROM M_RTM_VERSION a
					LEFT JOIN M_FN_REQ_HEADER c
					ON a.functionId = c.functionId
					LEFT JOIN M_TESTCASE_HEADER b
					ON a.testCaseId = b.testCaseId
					WHERE a.projectid = '$projectId'
					AND a.activeFlag = '1' 
					AND c.activeflag = '1'
					AND b.activeflag = '1'
					ORDER BY c.functionNo,a.functionversion
					 ";

		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

	function searchExistRTMInfoByTestCaseId($projectId, $testCaseId){
		$sqlStr = "SELECT *
			FROM M_RTM_VERSION r
			WHERE r.projectId = '$projectId'
			AND r.testCaseId= $testCaseId";
	 	$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

	function searchExistRTMVersion($projectId,$testCaseId,$functionId){
		$sqlStr = "SELECT *
			FROM M_RTM_VERSION 
			WHERE projectId = '$projectId'
			AND testCaseId = '$testCaseId'
			AND functionId = '$functionId'
			AND activeFlag = '1'";
		$result = $this->db->query($sqlStr);
		return $result->row();
	}

	function searchRTMVersionInfo($param){
		$sqlStr = "SELECT *
			FROM M_RTM_VERSION 
			WHERE projectId = $param->projectId
			";
		$result = $this->db->query($sqlStr);
		return $result->row();
	}

	function searchRTMVersionInfoByCriteria($param){
		//print_r($param->activeflag);

		if(isset($param->projectId) && !empty($param->projectId)){
			$where[] = "a.projectId = $param->projectId";
		}
		if((null != $param->activeflag)){
			$where[] = "a.activeflag = '$param->activeflag' ";
		}
		$where_condition = implode(" AND ", $where);
		//print_r($where_condition);
			$sqlStr ="SELECT 
					a.testCaseversion,b.testCaseNo,
					a.functionversion,a.functionId,c.functionNo,
					a.effectiveStartDate, 
					a.effectiveEndDate, a.activeFlag
					FROM M_RTM_VERSION a
					LEFT JOIN M_FN_REQ_HEADER c
					ON a.functionId = c.functionId
					AND a.functionVersion = c.functionVersion
					LEFT JOIN M_TESTCASE_HEADER b
					on a.testCaseId = b.testCaseId
					AND a.testCaseVersion = b.testCaseVersion
					where $where_condition
					ORDER BY functionNo,activeflag ";
					//print_r($sqlStr);
		$result = $this->db->query($sqlStr);
		//return $result->row();
		return $result->result_array();
	}	

	function updateRTMVersion($param){
		$effectiveEndDate = !empty($param->effectiveEndDate)? "'".$param->effectiveEndDate."'": "NULL";

		$sqlStr = "UPDATE M_RTM_VERSION
			SET effectiveEndDate = $effectiveEndDate,
				activeFlag = '$param->activeFlag',
				updateDate = '$param->updateDate',
				updateUser = '$param->user'
			WHERE rtmVersionId = $param->rtmVersionIdCondition 
			AND projectId = $param->projectId 
			AND updateDate = '$param->updateDateCondition'";
		$result = $this->db->query($sqlStr);
		return $this->db->affected_rows();
	}

	function deleteRTMVersion($param){
		$sqlStr = "DELETE FROM M_RTM_VERSION
			WHERE projectId = $param->projectId
			AND rtmVersionId = $param->rtmVersionId";
		$result = $this->db->query($sqlStr);
		return $this->db->affected_rows();
	}

	function searchExistFunctionalRequirement($fnId, $projectId){

		if(null != $projectId && !empty($projectId)){
			$where[] = "projectId = '$projectId'";
		}
		if(null != $fnId && !empty($fnId)){
			$where[] = "functionId = '$fnId'";
		}
		$where_clause = implode(' AND ', $where);
		
		$queryStr = "SELECT * 
			FROM M_FN_REQ_HEADER 
			WHERE $where_clause";
		//echo $queryStr;
		$result = $this->db->query($queryStr);
		return $result->row();
	}

	function insertRTMVersion($param, $user){
		$currentDateTime = date('Y-m-d H:i:s');
		$previousVersionId = !empty($param->previousVersionId)? $param->previousVersionId : 'NULL';

		$sqlStr = "INSERT INTO M_RTM_VERSION (projectId, testCaseId,testCaseversion,functionId,functionVersion,effectiveStartDate, effectiveEndDate, 
		activeFlag, createDate,	createUser, updateDate, updateUser)
		VALUES ($param->projectId, '$param->testCaseId','$param->testCaseversion','$param->functionId','$param->functionversion', '$param->effectiveStartDate', NULL, 
		'$param->activeFlag', '$currentDateTime', '$user', '$currentDateTime', '$user')";
		$result = $this->db->query($sqlStr);
		return $result;
	}

	function insertMapRTM($param, $user){
		$previousVersionId = !empty($param->previousVersionId)? $param->previousVersionId : 'NULL';

		$sqlStr = "INSERT INTO MAP_RTM (projectId, testcaseId,testcaseversion,
		functionId,functionVersion,activeFlag)
		VALUES ($param->projectId, '$param->testCaseId','$param->testCaseversion',
		'$param->functionId','$param->functionversion',
		'$param->activeFlag')";
		$result = $this->db->query($sqlStr);
		return $result;
	}

	function searchExistTestCaseHeader($projectId, $testCaseId){
		if(null != $projectId && !empty($projectId)){
			$where[] = "th.projectId = '$projectId'";
		}
		if(null != $testCaseId && !empty($testCaseId)){
			$where[] = "th.testCaseId = '$testCaseId'";
		}
		$where_clause = implode(' AND ', $where);

		$sqlStr = "SELECT *
			FROM M_TESTCASE_HEADER th
			WHERE $where_clause";
			//echo $sqlStr;
		$result = $this->db->query($sqlStr);
		return $result->row();
	}

	function uploadRTM($param, $user){
		$this->db->trans_begin(); //Starting Transaction
		$effectiveStartDate = '';

		for($i=0;$i<count($param);$i++){
			//echo $param->functionId;
			//echo $param[0]->testCaseId;
			$resultfunction = $this->searchExistFunctionalRequirement($param[$i]->functionId,$param[$i]->projectId);
			//3.1 Update Version
			//var_dump($resultfunction);
			$param[$i]->functionversion = $resultfunction->functionversion;
//			echo $i;
//echo $param[$i]->functionId;
			$resulttestcase = $this->searchExistTestCaseHeader($param[$i]->projectId,$param[$i]->testCaseId);
			//var_dump($resulttestcase);
		
			$param[$i]->testCaseversion = $resulttestcase->testcaseVersion;

		//	echo $param[0]->functionId;
		//	echo $param[0]->testCaseId;
			//Check Existing RTM Version
			$result = $this->searchExistRTMVersion($param[$i]->projectId,$param[$i]->testCaseId ,$param[$i]->functionId);
			if((NULL != $result) && (0 < count($result))){
				$effectiveStartDate = $result->effectiveStartDate;
			}else{
				$effectiveStartDate = date('Y-m-d H:i:s');
				$param[$i]->effectiveStartDate = $effectiveStartDate;
			}
			//print_r($param[$i]);

			$resultInsertRTMVersion = $this->insertRTMVersion($param[$i], $user);
			$resultInsertMapRTM= $this->insertMapRTM($param[$i], $user);

		}

    	$trans_status = $this->db->trans_status();
	    if($trans_status == FALSE){
	    	$this->db->trans_rollback();
	    	return false;
	    }else{
	   		$this->db->trans_commit();
	   		return true;
	    }
	}
}

?>