<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<div class="collapse navbar-collapse navbar-ex1-collapse">
  <ul class="nav navbar-nav side-nav">
    <li class="active">
      <a href="<?php echo base_url('admin'); ?>"><i class="fa fa-fw fa-dashboard"></i> Admin </a>
    </li>
    <li>
      <a href="<?php echo base_url('time'); ?>"><i class="fa fa-fw fa-clock-o"></i> Time Logs</a>
    </li>
    <li>
      <a href="<?php echo base_url('host'); ?>"><i class="fa fa-fw fa-server"></i> Network</a>
    </li>
    <li>
      <a href="#" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-users"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
      <ul id="demo" class="collapse">
        <li>
          <a href="<?php echo base_url('accounts/viewAdd'); ?>">Add</a>
        </li>
        <li>
          <a href="<?php echo base_url('accounts'); ?>">View</a>
        </li>
      </ul>
    </li>
    
  </ul>
</div>
<!-- /.navbar-collapse -->
</nav>
<div id="page-wrapper">
  <div class="container-fluid">
   <!-- Page Heading -->
   <div class="row">
    <div class="col-lg-7">
     <h1 class="page-header">
      <?php echo $userDetails->firstName; ?> <small><?php echo $userDetails->lastName; ?></small>
    </h1>
 			<!-- 	<ol class="breadcrumb">
 					<li>
 						<i class="fa fa-dashboard"></i>  <a href="<?php echo base_url('admin'); ?>">Admin</a>
 					</li>
 					<li class="active">
 						<i class="fa fa-user"></i> Profile
 					</li>
 				</ol> -->
 			</div>
      <div class="col-lg-5">
       <div>
        <div class="panel-heading">
         <div class="row">
          <div class="col-xs-3">
           <i class=""></i>
         </div>
         <div class="col-xs-9 text-right">
          <div class="huge">
           <span id="clock">&nbsp</span>
         </div>
         <div><?php echo date("D, j M Y"); ?></div>
       </div>
     </div>
   </div>
 </div>
</div>
<!-- clock -->
</div>
<!-- page heading -->
<?php
$imageUrl = '../../uploads/'.$userDetails->imageCode;
?>
<div class="row">
  <div class="col-lg-12">
   <div class="panel panel-default">
    <div class="panel-heading">
     <h3 class="panel-title"><i class="fa fa-user"></i> Admin Profile </h3>
   </div>
   <div class="panel-body">
     <div class="row">
       <!-- <div class="col-sm-2" style="width: 150px; height: 150px; background: url(<?php echo $imageUrl; ?>);"> -->
       <div class='col-sm-2'>
             <!-- <img src="<?php echo base_url('assets/images/rose.png'); ?>" alt="Profile Picture" width="150" height="150">
           -->
           <img src="<?php echo base_url('uploads/'.$userDetails->imageCode); ?>" alt="Profile Picture" width="150" height="150">
         </div>
         <!-- col picture -->
         <div class="col-sm-2">
           <fieldset>
            <h5 style='color: #2980b9;'><i class="fa fa-user"></i> Username</h5>
            <?php
            echo form_label($userDetails->userName, "class='sr-only'");
            ?>
            <h5 style='color: #2980b9;'><i class="fa fa-inbox"></i> Email</h5>
            <?php
            echo form_label($userDetails->emailAddress, "class='sr-only'");
            ?>
            <h5 style='color: #2980b9;'><i class="fa fa-mobile-phone"></i> Contact Number</h5>
            <?php
            echo form_label($userDetails->contactNumber, "class='sr-only'");
            ?>
            <h5 style='color: #2980b9;'><i class="fa fa-eye"></i> Status</h5>
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
           echo form_label($status, "class='sr-only'");
           ?>
           <h5 style='color: #2980b9;'><i class="fa fa-clock-o"></i> Total Hours</h5>
           <?php
           echo form_label($userDetails->totalHours, "class='sr-only'");
           ?>
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