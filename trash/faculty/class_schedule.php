<?php
	error_reporting(0);
	session_start();
	include("../include/conn.php");
	include("include/session.php");
	include("../include/function.php");
	$parentpage='Class';
	$parentpage_link='';
	$page=$currentpage='Class Schedule';

	//validate class id
	if(!isset($_GET['id'])){
        echo    "
            <script>
                window.location.href='403.php';
            </script>
        ";
        exit();
	}
	$_SESSION['class']=$_GET['id'];

	//validate class id if exist
	$class=getrecord('class',['id'],[$_SESSION['class']]);
	if(empty($class['class_code'])){
        echo    "
            <script>
                window.location.href='404.php';
            </script>
        ";
        exit();
    }
	
	$count_subject=0;
	$count_setted=0;
	
 ?>
	<?php
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
					  <li class="breadcrumb-item"><a href="class.php">Class</a></li>
					  <li class="breadcrumb-item active" aria-current="page">Class Schedule</li>
					</ol>
				  </nav>
				</div>
				<div class="col-lg-6 col-5 text-right">
				</div>
			  </div>
			</div>
		  </div>
		</div>
    <!-- Header & Breadcrumbs -->
			<!-- Page content -->
			<div class="container-fluid mt--6">
				  <div class="row">
					<div class="col">
					<div class="card">
					<div class="card-header border-0">
					  <div class="row">
						<div class="col-6">
						  <h3 class="mb-0">Class Schedule </h3>
						</div>
						<div class="col-6 text-right">
							<code class="text-default"><mark class="text-default">Class Code.: <?php echo ''.$class['class_code'];?></mark></code><br>
							<code class="text-default"><mark class="text-default">Program: <?php 
							$get_program=getrecord('program',['id'],[$class['program_id']]);
							echo ''.$get_program['name'];?></mark></code><br>
							<code class="text-default"><mark class="text-default">Year Level: <?php echo ''.$class['level'];?></mark></code>
						</div>
					  </div>
					</div>
					<div class="table-responsive">
              			<table class="table align-items-center table-flush table-striped" >
                			<thead class="thead-light">
						  <tr>
							<th>Course Code</th>
							<th>Description</th>
							<th>Unit</th>
							<th class="text-center">Option</th>
						  </tr>
						</thead>
						<tbody>
							<?php
								try{
								$period = getrecord('period', ['id'], [$class['period_id']]);
								$sql = "SELECT *
										FROM `course`
										WHERE `program_id` = :program_id
										AND `level` = :level
										AND `term` = :term
										ORDER BY `subject_code`";
								$stmt = $con->prepare($sql);
								$stmt->bindValue(':program_id', $class['program_id']);
								$stmt->bindValue(':level', $class['level']);
								$stmt->bindValue(':term', $period['term']);
								$stmt->execute();
								while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
									$count_subject+=1;
							?>
						  	<tr>
							<td class="table-user">
								<b>
								<?php 
									if(!empty($row['subject_code'])  || $row['description']!=NULL){
										$course_code = (isset($row['subject_code']) && !empty($row['unit'])) ? htmlspecialchars(short_text($row['subject_code']), ENT_QUOTES, 'UTF-8') : '';
										echo $course_code;
									}
									else{
										echo 'row[subject_code]';
									}
								?>
							  </b>
							</td>
							<td>
								<span class="text-muted">
									<?php 
										if(!empty($row['description']) || $row['description']!=NULL){
											$description = (isset($row['description'] ) && !empty($row['unit'])) ? htmlspecialchars(short_text($row['description']), ENT_QUOTES, 'UTF-8') : '';
											echo $description;
										}
										else{
											echo $row['description'];
										}
									?>
								</span>
							</td>
							<td>
								<span class="text-muted">
									<?php 
										if(!empty($row['unit'])){
											$unit = (isset($row['unit'])) ? htmlspecialchars(short_text($row['unit']), ENT_QUOTES, 'UTF-8') : '';
											$unit =$unit==10?'0':$unit;
											echo $unit;
										}
										else{
											echo $row['unit'];
										}
									?>
								</span>
							</td>
							<td class="text-center">
								<?php
									$get_schedule = "SELECT `course_id` FROM `schedule` WHERE `class_id` = :class_id AND `course_id` = :course_id LIMIT 1";
									$get_schedule_stmt = $con->prepare($get_schedule);
									$get_schedule_stmt->bindValue(':class_id', $_SESSION['class']);
									$get_schedule_stmt->bindValue(':course_id', $row['id']);
									$get_schedule_stmt->execute();
									$get_schedule_row = $get_schedule_stmt->fetch(PDO::FETCH_ASSOC);
									if (empty($get_schedule_row['course_id'])) {
									?>
									<a class="btn btn-primary text-white" data-id="<?php echo $row['id'] ?>" style="color: black;" type="button" data-toggle="modal" data-target="#modal-edit-form<?php echo $row['id']; ?>">
										<svg style="fill:#FFF" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M0 416c0 17.7 14.3 32 32 32l54.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48L480 448c17.7 0 32-14.3 32-32s-14.3-32-32-32l-246.7 0c-12.3-28.3-40.5-48-73.3-48s-61 19.7-73.3 48L32 384c-17.7 0-32 14.3-32 32zm128 0a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zM320 256a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm32-80c-32.8 0-61 19.7-73.3 48L32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l246.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48l54.7 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-54.7 0c-12.3-28.3-40.5-48-73.3-48zM192 128a32 32 0 1 1 0-64 32 32 0 1 1 0 64zm73.3-64C253 35.7 224.8 16 192 16s-61 19.7-73.3 48L32 64C14.3 64 0 78.3 0 96s14.3 32 32 32l86.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48L480 128c17.7 0 32-14.3 32-32s-14.3-32-32-32L265.3 64z"/></svg>
										Set			
									</a>
								<?php
									}
									else{
										$count_setted+=1;
										echo "<button class='btn text-white bg-red' disabled> Setted</button>";
									}	
								?>
							</td>
						  </tr>

						  <div class="col-md-4">
							<div class="modal fade" id="modal-edit-form<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="modal-edit-form" aria-hidden="true">
								<div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
									<div class="modal-content">
										<div class="modal-body p-0">
											<div class="card bg-secondary border-0 mb-0">
												<div class="card-body px-lg-5 py-lg-5">
													<div class="text-center text-muted mb-4">
														<small>Set Schedule: </small>
														<label class="form-control-label mb-0"><?php echo ''.$row['subject_code']?></label>
													</div>
													<form role="form" method="post" action="class_controller.php">
														
														<input id="course_id" name="course_id" class="id form-control" value="<?php echo $row['id']?>"  type="hidden" required>
														<input id="class_id" name="class_id" class="id form-control" value="<?php echo $_GET['id']?>"  type="hidden" required>
														
														<div class="form-group mb-2">
															<label class="form-control-label mb-0">Day(s)</label>
															<div class="input-group input-group-merge input-group-alternative">
																<input  class="form-control"  name="days" id="days" placeholder="Enter day(s) schedule" type="text" oninvalid="this.setCustomValidity('Please enter a day(s) schedule.')" oninput="setCustomValidity('')" required>
															</div>
														</div>

														<div class="form-group mb-2">
															<label class="form-control-label mb-0">Time </label>
															<div class="input-group input-group-merge input-group-alternative">
																<input  class="form-control"  name="time" id="time" placeholder="Enter time schedule" type="text" oninvalid="this.setCustomValidity('Please enter time schedule.')" oninput="setCustomValidity('')" required>
															</div>
														</div>

														<div class="form-group mb-2">
															<label class="form-control-label mb-0">Room </label>
																<div class="input-group input-group-merge input-group-alternative">
																<input  class="form-control"  name="room" id="room" placeholder="Enter room" type="text" oninvalid="this.setCustomValidity('Please enter a room code/number.')" oninput="setCustomValidity('')" required>
															</div>
														</div>

														<div class="form-group mb-2">
															<label class="form-control-label mb-0">Teacher/Insturctor </label>
																<div class="input-group input-group-merge input-group-alternative">
																<select  class="form-control"  name="faculty_id" id="faculty_id" placeholder="Enter room" type="text" oninvalid="this.setCustomValidity('Please enter a faculty id.')" oninput="setCustomValidity('')" required>
																	<option value="">Select Faculty</option>
																	<?php
																		try {
																			$position_id = 3;
																			$f_sql = "SELECT * FROM `user`
																					  INNER JOIN `staff` ON `staff`.`username` = `user`.`username`
																					  WHERE `staff`.`institute_id` = :institute_id AND `staff`.`position_id` = :position_id";
																			
																			$f_stmt = $con->prepare($f_sql);
																			$f_stmt->bindParam(':institute_id', $user['institute_id'], PDO::PARAM_INT);
																			$f_stmt->bindParam(':position_id', $position_id, PDO::PARAM_INT);
																			$f_stmt->execute();
																		
																			while ($row = $f_stmt->fetch(PDO::FETCH_ASSOC)) {
																				echo "<option value='" . $row['id'] . "'>" . $row['lastname'] . ", " . $row['firstname'] . "</option>";
																			}
																		} catch (Exception $e) {
																			$_SESSION['error'] = 'Something went wrong in accessing faculty.';
																		}	
																	?>
																</select>
															</div>
														</div>
														<div class="text-center">
															<?php
															
															?>

															<button type="submit" id="set-schedule" name="set-schedule" class="btn btn-primary my-4">
															<svg style="fill:white"xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V173.3c0-17-6.7-33.3-18.7-45.3L352 50.7C340 38.7 323.7 32 306.7 32H64zm0 96c0-17.7 14.3-32 32-32H288c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V128zM224 288a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg>
																Save
															</button>
														</div>
													</form>
												</div>
											</div>
										</div>
										
									</div>
								</div>
							</div>
						</div> 
						  <?php  
									} //while
								}catch(Exception $e){
									$_SESSION['error']='Something went wrong in accessing scholarship program data.';
								}
							?>
						</tbody>
					  </table>
					</div>
					<?php
						if($count_subject==$count_setted){
					?>
					
						<div class="text-right my-3" style="margin-right:95px;">
							<button type="button" onclick="window.location.href='class_student.php?id=<?php echo $_SESSION['class'];?>'" class="btn btn-primary "><i class="fa fa-plus"></i> Add Student</button>
						</div>
					<?php
						}
					?>
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
