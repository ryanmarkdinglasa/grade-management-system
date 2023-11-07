<?php
	error_reporting(0);
	session_start();
	include("include/session.php");
	include("include/header.php");

	$parentpage='Grade';
	$parentpage_link='grade.php';
	$page=$currentpage='Grade';

	//validate class id
	if (!isset($_GET['id']) || empty($_GET['id']) || !isset($_GET['period']) || empty($_GET['period']) || $_GET['period']!=='prelim'  && $_GET['period']!=='midterm' && $_GET['period']!=='final'){
        echo  "
            <script>
                window.location.href='403.php';
            </script>
        ";
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
					  <li class="breadcrumb-item "><a href="grade.php">Grade</a></li>
					  <li class="breadcrumb-item active" aria-current="page">Class Courses</li>
					</ol>
				  </nav>
				</div>
				<div class="col-lg-6 col-5 text-right">
				</div>
			  </div>
			</div>
		  </div>
		</div>
    <!-- Batas Header & Breadcrumbs -->
			<!-- Page content -->
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
							<form action="submit_grade.php" method="POST"> 
								<input type="hidden" name="class_id" value="<?php echo $_SESSION['class'];?>" required>
								<input type="hidden" name="period" value="<?php echo $_SESSION['period'];?>" required>
								<button type="submit" class="btn btn-primary btn-sm text-white" id="submit_grade" name="submit_grade" >
									<svg style="fill:#FFF;" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
										<path d="M288 109.3V352c0 17.7-14.3 32-32 32s-32-14.3-32-32V109.3l-73.4 73.4c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l128-128c12.5-12.5 32.8-12.5 45.3 0l128 128c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L288 109.3zM64 352H192c0 35.3 28.7 64 64 64s64-28.7 64-64H448c35.3 0 64 28.7 64 64v32c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V416c0-35.3 28.7-64 64-64zM432 456a24 24 0 1 0 0-48 24 24 0 1 0 0 48z"/>
									</svg> Submit Grade
								</button>
							</form>
							</a>
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
													echo "<button type='button' class='btn btn-primary btn-sm text-white' onclick=\"window.location.href='periodical_grade.php?id={$schedule_id}&period={$_SESSION['period']}'\">";
													echo "<i class='fa fa-eye'></i> view grade";
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
