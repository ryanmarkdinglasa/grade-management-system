<?php
	error_reporting(0);
	session_start();
	include("include/session.php");
	$parentpage='';
	$parentpage_link='';
	$page='Grade';
	$currentpage='Grade Sheet';
	include("include/header.php");
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
			include("include/breadcrumbs.php");
		?>
		<!-- Page content -->
		<div class="container-fluid mt--6">
			<div class="row">
				<div class="col">
					<div class="card">
						<div class="card-header border-0">
							<div class="row">
								<div class="col-6">
									<h3 class="mb-0 text-primary font-weight-bolder">Grading Sheet</h3>
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
										<button type="submit"  id="view" name="view"  class="btn bg-green text-primary font-weight-bolder">
												<i class="fa fa-eye text-primary"></i>
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
							$get=[];$date_submitted=[];$isPrelim=[];$isMidterm=[];$isFinal=[];$count=0;$redirect='';$len=0;$prelimCount=0;$midtermCount=0;$finalCount=0;$isGrade='';
							if(empty($period_id)){
								$_SESSION['error']='All fields are required.';
								echo"<script>window.location.href='grading_sheet.php';</script>";
								exit();
							}
							/*
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
							*/
							$assigned_course_sql = "SELECT
														`course`.`subject_code` AS `course_code`,
														`course`.`description` AS `course_description`,
														`schedule`.`id` AS `schedule_id`,
														`class`.`id` AS `class_id`,
														`class`.`class_code` AS `section`
													FROM `schedule`
													INNER JOIN `course` ON `course`.`id` = `schedule`.`course_id`
													INNER JOIN `class` ON `class`.`id` = `schedule`.`class_id`
													INNER JOIN `period` ON `period`.`id`=`class`.`period_id`
													WHERE `schedule`.`faculty_id` = '".$user['staff_id']."'
													AND `class`.`period_id`='".$period_id."'";
							$assigned_course_stmt = $con->prepare($assigned_course_sql);
							$assigned_course_stmt->execute();
							$assigned_courses = $assigned_course_stmt->fetchAll(PDO::FETCH_ASSOC);
							?>
							<div class='card'>
							<div class='table-responsive bg-white ' style="border-radius:5px">
									<div class='card-body'>
										<div class='row border' style='border:1px solid red;padding:5px 5px;'>
												<label class='col-lg-2 text-primary font-weight-bolder'>Class</label>
												<label class='col-lg-2  text-primary font-weight-bolder'>Course</label>
												<label class='col-lg-4  text-primary font-weight-bolder'>Description</label>
												<label class='col-lg-2  text-primary font-weight-bolder'>Date Submitted</label>
										</div><br>
							<?php	
								$subject_len=count($assigned_courses);
								$prelimCount=getrecord_query2("SELECT COUNT(`isPrelim`) AS `prelimCount` FROM `isgraded` WHERE `isPrelim`='1'");
								$midtermCount=getrecord_query2("SELECT COUNT(`isMidterm`) AS `midtermCount` FROM `isgraded` WHERE `isMidterm`='1'");
								$finalCount=getrecord_query2("SELECT COUNT(`isFinal`) AS `finalCount` FROM `isgraded` WHERE `isFinal`='1'");
								foreach ($assigned_courses as $course) {
									try {
										$get[$count]=getrecord('isgraded',['class_id','course_id'],[$course['class_id'],$course['schedule_id']]);
										if(!empty($get[$count])) {
											if($prelimCount>0){
												$isPrelim[$count]= ($get[$count]['isPrelim'] !== NULL || $get[$count]['isPrelim'] != '0' || !empty($get[$count]['isPrelim']))?$get[$count]['isPrelim']:'0';
											}
											if($midtermCount>0){
												$isMidterm[$count]= ($get[$count]['isMidterm'] !== NULL || $get[$count]['isMidterm'] != '0' || !empty($get[$count]['isMidterm']))?$get[$count]['isMidterm']:'0';
											}
											if($finalCount>0){
												$isFinal[$count]= ($get[$count]['isFinal'] !== NULL || $get[$count]['isFinal'] != '0'  || !empty($get[$count]['isFinal']))?$get[$count]['isFinal']:'0';
											}
											//
											if(!empty($prelimCount['prelimCount']) && $prelimCount['prelimCount']!=$subject_len+1)	{
												$redirect='prelim.php';
												$isGrade='prelim';
											}
											else if(!empty($midtermCount['midtermCount']) && $prelimCount['prelimCount']==$subject_len && $midtermCount['midtermCount']!=$subject_len)	{
												$redirect='midterm.php';
												$isGrade='midterm';
											}

											else if(!empty($finalCount['finalCount']) && $midtermCount['midtermCount']==$subject_len && $finalCount['finalCount']!=$subject_len)	{
												$redirect='final.php';
												$isGrade='final';
											}else{
												$redirect='err';
												$isGrade='err';
											} 


											
											if($get[$count]['updated_on']!==NULL){
												$date_submitted[$count] = ($get[$count]['updated_on'] === NULL || $get[$count]['updated_on'] == 0)?'':formatDate($get[$count]['updated_on']);
											} 
											else {
												$date_submitted[$count] = ($get[$count]['created_on'] === NULL || $get[$count]['created_on'] == 0)?'':formatDate($get[$count]['created_on']);
											}
										}else{
											$isPrelim[$count]='';
											$isMidterm[$count]='';
											$isFinal[$count]='';
											$date_submitted[$count]='';
										}
									} catch (Exception $err) {
										echo 'error';
									}

								if($isGrade=='prelim'){
								?>
								<button class='row  text-primary btn cursor-pointer <?php if ($isPrelim[$count] == '1') { echo 'bg-red'; }else{ echo 'bg-green';}?>'
									<?php if (empty($isPrelim[$count]) || $isPrelim[$count] =='0') { ?>
										onclick="window.location.href='<?php echo $redirect;?>?class_id=<?php echo $course['class_id']; ?>&sched_id=<?php echo $course['schedule_id']; ?>'"
									<?php  } ?> style='width:100%;text-align:left;margin-top:5px;border:none;'>
								<?php 
								} else if($isGrade=='midterm' && $isPrelim[$count]== '2' ){?>
									<button class='row  text-primary btn cursor-pointer <?php if ($isMidterm[$count] == '1') { echo 'bg-red'; }else{ echo 'bg-green';}?>'
									<?php if (empty($isMidterm[$count]) || $isMidterm[$count] =='0') { ?>
										onclick="window.location.href='<?php echo $redirect;?>?class_id=<?php echo $course['class_id']; ?>&sched_id=<?php echo $course['schedule_id']; ?>'"
									<?php  } ?> style='width:100%;text-align:left;margin-top:5px;border:none;'><?php
								}else if($isGrade=='final' && $isMidterm[$count]== '2'){?>
									<button class='row  text-primary btn cursor-pointer <?php if ($isFinal[$count] == '1') { echo 'bg-red'; }else{ echo 'bg-green';}?>'
									<?php if (empty($isFinal[$count]) || $isFinal[$count] =='0') { ?>
										onclick="window.location.href='<?php echo $redirect;?>?class_id=<?php echo $course['class_id']; ?>&sched_id=<?php echo $course['schedule_id']; ?>'"
									<?php  } ?> style='width:100%;text-align:left;margin-top:5px;border:none;'><?php
								}
								?>
									<label class='col-lg-2 cursor-pointer'><?php echo $course['section']; ?> </label>
									<label class='col-lg-2 cursor-pointer'><?php echo $course['course_code']; ?> </label>
									<label class='col-lg-4 cursor-pointer'><?php echo $course['course_description']; ?> </label>
									<label class='col-lg-2 cursor-pointer'><?php echo $date_submitted[$count];  ?> </label>
								</button>
								<?php
								/*echo 'isGrade:'.$isGrade.'<br>';
								echo 'isPrelim:'.$isPrelim[$count].'<br>';
								echo 'isMidterm:'.$isMidterm[$count].'<br>';
								echo 'isFinal:'.$isFinal[$count].'<br>';*/
								///echo 'redirect:'.$redirect.'<br>';
								//echo 'count:'.$count.'<br>';
								$count++;
							}
							echo"
								</div>
							</div>
							</div>
							<br>";
							
						
						}//VIEW
						/*else if(!isset($_POST['view'])){
							echo"<script>window.location.href='grading_sheet.php';</script>";
							exit();
						}*/
						?>
						</div>
					</div>
				<?php include("include/footer.php"); ?>
       		</div>
      	</div>
	</body>
</html>
