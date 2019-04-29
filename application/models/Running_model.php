	<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Change Management Model
*/
class Running_model extends CI_Model{

    function __construct(){
		parent::__construct();

		$this->load->model('FunctionalRequirement_model', 'mFR');
		$this->load->model('DatabaseSchema_model', 'mDB');
		$this->load->model('Miscellaneous_model', 'mMisc');
		$this->load->model('TestCase_model', 'mTestCase');
		$this->load->model('RTM_model', 'mRTM');
		$this->load->model('Common_model', 'mCommon');
	}

    function running_ch(){

		$sqlStr = "select max(changeRequestId) AS changeRequestId from M_RUNNING_CH";
		$result = $this->db->query($sqlStr);
		//echo $sqlStr ;
		return $result->row();
    }	
    
    function Update_Running_ch(){
		$this->db->trans_start(); //Starting Transaction
        $this->db->trans_strict(FALSE);
        
		$sqlStr = "UPDATE M_RUNNING_CH SET changeRequestId = changeRequestId+1 ";
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
}