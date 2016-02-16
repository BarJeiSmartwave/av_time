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
			"ipDescription"=>$ipDescription
			);

		$this->host->storeIp($ipData);

		echo "<script> alert('IP address saved to database.'); </script>";
		redirect("host/viewHost", "refresh");
	}

//archived
	public function activateIp($ipId)
	{
		$this->host->activateIp($ipId);
		echo "<script> alert('IP address activated.'); </script>";
		redirect("host/viewHost", "refresh");
	}

//archived
	public function getActiveHost()
	{
		$ipActive = $this->host->searchActiveHost();

		if(count($ipActive)>0)
		{
			return $ipActive;
		}
		else
		{
			return $ipActive;
		}
	}

	public function viewHost()
	{
		$ipAddress = $this->getIp();
		$userLog = $this->accounts->getSessionAdmin();
		if(count($userLog) > 0)
		{
			$userFirstName["firstName"] = $userLog->firstName;
			$title = array(
				"title"=>"Network"
				);

			$allIp = $this->host->viewAllIp();
			$ipData["results"] = $allIp;
			// die('<pre>'.print_r($ipData, true));
			$activeIp = $this->getActiveHost();
			$ipActive["ipDetails"] = $activeIp;

			$this->load->view("admin/header", $title);
			$this->load->view("admin/sidebar", $userFirstName);
			$this->load->view("admin/host_view", array_merge($ipAddress, $ipData, $ipActive));
			$this->load->view("admin/footer");
		}
		else
		{
			echo "<script> alert('No User Logged In!'); </script>";
			redirect("login", "refresh");
		}
	}
	
//archived
	public function unsetIp($ipHostName)
	{
		$this->host->unsetIp($ipHostName);
		echo "<script> alert('Active IP address removed.'); </script>";
		redirect("host/viewHost", "refresh");
	}

	public function deleteIp($ipId)
	{
		$this->host->deleteIp($ipId);
		echo '<script> alert("Network removed from valid list."); </script>';
		redirect("host/viewHost", "refresh");
	}
}