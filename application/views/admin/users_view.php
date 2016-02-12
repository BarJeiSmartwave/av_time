<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<div class="collapse navbar-collapse navbar-ex1-collapse">
  <ul class="nav navbar-nav side-nav">
    <li>
      <a href="<?php echo base_url('admin'); ?>"><i class="fa fa-fw fa-dashboard"></i> Admin </a>
    </li>
    <li>
      <a href="<?php echo base_url('time/viewTimeLogs'); ?>"><i class="fa fa-fw fa-clock-o"></i> Time Logs</a>
    </li>
    <li>
      <a href="<?php echo base_url('host/viewHost'); ?>"><i class="fa fa-fw fa-server"></i> Server</a>
    </li>
    <li class="active">
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
    <div class="col-lg-12">
     <h1 class="page-header">
      Users 
      <small>View</small>
    </h1>
 				<!-- <ol class="breadcrumb">
 					<li>
 						<i class="fa fa-dashboard"></i>  <a href="<?php echo base_url('admin'); ?>">Admin</a>
 					</li>
 					<li class="active">
 						<i class="fa fa-users"></i> View
 					</li>
 				</ol> -->
 			</div>
 		</div>
 		<!-- page heading -->
 		<div class="row">
 			<div class="col-lg-12">
 				<div class="panel panel-default">
 					<div class="panel-heading">
 						<h3 class="panel-title"><i class="fa fa-table"></i> Personal Data Sheet</h3>
 					</div>
 					<div class="panel-body">
 						<div style="overflow-x:auto;">
 							<table class="table table-bordered table-hover" id="dataTable">
 								<thead>
 									<tr style="background-color: #ff4f73; color: #ffffff;">
 										<th id="timelog-th">#</th>
 										<th id="timelog-th">Name</th>
 										<th id="timelog-th">Username</th>
 										<th id="timelog-th">Contact #</th>
 										<th id="timelog-th">Email Address</th>
 										<th id="timelog-th">Status</th>
 										<!-- <th>Total Hours</th> -->
 									</tr>
 								</thead>
 								<tbody>
 									<?php
 									$anchorViewUser = array(
 										"data-toggle"=>"tooltip",
 										"data-placement"=>"right",
 										"title"=>"View Time Logs"
 										);

 									foreach ($usersData as $value) 
 									{
 										if($value->statusCode == 1)
 										{
 											$status = "<td style='color: green;' id='timelog-td'>Online</td>";
 										}
 										elseif($value->statusCode == 0)
 										{
 											$status = "<td style='color: red;' id='timelog-td'>Offline</td>";
 										}
 										elseif($value->statusCode == 2)
 										{
 											$status = "<td style='color: blue;' id='timelog-td'>Break</td>";
 										}
 									// <td>".$value->totalHours."</td>
 										// <td id='timelog-td'>".$value->firstName." ".$value->lastName."</td>
 										echo "<tr>
 										<td id='timelog-td'>".$value->userId."</td>
 										<td id='timelog-td'>".anchor("time/viewperuser/".$value->userId, $value->firstName." ".$value->lastName, $anchorViewUser)."</td>
 										<td id='timelog-td'>".$value->userName."</td>
 										<td id='timelog-td'>".$value->contactNumber."</td>
 										<td id='timelog-td'	>".$value->emailAddress."</td>
 										".$status."
 									</tr>";
 								}
 								?>
 							</tbody>
 						</table>
 					</div>
 					<!-- table overflow -->
 				</div>
 			</div>
 		</div>
 		<!-- col 1 -->
 	</div>
 	<!-- row 1 -->
 </div>
 <!-- container -->
</div>