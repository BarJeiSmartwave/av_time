<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<div class="collapse navbar-collapse navbar-ex1-collapse">
  <ul class="nav navbar-nav side-nav">
    <li class="active">
      <a href="<?php echo base_url('admin'); ?>"><i class="fa fa-fw fa-dashboard"></i> Admin </a>
    </li>
    <li>
      <a href="<?php echo base_url('time/viewTimeLogs'); ?>"><i class="fa fa-fw fa-clock-o"></i> Time Logs</a>
    </li>
    <li>
      <a href="<?php echo base_url('host/viewHost'); ?>"><i class="fa fa-fw fa-server"></i> Server</a>
    </li>
    <li>
      <a href="#" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-users"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
      <ul id="demo" class="collapse">
        <li>
          <a href="<?php echo base_url('accounts/viewAdd'); ?>">Add</a>
        </li>
        <li>
          <a href="<?php echo base_url('accounts/viewUsers'); ?>">View</a>
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
    <div class="col-lg-8">
     <h1 class="page-header">
      AppVenture <small></small>
    </h1>
  </div>
  <div class="col-lg-4">
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

<div class="row">
  
  <?php 
  $timeInUrl = base_url("admin/timeIn");
  $timeOutUrl = base_url("admin/timeOut");
  $goToBreakUrl = base_url("admin/goToBreak");
  $endBreakUrl = base_url("admin/endBreak");

  $timeIn = '<div class="col-lg-4">

  <div class="panel panel-green">
   <div class="panel-heading">
    <div class="row">
     <div class="col-xs-3">
      <i class="fa fa-sign-in fa-5x"></i>
    </div>
    <div class="col-xs-9 text-right">
      <div class="huge">'.$onLine.'</div>
      <div>Online Users</div>
    </a>
  </div>
</div>
</div>
<a href="'.$timeInUrl.'" id="timeIn">
 <div class="panel-footer">
  <span class="pull-left">Time In</span>
  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
  <div class="clearfix"></div>
</div>
</a>
</div>
</div>';

$timeOut = '<div class="col-lg-4">
<div class="panel panel-red">
 <div class="panel-heading">
  <div class="row">
   <div class="col-xs-3">
    <i class="fa fa-sign-out fa-5x"></i>
  </div>
  <div class="col-xs-9 text-right">
    <div class="huge">'.$offLine.'</div>
    <div>Offline Users</div>
  </div>
</div>
</div>
<a href="'.$timeOutUrl.'" id="timeOut">
  <div class="panel-footer">
   <span class="pull-left">Time Out</span>
   <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
   <div class="clearfix"></div>
 </div>
</a>
</div>
</div>';

$goToBreak = '<div class="col-lg-4">
<div class="panel panel-primary">
  <div class="panel-heading">
   <div class="row">
    <div class="col-xs-3">
     <i class="fa fa-spoon fa-5x"></i>
   </div>
   <div class="col-xs-9 text-right">
     <div class="huge">'.$onLunch.'</div>
     <div>Users on Break</div>
   </div>
 </div>
</div>
<a href="'.$goToBreakUrl.'" id="goToBreak">
 <div class="panel-footer">
  <span class="pull-left">Break</span>
  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
  <div class="clearfix"></div>
</div>
</a>
</div>
</div>';

$endBreak = '<div class="col-lg-4">
<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="row">
			<div class="col-xs-3">
				<i class="fa fa-spoon fa-5x"></i>
			</div>
			<div class="col-xs-9 text-right">
				<div class="huge">'.$onLunch.'</div>
				<div>Users on Break</div>
			</div>
		</div>
	</div>
	<a href="'.$endBreakUrl.'" id="endBreak">
		<div class="panel-footer">
			<span class="pull-left">End Break</span>
			<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
			<div class="clearfix"></div>
		</div>
	</a>
</div>
</div>';
if($statusCode == 0)
{
	echo $timeIn;
}
elseif($statusCode == 1)
{
	echo $timeOut;
	echo $goToBreak;
}
elseif($statusCode == 2)
{
	echo $endBreak;
}
?>
</div>
<!-- row -->
</div>
<!-- container -->
</div>