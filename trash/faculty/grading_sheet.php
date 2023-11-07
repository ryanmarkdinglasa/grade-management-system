<?php
	error_reporting(0);
	session_start();
	include("include/session.php");
	$parentpage='';
	$parentpage_link='';
	$page=$currentpage='Grade';
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
    <!-- Header & Breadcrumbs -->
		<div class="header bg-primary pb-6">
		  <div class="container-fluid">
			<div class="header-body">
			  <div class="row align-items-center py-4">
				<div class="col-lg-6 col-7">
				  <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
					<ol class="breadcrumb breadcrumb-links breadcrumb-dark">
					<li class="breadcrumb-item"><a href="./"><i class="fas fa-home"></i></a></li>
					  <li class="breadcrumb-item"><a href="./">Dashboard</a></li>
					  <li class="breadcrumb-item active" aria-current="page">Grading Sheet</li>
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
			<!-- Page content -->
		<div class="container-fluid mt--6">
			<div class="row">
				<div class="col">
					<div class="card">
						<div class="card-header border-0">
							<div class="row">
								<div class="col-6">
									<h3 class="mb-0">Grading Sheet</h3>
								</div>
							<div class="col-6 text-right">
							</div>
						</div>
					</div>
					<div class="table-responsive">
						<div class="card-body">
							<form action="grading_sheet.php" method="POST">
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
									<!--<div class="col-lg-5" style="">
										<label class="form-control-label"> Course </label>
										<select class="form-control" id="schedule_id" name="schedule_id" required>
											<option class="form-control" value="">Select Course</option>
											<?php
												/*
												$assigned_course_sql = "SELECT *,
																		`course`.`subject_code` AS `course_code`,
																		`schedule`.`id` AS `schedule_id`,
																		`class`.`id` AS `class_id`,
																		`class`.`class_code` AS `section`
																		FROM `schedule`
																		INNER JOIN `course` ON `course`.`id` = `schedule`.`course_id`
																		INNER JOIN `class` ON `class`.`id` = `schedule`.`class_id`
																		WHERE `schedule`.`faculty_id` = '".$user['staff_id']."'";
												$assigned_course_stmt = $con->prepare($assigned_course_sql);
												$assigned_course_stmt->execute();
												$assigned_courses = $assigned_course_stmt->fetchAll(PDO::FETCH_ASSOC);

												foreach ($assigned_courses as $course) {
													// Add proper escaping for HTML attributes (e.g., htmlspecialchars) to prevent XSS attacks if required.
													echo "<option class='form-control' value='" . $course['schedule_id'] . "'>" .$course['course_code']." ". $course['section'] . "</option>";
												}
											*/
											?>
										</select>
										<span class="text-muted"><small>All the subjects assigned by the Program Coordinator are listed.</small></span>
									</div>-->

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
						if(isset($_POST['view'])){
							//$schedule_id=trim($_POST['schedule_id']);
							$period_id=trim($_POST['period_id']);
							if(empty($period_id)){
								$_SESSION['error']='All fields are required.';
								echo"<script>window.location.href='grading_sheet.php';</script>";
								exit();
							}
							$assigned_course_sql = "SELECT
								`course`.`subject_code` AS `course_code`,
								`course`.`description` AS `course_description`,
								`schedule`.`id` AS `schedule_id`,
								`class`.`id` AS `class_id`,
								`class`.`class_code` AS `section`,
								COALESCE(`isgraded`.`updated_on`, `isgraded`.`created_on`) AS `date_submitted`,
								`isgraded`.`isPrelim` AS `grade_prelim`,
								`isgraded`.`isMidterm` AS `grade_midterm`,
								`isgraded`.`isFinal` AS `grade_final`
							FROM `schedule`
							INNER JOIN `course` ON `course`.`id` = `schedule`.`course_id`
							INNER JOIN `class` ON `class`.`id` = `schedule`.`class_id`
							INNER JOIN `isgraded` ON `isgraded`.`course_id` = `schedule`.`id`
							WHERE `schedule`.`faculty_id` = '".$user['staff_id']."'";
							$assigned_course_stmt = $con->prepare($assigned_course_sql);
							$assigned_course_stmt->execute();
							$assigned_courses = $assigned_course_stmt->fetchAll(PDO::FETCH_ASSOC);
							echo"
							<div class='table-responsive'>
								<div class='card-body'>
									<div class='row border' style='border:1px solid red;'>
											<label class='col-lg-2'>Class</label>
											<label class='col-lg-2'>Course</label>
											<label class='col-lg-4'>Description</label>
											<label class='col-lg-2'>Date Submitted</label>
									</div><br>
								
							";
							foreach ($assigned_courses as $course) {
								if($course['grade_prelim']=='0' || $course['grade_prelim']==NULL){
								?>
								<button class='row btn-primary btn cursor-pointer <?php if ($course['grade_prelim'] == '1') { echo 'bg-red'; } ?>'
									style='width:100%;text-align:left;margin-top:5px;border:none;'
									<?php if ($course['grade_prelim'] == '0'|| $course['grade_prelim'] == NULL) { ?>
										onclick="window.location.href='prelim.php?class_id=<?php echo $course['class_id']; ?>&sched_id=<?php echo $course['schedule_id']; ?>'"
									<?php } ?>>
									<label class='col-lg-2 cursor-pointer'><?php echo $course['section']; ?> </label>
									<label class='col-lg-2 cursor-pointer'><?php echo $course['course_code']; ?> </label>
									<label class='col-lg-4 cursor-pointer'><?php echo $course['course_description']; ?> </label>
									<label class='col-lg-2 cursor-pointer'><?php echo formatDate($course['date_submitted']); ?> </label>
								</button>
								<?php
								}
								else if($course['grade_prelim']=='2' &&  intval($course['grade_midterm'])<2 || $course['grade_midterm']==NULL ){
								?>
								<button class='row btn-primary btn cursor-pointer <?php if ($course['grade_midterm'] == '1') { echo 'bg-red'; } ?>'
									style='width:100%;text-align:left;margin-top:5px;border:none;'
									<?php if ($course['grade_midterm'] == '0'|| $course['grade_midterm'] == NULL) { ?>
										onclick="window.location.href='midterm.php?class_id=<?php echo $course['class_id']; ?>&sched_id=<?php echo $course['schedule_id']; ?>'"
									<?php } ?>>
									<label class='col-lg-2 cursor-pointer'><?php echo $course['section']; ?> </label>
									<label class='col-lg-2 cursor-pointer'><?php echo $course['course_code']; ?> </label>
									<label class='col-lg-4 cursor-pointer'><?php echo $course['course_description']; ?> </label>
									<label class='col-lg-2 cursor-pointer'><?php echo formatDate($course['date_submitted']); ?> </label>
								</button>
								<?php
								}else if($course['grade_midterm']=='2' &&  intval($course['grade_final'])<2  || $course['grade_midterm']==NULL){
									?>
								<button class='row btn-primary btn cursor-pointer <?php if ($course['grade_final'] == '1') { echo 'bg-red'; } ?>'
									style='width:100%;text-align:left;margin-top:5px;border:none;'
									<?php if ($course['grade_final'] == '0'|| $course['grade_final'] == NULL) { ?>
										onclick="window.location.href='final.php?class_id=<?php echo $course['class_id']; ?>&sched_id=<?php echo $course['schedule_id']; ?>'"
									<?php } ?>>
									<label class='col-lg-2 cursor-pointer'><?php echo $course['section']; ?> </label>
									<label class='col-lg-2 cursor-pointer'><?php echo $course['course_code']; ?> </label>
									<label class='col-lg-4 cursor-pointer'><?php echo $course['course_description']; ?> </label>
									<label class='col-lg-2 cursor-pointer'><?php echo formatDate($course['date_submitted']); ?> </label>
								</button>
								<?php
								}
							}
							echo"
								</div>
							</div>
							";
						}//VIEW	
						?>
						</div>
					</div>
				<?php include("include/footer.php"); ?>
       		</div>
      	</div>
	</body>
</html>
