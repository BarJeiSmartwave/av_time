<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Host_model extends CI_Model
{
	public function storeIp($ipData)
	{
		$this->db->insert("tbl_ipaddress", $ipData);
	}

	public function getValidIp()
	{
		$validHosts = $this->db->select('*')
		->where('isValid', 1)
		->where('isDeleted', 0)
		->get("tbl_ipaddress");

		return $validHosts->result_array();
	}

	public function getInvalidIp()
	{
		$invalidHosts = $this->db->select('*')
		->where('isValid', 0)
		->where('isDeleted', 0)
		->get('tbl_ipaddress');

		return $invalidHosts->result_array();
	}

	public function getHostName()
	{
		$inputIpAddress = $this->input->ip_address();
		$ipHostName = gethostbyaddr($inputIpAddress);
		return $ipHostName;
	}

	public function removeIp($ipId)
	{
		$this->db->set("isValid", 0)
		->where("ipId", $ipId)
		->update("tbl_ipaddress");
	}

	public function deleteIp($ipId)
	{
		$this->db->set("isDeleted", 1)
		->where('ipId', $ipId)
		->update('tbl_ipaddress');
	}

	public function setAsValidIp($ipId)
	{
		$this->db->set("isValid", 1)
		->where('ipId', $ipId)
		->update('tbl_ipaddress');
	}
}