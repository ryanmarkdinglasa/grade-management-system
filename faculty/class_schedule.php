<?php
	//error_reporting(E_ALL);
	session_start();	
	include("include/session.php");
	include("../include/conn.php");
	include("../include/function.php");
	$parentpage='Class';
	$parentpage_link='';
	$page=$currentpage='Class Schedule';
	$content_right=''; $count_subject=0; $count_setted=0;
	//validate class id
	if(!isset($_GET['id'])){
        echo "<script>window.location.href='403.php';</script>";
        exit();
	}
	
	$_SESSION['class']=$_GET['id']; //validate class id if exist
	$class=getrecord('class',['id'],[$_SESSION['class']]);
	if(empty($class['class_code'])){
        echo "<script> window.location.href='404.php';</script>";
        exit();
    }
	
 ?>
	<?php include("include/header.php"); ?>
	</head>
	<?php include("include/sidebar.php"); ?>
	<!-- Main content -->
	<div class="main-content" id="panel">
		<?php
			include("include/topnav.php"); 
			include("include/snackbar.php"); 
			include("include/breadcrumbs.php"); 
		?> <!-- Header -->
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
							<td class="text-primary">
								<b>
								<?php 
									if(!empty($row['subject_code'])  || $row['description']!=NULL){
										$course_code = (isset($row['subject_code']) && !empty($row['unit'])) ? htmlspecialchars(short_text($row['subject_code']), ENT_QUOTES, 'UTF-8') : '';
										echo $course_code;
									} else{ echo 'row[subject_code]'; }
								?>
							  </b>
							</td>
							<td>
								<span class="text-primary">
									<?php 
										if(!empty($row['description']) || $row['description']!=NULL){
											$description = (isset($row['description'] ) && !empty($row['unit'])) ? htmlspecialchars(short_text($row['description']), ENT_QUOTES, 'UTF-8') : '';
											echo $description;
										} else{ echo $row['description']; }
									?>
								</span>
							</td>
							<td>
								<span class="text-primary">
									<?php 
										if(!empty($row['unit'])){
											$unit = (isset($row['unit'])) ? htmlspecialchars(short_text($row['unit']), ENT_QUOTES, 'UTF-8') : '';
											$unit =$unit==10?'0':$unit;
											echo $unit;
										} else{ echo $row['unit']; }
									?>
								</span>
							</td>
							<td class="text-center text-primary">
								<?php
									$get_schedule = "SELECT `course_id` FROM `schedule` WHERE `class_id` = :class_id AND `course_id` = :course_id LIMIT 1";
									$get_schedule_stmt = $con->prepare($get_schedule);
									$get_schedule_stmt->bindValue(':class_id', $_SESSION['class']);
									$get_schedule_stmt->bindValue(':course_id', $row['id']);
									$get_schedule_stmt->execute();
									$get_schedule_row = $get_schedule_stmt->fetch(PDO::FETCH_ASSOC);
									if (empty($get_schedule_row['course_id'])) {
									?>
									<a class="btn bg-green text-primary font-weigt-bolder btn-sm w-50" data-id="<?php echo $row['id'] ?>" style="color: black;" type="button" data-toggle="modal" data-target="#modal-edit-form<?php echo $row['id']; ?>">
										<svg  xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M0 416c0 17.7 14.3 32 32 32l54.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48L480 448c17.7 0 32-14.3 32-32s-14.3-32-32-32l-246.7 0c-12.3-28.3-40.5-48-73.3-48s-61 19.7-73.3 48L32 384c-17.7 0-32 14.3-32 32zm128 0a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zM320 256a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm32-80c-32.8 0-61 19.7-73.3 48L32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l246.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48l54.7 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-54.7 0c-12.3-28.3-40.5-48-73.3-48zM192 128a32 32 0 1 1 0-64 32 32 0 1 1 0 64zm73.3-64C253 35.7 224.8 16 192 16s-61 19.7-73.3 48L32 64C14.3 64 0 78.3 0 96s14.3 32 32 32l86.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48L480 128c17.7 0 32-14.3 32-32s-14.3-32-32-32L265.3 64z"/></svg>
										Set			
									</a>
								<?php
									} else{ $count_setted+=1;
										echo "<button class='btn text-white bg-red btn-sm w-50 ' disabled> Setted</button>";
									}	
								?>
							</td>
						  </tr>

						<div class="col-md-4">
							<div class="modal fade" id="modal-edit-form<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="modal-edit-form" aria-hidden="true">
								<div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
									<div class="modal-content">
										<div class="modal-body p-0">
											<div class="card bg-blue border-0 mb-0">
												<div class="card-body px-lg-5 py-lg-5">
													<div class="text-center text-white font-weight-bolder mb-4">
														<span>Set Schedule: </span>
														<label class="form-control-label mb-0 text-white"><?php echo ''.$row['subject_code']?></label>
													</div>
													<form role="form" method="post" action="class_controller.php">
														<input id="course_id" name="course_id" class="id form-control" value="<?php echo $row['id']?>"  type="hidden" required>
														<input id="class_id" name="class_id" class="id form-control" value="<?php echo $_GET['id']?>"  type="hidden" required>
														<div class="form-group mb-2">
															<label class="form-control-label mb-0  text-white">Day(s)</label>
															<div class="input-group input-group-merge input-group-alternative">
																<input  class="form-control"  name="days" id="days" placeholder="Enter day(s) schedule" type="text" oninvalid="this.setCustomValidity('Please enter a day(s) schedule.')" oninput="setCustomValidity('')" required>
															</div>
														</div>
														<div class="form-group mb-2">
															<label class="form-control-label mb-0  text-white">Time </label>
															<div class="input-group input-group-merge input-group-alternative">
																<input  class="form-control"  name="time" id="time" placeholder="Enter time schedule" type="text" oninvalid="this.setCustomValidity('Please enter time schedule.')" oninput="setCustomValidity('')" required>
															</div>
														</div>
														<div class="form-group mb-2">
															<label class="form-control-label mb-0  text-white">Room </label>
																<div class="input-group input-group-merge input-group-alternative">
																<input  class="form-control"  name="room" id="room" placeholder="Enter room" type="text" oninvalid="this.setCustomValidity('Please enter a room code/number.')" oninput="setCustomValidity('')" required>
															</div>
														</div>
														<div class="form-group mb-2">
															<label class="form-control-label mb-0  text-white">Teacher/Insturctor </label>
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
																		
																			while ($row2 = $f_stmt->fetch(PDO::FETCH_ASSOC)) {
																				echo "<option value='" . $row2['id'] . "'>" . $row2['lastname'] . ", " . $row2['firstname'] . "</option>";
																			}
																		} catch (Exception $e) {
																			$_SESSION['error'] = 'Something went wrong in accessing faculty.';
																		}	
																	?>
																</select>
															</div>
														</div>
														<div class="text-right">
															<button type="reset" id="cancel-button<?php echo $row['id'];?>" class="btn btn-primary my-4 sp-add bg-secondary text-primary font-weight-bolder" >Cancel</button>
															<button type="submit" id="set-schedule" name="set-schedule" class="btn btn-primary my-4 bg-green text-primary font-weight-bolder">Save</button>
														</div>
													</form>
												</div>
											</div>
										</div>
										
									</div>
								</div>
							</div>
							<script>
								document.addEventListener("DOMContentLoaded", function () {
									// Get a reference to the cancel button
									var cancelButton = document.getElementById("cancel-button<?php echo $row['id'];?>");

									// Get a reference to the modal
									var modal = document.getElementById("modal-edit-form<?php echo $row['id'];?>");

									// Add a click event listener to the cancel button
									cancelButton.addEventListener("click", function () {
										// Use Bootstrap's modal function to close the modal
										$(modal).modal("hide");
									});
								});
							</script>
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
					<?php if($count_subject==$count_setted){ ?>
						<div class="text-right my-3" style="margin-right:5.1%;">
							<button type="button" onclick="window.location.href='class_student.php?id=<?php echo $_SESSION['class'];?>'" class="btn bg-green text-primary "><i class="fa fa-plus"></i> Add Student</button>
						</div>
					<?php } ?>
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
