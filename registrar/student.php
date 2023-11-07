<?php
    //error_reporting(0);
    session_start();
    include("include/session.php");
    $parentpage = "";
    $parentpage_link= "#";
    $page=$currentpage='Student';
    $childpage = "student";
    $content_right='<a type="button" href="register.php" class="btn btn-round btn-icon bg-green text-primary">
                      <span class="btn-inner--icon text-primary font-weight-bolder"><i class="fas fa-plus"></i></span>
                      <span class="btn-inner--text text-primary font-weight-bolder"> New</span>
                    </a>';
    include("../include/conn.php");
    include("../include/function.php");
    include("include/header.php");
  ?>
    <script> if (window.history.replaceState) window.history.replaceState(null, null, window.location.href); </script>
    </head>
    <?php include("include/sidebar.php"); ?>
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
            <div class="card-header border-0">
              <div class="row">
                <div class="col-6">
                  <h3 class="mb-0">Students</h3>
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
                  <th>Date Registered</th>
                  <th>Options</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
				            try{
                      $sql = "SELECT *,
                      `student`.`id` AS `student_id`,
                      `program`.`id` AS `program_id`,
                      `program`.`name` AS `program_name`,
                      `institute`.`name` AS `institute_name`
                      FROM `student`
                      INNER JOIN `program` ON `program`.`id` =`student`.`program_id`
                      INNER JOIN `institute` ON `institute`.`id`= `program`.`institute_id`
                      ";
                      $query = $con->query($sql);
                      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                    <tr>
                      <td class="table-user">
                        <b>
                          <?php
                            $middle_initial =(!empty($row['middlename']))?substr($row['middlename'], 0, 1).'.':'';
                            $firstname= (empty($row['firstname']) || $row['firstname']==NULL)?'':htmlentities($row['firstname']);
                            $lastname= (empty($row['lastname']) || $row['lastname']==NULL)?'':htmlentities($row['lastname']);
                            $name = $lastname.', '.$firstname.' '.$middle_initial; 
                           
                            if (!$name == "" || !$name == "NULL") {
                              $fullname_short = htmlentities($name);
                              if (strlen($fullname_short) > 30) $fullname_short = substr($fullname_short, 0, 30) . "...";
                              echo $fullname_short;
                            }
                          ?>
                        </b>
                      </td>
                     
                      <td>
                        <span class="text-muted">
                          <?php
                            $program = (empty($row['program_name']) || $row['program_name']==NULL)?'':htmlentities($row['program_name']);
                            $level = (empty($row['level']) || $row['level']==NULL)?'':htmlentities($row['level']);
                            echo $program.'-'.$level;
                          ?>
                        </span>
                      </td>

                      <td>
                        <span class="text-muted">
                          <?php
                            $institute = (empty($row['institute_name']) || $row['institute_name']==NULL)?'':htmlentities($row['institute_name']);
                            echo $institute;
                          ?>
                        </span>
                      </td>

					            <td>
                        <span class="text-muted"><?php
                          $created_on = isset($row['created_on']) ? htmlspecialchars(created_on($row['created_on']), ENT_QUOTES, 'UTF-8') : '';
                          ?><label title="<?php echo formatDate($created_on); ?>"> <?php echo $created_on; ?></label>
                        </span>
                      </td>
                      
                      <td class="text-right">
                        <div class="dropdown">
                          <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a class="dropdown-item" href="student_edit.php?id=<?php echo $row['student_id']?>"  style="color: black;" ?><i class="fas fa-pen" style="color:#172b4d;" ></i> Edit </a>
                            <a class="dropdown-item text-primary" href="student_info.php?id=<?php echo $row['student_id']?>" ><i class="fas fa-eye" ></i> View Info</a>
                          </div>
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
