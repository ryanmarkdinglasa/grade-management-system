<?php
	error_reporting(0);
	session_start();
	include("include/session.php");
	$parentpage='';
	$parentpage_link='';
	$page=$currentpage='Grades';
	include("include/header.php");
	?>
	<script>
		if ( window.history.replaceState ) {
			window.history.replaceState( null, null, window.location.href );
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
		<div class="header bg-primary pb-6">
		  <div class="container-fluid">
			<div class="header-body">
			  <div class="row align-items-center py-4">
				<div class="col-lg-6 col-7">
				  <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
					<ol class="breadcrumb breadcrumb-links breadcrumb-dark">
					<li class="breadcrumb-item"><a href="./"><i class="fas fa-home"></i></a></li>
					  <li class="breadcrumb-item"><a href="./">Dashboard</a></li>
					  <li class="breadcrumb-item active" aria-current="page">Grades</li>
					</ol>
				  </nav>
				</div>
				<div class="col-lg-6 col-5 text-right">
				</div>
			  </div>
			</div>
		  </div>
		</div>
    	<!--  Header & Breadcrumbs -->
		<div class="container-fluid mt--6">
			<div class="row">
				<div class="col">
					<div class="card">
						<div class="card-header border-0">
							<div class="row">
								<div class="col-6">
									<h3 class="mb-0">Grades</h3>
								</div>
							<div class="col-6 text-right">
							</div>
						</div>
					</div>
					<div class="table-responsive">
						<div class="card-body">
							<form action="" method="POST">
								<div class="row">
									<div class="col-lg-4" style="">
										<label class="form-control-label"> Academic Year & Term</label>
										<select class="form-control" id="period_id" name="period_id"  required>
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
										<span class="text-muted"><small> All academic year in the system are listed</small></span>
									</div>
									<div class="col-lg-5" style="">
										<label class="form-control-label"> Course </label>
										<select class="form-control" id="schedule_id" name="schedule_id" required>
											<option class="form-control" value="">Select Course</option>
											<?php
												$assigned_course_sql = "SELECT *,
													`course`.`subject_code` AS `course_code`,
													`schedule`.`id` AS `schedule_id`,
													`class`.`id` AS `class_id`,
													`class`.`class_code` AS `section`
													FROM `schedule`
													INNER JOIN `course` ON `course`.`id` = `schedule`.`course_id`
													INNER JOIN `class` ON `class`.`id` = `schedule`.`class_id`
													INNER JOIN `isgraded` ON `isgraded`.`course_id` = `schedule`.`id`
													WHERE `schedule`.`faculty_id` = :staff_id
													AND `isgraded`.`isPrelim` <= '2'";
												
												$assigned_course_stmt = $con->prepare($assigned_course_sql);
												$assigned_course_stmt->bindParam(':staff_id', $user['staff_id'], PDO::PARAM_INT);
												$assigned_course_stmt->execute();
												$assigned_courses = $assigned_course_stmt->fetchAll(PDO::FETCH_ASSOC);
												
												foreach ($assigned_courses as $course) {
													// Add proper escaping for HTML attributes (e.g., htmlspecialchars) to prevent XSS attacks if required.
													echo "<option class='form-control' value='" . $course['schedule_id'] . "'>" .$course['course_code']." ". $course['section'] . "</option>";
												}
											?>
										</select>
										<span class="text-muted"><small>All the subjects that has submitted grade.</small></span>
									</div>
									<div class="col-lg-3" style="">
										<label class="form-control-label"> Action</label><br>
										<button type="submit"  id="view" name="view"  class="btn btn-primary">
											<i class="fa fa-eye text-white"></i>
											View
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<?php
					//IF VIEW BUTTON IS CLICK
					$classes='';
					//HEY MARK TRY USING THE GET AND CHANGE THE VIEW BUTTON TO REDIRECT AND DISYPLAY THE TABLE
					if(isset($_POST['view'])){
						$schedule_id = trim($_POST['schedule_id']);
						$period_id = trim($_POST['period_id']);

						if (empty($schedule_id) || empty($period_id)) {
							$_SESSION['error'] = 'All fields are required.';
							echo "<script>window.location.href='grades.php';</script>";
							exit();
						}

						$student_query = "SELECT 
								`student`.`idno` AS `student_idno`,
								CONCAT(`student`.`lastname`, ', ', `student`.`firstname`, ' ', LEFT(`student`.`middlename`, 1), '.') AS `student_name`,
								`grade`.`prelim` AS `grade_prelim`,
								`grade`.`midterm` AS `grade_midterm`,
								`grade`.`final` AS `grade_final`,
								`course`.`subject_code` AS `course_code`
							FROM `participants`
							INNER JOIN `student` ON `student`.`id` = `participants`.`student_id`
							INNER JOIN `class` ON `class`.`id` = `participants`.`class_id`
							INNER JOIN `schedule` ON `schedule`.`class_id` = `class`.`id`
							INNER JOIN `course` ON `course`.`id` = `schedule`.`course_id`
							LEFT JOIN `grade` ON `grade`.`schedule_id` = `schedule`.`id` AND `grade`.`student_id` = `participants`.`student_id`
							WHERE `schedule`.`id` = :schedule_id
							AND `class`.`period_id` = :period_id
							ORDER BY `student`.`lastname`
						";

						$student_statement = $con->prepare($student_query);
						$student_statement->bindParam(':period_id', $period_id, PDO::PARAM_INT);
						$student_statement->bindParam(':schedule_id', $schedule_id, PDO::PARAM_INT);
						$student_statement->execute();
						$students = $student_statement->fetchAll(PDO::FETCH_ASSOC);
						?>
							 <div class="card">
								<div class="card-body">
								<a class="text-right btn btn-primary text-white mb-3" href="grading_sheet_print.php?id=<?php echo $schedule_id.'&period='.$period_id?>" target="_blank">
									<svg style="fill:#FFF;" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/></svg>
									Print
								</a>
																	
									<div class="table-responsive">
									<table class="table align-items-center table-flush table-striped">
										<thead class="thead-light">
											<tr>
											<th>Student No. </th>
											<th>Student </th>
											<th>Subject Code</th>
											<th>Prelim</th>
											<th>Midterm</th>
											<th>Final</th>
											<th>Remarks</th>
											</tr>
										</thead>
										<tbody>
										<?php
										
										foreach($students as $student){
											?>
											<tr>
											<td>
												<?php
												$student_no=(empty($student['student_idno']) || $student['student_idno']==NULL)?'':$student['student_idno'];
												echo htmlspecialchars($student_no, ENT_QUOTES, 'UTF-8');
												?>
											</td>
											<td>
												<?php
												$student_name=(empty($student['student_name']) || $student['student_name']==NULL)?'':$student['student_name'];
												echo htmlspecialchars($student_name, ENT_QUOTES, 'UTF-8');
												?>
											</td>
					
											<td>
												<?php
												$subject_code=(empty($student['course_code']) || $student['course_code']==NULL)?'':$student['course_code'];
												echo htmlspecialchars($subject_code, ENT_QUOTES, 'UTF-8');
												?>
											</td>
											<td>
												<?php
												$grade_prelim=(empty($student['grade_prelim']) || $student['grade_prelim']==NULL)?'':$student['grade_prelim'];
												echo htmlspecialchars($grade_prelim, ENT_QUOTES, 'UTF-8');
												?>
											</td>
											<td>
												<?php
												$grade_midterm=(empty($student['grade_midterm']) || $student['grade_midterm']==NULL)?'':$student['grade_midterm'];
												echo htmlspecialchars($grade_midterm, ENT_QUOTES, 'UTF-8');
												?>
											</td>
											<td>
												<?php
												$grade_final=(empty($student['grade_final']) || $student['grade_final']==NULL)?'':$student['grade_final'];
												echo htmlspecialchars($grade_final, ENT_QUOTES, 'UTF-8');
												?>
											</td>
											<td>
												<?php
												$note='';
												if (is_numeric($grade_final)) {
													$numericGrade = floatval($grade_final);
													if ($numericGrade < 75 && $numericGrade >= 50) {
														$note = 'FAILED';
													} else if ($numericGrade >= 75 && $numericGrade <= 100) {
														$note = 'PASSED';
													}
												} else {
													if ($grade_final == 'UD') {
														$note = 'UD';
													} else if ($remarks == 'OD') {
														$note = 'OD';
													} else if ($remarks == 'INC') {
														$note = 'INC';
													}
												}
												echo htmlspecialchars($note, ENT_QUOTES, 'UTF-8');
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
							<?php	}	?>
						</div>
					</div>
				<?php include("include/footer.php"); ?>
       		</div>
      	</div>
	</body>
</html>
