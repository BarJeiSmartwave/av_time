<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts_model extends CI_Model
{
	public function getUserById($userId)
	{
		$userData = $this->db->select()
		->from("tbl_accounts")
		->where("userId", $userId)
		->get();

		return $userData->row();
	}

	public function getSessionAdmin()
	{
		$sessionAdminId = $this->session->adminId;
		$userLog = $this->getUserById($sessionAdminId);

		return $userLog;
	}

	public function getSessionUser()
	{
		$sessionUserId = $this->session->userId;
		$userLog = $this->getUserById($sessionUserId);

		return $userLog;
	}

	public function userIsOnline($userId)
	{
		$userQuery = $this->db->select("statusCode")
		->from("tbl_accounts")
		->where("userId", $userId)
		->get();

		$value = $userQuery->row();
		switch ($value->statusCode) 
		{
			case 0:
			return 0;
			break;

			case 1:
			return 1;
			break;

			case 2:
			return 2;
			break;
		}
	}

	public function addUser($userData)
	{
		$insert = $this->db->insert("tbl_accounts", $userData);
	}

	public function viewAllUsers()
	{
		$allUsers = $this->db->get("tbl_accounts");
		$users = $allUsers->result();
		return $users;
	}

	public function saveUserData($updatedData, $userId)
	{
		$updateUser = $this->db->set($updatedData)
		->where("userId", $userId)
		->update("tbl_accounts");
	}

	// public function getUserStatus($userId)
	// {
	// 	$selectUser = $this->db->select("statusCode")
	// 	->from("tbl_accounts")
	// 	->where("userId", $userId)
	// 	->get();

	// 	$userStatus = $selectUser->row();
	// 	return $userStatus;
	// }

	public function countUserStatus($statusCode)
	{
		$usersCount = $this->db->select()
		->from("tbl_accounts")
		->where("statusCode", $statusCode)
		->count_all_results();

		return $usersCount;
	}
}