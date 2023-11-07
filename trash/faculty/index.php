<?php
	session_start();
	error_reporting(0);
	include("include/session.php");
	$parentpage = "dashboard";
	include("include/header.php");
	//
?>
	<script>
		if (window.history.replaceState) {
		  window.history.replaceState(null, null, window.location.href);
		}
	</script>
	<style>

	</style>
	</head>
		<?php
			include("include/sidebar.php");
		?>
		<!-- ain content -->
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
					  <h6 class="h2 text-white d-inline-block mb-0">Dashboard</h6>
					  <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
						<ol class="breadcrumb breadcrumb-links breadcrumb-dark">
						  <li class="breadcrumb-item"><a href="./"><i class="fas fa-home"></i></a></li>
						  <li class="breadcrumb-item active" aria-current="page">Dashboard
						  </li>
						</ol>
					  </nav>
					</div>
					<div class="col-lg-6 col-5 text-right">
					</div>
				  </div>
				  <!-- Card stats -->
					<div class="row">
						<div class="col-xl-12 col-md-3">
							<div class="card card2 card-stats">
								<div class="card-body">
									<div class="row">
										<div class="col">
											<h1>
												<svg style=""xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M243.4 2.6l-224 96c-14 6-21.8 21-18.7 35.8S16.8 160 32 160v8c0 13.3 10.7 24 24 24H456c13.3 0 24-10.7 24-24v-8c15.2 0 28.3-10.7 31.3-25.6s-4.8-29.9-18.7-35.8l-224-96c-8-3.4-17.2-3.4-25.2 0zM128 224H64V420.3c-.6 .3-1.2 .7-1.8 1.1l-48 32c-11.7 7.8-17 22.4-12.9 35.9S17.9 512 32 512H480c14.1 0 26.5-9.2 30.6-22.7s-1.1-28.1-12.9-35.9l-48-32c-.6-.4-1.2-.7-1.8-1.1V224H384V416H344V224H280V416H232V224H168V416H128V224zM256 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
												<?php 
													$getrecord=getrecord('institute',['id'],[$user['institute_id']]);
													$description=(empty($getrecord['description'])|| $getrecord['description']==NULL)?'':$getrecord['description'];
													echo ''.$description;
												?>
											</h1>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				
				  <div class="row">
				  	<?php if($user['position_id']=='2'){?>
					<div class="col-xl-4 col-md-3 cursor-pointer" onclick="window.location.href='faculty.php'">
					  <div class="card card2 card-stats">
						<div class="card-body">
						  <div class="row">
							<div class="col">
							  	<h5 class="card-title text-uppercase text-muted mb-0">Faculty</h5>
							  	<span class="h2 font-weight-bold mb-0"> 
								<?php
									$query= "SELECT * FROM `staff` WHERE `position_id`='2' OR `position_id`='3' AND `institute_id`='".$user['institute_id']."' ";
									$stmt =$con->prepare($query);
									$stmt -> execute();
									$count =$stmt->rowCount();
									echo"".$count;
								?>
								</span>
							</div>
							<div class="col-auto">
							  <div class="icon icon-shape bg-green text-white rounded-circle shadow">
							  	<svg style="fill:#FFF;" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M192 96a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm-8 384V352h16V480c0 17.7 14.3 32 32 32s32-14.3 32-32V192h56 64 16c17.7 0 32-14.3 32-32s-14.3-32-32-32H384V64H576V256H384V224H320v48c0 26.5 21.5 48 48 48H592c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48H368c-26.5 0-48 21.5-48 48v80H243.1 177.1c-33.7 0-64.9 17.7-82.3 46.6l-58.3 97c-9.1 15.1-4.2 34.8 10.9 43.9s34.8 4.2 43.9-10.9L120 256.9V480c0 17.7 14.3 32 32 32s32-14.3 32-32z"/></svg>
							  </div>
							</div>
						  </div>
						   <p class="mt-3 mb-0 text-sm">
							<span class="text-nowrap text-black">Total Faculty in this institute</span>
						  </p> 
						</div>
					  </div>
					</div>

					<div class="col-xl-4 col-md-3 cursor-pointer" onclick="window.location.href='student.php'">
					  <div class="card card2 card-stats">
						<div class="card-body">
						  <div class="row">
							<div class="col">
							  	<h5 class="card-title text-uppercase text-muted mb-0">Student</h5>
							 	<span class="h2 font-weight-bold mb-0">
								<?php
									$query= "SELECT * FROM `student`";
									$stmt =$con->prepare($query);
									$stmt -> execute();
									$count =$stmt->rowCount();
									echo"".$count;
								?>
								</span>
							</div>
							<div class="col-auto">
							  <div class="icon icon-shape bg-green text-white rounded-circle shadow">
							  <svg style="fill:#FFF;" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z"/></svg>
							  </div>
							</div>
						  </div>
						   <p class="mt-3 mb-0 text-sm">
							<span class="text-nowrap text-black">Total Student in this institute</span>
						  </p> 
						</div>
					  </div>
					</div>

					<div class="col-xl-4 col-md-3 cursor-pointer" onclick="window.location.href='course.php'">
					  <div class="card card2 card-stats">
						<div class="card-body">
						  <div class="row">
							<div class="col">
							  	<h5 class="card-title text-uppercase text-muted mb-0">Course</h5>
							 	<span class="h2 font-weight-bold mb-0">
								<?php
									$query= "SELECT  `program`.`institute_id` AS `institute_id`
										FROM `course`
										INNER JOIN `program` ON `program`.`id`=`course`.`program_id`
										WHERE `program`.`institute_id`='".$user['institute_id']."'";
									$stmt =$con->prepare($query);
									$stmt -> execute();
									$count =$stmt->rowCount();
									echo"".$count;
								?>
							</div>
							<div class="col-auto">
							  <div class="icon icon-shape bg-green text-white rounded-circle shadow">
							 	<i class="ni ni-books text-white"></i>
							  </div>
							</div>
						  </div>
						   <p class="mt-3 mb-0 text-sm">
							<span class="text-nowrap text-black">Total Courses in this institute</span>
						  </p> 
						</div>
					  </div>
					</div>
					<?php
						}else if($user['position_id']=='3'){
					?>
					<div class="col-xl-6 col-md-3 cursor-pointer" onclick="window.location.href='student_list.php'">
					  <div class="card card2 card-stats">
						<div class="card-body">
						  <div class="row">
							<div class="col">
							  	<h5 class="card-title text-uppercase text-muted mb-0">Student</h5>
							 	<span class="h2 font-weight-bold mb-0">
								<?php
									$query= "SELECT
											`student`.`id` AS `student_id`
											FROM `participants`
											INNER JOIN `student` ON `student`.`id`= `participants`.`student_id`
											INNER JOIN `program` ON `program`.`id` =`student`.`program_id`
											INNER JOIN `institute` ON `institute`.`id`=`program`.`institute_id`
											INNER JOIN `schedule` ON `schedule`.`class_id`=`participants`.`class_id`
											WHERE `schedule`.`faculty_id` ='".$user['staff_id']."'
											GROUP BY `student`.`id`";
									$stmt =$con->prepare($query);
									$stmt -> execute();
									$count =$stmt->rowCount();
									echo"".$count;
								?>
								</span>
							</div>
							<div class="col-auto">
							  <div class="icon icon-shape bg-green text-white rounded-circle shadow">
							  <svg style="fill:#FFF;" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z"/></svg>
							  </div>
							</div>
						  </div>
						   <p class="mt-3 mb-0 text-sm">
							<span class="text-nowrap text-black">Total handled student</span>
						  </p> 
						</div>
					  </div>
					</div>
					<div class="col-xl-6 col-md-3 cursor-pointer" onclick="window.location.href='class_course.php'">
					  <div class="card card2 card-stats">
						<div class="card-body">
						  <div class="row">
							<div class="col">
							  	<h5 class="card-title text-uppercase text-muted mb-0">Class 

								</h5>
							 	<span class="h2 font-weight-bold mb-0">
								<?php
									$query2= "SELECT 
									`schedule`.`id` AS `schedule_id`
									FROM `class`
									INNER JOIN `schedule` ON `schedule`.`class_id` = `class`.`id`
									INNER JOIN `course` ON `course`.`id`=`schedule`.`course_id`
									INNER JOIN `program` ON `program`.`id`=`class`.`program_id`
									INNER JOIN `period` ON `period`.`id`=`class`.`period_id`
									WHERE `schedule`.`faculty_id` = :faculty_id
									";
									$stmt2 = $con->prepare($query2);
									$stmt2->bindParam(':faculty_id', $user['staff_id'], PDO::PARAM_INT);
									$stmt2->execute();
									$count2 =$stmt2->rowCount();
									echo"".$count2;
								?>
							</div>
							<div class="col-auto">
							  <div class="icon icon-shape bg-green text-white rounded-circle shadow">
							 	<i class="ni ni-books text-white"></i>
							  </div>
							</div>
						  </div>
						   <p class="mt-3 mb-0 text-sm">
							<span class="text-nowrap text-black">Total handled Course</span>
						  </p> 
						</div>
					  </div>
					</div>
					<?php
						}  
					?>
					</div>
				  </div>
				</div>
			  </div>
						
			
			<!-- CLASS GRADED -->
			<div class="container-fluid mt--6">
				<!--<div class="row">
			  		<div class="col-xl-12">
						<div class="card">
							<div class="card-header">
								<h6 class="text-black text-uppercase ls-1 mb-1"></h6>
								<h5 class="h3 text-uppercase text-primary mb-0">CLASS GRADED </h5>
								<span class="text-muted"></h5>
							</div>
							<div class='card-body'>
								<?php 
									/*try{
										$cg_sql="SELECT 
												`schedule`.`course_id` AS `schedule_course_id`,
												`course`.`subject_code` AS `course_code`,
												`isgraded`.`isPrelim` AS `prelim`,
												`isgraded`.`isMidterm` AS `midterm`,
												`isgraded`.`isFinal` AS `final`
										FROM `schedule`
										INNER JOIN `class` ON `class`.`id`=`schedule`.`class_id` 
										INNER JOIN `period` ON `period`.`id`=`class`.`period_id`
										INNER JOIN `course` ON `course`.`id`=`schedule`.`course_id`
										INNER JOIN `isgraded` ON `isgraded`.`course_id`=`schedule`.`id`
										WHERE `faculty_id`=:staff_id
										AND `class`.`period_id`= :academic_year
										";
										$cg_stmt=$con ->prepare($cg_sql);
										$cg_stmt->bindParam(':staff_id', $user['staff_id'], PDO::PARAM_INT);
										$cg_stmt->bindParam(':academic_year', $_SESSION['academic-year'], PDO::PARAM_INT);
										$cg_stmt->execute();
										$class = $cg_stmt->fetchAll(PDO::FETCH_ASSOC);
										foreach ($class as $course) {
											//var_dump($class);
									
								?>
								<div class="class-graded expansion-panel">
									<div class="panel-header border-radius" onclick="togglePanel(this.parentNode)">
										Panel Title
									</div>
									<div class="row">
										<div class="col-xl-12 ">
											<div class="bg-red panel-content">
												readdir
											</div>
										</div>
									</div>
								</div>	
								<?php
									}
								}catch(PDOException $e){
									$_SESSION['error']='Something went wrong accessing class graded.';
								}
								*/
								?>
							</div>
						</div>
					</div>
				</div>-->
				<!-- CLASS GRADED -->
				<br>
				<div class="row">
				
					<?php
					try{
						$sql = "SELECT 
							`post`.`id` AS `post_id`,
							`post`.`user_id` AS `post_user`,
							`post`.`title` AS `post_title`,
							`post`.`context` AS `post_context`,
							`post`.`status` AS `post_status`,
                            `post`.`created_on` AS `post_on`,
							`user`.`type` AS `user_type`,
							`user`.`profileImage` AS `user_image`,
							`user`.`firstname` AS `user_fname`, `user`.`lastname` AS `user_lname`
							 FROM `post` 
							 INNER JOIN `user` ON `user`.`id`= `post`.`user_id`
							 WHERE `post`.`status`='1' ORDER BY `post_on` DESC";
						$query = $con->query($sql);
						$count=$query->rowCount();
						if($count<1){
					?>
						<div class="col-xl-12">
							<div class="card">
							  <div class="card-header">
								<h6 class="text-black text-uppercase ls-1 mb-1">ANNOUNCEMENT</h6>
								<h5 class="h3 text-uppercase text-primary mb-0"> </h5>
								<span class="text-muted"><?php //echo $row['created_on']; ?></h5>
							  </div>
							  <div class='card-body'>No Data Found
								<?php //echo $row['context']; ?>
							  </div>
							</div>
						</div>
					<?php
						}
						else{
					?>
						<div class="col-xl-12">
							<div class="card">
							  <div class="card-header">
								<h4 class="text-black text-uppercase ls-1 mb-1"><i class="ni ni-notification-70"></i> ANNOUNCEMENT</h4>
								<h5 class="h3 text-uppercase text-primary mb-0"> </h5>
								<span class="text-muted"><?php //echo $row['created_on']; ?></h5>
							  </div>
							  
							</div>
						</div>
					<?php
						}
						while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
							
					?>
					<div class="col-xl-12">
						<div class="card">
						  <div class="card-header">
							<div class="poster">
							<?php $userphoto = $row['user_image'];
								if ($userphoto == "" || $userphoto == "NULL") :
								 echo' <img src="img/profile.png" class="avatar rounded-circle mr-3">';
								else : 
									//echo$row['user_type'];
								   echo'<img src="../'.$row['user_type'].'/img/'.htmlentities($userphoto).'" class="avatar rounded-circle mr-3">';
								endif;
								//Posted By & Posted On
								echo '<h5 class="text-black  mb-0">'.$row['user_fname'].' '.$row['user_lname'].'<br>';
								echo'<span class="text-muted""><small>';
								$post_created=''.$row['post_on'];
								echo $row['user_type'].' | '.created_on($post_created);
								echo'</small></span></h5>';
								?>
								<?php
								if($user['user_id']==$row['post_user']){
								?>
								<div class="text-right" style="margin-top:-30px;">
									<div class="dropdown">
									  <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fas fa-ellipsis-v"></i>
									  </a>
									  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										<a class="dropdown-item" href="announcement_edit.php?id=<?php echo $row['post_id'] ?>&edit=edit" style="color: black;" type="button"><i class="fas fa-pen" style="color:#172b4d;"></i> Edit post</a>
										<a class="dropdown-item" href="announcement_controller.php?id=<?php echo $row['post_id'] ?>&del=delete" onClick="return confirm('Are you sure you want to clear, <?php echo htmlentities($row['post_title']); ?> ?')"><i class="fas fa-trash" style="color:#f5365c;"></i> Delete post</a>
									  </div>
									</div>
								</div>
								<?php }?>
							</div>
						  </div>
						  <div class='card-body'>
							<h5 class="h3 text-uppercase text-primary mb-0"><?php echo $row['post_title']; ?></h5>
							<?php echo $row['post_context']; ?>
						  </div>
						</div>
					</div>
					<?php	
						}//while
					}catch(Exception $e){
						$_SESSION['error']='Something went wrong in accessing annoouncement post.';
					}
					?>
				</div>
				<?php
					include("include/footer.php"); //Edit topnav on this page
				?>
			</div>
		</div>
	</body>
	<style>
		.expansion-panel {
		border: 1px solid #ccc;
		border-radius: 4px;
		margin-bottom: 10px;
		overflow: hidden;
		}

		.panel-header {
		background-color: #f1f1f1;
		padding: 10px;
		cursor: pointer;
		}

		.panel-content {
		padding: 10px;
		display: none;
		}

		.expanded .panel-content {
		display: block;
		}
	</style>
	<script>
    function togglePanel(panel) {
      panel.classList.toggle("open");
    }

	const panelHeaders = document.querySelectorAll('.panel-header');
	panelHeaders.forEach(header => {
	header.addEventListener('click', () => {
		const panel = header.parentElement;
		panel.classList.toggle('expanded');
	});
	});
  </script>
</html>