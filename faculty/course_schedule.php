<?php
	//error_reporting(0);
	session_start();
	include("include/session.php");
	$parentpage='';
	$parentpage_link='';
	$page=$currentpage='Course Schedule';
	$content_right='';
	include("include/header.php");	
	include("../include/conn.php");
	include("../include/function.php");
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
						  <h3 class="mb-0">Course List</h3>
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
							<th>Subject Code</th>
							<th>Descriptive Title</th>
							<th>Program & Year Level </th>
							<th>Unit</th>
							<th>Days(s)</th>
							<th>Time</th>
							<th>Room</th>
							<th>Teacher/Instructor</th>
						  </tr>
						</thead>
						<tbody>
						<?php
							try {
								// Establish database connection here (e.g., $con = new PDO(...);)

								$sql = "SELECT *,
				
										`course`.`id` AS `course_id`,
										`course`.`subject_code` AS `course_code`,
										`course`.`description` AS `course_description`,
										`course`.`level` AS `course_level`,
										`course`.`unit` AS `course_unit`,
										`program`.`id` AS `program_id`,
										`program`.`description` AS `program_description`,
										`program`.`name` AS `program_name`,
										`staff`.`username` AS `staff_username`,
										`user`.`lastname` AS `user_lastname`,
										`user`.`firstname` AS `user_firstname`
										FROM `schedule`
										INNER JOIN `course` ON `course`.`id` = `schedule`.`course_id`
										INNER JOIN `program` ON `program`.`id` = `course`.`program_id`
										INNER JOIN `staff` ON `staff`.`id` = `schedule`.`faculty_id`
										INNER JOIN `user` ON `user`.`username` = `staff`.`username`
										WHERE `program`.`institute_id` = :institute_id";

								$institute_id = 2; // Replace this with the actual institute ID or a parameter

								$query = $con->prepare($sql);
								$query->bindParam(':institute_id', $institute_id, PDO::PARAM_INT);
								$query->execute();
								$count=1;
								while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
									$count++;
									// Process each row here
									?>
									<tr>
										<td  class="text-muted">
											<?php 
												echo $count;
											?>
										</td>
										<td class="text-muted">
											<b>
											<?php 
												$course_code=(empty($row['course_code']) || $row['course_code']==NULL)?'Empty':$row['course_code'];
												$course_code = isset($course_code) ? htmlspecialchars(short_text($course_code), ENT_QUOTES, 'UTF-8') : '';
												echo $course_code;
											?>
											</b>
										</td>

										<td class="text-muted">
											<?php 
												$description=(empty($row['course_description']) || $row['course_description']==NULL)?'Empty':$row['course_description'];
												$description = isset($description) ? htmlspecialchars($description, ENT_QUOTES, 'UTF-8') : '';
												echo $description;
											?>
										</td>

										<td class="text-muted">
											<?php 
												$program_name=(empty($row['program_name']) || $row['program_name']==NULL)?'Empty':$row['program_name'];
												$program_name = isset($program_name) ? htmlspecialchars($program_name, ENT_QUOTES, 'UTF-8') : '';
												$course_level=(empty($row['course_level']) || $row['course_level']==NULL)?'Empty':$row['course_level'];
												$course_level = isset($course_level) ? htmlspecialchars($course_level, ENT_QUOTES, 'UTF-8') : '';
												echo $program_name.'-'.$course_level;
											?>
										</td>

										<td class="text-muted">
											<?php 
												$course_unit=(empty($row['course_unit']) || $row['course_unit']==NULL)?'Empty':$row['course_unit'];
												$course_unit = isset($course_unit) ? htmlspecialchars($course_unit, ENT_QUOTES, 'UTF-8') : '';
												echo $course_unit;
											?>
										</td>

										<td class="text-muted">
											<?php 
												$schedule_day=(empty($row['days']) || $row['days']==NULL)?'Empty':$row['days'];
												$schedule_day = isset($schedule_day) ? htmlspecialchars($schedule_day, ENT_QUOTES, 'UTF-8') : '';
												echo $schedule_day;
											?>
										</td>

										<td class="text-muted">
											<?php 
												$schedule_time=(empty($row['time']) || $row['time']==NULL)?'Empty':$row['time'];
												$schedule_time = isset($schedule_time) ? htmlspecialchars($schedule_time, ENT_QUOTES, 'UTF-8') : '';
												echo $schedule_time;
											?>
										</td>
										
										<td class="text-muted">
											<?php 
												$schedule_room=(empty($row['room']) || $row['room']==NULL)?'Empty':$row['room'];
												$schedule_room = isset($schedule_room) ? htmlspecialchars($schedule_room, ENT_QUOTES, 'UTF-8') : '';
												echo $schedule_room;
											?>
										</td>

										<td class="text-muted">
											<?php 
												$user_lastname=(empty($row['user_lastname']) || $row['user_lastname']==NULL)?'Empty':$row['user_lastname'];
												$user_lastname = isset($user_lastname) ? htmlspecialchars($user_lastname, ENT_QUOTES, 'UTF-8') : '';
												$user_firstname=(empty($row['user_firstname']) || $row['user_firstname']==NULL)?'Empty':$row['user_firstname'];
												$user_firstname = isset($user_firstname) ? htmlspecialchars($user_firstname, ENT_QUOTES, 'UTF-8') : '';
												echo $user_lastname.', '.$user_firstname;
											?>
										</td>

						  			</tr>

						  
						
									<?php
								}
							} catch (PDOException $e) {
								// Handle exceptions here (e.g., echo $e->getMessage();)
							}
							?>
							
						  
						</tbody>
					  </table>
					</div>
				</div>
			</div>
		</div>
	<?php
		include("include/footer.php"); //Edit topnav on this page
    ?>
	
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
	
		document.getElementById("close_direct").onclick = function () {
			location.href = "institute.php";
		};
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
