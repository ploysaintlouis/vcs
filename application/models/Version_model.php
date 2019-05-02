<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Functional Requirement Version Management
* Create Date: 2017-06-08
*/
class Version_model extends CI_Model{
	
	function __construct(){
		parent::__construct();

		$this->load->model('Project_model', 'Project');
		$this->load->model('VersionManagement_model', 'mVerMng');
		$this->load->model('FunctionalRequirement_model', 'mFR');

		$this->load->library('form_validation', null, 'FValidate');
	}

    function saveChangeList($param){
        
    }
}
?>