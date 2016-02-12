<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">
                        <li class="active">
                            <a href="<?php echo base_url('user'); ?>"><i class="fa fa-fw fa-dashboard"></i> User </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('user/viewTimeLogs'); ?>"><i class="fa fa-fw fa-clock-o"></i> My Time Logs</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </nav>
 <div id="page-wrapper">
 	<div class="container-fluid">
 		<!-- Page Heading -->
 		<div class="row">
 			<div class="col-lg-12">
 				<h1 class="page-header">
 					<?php echo $userDetails->firstName; ?> <small><?php echo $userDetails->lastName; ?></small>
 				</h1>
 				<!-- <ol class="breadcrumb">
 					<li>
 						<i class="fa fa-dashboard"></i>  <a href="<?php echo base_url('user'); ?>">User</a>
 					</li>
 					<li class="active">
 						<i class="fa fa-user"></i> Profile
 					</li>
 				</ol> -->
 			</div>
 		</div>
 		<!-- page heading -->
 		<div class="row">
 			<div class="col-lg-12">
 				<div class="panel panel-default">
 					<div class="panel-heading">
 						<h3 class="panel-title"><i class="fa fa-user"></i> User Profile </h3>
 					</div>
 					<div class="panel-body">
 						<div class="row">
 							<div class="col-sm-2">
 								<img src="<?php echo base_url('uploads/'.$userDetails->imageCode); ?>" alt="Profile Picture" width="150" height="150">
 							</div>
 							<!-- col picture -->
 							<div class="col-sm-2">
 								<fieldset>
 									<h5>Username:</h5>
 									<?php
 									echo form_label($userDetails->userName, "class='sr-only'");
 									?>
 									<h5>Email:</h5>
 									<?php
 									echo form_label($userDetails->emailAddress, "class='sr-only'");
 									?>
 									<h5>Contact Number:</h5>
 									<?php
 									echo form_label($userDetails->contactNumber, "class='sr-only'");
 									?>
 									<h5>Status:</h5>
 									<?php
 									$statusCode = $userDetails->statusCode;
 									if($statusCode == 1)
 									{
 										$status = "Online";
 									}
 									elseif($statusCode == 2)
 									{

 										$status = "On break";
 									}
 									else
 									{
 										$status = "Offline";
 									}
 									echo form_label($status, "class='sr-only'");?>
 									<h5>Total Hours:</h5>
 									<?php
 									echo form_label($userDetails->totalHours, "class='sr-only'");?>
 								</fieldset>
 							</div>
 							<!-- col details -->
 						</div>
 					</div>
 				</div>
 			</div>
 			<!-- col 1 -->
 		</div>
 		<!-- row 1 -->
 	</div>
 	<!-- container -->
 </div>