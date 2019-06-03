<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Test Case Model
*/
class TestCase_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	function searchTestCaseInfoByCriteria($projectId, $testCaseStatus,$testCaseNo,$testCaseVersion){
		$where[] = "th.projectId = ".$projectId." ";
		if("2" != $testCaseStatus){
			$where[] = "th.activeFlag = '".$testCaseStatus."'";
		}
		if(!empty($testCaseVersion)){
			$where[] = "th.testCaseVersion ='$testCaseVersion'";
		}
		if(!empty($testCaseNo)){
			$where[] = "th.testCaseNo = '$testCaseNo'";
		}		
		$where_clause = implode(' AND ', $where);
		$sqlStr = "SELECT 
				th.testCaseId,
				th.testCaseNo,
				th.testCaseDescription,
				th.expectedResult,
				th.testCaseVersion,
				th.UpdateDate,
				th.UpdateDate,
				th.activeFlag,
				h.functionNo,
				h.functionDescription
			FROM M_TESTCASE_HEADER th , M_RTM_VERSION r,M_FN_REQ_HEADER h 
			WHERE   th.testCaseId = r.testCaseId 
			AND th.testCaseVersion = r.testCaseVersion
			AND r.functionId = h.functionId 
			AND r.functionVersion = h.functionVersion
			AND h.activeflag = '1'
			AND $where_clause
			ORDER BY th.testCaseNo, th.testCaseVersion";
			//print_r($sqlStr);
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

	function searchCountAllTestCases(){
		$result = $this->db->query("
			SELECT count(*) as counts FROM M_TESTCASE_HEADER");
		return $result->row();
	}

	function searchExistTestCaseDetail($projectId, $testCaseNo = '',$testCaseversion, $refInputId = ''){
		if(!empty($projectId)){
			$where[] = "th.projectId = $projectId";
		}

		if(!empty($testCaseNo)){
			$where[] = "th.testCaseNo = '$testCaseNo'";
		}
		if(!empty($testCaseversion)){
			$where[] = "td.testCaseversion = $testCaseversion";
		}
		if(!empty($refInputId)){
			$where[] = "td.refdataId = $refdataId";
		}

		$where_condition = implode(' AND ', $where);

		$sqlStr = "SELECT 
				th.testCaseId,
				th.testCaseNo,
				td.refdataId,
				td.refdataName,
				td.testData
			FROM M_TESTCASE_HEADER th
			INNER JOIN M_TESTCASE_DETAIL td
			ON th.testCaseId = td.testCaseId
			WHERE td.activeFlag = '1'
			AND $where_condition";		
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

	function searchExistTestCaseHeader($projectId, $testCaseNo){
		if(null != $projectId && !empty($projectId)){
			$where[] = "th.projectId = $projectId";
		}
		if(null != $testCaseNo && !empty($testCaseNo)){
			$where[] = "th.testCaseNo = '$testCaseNo'";
		}
		$where_clause = implode(' AND ', $where);

		$sqlStr = "SELECT *
			FROM M_TESTCASE_HEADER th
			WHERE $where_clause";
		$result = $this->db->query($sqlStr);
		return $result->row();
	}

	function searchTestCaseVersionInformationByCriteria($param){
		if(isset($param->testCaseId) && !empty($param->testCaseId)){
			$where[] = "h.testCaseId = $param->testCaseId";
		}
		if(isset($param->testCaseVersion) && !empty($param->testCaseVersion)){
			$where[] = "v.testCaseVersion = $param->testCaseVersion";
		}
		$where_condition = implode(" AND ", $where);
		
		$sqlStr = "SELECT 
			h.testCaseId, h.testCaseNo, v.testCaseVersion, 
			v.effectiveStartDate, v.effectiveEndDate, v.updateDate, v.activeFlag
			FROM M_TESTCASE_HEADER h
			INNER JOIN M_TESTCASE_DETAIL v
			ON h.testCaseId = v.testCaseId
			AND h.testCaseVersion = v.testCaseVersion
			WHERE $where_condition";
			//print_r($sqlStr);
		$result = $this->db->query($sqlStr);
		return $result->row();
	}

	function insertTestCaseHeader($param, $user,$New_testCaseId){
		$currentDateTime = date('Y-m-d H:i:s');
		$sqlStr = "INSERT INTO M_TESTCASE_HEADER (testCaseId,testCaseNo, testCaseDescription, expectedResult, projectId, createDate, createUser, updateDate, updateUser,testcaseVersion,activeflag) 
		VALUES ('{$New_testCaseId}','{$param->testCaseNo}', '{$param->testCaseDescription}', '{$param->expectedResult}', {$param->projectId}, '{$currentDateTime}', '$user', '{$currentDateTime}', '$user','{$param->testcaseVersion}','{$param->activeflag}')";
		$result = $this->db->query($sqlStr);
		if($result){
			$query = $this->db->query("SELECT MAX(testCaseId) AS last_id FROM M_TESTCASE_HEADER");
			$resultId = $query->result();
			return $resultId[0]->last_id;
		}
		return null;
	}
function searchFRMAXTCNo() {

		$strsql = " SELECT max(testCaseNo) AS Max_TCNO 
					FROM M_TESTCASE_HEADER ";

   $result = $this->db->query($strsql);
   return  $result->row();
} 
	function insertTestCaseDetail($param, $user){
		$currentDateTime = date('Y-m-d H:i:s');
		
		$sqlStr = "INSERT INTO M_TESTCASE_DETAIL (testCaseId, typeData, refdataId, refdataName, testData, effectiveStartDate, 
		effectiveEndDate, activeFlag, createDate, createUser, updateDate, updateUser,projectId,testCaseNo,testcaseVersion) 
		VALUES ('{$param->testCaseId}','{$param->typeData}', '{$param->refdataId}', '{$param->refdataName}', '{$param->testData}', '{$param->effectiveStartDate}', 
		NULL, '{$param->activeStatus}', '{$currentDateTime}', '$user', '{$currentDateTime}', '$user','{$param->projectId}','{$param->testCaseNo}', '{$param->initialVersionNo}')";

		$result = $this->db->query($sqlStr);
		return $result;
	}
/*
	function insertTestCaseVersion($param, $user){
		$currentDateTime = date('Y-m-d H:i:s');
		$previousVersionId = !empty($param->previousVersionId)? $param->previousVersionId : "NULL";

		$sqlStr = "INSERT INTO M_TESTCASE_VERSION (testCaseVersionNumber,testCaseVersion, 
		effectiveStartDate, effectiveEndDate, activeFlag, createDate, createUser, updateDate,
		 updateUser) VALUES ('{$param->testCaseNo}', '{$param->initialVersionNo}', 
		 '{$param->effectiveStartDate}', NULL, '{$param->activeStatus}', '{$currentDateTime}', 
		 '$user', '{$currentDateTime}', '$user')";
		$result = $this->db->query($sqlStr);
		return $result;
	}

	function updateTestCaseVersion($param){
		$effectiveEndDate = empty($param->effectiveEndDate)? "NULL": "'".$param->effectiveEndDate."'";

		$sqlStr = "UPDATE M_TESTCASE_VERSION 
			SET effectiveEndDate = $effectiveEndDate, 
				activeFlag = '$param->activeFlag', 
				updateDate = '$param->updateDate', 
				updateUser = '$param->updateUser'  
			WHERE testCaseId = $param->testCaseId 
			AND testCaseVersion = $param->testCaseVersionId 
			AND updateDate = '$param->updateDateCondition'";
		$result = $this->db->query($sqlStr);
		return $this->db->affected_rows();	
	}
*/
	function updateTestCaseDetail($param){
		$effectiveEndDate = empty($param->effectiveEndDate)? "NULL": "'".$param->effectiveEndDate."'";

		if(isset($param->testCaseId) && !empty($param->testCaseId)){
			$where[] = "testCaseId = $param->testCaseId";
		}

		if(isset($param->inputId) && !empty($param->inputId)){
			$where[] = "refInputId 	= $param->inputId";
		}

		if(isset($param->activeFlagCondition) && !empty($param->activeFlagCondition)){
			$where[] = "activeFlag 	= '$param->activeFlagCondition'";
		}

		if(isset($param->endDateCondition) && !empty($param->endDateCondition)){
			$where[] = "effectiveEndDate = '$param->endDateCondition'";
		}
		$where_condition = implode(" AND ", $where);

		$sqlStr = "UPDATE M_TESTCASE_DETAIL
			SET effectiveEndDate = $effectiveEndDate, 
				activeFlag = '$param->activeFlag', 
			 	updateDate = '$param->updateDate', 
			 	updateUser = '$param->updateUser' 
			WHERE $where_condition";
		
		$result = $this->db->query($sqlStr);
		return $this->db->affected_rows();
	}
/*
	function deleteTestCaseVersion($param){
		if(isset($param->testCaseId) && !empty($param->testCaseId)){
			$where[] = "testCaseId = $param->testCaseId";
		}
		if(isset($param->testCaseVersionId) && !empty($param->testCaseVersionId)){
			$where[] = "testCaseVersionId = $param->testCaseVersionId";
		}
		if(isset($param->testCaseVersionNumber) && !empty($param->testCaseVersionNumber)){
			$where[] = "testCaseVersionNumber = $param->testCaseVersionNumber";
		}
		$where_condition = implode(" AND ", $where);

		$sqlStr = "DELETE FROM M_TESTCASE_VERSION WHERE $where_condition";

		$result = $this->db->query($sqlStr);
		return $this->db->affected_rows();	
	}
*/
	function deleteTestCaseHeader($testCaseId){
		$sqlStr = "DELETE FROM M_TESTCASE_HEADER
			WHERE testCaseId = $testCaseId";
		$result = $this->db->query($sqlStr);
		return $this->db->affected_rows();
	}

	function searchMaxTestcaseId(){

		$strsql = " SELECT MAX(testCaseId) as MAX_TestCaseId
		FROM M_TESTCASE_HEADER 
	    ";

		$result = $this->db->query($strsql);
		//echo $sqlStr ;
		return $result->result_array();
	}

	function deleteTestCaseDetail($param){
		if(isset($param->testCaseId)  && !empty($param->testCaseId)){
			$where[] = "testCaseId = $param->testCaseId";
		}
		if(isset($param->inputId) && !empty($param->inputId)){
			$where[] = "dataId = $param->dataId";
		}
		if(isset($param->effectiveStartDate) && !empty($param->effectiveStartDate)){
			$where[] = "effectiveStartDate = '$param->effectiveStartDate'";
		}
		$where_condition = implode(" AND ", $where);
		
		$sqlStr = "DELETE FROM M_TESTCASE_DETAIL WHERE $where_condition";
		
		$result = $this->db->query($sqlStr);
		return $this->db->affected_rows();
	}

	function uploadTestCaseInfo($param, $user){
		$this->db->trans_begin(); //Starting Transaction

		$effectiveStartDate = date('Y-m-d H:i:s');
		$MAX_TestCaseId = $this->searchMaxTestcaseId();
		$New_testCaseId = $MAX_TestCaseId[0]['MAX_TestCaseId']+1;

		//Check Existing Test Case Header
		//var_dump($param[0]);
		$param[0]->testcaseVersion = '1';
		$param[0]->activeflag = '1';

		$result = $this->searchExistTestCaseHeader($param[0]->projectId, $param[0]->testCaseNo);
		if(null != $result && 0 < count($result)){
			$testCaseId = $result->testCaseId;
		}else{
			//Insert new Test Case Header
			$testCaseId = $this->insertTestCaseHeader($param[0], $user,$New_testCaseId);
			
			//Insert new Test Case Version

			$param[0]->testCaseId = $testCaseId;
			$param[0]->effectiveStartDate = $effectiveStartDate;
			//$this->insertTestCaseVersion($param[0], $user);
		}
		
		//Insert new Test Case Details
		if(null != $testCaseId && !empty($testCaseId)){
			foreach ($param as $value){
				if (($value->typeData == 'input') || ($value->typeData == 'Input')) {
					$value->typeData  = '1';
				}
				if (($value->typeData == 'output') || ($value->typeData == 'Output')) {
					$value->typeData  = '2';
				}	

				$value->testCaseId = $testCaseId;
				$value->effectiveStartDate = $effectiveStartDate;

				$resultInsertDetail = $this->insertTestCaseDetail($value, $user);
			}
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