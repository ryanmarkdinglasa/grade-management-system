<?php
  error_reporting(0);
	session_start();
	include("include/session.php");
	$parentpage = "Records";
	$parentpage_link= "#";
	$currentpage='Grade';
	$childpage = "Grade";
  $content_right='';
	include("../include/conn.php");
	include("../include/function.php");
  include("include/header.php");
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
      include("include/snackbar.php");
      include "include/breadcrumbs.php";
    ?> <!--  Header & Breadcrumbs -->
    <div class="container-fluid mt--6">
      <!-- Table -->
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <div class="row">
                <div class="col-6">
                  <h3 class="mb-0">Quarter Grade</h3>
                </div>
                <div class="col-6 text-right">
                </div>
              </div>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <div class="card-body">
                <form action="prelim_print.php" method="POST" id="myForm" target="_blank">
                <div class="row">
                  <div class="col-lg-3" style="">
                    <label class="form-control-label"> Academic Year & Term</label>
                    <select class="form-control" id="period" name="period" >
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
                    <label class="form-control-label"> Course</label>
                    <select class="form-control" id="course" name="course">
                      <option class="form-control" value="">Select A.Y. & Term</option>
                        <?php
                          $course=getall('course');
                          foreach ($course as $row1) {
                            // Add proper escaping for HTML attributes (e.g., htmlspecialchars) to prevent XSS attacks if required.
                            echo "<option class='form-control' value='" . $row1['id'] . "'>" . $row1['subject_code'] . "</option>";
                          }
                        ?>
                    </select>
                  </div>
                  <div class="col-lg-3" style="">
                    <label class="form-control-label" id="class" name="class"> Class</label>
                    <select class="form-control">
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
                  <div class="col-lg-3" style="">
                    <label class="form-control-label"> Action</label><br>
                    <button class="btn btn-primary">
                      <svg style="fill:#FFF;" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg>
                      Preview
                    </button>
                        <button type="submit"  id="print" name="print"  class="btn btn-primary">
                          <svg style="fill:#FFF;" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/></svg>
                          Print
                        </button>
                  </div>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php include("include/footer.php");  ?>
    </div>
  </div>
  </body>
</html>
