<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
	function __construct(){
		parent::__construct();
	}

	function _checkUser($username, $password){
		$result = $this->db->query("SELECT * FROM M_USERS where username = '$username' and password = '$password'")->first_row(); 

		//echo var_dump($result->counts);
		//return (int)$result->counts > 0 ? TRUE : FALSE;
		return $result;
	}
	function UserName($userId){
		$queryStr 
		= "SELECT username FROM M_USERS where userId = '$userId' ";
		$result = $this->db->query($queryStr);
		//echo $queryStr ;
		return $result->row();

	}
}
?>