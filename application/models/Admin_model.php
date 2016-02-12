<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model
{
	public function getCsvDetails()
	{
		// $sql = "SELECT   FROM tbl_accounts AS a , tbl_timelogs AS b WHERE a.userId = $userId";
		// $result = $this->db->query($sql);
		// return $result;
		$csvQuery = $this->db->select("logId, tbl_timelogs.userId, lastName, firstName, logIn, logOut, logHours")
		->from("tbl_timelogs")
		->join("tbl_accounts", "tbl_timelogs.userId = tbl_accounts.userId")
		->get();

		return $csvQuery;
	}
}