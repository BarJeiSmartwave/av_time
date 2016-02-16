<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<div class="collapse navbar-collapse navbar-ex1-collapse">
  <ul class="nav navbar-nav side-nav">
    <li>
      <a href="<?php echo base_url('admin'); ?>"><i class="fa fa-fw fa-dashboard"></i> Admin </a>
    </li>
    <li class="active">
      <a href="<?php echo base_url('time/viewTimeLogs'); ?>"><i class="fa fa-fw fa-clock-o"></i> Time Logs</a>
    </li>
    <li>
      <a href="<?php echo base_url('host/viewHost'); ?>"><i class="fa fa-fw fa-server"></i> Network</a>
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
      Time Logs
      <small>Today</small>
    </h1>
 				<!-- <ol class="breadcrumb">
 					<li>
 						<i class="fa fa-dashboard"></i>  <a href="<?php echo base_url('admin'); ?>">Admin</a>
 					</li>
 					<li class="active">
 						<i class="fa fa-clock-o"></i> User Time Logs
 					</li>
 				</ol> -->
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
      <div class="col-lg-12">
       <div class="panel panel-default">
        <div class="panel-heading">
         <h3 class="panel-title"><i class="fa fa-table"></i> Attendance Sheet </h3>
       </div>
       <div class="panel-body">
         <div style="overflow-x:auto;">
          <table class="table table-bordered table-hover" id="timeLogTable">
           <thead>
            <tr id="timelog-tr">
             <th id="timelog-th">Log No.</th>
             <th id="timelog-th">NAME</th>
             <th id="timelog-th">DATE</th>
             <th id="timelog-th">TIME IN</th>
             <!-- <th id="timelog-th">BREAK</th> -->
             <th id="timelog-th">TIME OUT</th>
             <th id="timelog-th">LATE HOURS</th>
             <!-- <th>OVER TIME HOURS</th> -->
             <th id="timelog-th">TOTAL</th>
           </tr>
         </thead>
         <tbody>
          <?php
          $anchorViewUser = array(
           "data-toggle"=>"tooltip",
           "data-placement"=>"right",
           "title"=>"View Time Logs"
           );

          if(count($timeLogs) == 0)
          {
            echo '<td colspan="5"  id="timelog-td"> No time logs yet.</td>';
          }
          else
          {
           $logId = 0;

           foreach ($timeLogs as $value) 
           {
            $logId++;

            $logDate = date("M j", strtotime($value->logDate));
            $logInDate = date("g:i:s A", strtotime($value->logIn));

            if($value->logOut == "0000-00-00 00:00:00")
            {
              $logOutDate = "---";
            }
            else
            {
              $logOutDate = date("g:i:s A", strtotime($value->logOut));
            }
            if($value->breakTime == "0000-00-00 00:00:00")
            {
              $breakTime = "---";
            }
            else
            {
              $breakTime = date("g:i:s A", strtotime($value->breakTime));
            }
            if($value->lateHours == "00:00:00")
            {
              $lateHours = "---";
            }
            else
            {
              $lateHours = $value->lateHours;
            }
                  // <td>".$value->logId."</td>
                  // <td id='timelog-td'>".$breakTime."</td>
                  // <td>---</td>
            echo "<tr>
            <td id='timelog-td'>".$logId."</td>
            <td id='timelog-td'>".anchor("time/viewperuser/".$value->userId, $value->firstName." ".$value->lastName, $anchorViewUser)."</td>
            <td id='timelog-td'>".$logDate."</td>
            <td id='timelog-td'>".$logInDate."</td>
            <td id='timelog-td'>".$logOutDate."</td>
            <td id='timelog-td'>".$lateHours."</td>
            <td id='timelog-td'>".$value->logHours."</td>
          </tr>";
        }
      }
      ?> 
    </tbody>
  </table>
</div>
<!-- overflow div -->
<div>
 <?php 
 echo anchor("admin/exportToCsv/", "Export to CSV file.", "class='btn btn-primary'");
 ?>
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