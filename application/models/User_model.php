<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
	public function getCsvDetails($userId)
	{
		$csvQuery = $this->db->select("logId, logIn, logOut, logHours")
		->from("tbl_timelogs")
		->where("userId", $userId)
		->get();

		return $csvQuery;
	}
}