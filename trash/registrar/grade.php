<?php
  error_reporting(0);
	session_start();
	include("include/session.php");
  include("include/header.php");
	$parentpage = "Records";
	$parentpage_link= "#";
	$currentpage='Periodical Grade';
	$childpage = "Grade";
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
    include("include/topnav.php"); //Edit topnav on this page
    include("include/prompt.php");
    include "include/breadcrumbs.php";?>
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
                  <h3 class="mb-0">Periodical Grade</h3>
                </div>
                <div class="col-6 text-right">
						      
                </div>
              </div>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <div class="card-body">
                <form action="grade_print.php" method="POST" target="_blank">
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
                    </div>
                    <div class="col-lg-2" style="">
                      <label class="form-control-label"  > Class</label>
                      <select class="form-control" id="class" name="class" required>
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
                      <label class="form-control-label" > Period</label>
                      <select class="form-control" id="periodical" name="periodical" required>
                        <option class="form-control" value="">Select Class</option>
                        <option class="form-control" value="1">Prelim</option>
                        <option class="form-control" value="2">Midterm</option>
                        <option class="form-control" value="3">Finals</option>
                      </select>
                    </div>
                    <div class="col-lg-3" style="">
                      <label class="form-control-label"> Action</label><br>
                          <button type="submit"  target="_blank" id="print" name="print"  class="btn btn-primary">
                            <svg style="fill:#FFF;" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/></svg>
                            Print
                          </button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <?php
      include("include/footer.php"); //Edit topnav on this page
      ?>
    </div>
  </div>
  </body>

  </html>
