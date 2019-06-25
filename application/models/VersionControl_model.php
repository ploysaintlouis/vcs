<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* VersionControl Model
*/
class VersionControl_model extends CI_Model{
	
	function __construct(){
		parent::__construct();

		$this->load->model('FunctionalRequirement_model', 'mFR');
		$this->load->model('DatabaseSchema_model', 'mDB');
		$this->load->model('Miscellaneous_model', 'mMisc');
		$this->load->model('TestCase_model', 'mTestCase');
		$this->load->model('RTM_model', 'mRTM');
		$this->load->model('Common_model', 'mCommon');
	}

	function updateRequirementsHeader($param){

		$currentDateTime = date('Y-m-d H:i:s');

		$sqlStr = "UPDATE M_FN_REQ_HEADER
			SET activeflag = '0',
				updateDate 	 = '$currentDateTime',
				updateUser 	 = '$param->user'
			WHERE functionId = '$param->functionId'
			AND functionversion = '$param->functionVersion'
			AND projectid = '$param->projectId'
            AND activeflag = '1' ";
			//print_r($sqlStr);
            $result = $this->db->query($sqlStr);
            return $this->db->affected_rows();
    
    }

	function InsertNewRequirementsHeader($param){
        
		$currentDateTime = date('Y-m-d H:i:s');
        $FRMAXFuncNo = $this->searchFRMAXFuncNo($param);
        $New_FRNO = substr($FRMAXFuncNo[0]['Max_FRNO'],0,7).(substr($FRMAXFuncNo[0]['Max_FRNO'],7,7)+1);
        $FRMAXFuncId = $this->searchFRMAXFuncId();
        foreach($FRMAXFuncId as $value){
            $NewFRID = (object) array(
                'functionId' => $value['Max_FRId']
            );
        }
        $NewFRID->functionId = $NewFRID->functionId+1;

        $fnDesc = $this->SearchRequirementsDesc($param);
        foreach($fnDesc as $value){
            $fnDesc = (object) array(
                'functionDescription' => $value['functionDescription']
            );
        }     
        //print_r($fnDesc->functionDescription)  ;

        $sqlStr = "INSERT INTO M_FN_REQ_HEADER (functionId,functionNo, functionDescription, projectId, 
        createDate, createUser, updateDate, updateUser,functionversion,activeflag) 
        VALUES ('$NewFRID->functionId','{$New_FRNO}', '{$fnDesc->functionDescription}', '{$param->projectId}', 
        '$currentDateTime', '{$param->user}', '$currentDateTime', '{$param->user}','1','1')";

        $result = $this->db->query($sqlStr);
        if($result){
            $query = $this->db->query("SELECT MAX(Id) AS last_id FROM M_FN_REQ_HEADER");
            $resultId = $query->result();
            return $resultId[0]->last_id;
        }
        return NULL;
    }

    function InsertRequirementsHeader($param){
        
		$currentDateTime = date('Y-m-d H:i:s');
        $New_functionVersion = $param->functionVersion+1;
        $fnDesc = $this->SearchRequirementsDesc($param);
        foreach($fnDesc as $value){
            $fnDesc = (object) array(
                'functionDescription' => $value['functionDescription']
            );
        }  

         $sqlStr = "INSERT INTO M_FN_REQ_HEADER (functionId,functionNo, functionDescription, projectId, 
         createDate, createUser, updateDate, updateUser,
         functionversion,activeflag) 
         VALUES ('{$param->functionId}','{$param->functionNo}', '{$fnDesc->functionDescription}', '{$param->projectId}', 
         '$currentDateTime', '{$param->user}', '$currentDateTime', '{$param->user}',
         '{$New_functionVersion}','1')";
        
        $result = $this->db->query($sqlStr);
        if($result){
            $query = $this->db->query("SELECT MAX(Id) AS last_id FROM M_FN_REQ_HEADER");
            $resultId = $query->result();
             return $resultId[0]->last_id;
        }
           return $resultId[0]->last_id;
        }

    function searchFRMAXFuncNo($param) {

        $strsql = " SELECT max(functionNo) AS Max_FRNO 
                    FROM M_FN_REQ_HEADER 
                    WHERE projectId = '$param->projectId' ";
       //echo $strsql;
       $result = $this->db->query($strsql);
       //echo $sqlStr ;
       return $result->result_array();
    } 

    function searchFRMAXFuncId() {

        $strsql = " SELECT max(functionId) AS Max_FRId
                    FROM M_FN_REQ_HEADER ";
       //echo $strsql;
       $result = $this->db->query($strsql);
       //echo $sqlStr ;
       return $result->result_array();
    } 

    function searchFRMAXFuncVer($functionNo) {
   
       $strsql = " SELECT max(functionVersion) AS Max_FRVer
                   FROM M_FN_REQ_HEADER 
                   WHERE functionNo = '$functionNo' ";
   
   $result = $this->db->query($strsql);
   //echo $sqlStr ;
   return $result->result_array();
} 

	function updateChange_RequirementsDetail($param) {
		$currentDateTime = date('Y-m-d H:i:s');
	
			$strsql = "UPDATE M_FN_REQ_DETAIL 
				SET effectiveEndDate = '$currentDateTime',
				updateDate = '$currentDateTime',
				updateUser = '$param->user',
				activeFlag = '0'
				WHERE functionVersion = '$param->functionVersion' 
				AND functionId = '$param->functionId'
				AND activeflag = '1' 
				AND projectid = '$param->projectId' 
		";
		$result = $this->db->query($strsql);
		return $this->db->affected_rows();
    } 

    function InsertChange_RequirementsDetail($param,$New_param) {
        $currentDateTime = date('Y-m-d H:i:s');

        $strsql = "INSERT INTO M_FN_REQ_DETAIL 
        (projectid, functionId, functionNo, functionVersion, typeData, dataName, 
        schemaVersionId, refTableName, refColumnName, dataType, dataLength, decimalPoint, constraintPrimaryKey, constraintUnique, 
        constraintDefault, constraintNull, constraintMinValue, constraintMaxValue, effectiveStartDate, effectiveEndDate, activeFlag,
        createDate, createUser, updateDate, updateUser)
        SELECT '$param->projectId','$New_param->functionId','$New_param->functionNo','$New_param->functionversion',typeData,dataName,
        schemaVersionId,refTableName,refColumnName,dataType,dataLength,decimalPoint,constraintPrimaryKey,
        constraintUnique,constraintDefault,constraintNull,constraintMinValue,constraintMaxValue,'$currentDateTime',
        NULL,'1','$currentDateTime','$param->user','$currentDateTime','$param->user'
        FROM M_FN_REQ_DETAIL
                WHERE functionVersion = '$param->functionVersion' 
                AND functionId = '$param->functionId'
                AND projectid = '$param->projectId' 
        ";
        //print_r($strsql);
        $result = $this->db->query($strsql);
        if($result){
            $query = $this->db->query("SELECT MAX(functionId) AS last_id FROM M_FN_REQ_DETAIL");
            $resultId = $query->result();
            return $resultId[0]->last_id;
        }
		return NULL;
    }     

    function SearchRequirementsDetail($param,$New_FunctionId) {
    
        $strsql = "SELECT projectId,functionNo,functionVersion,functionId,functionDescription
                FROM M_FN_REQ_HEADER
                WHERE activeflag = '1' 
                AND projectid = '$param->projectId' 
                AND Id = '$New_FunctionId'
        ";
       $result = $this->db->query($strsql);
       //echo $strsql ;
       return $result->result_array();
    } 

    function SearchRequirementsDesc($param) {
    
        $strsql = "SELECT functionNo,functionVersion,functionId,functionDescription
                FROM M_FN_REQ_HEADER
                WHERE projectid = '$param->projectId' 
                AND functionNo = '$param->functionNo'
                AND functionVersion = '$param->functionVersion'
        ";
       $result = $this->db->query($strsql);
       //echo $sqlStr ;
       return $result->result_array();
    } 

    function SearchTC($param) {
    
        $strsql = "SELECT testCaseId,testCaseNo,testcaseVersion,testCaseDescription
                FROM M_TESTCASE_HEADER
                WHERE  projectid = '$param->projectId' 
                AND testcaseNo = '$param->testcaseNo'
                AND testcaseVersion = '$param->testcaseVersion'
        ";
       $result = $this->db->query($strsql);
       //echo $sqlStr ;
       return $result->result_array();
    } 

    function updateChangeRequestDetail($param,$paramUpdate,$New_param) {

        //print_r($New_FunctionId);
        //print_r($paramUpdate);

        $currentDateTime = date('Y-m-d H:i:s');
        $fieldName = '';
        if(!empty($paramUpdate->newDataType)){
            $fieldName = " dataType = '$paramUpdate->newDataType' ,";
        }
        if(!empty($paramUpdate->newDataLength)){
            $fieldName .= " dataLength = '$paramUpdate->newDataLength' ,";
        }
        if(!empty($paramUpdate->newScaleLength)){
            $fieldName .= " decimalPoint = '$paramUpdate->newScaleLength' ,";
        }
        if(!empty($paramUpdate->newDefaultValue)){
            $fieldName .= " constrraintDefault = '$paramUpdate->newDefaultValue' ,";
        }
        if(!empty($paramUpdate->newMinValue)){
            $fieldName .= " ConstraintMinValue = '$paramUpdate->newMinValue' ,";
        }	
        if(!empty($paramUpdate->newMaxValue)){
            $fieldName .= " ConstraintMaxValue = '$paramUpdate->newMaxValue' ,";
        }					
        $condition = $fieldName;

        $strsql = "UPDATE M_FN_REQ_DETAIL
                set $condition 
                constraintUnique = '$paramUpdate->newUnique',
                constraintNull = '$paramUpdate->newNotNull'
                WHERE functionVersion = '$New_param->functionversion' 
                AND functionId = '$New_param->functionId'
                and activeflag = '1' 
                AND dataName = '$paramUpdate->dataName'
                and projectid = '$param->projectId' ";
        $result = $this->db->query($strsql);
        //print_r($strsql);
		return $this->db->affected_rows();
     } 
    
    function deleteChangeRequestDetail($param,$paramUpdate,$New_param) {
    $dataName = trim($paramUpdate->dataName);
    $functionversion = trim($New_param->functionversion);
    $functionId = trim($New_param->functionId);

        $strsql = "DELETE FROM M_FN_REQ_DETAIL
                WHERE functionId = '$functionId' 
                AND functionVersion = '$functionversion' 
                AND activeflag = '1' 
                AND dataName = '$dataName'
                AND projectid = '$param->projectId' ";
		$result = $this->db->query($strsql);
		return $this->db->affected_rows();
    }   				

    function addChangeRequestDetail($param,$paramUpdate,$New_param) {
        $currentDateTime = date('Y-m-d H:i:s');
		$paramUpdate->tableName = !empty($paramUpdate->tableName)? "'".$paramUpdate->tableName."'" : "NULL";
		$paramUpdate->columnName = !empty($paramUpdate->columnName)? "'".$paramUpdate->columnName."'" : "NULL";
		$paramUpdate->newMinValue = !empty($paramUpdate->newMinValue)? "'".$paramUpdate->newMinValue."'" : "NULL";
		$paramUpdate->newMaxValue = !empty($paramUpdate->newMaxValue)? "'".$paramUpdate->newMaxValue."'" : "NULL";
		$paramUpdate->newDefaultValue = !empty($paramUpdate->newDefaultValue)? "'".$paramUpdate->newDefaultValue."'" : "NULL";

        $strsql = "INSERT INTO M_FN_REQ_DETAIL 
        (projectid, functionId, functionNo, functionVersion, typeData, dataName, 
        schemaVersionId, refTableName, refColumnName, dataType, dataLength, decimalPoint, constraintPrimaryKey, constraintUnique, 
        constraintDefault, constraintNull, constraintMinValue, constraintMaxValue, effectiveStartDate, effectiveEndDate, activeFlag,
        createDate, createUser, updateDate, updateUser)
        VALUES('$param->projectId','$New_param->functionId','$New_param->functionNo','$New_param->functionversion',
        '$paramUpdate->typeData','$paramUpdate->dataName',NULL,$paramUpdate->tableName,
        $paramUpdate->columnName,'$paramUpdate->newDataType','$paramUpdate->newDataLength',
        '$paramUpdate->newScaleLength','N','$paramUpdate->newUnique',$paramUpdate->newDefaultValue,
        '$paramUpdate->newNotNull',$paramUpdate->newMinValue,$paramUpdate->newMaxValue,
        '$currentDateTime',NULL,'1','$currentDateTime','$param->user','$currentDateTime','$param->user')
        ";

		$result = $this->db->query($strsql);
		return $this->db->affected_rows();
    }  

    function insertlogAffFr($fr_list_aff) {

        $strsql = "INSERT INTO AFF_FR 
        (projectId,ChangeRequestNo,FR_Id,FR_No,FR_Version,changeType)
        VALUES('$fr_list_aff->projectId','$fr_list_aff->changeRequestNo','$fr_list_aff->functionId','$fr_list_aff->functionNo',
        '$fr_list_aff->functionVersion','$fr_list_aff->changeType')
        ";

		$result = $this->db->query($strsql);
		return $this->db->affected_rows();
    } 

    function insertlogAffSchema($schema_list_aff) {

        $strsql = "INSERT INTO AFF_SCHEMA 
        (ChangeRequestNo,schemaVersionId,tableName,columnName,Version,changeType)
        VALUES('$schema_list_aff->changeRequestNo','$schema_list_aff->schemaVersionId',
        '$schema_list_aff->tableName','$schema_list_aff->columnName','$schema_list_aff->version',
        '$schema_list_aff->changeType')
        ";

		$result = $this->db->query($strsql);
		return $this->db->affected_rows();
    }    

    function insertlogAffTestcase($test_list_aff) {

        $strsql = "INSERT INTO AFF_TESTCASE
        (ChangeRequestNo,testcaseId,testcaseNo,testcaseVersion,changeType)
        VALUES('$test_list_aff->changeRequestNo','$test_list_aff->testCaseId','$test_list_aff->testcaseNo',
        '$test_list_aff->testcaseVersion','$test_list_aff->changeType')
        ";

		$result = $this->db->query($strsql);
		return $this->db->affected_rows();
    }  

    function insertlogAffRTM($rtm_list_aff) {

        $strsql = "INSERT INTO AFF_RTM
        (ChangeRequestNo,functionId,functionNo,functionVersion,testcaseId,testcaseNo,testcaseVersion)
        VALUES('$rtm_list_aff->changeRequestNo','$rtm_list_aff->functionId','$rtm_list_aff->functionNo',
        '$rtm_list_aff->functionVersion','$rtm_list_aff->testcaseId','$rtm_list_aff->testcaseNo','$rtm_list_aff->testcaseVersion')
        ";

		$result = $this->db->query($strsql);
		return $this->db->affected_rows();
    } 

    function MapFRVersion($param,$New_param) {
        $currentDateTime = date('Y-m-d H:i:s');

        $strsql = "INSERT INTO MAP_FR_VERSION 
        (projectid,Old_FR_Id, Old_FR_No, Old_FR_Version, New_FR_Id,New_FR_No, New_FR_Version)
        VALUES('$param->projectId','$param->functionId','$param->functionNo','$param->functionVersion',
        '$New_param->functionId','$New_param->functionNo','$New_param->functionversion')
        ";

		$result = $this->db->query($strsql);
		return $this->db->affected_rows();
    }     
  
    function MapTCVersion($param,$New_TC_HEADER) {
        $currentDateTime = date('Y-m-d H:i:s');

        $strsql = "INSERT INTO MAP_TC_VERSION 
        (projectid, Old_TC_Id, Old_TC_No, Old_TC_Version,New_TC_Id, New_TC_No, New_TC_Version)
        VALUES('$param->projectId','$param->testCaseId','$param->testcaseNo','$param->testcaseVersion',
        '$New_TC_HEADER->testCaseId','$New_TC_HEADER->testCaseNo','$New_TC_HEADER->testcaseVersion')
        ";

		$result = $this->db->query($strsql);
		return $this->db->affected_rows();
    }  

	function updateDatabaseSchemaVersion($schema_list_aff){
        $currentDateTime = date('Y-m-d H:i:s');

		$sqlStr = "UPDATE M_DATABASE_SCHEMA_VERSION
			SET effectiveEndDate = '$currentDateTime', 
				activeFlag = '0', 
				updateDate = '$currentDateTime', 
				updateUser = '$schema_list_aff->user' 
            WHERE projectId = '$schema_list_aff->projectId'
            AND schemaVersionId = '$schema_list_aff->schemaVersionId'
            AND schemaVersionNumber = '$schema_list_aff->version'
            AND activeflag = '1' ";
//print_r($sqlStr);
        $result = $this->db->query($sqlStr);
		return $this->db->affected_rows();
    } 
    
	function updateDatabaseSchemaInfo($schema_list_aff){

		$sqlStr = "UPDATE M_DATABASE_SCHEMA_INFO
			SET activeflag = '0'
            WHERE projectId = '$schema_list_aff->projectId'
            AND schemaVersionId = '$schema_list_aff->schemaVersionId'
            AND Version = '$schema_list_aff->version'
            AND activeflag = '1' ";
//print_r($sqlStr);
        $result = $this->db->query($sqlStr);
		return $this->db->affected_rows();
    } 

    function insertDatabaseSchemaVersion($param, $paramInsert){
		$currentDateTime = date('Y-m-d H:i:s');
        $Max_DBVersion = $this->searchMaxSchemaVersion($param, $paramInsert);
        $New_DBVer = $Max_DBVersion[0]['Max_DBVersion']+1;
        $Old_DBVer =$Max_DBVersion[0]['Max_DBVersion'];

		$sqlStr = "INSERT INTO M_DATABASE_SCHEMA_VERSION 
        (projectId, tableName, columnName,schemaVersionId, schemaVersionNumber, effectiveStartDate, effectiveEndDate, activeFlag, createDate, 
        createUser, updateDate, updateUser) 
        SELECT projectId, tableName, columnName,schemaVersionId, '$New_DBVer', '$currentDateTime',
         NULL, '1', '$currentDateTime', '$param->user', '$currentDateTime', '$param->user'
         FROM M_DATABASE_SCHEMA_VERSION
        WHERE projectId = '$param->projectId'
        AND tableName = '$paramInsert->tableName'
        AND schemaVersionNumber = '$Old_DBVer'
        ";

        $result = $this->db->query($sqlStr);

		if($result){
			$query = $this->db->query("SELECT MAX(schemaVersionId) as last_id FROM M_DATABASE_SCHEMA_VERSION");
			$resultId = $query->result();
			return $resultId[0]->last_id;
		}
		return NULL;
    }   
  
    function insertDatabaseSchemaInfo($param, $paramInsert){
        $Max_DBVersion = $this->searchMaxSchemaInfo($param,$paramInsert);
        $New_DBVer = $Max_DBVersion[0]['Max_DBVersion']+1;
        $Old_DBVer = $Max_DBVersion[0]['Max_DBVersion'];

		$sqlStr = "INSERT INTO M_DATABASE_SCHEMA_INFO 
        (projectId, tableName, columnName, schemaVersionId,Version, dataType, dataLength, decimalPoint, 
        constraintPrimaryKey, constraintUnique, constraintDefault,constraintNull,
        constraintMinValue,constraintMaxValue,activeflag) 
        SELECT projectId, tableName, columnName,schemaVersionId, '$New_DBVer',dataType, dataLength, decimalPoint, 
        constraintPrimaryKey, constraintUnique, constraintDefault,constraintNull,
        constraintMinValue,constraintMaxValue,'1'
         FROM M_DATABASE_SCHEMA_INFO
        WHERE projectId = '$param->projectId'
        AND tableName = '$paramInsert->tableName'
        AND Version = '$Old_DBVer'
        ";
//print_r($sqlStr);

		$result = $this->db->query($sqlStr);
		if($result){
			$query = $this->db->query("SELECT MAX(Version) as last_id FROM M_DATABASE_SCHEMA_INFO");
			$resultId = $query->result();
			return $resultId[0]->last_id;
		}
		return NULL;
    }   

    function searchMaxSchemaVersion($param,$paramInsert) {
   
        $strsql = " SELECT MAX(schemaVersionNumber) AS Max_DBVersion
                      FROM M_DATABASE_SCHEMA_VERSION 
                     WHERE projectId = '$param->projectId'
                       AND tableName = '$paramInsert->tableName' ";
    
    $result = $this->db->query($strsql);
    //echo $sqlStr ;
    return $result->result_array();
    }

    function searchMaxSchemaInfo($param,$paramInsert) {
   
        $strsql = " SELECT MAX(Version) AS Max_DBVersion
                      FROM M_DATABASE_SCHEMA_INFO 
                     WHERE projectId = '$param->projectId'
                       AND tableName = '$paramInsert->tableName' ";
    
    $result = $this->db->query($strsql);
    //echo $sqlStr ;
    return $result->result_array();
    }

    function SearchDatabaseSchemaDetail($param,$paramInsert) {
        $tableName = trim($paramInsert->tableName);

        $strsql = "SELECT DISTINCT tableName,schemaVersionId,schemaVersionNumber
                FROM M_DATABASE_SCHEMA_VERSION
                WHERE activeflag = '1' 
                AND projectid = '$param->projectId' 
                AND tableName = '$tableName'
        ";
       $result = $this->db->query($strsql);
       //echo $sqlStr ;
       return $result->result_array();
    } 

    function SearchDatabaseSchemaOldDetail($schema_list_aff,$paramInsert) {
    
        $strsql = "SELECT DISTINCT tableName,schemaVersionId,Version
                FROM AFF_SCHEMA
                WHERE tableName = '$schema_list_aff->tableName'
                AND ChangeRequestNo = '$schema_list_aff->changeRequestNo'
                AND Version <> '0'
        ";
       $result = $this->db->query($strsql);
       //echo $sqlStr ;
       return $result->result_array();
    } 

    function MapDBVersion($Old_param_DB,$New_param_DB) {
        $currentDateTime = date('Y-m-d H:i:s');

        $strsql = "INSERT INTO MAP_SCHEMA_VERSION 
        (projectid,Old_schemaVersionId,Old_TableName,Old_Schema_Version,
        New_schemaVersionId,New_TableName,New_Schema_Version)
        VALUES('$Old_param_DB->projectId','$Old_param_DB->schemaVersionId','$Old_param_DB->tableName','$Old_param_DB->schemaVersionNumber',
        '$New_param_DB->schemaVersionId','$New_param_DB->tableName','$New_param_DB->schemaVersionNumber')
        ";

        
		$result = $this->db->query($strsql);
        return $this->db->affected_rows();

    }    

	function updateDatabaseSchemaInfoDetail($New_param_DB,$paramUpdate_DB){
        $currentDateTime = date('Y-m-d H:i:s');

        $fieldName = '';
        if($paramUpdate_DB->newDataType != null){
            $fieldName = " dataType = '$paramUpdate_DB->newDataType' ,";
        }
        if($paramUpdate_DB->newDataLength != null){
            $fieldName .= " dataLength = '$paramUpdate_DB->newDataLength' ,";
        }
        if($paramUpdate_DB->newScaleLength  != null){
            $fieldName .= " decimalPoint = '$paramUpdate_DB->newScaleLength' ,";
        }
        if($paramUpdate_DB->newDefaultValue != null){
            $fieldName .= " constrraintDefault = '$paramUpdate_DB->newDefaultValue' ,";
        }
        if($paramUpdate_DB->newMinValue != null){
            $fieldName .= " ConstraintMinValue = '$paramUpdate_DB->newMinValue' ,";
        }	
        if($paramUpdate_DB->newMaxValue != null){
            $fieldName .= " ConstraintMaxValue = '$paramUpdate_DB->newMaxValue' ,";
        }					
        $condition = $fieldName;
        $tableName = trim($paramUpdate_DB->tableName);
        $columnName = trim($paramUpdate_DB->columnName);
       
        $strsql = "UPDATE M_DATABASE_SCHEMA_INFO
                set $condition 
                constraintUnique = '$paramUpdate_DB->newUnique',
                constraintNull = '$paramUpdate_DB->newNotNull'
                WHERE tableName = '$tableName' 
                AND columnName = '$columnName' 
                AND activeflag = '1'
                AND schemaVersionId = '$New_param_DB->schemaVersionId'
                AND Version = '$New_param_DB->schemaVersionNumber'
             ";
        $result = $this->db->query($strsql);
        //print_r($strsql);
		return $this->db->affected_rows();
    } 

    function deleteDatabaseSchemaInfoDetail($New_param_DB,$paramUpdate_DB){

        $strsql = "DELETE FROM M_DATABASE_SCHEMA_INFO
               WHERE tableName = '$paramUpdate_DB->tableName' 
                AND columnName = '$paramUpdate_DB->columnName' 
                AND activeflag = '1'
                AND schemaVersionId = '$New_param_DB->schemaVersionId'
                AND Version = '$New_param_DB->schemaVersionNumber' ";

		$result = $this->db->query($strsql);
		return $this->db->affected_rows();
    }   

    function deleteCDatabaseSchemaVersionDetail($New_param_DB,$paramUpdate_DB){

        $strsql = "DELETE FROM M_DATABASE_SCHEMA_VERSION
               WHERE tableName = '$paramUpdate_DB->tableName' 
                AND columnName = '$paramUpdate_DB->columnName' 
                AND activeflag = '1'
                AND schemaVersionId = '$New_param_DB->schemaVersionId'
                AND schemaVersionNumber = '$New_param_DB->schemaVersionNumber' ";

		$result = $this->db->query($strsql);
		return $this->db->affected_rows();
    }

    function searchTablerelateSCHEMA($param){

		$sqlStr = " SELECT distinct tableName,schemaVersionId
		FROM T_TEMP_CHANGE_LIST
		WHERE functionId = '$param->functionId'
		AND functionversion ='$param->functionVersion'
		AND tableName is NOT NULL
		AND columnName is NOT  NULL ";
		$result = $this->db->query($sqlStr);
		//echo $sqlStr ;
		return $result->result_array();
    }
    function SearchFrHeader($param,$fr_list_aff){
		$sqlStr = " SELECT functionId
		FROM M_FN_REQ_HEADER
		WHERE functionNo = '$fr_list_aff->functionNo'
		AND functionversion ='$fr_list_aff->functionVersion'
        AND projectId = '$param->projectId'
        ";
		$result = $this->db->query($sqlStr);
		//echo $sqlStr ;
		return $result->result_array();
    }

    function searchChangeRequestList($param){

		$sqlStr = " SELECT *
		FROM T_TEMP_CHANGE_LIST
		WHERE functionId = '$param->functionId'
		AND functionVersion ='$param->functionVersion'
		 ";
        
		$result = $this->db->query($sqlStr);
		//echo $sqlStr ;
		return $result->result_array();
    }

	function updateTestcaseHeader($param,$test_list_aff){
        $currentDateTime = date('Y-m-d H:i:s');

		$sqlStr = "UPDATE M_TESTCASE_HEADER
            SET activeFlag = '0', 
				updateDate = '$currentDateTime', 
				updateUser = '$param->user' 
            WHERE projectId = '$param->projectId'
            AND testCaseNo = '$test_list_aff->testcaseNo'
            AND testcaseVersion = '$test_list_aff->testcaseVersion' ";
//print_r($sqlStr);
        $result = $this->db->query($sqlStr);
		return $this->db->affected_rows();
    } 
     
    function updateTestcaseDetail($param,$test_list_aff){
        $currentDateTime = date('Y-m-d H:i:s');

		$sqlStr = "UPDATE M_TESTCASE_DETAIL
			SET effectiveEndDate = '$currentDateTime', 
				activeFlag = '0', 
				updateDate = '$currentDateTime', 
				updateUser = '$param->user' 
            WHERE projectId = '$param->projectId'
            AND testCaseNo = '$test_list_aff->testcaseNo'
            AND testcaseVersion = '$test_list_aff->testcaseVersion' ";
//print_r($sqlStr);
        $result = $this->db->query($sqlStr);
		return $this->db->affected_rows();
    } 

    function SearchTestcaseHeader($param,$test_list_aff) {
    
        $strsql = "SELECT testCaseId,testCaseNo,testcaseVersion,testCaseDescription,expectedResult
                FROM M_TESTCASE_HEADER
                WHERE  projectid = '$param->projectId' 
                AND testcaseNo = '$test_list_aff->testcaseNo'
                AND testcaseVersion = '$test_list_aff->testcaseVersion'
        ";
       $result = $this->db->query($strsql);
       //echo $sqlStr ;
       return $result->result_array();
    } 

	function InsertNewTestCaseHeader($param,$data_list){
        
		$currentDateTime = date('Y-m-d H:i:s');
        $MAXTCNo = $this->searchTCMaxNo($param);
        $New_TCNO = substr($MAXTCNo[0]['Max_TCNO'],0,7).(substr($MAXTCNo[0]['Max_TCNO'],7,7)+1);
        $MAXTCId = $this->searchTCMaxId($param);
        foreach($MAXTCId as $value){
            $NewTCID = (object) array(
                'testCaseId' => $value['Max_TCId']
            );
        }
        $NewTCID->testCaseId = $NewTCID->testCaseId+1;

        $sqlStr = "INSERT INTO M_TESTCASE_HEADER (projectId,testcaseId,testCaseNo,testcaseVersion,testCaseDescription,
        expectedResult,createDate, createUser, updateDate, updateUser,activeflag) 
        VALUES ('{$param->projectId}','{$NewTCID->testCaseId}','{$New_TCNO}','1','{$data_list->testCaseDescription}',
        '{$data_list->expectedResult}','$currentDateTime', '{$param->user}', '$currentDateTime', '{$param->user}','1')";

        $result = $this->db->query($sqlStr);
        if($result){
            $query = $this->db->query("SELECT MAX(Id) AS last_id FROM M_TESTCASE_HEADER");
            $resultId = $query->result();
            return $resultId[0]->last_id;
        }
        return NULL;
    }    

	function InsertTestCaseHeader($param,$data_list){
        
		$currentDateTime = date('Y-m-d H:i:s');
        $New_TCVer = $data_list->testcaseVersion+1;

        $sqlStr = "INSERT INTO M_TESTCASE_HEADER (projectId,testcaseId,testCaseNo,testcaseVersion,
        testCaseDescription,expectedResult,createDate, createUser, updateDate, updateUser,activeflag) 
        VALUES ('{$param->projectId}','{$data_list->testCaseId}','{$data_list->testCaseNo}',
        '$New_TCVer','{$data_list->testCaseDescription}','{$data_list->expectedResult}',
        '$currentDateTime', '{$param->user}', '$currentDateTime','{$param->user}','1')";
//print_r($sqlStr);
        $result = $this->db->query($sqlStr);
        if($result){
            $query = $this->db->query("SELECT MAX(Id) AS last_id FROM M_TESTCASE_HEADER");
            $resultId = $query->result();
            return $resultId[0]->last_id;
        }
        return NULL;
    }    

    function searchTCMaxNo($param) {
   
        $strsql = " SELECT MAX(testCaseNo) AS Max_TCNO
                      FROM M_TESTCASE_HEADER 
                     WHERE projectId = '$param->projectId'
                     ";
    
    $result = $this->db->query($strsql);
    //echo $sqlStr ;
    return $result->result_array();
    }    

    function searchTCMaxId($param) {
   
        $strsql = " SELECT MAX(testcaseId) AS Max_TCId
                      FROM M_TESTCASE_HEADER 
                     WHERE projectId = '$param->projectId'
                     ";
    
    $result = $this->db->query($strsql);
    //echo $sqlStr ;
    return $result->result_array();
    }  

    function SearchNewTestCaseHeader($param,$New_TCId){
   
        $strsql = " SELECT testCaseId,testCaseNo,testcaseVersion
                      FROM M_TESTCASE_HEADER 
                     WHERE projectId = '$param->projectId'
                       AND Id = '$New_TCId'
                     ";
    
    $result = $this->db->query($strsql);
    //echo $sqlStr ;
    return $result->result_array();
    }  

    function InsertTestcaseDetail($param,$New_TC_HEADER,$data_list) {
        $currentDateTime = date('Y-m-d H:i:s');

        $strsql = "INSERT INTO M_TESTCASE_DETAIL
        (projectid,testCaseId,testCaseNo,testcaseVersion,typeData, 
        refdataId,refdataName, testData,effectiveStartDate, effectiveEndDate, activeFlag,
        createDate, createUser, updateDate, updateUser)
        SELECT '$param->projectId','$New_TC_HEADER->testCaseId','$New_TC_HEADER->testCaseNo',
        '$New_TC_HEADER->testcaseVersion',typeData,refdataId,refdataName,testData,'$currentDateTime',
        NULL,'1','$currentDateTime','$param->user','$currentDateTime','$param->user'
        FROM M_TESTCASE_DETAIL
                WHERE testcaseVersion = '$data_list->testcaseVersion' 
                AND testCaseId = '$data_list->testCaseId'
                AND projectid = '$param->projectId' 
        ";
        //print_r($strsql);
        
        $result = $this->db->query($strsql);
        if($result){
            $query = $this->db->query("SELECT MAX(sequenceNo) AS last_id FROM M_TESTCASE_DETAIL");
            $resultId = $query->result();
            return $resultId[0]->last_id;
        }
        return NULL;
    }     


    function updateChangeTestCaseDetail($param,$param_update_tc,$New_TC_HEADER,$new_testdata) {

        $strsql = "UPDATE M_TESTCASE_DETAIL
                set testData = '$new_testdata'
                WHERE testcaseVersion = '$New_TC_HEADER->testcaseVersion' 
                AND testCaseId = '$New_TC_HEADER->testCaseId'
                and activeflag = '1' 
                AND refdataName = '$param_update_tc->dataName'
                and projectid = '$param->projectId' ";
        $result = $this->db->query($strsql);
        //print_r($strsql);
		return $this->db->affected_rows();
     } 
     function deleteChangeTestCaseDetail($param,$param_update_tc,$New_TC_HEADER) {

        $strsql = "DELETE FROM M_TESTCASE_DETAIL
                WHERE testCaseId = '$New_TC_HEADER->testCaseId' 
                AND testcaseVersion = '$New_TC_HEADER->testcaseVersion' 
                AND activeflag = '1' 
                AND refdataName = '$param_update_tc->dataName'
                AND projectid = '$param->projectId' ";
        $result = $this->db->query($strsql);
        //print_r($strsql);
		return $this->db->affected_rows();
    }    
    
    function addChangeTestCaseDetail($param,$param_update_tc,$New_TC_HEADER,$new_testdata) {
        $currentDateTime = date('Y-m-d H:i:s');
        //print_r($NewFR);
        $strsql = "INSERT INTO M_TESTCASE_DETAIL
        (projectid,testCaseId,testCaseNo,testcaseVersion,typeData, 
        refdataId,refdataName, testData,effectiveStartDate, effectiveEndDate, activeFlag,
        createDate, createUser, updateDate, updateUser)
        VALUES('$param->projectId','$New_TC_HEADER->testCaseId','$New_TC_HEADER->testCaseNo',
        '$New_TC_HEADER->testcaseVersion','$param_update_tc->typeData','$param_update_tc->dataId',
        '$param_update_tc->dataName','$new_testdata','$currentDateTime',
        NULL,'1','$currentDateTime','$param->user','$currentDateTime','$param->user')
        ";

		$result = $this->db->query($strsql);
		return $this->db->affected_rows();
    }  

    function checkRTMAffected($param,$paramothFR,$y){

		if (0 < count($paramothFR)){
			$FROth_No =  $paramothFR->FROth_NO;
			$FROth_Id =  $paramothFR->FROth_Id;
			$FROth_Version =  $paramothFR->FROth_Version;
		}else{
			$FROth_No =  "";
			$FROth_Id =  "";
			$FROth_Version =  "";
		}

		//echo $FROth_Id;
		if((null != $FROth_Id) && ($y == '1')) {
			//echo "1";
			$sqlStr = "SELECT c.functionId,c.functionNo,c.functionVersion,a.testCaseId,b.testcaseVersion,b.testCaseNo,'' tctype
			FROM M_RTM_VERSION a,M_TESTCASE_HEADER b,M_FN_REQ_HEADER c
			WHERE a.functionId = '$param->functionId'
			AND a.functionversion ='$param->functionVersion' 
            AND b.projectId ='$param->projectId' 
			AND b.projectId = c.projectId
			AND a.testCaseId = b.testCaseId
			AND a.testCaseversion = b.testCaseversion
            AND a.functionId = c.functionId
            AND a.functionVersion = c.functionVersion
			UNION
			SELECT c.functionId,c.functionNo,c.functionVersion,a.testCaseId,b.testcaseVersion,b.testCaseNo,'Oth' tctype
			FROM M_RTM_VERSION a,M_TESTCASE_HEADER b,M_FN_REQ_HEADER c
			WHERE a.functionId = '$FROth_Id'
			AND a.functionversion ='$FROth_Version' 
            AND b.projectId ='$param->projectId' 
			AND b.projectId = c.projectId
			AND a.testCaseId = b.testCaseId
			AND a.testCaseversion = b.testCaseversion
            AND a.functionId = c.functionId
            AND a.functionVersion = c.functionVersion		";
		}else if($FROth_Id == ""){
			$sqlStr = "SELECT c.functionId,c.functionNo,c.functionVersion,a.testCaseId,a.testcaseVersion,b.testCaseNo,'' tctype
			FROM M_RTM_VERSION a,M_TESTCASE_HEADER b,M_FN_REQ_HEADER c
			WHERE a.functionId = '$param->functionId'
			AND a.functionversion ='$param->functionVersion'
            AND b.projectId ='$param->projectId' 
			AND b.projectId = c.projectId
			AND a.testCaseId = b.testCaseId
			AND a.testCaseversion = b.testCaseversion
            AND a.functionId = c.functionId
            AND a.functionVersion = c.functionVersion ";
		}else if ((null != $FROth_Id) && ($y != '1')){
            $sqlStr = " SELECT c.functionId,c.functionNo,c.functionVersion,a.testCaseId,b.testcaseVersion,b.testCaseNo,'Oth' tctype
			FROM M_RTM_VERSION a,M_TESTCASE_HEADER b,M_FN_REQ_HEADER c
			WHERE a.functionId = '$FROth_Id'
			AND a.functionversion ='$FROth_Version' 
            AND b.projectId ='$param->projectId' 
			AND b.projectId = c.projectId
			AND a.testCaseId = b.testCaseId
			AND a.testCaseversion = b.testCaseversion
            AND a.functionId = c.functionId
            AND a.functionVersion = c.functionVersion		";
        }
        //echo $sqlStr;
		$result = $this->db->query($sqlStr);
		return $result->result_array();

    }	

    function searchNewFR($rtm_relate) {
   
        $strsql = " SELECT New_FR_Id,New_FR_No,New_FR_Version
                      FROM MAP_FR_VERSION 
                     WHERE projectId = '$rtm_relate->projectId'
                       AND Old_FR_Id = '$rtm_relate->functionId'
                       AND Old_FR_Version = '$rtm_relate->functionVersion' ";
    
    $result = $this->db->query($strsql);
    //echo $sqlStr ;
    return $result->result_array();
    }

    function searchNewTC($rtm_relate) {
   
        $strsql = " SELECT New_TC_Id,New_TC_No,New_TC_Version
                      FROM MAP_TC_VERSION 
                     WHERE projectId = '$rtm_relate->projectId'
                       AND Old_TC_Id = '$rtm_relate->testcaseId'
                       AND Old_TC_Version = '$rtm_relate->testcaseVersion' ";
    
    $result = $this->db->query($strsql);
    //echo $sqlStr ;
    return $result->result_array();
    }

    function searchAffRTM($param) {
   
        $strsql = " SELECT functionId,functionNo,functionVersion,testcaseId,testcaseNo,testcaseVersion
                      FROM AFF_RTM 
                     WHERE ChangeRequestNo = '$param->changeRequestNo'
                     ";
    
    $result = $this->db->query($strsql);
    //echo $sqlStr ;
    return $result->result_array();
    }

    function insertRTMVersion($relate_new_fr,$relate_new_tc) {
        $this->db->trans_start(); //Starting Transaction
		$this->db->trans_strict(FALSE);
        
        $currentDateTime = date('Y-m-d H:i:s');

        $strsql = "INSERT INTO M_RTM_VERSION 
        (projectid,testCaseId,testCaseversion,functionId,functionVersion,
        effectiveStartDate, effectiveEndDate,createDate,createUser,
        updateDate,updateUser,activeFlag)
        VALUES('$relate_new_fr->projectId','$relate_new_tc->testcaseId','$relate_new_tc->testcaseVersion',
        '$relate_new_fr->functionId','$relate_new_fr->functionVersion','$currentDateTime',NULL,
        '$currentDateTime','$relate_new_fr->user','$currentDateTime','$relate_new_fr->user','1')
        ";
        
        $this->db->query($strsql);
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

    function updateRTMVersion($param){

		$currentDateTime = date('Y-m-d H:i:s');

		$sqlStr = "UPDATE M_RTM_VERSION
			SET activeflag = '0',
				updateDate 	 = '$currentDateTime',
				updateUser 	 = '$param->user'
			WHERE functionId = '$param->functionId'
			AND functionversion = '$param->functionVersion'
			AND projectid = '$param->projectId'
            AND testCaseId = '$param->testcaseId'
            AND testCaseversion = '$param->testcaseVersion'
            AND activeflag = '1' ";
			//print_r($sqlStr);
            $result = $this->db->query($sqlStr);
            return $this->db->affected_rows();
    
    }

    function updateMAPRTM($param){

		$currentDateTime = date('Y-m-d H:i:s');

		$sqlStr = "UPDATE MAP_RTM
			SET activeflag = '0',
				changeRequestNo 	 = '$param->changeRequestNo'
			WHERE  activeflag = '1'
            AND changeRequestNo IS NULL ";
			//print_r($sqlStr);
            $result = $this->db->query($sqlStr);
            return $this->db->affected_rows();
    
    }

    function updateDBMAP($param){

		$currentDateTime = date('Y-m-d H:i:s');

		$sqlStr = "UPDATE MAP_SCHEMA
			SET changeRequestNo 	 = '$param->changeRequestNo'
			WHERE  changeRequestNo IS NULL ";
			//print_r($sqlStr);
            $result = $this->db->query($sqlStr);
            return $this->db->affected_rows();
    
    }

    function deleteTempChange($param){

        $strsql = "DELETE FROM T_TEMP_CHANGE_LIST
               WHERE functionId = '$param->functionId' 
                AND functionVersion = '$param->functionVersion' ";

		$result = $this->db->query($strsql);
		return $this->db->affected_rows();
    } 

    function insertSchemaVersion($param){
		$currentDateTime = date('Y-m-d H:i:s');
        $Max_DBVersion = $this->searchSchemaVersion($param);
        $schemaVersionId = $Max_DBVersion[0]['schemaVersionId']+1;
        $schemaVersionNumber =$Max_DBVersion[0]['schemaVersionNumber'];

		$sqlStr = "INSERT INTO M_DATABASE_SCHEMA_VERSION 
        (projectId, tableName, columnName,schemaVersionId, schemaVersionNumber, effectiveStartDate, effectiveEndDate, activeFlag, createDate, 
        createUser, updateDate, updateUser) 
        SELECT projectId, tableName, columnName,schemaVersionId, '$schemaVersionNumber', '$currentDateTime',
         NULL, '1', '$currentDateTime', '$param->user', '$currentDateTime', '$param->user'
         FROM M_DATABASE_SCHEMA_VERSION
        WHERE projectId = '$param->projectId'
        AND tableName = '$paramInsert->tableName'
        AND schemaVersionNumber = '$Old_DBVer'
        ";

		$result = $this->db->query($sqlStr);
		if($result){
			$query = $this->db->query("SELECT MAX(schemaVersionId) as last_id FROM M_DATABASE_SCHEMA_VERSION");
			$resultId = $query->result();
			return $resultId[0]->last_id;
		}
		return NULL;
    }   

    function addDatabaseSchemaInfoDetail($New_param_DB,$paramUpdate_DB){

		$sqlStr = "INSERT INTO M_DATABASE_SCHEMA_INFO 
        (projectId, tableName, columnName, schemaVersionId,Version, dataType, dataLength, decimalPoint, 
        constraintPrimaryKey, constraintUnique, constraintDefault,constraintNull,
        constraintMinValue,constraintMaxValue,activeflag) 
        VALUES('$New_param_DB->projectId','$paramUpdate_DB->tableName','$paramUpdate_DB->columnName',
        '$New_param_DB->schemaVersionId','$New_param_DB->schemaVersionNumber','$paramUpdate_DB->newDataType',
        '$paramUpdate_DB->newDataLength',
        '$paramUpdate_DB->newScaleLength',
        'N',
        '$paramUpdate_DB->newUnique',
        '$paramUpdate_DB->newDefaultValue',
        '$paramUpdate_DB->newNotNull',
        '$paramUpdate_DB->newMinValue',
        '$paramUpdate_DB->newMaxValue',
        '1'
        )
        ";
//print_r($sqlStr);

		$result = $this->db->query($sqlStr);
		if($result){
			$query = $this->db->query("SELECT MAX(Id) as last_id FROM M_DATABASE_SCHEMA_INFO");
			$resultId = $query->result();
			return $resultId[0]->last_id;
		}
		return NULL;
    }   

    function addDatabaseSchemaVersionDetail($New_param_DB,$paramUpdate_DB){
		$currentDateTime = date('Y-m-d H:i:s');

		$sqlStr = "INSERT INTO M_DATABASE_SCHEMA_VERSION 
        (projectId, tableName, columnName,schemaVersionId, schemaVersionNumber, effectiveStartDate, effectiveEndDate, activeFlag, createDate, 
        createUser, updateDate, updateUser) 
        VALUES('$New_param_DB->projectId','$New_param_DB->tableName','$paramUpdate_DB->columnName',
        '$New_param_DB->schemaVersionId', '$New_param_DB->schemaVersionNumber', '$currentDateTime',
         NULL, '1', '$currentDateTime', '$New_param_DB->user', '$currentDateTime', '$New_param_DB->user'
        )
        ";

		$result = $this->db->query($sqlStr);
		if($result){
			$query = $this->db->query("SELECT MAX(schemaVersionId) as last_id FROM M_DATABASE_SCHEMA_VERSION");
			$resultId = $query->result();
			return $resultId[0]->last_id;
		}
		return NULL;
    }   
    
     function updateSchemaDetail($New_param_DB,$New_param) {
                
        $sql = "UPDATE M_FN_REQ_DETAIL a,
         (SELECT Id,columnName,tableName FROM M_DATABASE_SCHEMA_INFO
         WHERE  schemaVersionId = '$New_param_DB->schemaVersionId'
                 AND Version = '$New_param_DB->schemaVersionNumber'
                 AND activeflag = '1') AS DB
         SET a.schemaVersionId  = DB.Id
         WHERE  a.activeFlag = '1'
         AND a.refColumnName = DB.columnName
         AND a.refTableName = DB.tableName";

        $result = $this->db->query($sql);
        //print_r($strsql);
        return $this->db->affected_rows();
     }


     function insertRTMMAP($param){

		$sqlStr = "INSERT INTO MAP_RTM 
        (changeRequestNo,projectId,functionId,functionVersion,testcaseId,testcaseVersion,activeflag) 
        SELECT NULL,projectId,functionId,functionVersion,testcaseId,testcaseVersion,'1'
         FROM M_RTM_VERSION
        WHERE projectId = '$param->projectId'
        AND activeflag = '1'
        ";

		$result = $this->db->query($sqlStr);
		if($result){
			$query = $this->db->query("SELECT MAX(Id) as last_id FROM MAP_RTM");
			$resultId = $query->result();
			return $resultId[0]->last_id;
		}
		return NULL;
    } 

    function insertDBMAP($param){

		$sqlStr = "INSERT INTO MAP_SCHEMA
        (schemaVersionId,schemaVersion,tableName,changeRequestNo,projectId)
        SELECT DISTINCT schemaVersionId,Version,tableName,NULL,'$param->projectId'
         FROM M_DATABASE_SCHEMA_INFO
        WHERE projectId = '$param->projectId'
        AND activeflag = '1'
        ";

		$result = $this->db->query($sqlStr);
		if($result){
			$query = $this->db->query("SELECT MAX(Id) as last_id FROM MAP_RTM");
			$resultId = $query->result();
			return $resultId[0]->last_id;
		}
		return NULL;
    } 

}
?>