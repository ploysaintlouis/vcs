<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FunctionalRequirement_model extends CI_Model {
	function __construct(){
		parent::__construct();
	}

	function searchFunctionalRequirementHeaderInfo($param){
		if(isset($param->projectId) && !empty($param->projectId)){
			$where[] = "FRH.projectId = ".$param->projectId;
		}
		
		if(isset($param->status) && ("2" != $param->status)){
			$where[] = "FRH.activeFlag = '".$param->status."'";
		}

		if(isset($param->functionId) && !empty($param->functionId)){
			$where[] = "FRH.functionId = ".$param->functionId;
		}

		if(isset($param->functionVersion) && !empty($param->functionVersion)){
			$where[] = "FRH.functionVersion = ".$param->functionVersion;
		}
		
		$where_clause = implode(' AND ', $where);
		$queryStr = "SELECT 
				FRH.functionId, 
				FRH.functionNo, 
				FRH.functionDescription as fnDesc, 
				FRH.functionVersion, 
				FRH.activeFlag as functionStatus,
				CONVERT(FRH.createDate , CHAR(120)) as effectiveStartDate
			FROM M_FN_REQ_HEADER FRH 
			WHERE $where_clause 
			ORDER BY FRH.functionNo, FRH.functionVersion";
			//echo $queryStr;
		$result = $this->db->query($queryStr);
		return $result->result_array();
	}

	function searchCountAllFunctionalRequirements(){
		$result = $this->db->query("
			SELECT count(*) as counts FROM M_FN_REQ_HEADER");
		return $result->row();
	}

	function searchExistFunctionalRequirement($fnId, $projectId){

		if(null != $projectId && !empty($projectId)){
			$where[] = "projectId = '$projectId'";
		}
		if(null != $fnId && !empty($fnId)){
			$where[] = "functionNo = '$fnId'";
		}
		$where_clause = implode(' AND ', $where);
		
		$queryStr = "SELECT * 
			FROM M_FN_REQ_HEADER 
			WHERE $where_clause";
		//echo $queryStr;
		$result = $this->db->query($queryStr);
		return $result->result_array();
	}

	function searchFRInputInformation($projectId, $dataName, $activeFlag){

		$queryStr = "SELECT projectid,dataId,dataName,refTableName,refColumnName,
			createDate,createUser,updateDate,activeFlag 
			FROM M_FN_REQ_DETAIL i
			WHERE i.projectId = $projectId
			AND i.dataName = '$dataName'
			AND i.functionId =
			AND ($activeFlag is null or i.activeFlag = $activeFlag)
			ORDER BY i.createDate desc";
		$result = $this->db->query($queryStr);
		return $result->row();
	}

	function searchFRInputInfoByInputId($dataId){

		$queryStr = "SELECT projectid,dataId,dataName,refTableName,refColumnName,
			createDate,createUser,updateDate,activeFlag
			FROM M_FN_REQ_DETAIL i 
			WHERE i.dataId = $dataId";
		$result = $this->db->query($queryStr);
		return $result->row();
	}

	function searchFRInputDetailByCriteria($param){
		if(null != $param->dataId && !empty($param->dataId)){
			$where[] = "i.dataId = $param->dataId";
		}

		$where_clause = implode(' AND ', $where);

		$sqlStr = "SELECT i.typeData,i.dataId,i.dataName,i.refTableName, i.refColumnName,
			i.dataType,i.dataLength, i.decimalPoint, i.constraintUnique, 
		i.constraintNull, i.constraintDefault, i.constraintMinValue,
		i.constraintMaxValue
	   FROM M_FN_REQ_DETAIL i
	   where $where_clause";
	  // echo $sqlStr;
		$result = $this->db->query($sqlStr);
		return $result->row_array();
	}

	function searchExistFRInputInFunctionalRequirement($param){
		if(isset($param->functionId) && !empty($param->functionId)){
			$where[] = "h.functionId = $param->functionId";
		}
		if(isset($param->dataName) && !empty($param->dataName)){
			$where[] = "d.dataName = '$param->dataName'";
		}

		if(isset($param->schemaVersionId) && !empty($param->schemaVersionId)){
			$where[] = "d.schemaVersionId = $param->schemaVersionId";
		}

		$where_clause = implode(' AND ', $where);

		$queryStr = "SELECT h.functionId, d.dataId, d.dataName, d.schemaVersionId
			FROM M_FN_REQ_HEADER h
			INNER JOIN M_FN_REQ_DETAIL d
			ON h.functionId = d.functionId
			AND d.activeFlag = '1'
			WHERE $where_clause";
//echo $queryStr;
		$result = $this->db->query($queryStr);
		return $result->result_array();
	}

	function searchExistFRDetailbyCriteria($param){

		$sqlStr = "SELECT functionId,dataId,schemaVersionId,effectiveStartDate,effectiveEndDate,
			activeFlag,createDate,createUser,updateDate,updateUser
			FROM M_FN_REQ_DETAIL
			WHERE functionId = $param->functionId
			AND dataId = $param->dataId 
			AND effectiveStartDate = '$param->effectiveStartDate'";

		$result = $this->db->query($sqlStr);
		return $result->result_array();
	}

	function searchExistFRInputsByTableAndColumnName($tableName, $columnName, $projectId, $activeFlag){
		$activeFlag = (!empty($activeFlag)? "'".$activeFlag."'": "NULL");

		$queryStr = " SELECT projectid,dataId,dataName,refTableName,refColumnName,createDate,createUser,
				updateDate,updateUser,activeFlag
				FROM M_FN_REQ_DETAIL fi
			WHERE fi.refTableName = '$tableName'
			AND fi.refColumnName = '$columnName'
			AND fi.projectId = $projectId
			AND ($activeFlag is null or fi.activeFlag = $activeFlag)";
		$result = $this->db->query($queryStr);
		return $result->row();
	}

	function searchReferenceDatabaseSchemaInfo($param){

		if(isset($param->projectId) && !empty($param->projectId)){
			$where[] = "di.projectId = $param->projectId";
		}

		if(isset($param->referTableName) && !empty($param->referTableName)){
			$where[] = "di.tableName = '$param->referTableName'";
		}

		if(isset($param->referColumnName) && !empty($param->referColumnName)){
			$where[] = "di.columnName = '$param->referColumnName'";
		}

		$where_clause = implode(' AND ', $where);

		$queryStr = "SELECT di.*
			FROM M_DATABASE_SCHEMA_VERSION dv
			INNER JOIN M_DATABASE_SCHEMA_INFO di
			ON dv.schemaVersionId = di.schemaVersionId
			WHERE dv.activeFlag = '1'
			AND $where_clause";
		$result = $this->db->query($queryStr);
		return $result->row();
	}

	function searchFunctionalRequirementDetail($param){
		if(isset($param->projectId) && !empty($param->projectId)){
			$where[] = "h.projectId = $param->projectId";
		}

		if(isset($param->functionId) && !empty($param->functionId)){
			$where[] = "h.functionId = $param->functionId";
		}

		if(isset($param->dataId) && !empty($param->dataId)){
			$where[] = "v.dataId = $param->dataId";
		}

		if(isset($param->schemaVersionId) && !empty($param->schemaVersionId)){
			$where[] = "db.schemaVersionId = $param->schemaVersionId";
		}
		$where_clause = implode(' AND ', $where);

			$queryStr = "SELECT 	h.projectId,
				h.functionId,
				h.functionNo,
				h.functionDescription,
				v.functionVersion,
				db.schemaVersionId,
				v.typeData,
				v.dataId,
				v.dataName,
				v.refTableName,
				v.refColumnName,
				v.dataType,
				v.dataLength,
				v.decimalPoint,
				v.constraintUnique,
				v.constraintNull,
				v.constraintDefault,
				v.constraintMinValue,
				v.constraintMaxValue
		FROM M_FN_REQ_HEADER h
		INNER JOIN M_FN_REQ_DETAIL v
		ON h.functionId = v.functionId
		AND h.projectid = v.projectid
		AND v.activeFlag = '1'
		INNER JOIN M_DATABASE_SCHEMA_INFO db
		ON v.refTableName = db.tableName
		AND v.refColumnName = db.columnName
		WHERE $where_clause
		UNION
		SELECT 	h.projectId,
				h.functionId,
				h.functionNo,
				h.functionDescription,
				v.functionVersion,
				NULL schemaVersionId,
				v.typeData,
				v.dataId,v.dataName,
				v.refTableName,
				v.refColumnName,
				v.dataType,
				v.dataLength,
				v.decimalPoint,
				v.constraintUnique,
				v.constraintNull,
				v.constraintDefault,
				v.constraintMinValue,
				v.constraintMaxValue
		FROM M_FN_REQ_HEADER h
		INNER JOIN M_FN_REQ_DETAIL v
		ON h.functionId = v.functionId
		AND h.projectid = v.projectid
		AND v.activeFlag = '1'
		AND v.refTableName =''
		AND v.refColumnName = ''
		LEFT JOIN M_DATABASE_SCHEMA_INFO db
		ON v.refTableName = db.tableName
		AND v.refColumnName = db.columnName		
		WHERE $where_clause
		ORDER BY dataId";

			//var_dump($queryStr);
		$result = $this->db->query($queryStr);
		return $result->result_array();
	}

	function searchLatestFunctionalRequirementMaxId(){
			$query = $this->db->query("SELECT IDENT_CURRENT('M_FN_REQ_DETAIL') as last_id");
			$resultId = $query->result();
			return $resultId[0]->last_id;
	}

	function searchLatestFunctionalRequirementVersion($functionId, $functionVersion){
		$sqlStr = "SELECT *
			FROM M_FN_REQ_DETAIL 
			WHERE functionId = $functionId
			AND functionVersion = $functionVersion
			AND activeFlag = '1'" ;

		$result = $this->db->query($sqlStr);
		return $result->row();
	}

	function searchFunctionalRequirementVersionByCriteria($param){
		if(null != $param->functionId && !empty($param->functionId)){
			$where[] = "functionId = $param->functionId";
		}

		if(isset($param->functionVersionNumber) && !empty($param->functionVersionNumber)){
			$where[] = "functionVersion = $param->functionVersion";
		}

		$where_condition = implode(" AND ", $where);

		$sqlStr = "SELECT * 
			FROM M_FN_REQ_DETAIL
			WHERE $where_condition";
		$result = $this->db->query($sqlStr);
		return $result->row();
	}

	function insertFRHeader($param){
		$currentDateTime = date('Y-m-d H:i:s');
	/*	$sqlStr = "INSERT INTO M_FN_REQ_HEADER (functionNo, functionDescription, projectId, createDate, createUser, updateDate, updateUser) VALUES ('{$param->functionNo}', '{$param->functionDescription}', {$param->projectId}, '$currentDateTime', '{$param->user}', '$currentDateTime', '{$param->user}')";*/
	if($param->functionVersionNo == null){
		$sqlStr = "INSERT INTO M_FN_REQ_HEADER (functionNo, functionDescription, projectId, 
		createDate, createUser, updateDate, updateUser,functionversion,activeflag) 
		VALUES ('{$param->functionNo}', '{$param->functionDescription}', {$param->projectId}, 
		'$currentDateTime', '{$param->user}', '$currentDateTime', '{$param->user}','1','1')";
	}else{
$sqlStr = "INSERT INTO M_FN_REQ_HEADER (functionNo, functionDescription, projectId, 
createDate, createUser, updateDate, updateUser,functionversion,activeflag) 
VALUES ('{$param->functionNo}', '{$param->functionDescription}', {$param->projectId}, 
'$currentDateTime', '{$param->user}', '$currentDateTime', '{$param->user}','{$param->functionVersionNo}','{$param->activeFlag}')";
	}
		$result = $this->db->query($sqlStr);
		if($result){
			$query = $this->db->query("SELECT IDENT_CURRENT('M_FN_REQ_HEADER') as last_id");
			$resultId = $query->result();
			return $resultId[0]->last_id;
		}
		return NULL;
	}
/*
	function insertFRVersion($param){
		$currentDateTime = date('Y-m-d H:i:s');
		$previousVersionId = !empty($param->previousVersionId)? $param->previousVersionId : "NULL";
		$sqlStr ="INSERT INTO M_FN_REQ_VERSION (functionId, functionVersionNumber, effectiveStartDate, effectiveEndDate, activeFlag, previousVersionId, createDate,
		 createUser, updateDate, updateUser) VALUES ($param->functionId, $param->functionVersionNo, '$param->effectiveStartDate', NULL, '$param->activeFlag', $previousVersionId, 
		 '$currentDateTime', '$param->user', '$currentDateTime', '$param->user')";

		$result = $this->db->query($sqlStr);
		if($result){
			$query = $this->db->query("SELECT IDENT_CURRENT('M_FN_REQ_VERSION') as last_id");
			$resultId = $query->result();
			return $resultId[0]->last_id;
		}
		return NULL;
	}
*/
	function insertFRInput($functionId,$param){
		$currentDateTime = date('Y-m-d H:i:s');

		if ($param->referTableName !=null) {
				$sqlStr = " INSERT INTO M_FN_REQ_DETAIL (projectId,typeData,dataName,refTableName,refColumnName,
		 createDate,createUser,updateDate,updateUser,functionId,functionNo,schemaVersionId,dataType,
		 effectiveStartDate,effectiveEndDate,activeFlag,functionVersion,
		 dataLength,decimalPoint,constraintPrimaryKey,constraintUnique,constraintDefault,constraintNull,constraintMinValue,constraintMaxValue)
		 VALUES ('{$param->projectId}','{$param->typeData}', '{$param->dataName}', '{$param->referTableName}',
		 '{$param->referColumnName}', '$currentDateTime', '{$param->user}', '$currentDateTime', 
		 '{$param->user}','$functionId','$param->functionNo','$param->schemaVersionId','$param->dataType',
		 '$currentDateTime',NULL,'1','1',
		 '{$param->dataLength}','{$param->decimalPoint}','{$param->constraintPrimaryKey}','{$param->constraintUnique}','{$param->constraintDefault}','{$param->constraintNull}','{$param->constraintMinValue}','{$param->constraintMaxValue}')";
		//var_dump($sqlStr);
		}else{
			$sqlStr = " INSERT INTO M_FN_REQ_DETAIL (projectId,typeData,dataName,refTableName,refColumnName,
			createDate,createUser,updateDate,updateUser,functionId,functionNo,schemaVersionId,dataType,
			effectiveStartDate,effectiveEndDate,activeFlag,functionVersion,
			dataLength,decimalPoint,constraintPrimaryKey,constraintUnique,constraintDefault,constraintNull,constraintMinValue,constraintMaxValue)
			VALUES ('{$param->projectId}','{$param->typeData}', '{$param->dataName}', '{$param->referTableName}',
			'{$param->referColumnName}', '$currentDateTime', '{$param->user}', '$currentDateTime', 
			'{$param->user}','$functionId','$param->functionNo',NULL,'$param->dataType',
			'$currentDateTime',NULL,'1','1',
			'{$param->dataLength}','{$param->decimalPoint}',NULL,NULL,NULL,NULL,NULL,NULL)";   
		}
		$result = $this->db->query($sqlStr);
		if($result){
			$query = $this->db->query("SELECT IDENT_CURRENT('M_FN_REQ_DETAIL') as last_id");
			$resultId = $query->result();
			return $resultId[0]->last_id;
		}
		return NULL;
	}

	function insertFRDetail($functionId, $param){
		$currentDateTime = date('Y-m-d H:i:s');
		$sqlStr = "INSERT INTO M_FN_REQ_DETAIL_INPUT (functionId, inputId, schemaVersionId, effectiveStartDate, effectiveEndDate, activeFlag, createDate, createUser, updateDate, updateUser) VALUES ($functionId, $param->inputId, $param->schemaVersionId, '$param->effectiveStartDate', NULL, '$param->activeFlag', '$currentDateTime', '$param->user', '$currentDateTime', '$param->user')";
		$result = $this->db->query($sqlStr);
		return $result;
	}
/*
	function updateFunctionalRequirementsVersion($param){
		$effectiveEndDate = !empty($param->effectiveEndDate)? "'".$param->effectiveEndDate."'": "NULL";

		$sqlstr = "UPDATE M_FN_REQ_VERSION 
			SET effectiveEndDate = $effectiveEndDate, 
				activeFlag = '$param->activeFlag', 
				updateDate = '$param->currentDate', 
				updateUser = '$param->user' 
			WHERE functionId = $param->functionId 
			AND updateDate = '$param->oldUpdateDate'";

		$result = $this->db->query($sqlstr);
		return $this->db->affected_rows();
	}*/
	function updateFunctionalRequirementsNo($param){
		$effectiveEndDate = !empty($param->effectiveEndDate)? "'".$param->effectiveEndDate."'": "NULL";

		$sqlstr = "UPDATE M_FN_REQ_HEADER 
			SET activeFlag = '$param->activeFlag', 
				updateDate = '$param->currentDate', 
				updateUser = '$param->user' 
			WHERE functionId = '$param->functionId'";
//echo $sqlstr;
		$result = $this->db->query($sqlstr);
		return $this->db->affected_rows();
	}
	function updateStatusFRInput($param){
		$sqlStr = "UPDATE M_FN_REQ_INPUT
			SET activeFlag = '$param->activeFlag',
				updateDate = '$param->updateDate',
				updateUser = '$param->updateUser'
			WHERE projectId = $param->projectId
			AND inputId = $param->inputId";
		$result = $this->db->query($sqlStr);
		return $this->db->affected_rows();
	}

	function updateFunctionalRequirementsDetail($param){

		$effectiveEndDate = !empty($param->effectiveEndDate)? "'".$param->effectiveEndDate."'" : "NULL";

		if(isset($param->functionId) && !empty($param->functionId)){
			$where[] = "functionId = $param->functionId";
		}

		if(isset($param->inputId) && !empty($param->inputId)){
			$where[] = "inputId = $param->inputId";
		}

		if(isset($param->oldSchemaVersionId) && !empty($param->oldSchemaVersionId)){
			$where[] = "schemaVersionId = $param->oldSchemaVersionId";
		}

		if(isset($param->endDateCondition) && !empty($param->endDateCondition)){
			$where[] = "effectiveEndDate = '$param->endDateCondition'";
		}
		$where_condition = implode(" AND ", $where);

		//$sqlStr = "UPDATE M_FN_REQ_DETAIL_INPUT
		$sqlStr = "UPDATE M_FN_REQ_DETAIL
			SET effectiveEndDate = $effectiveEndDate,
				activeFlag = '$param->activeFlag',
				updateDate = '$param->currentDate',
				updateUser = '$param->user'
			WHERE $where_condition";
	//	echo $sqlStr;
		$result = $this->db->query($sqlStr);
		return $this->db->affected_rows();
	}
/*
	function deleteFunctionalRequirementHeader($param){
		$sqlStr = "DELETE FROM M_FN_REQ_VERSION
			WHERE functionId = $param->functionId
			AND functionVersionId = $param->functionVersionId";

		$result = $this->db->query($sqlStr);
		return $this->db->affected_rows();
	}
*/
	function deleteFunctionalRequirementDetail($param){
		$sqlStr = "DELETE FROM M_FN_REQ_DETAIL_INPUT
			WHERE functionId = $param->functionId
			AND inputId = $param->inputId
			AND effectiveStartDate = '$param->effectiveStartDate'";

		$result = $this->db->query($sqlStr);
		return $this->db->affected_rows();
	}

	function deleteFunctionalRequirementInput($param){
		$sqlStr = "DELETE FROM M_FN_REQ_INPUT
			WHERE inputId = $param->inputId
			AND activeFlag = '1'";

		$result = $this->db->query($sqlStr);
		return $this->db->affected_rows();
	}

	function schemaVersionIdFunctionalRequirementInput($param){
		$sqlStr = "	select schemaVersionId 
					from M_FN_REQ_DETAIL
					where refColumnName = $param->columnName
					and refTableName = $param->tableName
					and activeflag = '1' ";

		$result = $this->db->query($sqlStr);
		return $this->db->affected_rows();
	}

	function uploadFR($param){
		$this->db->trans_begin(); //Starting Transaction

		//insert Functional Requirement Header
		$functionId = $this->insertFRHeader($param[0]);
		if(NULL != $functionId){
			$effectiveStartDate = date('Y-m-d H:i:s');
			
			$headerData = (object) array(
				'functionId' => $functionId, 
				'functionVersionNo' => $param[0]->functionVersionNo, 
				'effectiveStartDate' => $effectiveStartDate,
				'effectiveEndDate' => "NULL",
				'activeFlag' => $param[0]->activeFlag,
				'user' => $param[0]->user);

			//insert Functional Requirement Version
			$resultInsertVersion = $this->insertFRVersion($headerData);

			//insert Functional Requirement Detail
			foreach ($param as $detail) {
				$dataId = '';
				//Check Exist Input
				if(empty($detail->dataId)){
					//Insert New Input
					if ($detail->typeData == 'input'){
						$detail->typeData = '1';
					}
					if ($detail->typeData == 'output'){
						$detail->typeData = '2';
					}
					$detail->functionVersionNo = $param[0]->functionVersionNo;

					$resultSchemaInfo = $this->searchReferenceDatabaseSchemaInfo($detail);

				if ( empty($detail->dataType) && empty($detail->dataLength) && empty($detail->decimalPoint)) {
					$detail->dataType = $resultSchemaInfo->dataType;
					$detail->dataLength = $resultSchemaInfo->dataLength;
					$detail->decimalPoint = $resultSchemaInfo->decimalPoint;
					$detail->constraintPrimaryKey = $resultSchemaInfo->constraintPrimaryKey;
					$detail->constraintUnique = $resultSchemaInfo->constraintUnique;
					$detail->constraintDefault = $resultSchemaInfo->constraintDefault;
					$detail->constraintNull = $resultSchemaInfo->constraintNull;
					$detail->constraintMinValue = $resultSchemaInfo->constraintMinValue;
					$detail->constraintMaxValue = $resultSchemaInfo->constraintMaxValue;
					$detail->schemaVersionId = $resultSchemaInfo->schemaVersionId;
				}else{
					if ($detail->decimalPoint == null){
						$detail->decimalPoint = 'NULL';
					}
					$detail->constraintPrimaryKey = 'NULL';
					$detail->constraintUnique = 'NULL';
					$detail->constraintDefault = 'NULL';
					$detail->constraintNull = 'NULL';
					$detail->constraintMinValue = 'NULL';
					$detail->constraintMaxValue = 'NULL';
					$detail->schemaVersionId = '';				
				}
					$detail->effectiveStartDate = $effectiveStartDate;
					$detail->effectiveEndDate = 'NULL';

					$inputId = $this->insertFRInput($functionId,$detail);
					$detail->dataId = $dataId;
				}
/*
				$resultSchemaInfo = $this->searchReferenceDatabaseSchemaInfo($detail);

				$detail->schemaVersionId = $resultSchemaInfo->schemaVersionId;
				$detail->effectiveStartDate = $effectiveStartDate;
				$detail->effectiveEndDate = "NULL";
*/
				//$resultInsertDetail = $this->insertFRDetail($functionId, $detail);
			}// end foreach
		}// end if

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