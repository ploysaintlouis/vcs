<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Change Management Model
*/
class ChangeManagement_model extends CI_Model{
	
	function __construct(){
		parent::__construct();

		$this->load->model('FunctionalRequirement_model', 'mFR');
		$this->load->model('DatabaseSchema_model', 'mDB');
		$this->load->model('Miscellaneous_model', 'mMisc');
		$this->load->model('TestCase_model', 'mTestCase');
		$this->load->model('RTM_model', 'mRTM');
		$this->load->model('Common_model', 'mCommon');
	}

	function searchTempFRInputChangeList($param){

		if(!empty($param->userId)){
			$where[] = "userId = $param->userId";
		}

		if(!empty($param->functionId)){
			$where[] = "functionId = $param->functionId";
		}

		if(!empty($param->functionVersion)){
			$where[] = "functionVersion = $param->functionVersion";
		}

		if(!empty($param->dataId)){
			$where[] = "dataId = $param->dataId";
		}

		if(!empty($param->schemaVersionId)){
			$where[] = "schemaVersionId = $param->schemaVersionId";
		}

		//For Adding new input
	/*	if(!empty($param->dataName) && !empty($param->table) && !empty($param->column)){
			$where[] = "((dataName = '$param->dataName') 
				OR (tableName = '$param->table' AND columnName = '$param->column'))";
		}
		*/
		if(!empty($param->dataName)){
			$where[] = "dataName = '$param->dataName'";
		}
		$where_clause = implode(' AND ', $where);

		$sqlStr = "SELECT *
			FROM T_TEMP_CHANGE_LIST
			WHERE $where_clause
			ORDER BY lineNumber";
		//	echo $sqlStr;
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

	function searchFRInputChangeList($param){
		if(!empty($param->userId)){
			$where[] = "userId = '$param->userId'";
		}
		if(!empty($param->functionId)){
			$where[] = "functionId = '$param->functionId'";
		}
		if(!empty($param->functionVersion)){
			$where[] = "functionVersion = '$param->functionVersion'";
		}
		if(!empty($param->dataId)){
			$where[] = "dataId = $param->dataId";
		}

		if(!empty($param->schemaVersionId)){
			$where[] = "schemaVersionId = $param->schemaVersionId";
		}
		if(!empty($param->dataName)){
			$where[] = "dataName = '$param->dataName'";
		}
		$where_clause = implode(' AND ', $where);

		$sqlStr = "SELECT *
			FROM T_TEMP_CHANGE_LIST
			WHERE $where_clause
			ORDER BY lineNumber";
			echo $sqlStr;
		$result = $this->db->query($sqlStr);
		return $result->row();
	}

	function searchChangeRequestList(){
		$sqlStr = "SELECT 
				p.projectName, 
				p.projectNameAlias, 
				i.changeRequestNo,
				i.changeStatus, 
				i.changeUserId,
				CONVERT(i.changeDate,CHAR) AS changeDate,
				CONCAT(u.Firstname,' ',u.lastname) AS changeUser
			FROM T_CHANGE_REQUEST_HEADER i
			INNER JOIN M_PROJECT p
			ON i.projectId = p.projectId
			INNER JOIN M_USERS u
			ON i.changeUserId = u.userId
			ORDER BY i.createDate desc LIMIT 0,10";
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

	function searchRelatedChangeFRInputs($param){
		/*$sqlStr = "SELECT  t.functionId, d.functionId, d.inputId
			FROM T_TEMP_CHANGE_LIST t 
			INNER JOIN M_FN_REQ_DETAIL d
			ON t.inputId = d.inputId
			AND d.functionId <> t.functionId
			AND d.activeFlag = '1'
			WHERE t.changeType IN ('edit', 'delete')
			AND t.userId = $param->userId
			AND t.functionId = $param->functionId
			AND t.functionVersion = $param->functionVersion";
			*/
		$sqlStr = "SELECT  t.functionId, d.functionId, d.dataId
			FROM T_TEMP_CHANGE_LIST t 
			INNER JOIN M_FN_REQ_DETAIL d
			ON t.dataId = d.dataId
			AND d.functionId = t.functionId
			AND d.activeFlag = '1'
			WHERE t.changeType IN ('edit', 'delete')
			AND t.confirmflag = '1'
			AND t.userId = $param->userId
			AND t.functionId = $param->functionId
			AND t.functionVersion = $param->functionVersion";
			//echo $sqlStr;
		$result = $this->db->query($sqlStr);
		return $result->result_array();	
	}

	function deleteTempFRInputChangeList($param){
		if(!empty($param->userId)){
			$where[] = "userId = $param->userId";
		}

		if(!empty($param->functionId)){
			$where[] = "functionId = $param->functionId";
		}

		if(!empty($param->functionVersion)){
			$where[] = "functionVersion = $param->functionVersion";
		}

		if(!empty($param->lineNumber)){
			$where[] = "lineNumber = $param->lineNumber";
		}

		$where_condition = implode(' AND ', $where);

		$sqlStr = "DELETE FROM T_TEMP_CHANGE_LIST
			WHERE $where_condition";
		$result = $this->db->query($sqlStr);
		return $this->db->affected_rows();
	}

	function insertTempFRInputChange($param){
		$currentDateTime = date('Y-m-d H:i:s');

		$schemaVersionId = !empty($param->schemaVersionId)? $param->schemaVersionId : "NULL";
		$dataType = !empty($param->dataType)? "'".$param->dataType."'" : "NULL";
		$dataLength = !empty($param->dataLength)? $param->dataLength : "NULL";
		$scale = !empty($param->scaleLength)? $param->scaleLength : "NULL";
		$unique = !empty($param->unique)? "'".$param->unique."'" : "NULL";
		$notNull = !empty($param->notNull)? "'".$param->notNull."'" : "NULL";
		$default = !empty($param->default)? "'".$param->default."'" : "NULL";
		$min = !empty($param->min)? "'".$param->min."'" : "NULL";
		$max = !empty($param->max)? "'".$param->max."'" : "NULL";
		$tableName = !empty($param->table)? "'".$param->table."'" : "NULL";
		$columnName = !empty($param->column)? "'".$param->column."'" : "NULL";

		$dataLength = !empty($dataLength)? $dataLength : "NULL";

		$sqlStr = "INSERT INTO T_TEMP_CHANGE_LIST (userId, functionId, functionVersion,typeData, dataName, schemaVersionId, newDataType, newDataLength, 
		newScaleLength, newUnique, newNotNull, newDefaultValue, newMinValue, newMaxValue, tableName, columnName, changeType, createUser, createDate,dataId,confirmflag,approveflag) 
			VALUES (
				'$param->userId', 
				'$param->functionId',
				'$param->functionVersion',
				'$param->typeData',
				'$param->dataName',
				$schemaVersionId,
				$dataType,
				$dataLength,
				$scale,
				$unique,
				$notNull,
				$default,
				$min,
				$max,
				$tableName,
				$columnName,
				'$param->changeType',
				'$param->user', 
				'$currentDateTime',
				'$param->dataId',
				NULL,
				NULL)";
echo $sqlStr;
		$result = $this->db->query($sqlStr);
		return $result;
	}

	function insertChangeRequestHeader($param){
		
		$sqlStr = "INSERT INTO T_CHANGE_REQUEST_HEADER (changeRequestNo, changeUserId, changeDate, projectId, changeFunctionId, changeFunctionNo, changeFunctionVersion, changeStatus, createUser, createDate, updateUser, updateDate) VALUES ('$param->changeRequestNo', $param->changeUser, '$param->changeDate', $param->projectId, $param->changeFunctionId, '$param->changeFunctionNo', '$param->changeFunctionVersion', '$param->changeStatus', '$param->user', '$param->currentDate', '$param->user', '$param->currentDate')";
		
		$result = $this->db->query($sqlStr);
		return $result;
	}

	function insertChangeRequestDetail($param){

		$dataId = !empty($param->dataId)? $param->dataId : "NULL";
		$schemaVersionId = !empty($param->schemaVersionId)? $param->schemaVersionId : "NULL";

		$dataType = !empty($param->dataType)? "'".$param->dataType."'" : "NULL";
		$dataLength = !empty($param->dataLength)? $param->dataLength : "NULL";
		$scale = !empty($param->scale)? $param->scale : "NULL";
		$unique = !empty($param->unique)? "'".$param->unique."'" : "NULL";
		$notNull = !empty($param->notNull)? "'".$param->notNull."'" : "NULL";
		$default = !empty($param->default)? "'".$param->default."'" : "NULL";
		$min = !empty($param->min)? "'".$param->min."'" : "NULL";
		$max = !empty($param->max)? "'".$param->max."'" : "NULL";
		$tableName = !empty($param->tableName)? "'".$param->tableName."'" : "NULL";
		$columnName = !empty($param->columnName)? "'".$param->columnName."'" : "NULL";

		$sqlStr = "INSERT INTO T_CHANGE_REQUEST_DETAIL (changeRequestNo, sequenceNo, changeType,typeData, refdataId, refSchemaVersionId, dataName, dataType, dataLength, scale, constraintUnique, constraintNotNull, constraintDefault, constraintMin, constraintMax, refTableName, refColumnName) VALUES ('$param->changeRequestNo', $param->sequenceNo, '$param->changeType','$param->typeData', $dataId, $schemaVersionId, '$param->dataName', $dataType, $dataLength, $scale, $unique, $notNull, $default, $min, $max, $tableName, $columnName)";
		$result = $this->db->query($sqlStr);
		return $result;
	}

	function insertChangeHistory_RequirementsHeader($param){
		$sqlStr = "INSERT INTO T_CHANGE_HISTORY_REQ_HEADER (changeRequestNo, functionId, functionNo, oldFunctionVersion, newFunctionVersion) VALUES ('$param->changeRequestNo', $param->functionId, '$param->functionNo', $param->oldFnVersionNumber, $param->newFnVersionNumber)";
		$result = $this->db->query($sqlStr);
		if($result){
			$query = $this->db->query("SELECT IDENT_CURRENT('T_CHANGE_HISTORY_REQ_HEADER') as last_id");
			$resultId = $query->result();
			return $resultId[0]->last_id;
		}
		return NULL;
	}

	function insertChangeHistory_RequirementsDetail($param){
		$sqlStr = "INSERT INTO T_CHANGE_HISTORY_REQ_DETAIL (fnReqHistoryId, sequenceNo, changeType, inputName, refTableName, refColumnName) VALUES ($param->fnReqHistoryId, $param->sequenceNo, '$param->changeType', '$param->inputName', '$param->refTableName', '$param->refColumnName')";
		$result = $this->db->query($sqlStr);
		return $result;
	}

	function insertChangeHistory_Schema($param){
		$oldVersionNumber = !empty($param->oldSchemaVersionNumber)? $param->oldSchemaVersionNumber : "NULL";
		$newVersionNumber = !empty($param->newSchemaVersionNumber)? $param->newSchemaVersionNumber : "NULL";

		$sqlStr = "INSERT INTO T_CHANGE_HISTORY_SCHEMA (changeRequestNo, sequenceNo, tableName, columnName, oldSchemaVersionNumber, newSchemaVersionNumber, changeType) VALUES ('$param->changeRequestNo', $param->sequenceNo, '$param->tableName', '$param->columnName', $oldVersionNumber, $newVersionNumber, '$param->changeType') ";
		$result = $this->db->query($sqlStr);
		return $result;
	}

	function insertChangeHistory_TestCase($param){
		$oldTCVerNumber = !empty($param->oldTestCaseVersionNo)? $param->oldTestCaseVersionNo : "NULL";
		$newTCVerNumber = !empty($param->newTestCaseVersionNo)? $param->newTestCaseVersionNo : "NULL";

		$sqlStr = "INSERT INTO T_CHANGE_HISTORY_TESTCASE (changeRequestNo, testCaseId, testCaseNo, oldTestCaseVersionNumber, newTestCaseVersionNumber, changeType) VALUES ('$param->changeRequestNo', $param->testCaseId, '$param->testCaseNo', $oldTCVerNumber, $newTCVerNumber, '$param->changeType')";
		$result = $this->db->query($sqlStr);
		return $result;
	}

	function insertChangeHistory_RTMHeader($param){
		$sqlStr = "INSERT INTO T_CHANGE_HISTORY_RTM_HEADER (changeRequestNo, projectId, oldVersionNumber, newVersionNumber) VALUES ('$param->changeRequestNo', $param->projectId, $param->oldVersionNumber, $param->newVersionNumber)";
		$result = $this->db->query($sqlStr);
		if($result){
			$query = $this->db->query("SELECT IDENT_CURRENT('T_CHANGE_HISTORY_RTM_HEADER') as last_id");
			$resultId = $query->result();
			return $resultId[0]->last_id;
		}
		return NULL;
	}

	function updateChangeRequestHeader($param){
		$sqlStr = "UPDATE T_CHANGE_REQUEST_HEADER
			SET changeStatus = '$param->status',
				reason 		 = '$param->reason',
				updateDate 	 = '$param->updateDate',
				updateUser 	 = '$param->user'
			WHERE changeRequestNo = '$param->changeRequestNo'
			AND updateDate = '$param->updateDateCondition'";
		$result = $this->db->query($sqlStr);
		return $this->db->affected_rows();
	}

	function insertChangeHistory_RTMDetail($param){
		$sqlStr = "INSERT INTO T_CHANGE_HISTORY_RTM_DETAIL (rtmHistoryId, sequenceNo, functionId, testCaseId, changeType) VALUES ($param->rtmHistoryId, $param->sequenceNo, $param->functionId, $param->testCaseId, '$param->changeType')";
		$result = $this->db->query($sqlStr);
		return $result;
	}

	function getLastDatabaseSchemaVersion($projectId, $tableName, $columnName){
		$sqlStr = "SELECT schemaVersionId, schemaVersionNumber, updateDate
			FROM M_DATABASE_SCHEMA_VERSION
			WHERE activeFlag = '1'
			AND projectId = $projectId
			AND tableName = '$tableName'
			AND columnName = '$columnName'";
		$result = $this->db->query($sqlStr);
		return $result->row();
	}

	function getLastFunctionalRequirementVersion($functionId){
		/*$sqlStr = "SELECT functionVersionId, functionVersionNumber, updateDate
			FROM M_FN_REQ_VERSION
			WHERE functionId = $functionId
			AND activeFlag = '1'";
*/
		$sqlStr = "SELECT functionId, functionVersionNumber, updateDate
		FROM M_FN_REQ_VERSION
		WHERE functionId = $functionId
		AND activeFlag = '1'";

		$result = $this->db->query($sqlStr);
		return $result->row();
	}
	function getFunctionalRequirementNo($functionId){
		/*$sqlStr = "SELECT functionVersionId, functionVersionNumber, updateDate
			FROM M_FN_REQ_VERSION
			WHERE functionId = $functionId
			AND activeFlag = '1'";
*/
		$sqlStr = "SELECT functionId, functionNo, updateDate
		FROM M_FN_REQ_HEADER
		WHERE functionId = $functionId
		AND activeFlag = '1'";

		$result = $this->db->query($sqlStr);
		return $result->row();
	}
	function getLastFunctionalRequirementNo($functionId){
		/*$sqlStr = "SELECT functionVersionId, functionVersionNumber, updateDate
			FROM M_FN_REQ_VERSION
			WHERE functionId = $functionId
			AND activeFlag = '1'";
*/
		$sqlStr = "SELECT Max(functionNo) AS functionNo
		FROM M_FN_REQ_HEADER
		WHERE activeFlag = '1'";

		$result = $this->db->query($sqlStr);
		return $result->row();
	}	
	function getLastTestCaseVersion($projectId, $testCaseNo, $testCaseVersionNo){
		$sqlStr = "SELECT h.testCaseId,v.testCaseVersion,v.testCaseVersionNumber, v.updateDate
			FROM M_TESTCASE_HEADER h
			INNER JOIN M_TESTCASE_VERSION v
			ON h.testCaseId = v.testCaseId
			WHERE v.activeFlag = '1'
			AND h.projectId = $projectId
			AND h.testCaseNo = '$testCaseNo'
			AND v.testCaseVersion = $testCaseVersionNo";
		$result = $this->db->query($sqlStr);	
		return $result->row();
	}

	function getLastRTMVersion($projectId){
		$sqlStr = "SELECT 
				rtmVersionId,
				rtmVersionNumber,
				updateDate
			FROM M_RTM_VERSION 
			WHERE projectId = $projectId
			AND activeFlag = '1'";
		$result = $this->db->query($sqlStr);	
		return $result->row();
	}

	function getChangeRequestInformation($changeRequestNo){
		$sqlStr = "SELECT 
				h.changeRequestNo,
				CONVERT(nvarchar, h.changeDate, 103) as changeDate,
				CONCAT(u.firstname, '   ', u.lastname) as changeUser,
				h.changeStatus,
				h.changeFunctionId,
				h.changeFunctionNo,
				h.changeFunctionVersion,
				fh.functionDescription,
				h.updateDate
			FROM T_CHANGE_REQUEST_HEADER h 
			INNER JOIN M_USERS u 
			ON h.changeUserId = u.userId 
			INNER JOIN M_FN_REQ_HEADER fh 
			ON h.changeFunctionId = fh.functionId 
			WHERE h.changeRequestNo = '$changeRequestNo'";
		$result = $this->db->query($sqlStr);
		return $result->first_row();
	}

	function getChangeRequestInputList($changeRequestNo){
		$sqlStr = "SELECT *
			FROM T_CHANGE_REQUEST_DETAIL
			WHERE changeRequestNo = '$changeRequestNo' 
			ORDER BY sequenceNo";
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

	function getChangeHistoryFnReqHeaderList($changeRequestNo){
		$sqlStr = "SELECT c.*, f.functionDescription 
			FROM T_CHANGE_HISTORY_REQ_HEADER c 
			INNER JOIN M_FN_REQ_HEADER f 
			ON c.functionId = f.functionId
			WHERE c.changeRequestNo = '$changeRequestNo' 
			ORDER BY c.functionNo";
		$result = $this->db->query($sqlStr);
		return $result->result_array();	
	}

	function getChangeHistoryFnReqDetailList($fnReqHistoryId){
		$sqlStr = "SELECT *
			FROM T_CHANGE_HISTORY_REQ_DETAIL
			WHERE fnReqHistoryId = $fnReqHistoryId
			ORDER BY sequenceNo";
		$result = $this->db->query($sqlStr);
		return $result->result_array();	
	}

	function getChangeHistoryDatabaseSchemaList($changeRequestNo){
		$sqlStr = "SELECT * FROM T_CHANGE_HISTORY_SCHEMA 
			WHERE changeRequestNo = '$changeRequestNo'
			AND changeType <> ''
			ORDER BY tableName, columnName";
		$result = $this->db->query($sqlStr);
		return $result->result_array();	
	}

	function getChangeHistoryTestCaseList($changeRequestNo){
		$sqlStr = "SELECT ht.*, rh.functionNo  
			FROM T_CHANGE_HISTORY_TESTCASE ht
			INNER JOIN M_RTM r
			ON ht.testCaseId = r.testCaseId
			INNER JOIN M_FN_REQ_HEADER rh
			ON r.functionId = rh.functionId
			WHERE ht.changeRequestNo = '$changeRequestNo'
			ORDER BY ht.testCaseNo";
		$result = $this->db->query($sqlStr);
		return $result->result_array();	
	}

	function getChangeHistoryRTM($changeRequestNo){
		$sqlStr = "SELECT 
				h.changeRequestNo, 
				h.oldVersionNumber,
				h.newVersionNumber,
				d.testCaseId,
				t.testCaseNo,
				d.functionId,
				r.functionNo,
				d.changeType 
			FROM T_CHANGE_HISTORY_RTM_HEADER h
			INNER JOIN T_CHANGE_HISTORY_RTM_DETAIL d
			ON h.rtmHistoryId = d.rtmHistoryId 
			INNER JOIN M_FN_REQ_HEADER r
			ON d.functionId = r.functionId
			INNER JOIN M_TESTCASE_HEADER t
			ON d.testCaseId = t.testCaseId
			WHERE h.changeRequestNo = '$changeRequestNo'
			ORDER BY r.functionNo, t.testCaseNo";
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

	function getChangeHistoryRTMDetail($changeRequestNo){
		$sqlStr = "SELECT h.changeRequestNo, h.projectId, h.oldVersionNumber, h.newVersionNumber, d.functionId, d.testCaseId, d.changeType 
			FROM T_CHANGE_HISTORY_RTM_HEADER h
			INNER JOIN T_CHANGE_HISTORY_RTM_DETAIL d
			ON h.rtmHistoryId = d.rtmHistoryId
			WHERE h.changeRequestNo = '$changeRequestNo'";
		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

	function changeProcess($changeInfo, &$changeResult, $connectionDB, $user, &$error_message, &$changeRequestNo){
	
		
	}

	private function saveChangeRequestInformation($changeInfo, $changeResult, $user, &$error_message, &$changeRequestNo = ''){
		
		$newCurrentDate = date('Y-m-d H:i:s');

		$affectedProjectId = $changeResult->projectInfo;
		$affectedRequirements = $changeResult->affectedRequirement;
		$affectedSchemaList = $changeResult->affectedSchema;
		$affectedTestCase = $changeResult->affectedTestCase;
		$affectedRTM = $changeResult->affectedRTM;

		//1. save change request header.
		$changeRequestNo = $this->mCommon->getChangeRequestNo(RUNNING_TYPE_CHANGE_REQUEST_NO);
		if(empty($changeRequestNo)){
			$error_message = str_replace("{0}", "Change Request", ER_MSG_016);
			return false;
		}

		$paramSearch = (object) array(
			'userId' => $changeInfo->userId,
			'functionId' => $changeInfo->functionId,
			'functionVersion' => $changeInfo->functionVersion,
			'staffflag' => $changeInfo->staffflag);
		$tmpChangeList = $this->searchTempFRInputChangeList($paramSearch);
		if(0 == count($tmpChangeList)){
			$error_message = str_replace("{0}", "Change Request", ER_MSG_016);
			return false;
		}

		$resultFnReq = $this->db->query("SELECT functionNo FROM M_FN_REQ_HEADER WHERE functionId = $changeInfo->functionId")->row();

		$paramInsert = (object) array(
			'changeRequestNo' => $changeRequestNo,
			'changeUser' => $changeInfo->userId,
			'changeDate' => $newCurrentDate,
			'projectId' => $changeInfo->projectId,
			'changeFunctionId' => $changeInfo->functionId,
			'changeFunctionNo' => $resultFnReq->functionNo,
			'changeFunctionVersion' => $changeInfo->functionVersion,
			'changeStatus' => CHANGE_STATUS_CLOSE,
			'user' => $user,
			'currentDate' => $newCurrentDate);
		$this->insertChangeRequestHeader($paramInsert);

		//2. save change request details.
		$i = 1;
		foreach($tmpChangeList as $value){
			$paramInsert = (object) array(
				'changeRequestNo' => $changeRequestNo,
				'sequenceNo' => $i++,
				'changeType' => $value['changeType'],
				'dataId' => $value['dataId'],
				'dataName' => $value['dataName'], 
				'schemaVersionId' => $value['schemaVersionId'],
				'dataType' => $value['newDataType'],
				'dataLength' => $value['newDataLength'],
				'scale' => $value['newScaleLength'],
				'unique' => $value['newUnique'],
				'notNull' => $value['newNotNull'],
				'default' => $value['newDefaultValue'],
				'min' => $value['newMinValue'],
				'max' => $value['newMaxValue'],
				'tableName' => $value['tableName'],
				'columnName' => $value['columnName']);
			$this->insertChangeRequestDetail($paramInsert);
		}

		//3. save change history requirement header
		foreach($affectedRequirements as $keyFunctionNo => $functionDetailValue){
			
			$existFR = $this->mFR->searchExistFunctionalRequirement($keyFunctionNo, $affectedProjectId);

			$resultNewVersion = $this->searchRelatedNewVersion_FnReq($existFR[0]['functionId'], $functionDetailValue->functionVersion);

			$paramInsert = (object) array(
				'changeRequestNo' 	 => $changeRequestNo,
				'functionNo'		 => $keyFunctionNo,
				'functionId' 		 => $existFR[0]['functionId'],
				'oldFnVersionNumber' => $functionDetailValue->functionVersion,
				'newFnVersionNumber' => $resultNewVersion->functionVersionNumber);

			$fnReqHistoryId = $this->insertChangeHistory_RequirementsHeader($paramInsert);
			if(empty($fnReqHistoryId)){
				$error_message = str_replace("{0}", "Change Request", ER_MSG_016);
				return false;
			}

			//3.1 save change history requirement detail
			$i = 1;
			foreach($functionDetailValue->functionData as $keyInputName => $value){

				$paramInsert = (object) array(
				'fnReqHistoryId' 	 => $fnReqHistoryId,
				'sequenceNo' 	 	 => $i++,
				'changeType'  	 	 => $value->changeType,
				'inputName' 	 	 => $keyInputName,
				'refTableName' 	 	 => $value->refTableName,
				'refColumnName' 	 => $value->refColumnName);

				$this->insertChangeHistory_RequirementsDetail($paramInsert);
			}
		}

		//4. save change history database schema
		$i = 1;
		foreach($affectedSchemaList as $value){
			$paramInsert = (object) array(
				'changeRequestNo' => $changeRequestNo,
				'sequenceNo' => $i++,
				'changeType' => $value->affectedAction,
				'tableName'  => $value->tableName,
				'columnName' => $value->columnName,
				'oldSchemaVersionNumber' => $value->oldSchemaVersionNo,
				'newSchemaVersionNumber' => $value->newSchemaVersionNo);

			$this->insertChangeHistory_Schema($paramInsert);
		}

		//5. save change history test case
		foreach($affectedTestCase as $keyTestCaseNo => $value){
			$paramInsert = (object) array(
				'changeRequestNo' => $changeRequestNo,
				'testCaseId' => $value->testCaseId,
				'testCaseNo' => $keyTestCaseNo,
				'oldTestCaseVersionNo' => $value->oldVerNO,
				'newTestCaseVersionNo' => $value->newVerNO,
				'changeType' => $value->changeType);
			$this->insertChangeHistory_TestCase($paramInsert);
		}

		//6. save change history RTM header and detail
		if(isset($affectedRTM) && 0 < count($affectedRTM) && !empty($affectedRTM->details)){

			$paramInsert = (object) array(
				'changeRequestNo' => $changeRequestNo,
				'projectId' => $affectedProjectId,
				'oldVersionNumber' => $affectedRTM->oldRTMVerNO,
				'newVersionNumber' => $affectedRTM->newRTMVerNO);

			$rtmHistoryId = $this->insertChangeHistory_RTMHeader($paramInsert);

			$i = 1;
			foreach($affectedRTM->details as $value){
				$paramInsert = (object) array(
					'rtmHistoryId' => $rtmHistoryId,
					'sequenceNo' => $i++,
					'functionId' => $value->functionId,
					'testCaseId' => $value->testCaseId,
					'changeType' => $value->changeType);
				$this->insertChangeHistory_RTMDetail($paramInsert);
			}
		}

		return true;
	}

	private function searchRelatedNewVersion_FnReq($functionId, $functionVersion){
		$sqlStr = "SELECT b.functionVersionNumber
			FROM M_FN_REQ_VERSION a
			INNER JOIN M_FN_REQ_VERSION b
			ON a.functionVersionId = b.previousVersionId
			and a.functionId = b.functionId
			WHERE a.functionId = $functionId 
			AND a.functionVersionNumber = $functionVersion";
		$result = $this->db->query($sqlStr);
		return $result->row();
	}

	function updateTempFRInputChangeList($functionId, $functionVersion){
		$this->db->trans_start(); //Starting Transaction
		$this->db->trans_strict(FALSE);

		$sql = "UPDATE T_TEMP_CHANGE_LIST
			SET confirmflag = '1'
			WHERE functionId = $functionId 
			AND functionVersion = $functionVersion";
//echo $functionId;
		$this->db->query($sql);
		$this->db->trans_complete();
    	$trans_status = $this->db->trans_status();
	    if($trans_status == FALSE){
	    	$this->db->trans_rollback();
	    	return FALSE;
	    }else{
	   		$this->db->trans_commit();
	   		return TRUE;
	    }
	}

	private function updateApproveInputChangeList($functionId, $functionVersion){
		$this->db->trans_start(); //Starting Transaction
		$this->db->trans_strict(FALSE);

		$sql = "UPDATE T_TEMP_CHANGE_LIST
			SET approveflag = '1'
			WHERE functionId = $functionId 
			AND functionVersion = $functionVersion
			AND activeflag = '1' ";

		$this->db->query($sql);
		$this->db->trans_complete();
    	$trans_status = $this->db->trans_status();
	    if($trans_status == FALSE){
	    	$this->db->trans_rollback();
	    	return FALSE;
	    }else{
	   		$this->db->trans_commit();
	   		return TRUE;
	    }		
	}
	function searchChangeRequestrelateSCHEMA($param){

		$sqlStr = "CREATE TEMPORARY TABLE tmp_ch_db 
		(SELECT *
		FROM T_TEMP_CHANGE_LIST
		WHERE 1=2) ";
		$result = $this->db->query($sqlStr);
		//echo $sqlStr ;

		$sqlStr = " INSERT INTO tmp_ch_db	SELECT *
		FROM T_TEMP_CHANGE_LIST
		WHERE functionId = '$param->functionId'
		AND functionversion ='$param->functionVersion'
		AND tableName is NOT NULL
		AND columnName is NOT  NULL ";
		$result = $this->db->query($sqlStr);
		//echo $sqlStr ;

		$sqlStr = " SELECT *
		FROM tmp_ch_db ";

		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}
	function searchChangeRequestNotrelateSCHEMA($param){

		$sqlStr = "CREATE TEMPORARY TABLE tmp_ch_existdb 
		(SELECT *
		FROM T_TEMP_CHANGE_LIST
		WHERE 1=2) ";
		$result = $this->db->query($sqlStr);
		//echo $sqlStr ;

		$sqlStr = " INSERT INTO tmp_ch_existdb
		SELECT *
		FROM T_TEMP_CHANGE_LIST
		WHERE functionId = '$param->functionId'
		AND functionversion ='$param->functionVersion'
		AND tableName is NULL
		AND columnName is  NULL ";
		$result = $this->db->query($sqlStr);
		//echo $sqlStr ;

		$sqlStr = " SELECT *
		FROM tmp_ch_existdb ";

		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}
	function checkChangeRequestrelateSCHEMA($param){

		$sqlStr = "CREATE TEMPORARY TABLE tmp_FRDETAIL_Affected 
		(SELECT  *,'' FR_NAME
		FROM tmp_ch_db
		WHERE 1=2)";
		$result = $this->db->query($sqlStr);
		//echo $sqlStr ;

		$sqlStr = " INSERT INTO tmp_FRDETAIL_Affected
		SELECT a.*,b.dataName FR_NAME
		FROM tmp_ch_db a, M_FN_REQ_DETAIL b
		WHERE a.confirmflag=1 
		AND a.tableName=b.refTableName 
		AND a.columnName = b.refColumnName
		AND a.functionId = b.functionId
		AND a.functionVersion = b.functionVersion
		AND b.activeflag = '1' ";
		$result = $this->db->query($sqlStr);
		//echo $sqlStr ;

		$sqlStr = " SELECT *
		FROM tmp_FRDETAIL_Affected ";

		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}	
	function checkChangeRequestrelateSCHEMAOtherFr($param){
		$sqlStr = "DROP TEMPORARY TABLE  tmp_FRDETAIL_Affected ";
		$result = $this->db->query($sqlStr);
		//echo $sqlStr ;

		$sqlStr = "CREATE TEMPORARY TABLE tmp_FRDETAIL_Affected 
		(SELECT  *,'' FR_NAME
		FROM tmp_ch_db
		WHERE 1=2)";
		$result = $this->db->query($sqlStr);
		//echo $sqlStr ;
		
		$sqlStr = " INSERT INTO tmp_FRDETAIL_Affected
		SELECT a.*,b.dataName FR_NAME
		FROM tmp_ch_db a, M_FN_REQ_DETAIL b
		WHERE a.confirmflag=1 
		AND a.tableName=b.refTableName 
		AND a.columnName = b.refColumnName
		AND a.functionId <> b.functionId
		AND a.functionVersion <> b.functionVersion
		AND b.activeflag = '1'";
		$result = $this->db->query($sqlStr);
		//echo $sqlStr ;

		$sqlStr = " SELECT *
		FROM tmp_FRDETAIL_Affected ";

		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}	
	function checkChangeRequestNotRelateSchema($param){
		
		$sqlStr = "CREATE TEMPORARY TABLE tmp_Not_Schema
		(SELECT  *,'' FR_NAME
		FROM tmp_ch_db
		WHERE 1=2)";
		$result = $this->db->query($sqlStr);

		$sqlStr = " INSERT INTO tmp_FRDETAIL_Affected
		SELECT a.*,b.dataName FR_NAME
		FROM tmp_ch_existdb a, M_FN_REQ_DETAIL b
		WHERE a.confirmflag=1 
		AND a.dataId = b.dataId";
		$result = $this->db->query($sqlStr);
		//echo $sqlStr ;

		$sqlStr = " INSERT INTO tmp_Not_Schema
		SELECT a.*,b.dataName FR_NAME
		FROM tmp_ch_existdb a, M_FN_REQ_DETAIL b
		WHERE a.confirmflag=1 
		AND a.dataId = b.dataId";
		$result = $this->db->query($sqlStr);

		$sqlStr = " 
		SELECT a.*,'' FR_NAME
		FROM tmp_ch_existdb a
		WHERE a.confirmflag = '1' 
		AND a.changeType = 'add' 
		UNION
		SELECT *
		FROM tmp_Not_Schema";

		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}		
	function checkSchemaAffted($param){

		$sqlStr = " SELECT b.*
		FROM tmp_ch_db a,M_DATABASE_SCHEMA_INFO b
		WHERE a.tableName = b.tableName
		AND a.columnName = b.columnName ";
		$result = $this->db->query($sqlStr);
		//echo $sqlStr ;

		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}		
	function chaeckTestCaseAffected($param){
		$sqlStr = "INSERT INTO tmp_FR_Affected
		SELECT DISTINCT functionId,functionVersion
		FROM tmp_FRDETAIL_Affected";
		$result = $this->db->query($sqlStr);

		$sqlStr = "CREATE TEMPORARY TABLE tmp_RTM
		(SELECT  testCaseId,testCaseversion,functionId,functionVersion
		FROM M_RTM_VERSION
		WHERE 1=2)";
		$result = $this->db->query($sqlStr);

		$sqlStr = "INSERT INTO tmp_RTM
		SELECT a.*    
		FROM M_RTM_VERSION a,tmp_FR_Affected b
		WHERE a.functionId = b.functionId
		AND functionVersion = b.functionVersion";
		$result = $this->db->query($sqlStr);
		//echo $sqlStr ;

		//หา TESTCASE ที่สัมพันธ์กับ dataname โดยดูจาก dataId ที่ทำการ change ของ testId นั้น
		$sqlStr = "SELECT a.testCaseId,a.testCaseNo,a.testcaseVersion,a.typeData,
		a.refdataName TC_NAME,a.testData,b.dataName CH_NAME,b.changeType,b.newdataType,
		newDataLength,b.newScaleLength,b.newUnique,newNotNull,
		newDefaultValue,newMinValue,newMaxValue
		FROM m_testcase_detail a,T_TEMP_CHANGE_LIST b,tmp_RTM c
		WHERE a.projectId = '2'
		AND a.activeflag = '1'
		AND a.refdataId = b.dataId
		AND b.confirmflag = '1'
		AND a.testCaseId = c.testCaseId
		AND a.testCaseversion = c.testCaseversion
		AND b.functionId = c.functionId
		AND b.functionVersion = c.functionVersion
		UNION ALL
		/*การหา TESTCASE ที่เป็นการ add //ยังไม่มีใน testCase*/
		SELECT '' testCaseId,'' testCaseNo,'' testcaseVersion,b.typeData,'' TC_NAME,'' testData
		,b.dataName CH_NAME,b.changeType,b.newdataType,newDataLength,b.newScaleLength,b.newUnique,newNotNull,
		newDefaultValue,newMinValue,newMaxValue
		FROM T_TEMP_CHANGE_LIST b
		WHERE b.functionId = '25'
		AND b.functionVersion = '1'
		AND b.confirmflag = '1'
		AND b.changeType = 'add'";

		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}	

}
?>