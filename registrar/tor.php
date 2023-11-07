<?php
  //error_reporting(0);
	session_start();
	include("include/session.php");
	$parentpage = "Records";
	$parentpage_link= "#";
	$currentpage='TOR';
	$childpage = "TOR";
  $content_right='';
	include("../include/conn.php");
	include("../include/function.php");
  include("include/header.php");
  ?>
  <script> if (window.history.replaceState) window.history.replaceState(null, null, window.location.href); </script>
  </head>
  <?php include("include/sidebar.php"); ?>
  <div class="main-content" id="panel">
    <?php
      include("include/topnav.php");
      include("include/snackbar.php");
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
                          <a class="dropdown-item text-primary btn bg-green  text-primary font-weight-bolder text-center" target="_blank" href="tor_print.php?id=<?php echo $row['student_id']?>" >
                          <svg class="text-primary" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/></svg>
                            Print
                          </a>
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
