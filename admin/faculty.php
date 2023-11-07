  <?php
    error_reporting(0);
    session_start();
    include("include/session.php");
    $parentpage = "Account";
    $parentpage_link = "#";
    $currentpage = "Faculty";
    $page=$childpage = "faculty";
    $content_right='<a type="button" data-toggle="modal" data-target="#modal-form" class="btn btn-round btn-icon bg-green text-primary" >
                      <span class="btn-inner--icon text-primary font-weight-bolder"><i class="fas fa-plus"></i></span>
                      <span class="btn-inner--text text-primary font-weight-bolder"> New</span>
                    </a>';
  include("include/header.php");
  ?>
  <script>
    function userAvailability() {
      $("#loaderIcon").show();
      jQuery.ajax({
        url: "add_admin_check_username.php",
        data: 'username=' + $("#username").val(),
        type: "POST",
        success: function(data) {
          $("#user-availability-status1").html(data);
          $("#loaderIcon").hide();
        },
        error: function() {}
      });
    }
  </script>
  </head>
  <?php include("include/sidebar.php"); ?>
      <div class="main-content" id="panel">
        <?php
          include("include/topnav.php");
          include("include/snackbar.php");
          include "include/breadcrumbs.php";
        ?><!-- Batas Header & Breadcrumbs -->
        <div class="col-md-4">
          <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
            <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
              <div class="modal-content">
                <div class="modal-body p-0">
                  <div class="card bg-blue border-0 mb-0">
                    <div class="card-body px-lg-5 py-lg-5">
                      <div class="text-center form-control-label mb-4  text-white font-weight-bolder">
                        <span>Add New Faculty</span>
                      </div>
                      <form action='faculty_controller.php' role="form" method="post">
                        <div class="form-group mb-2">
                          <label class="form-control-label mb-0  text-white">Email Address</label>
                          <div class="input-group input-group-merge input-group-alternative">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                            </div>
                            <input onBlur="userAvailability()" id="username" name="username" class="form-control" placeholder="Enter Email" type="email" title="New Scholarship Provider" oninvalid="this.setCustomValidity('Please enter the new email.')" oninput="setCustomValidity('')" required>
                            <div class="input-group-append">
                              <span class="input-group-text" id="user-availability-status1"></span>
                            </div>
                          </div>
                          <span id="user-availability-status1"></span>
                        </div>
                        <div class="form-group mb-2">
                          <label class="form-control-label mb-0  text-white">Position</label>
                          <div class="input-group input-group-merge input-group-alternative">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-building"></i></span>
                            </div>
                            <select class="form-control" name="position" id="position" placeholder="Select Position" title="Enter Position" oninvalid="this.setCustomValidity('Please enter a position.')" oninput="setCustomValidity('')" required>
                              <option value="" selected>Select Position</option>
                              <option value="2" selected>Course Coordinator</option>
                              <option value="3" selected>Teacher/Insturctor</option>
                              <img src="../assets/img/loading.gif" width="35" id="load1" style="display:none;" />
                            </select>
                            <div class="input-group-prepend">
                              <span class="input-group-text" data-toggle="tooltip" data-placement="top" title="Please enter a position."><i class="fas fa-question-circle"></i></span>
                            </div>
                          </div>
                        </div>

                        <div class="form-group mb-2">
                          <label class="form-control-label mb-0  text-white">Institute</label>
                          <div class="input-group input-group-merge input-group-alternative">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-building"></i></span>
                            </div>
                            <select class="form-control" name="institute" id="institute" placeholder="Select Institute" title="Enter Institute" oninvalid="this.setCustomValidity('Please enter a position.')" oninput="setCustomValidity('')" required>
                              <option value="" selected>Select Institute</option>
                              <?php
                                try{
                                  $query="SELECT * FROM `institute`";
                                  $stmt = $con->prepare($query);
                                  $stmt->execute();
                                  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                }catch(Exception $e){
                                    $_SESSION['error']='Something went wrong accessing institute.';
                                }
                                foreach ($result as $row) {
                                  echo"<option value=".$row['id'].">".$row['name']."</option>";
                                }
                              ?>
                              <img src="../assets/img/loading.gif" width="35" id="load1" style="display:none;" />
                            </select>
                            <div class="input-group-prepend">
                              <span class="input-group-text" data-toggle="tooltip" data-placement="top" title="Please enter an institute."><i class="fas fa-question-circle"></i></span>
                            </div>
                          </div>
                        </div>

                        <div class="form-group mb-2">
                          <label class="form-control-label mb-0 text-white">Password</label>
                          <div class="input-group input-group-merge input-group-alternative">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                            </div>
                            <?php $password=generate_password();?>
                            <input class="form-control" type="password" id='password_default' name="password_default" placeholder="Password" value="<?php echo $password?>" readonly="readonly">
                          </div>
                          <small class=" text-white">Default password:</small><small style="color:red;"> auto generated</small>
                        </div>
                        <div class="text-right">
                            <button type="reset" id="cancel-button" class="btn btn-primary my-4 sp-add bg-secondary text-primary font-weight-bolder" >Cancel</button>
                            <button type="submit" id="add" name="add" class="btn btn-primary my-4 sp-add bg-green text-primary font-weight-bolder" >
                              <svg class="text-primary"xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V173.3c0-17-6.7-33.3-18.7-45.3L352 50.7C340 38.7 323.7 32 306.7 32H64zm0 96c0-17.7 14.3-32 32-32H288c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V128zM224 288a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg>
                              Save
                            </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header">
			        <div class="row">
                <div class="col-6">
						     <h3 class="mb-0 text-primary font-weight-bolder">Faculty</h3>
						    </div>
                <div class="col-6 text-right">
                </div>
					    </div>
            </div>
            <!-- Light table -->
            <div class="table-responsive py-4">
              <table class="table align-items-center table-flush table-striped" id="datatable-buttons">
                <thead class="thead-light">
                  <tr>
                    <th>No.</th>
					          <th>Name</th>
                    <th>Email</th>
                    <th>Institute</th>
                    <th>Position</th>
                    <th>Status</th>
                    <th>Options</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    try{
                    $query = 
                    "SELECT 
                      `user`.`id` AS `user_id`,
                      `user`.`firstname` AS `user_fname`,
                      `user`.`lastname` AS `user_lname`,
                      `user`.`username` AS `user_username`,
                      `user`.`profileImage` AS `user_image`,
                      `user`.`isPasswordChanged` AS `pass_changed`,
                      `user`.`status` AS `user_status`,
                      `staff`.`id` AS `staff_id`,
                      `staff`.`institute_id` AS `staff_institute`,
                      `staff`.`position_id` AS `staff_position`,
                      `staff`.`created_on` AS `staff_created`,
                      `position`.`id` AS `position_id`,
                      `position`.`position_name` AS `position_name`,
                      `position`.`description` AS `position_description`,
                      `institute`.`name` AS `institute_name`
                    FROM `user`
                    INNER JOIN `staff` ON `staff`.`username` = `user`.`username`
                    INNER JOIN `position` ON `position`.`id` = `staff`.`position_id`
                    INNER JOIN `institute` ON `institute`.`id`=`staff`.`institute_id`
                    WHERE `user`.`type` ='faculty';
                    ";
                    $stmt = $con->prepare($query);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }catch(Exception $e){
                      $_SESSION['error']='Something went wrong accessing scholarship providers.';
                    }
                    $cnt=0;
                    foreach ($result as $row) {
                        $cnt++;
                            ?>
                              <tr>
                                <td class="text-muted"><?php echo ''.$cnt;?></td>
                                <td class="table-user">
                                  <?php
                                    $userphoto = isset($row['user_image']) ? htmlspecialchars($row['user_image'], ENT_QUOTES, 'UTF-8') : '';
                                    if ($userphoto == "" || $userphoto == "NULL") :
                                  ?>
                                  <img src="img/profile.png" class="avatar rounded-circle mr-3">
                                  <?php else : ?>
                                    <img src="../faculty/img/<?php echo $userphoto; ?>" class="avatar rounded-circle mr-3">
                                  <?php endif; ?>
                                  <b>
                                  <?php 
                                    $firstname = isset($row['user_fname']) ? htmlspecialchars($row['user_fname'], ENT_QUOTES, 'UTF-8') : '';
                                    $lastname = isset($row['user_lname']) ? htmlspecialchars($row['user_lname'], ENT_QUOTES, 'UTF-8') : '';
                                    $name=short_text($firstname.' '.$lastname);
                                  echo $name;
                                    ?>
                                  </b>
                                </td>
                                <!--<td>
                                  <span class="text-muted">
                                    <?php 
                                      $created_on = isset($row['staff_created']) ? htmlspecialchars(created_on($row['staff_created']), ENT_QUOTES, 'UTF-8') : '';
                                      echo $created_on;
                                    ?>
                                  </span>
                                </td> -->
                                <td>
                                  <a href="mailto:<?php 
                                    $username= isset($row['user_username']) ? htmlspecialchars($row['user_username'], ENT_QUOTES, 'UTF-8') : '';
                                    echo $username; ?>" class="font-weight-bold"><?php 
                                    $username =short_text($username);
                                    echo $username;
                                    ?>
                                  </a>
                                </td>
                                <td>
                                  <?php 
                                    $sp= isset($row['institute_name']) ? htmlspecialchars(short_text($row['institute_name']), ENT_QUOTES, 'UTF-8') : '';
                                    echo $sp;
                                  ?>
                                </td>
                                <td>
                                  <?php 
                                    $position= isset($row['position_description']) ? htmlspecialchars(short_text($row['position_description']), ENT_QUOTES, 'UTF-8') : '';
                                    //$position = $row['position_name'];
                                    echo $position;
                                  ?>
                                </td>
                                <td>
                                  <?php 
                                    $status = $row['user_status'];
                                    if ($status > 0) echo '<span class="badge badge-success">Active</span>';
                                    else  echo '<span class="badge badge-danger">Inactive</span>';
                                  ?>
                                </td>
                                <td class="text-right">
                                  <div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only bg-light rounded-circle shadow text-primary" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                      <?php $status = $row['user_status'];
                                        if ($status > 0) :
                                      ?>
                                      <a class="dropdown-item" href="faculty_controller.php?id=<?php echo $row['user_id'] ?>&off=0"><i class="fas fa-lock text-primary " ></i> Deactivate Account</a>
                                      <?php else : ?>
                                        <a class="dropdown-item" href="faculty_controller.php?id=<?php echo $row['user_id'] ?>&on=1"><i class="fas fa-lock-open text-primary "></i>Activate Account</span></a>
                                      <?php endif; ?>
                                    
                                      <!--<a class="dropdown-item" href="faculty_controller.php?id=<?php //echo $row['user_id'] ?>&del=delete" onClick="return confirm('Are you sure you want to clear, <?php //echo htmlentities($row['user_username']); ?> ?')"><i class="fas fa-trash" style="color:#f5365c;"></i> Delete Account</a>-->
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            <?php
                      } 
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
			  <?php include("include/footer.php"); ?>
			</div>
		</div>
	</body>
</html>
