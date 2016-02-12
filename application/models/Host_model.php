<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Host_model extends CI_Model
{
	public function storeIp($ipData)
	{
		$this->db->insert("tbl_ipaddress", $ipData);
	}

	public function viewAllIp()
	{
		$allIpAdd = $this->db->select()
		->from("tbl_ipaddress")
		->where("isActive", 0)
		->get();
		return $allIpAdd->result();
	}

	public function activateIp($ipId)
	{
		$this->db->set("isActive", 0)
		->where("isActive", 1)
		->update("tbl_ipaddress");

		$this->db->set("isActive", 1)
		->where("ipId", $ipId)
		->update("tbl_ipaddress");

	}

	public function searchActiveHost()
	{
		$ipQuery = $this->db->select()
		->from("tbl_ipaddress")
		->where("isActive", 1)
		->get();
		
		return $ipQuery->row();
	}

	public function unsetIp($ipHostName)
	{
		$this->db->set("isActive", 0)
		->where("ipHostName", $ipHostName)
		->update("tbl_ipaddress");
	}
	
	public function getHostName()
	{
		$inputIpAddress = $this->input->ip_address();
		$ipHostName = gethostbyaddr($inputIpAddress);
		return $ipHostName;
	}
}