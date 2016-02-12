<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Time extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Time_model", "time");
		$this->load->model("Admin_model", "admin");
		$this->load->model("User_model", "user");
		$this->load->model("Accounts_model", "accounts");
		$this->load->model("Host_model", "host");
	}

	public function viewTimeLogs()
	{
		$userLog = $this->accounts->getSessionAdmin();
		$timeLogs["timeLogs"] = $this->time->getTimeLogs();
		if(count($userLog) > 0)
		{
			// $userFullName["fullName"] = $userLog->firstName." ".$userLog->lastName;
			$userFirstName["firstName"] = $userLog->firstName;
			$title = array(
				"title"=>"Time Logs"
				);
			$this->load->view("admin/header", $title);
			$this->load->view("admin/sidebar", $userFirstName);
			$this->load->view("admin/timelogtable_view", $timeLogs);
			$this->load->view("admin/footer");
		}
		else
		{
			echo "<script> alert('No User Logged In!'); </script>";
			redirect("login", "refresh");
		}
	}

	public function viewPerUser($userId)
	{
		$userLog = $this->accounts->getSessionAdmin();
		$timeLogsPeriod["timeLogsPeriod"] = $this->time->getTotalHoursCurrentMonth($userId);
		$timeLogs["timeLogs"] = $this->time->getTimeLogsOnCurrentMonth($userId);
		$userData["userData"] = $this->accounts->getUserById($userId);
		$datePeriods["datePeriods"] = $this->time->getDatePeriods($userId);
		// die("<pre>".print_r($datePeriod, true));

		if(count($userLog) > 0)
		{
			// $userFullName["fullName"] = $userLog->firstName." ".$userLog->lastName;
			$userFirstName["firstName"] = $userLog->firstName;
			$title = array(
				"title"=>"Time Logs"
				);
			$this->load->view("admin/header", $title);
			$this->load->view("admin/sidebar", $userFirstName);
			$this->load->view("admin/timelogperuser_view", array_merge($timeLogs, $userData, $timeLogsPeriod, $datePeriods));
			$this->load->view("admin/footer");
		}
		else
		{
			echo "<script> alert('No User Logged In!'); </script>";
			redirect("login", "refresh");
		}
	}

	public function viewPerPeriod($userId)
	{
		$userLog = $this->accounts->getSessionAdmin();
		
		$userData["userData"] = $this->accounts->getUserById($userId);
		$datePeriods["datePeriods"] = $this->time->getDatePeriods($userId);

		$datePeriod = $this->input->post("datePeriod");

		$logsPerPeriod["timeLogs"] = $this->time->viewLogsPerPeriod($userId, $datePeriod);
		$timeLogsPeriod["timeLogsPeriod"] = $this->time->getTotalHoursPerPeriod($userId, $datePeriod);

		if(count($userLog) > 0)
		{
			// $userFullName["fullName"] = $userLog->firstName." ".$userLog->lastName;
			$userFirstName["firstName"] = $userLog->firstName;
			$title = array(
				"title"=>"Time Logs"
				);
			$this->load->view("admin/header", $title);
			$this->load->view("admin/sidebar", $userFirstName);
			$this->load->view("admin/timelogperuser_view", array_merge($userData, $logsPerPeriod, $datePeriods, $timeLogsPeriod));
			$this->load->view("admin/footer");
		}
		else
		{
			echo "<script> alert('No User Logged In!'); </script>";
			redirect("login", "refresh");
		}
	}

	public function exportToCsv($userId)
	{
		$this->load->dbutil();
		$this->load->helper("file");
		$this->load->helper("download");

		$userName = $this->accounts->getUserById($userId);

		$fileName = "Log-data-".$userName->userName."-".$userId.".csv";
		$delimiter = ", ";
		$newLine = "\r\n";

		$logData = $this->user->getCsvDetails($userId);
		$csv = $this->dbutil->csv_from_result($logData, $delimiter, $newLine);
		force_download($fileName, $csv);
	}

}