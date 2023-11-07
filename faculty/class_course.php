<?php
	//error_reporting(0);
	session_start();
	include("include/session.php");
	$parentpage='';
	$parentpage_link='';
	$page=$currentpage='Class';
	$content_right='';
	include("include/header.php");
	include("../include/conn.php");
	include("../include/function.php");
	
	//validate faculty user
	if ($user['position_id']!='3'){
        echo  "<script>window.location.href='403.php'; </script>";
        exit();
	}
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
						  <h3 class="mb-0 font-weight-bolder text-primary">Class</h3>
						</div>
						<div class="col-6 text-right">
						</div>
					  </div>
					</div>
					<div class="table-responsive">
              			<table class="table align-items-center table-flush table-striped" id="datatable-buttons">
                			<thead class="thead-light">
								<tr>
									<th>No.</th>
									<th>Class Code</th>
									<th>Program & Year Level</th>
									<th>Academec Year&Term</th>
									<th>Unit</th>
									<th>Day(s)</th>
									<th>Time</th>
									<th>Room</th>
								</tr>
							</thead>
						<tbody>
							<?php
							try{
								$cnt=0;
								$sql = "SELECT *,
								`schedule`.`id` AS `schedule_id`,
								`program`.`id` AS `program_id`,
								`program`.`name` AS `program_name`,
								`class`.`id` AS `class_id`,
								`course`.`id` AS `course_id`,
								`course`.`subject_code` AS `course_code`,
								`period`.`year` AS `period_year`,
								`period`.`term` AS `period_term`
								FROM `class`
								INNER JOIN `schedule` ON `schedule`.`class_id` = `class`.`id`
								INNER JOIN `course` ON `course`.`id`=`schedule`.`course_id`
								INNER JOIN `program` ON `program`.`id`=`class`.`program_id`
								INNER JOIN `period` ON `period`.`id`=`class`.`period_id`
								WHERE `schedule`.`faculty_id` = :faculty_id
								";
								$stmt = $con->prepare($sql);
								$stmt->bindParam(':faculty_id', $user['staff_id'], PDO::PARAM_INT);
								$stmt->execute();
								while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
									$cnt++;
							?>
						  <tr>
						  	<td class="text-muted"><?php echo ''.$cnt;?></td>
							<td class="table-user">
								<b>
								<?php 
								$name=(empty($row['class_code']) || ($row['class_code']==NULL))?'Empty':$row['class_code'];
								$course=(empty($row['course_code']) || ($row['course_code']==NULL))?'Empty':$row['course_code'];
								$course = isset($course) ? htmlspecialchars($course, ENT_QUOTES, 'UTF-8') : '';
								$name = isset($name) ? htmlspecialchars($name, ENT_QUOTES, 'UTF-8') : '';
								echo $course.' '.$name;
								?>
							  </b>
							</td>
							<td>
								<span class="text-primary">
									<?php 
										$program_name=(empty($row['program_name']) || ($row['program_name']==NULL))?'Empty':$row['program_name'];
										$level=(empty($row['level']) || ($row['level']==NULL))?'0':$row['level'];
										$program_name = isset($program_name) ? htmlspecialchars(short_text($program_name), ENT_QUOTES, 'UTF-8') : '';
										$level = isset($level) ? htmlspecialchars($level, ENT_QUOTES, 'UTF-8') : '';
										echo $program_name.'-'.$level;
									?>
								</span>
							</td>
							<td>
								<span class="text-primary">
									<?php
										$period_year=(empty($row['period_year']) || ($row['period_year']==NULL))?'Empty':$row['period_year'];
										$period_year = isset($period_year) ? htmlspecialchars($period_year, ENT_QUOTES, 'UTF-8') : '';
										if($row['period_term']=='1'){
											$term='1st Semester';
										}
										else if($row['period_term']=='2'){
											$term='2nd Semester';
										}
										else if($row['period_term']=='3'){
											$term='Summer';
										}
										echo $period_year.' '.$term;
									?>
								</span>
							</td>
							<td>
							  <span class="text-primary">
								<?php
							  		$unit=(empty($row['unit']) || ($row['unit']==NULL))?'Empty':$row['unit'];
									$unit = isset($unit) ? htmlspecialchars($unit, ENT_QUOTES, 'UTF-8') : '';
									echo ''.$unit;
							  	?>
							  </span>
							</td>
							<td>
							  <span class="text-primary">
								<?php
							  		$days=(empty($row['days']) || ($row['days']==NULL))?'Empty':$row['days'];
									$days = isset($days) ? htmlspecialchars($days, ENT_QUOTES, 'UTF-8') : '';
									echo ''.$days;
							  	?>
							  </span>
							</td>

							<td class="text-primary">
								<?php
							  		$time=(empty($row['time']) || ($row['time']==NULL))?'Empty':$row['time'];
									$time = isset($time) ? htmlspecialchars($time, ENT_QUOTES, 'UTF-8') : '';
									echo ''.$time;
							  	?>
							</td>
							<td class="text-primary">
								<?php
							  		$room=(empty($row['room']) || ($row['room']==NULL))?'Empty':$row['room'];
									$room = isset($room) ? htmlspecialchars($room, ENT_QUOTES, 'UTF-8') : '';
									echo ''.$room;
							  	?>
							</td>
						  </tr>
						  <?php  } //while
							}catch(Exception $e){
								$_SESSION['error']='Something went wrong in accessing class course.';
							}?>
						</tbody>
					  </table>
					</div>
				</div>
			</div>
		</div>
	<?php include("include/footer.php"); ?>
	<script type="text/javascript">
	$(function(){
	   $(document).on('click', '.edit', function(e){
		e.preventDefault();
		$('#modal-edit-form').modal('show');
		var id = $(this).data('id');
		//document.getElementById('edit_name').value='bogog-mama';
		getRow(id);
	  });
	});
	function getRow(id){
	  $.ajax({
		type: 'POST',
		url: 'institute_row.php',
		data: {id:id},
		dataType: 'json',
		success: function(response){
		  $('.edit_id').val(response.id);
		  $('#edit_name').val(response.name);
		  $('#edit_description').val(response.description);
		}
	  });
	}
	</script>
	<script type="text/javascript">
		$(document).on("click", ".add",function(){
				var lettersRegex = /^[a-zA-Z\s]+$/;
				var numbersRegex = /^[0-9]+$/;
				var specialCharactersRegex = /^[a-zA-Z0-9\s]*$/;
				var sp_name=document.getElementById("name").value.trim();
				if (sp_name==='') {
					$("#name").css({ 
						"border" :"1px solid red",
					});
					$("#name").fadeIn("slow");
					$("#name").focus();
				   return false;
				}
				if (!lettersRegex.test(sp_name)) {
					 $("#name").css({ 
						"border" :"1px solid red",
						"color" :"red",
					});
					$("#name").fadeIn("slow");
					$("#name").focus();
				   return false;
				}
				var sp_description=document.getElementById("description").value.trim();
				if (sp_description==='') {
					$("#description").css({ 
						"border" :"1px solid red",
					});
					$("#description").fadeIn("slow");
					$("#description").focus();
				   return false;
				}
				if (!lettersRegex.test(sp_description)) {
					 $("#sdescription").css({ 
						"border" :"1px solid red",
						"color" :"red",
					});
					$("#description").fadeIn("slow");
					$("#description").focus();
				   return false;
				}
		});
	</script>
        	</div>
    	</div>
	</body>
</html>
