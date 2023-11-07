<?php
  error_reporting(E_ALL);
	session_start();
	include("include/session.php");
	$parentpage = "";
	$parentpage_link= "#";
	$currentpage='Student';
	$page=$childpage = "Student";
  include("include/header.php");
  ?>
  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
  </head>
  <?php
  include("include/sidebar.php");
  ?>
  <!-- Main content -->
  <div class="main-content" id="panel">
    <?php
    include("include/topnav.php"); 
    include("include/prompt.php");
    ?>
    <!-- Header -->
    <!-- Header & Breadcrumbs -->
	  <?php include "include/breadcrumbs.php";?>
    <!--  Header & Breadcrumbs -->
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <!-- Table -->
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <div class="row">
                <div class="col-6">
                  <h3 class="mb-0">Student List</h3>
                </div>
                <div class="col-6 text-right">
                </div>
              </div>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush table-striped" id="datatable-buttons">
                <thead class="thead-light">
                  <tr>
                  <th>No.</th>
                  <th>Name</th>
                  <th>Program & Year Level</th>
                  <th>Email</th>
                  <th>Date Created</th>
                  <th class="text-center">Options</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
				            try{
                      $cnt=0;
                      $sql = "SELECT `student`.*,
                      `student`.`id` AS `student_id`,
                       CONCAT(`student`.`lastname`, ', ', `student`.`firstname`, ' ', LEFT(`student`.`middlename`, 1), '.') AS `student_name`,
                      `program`.`id` AS `program_id`,
                      `program`.`name` AS `program_name`,
                      `institute`.`id` AS `institute_id`,
                      `institute`.`name` AS `institute_name`
                  FROM `participants`
                  INNER JOIN `student` ON `student`.`id`= `participants`.`student_id`
                  INNER JOIN `program` ON `program`.`id` =`student`.`program_id`
                  INNER JOIN `institute` ON `institute`.`id`=`program`.`institute_id`
                  INNER JOIN `schedule` ON `schedule`.`class_id`=`participants`.`class_id`
                  WHERE `schedule`.`faculty_id` ='".$user['staff_id']."'
                  GROUP BY `student`.`id`
                  ORDER BY `student`.`lastname` ASC
                      ";
                      $query = $con->query($sql);
                      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                        $cnt++;
                  ?>
                    <tr>
                      <td class="text-muted"><?php echo ''.$cnt;?></td>
                      <td class="table-user">
                        <b>
                          <?php
                            $firstCharacter =(!empty($row['middlename']))?substr($row['middlename'], 0, 1).'.':'';
                            $name = $row['lastname'].', '.$row['firstname'].' '.$firstCharacter; 
                            if (!$name == "" || !$name == "NULL") {
                              $username_short = htmlentities($name);
                              if (strlen($username_short) > 30) $username_short = substr($username_short, 0, 30) . "...";
                              echo $username_short;
                            }
                          ?>
                        </b>
                      </td>
                     
                      <td>
                        <span class="text-muted">
                          <?php
                            $program = htmlentities($row['program_name']);
                            $level = htmlentities($row['level']);
                            echo $program.'-'.$level;
                          ?>
                        </span>
                      </td>

                      <td>
                        <a href="emailto:<?php echo htmlentities($row['username']); ?>" class="font-weight-bold"><?php echo htmlentities($row['username']); ?></a>
                      </td>

					            <td>
                        <span class="text-muted"><?php
                          $created_on = isset($row['created_on']) ? htmlspecialchars(created_on($row['created_on']), ENT_QUOTES, 'UTF-8') : '';
                         ?><label title="<?php echo formatDate($created_on); ?>"> <?php echo $created_on; ?></label>
                          </span>
                        
                      </td>
                      
                      <td class="text-center">
                        <a class="btn btn-primary btn-sm text-white" href="student_info.php?id=<?php echo $row['student_id']?>" ><i class="fas fa-eye" ></i> View Info</a>
                      </td>
                    </tr>
                  <?php 
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








      <?php
      include("include/footer.php"); //Edit topnav on this page
      ?>
      <script>
        function toggle_select(id) {
          var X = document.getElementById(id);
          if (X.checked == true) {
            X.value = "1";
          } else {
            X.value = "0";
          }
          //var sql="update clients set calendar='" + X.value + "' where cli_ID='" + X.id + "' limit 1";
          var who = X.id;
          var chk = X.value
          //alert("Joe is still debugging: (function incomplete/database record was not updated)\n"+ sql);
          $.ajax({
            //this was the confusing part...did not know how to pass the data to the script
            url: 'as_status_admin.php',
            type: 'post',
            data: 'who=' + who + '&chk=' + chk,
            success: function(output) {
              alert('success, server says ' + output);
            },
            error: function() {
              alert('something went wrong, save failed');
            }
          });
        }
      </script>
      <script type="text/javascript">
        document.getElementById("close_direct").onclick = function() {
          location.href = "data_admin.php";
        };
      </script>


    </div>
  </div>

  </body>

  </html>
