<?php
	//error_reporting(0);
	session_start();
	include("include/session.php");
	$parentpage = "Account";
	$parentpage_link = "#";
	$currentpage = "Faculty";
	$page=$childpage = "faculty";
	$content_right='';
	include("../include/conn.php");
	include("../include/function.php");
  include("include/header.php");
?>
  </head>
  <?php include("include/sidebar.php");  ?>
  <!-- Main content -->
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
            <div class="card-header">
			        <div class="row">
                <div class="col-6">
                  <h3 class="mb-0">Faculty</h3>
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
                  WHERE `user`.`type` ='faculty'
                  AND `position`.`id`='3';
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
                        <b>
                        <?php 
                          $firstname = isset($row['user_fname']) ? htmlspecialchars($row['user_fname'], ENT_QUOTES, 'UTF-8') : '';
                          $lastname = isset($row['user_lname']) ? htmlspecialchars($row['user_lname'], ENT_QUOTES, 'UTF-8') : '';
                          $name=short_text($lastname.', '.$firstname);
                         echo $name;
						              ?>
                        </b>
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
