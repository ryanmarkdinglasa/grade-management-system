<?php
  error_reporting(0);
	session_start();
	include("include/session.php");
	include("include/header.php");
	$parentpage = "Records";
	$parentpage_link= "#";
	$currentpage='TOR';
	$childpage = "TOR";
  ?>
  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
  </head>
  <?php include("include/sidebar.php"); ?>
  <!-- Main content -->
  <div class="main-content" id="panel">
    <?php
      include("include/topnav.php");
      include("include/prompt.php");
      include("include/breadcrumbs.php");
    ?>
    <div class="container-fluid mt--6">
      <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <div class="row">
                <div class="col-6">
                  <h3 class="mb-0">Transcript of Records</h3>
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
                  <th>Name</th>
                  <th>Description</th>
                  <th>Institute</th>
                  <th>Date Created</th>
                  <th>Options</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
				            try{
                      $sql = "SELECT *,
                      `student`.`id` AS `student_id`,
                      `program`.`id` AS `program_id`,
                      `program`.`name` AS `program_name`
                      FROM `student`
                      INNER JOIN `program` ON `program`.`id` =`student`.`program_id`";
                      $query = $con->query($sql);
                      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                    <tr>
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
                        <span class="text-muted">
                          <?php
                            $date=(empty($row['created_on']) ||$row['created_on']==NULL)?'':$row['created_on'];
                            $created_on = isset( $date) ? htmlspecialchars(created_on($date), ENT_QUOTES, 'UTF-8') : '';
                            
                           // echo $created_on; 
                          ?>
                          <label title="<?php echo formatDate($date); ?>"> <?php echo $created_on; ?></label>
                        </span>
                      </td>
                      
                      <td class="text-left">
                        <div class="dropdown">
                          <a class="dropdown-item text-primary btn btn-primary bg-primary text-white text-center" target="_blank" href="tor_print.php?id=<?php echo $row['student_id']?>" >Print TOR</a>
                        </div>
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







      <?php
      include("include/footer.php"); //Edit topnav on this page
      ?>
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
