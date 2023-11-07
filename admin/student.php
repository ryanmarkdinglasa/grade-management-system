  <?php
    session_start();
    include("include/session.php");
    $parentpage = "Account";
    $parentpage_link= "#";
    $currentpage='Student';
    $childpage = "student";
    include("include/header.php");
    $content_right='';
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
      ?>
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header border-0">
              <div class="row">
                <div class="col-6">
                  <h3 class="mb-0">Students</h3>
                </div>
                <div class="col-6 text-right">
                </div>
              </div>
            </div>
            <div class="table-responsive">
               <table class="table align-items-center table-flush table-striped" id="datatable-buttons">
                <thead class="thead-light">
                  <tr>
                    <th>No.</th>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Contact No.</th>
					          <th>Date Registered</th>
                    <th>Status</th>
                    <th>Option</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    try{
                      $sql = "SELECT 
                                  `student`.*, 
                                  `user`.`id` AS `user_id`,
                                  `user`.`status` AS `user_status`
                              FROM 
                                  `student`
                              INNER JOIN 
                                  `user` ON `user`.`username` = `student`.`username`
                        ";
                      $query = $con->query($sql);
                      $cnt = 1;
                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                    <tr>
                      <td>
                          <label class="text-muted"><?php echo $cnt;?></label>
                      </td>
                      <td class="table-user">
                        <?php 
                          $userphoto = isset($row['picture']) ? htmlspecialchars(($row['picture']), ENT_QUOTES, 'UTF-8') : '';
                          $userphoto = $row['picture'];
                          if ($userphoto == "" || $userphoto == "NULL") :
                          ?>
                          <img src="img/profile.png" class="avatar rounded-circle mr-3">
                          <?php else : ?>
                          <img src="../registrar/img/<?php echo $userphoto; ?>" class="avatar rounded-circle mr-3">
                          <?php endif; ?>
                          <b>
                          <?php 
                            $firstCharacter =(!empty($row['middlename']))?substr($row['middlename'], 0, 1):'';
                            $fname=(empty($row['lastname'])||$row['lastname']==NULL)?'None':$row['lastname'];
                            $lname=(empty($row['lastname'])||$row['lastname']==NULL)?'None':$row['lastname'];
                            $name =  $lname.', '. $fname.' '.$firstCharacter.'.';
                            if (!$name == "" || !$name == "NULL") {
                              $username_short = htmlentities($name);
                              if (strlen($username_short) > 30) $username_short = substr($username_short, 0, 30) . "...";
                              echo $username_short;
                            }
                        ?>
											  </b>
                      </td>
                     
                      <td>
                        <a href="mailto:<?php 
                            $email=(empty($row['username']) || $row['username']==NULL)?'':$row['username'];
                            $username = isset($email) ? htmlspecialchars(($email), ENT_QUOTES, 'UTF-8') : '';
                            echo $username;?>" class="font-weight-bold">
                          <?php 
                            $username=short_text($username);
                            echo $username;
                          ?>
                        </a>
                      </td>
                      <td>
                        <?php
                          $contact_no=(empty($row['contact_no']) ||$row['contact_no']==NULL)?'':$row['contact_no'];
                        ?>
                        <a href="tel:<?php echo htmlentities($contact_no); ?>" class="font-weight-bold"><?php echo htmlentities($contact_no); ?></a>
                      </td>
					            <td>
                        <span class="text-muted">
                          <?php
                            $date=(empty($row['created_on']) ||$row['created_on']==NULL)?'':$row['created_on'];
                            $created_on = isset( $date) ? htmlspecialchars(created_on($date), ENT_QUOTES, 'UTF-8') : '';
                            
                           // echo $created_on; 
                          ?>
                          <label title="<?php echo formatDate($date); ?>"> <?php echo $created_on; ?></label>
                        </span>
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
                              <a class="dropdown-item" href="student_controller.php?id=<?php echo $row['user_id'] ?>&off=0"><i class="fas fa-lock text-primary"></i> Deactivate Account</a>
                            <?php else : ?>
                              <a class="dropdown-item" href="student_controller.php?id=<?php echo $row['user_id'] ?>&on=1"><i class="fas fa-lock-open text-primary" ></i> Activate Account</span></a>
                            <?php endif; ?>
                            <!--<a class="dropdown-item" href="student_controller.php?id=<?php // echo $row['user_id'] ?>&del=delete" onClick="return confirm('Are you sure you want to remove student, <?php // echo $username; ?> ?')"><i class="fas fa-trash" style="color:#f5365c;"></i> Delete Account</a>-->
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php $cnt = $cnt + 1;
                  } //while
                }catch(Exception $e){
                  $_SESSION['error']='Something went wrong in accessing student data.';
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
