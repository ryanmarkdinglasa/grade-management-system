<?php
	//error_reporting(0);
	session_start();
	include("include/session.php");
	include("include/header.php");

	$parentpage='Grade';
	$parentpage_link='grade.php';
	$page='Grade Class';
	$currentpage='Grade';
	$content_right='';
	include("../include/conn.php");
	include("../include/function.php");
  	include("include/header.php");

	//validate class id
	if (!isset($_GET['id']) || empty($_GET['id']) || !isset($_GET['period']) || empty($_GET['period']) || $_GET['period']!=='prelim'  && $_GET['period']!=='midterm' && $_GET['period']!=='final'){
        echo  " <script> window.location.href='403.php'; </script> ";
        exit();
	}

	//validate class id if exist
	$class=getrecord('class',['id'],[$_GET['id']]);
	if($class==false){
  		echo    "<script>window.location.href='404.php';</script>";
        exit();
    }
	//SESSSION the class_id and the period
	$_SESSION['class']=$_GET['id'];
	$_SESSION['period']=$_GET['period'];
	?>
	</head>
	<?php include("include/sidebar.php"); ?>
	<div class="main-content" id="panel">
		<?php
			include("include/topnav.php"); 
			include("include/snackbar.php");
			include("include/breadcrumbs.php");
		?>
			<div class="container-fluid mt--6">
				  <div class="row">
					<div class="col">
					<div class="card">
					<div class="card-header border-0">
					  <div class="row">
						<div class="col-6">
						  <h3 class="mb-0">Class Courses</h3>
						  <!--<button class="btn btn-primary text-white btn-sm" style="margin-top:60px;position:absolute;"><i class="fa fa-bell"> </i> Notify Students</button>-->
						</div>
						<div class="col-6 text-right">
							<code class="text-default"><mark class="text-default">Class Code.: <?php echo  htmlspecialchars($class['class_code'], ENT_QUOTES, 'UTF-8');?></mark></code><br>
							<code class="text-default"><mark class="text-default">Program: <?php 
							$get_program=getrecord('program',['id'],[$class['program_id']]);
							echo ''.$get_program['name'];?></mark></code><br>
							<code class="text-default"><mark class="text-default">Year Level: <?php echo  htmlspecialchars($class['level'], ENT_QUOTES, 'UTF-8');?></mark></code><br>
							<br>
						</div>
					  </div>
					</div>
					<div class="table-responsive">
              			<table class="table align-items-center table-flush table-striped" id="">
                			<thead class="thead-light">
								<tr>
									<th>No.</th>
									<th>Subject Code</th>
									<th class="">Periodical Grade</th>
								</tr>
							</thead>
							<tfoot class="thead-light">
								<tr>
									<th>No.</th>
									<th>Subject Code</th>
								
									<th class="">Periodical Grade</th>
								</tr>
							</tfoot>
						<tbody>
							<?php
								try {
									$subject_sql = "SELECT `schedule`.`id` AS `schedule_id`, `course`.`subject_code` AS `course_code`
													FROM `schedule`
													INNER JOIN `course` ON `course`.`id` = `schedule`.`course_id`
													WHERE `schedule`.`class_id` = :class_id
													ORDER BY `schedule`.`id`";
																
									$subject_stmt = $con->prepare($subject_sql);
									$subject_stmt->bindParam(':class_id', $_SESSION['class'], PDO::PARAM_INT);
									$subject_stmt->execute();
									$subjects = $subject_stmt->fetchAll(PDO::FETCH_ASSOC);
									$cnt=0;
									foreach ($subjects as $subject) {
										$cnt++;
										$schedule_id = htmlspecialchars($subject['schedule_id'], ENT_QUOTES, 'UTF-8');
										$course_code = htmlspecialchars($subject['course_code'], ENT_QUOTES, 'UTF-8');
										$isgraded=getrecord('isgraded',['class_id','course_id'],[$_SESSION['class'],$schedule_id]);
										$isgraded=($isgraded==false)?'':$isgraded;

										echo "<tr>";
											echo "<td>";	
												echo "<label>" .$cnt. "</label>";
											echo "</td>";
											echo "<td class=''>";	
												echo "<label class='form-control-label'>" .$course_code. "</label>";
											echo "</td>";
											echo "<td class=''>";	
													echo "<button type='button' class='btn bg-green text-primary btn-sm ' onclick=\"window.location.href='periodical_grade.php?id={$schedule_id}&period={$_SESSION['period']}'\">";
													echo "<i class='fa fa-eye text-primary' ></i> View grade";
													echo "</button>";
											echo "</td>";
										echo "</tr>";

									}
								
								} catch (Exception $e) {
									// Handle exceptions if necessary
								}
							?>
						</tbody>
					  </table>
					</div>
				</div>
			</div>
		</div>
	<?php include("include/footer.php");  ?>
        </div>
      </div>
	</body>
</html>
