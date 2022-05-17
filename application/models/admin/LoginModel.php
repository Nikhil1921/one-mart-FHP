<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class LoginModel extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function loginadmin($select, $mobile, $password, $table)
	{	
		$cred = array('mobile' => $mobile, 'password' => $password);
		
		$query = $this->db->select($select)
							->from($table)
							->where($cred)
							->get()
							->row_array();
		return $query;
	}
}