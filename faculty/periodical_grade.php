<?php
	//error_reporting(0);
	session_start();
	include("include/session.php");
	include("../include/conn.php");
	include("../include/function.php");
  	include("include/header.php");
	//validate class id
	if (!isset($_GET['id']) || empty($_GET['id']) || !isset($_GET['period']) || empty($_GET['period']) || $_GET['period']!=='prelim'  && $_GET['period']!=='midterm' && $_GET['period']!=='final'){
        echo  " <script> window.location.href='403.php'; </script> ";
        exit();
	}
	
	//validate class id if exist
	$schedule=getrecord('schedule',['id'],[$_GET['id']]);
	if($schedule==false){
  		echo    "<script>window.location.href='404.php';</script>";
        exit();
    }
	//SESSSION the class_id and the period
	$_SESSION['schedule']=$_GET['id'];
	$_SESSION['period']=$_GET['period'];
	$class=getrecord('class',['id'],[$schedule['class_id']]);
	$class_id=(empty($class['id']) || $class['id']==NULL)?'2':$class['id'];
	$parentpage='Class Courses';
	$parentpage_link='grade_class.php?id='.$class_id.'&period='.$_SESSION['period'];
	$page=$currentpage='Periodical Grade';
	$content_right="<form action='submit_grade.php' method='POST'> 
						<input type='hidden' name='schedule' value='".$_SESSION['schedule']."' required>
						<input type='hidden' name='period' value='".$_SESSION['period']."' required>
						<button type='submit' class='btn bg-green text-primary' id='submit_grade' name='submit_grade' >
							<svg  xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'>
								<path d='M288 109.3V352c0 17.7-14.3 32-32 32s-32-14.3-32-32V109.3l-73.4 73.4c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l128-128c12.5-12.5 32.8-12.5 45.3 0l128 128c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L288 109.3zM64 352H192c0 35.3 28.7 64 64 64s64-28.7 64-64H448c35.3 0 64 28.7 64 64v32c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V416c0-35.3 28.7-64 64-64zM432 456a24 24 0 1 0 0-48 24 24 0 1 0 0 48z'/>
							</svg> Submit Grade
						</button>
					</form>";
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
    <!-- Header -->

   		<!-- Header & Breadcrumbs -->
		<!-- Page content -->
			<div class="container-fluid mt--6">
				  <div class="row">
					<div class="col">
					<div class="card">
					<div class="card-header border-0">
					  <div class="row">
						<div class="col-6">
						  <h3 class="mb-0 text-primary font-weight-bolder">Periodical Grade</h3>
						</div>
						<div class="col-6 text-right">
							<?php
								$subject_code=getrecord('course',['id'],[$schedule['course_id']]);
								$subject=(empty($subject_code['subject_code']) || $subject_code['subject_code']==NULL)?'':$subject_code['subject_code'];
								$faculty_id=getrecord('staff',['id'],[$schedule['faculty_id']]);
								$faculty_name=getrecord('user',['username'],[$faculty_id['username']]);
								$faculty_fname=(empty($faculty_name['firstname']) || $faculty_name['firstname']==NULL)?'':$faculty_name['firstname'];
								$faculty_lname=(empty($faculty_name['lastname']) || $faculty_name['lastname']==NULL)?'':$faculty_name['lastname'];
							?>
							<code class="text-default"><mark class="text-default">Class Code.: <?php echo  htmlspecialchars($class['class_code'], ENT_QUOTES, 'UTF-8'); ?></mark></code><br>
							<code class="text-default"><mark class="text-default">Program: <?php 
							$get_program=getrecord('program',['id'],[$class['program_id']]);
							echo ''.$get_program['name'].'-'.htmlspecialchars($class['level'], ENT_QUOTES, 'UTF-8');?></mark></code><br>
							<code class="text-default"><mark class="text-default">Subject Code: <?php echo htmlspecialchars($subject, ENT_QUOTES, 'UTF-8');?></mark></code><br>
							<code class="text-default"><mark class="text-default">Teacher : <?php echo htmlspecialchars($faculty_lname.', '.$faculty_fname, ENT_QUOTES, 'UTF-8');?></mark></code>
							
						</div>
					  </div>
					</div>
					<div class="table-responsive">
              			<table class="table align-items-center table-flush table-striped" id="datatable-buttons">
                			<thead class="thead-light">
								<tr>
									<th>No.</th>
									<th>Student No.</th>
									<th>Name</th>
									<th><?php echo $_SESSION['period'];?></th>
									<th>Remarks</th>
								</tr>
							</thead>
							
						<tbody>
							<?php
								try {
									$sql = "SELECT 
												`student`.`idno` AS `student_idno`,
												CONCAT(`student`.`lastname`, ', ', `student`.`firstname`, ' ', LEFT(`student`.`middlename`, 1), '.') AS `student_name`,
												`grade`.`".$_SESSION['period']."` AS `grade_period`
    
											FROM `participants`
											INNER JOIN `student` ON `student`.`id` = `participants`.`student_id`
											INNER JOIN `class` ON `class`.`id` = `participants`.`class_id`
											INNER JOIN `schedule` ON `schedule`.`class_id` = `class`.`id`
											INNER JOIN `course` ON `course`.`id` = `schedule`.`course_id`
											LEFT JOIN `grade` ON `grade`.`schedule_id` = `schedule`.`id` AND `grade`.`student_id` = `participants`.`student_id`
											WHERE `participants`.`class_id` = :class_id AND `schedule`.`id` = :schedule_id
											ORDER BY `student`.`lastname`";
								
									$query = $con->prepare($sql);
									$query->bindParam(':class_id', $_SESSION['class'], PDO::PARAM_INT);
									$query->bindParam(':schedule_id', $_SESSION['schedule'], PDO::PARAM_INT);
									$query->execute();
									$cnt = 0;
									while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
										// Your code to display the data goes here
										$cnt++;
								
								
							?>
						  <tr>
						  	<td  class="text-muted "><?php echo $cnt;?></td>
							<td  class="text-primary ">
								<?php
									$idno=(empty($row['student_idno']) || $row['student_idno']==NULL)?'':$row['student_idno'];
									echo htmlspecialchars($idno, ENT_QUOTES, 'UTF-8');
								?>
							</td>

							<td  class="text-primary">
								<?php
									$name=(empty($row['student_name']) || $row['student_name']==NULL)?'':$row['student_name'];
									echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
								?>		
							</td>

							<td  class="text-primary">
								<?php
									$period=(empty($row['grade_period']) || $row['grade_period']==NULL)?'':$row['grade_period'];
									echo htmlspecialchars($period, ENT_QUOTES, 'UTF-8');
								?>	
							</td>							
							<td class="text-primary">
								<?php
									$remarks=(empty($row['grade_period']) || $row['grade_period']==NULL)?'':$row['grade_period'];
									$note='';
									if (is_numeric($remarks)) {
										$numericGrade = floatval($remarks);
									
										if ($numericGrade < 75 && $numericGrade >= 50) {
											$note = 'FAILED';
										} else if ($numericGrade >= 75 && $numericGrade <= 100) {
											$note = 'PASSED';
										}
									} else {
										if ($remarks == 'UD') {
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
						  <?php  } //while
							}catch(Exception $e){
								$_SESSION['error']='Something went wrong in accessing scholarship program data.';
							}?>
						</tbody>
					  </table>
					</div>
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
