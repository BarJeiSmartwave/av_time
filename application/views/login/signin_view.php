<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>AV Time | Log In</title>
	<link rel="icon" href="<?php echo base_url('assets/images/av_icon.ico'); ?>">
	<!-- maxcdn bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<!-- Bootstrap Core CSS -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
	<!-- maxcdn font awesome -->
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- Custom Fonts -->
	<link href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">

	<style>
		.form-signin
		{
			position: 0;
			max-width: 330px;
			margin: 0 auto;
		}
	</style>
</head>
<body>

	<div class="container" style="margin-top: 10%">
		<?php
		$styleForm = array(
			"class"=>"form-signin",
			"id"=>"frmLogin"
			);
		echo form_open("Login/submit", $styleForm);
		?>
		<div class="panel panel-default" style="border-color: #080808;">
			<legend class="panel-heading" style="font-size: 25px; background-color: #101010; color: #9d9d9d;">
				<i class="fa fa-spin fa-clock-o"></i> AppVenture Time
			</legend>
			<fieldset class="panel-body">
				<?php
				$txtUsername = array(
					"name"=>"txtUsername",
					"id"=>"txtUsername",
					"class"=>"form-control",
					"placeholder"=>"Username",
					"autofocus"=>"autofocus"
					);
				$txtPassword = array(
					"name"=>"txtPassword",
					"id"=>"txtPassword",
					"class"=>"form-control",
					"placeholder"=>"Password"
					);
						// echo form_label("Username","txtUsername", "class='sr-only'");?>
						<div class="input-group margin-bottom-sm" style="margin-bottom: 5%;">
							<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
							<div class="form-group">
								<?php
								echo form_input($txtUsername, set_value("txtUsername"));
								?>
							</div>
						</div>
						<?php
						echo form_error("txtUsername");
						// echo form_label("Password", "txtPassword", "class='sr-only'");
						?>
						<div class="input-group" style="margin-bottom: 5%;">
							<span class="input-group-addon" data-toggle="tooltip" data-placement="bottom" title="Minimum of 8 characters"><i class="fa fa-key fa-fw"></i></span>
							<div class="form-group">
								<?php
								echo form_password($txtPassword);
								?>
							</div>
						</div>
						<?php
						echo form_error("txtPassword");
						?>
						<div class="btn-group" style="float: right; margin-top: 5%;">
							<?php
							$submit = array(
								"id"=>"btnLogin",
								"name"=>"btnLogin",
								"value"=>"Log In",
								"class"=>"btn btn-primary"
								);
							echo form_submit($submit);
							?>
							<?php 
							$btnReset = array(
								"class"=>"btn btn-default",
								"value"=>"Reset"
								);
							echo form_reset($btnReset); 
							?>
						</div>
					</fieldset>
				</div>
				<?php echo form_close(); ?>
			</div>
		</body>
		<!-- jQuery -->
		<script src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>
		<!-- Bootstrap Core JavaScript -->
		<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script>
			$(function(){
				$('[data-toggle="tooltip"]').tooltip();
			});
		</script>
		</html>