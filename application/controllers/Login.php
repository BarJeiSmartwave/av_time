<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Login_model", "login");
		$this->load->model("Accounts_model", "accounts");
	}

	public function index()
	{
		if($this->session->adminName)
		{
			redirect("admin", 'refresh');
		}
		elseif($this->session->userName)
		{
			redirect("user", 'refresh');
		}
		else
		{
			$this->load->view("login/signin_view");
		}
		
	}

	public function submit()
	{
		$arrRules = array(
			array(
				"field" => "txtUsername",
				"label" => "Username",
				"rules" => "required"
				),
			array(
				"field" => "txtPassword",
				"label" => "Password",
				"rules" => "required"
				)
			);
		$this->form_validation->set_rules($arrRules);
		if ($this->form_validation->run() == FALSE) 
		{
			$this->index();
		} 
		else
		{
			$userName = $this->input->post("txtUsername");
			$userPass = $this->input->post("txtPassword");
			$md5Pass = md5($userPass);
			$res = $this->login->authenticateUser($userName, $md5Pass);
			if (count($res) > 0) 
			{
				if($res->isAdmin == 1)
				{
					$this->session->set_userdata("adminId", $res->userId);
					$this->session->set_userdata("adminName", $userName);
					redirect('admin', 'refresh');
				}
				else
				{
					$this->session->set_userdata("userId", $res->userId);
					$this->session->set_userdata("userName", $userName);
					redirect('user', 'refresh');
				}
				
			} 
			else 
			{
				echo "<script> alert('No User Account Found!'); </script>";
				$this->index();
			}
		}
	}
}