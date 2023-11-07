<?php
  error_reporting(0);
	session_start();
	include("include/conn.php");
	include("include/session.php");
	include("include/function.php");
	$parentpage = "";
	$parentpage_link= "#";
	$currentpage='Grade';
	$childpage = "";
?>
  <?php
  include("include/header.php");
  ?>
  <script>
  </script>
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
    include("include/topnav.php"); //Edit topnav on this page
    ?>
	<?php if(isset($_SESSION['success'])){ ?>
		<div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
			<span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
			<div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Success!</span>
				<span data-notify="message"><?php echo $_SESSION['success'];?></span>
			</div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
			<span aria-hidden="true">×</span></button>
		</div>
	<?php }  unset($_SESSION['success']); ?>
    <?php if(isset($_SESSION['error'])){ ?>
        <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
          <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
          <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Fail!</span>
            <span data-notify="message"><?php echo $_SESSION['error'];?></span>
          </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
            <span aria-hidden="true">×</span></button>
        </div>
    <?php }  unset($_SESSION['error']); ?>

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
                  <h3 class="mb-0">Grade</h3>
                </div>
                <div class="col-6 text-right">
						      
                </div>
              </div>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <div class="card-body">
                  <div class=" justify-content-center align-items-center" >
                      <form action="" method="POST" style="max-width: 600px;">
                          <div class="row mb-3">
                              <div class="col-lg-12">
                                  <label class="form-control-label">Academic Year & Term</label>
                                  <select class="form-control" id="period" name="period" required>
                                      <option class="form-control" value="">Select A.Y. & Term</option>
                                      <?php
                                          try {
                                              $query1 = "SELECT 
                                                              `period`.`id` AS `period_id`,
                                                              `period`.`year` AS `period_year`,
                                                              `period`.`term` AS `period_term` 
                                                          FROM `period`
                                                          INNER JOIN `class` ON `class`.`period_id` = `period`.`id`
                                                          INNER JOIN `participants` ON `participants`.`class_id` = `class`.`id`
                                                          WHERE `participants`.`student_id` = :student_id
                                                          ORDER BY `period`.`year` DESC";
                                              $stmt1 = $con->prepare($query1);
                                              $stmt1->bindParam(':student_id', $user['id'], PDO::PARAM_INT);
                                              $stmt1->execute();
                                              $period = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                                          } catch (PDOException $e) {
                                              // Handle the exception gracefully (log, display error message, etc.)
                                              $_SESSION['error'] = 'Something went wrong accessing course.';
                                          }

                                          foreach ($period as $row) {
                                              // Assuming $row['term'] can have values '1', '2', or '3' representing semesters
                                              $term = ($row['period_term'] == '1') ? '1st Semester' : (($row['period_term'] == '2') ? '2nd Semester' : 'Summer');
                                              $escaped_term = htmlspecialchars($term, ENT_QUOTES, 'UTF-8');
                                              // Add proper escaping for HTML attributes (e.g., htmlspecialchars) to prevent XSS attacks if required.
                                              echo "<option class='form-control' value='" . $row['period_id'] . "'>" . $row['period_year'] . ' ' . $escaped_term . "</option>";
                                          }
                                          ?>

                                  </select>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-lg-12">
                                  <button type="submit" id="view" name="view" class="btn btn-primary">
                                      <i class="fa fa-eye"></i>
                                      View
                                  </button>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
            </div> 
      </div>
          <?php
            if(isset($_POST['view'])){
              $period_id=$_POST['period'];
              $sql = "SELECT
                          CONCAT(`user`.`lastname`, ', ', `user`.`firstname`) AS `faculty_name`,
                          `course`.`subject_code`,
                          `grade`.`prelim` AS `grade_prelim`,
                          `grade`.`midterm` AS `grade_midterm`,
                          `grade`.`final` AS `grade_final`
                      FROM `period`
                      INNER JOIN `class` ON `class`.`period_id` = `period`.`id`
                      INNER JOIN `participants` ON `participants`.`class_id` = `class`.`id`
                      INNER JOIN `schedule` ON `schedule`.`class_id` = `class`.`id`
                      INNER JOIN `staff` ON `staff`.`id` = `schedule`.`faculty_id`
                      INNER JOIN `user` ON `user`.`username` = `staff`.`username`
                      INNER JOIN `grade` ON `grade`.`schedule_id` = `schedule`.`id`
                      INNER JOIN `course` ON `course`.`id` = `schedule`.`course_id`
                      WHERE `participants`.`student_id` = :student_id
                      AND `class`.`period_id` = :period_id
                      AND `grade`.`student_id` = :student_id";
              
              $stmt = $con->prepare($sql);
              $stmt->bindParam(':student_id', $user['id'], PDO::PARAM_INT);
              $stmt->bindParam(':period_id', $period_id, PDO::PARAM_INT);
              $stmt->execute();
              $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
          ?>                                   
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table align-items-center table-flush table-striped">
                    <thead class="thead-light">
                        <tr>
                          <th>Teacher </th>
                          <th>Subject Code</th>
                          <th>Prelim</th>
                          <th>Midterm</th>
                          <th>Final</th>
                          <th>Remarks</th>
                        </tr>
                    </thead>
                    <tfoot class="thead-light">
                        <tr>
                          <th>Teacher </th>
                          <th>Subject Code</th>
                          <th>Prelim</th>
                          <th>Midterm</th>
                          <th>Final</th>
                          <th>Remarks</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    <?php
                      foreach($result AS $row){
                        //var_dump($result);
                        ?>
                        <tr>
                          <td>asdasd
                            <?php
                              $faculty=(empty($row['faculty_name']) || $row['faculty_name']==NULL)?'':$row['faculty_name'];
                              echo htmlspecialchars($faculty, ENT_QUOTES, 'UTF-8');
                            ?>
                          </td>
  
                          <td>
                            <?php
                              $subject_code=(empty($row['subject_code']) || $row['subject_code']==NULL)?'':$row['subject_code'];
                              echo htmlspecialchars($subject_code, ENT_QUOTES, 'UTF-8');
                            ?>
                          </td>
                          <td>
                            <?php
                              $grade_prelim=(empty($row['grade_prelim']) || $row['grade_prelim']==NULL)?'':$row['grade_prelim'];
                              echo htmlspecialchars($grade_prelim, ENT_QUOTES, 'UTF-8');
                            ?>
                          </td>
                          <td>
                            <?php
                              $grade_midterm=(empty($row['grade_midterm']) || $row['grade_midterm']==NULL)?'':$row['grade_midterm'];
                              echo htmlspecialchars($grade_midterm, ENT_QUOTES, 'UTF-8');
                            ?>
                          </td>
                          <td>
                            <?php
                              $grade_final=(empty($row['grade_final']) || $row['grade_final']==NULL)?'':$row['grade_final'];
                              echo htmlspecialchars($grade_final, ENT_QUOTES, 'UTF-8');
                            ?>
                          </td>
                          <td>
                            <?php
                               $grade_final=floatval($grade_final);
                               if($grade_final>=75 && $grade_final <=100){
                                       $remarks="PASSED";
                               } else if($grade_final<75 && $grade_final >=50){
                                       $remarks="FAILED";
                                }else{
                                       $remarks="ERROR";
                                }
                              $remarks=(empty($remarks) || $remarks==NULL)?'':$remarks;
                              echo htmlspecialchars($remarks, ENT_QUOTES, 'UTF-8');
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
            <?php 
              }
            ?>
          </div>
        </div>
      <?php
      include("include/footer.php"); //Edit topnav on this page
      ?>
    </div>
  </div>
  </body>

  </html>
