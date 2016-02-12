<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<div class="collapse navbar-collapse navbar-ex1-collapse">
  <ul class="nav navbar-nav side-nav">
    <li>
      <a href="<?php echo base_url('user'); ?>"><i class="fa fa-fw fa-dashboard"></i> User </a>
    </li>
    <li class="active">
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
    <div class="col-lg-8">
     <h1 class="page-header">
      My Time Logs
      <!-- <small>Time Logs</small> -->
    </h1>
 				<!-- <ol class="breadcrumb">
 					<li>
 						<i class="fa fa-dashboard"></i>  <a href="<?php echo base_url('user'); ?>">User</a>
 					</li>
 					<li class="active">
 						<i class="fa fa-clock-o"></i> Time Logs
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
             <!-- <th>Log No.</th> -->
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
          foreach ($timeLogs as $value) 
          {
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
          <td id='timelog-td'>".$logDate."</td>
          <td id='timelog-td'>".$logInDate."</td>
          <td id='timelog-td'>".$logOutDate."</td>
          <td id='timelog-td'>".$lateHours."</td>
          <td id='timelog-td'>".$value->logHours."</td>
        </tr>";
      }
      ?>
    </tbody>
    <tfoot>
     <?php
     foreach ($timeLogsPeriod as $value) {
 										// <th colspan='4' id='timelog-td' style='color: red'>".$value->monthYear."</th>
      echo "
      <tr>
       <th colspan='3' id='timelog-td' style='color: red'>TOTAL:</th>
       <th id='timelog-td' style='color: red'>".$value->totalLateHours."</th>
       <th id='timelog-td' style='color: red'>".$value->totalHoursPeriod."</th>
     </tr>";
   }
   ?>
 </tfoot>
</table>
</div>
<!-- overflow table -->
 					<!-- <div>
 						<?php 
 						$sessionUserId = $this->session->userId;
 						echo anchor("user/exportToCsv/".$sessionUserId, "Export to CSV file.", "class='btn btn-warning'");
 						?>
 					</div> -->
 				</div>
 			</div>
 		</div>
 		<!-- col 1 -->
 	</div>
 	<!-- row 1 -->
 </div>
 <!-- container -->
</div>