<?php
	//error_reporting(0);
	session_start();
	include("include/session.php");
	$parentpage='';
	$parentpage_link='';
	$page=$currentpage='Course';
	$content_right='';
	include("../include/conn.php");
	include("../include/function.php");
	include("include/header.php");
	?>
	</head>
	<?php include("include/sidebar.php"); ?>
	<!-- Main content -->
	<div class="main-content" id="panel">
		<?php
			include("include/topnav.php");
			include("include/snackbar.php");
			include "include/breadcrumbs.php"; // Snackbar & Breadcrumbs -->
		?>
			<!-- Page content -->
			<div class="container-fluid mt--6">
				  <div class="row">
					<div class="col">
					<div class="card">
					<div class="card-header border-0">
					  <div class="row">
						<div class="col-6">
						  <h3 class="mb-0 text-primary font-weight-bolder">Course List</h3>
						</div>
						<div class="col-6 text-right">
						</div>
					  </div>
					</div>
					<div class="table-responsive">
              			<table class="table align-items-center table-flush table-striped" id="datatable-buttons">
                			<thead class="thead-light">
						  <tr>
							<th>Subject Code</th>
							<th>Descriptive Title</th>
							<th>Program </th>
							<th>Total Unit</th>
							<th>Hour(s)</th>
							<th>Prerequisite</th>
							<th>Date Created</th>
						  </tr>
						</thead>
						<tbody>
							<?php
							try{
								$sql3 = "SELECT *,
								`course`.`id` AS `course_id`,
								`course`.`description` AS `course_description`,
								`program`.`id` AS `program_id`,
								`program`.`description` AS `program_description`,
								`program`.`name` AS `program_name`
								FROM `course`
								INNER JOIN `program` ON `program`.`id`=`course`.`program_id`
								";
								$query3 = $con->query($sql3);
								while ($row3 = $query3->fetch(PDO::FETCH_ASSOC)) {
							?>
						  <tr>
							<td class="text-primary">
								<b>
									<?php 
										$name = isset($row3['subject_code']) ? htmlspecialchars(short_text($row3['subject_code']), ENT_QUOTES, 'UTF-8') : '';
										echo $name;
									?>
							  	</b>
							</td>

							<td>
								<span class="text-primary">
									<?php 
										$description = isset($row3['course_description']) ? htmlspecialchars(short_text($row3['course_description']), ENT_QUOTES, 'UTF-8') : '';
										echo $description;
									?>
								</span>
							</td>

							<td>
								<span class="text-primary">
									<?php 
										$program_name = isset($row3['program_name']) ? htmlspecialchars(short_text($row3['program_name']), ENT_QUOTES, 'UTF-8') : '';
										echo $program_name.'-'.$row3['level'].''.$row3['term'];
									?>
								</span>
							</td>
							<td>
								<span class="text-primary">
									<?php 
										if($row3['unit']!=0 || empty($row3['unit'])){
											$unit = isset($row3['unit']) ? htmlspecialchars($row3['unit'], ENT_QUOTES, 'UTF-8') : '';
											echo $unit;
										}
										else{
											echo '0';
										}										
									?>
								</span>
							</td>

							<td>
								<span class="text-primary">
									<?php 
										$hours = isset($row3['hours']) ? htmlspecialchars($row3['hours'], ENT_QUOTES, 'UTF-8') : '';
										echo $hours;
									?>
								</span>
							</td>

							<td>
								<span class="text-primary ">
									<?php 
										if ($row3['prerequisite']=='0'){
											echo "None";
										}else{
											$prerequisite=getrecord('course',['id'],[$row3['prerequisite']]);
											echo $prerequisite['subject_code'];
										}
									?>
								</span>
							</td>

							<td>
							  <span class="text-primary"><?php
							  $created_on = isset($row3['created_on']) ? htmlspecialchars(created_on($row3['created_on']), ENT_QUOTES, 'UTF-8') : '';
							  ?></span><label title="<?php echo formatDate($created_on); ?>"> <?php echo $created_on; ?></label>
							</td>
						  </tr>

						  <div class="col-md-4">
							<div class="modal fade" id="modal-edit-form<?php echo $row3['course_id'];?>" tabindex="-1" role="dialog" aria-labelledby="modal-edit-form" aria-hidden="true">
								<div class="modal-dialog modal- modal-dialog-centered modal" role="document">
									<div class="modal-content">
										<div class="modal-body p-0">
											<div class="card bg-secondary border-0 mb-0">
												<div class="card-body px-lg-5 py-lg-5">
													<div class="text-center text-muted mb-3">
														<small class="form-control-label">Add New Course</small>
													</div>
													<form role="form" method="post" action="course_controller.php">
													<input value="<?php echo ''.$row3['course_id'];?>" type="hidden" class="form-control"  name="edit_id" id="edit_id"   required>
														<div class="form-group mb-2">
															<label class="form-control-label mb-0">Subject Code</label>
															<div class="input-group input-group-merge input-group-alternative">
																<input  value="<?php echo ''.$row3['subject_code'];?>" type="text" class="form-control"  name="edit_subject_code" id="edit_subject_code" placeholder="Enter subject code" type="text" oninvalid="this.setCustomValidity('Please enter a subject code.')" oninput="setCustomValidity('')" required>
															</div>
														</div>
													
														<div class="form-group mb-2">
															<label class="form-control-label mb-0">Descriptive Title </label>
															<div class="input-group input-group-merge input-group-alternative">
																<input  value="<?php echo ''.$row3['course_description'];?>" type="text" class="form-control" id="edit_description" name="edit_description" placeholder="Enter descriptive title" title="Enter descriptive title"  oninvalid="this.setCustomValidity('Please enter a descriptive title.')" oninput="setCustomValidity('')" required>
															</div>
														</div>

														<div class="form-group mb-2">
															<label class="form-control-label mb-0">Program </label>
															<div class="input-group input-group-merge input-group-alternative">
																<select  class="form-control" id="edit_program" name="edit_program" placeholder="Enter program" title="Enter  program"  oninvalid="this.setCustomValidity('Please enter program.')" oninput="setCustomValidity('')" required>
																	<?php
																		echo "<option value='".$row3['program_id']."'>".$row3['program_name']."</option>";
																		echo"<option vlaue=''>Select Program</option>";
																		try{
																			$query2="SELECT * FROM `program`";
																			$stmt2 = $con->prepare($query2);
																			$stmt2->execute();
																			$result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
																		}catch(Exception $e){
																					$_SESSION['error']='Something went wrong accessing program.';
																		}
																			foreach ($result2 as $row2) {
																			echo"<option value=".$row2['id'].">".$row2['name']."</option>";
																		}
																	?>
																</select>
															</div>
														</div>
														
														<div class="row">
															<div class="col">
																<div class="form-group mb-2">
																	<label class="form-control-label mb-0">Year Level </label>
																	<div class="input-group input-group-merge input-group-alternative">
																		<select  class="form-control" id="edit_level" name="edit_level" placeholder="Enter level" title="Enter  level"  oninvalid="this.setCustomValidity('Please enter year level.')" oninput="setCustomValidity('')" required>
																			<?php
																			if($row3['level']=='1'){
																				$edit_level='1st Year';
																			}
																			else if($row3['level']=='2'){
																				$edit_level='2nd Year';
																			}
																			else if($row3['level']=='3'){
																				$edit_level='3rd Year';
																			}
																			else if($row3['level']=='4'){
																				$edit_level='4th Year';
																			}
																			else{
																				$edit_level='Error';
																			}
																			echo "<option value='".$row3['level']."'>".$edit_level."</option>";
																			?>
																			<option vlaue=''>Select Year Level</option>
																			<option value='1'> 1st Year</option>
																			<option value='2'> 2nd Year</option>
																			<option value='3'> 3rd Year</option>
																			<option value='4'> 4th Year</option>
																		</select>
																	</div>
																</div>
															</div>
															<div class="col">
																<div class="form-group mb-2">
																	<label class="form-control-label mb-0">Term </label>
																	<div class="input-group input-group-merge input-group-alternative">
																		<select class="form-control" id="edit_term" name="edit_term" placeholder="Enter term" title="Enter term"  oninvalid="this.setCustomValidity('Please enter term.')" oninput="setCustomValidity('')" required>
																		<?php
																			if($row3['term']=='1'){
																				$edit_term='1st Semester';
																			}
																			else if($row3['term']=='2'){
																				$edit_term='2nd Semester';
																			}
																			else if($row3['term']=='3'){
																				$edit_term='Summer';
																			}
																			else{
																				$edit_term='Error';
																			}
																			echo "<option value='".$row3['term']."'>".$edit_term."</option>";
																			?>
																			<option vlaue=''>Select Term</option>
																			<option value='1'>1st Semester</option>
																			<option value='2'>2nd Semester</option>
																			<option value='3'>Summer</opti	on>
																		</select>
																	</div>
																</div>
															</div>
															
														</div>

														<div class="row">
															<div class="col">
																<div class="form-group mb-2">
																	<label class="form-control-label mb-0">Lab Unit </label>
																	<div class="input-group input-group-merge input-group-alternative">
																		<input value="<?php echo ''.$row3['lab_unit'];?>" type="number" class="form-control" id="edit_lab" name="edit_lab" placeholder="Enter unit" title="Enter  unit"  oninvalid="this.setCustomValidity('Please enter a labaratory unit.')" oninput="setCustomValidity('')" required>
																	</div>
																</div>
															</div>
															<div class="col">
																<div class="form-group mb-2">
																	<label class="form-control-label mb-0">Lec Unit </label>
																	<div class="input-group input-group-merge input-group-alternative">
																		<input value="<?php echo ''.$row3['lec_unit'];?>" type="number" class="form-control" id="edit_lec" name="edit_lec" placeholder="Enter  unit" title="Enter unit"  oninvalid="this.setCustomValidity('Please enter a lecture unit.')" oninput="setCustomValidity('')" required>
																	</div>
																</div>
															</div>
															<div class="col">
																<div class="form-group mb-2">
																	<label class="form-control-label mb-0">Hours</label>
																	<div class="input-group input-group-merge input-group-alternative">
																		<input value="<?php echo ''.$row3['hours'];?>" type="number" class="form-control" id="edit_hours" name="edit_hours" placeholder="Enter hourse per session " title="Enter hours"  oninvalid="this.setCustomValidity('Please enter a hours.')" oninput="setCustomValidity('')" required>
																	</div>
																</div>
															</div>
														</div>
													
														

														<div class="form-group mb-2">
															<label class="form-control-label mb-0">Pre-requisite</label>
															<div class="input-group input-group-merge input-group-alternative">
																<select class="form-control" id="edit_prerequisite" name="edit_prerequisite" placeholder="Enter prerequisite" title="Enter prerequisite"  oninvalid="this.setCustomV	ustomValidity('')" required>
																<?php
																	$edit_prerequisite=getrecord('course',['id'],[$row3['prerequisite']]);
																	if($edit_prerequisite['id']==0){
																		echo"<option vlaue='0'>None</option>";
																	}
																	else{
																		echo "<option value='".$edit_prerequisite['id']."'>".$edit_prerequisite['subject_code']."</option>";
																	}
																?>
																<option vlaue=''>Select Prerequisite</option>
																<option vlaue='0'>None</option>
																<?php
																	try{
																		$query="SELECT * FROM `course`";
																		$stmt = $con->prepare($query);
																		$stmt->execute();
																		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
																	}catch(Exception $e){
																		$_SESSION['error']='Something went wrong accessing course.';
																	}
																		foreach ($result as $row) {
																		echo"<option value=".$row['id'].">".$row['subject_code']."</option>";
																	}
																?>
																</select>
															</div>
														</div>

														<div class="text-center">
														<button type="submit" id="edit-program" name="edit-program" class="btn btn-primary my-4">Save</button>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div> 
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
