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
        $FRMAXFuncNo = $this->searchFRMAXFuncNo();
        $New_FRNO = substr($FRMAXFuncNo[0]['Max_FRNO'],0,7).(substr($FRMAXFuncNo[0]['Max_FRNO'],7,7)+1);
        
        $sqlStr = "INSERT INTO M_FN_REQ_HEADER (functionNo, functionDescription, projectId, 
        createDate, createUser, updateDate, updateUser,functionversion,activeflag) 
        VALUES ('{$New_FRNO}', '{$param->fnDesc}', {$param->projectId}, 
        '$currentDateTime', '{$param->user}', '$currentDateTime', '{$param->user}','1','1')";

        $result = $this->db->query($sqlStr);
        if($result){
            $query = $this->db->query("SELECT MAX(functionId) AS last_id FROM M_FN_REQ_HEADER");
            $resultId = $query->result();
            return $resultId[0]->last_id;
        }
        return NULL;
    }

    function InsertRequirementsHeader($param){
        
		$currentDateTime = date('Y-m-d H:i:s');
        $New_functionVersion = $param->functionVersion+1;

         $sqlStr = "INSERT INTO M_FN_REQ_HEADER (functionNo, functionDescription, projectId, 
         createDate, createUser, updateDate, updateUser,
         functionversion,activeflag) 
         VALUES ('{$param->functionNo}', '{$param->fnDesc}', {$param->projectId}, 
         '$currentDateTime', '{$param->user}', '$currentDateTime', '{$param->user}',
         '{$New_functionVersion}','1')";
        
        $result = $this->db->query($sqlStr);
        if($result){
            $query = $this->db->query("SELECT MAX(functionId) AS last_id FROM M_FN_REQ_HEADER");
            $resultId = $query->result();
             return $resultId[0]->last_id;
        }
           return $resultId[0]->last_id;
        }

    function searchFRMAXFuncNo() {

        $strsql = " SELECT max(functionNo) AS Max_FRNO 
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
                AND functionId = '$New_FunctionId'
        ";
       $result = $this->db->query($strsql);
       //echo $sqlStr ;
       return $result->result_array();
    } 


    function updateChangeRequestDetail($param,$paramUpdate,$New_FunctionId) {

        //print_r($New_FunctionId);
        //print_r($paramUpdate);

        $currentDateTime = date('Y-m-d H:i:s');
        $fieldName = '';
        if($paramUpdate->newDataType != null){
            $fieldName = " dataType = '$paramUpdate->newDataType' ,";
        }
        if($paramUpdate->newDataLength != null){
            $fieldName .= " dataLength = '$paramUpdate->newDataLength' ,";
        }
        if($paramUpdate->newScaleLength  != null){
            $fieldName .= " decimalPoint = '$paramUpdate->newScaleLength' ,";
        }
        if($paramUpdate->newDefaultValue != null){
            $fieldName .= " constrraintDefault = '$paramUpdate->newDefaultValue' ,";
        }
        if($paramUpdate->newMinValue != null){
            $fieldName .= " ConstraintMinValue = '$paramUpdate->newMinValue' ,";
        }	
        if($paramUpdate->newMaxValue != null){
            $fieldName .= " ConstraintMaxValue = '$paramUpdate->newMaxValue' ,";
        }					
        $condition = $fieldName;

        $NewFR = $this->SearchRequirementsDetail($param,$New_FunctionId);
        foreach($NewFR as $value){
            $New_param = (object) array(
                'functionNo' => $value['functionNo'],
                'functionversion'   => $value['functionVersion']
            );
        }
        //print_r($NewFR);

        $strsql = "UPDATE M_FN_REQ_DETAIL
                set $condition 
                constraintUnique = '$paramUpdate->newUnique',
                constraintNull = '$paramUpdate->newNotNull'
                WHERE functionVersion = '$New_param->functionversion' 
                AND functionId = '$New_FunctionId'
                and activeflag = '1' 
                AND dataName = '$paramUpdate->dataName'
                and projectid = '$param->projectId' ";
        $result = $this->db->query($strsql);
        //print_r($strsql);
		return $this->db->affected_rows();
     } 
    
    function deleteChangeRequestDetail($param,$paramUpdate,$New_FunctionId) {
                    
        $NewFR = $this->SearchRequirementsDetail($param,$New_FunctionId);
        foreach($NewFR as $value){
            $New_param = (object) array(
                'functionNo' => $value['functionNo'],
                'functionversion'   => $value['functionVersion']
            );
        }
        //print_r($NewFR);

        $strsql = "DELETE FROM M_FN_REQ_DETAIL
                WHERE functionId = '$New_FunctionId' 
                AND functionVersion = '$New_param->functionversion' 
                AND activeflag = '1' 
                AND dataName = '$paramUpdate->dataName'
                AND projectid = '$param->projectId' ";
		$result = $this->db->query($strsql);
		return $this->db->affected_rows();
    }   				

    function addChangeRequestDetail($param,$paramUpdate,$New_FunctionId) {
        $currentDateTime = date('Y-m-d H:i:s');
           
        $NewFR = $this->SearchRequirementsDetail($param,$New_FunctionId);
        foreach($NewFR as $value){
            $New_param = (object) array(
                'functionNo' => $value['functionNo'],
                'functionversion'   => $value['functionVersion']
            );
        }
        //print_r($NewFR);

        $strsql = "INSERT INTO M_FN_REQ_DETAIL 
        (projectid, functionId, functionNo, functionVersion, typeData, dataName, 
        schemaVersionId, refTableName, refColumnName, dataType, dataLength, decimalPoint, constraintPrimaryKey, constraintUnique, 
        constraintDefault, constraintNull, constraintMinValue, constraintMaxValue, effectiveStartDate, effectiveEndDate, activeFlag,
        createDate, createUser, updateDate, updateUser)
        VALUES('$param->projectId','$New_FunctionId','$New_param->functionNo','$New_param->functionversion',
        '$paramUpdate->typeData','$paramUpdate->dataName',NULL,'$paramUpdate->tableName',
        '$paramUpdate->columnName','$paramUpdate->newDataType','$paramUpdate->newDataLength',
        '$paramUpdate->newScaleLength','N','$paramUpdate->newUnique','$paramUpdate->newDefaultValue',
        '$paramUpdate->newNotNull','$paramUpdate->newMinValue','$paramUpdate->newMaxValue',
        '$currentDateTime',NULL,'1','$currentDateTime','$param->user','$currentDateTime','$param->user')
        ";

		$result = $this->db->query($strsql);
		return $this->db->affected_rows();
    }  


    function MapFRVersion($param,$New_param) {
        $currentDateTime = date('Y-m-d H:i:s');

        $strsql = "INSERT INTO MAP_FR_VERSION 
        (projectid, Old_FR_Id, Old_FR_Version, New_FR_Id, New_FR_Version)
        VALUES('$param->projectId','$param->functionId','$param->functionVersion','$New_param->functionId',
        '$New_param->functionversion')
        ";

		$result = $this->db->query($strsql);
		return $this->db->affected_rows();
    }     
    
	function updateDatabaseSchemaVersion($param,$paramInsert){
        $currentDateTime = date('Y-m-d H:i:s');

		$sqlStr = "UPDATE M_DATABASE_SCHEMA_VERSION
			SET effectiveEndDate = '$currentDateTime', 
				activeFlag = '0', 
				updateDate = '$currentDateTime', 
				updateUser = '$param->user' 
            WHERE projectId = '$param->projectId'
            AND tableName = '$paramInsert->tableName'
            AND activeflag = '1' ";
//print_r($sqlStr);
        $result = $this->db->query($sqlStr);
		return $this->db->affected_rows();
    } 
    
	function updateDatabaseSchemaInfo($param,$paramInsert){

		$sqlStr = "UPDATE M_DATABASE_SCHEMA_INFO
			SET activeflag = '0', 
            WHERE projectId = '$param->projectId'
            AND tableName = '$paramInsert->tableName'
            AND activeflag = '1' ";
print_r($sqlStr);
        $result = $this->db->query($sqlStr);
		return $this->db->affected_rows();
    } 

    function insertDatabaseSchemaVersion($param, $paramInsert){
		$currentDateTime = date('Y-m-d H:i:s');

		$sqlStr = "INSERT INTO M_DATABASE_SCHEMA_VERSION 
        (projectId, tableName, columnName, schemaVersionNumber, effectiveStartDate, effectiveEndDate, activeFlag, createDate, 
        createUser, updateDate, updateUser) 
        SELECT $param->projectId, tableName, 'columnName', schemaVersionNumber+1, '$currentDateTime',
         NULL, '1', '$currentDateTime', '$param->user'', '$currentDateTime', '$param->user'
        WHERE projectId = $param->projectId
        AND tableName = $paramInsert->tableName
        ";

		$result = $this->db->query($sqlStr);
		if($result){
			$query = $this->db->query("SELECT MAX(schemaVersionId) as last_id FROM M_DATABASE_SCHEMA_VERSION");
			$resultId = $query->result();
			return $resultId[0]->last_id;
		}
		return NULL;
    }   
    
    function SearchDatabaseSchemaDetail($param,$paramInsert) {
    
        $strsql = "SELECT tableName,columnName,schemaVersionNumber,schemaVersionId
                FROM M_DATABASE_SCHEMA_VERSION
                WHERE activeflag = '1' 
                AND projectid = '$param->projectId' 
                AND tableName = '$paramInsert->tableName'
        ";
       $result = $this->db->query($strsql);
       //echo $sqlStr ;
       return $result->result_array();
    } 

    function MapDBVersion($New_param,$New_param_Oth,$New_param_DB) {
        $currentDateTime = date('Y-m-d H:i:s');

        $strsql = "INSERT INTO MAP_SCHEMA_VERSION 
        (projectid, FR_Id, FR_Version, TableName,Schema_Version)
        VALUES('$New_param->projectId','$New_param->functionId','$New_param->functionVersion','$New_param_DB->tableName',
        '$New_param_DB->schemaVersionNumber')
        ";
		$result = $this->db->query($strsql);
        return $this->db->affected_rows();
        
        if (!empty(New_param_Oth)){
            $strsql = "INSERT INTO MAP_SCHEMA_VERSION 
            (projectid, FR_Id, FR_Version, TableName,Schema_Version)
            VALUES('$New_param_Oth->projectId','$New_param_Oth->functionId','$New_param_Oth->functionVersion','$New_param_DB->tableName',
            '$New_param_DB->schemaVersionNumber')
            ";

            $result = $this->db->query($strsql);
            return $this->db->affected_rows();            
        }


    }    

    function InsertDatabaseSchemaInfo($param, $paramInsert){
		$currentDateTime = date('Y-m-d H:i:s');

		$sqlStr = "INSERT INTO M_DATABASE_SCHEMA_INFO
        (projectId, tableName, columnName, Version, effectiveStartDate, effectiveEndDate, activeFlag, createDate, 
        createUser, updateDate, updateUser) 
        SELECT $param->projectId, tableName, 'columnName','$paramInsert->Version',
        dataType,dataLength,decimalPoint,constraintPrimaryKey,constraintUnique,constraintDefault,constraintNull,
        constraintMinValue,constraintMaxValue,'1'
        WHERE projectId = $param->projectId
        AND tableName = $paramInsert->tableName
        ";

		$result = $this->db->query($sqlStr);
		if($result){
			$query = $this->db->query("SELECT MAX(schemaVersionId) as last_id FROM M_DATABASE_SCHEMA_VERSION");
			$resultId = $query->result();
			return $resultId[0]->last_id;
		}
		return NULL;
    }  

	function updateDatabaseSchemaInfoDetail($New_param_DB,$paramUpdate_DB,$New_SCHEMA_VERSION){
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

        $strsql = "UPDATE M_DATABASE_SCHEMA_INFO
                set $condition 
                constraintUnique = '$paramUpdate_DB->newUnique',
                constraintNull = '$paramUpdate_DB->newNotNull'
                WHERE tableName = '$paramUpdate_DB->tableName' 
                AND columnName = '$paramUpdate_DB->columnName' 
                AND activeflag = '1'
                AND Version = '$New_param_DB->schemaVersionNumber'
             ";
        $result = $this->db->query($strsql);
        //print_r($strsql);
		return $this->db->affected_rows();
    } 

    function deleteCDatabaseSchemaInfoDetail($New_param_DB,$paramUpdate_DB,$New_SCHEMA_VERSION){

        $strsql = "DELETE FROM M_DATABASE_SCHEMA_INFO
               WHERE tableName = '$paramUpdate_DB->tableName' 
                AND columnName = '$paramUpdate_DB->columnName' 
                AND activeflag = '1'
                AND Version = '$New_param_DB->schemaVersionNumber' ";

		$result = $this->db->query($strsql);
		return $this->db->affected_rows();
    }   

    function searchTablerelateSCHEMA($param){

		$sqlStr = " SELECT distinct tableName
		FROM T_TEMP_CHANGE_LIST
		WHERE functionId = '$param->functionId'
		AND functionversion ='$param->functionVersion'
		AND tableName is NOT NULL
		AND columnName is NOT  NULL ";
		$result = $this->db->query($sqlStr);
		//echo $sqlStr ;
		return $result->result_array();
	}
}
?>