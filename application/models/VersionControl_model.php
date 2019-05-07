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
        $this->db->trans_start(); //Starting Transaction
		$this->db->trans_strict(FALSE);

		$newCurrentDate = date('Y-m-d H:i:s');

		$sqlStr = "UPDATE M_FN_REQ_HAEDER
			SET activeflag = '0',
				createUser 	= '$newCurrentDate',
				updateDate 	 = '$newCurrentDate',
				updateUser 	 = '$param->user'
			WHERE functionId = '$param->functionId'
			AND functionNo = '$param->functionNo'
			AND functionversion = '$param->functionVersion'
			AND projectId = '$param->projectId' ";
			
        $this->db->query($sqlStr);
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

	function InsertRequirementsHeader($param){
        
		$currentDateTime = date('Y-m-d H:i:s');
        $FRMAXFuncNo = $this->searchFRMAXFuncNo();

        if($param->functionVersionNo == null){
            $sqlStr = "INSERT INTO M_FN_REQ_HEADER (functionNo, functionDescription, projectId, 
            createDate, createUser, updateDate, updateUser,functionversion,activeflag) 
            VALUES ('{$FRMAXFuncNo['Max_FRNO']}', '{$param->fnDesc}', {$param->projectId}, 
            '$currentDateTime', '{$param->user}', '$currentDateTime', '{$param->user}','1','1')";
        }else{
            $sqlStr = "INSERT INTO M_FN_REQ_HEADER (functionNo, functionDescription, projectId, 
            createDate, createUser, updateDate, updateUser,functionversion,activeflag) 
            VALUES ('{$param->functionNo}', '{$param->functionDescription}', {$param->projectId}, 
            '$currentDateTime', '{$param->user}', '$currentDateTime', '{$param->user}','{$param->functionVersionNo}','{$param->activeFlag}')";
        }
            $result = $this->db->query($sqlStr);
            if($result){
                $query = $this->db->query("SELECT MAX(functionId) AS last_id FROM M_FN_REQ_HEADER");
                $resultId = $query->result();
                return $resultId[0]->last_id;
            }
            return NULL;
        }

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
   
      //echo $strsql;
      return $strsql;
    } 

	function updateChange_RequirementsDetail($param) {
		$currentDateTime = date('Y-m-d H:i:s');
	
			$strsql = "UPDATE M_FN_REQ_DETAIL 
				SET effectiveEndDate = '$currentDateTime',
				updateDate = '$currentDateTime',
				updateUser = '$param->user',
				activeFlag = '0'
				WHERE b.functionVersion = '$param->functionVersion' 
				AND b.functionNo = '$param->functionNo'
				AND b.activeflag = '1' 
				AND b.projectid = '$param->projectId' 
		";
		//echo $strsql;
		return $strsql ;
	} 
}
?>