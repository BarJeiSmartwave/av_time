<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
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
		$userLog = $this->accounts->getSessionAdmin();
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


			$this->load->view("admin/header", $title);
			$this->load->view("admin/sidebar", $userFirstName);
			$this->load->view("admin/time_view", array_merge($onlineNumber, $offlineNumber, $onLunchNumber, $userStatus));
			$this->load->view("admin/footer");
		}
		else
		{
			echo "<script> alert('You must log in first.'); </script>";
			redirect("login", "refresh");
		}
	}

	public function logOut()
	{
		$this->session->unset_userdata("adminName");
		$this->session->unset_userdata("adminId");
		redirect("login", "refresh");
	}

	public function timeIn()
	{
		$userId = $this->session->adminId;
		
		$statusCode = $this->accounts->userIsOnline($userId);
		if($statusCode == 1 || $statusCode == 2)
		{
			echo "<script> alert('You are already online!'); </script>";
			redirect("admin", "refresh");
		}
		else
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
				redirect("admin", "refresh");
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
				redirect("admin", "refresh");
			}
		}
	}

	public function timeOut()
	{
		$dateTimeNow = date("Y-m-d H:i:s");

		$userId = $this->session->adminId;
		
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
		$userId = $this->session->adminId;
		$arrLogData = array(
			"userId"=>$userId, 
			"breakTime"=>$dateTimeNow
			);
		$statusCode = $this->accounts->userIsOnline($userId);
		if($statusCode == 0)
		{
			echo "<script> alert('You are not online!'); </script>";
			$this->index();
		}
		elseif($statusCode == 2)
		{
			echo "<script> alert('You are already on break!'); </script>";
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
		$userId = $this->session->adminId;
		$statusCode = $this->accounts->userIsOnline($userId);
		if($statusCode == 0)
		{
			echo "<script> alert('You are not online!'); </script>";
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

	public function exportToCsv()
	{
		$this->load->dbutil();
		$this->load->helper("file");
		$this->load->helper("download");

		$dateToday = date("d-m-Y");
		$adminName = $this->session->adminName;
		$adminId = $this->session->adminId;
		$fileName = "Log-data-".$dateToday.".csv";
		$delimiter = ", ";
		$newLine = "\r\n";

		$logData = $this->admin->getCsvDetails();
		$csv = $this->dbutil->csv_from_result($logData, $delimiter, $newLine);
		force_download($fileName, $csv);
	}

	public function viewProfile($userId)
	{
		$userLog = $this->accounts->getSessionAdmin();
		if(count($userLog) > 0)
		{
			// $userFullName["fullName"] = $userLog->firstName." ".$userLog->lastName;
			$userFirstName["firstName"] = $userLog->firstName;
			$displayName = $userLog->firstName." ".$userLog->lastName;
			$title = array(
				"title"=>$displayName
				);
			$userData["userDetails"] = $userLog;

			// $imageFrame = base_url('assets/images/frames.png');
			// $image = base_url('uploads/'.$userLog->imageCode);

			// $top = imagecreatefrompng($imageFrame);
			// $bottom = imagecreatefrompng($image);

			// list($top_width, $top_height) = getimagesize($imageFrame);
			// list($bottom_width, $bottom_height) = getimagesize($image);

			// $new_width = ($top_width > $bottom_width) ? $top_width : $bottom_width;
			// $new_height = $top_height + $bottom_height;

			// $new = imagecreate($new_width, $new_height);
			// imagecopy($new, $top, 0, 0, 0, 0, $top_width, $top_height);
			// imagecopy($new, $bottom, 0, $top_height+1, 0, 0, $bottom_width, $bottom_height);

			// // save to file
			// imagepng($new, './uploads/newImage.png');

			$this->load->view("admin/header", $title);
			$this->load->view("admin/sidebar", $userFirstName);
			$this->load->view("admin/profile_view", $userData);
			$this->load->view("admin/footer");
		}
		else
		{
			echo "<script> alert('You must log in first.'); </script>";
			redirect("login", "refresh");
		}
	}

	public function editProfile($userId)
	{
		$userLog = $this->accounts->getSessionAdmin();
		if(count($userLog) > 0)
		{
			// $userFullName["fullName"] = $userLog->firstName." ".$userLog->lastName;
			$userFirstName["firstName"] = $userLog->firstName;
			$title = array(
				"title"=>"Edit Profile"
				);
			$userData["userDetails"] = $userLog;

			$this->load->view("admin/header", $title);
			$this->load->view("admin/sidebar", $userFirstName);
			$this->load->view("admin/editprofile_view", $userData);
			$this->load->view("admin/footer");
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

		$userId = $this->session->adminId;

		$this->accounts->saveUserData($updatedData, $userId);
		echo '<script> alert("Changes successfully saved."); </script>';
		redirect("admin/editProfile/".$userId, "refresh");
	}

	public function saveAccountDetails()
	{
		$userName = $this->input->post("txtUsername");
		$userPassword = $this->input->post("txtPassword");

		$updatedData = array(
			"userName" => $userName,
			"userPassword" => md5($userPassword)
			);

		$userId = $this->session->adminId;

		if(strlen($userPassword) < 8){
			echo "<script> alert('Password should have at least 8 characters.'); </script>";
			redirect("admin/editProfile/".$userId, "refresh");
		}
		else
		{
			$this->accounts->saveUserData($updatedData, $userId);
			echo '<script> alert("Changes successfully saved."); </script>';
			redirect("admin/editProfile/".$userId, "refresh");
		}
	}

	public function saveProfilePicture()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'jpg|png';
		$config['encrypt_name'] = TRUE;

		$this->load->library("upload", $config);

		$userId = $this->session->adminId;

		if (!$this->upload->do_upload("userImage"))
		{
			$strError = $this->upload->display_errors();
			echo '<script> alert("'.strip_tags($strError).'"); </script>';
			redirect("admin/editProfile/".$userId, "refresh");
			$this->viewAdd();
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
			redirect("admin/editProfile/".$userId, "refresh");
			$this->viewAdd();
		}
	}

}