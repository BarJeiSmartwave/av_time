<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends CI_Controller
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

	public function viewAdd()
	{
		$userLog = $this->accounts->getSessionAdmin();
		if(count($userLog) > 0)
		{
			// $userFullName["fullName"] = $userLog->firstName." ".$userLog->lastName;
			$userFirstName["firstName"] = $userLog->firstName;
			$title = array(
				"title"=>"Add User"
				);
			$this->load->view("admin/header", $title);
			$this->load->view("admin/sidebar", $userFirstName);
			$this->load->view("admin/adduser_view");
			$this->load->view("admin/footer");
		}
		else
		{
			echo "<script> alert('No User Logged In!'); </script>";
			redirect("login", "refresh");
		}
	}

	public function addUser()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'jpg|png';
		$config['encrypt_name'] = TRUE;

		$this->load->library("upload", $config);

		$firstName = $this->input->post("txtFirstName");
		$lastName = $this->input->post("txtLastName");
		$userName = $this->input->post("txtUsername");
		$userPass = $this->input->post("txtPassword");
		$contactNumber = $this->input->post("txtContact");
		$email = $this->input->post("txtEmail");
		$md5Pass = md5($userPass);

		if(strlen($userPass) < 8){
			echo "<script> alert('Password should have at least 8 characters!'); </script>";
			$this->viewAdd();
		}
		else
		{
			if (!$this->upload->do_upload("userImage"))
			{
				$strError = $this->upload->display_errors();
				echo '<script> alert("'.strip_tags($strError).'"); </script>';
				$this->viewAdd();
			}
			else
			{
				$data = array("upload_data" => $this->upload->data());
				$imageFile = $this->upload->data();

				$userData = array(
					"lastName" => ucwords($lastName),
					"firstName" => ucwords($firstName),
					"userName" => $userName,
					"userPassword" => $md5Pass,
					"emailAddress" => $email,
					"contactNumber" => $contactNumber,
					"imageCode" => $imageFile["file_name"]
					);
				$this->accounts->addUser($userData);
				echo "<script> alert('User successfully added to database.'); </script>";
				redirect("accounts/viewUsers", "refresh");
			}
		}
	}
	
	public function viewUsers()
	{
		$userLog = $this->accounts->getSessionAdmin();
		if(count($userLog) > 0)
		{
			// $userFullName["fullName"] = $userLog->firstName." ".$userLog->lastName;
			$userFirstName["firstName"] = $userLog->firstName;
			$title = array(
				"title"=>"All Users"
				);
			$allUsers["usersData"] = $this->accounts->viewAllUsers();
			$this->load->view("admin/header", $title);
			$this->load->view("admin/sidebar", $userFirstName);
			$this->load->view("admin/users_view", $allUsers);
			$this->load->view("admin/footer");
		}
		else
		{
			echo "<script> alert('No User Logged In!'); </script>";
			redirect("login", "refresh");
		}
	}
}