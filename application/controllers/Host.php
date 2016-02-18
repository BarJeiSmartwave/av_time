<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Host extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Host_model", "host");
		$this->load->model("Accounts_model", "accounts");
	}

	public function index()
	{
		$ipAddress['ipDetails'] = $this->getIp();		
		$userLog = $this->accounts->getSessionAdmin();
		if(count($userLog) > 0)
		{
			$userFirstName["firstName"] = $userLog->firstName;
			$title = array(
				"title"=>"Network"
				);

			$validIp['validIp'] = $this->host->getValidIp();
			$invalidIp['invalidIp'] = $this->host->getInvalidIp();

			$this->load->view("admin/header", $title);
			$this->load->view("admin/sidebar", $userFirstName);
			$this->load->view("admin/host_view", array_merge($validIp, $invalidIp, $ipAddress));
			$this->load->view("admin/footer");
		}
		else
		{
			echo "<script> alert('No User Logged In!'); </script>";
			redirect("login", "refresh");
		}
	}

	public function getIp()
	{
		$inputIpAddress = $this->input->ip_address();
		$ipAddress["hostname"] = gethostbyaddr($inputIpAddress);
		$ipAddress["ipAddress"] = $inputIpAddress;
		return $ipAddress;
	}

	public function saveIp()
	{
		$ipAddress = $this->getIp();
		$ipValue = $ipAddress["ipAddress"];
		$ipHostName = $ipAddress["hostname"];
		$ipDescription = $this->input->post("txtDescription");

		$ipConverted = ip2long($ipValue);

		$ipData = array(
			"ipValue"=>$ipConverted, 
			"ipHostName"=>$ipHostName, 
			"ipDescription"=>$ipDescription,
			"isValid"=>1
			);

		$this->host->storeIp($ipData);

		echo "<script> alert('IP address saved to database.'); </script>";
		redirect("host", "refresh");
	}
	
	public function removeIp($ipId)
	{
		$this->host->removeIp($ipId);
		echo "<script> alert('Network removed from valid list'); </script>";
		redirect("host", "refresh");
	}

	public function deleteIp($ipId)
	{
		$this->host->deleteIp($ipId);
		echo '<script> alert("Network deleted from all list."); </script>';
		redirect("host", "refresh");
	}

	public function setValid($ipId)
	{
		$this->host->setAsValidIp($ipId);
		echo "<script> alert('Network moved back to valid list'); </script>";
		redirect("host", "refresh");
	}
}