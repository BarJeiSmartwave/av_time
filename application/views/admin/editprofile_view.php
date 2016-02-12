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
        <div class="row"><!-- Page Heading -->
            <div class="col-lg-12">
                <h1 class="page-header">
                    <?php echo $userDetails->firstName; ?> <small><?php echo $userDetails->lastName; ?></small>
                </h1>
                <!-- <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="<?php echo base_url('admin'); ?>">Admin</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-users"></i> Settings
                    </li>
                </ol> -->
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-6">
               <div class="panel panel-default">
                <div class="panel-heading">
                    <!-- <h3 class="panel-title"><i class="fa fa-image fa-fw"></i> Profile Picture </h3> -->
                    <a href="#" data-toggle="collapse" data-target="#profilePicture" style="color: #000000"><i class="fa fa-fw fa-image"></i> Profile Picture <i class="fa fa-fw fa-caret-down"></i></a>
                </div>
                <div class="panel-body collapse" id="profilePicture">
                   <?php
                   echo form_open_multipart('admin/saveProfilePicture');
                   ?>
                   <fieldset>
                       <table>
                        <tr>
                            <td>
                                <input type="file" name="userImage" size="30" />
                            </td>
                            <td>
                               <img src="<?php echo base_url('uploads/'.$userDetails->imageCode); ?>" alt="Profile Picture" width="200" height="200"> 
                           </td>
                       </tr>
                       <tr>
                        <td>
                            <?php
                            echo form_submit("btnSubmit", "Upload Picture", "class='btn btn-success'");
                            ?>
                            <?php 
                            echo form_close();
                            ?>
                        </td>
                        <td>

                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
    </div>
</div>

<div class="col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <!-- <h3 class="panel-title"><i class="fa fa-info fa-fw"></i> User Details </h3> -->
            <a href="#" data-toggle="collapse" data-target="#userDetails" style="color: #000000"><i class="fa fa-fw fa-info"></i> User Details <i class="fa fa-fw fa-caret-down"></i></a>
        </div>
        <div class="panel-body collapse" id="userDetails">
            <?php
            echo form_open("admin/saveUserDetails");
            ?>
            <fieldset>
                <?php
                $txtFname = array(
                    "name"=>"txtFirstName",
                    "id"=>"txtFirstName",
                    "class"=>"form-control",
                    "placeholder"=>"First Name",
                    "required"=>"required",
                    "value"=>$userDetails->firstName
                    );
                $txtLname = array(
                    "name"=>"txtLastName",
                    "id"=>"txtLastName",
                    "class"=>"form-control",
                    "placeholder"=>"Last Name",
                    "required"=>"required",
                    "value"=>$userDetails->lastName
                    );
                $txtContact = array(
                    "name"=>"txtContact",
                    "id"=>"txtContact",
                    "class"=>"form-control",
                    "placeholder"=>"Contact No.",
                    "value"=>$userDetails->contactNumber
                    );
                    ?>
                    <table class="table-condensed table-responsive">
                        <tr>                                     
                            <td> 
                                <div class="form-group">
                                    <?php
                                    echo form_label("First Name", "txtFirstName");
                                    echo form_input($txtFname, set_value($userDetails->firstName));
                                    ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <?php
                                    echo form_label("Last Name", "txtLastName");
                                    echo form_input($txtLname, set_value($userDetails->lastName));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <?php 
                                    echo form_label("Contact No.", "txtContact");
                                    echo form_input($txtContact, set_value($userDetails->contactNumber)); 
                                    ?>
                                </div>
                            </td>
                            <td>
                              <div class="form-group">
                                  <?php
                                  echo form_label("Email Address", "txtEmail");
                                  ?>
                                  <input type="email" id="txtEmail" name="txtEmail" class="form-control" placeholder="Email" value="<?php echo $userDetails->emailAddress;?>"required>
                              </div>
                          </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="form-group">
                            <?php
                            echo form_submit("btnSubmit", "Save Changes", "class='btn btn-success btn-block'");
                            ?>
                        </div> 
                    </td>
                    <td>
                        <div class="form-group">
                            <?php echo form_reset("btnReset", "Revert Changes", "class='btn btn-default btn-block'"); ?>
                        </div>
                    </td>                                           
                </tr>
            </table>
        </fieldset>
        <?php echo form_close(); ?>
    </div>
</div>
</div>
</div>
<!-- row 1 end -->
<!-- user details col -->
<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5 class="panel-title"><i class="fa fa-user fa-fw"></i> Account Details </h5>
                <!-- <a href="#" data-toggle="collapse" data-target="#accountDetails" style="color: #000000"><i class="fa fa-fw fa-user"></i> Account Details <i class="fa fa-fw fa-caret-down"></i></a> -->
            </div>
            <!-- <div class="panel-body collapse" id="accountDetails"> -->
            <div class="panel-body" id="accountDetails">
                <?php
                echo form_open("admin/saveAccountDetails");
                ?>
                <fieldset>
                    <?php
                    $txtUsername = array(
                        "name"=>"txtUsername",
                        "id"=>"txtUsername",
                        "class"=>"form-control",
                        "placeholder"=>"Username",
                        "required"=>"required",
                        "value"=>$userDetails->userName
                        );
                    $txtPassword = array(
                        "name"=>"txtPassword",
                        "id"=>"txtPassword",
                        "class"=>"form-control",
                        "placeholder"=>"Minimum of 8 characters",
                        "required"=>"required"
                        );
                        ?>
                        <table class="table-condensed table-responsive">
                            <tr>                                     
                                <td> 
                                    <div class="form-group">
                                        <?php

                                        echo form_label("New Username", "txtUsername");
                                        echo form_input($txtUsername, set_value($userDetails->userName));
                                        ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo form_label("New Password", "txtPassword");
                                        echo form_password($txtPassword);
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                  <div class="form-group">
                                    <?php
                                    echo form_submit("btnSubmit", "Save Changes", "class='btn btn-success btn-block'");
                                    ?>
                                </div> 
                            </td>
                            <td>
                                <div class="form-group">
                                    <?php echo form_reset("btnReset", "Revert Changes", "class='btn btn-default btn-block'"); ?>
                                </div>
                            </td>                                           
                        </tr>
                    </table>
                </fieldset>
            </div>
        </div>
    </div>
    <!-- col account details -->
   <!--  <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
               <a href="#" data-toggle="collapse" data-target="#changePassword" style="color: #000000"><i class="fa fa-fw fa-key"></i> Change Password <i class="fa fa-fw fa-caret-down"></i></a>
           </div>
           <div class="panel-body collapse" id="changePassword">
            <?php
            echo form_open("admin/changePassword");
            ?>
            <fieldset>
                <?php
                $txtOldPassword = array(
                    "name"=>"txtPassword",
                    "id"=>"txtPassword",
                    "class"=>"form-control",
                    "placeholder"=>"Minimum of 8 characters",
                    "required"=>"required"
                    );
                $txtNewPassword = array(
                    "name"=>"txtPassword",
                    "id"=>"txtPassword",
                    "class"=>"form-control",
                    "placeholder"=>"Minimum of 8 characters",
                    "required"=>"required"
                    );
                    ?>
                    <table class="table-condensed table-responsive">
                        <tr>                                     
                            <td> 
                                <div class="form-group">
                                    <?php

                                    echo form_label("Old Password", "txtOldPassword");
                                    echo form_password($txtOldPassword);
                                    ?>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <?php
                                    echo form_label("New Password", "txtNewPassword");
                                    echo form_password($txtNewPassword);
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                              <div class="form-group">
                                <?php
                                echo form_submit("btnSubmit", "Save Changes", "class='btn btn-success btn-block'");
                                ?>
                            </div> 
                        </td>
                        <td>
                            <div class="form-group">
                                <?php echo form_reset("btnReset", "Revert Changes", "class='btn btn-default btn-block'"); ?>
                            </div>
                        </td>                                           
                    </tr>
                </table>
            </fieldset>
        </div>
    </div>
</div> -->
<!-- col change password -->
</div>
<!-- end row -->
</div>
<!-- end page container-fluid -->
</div>
<!-- end page wrapper -->
