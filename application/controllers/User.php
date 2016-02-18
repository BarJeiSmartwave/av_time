<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Admin_model", "admin");
		$this->load->model("User_model", "user");
		$this->load->model("Accounts_model", "accounts");
		$this->load->model("Host_model", "host");
		$this->load->model("Time_model", "time");
	}

	public function index()
	{
		$userLog = $this->accounts->getSessionUser();
		if(count($userLog) > 0)
		{
			// $userFullName["fullName"] = $userLog->firstName." ".$userLog->lastName;
			$userFirstName["firstName"] = $userLog->firstName;
			$title = array(
				"title"=>"Home"
				);

			$userStatus["statusCode"] = $this->accounts->userIsOnline($userLog->userId);

			$onlineNumber["onLine"] = $this->accounts->countUserStatus(1);
			$onLunchNumber["onLunch"] = $this->accounts->countUserStatus(2);
			$offlineNumber["offLine"] = $this->accounts->countUserStatus(0);

			$this->load->view("user/header", $title);
			$this->load->view("user/sidebar", $userFirstName);
			$this->load->view("user/time_view", array_merge($onlineNumber, $offlineNumber, $onLunchNumber, $userStatus));
			$this->load->view("user/footer");
		}
		else
		{
			echo "<script> alert('You must log in first.'); </script>";
			redirect("login", "refresh");
		}
	}

	public function logOut()
	{
		$this->session->unset_userdata("userName");
		$this->session->unset_userdata("userId");
		$this->load->view("login/signin_view");
	}

	public function timeIn()
	{
		$userId = $this->session->userId;

		$statusCode = $this->accounts->userIsOnline($userId);

		$networks = $this->host->getValidIp();
		if($statusCode == 1 || $statusCode == 2)
		{
			echo "<script> alert('You are already online.'); </script>";
			redirect("user", "refresh");
		}
		else
		{
			$networkCount = count($networks);
			if($networkCount > 0)
			{			
				$ipHostName = $this->host->getHostName();
				$validNetwork= array();
				foreach($networks as $network)
				{
					$validNetwork[] = $network["ipHostName"];
				}
				$matched = array_search($ipHostName, $validNetwork);

				if($matched > 0)
				{
					$dateTimeNow = date("Y-m-d H:i:s");
					$dateNow = date("Y-m-d");
					$gracePeriod = strtotime("09:30:59");
					$timeRequired = strtotime("09:00:00");
					$timeFormat = date("H:i:s");
					$timeNow = strtotime($timeFormat);

					if ($timeNow > $gracePeriod) 
					{
						$computeTime = ($timeNow - $timeRequired)/3600;
						$hoursValue = floor($computeTime);
						$computeMinutes = (($computeTime-floor($computeTime))*60);
						$minutesValue =floor((($computeTime-floor($computeTime))*60));
						$secondsValue = ($computeMinutes - $minutesValue)*60;
						$lateHours = $hoursValue.':'.$minutesValue.':'.$secondsValue;

						$arrLogData = array(
							"userId"=>$userId,
							"logDate"=>$dateNow, 
							"logIn"=>$dateTimeNow,
							"lateHours"=>$lateHours
							);
						$this->time->timeIn($arrLogData, $userId);
						echo '<script> alert("Time log recorded.\nYou are late."); </script>';
						redirect("user", "refresh");
					}
					else 
					{
						$arrLogData = array(
							"userId"=>$userId, 
							"logDate"=>$dateNow, 
							"logIn"=>$dateTimeNow
							);
						$this->time->timeIn($arrLogData, $userId);
						echo "<script> alert('Time log recorded.'); </script>";
						redirect("user", "refresh");
					}
				}
				else
				{
					echo '<script> alert("Error: System cannot record time log.\nReason: Your network is not in the valid list"); </script>';
					redirect("user", "refresh");
				}				
			}
			
			else
			{
				echo '<script> alert("Error: System cannot record time log.\nReason: There is no valid network"); </script>';
				redirect("user", "refresh");
			}
		}			
	}

	public function timeOut()
	{
		$dateTimeNow = date("Y-m-d H:i:s");

		$userId = $this->session->userId;
		
		$isOnline = $this->accounts->userIsOnline($userId);

		if($isOnline == 0)
		{
			echo "<script> alert('You are not online.'); </script>";
			$this->index();
		}
		elseif($isOnline == 2)
		{
			echo "<script> alert('You are still on break.'); </script>";
			$this->index();
		}
		elseif($isOnline == 1)
		{
			$timeCap = strtotime("18:00:00");
			$timeFormat = date("H:i:s");
			$timeNow = strtotime($timeFormat);

			$arrLogData = array(
				"logOut"=>$dateTimeNow
				);

			if($timeNow > $timeCap)
			{
				$this->time->timeOut($arrLogData, $userId);
				echo "<script> alert('Time log recorded.'); </script>";
				$this->index();
			}
			else
			{
				$this->time->timeOut($arrLogData, $userId);
				echo '<script> alert("Time log recorded.\nYou timed out early."); </script>';
				$this->index();
			}
		}
	}

	public function goToBreak()
	{
		$dateTimeNow = date("Y-m-d H:i:s");
		$userId = $this->session->userId;
		$arrLogData = array(
			"userId"=>$userId, 
			"breakTime"=>$dateTimeNow
			);
		$statusCode = $this->accounts->userIsOnline($userId);
		if($statusCode == 0)
		{
			echo "<script> alert('You are not online.'); </script>";
			$this->index();
		}
		elseif($statusCode == 2)
		{
			echo "<script> alert('You are already on break.'); </script>";
			$this->index();
		}
		else
		{
			$this->time->setUserOnBreak($arrLogData, $userId);
			echo "<script> alert('Status updated.'); </script>";
			$this->index();
		}
	}
	public function endBreak()
	{
		$userId = $this->session->userId;
		$statusCode = $this->accounts->userIsOnline($userId);
		if($statusCode == 0)
		{
			echo "<script> alert('You are not online.'); </script>";
			$this->index();
		}
		if($statusCode == 1)
		{
			echo "<script> alert('You are not on break.'); </script>";
			$this->index();
		}
		elseif($statusCode == 2)
		{
			$this->time->endBreak($userId);
			echo "<script> alert('Status updated.'); </script>";
			$this->index();
		}
	}

	public function viewTimeLogs()
	{
		$userLog = $this->accounts->getSessionUser();
		if(count($userLog) > 0)
		{
			// $userFullName["fullName"] = $userLog->firstName." ".$userLog->lastName;
			$userFirstName["firstName"] = $userLog->firstName;
			$title = array(
				"title"=>"Time Logs"
				);

			$userId = $this->session->userId;
			$timeLogsPeriod["timeLogsPeriod"] = $this->time->getTotalHoursCurrentMonth($userId);
			$timeLogData["timeLogs"] = $this->time->getTimeLogsOnCurrentMonth($userId);

			$userData["userData"] = $this->accounts->getUserById($userId);

			$this->load->view("user/header", $title);
			$this->load->view("user/sidebar", $userFirstName);
			$this->load->view("user/timelogtable_view", array_merge($userData, $timeLogData, $timeLogsPeriod));
			$this->load->view("user/footer");
		}
		else
		{
			echo "<script> alert('You must log in first.'); </script>";
			redirect("login", "refresh");
		}
	}

	public function exportToCsv($userId)
	{
		$this->load->dbutil();
		$this->load->helper("file");
		$this->load->helper("download");

		$userName = $this->session->userName;
		$fileName = "Log-data-".$userName."-".$userId.".csv";
		$delimiter = ", ";
		$newLine = "\r\n";

		$logData = $this->user->getCsvDetails($userId);
		$csv = $this->dbutil->csv_from_result($logData, $delimiter, $newLine);
		force_download($fileName, $csv);
	}

	public function viewProfile($userId)
	{
		$userLog = $this->accounts->getSessionUser();
		if(count($userLog) > 0)
		{
			// $userFullName["fullName"] = $userLog->firstName." ".$userLog->lastName;
			$userFirstName["firstName"] = $userLog->firstName;
			$displayName = $userLog->firstName." ".$userLog->lastName;
			$title = array(
				"title"=>$displayName
				);
			$userData["userDetails"] = $userLog;

			$this->load->view("user/header", $title);
			$this->load->view("user/sidebar", $userFirstName);
			$this->load->view("user/profile_view", $userData);
			$this->load->view("user/footer");
		}
		else
		{
			echo "<script> alert('You must log in first.'); </script>";
			redirect("login", "refresh");
		}
	}

	public function editProfile($userId)
	{
		$userLog = $this->accounts->getSessionUser();
		if(count($userLog) > 0)
		{
			// $userFullName["fullName"] = $userLog->firstName." ".$userLog->lastName;
			$userFirstName["firstName"] = $userLog->firstName;
			$title = array(
				"title"=>"Edit Profile"
				);
			$userData["userDetails"] = $userLog;

			$this->load->view("user/header", $title);
			$this->load->view("user/sidebar", $userFirstName);
			$this->load->view("user/editprofile_view", $userData);
			$this->load->view("user/footer");
		}
		else
		{
			echo "<script> alert('You must log in first.'); </script>";
			redirect("login", "refresh");
		}
	}

	public function saveUserDetails()
	{
		$firstName = $this->input->post("txtFirstName");
		$lastName = $this->input->post("txtLastName");
		$contactNo = $this->input->post("txtContact");
		$emailAdd = $this->input->post("txtEmail");

		$updatedData = array(
			"lastName" => ucwords($lastName),
			"firstName" => ucwords($firstName),
			"emailAddress" => $emailAdd,
			"contactNumber" => $contactNo
			);

		$userId = $this->session->userId;

		$this->accounts->saveUserData($updatedData, $userId);
		echo '<script> alert("Changes successfully saved"); </script>';
		redirect("user/editProfile/".$userId, "refresh");
	}
	public function saveAccountDetails()
	{
		$userName = $this->input->post("txtUsername");
		$userPassword = $this->input->post("txtPassword");

		$updatedData = array(
			"userName" => $userName,
			"userPassword" => md5($userPassword)
			);

		$userId = $this->session->userId;

		if(strlen($userPassword) < 8){
			echo "<script> alert('Password should have at least 8 characters.'); </script>";
			redirect("user/editProfile/".$userId, "refresh");
		}
		else
		{
			$this->accounts->saveUserData($updatedData, $userId);
			echo '<script> alert("Changes successfully saved"); </script>';
			redirect("user/editProfile/".$userId, "refresh");
		}

	}

	public function saveProfilePicture()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'jpg|png';
		$config['encrypt_name'] = TRUE;

		$this->load->library("upload", $config);

		$userId = $this->session->userId;

		if (!$this->upload->do_upload("userImage"))
		{
			$strError = $this->upload->display_errors();
			echo '<script> alert("'.strip_tags($strError).'"); </script>';
			redirect("user/editProfile/".$userId, "refresh");
		}
		else
		{
			$data = array("upload_data" => $this->upload->data());
			$imageFile = $this->upload->data();

			$userData = array(
				"imageCode" => $imageFile["file_name"]
				);
			$this->accounts->saveUserData($userData, $userId);
			echo "<script> alert('Changes successfully saved.'); </script>";
			redirect("user/editProfile/".$userId, "refresh");
		}
	}
}