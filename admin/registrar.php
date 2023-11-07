<?php
	error_reporting(0);
	session_start();
	include("include/session.php");
	$parentpage = "Account";
	$parentpage_link = "#";
	$currentpage = "Registrar";
	$page=$childpage = "registrar";
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
  <body>
  <?php include("include/sidebar.php"); ?>
  <!-- Main content -->
  <div class="main-content" id="panel">
    <?php
      include("include/topnav.php"); //Edit topnav on this page
      include("include/snackbar.php");
      include("include/breadcrumbs.php");
    ?><!-- Batas Header & Breadcrumbs -->
    <div class="col-md-4">
      <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-body p-0">
              <div class="card bg-blue border-0 mb-0">
                <div class="card-body px-lg-5 py-lg-5">
                  <div class="text-center form-control-label mb-4 text-white font-weight-bolder">
                    <span>Add New Registrar</span>
                  </div>
                  <form action='registrar_controller.php' role="form" method="post">
                    <div class="form-group mb-2">
                      <label class="form-control-label mb-0 text-white">Email Address</label>
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
                      <label class="form-control-label mb-0 text-white">Password</label>
                      <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                        </div>
						            <?php $password=generate_password();?>
                        <input class="form-control" type="password" id='password_default' name="password_default" placeholder="Password" value="<?php echo $password?>" readonly="readonly">
                      </div>
                      <small class="text-white">Default password:</small><small style="color:red;"> auto generated</small>
                    </div>
                    <div class="text-right">
									      <button type="reset" id="cancel-button" class="btn btn-primary my-4 sp-add bg-secondary text-primary font-weight-bolder" >Cancel</button>
                        <button type="submit" id="add" name="add" class="btn btn-primary my-4 sp-add bg-green text-primary font-weight-bolder" >Save</button>
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
                  <h3 class="mb-0 text-primary font-weight-bolder">Registrar</h3>
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
                    <th>Date Created</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Options</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>No.</th>
                    <th>Name</th>
                     <th>Date Created</th>
                     <th>Email</th>
                     <th>Status</th>
                     <th>Options</th>
                  </tr>
                </tfoot>
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
            `staff`.`created_on` AS `staff_created`
          FROM `user`
          INNER JOIN `staff` ON `staff`.`username` = `user`.`username`
          WHERE `user`.`type` ='registrar';
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
                          <img src="../registrar/img/<?php echo $userphoto; ?>" class="avatar rounded-circle mr-3">
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
						          <td>
                        <span class="text-muted">
						              <?php 
							              $created_on = isset($row['staff_created']) ? htmlspecialchars(created_on($row['staff_created']), ENT_QUOTES, 'UTF-8') : '';
						              	echo $created_on;
                           ?>
						            </span>
						          </td>
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
                        <?php $status = $row['user_status'];
                        if ($status > 0) {
                          echo '<span class="badge badge-success">Active</span>';
                        } else {
                          echo '<span class="badge badge-danger">Inactive</span>';
                        }
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
                            <a class="dropdown-item" href="registrar_controller.php?id=<?php echo $row['user_id'] ?>&off=0"><i class=" text-primary fas fa-lock" ></i> Deactivate Account</a>
                            <?php else : ?>
                              <a class="dropdown-item" href="registrar_controller.php?id=<?php echo $row['user_id'] ?>&on=1"><i class="text-primary  fas fa-lock-open" ></i>Activate Account</span></a>
                            <?php endif; ?>
                           
                            <a class="dropdown-item" href="registrar_controller.php?id=<?php echo $row['user_id'] ?>&del=delete" onClick="return confirm('Are you sure you want to clear, <?php echo htmlentities($row['user_username']); ?> ?')"><i class="fas fa-trash text-primary "></i> Delete Account</a>
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
			<?php
				include("include/footer.php");
			?>
			<script type="text/javascript">
				document.getElementById("close_direct").onclick = function() {
				  location.href = "faculty.php";
				};
			</script>
			<script>
				$('.select2').select2();
			</script>
			</div>
		</div>
	</body>
</html>
