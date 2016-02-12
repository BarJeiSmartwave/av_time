<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
        <li>
            <a href="<?php echo base_url('admin'); ?>"><i class="fa fa-fw fa-dashboard"></i> Admin </a>
        </li>
        <li>
            <a href="<?php echo base_url('time/viewTimeLogs'); ?>"><i class="fa fa-fw fa-clock-o"></i> Time Logs</a>
        </li>
        <li class="active">
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
        <div class="col-lg-12">
           <h1 class="page-header">
              Server 
              <!-- <small>Host names</small> -->
          </h1>
 			<!-- 	<ol class="breadcrumb">
 					<li>
 						<i class="fa fa-dashboard"></i>  <a href="<?php echo base_url('admin'); ?>">Admin</a>
 					</li>
 					<li class="active">
 						<i class="fa fa-server"></i> Server
 					</li>
 				</ol> -->
 			</div>
 		</div>
 		<!-- page heading -->
 		<div class="row">
 			<div class="col-lg-6">
 				<div class="panel panel-default">
 					<div class="panel-heading">
 						<h3 class="panel-title"><i class="fa fa-server"></i> Active Host </h3>
 					</div>
 					<div class="panel-body">
 						<?php
 						if(count($ipDetails) == 0)
 						{
 							echo "<h3>No Active Host.</h3>";
 						}
 						else
 						{
 							$unsetIp = array(
 								"class"=>"btn btn-danger",
 								);
 							
 								?>
 								<table class="table">
 									<tr >
 										<th style="border: none;">
 											Host name:
 										</th>
 										<td style="border: none;">
 											<?php echo $ipDetails->ipHostName; ?>
 										</td>
 									</tr>
 									<tr>
 										<th style="border: none;">
 											IP Address:
 										</th>
 										<td style="border: none;">
 											<?php 
 											$ipNumber = long2ip($ipDetails->ipValue); 
 											echo $ipNumber;
 											?>
 										</td>
 									</tr>
 									<tr>
 										<th style="border: none;">
 											Description:
 										</th>
 										<td style="border: none;">
 											<?php echo $ipDetails->ipDescription; ?>
 										</td>
 									</tr>
 								</table>
 								<?php
 								echo anchor("host/unsetIp/".$ipDetails->ipHostName, "Deactivate", $unsetIp);
 							}
 							?>
 						</div>
 					</div>
 				</div>
 				<!-- col 1 -->
 				<div class="col-lg-6">
 					<div class="panel panel-default">
 						<div class="panel-heading">
 						<!-- <h3 class="panel-title"><i class="fa fa-server"></i> Detected Host </h3>
 					</div>
 					<div class="panel-body"> -->
 						<a href="#" data-toggle="collapse" data-target="#detectedHost" style="color: #000000"><i class="fa fa-fw fa-server"></i> Detected Host <i class="fa fa-fw fa-caret-down"></i></a>
 					</div>
 					<div class="panel-body collapse" id="detectedHost">
 						<?php
 						echo form_open("host/saveip");
 						?>
 						<table class="table">
 							<tr >
 								<th style="border: none;">
 									Host name:
 								</th>
 								<td style="border: none;">
 									<?php echo $hostname; ?>
 								</td>
 							</tr>
 							<tr>
 								<th style="border: none;">
 									IP Address:
 								</th>
 								<td style="border: none;">
 									<?php echo $ipAddress; ?>
 								</td>
 							</tr>
 							<tr>
 								<th style="border: none;">
 									Description:
 								</th>
 								<td style="border: none;">
 									<?php
 									$txtDescription = array(
 										"name"=>"txtDescription",
 										"id"=>"txtDescription",
 										"class"=>"form-control",
 										"required"=>"required"
 										);
 									echo form_input($txtDescription);
 									?>
 								</td>
 							</tr>
 						</table>

 						<?php
 						$btnSaveIp = array(
 							"id"=>"btnSaveIp",
 							"name"=>"btnSaveIp",
 							"value"=>"Save to Database",
 							"class"=>"btn btn-primary"
 							);
 						echo form_submit($btnSaveIp);
 						echo form_close();
 						?>
 					</div>
 				</div>
 			</div>
 			<!-- col 2 -->
 		</div>
 		<!-- row IP-->
 		<div class="row">
 			<div class="col-lg-12">
 				<div class="panel panel-default">
 					<div class="panel-heading">
 						<h3 class="panel-title"><i class="fa fa-server"></i> Available Hosts </h3>
 					</div>
 					<div class="panel-body">
 						<div style="overflow-x:auto;">
 							<table class="table table-striped table-bordered table-hover" id="ipTable">
 								<thead>
 									<tr class="info">
 										<th id='ip-th'>Host name</th>
 										<th id='ip-th'>Description</th>
 									</tr>
 								</thead>
 								<tbody>
 									<?php
 									if(count($results) <= 0)
 									{
 										echo "<tr>
 										<td>No records yet.</td>
 										<td></td>
 									</tr>";
 								}
 								else
 								{
 									foreach($results as $value)
 									{
 										$anchorActivateIP = array(
 											"data-toggle"=>"tooltip",
 											"data-placement"=>"right",
 											"title"=>"Set as Server Host"
 											);
 										echo "<tr>
 										<td>".anchor("host/activateIp/".$value->ipId, $value->ipHostName, $anchorActivateIP)."</td>
 										<td>".$value->ipDescription."</td>
 									</tr>";
 								}
 							}
 							?>
 						</tbody>
 					</table>
 					<!-- /.table-responsive -->
 				</div>
 				<!-- table overflow -->
 			</div>
 		</div>
 	</div>
 	<!-- row ip table-->
 </div>
</div>
<!-- container -->
</div>