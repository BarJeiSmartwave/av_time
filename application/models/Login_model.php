<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model
{
	public function authenticateUser($userName, $userPassword)
	{
		$userData = $this->db->select()
		->from("tbl_accounts")
		->where("userName", $userName)
		->where("userPassword", $userPassword)
		->get();
		return $userData->row();
	}

	public function userIsDeleted($userId)
	{

	}
}