<?php
	//error_reporting(0);
	session_start();
	include("include/session.php");
	$parentpage='';
	$parentpage_link='';
	$page=$currentpage='Grade';
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
						  <h3 class="mb-0 font-weight-bolder text-primary">Grade</h3>
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
									<th>Program</th>
									<th>Academec Year&Term</th>
									<th class="">Option</th>
								</tr>
							</thead>
						<tbody>
						<?php
							try{
								$sql = "SELECT *,`class`.`id` AS `class_id`,
								`program`.`name` AS `program_name`,
								`program`.`id` AS `program_id`,
								`period`.`id` AS `period_id`,
								`period`.`year` AS `period_year`,
								`period`.`term` AS `period_term`
								FROM `class`
								INNER JOIN `program` ON `program`.`id` = `class`.`program_id`
								INNER JOIN `period` ON `period`.`id` = `class`.`period_id`
								WHERE `program`.`institute_id`='".$user['institute_id']."'
								";
								$query = $con->query($sql);
								$cnt = 0;
								while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
									$cnt++;
							?>
						  <tr>
						  	<td class="text-muted"><?php echo $cnt;?></td>
							<td class="table-user">
								<b>
								<?php 
								$name = isset($row['class_code']) ? htmlspecialchars(short_text($row['class_code']), ENT_QUOTES, 'UTF-8') : '';
								echo $name;
								?>
							  </b>
							</td>
							<td>
								<span class="text-muted">
									<?php 
										$level =(empty($row['level']) || $row['level']==NULL)?'0':$row['level'];
										$program_name =(empty($row['program_name']) || $row['program_name']==NULL)?'Empty':$row['program_name'];
										$program_name = isset($program_name) ? htmlspecialchars($row['program_name'], ENT_QUOTES, 'UTF-8') : '';
										echo $program_name.'-'.$level;
									?>
								</span>
							</td>

							<td>
								<span class="text-muted">
									<?php 
										$year = isset($row['period_year']) ? htmlspecialchars(short_text($row['period_year']), ENT_QUOTES, 'UTF-8') : '';
										if($row['period_term']=='1')$term='1st Semester';
										else if($row['period_term']=='2')$term='2nd Semester';
										else if($row['period_term']=='3')$term='Summer';
										
										echo $year.' '.$term;
									?>
								</span>
							</td>
							<td>
								<?php
									try {
										$subject_sql = "SELECT `schedule`.`id` AS `schedule_id`, `course`.`subject_code` AS `course_code`
														FROM `schedule`
														INNER JOIN `course` ON `course`.`id` = `schedule`.`course_id`
														WHERE `schedule`.`class_id` = :class_id
														ORDER BY `schedule`.`id`";
									
										$subject_stmt = $con->prepare($subject_sql);
										$subject_stmt->bindParam(':class_id',$row['class_id'], PDO::PARAM_INT);
										$subject_stmt->execute();
										$subjects = $subject_stmt->fetchAll(PDO::FETCH_ASSOC);
										$subjects_no = $subject_stmt->rowCount();
										$prelim_grade = $midterm_grade = $final_grade = 0;
									
										foreach ($subjects as $subject) {
											$schedule_id = htmlspecialchars($subject['schedule_id'], ENT_QUOTES, 'UTF-8');
											$isgraded = getrecord('isgraded', ['class_id', 'course_id'], [$row['class_id'], $schedule_id]);
											$isgraded = ($isgraded == false) ? '' : $isgraded;
											if (!empty($isgraded['isPrelim'])) $prelim_grade++;
											if (!empty($isgraded['isMidterm'])) $midterm_grade++;
											if (!empty($isgraded['isFinal'])) $final_grade++;
										}
									} catch (Exception $e) {
										// Handle exceptions if necessary
									}
									
									$link = '';
									$label = 'View grade';
									if (intval($final_grade) == intval($subjects_no) && intval($midterm_grade) == intval($subjects_no)) {
										$link = "grade_class.php?id={$row['class_id']}&period=final";
									} else if (intval($midterm_grade )== intval($subjects_no) && intval($prelim_grade) == intval($subjects_no)) {
										$link = "grade_class.php?id={$row['class_id']}&period=midterm";
									} else if (intval($prelim_grade) == intval($subjects_no)) {
										$link = "grade_class.php?id={$row['class_id']}&period=prelim";
									}
									if (!empty($link)): ?>
										<a href="<?php echo $link; ?>" class="btn bg-green text-primary btn-sm"><i class="fa fa-eye"></i>
										<?php echo $label; ?></a>
									<?php else: ?>
										<a href="#" class="btn bg-green text-primary btn-sm disabled"><i class="fa fa-eye"></i> No Grades</a>
									<?php endif; ?>
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
