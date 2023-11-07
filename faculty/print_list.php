<?php
 // error_reporting(0);
	session_start();
	include("include/session.php");
  include("include/header.php");
	$parentpage = "Records";
	$parentpage_link= "#";
	$currentpage='Student List';
	$childpage = "Student List";
  include("../include/conn.php");
	include("../include/function.php");
  $content_right='';
?>
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
                <div class="col-8">
                  <h3 class="mb-3 text-primary font-weight-bolder">Student List</h3>
                </div>
                <div class="col-6 text-right">
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <div class="card-body">
                <form action="print_list_view.php" method="POST" id="myForm" target="_blank">
                  <div class="row">
                    <div class="col-lg-3" style="">
                      <label class="form-control-label"> Academic Year & Term</label>
                      <select class="form-control" id="period" name="period" required>
                        <option class="form-control" value="">Select A.Y.&Term</option>
                          <?php
                            try {
                              $query1 = "SELECT * FROM `period` ORDER BY `year` DESC;";
                              $stmt1 = $con->prepare($query1);
                              $stmt1->execute();
                              $period = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                            } catch (PDOException $e) {
                                // Handle the exception gracefully (log, display error message, etc.)
                                $_SESSION['error'] = 'Something went wrong accessing course.';
                            }
                          foreach ($period as $row) {
                              // Assuming $row['term'] can have values '1', '2', or '3' representing semesters
                              $term = ($row['term'] == '1') ? '1st Semester' : (($row['term'] == '2') ? '2nd Semester' : 'Summer');
                              
                              // Add proper escaping for HTML attributes (e.g., htmlspecialchars) to prevent XSS attacks if required.
                              echo "<option class='form-control' value='" . $row['id'] . "'>" . $row['year'] . ' ' . $term . "</option>";
                          }
                          ?>
                      </select>
                    </div>
                    
                    <div class="col-lg-3" style="">
                      <label class="form-control-label"> Class</label>
                      <select class="form-control"  id="class" name="class" required>
                        <option class="form-control" value="">Select Class</option>
                        <?php
                          $course=getall('class');
                          foreach ($course as $row1) {
                            // Add proper escaping for HTML attributes (e.g., htmlspecialchars) to prevent XSS attacks if required.
                            echo "<option class='form-control' value='" . $row1['id'] . "'>" . $row1['class_code'] . "</option>";
                          }
                        ?>
                      </select>
                    </div>
                    <div class="col-lg-2" style="">
                      <label class="form-control-label"> Course</label>
                      <select class="form-control" id="course" name="course" required>
                        <option class="form-control" value="">Select Course</option>
                          <?php
                            $course_sql = "SELECT
                                              `schedule`.`id` AS `schedule_id`,
                                              `course`.`subject_code` AS `course_code`
                                          FROM `schedule`
                                          INNER JOIN `course` ON `course`.`id` = `schedule`.`course_id`";
                            $course_stmt = $con->prepare($course_sql);
                            $course_stmt->execute();
                            $course = $course_stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($course as $row1) {
                                // Add proper escaping for HTML attributes (e.g., htmlspecialchars) to prevent XSS attacks if required.
                                echo "<option class='form-control' value='" . $row1['schedule_id'] . "'>" . $row1['course_code'] . "</option>";
                            }
                          ?>
                      </select>
                      <!--<span><small>*Optional</small></span>-->
                    </div>
                    <div class="col-lg-3" style="">
                      <label class="form-control-label"> Action</label><br>
                          <button type="submit"  id="print" name="print"  class="btn bg-green text-primary">
                            
                             View print
                          </button>
                    </div>
                  </div>
                </form>
                <br>
                <span class="text-muted ">
                  <small>
                  *Please ensure that all <b>grades</b> (prelim, midterm, final) are provided in order for the grading sheet to be displayed accurately.
                  </small>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php include("include/footer.php"); ?>
    </div>
  </div>
  </body>
</html>
