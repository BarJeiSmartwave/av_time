 <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
 <div class="collapse navbar-collapse navbar-ex1-collapse">
  <ul class="nav navbar-nav side-nav">
    <li>
      <a href="<?php echo base_url('admin'); ?>"><i class="fa fa-fw fa-dashboard"></i> Admin </a>
    </li>
    <li>
      <a href="<?php echo base_url('time'); ?>"><i class="fa fa-fw fa-clock-o"></i> Time Logs</a>
    </li>
    <li class="active">
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
      Network 
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
<div class="col-lg-4">
  <div class="panel panel-default">
   <div class="panel-heading">
     <h3 class="panel-title"><i class="fa fa-fw fa-signal"></i> Current Network </h3>
   </div>
   <div class="panel-body">
            <!-- <a href="#" data-toggle="collapse" data-target="#detectedHost" style="color: #000000"> Detected <i class="fa fa-fw fa-caret-down"></i></a>
          </div> -->
          <div class="panel-body" id="detectedHost">
            <?php
            echo form_open("host/saveip");
            ?>
            <div style="overflow-x:auto;">
              <fieldset>
                <table class="table">
                  <tr >
                    <th style="border: none;">
                      Host name:
                    </th>
                    <td style="border: none;">
                      <?php echo $ipDetails['hostname']; ?>
                    </td>
                  </tr>
                  <tr>
                    <th style="border: none;">
                      IP Address:
                    </th>
                    <td style="border: none;">
                      <?php echo $ipDetails['ipAddress']; ?>
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
                  "class"=>"btn btn-primary btn-block"
                  );
                echo form_submit($btnSaveIp);
                ?>
              </fieldset>
            </div>
            <?php
            echo form_close();
            ?>
          </div>
        </div>
      </div>
    </div>
    <!-- col 2 -->
    <div class="col-lg-4">
     <div class="panel panel-default">
      <div class="panel-heading">
       <h3 class="panel-title"><i class="fa fa-fw fa-star"></i> Valid List </h3>
     </div>
     <div class="panel-body">
      <div style="overflow-x:auto;">
        <table class="table table-striped table-bordered table-hover" id="ipTable">
          <thead>
            <tr class="info">
              <th id='ip-th'>Host name</th>
              <th id='ip-th'>Description</th>
              <th id='ip-th'>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php

            if(count($validIp) == 0)
            {
             echo "<tr>
             <td colspan='3'>No records yet.</td>
           </tr>";
         }
         else
         {
          $loop = 0;
          foreach($validIp as $value)
          {
            $loop++;
            $removeIp = [
            "id"=>"removeIp",
            "class"=>"fa fa-fw fa-remove",
            "style"=>"color: orange;",
            "data-toggle"=>"tooltip",
            "data-placement"=>"bottom",
            "title"=>"Remove"
            ];
            echo "<tr>
            <td>".$value["ipHostName"]."</td>
            <td>".$value["ipDescription"]."</td>
            <td>".anchor('host/removeIp/'.$value["ipId"], " ", $removeIp)."</td>
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
<!-- col 1 -->
<div class="row">
  <div class="col-lg-4">
   <div class="panel panel-default">
    <div class="panel-heading">
     <h3 class="panel-title"><i class='fa fa-fw fa-warning'></i> Invalid List </h3>
   </div>
   <div class="panel-body">
    <div style="overflow-x:auto;">
      <table class="table table-striped table-bordered table-hover" id="ipTable">
        <thead>
          <tr class="info">
            <th id='ip-th'>Host name</th>
            <th id='ip-th'>Description</th>
            <th id='ip-th'>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php

          if(count($invalidIp) == 0)
          {
           echo "<tr>
           <td colspan='3'>No records yet.</td>
         </tr>";
       }
       else
       {
        $loop = 0;
        foreach($invalidIp as $value)
        {
          $loop++;
          $deleteIp = [
          "id"=>"deleteIp",
          "class"=>"fa fa-fw fa-trash",
          "style"=>"color: red;",
          "data-toggle"=>"tooltip",
          "data-placement"=>"bottom",
          "title"=>"Delete"
          ];
          $setValid = [
          "id"=>"setValid",
          "class"=>"fa fa-fw fa-check",
          "style"=>"color: green;",
          "data-toggle"=>"tooltip",
          "data-placement"=>"bottom",
          "title"=>"Set as valid network"
          ];
          echo "<tr>
          <td>".$value["ipHostName"]."</td>
          <td>".$value["ipDescription"]."</td>
          <td>".anchor('host/setValid/'.$value["ipId"], " ", $setValid)."
           ".anchor('host/deleteIp/'.$value["ipId"], " ", $deleteIp)."</td>
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
</div>
<!-- row ip-->
</div>
<!-- container -->
</div>