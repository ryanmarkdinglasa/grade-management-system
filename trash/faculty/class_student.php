<?php
	error_reporting(0);
	session_start();
	include("include/session.php");
	$parentpage = "Class";
	$parentpage_link = "class.php";
	$currentpage = "Class Student";
	$page=$childpage = "Class";

	//validate class id
	if(!isset($_GET['id']) ){
        echo    "
            <script>
                window.location.href='403.php';
            </script>
        ";
        exit();
	}else{
		$_SESSION['class']=$_GET['id'];
	}
	//validate class id if exist
	$class=getrecord('class',['id'],[$_GET['id']]);
	
	if(empty($class['class_code'])){
        echo    "
            <script>
                window.location.href='404.php';
            </script>
        ";
        exit();
    }
	$count_participants=0;
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
		include("include/topnav.php"); //Edit topnav on this page
		?>
		<?php if(isset($_SESSION['success'])){ ?>
			<div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
			  <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
			  <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Success!</span>
				<span data-notify="message"><?php echo $_SESSION['success'];?></span>
			  </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
				<span aria-hidden="true">×</span></button>
			</div>
			<?php }  unset($_SESSION['success']); ?>

			<?php if(isset($_SESSION['error'])){ ?>
			<div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
			  <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
			  <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Fail!</span>
				<span data-notify="message"><?php echo $_SESSION['error'];?></span>
			  </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
				<span aria-hidden="true">×</span></button>
			</div>
			<?php }  unset($_SESSION['error']); ?>
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
					  <li class="breadcrumb-item" ><a href="student.php">Class</a></li>
					  <li class="breadcrumb-item active" aria-current="page">Class Student </li>
					</ol>
				  </nav>
				</div>
				<div class="col-lg-6 col-5 text-right">
				</div>
			  </div>
			</div>
		  </div>
		</div>
    	<!--  Header & Breadcrumbs -->
		<!-- Page content -->
			<div class="container-fluid mt--6">
				<div class="row">
					<div class="col">
						<div class="card">
							<div class="card-header border-0">
								<div class="row">
									<div class="col-6">
									<h3 class="mb-0">Student List </h3>
									</div>
									<div class="col-6 text-right">

									</div>
								</div>
							</div>
							<div class="table-responsive">
								<table class="table align-items-center table-flush table-striped" id="datatable-buttons">
									<thead class="thead-light">
										<tr>
											<th>Name</th>
											<th>Program & Year Level</th>
											<th>Email</th>
											<th class="text-center">Options</th>
										</tr>
									</thead>
									<tbody>
									<?php 
										try {
											$get_sql = "SELECT * FROM `participants` WHERE `class_id`=:class_id";
											$get_stmt = $con->prepare($get_sql);
											$get_stmt->bindParam(':class_id', $_GET['id'], PDO::PARAM_INT);
											$get_stmt->execute();
										
											$arr = array();
											while ($participants = $get_stmt->fetch(PDO::FETCH_ASSOC)) {
												$arr[] = $participants['student_id'];
											}
										
											// Check the array if it's empty
											if (!empty($arr)) {
												$include = "NOT IN (" . implode(",", $arr) . ")";
											} else {
												$include = "";
											}
										
											$sql = "SELECT *,
													`student`.`id` AS `student_id`,
													`program`.`id` AS `program_id`,
													`program`.`name` AS `program_name`,
													`institute`.`id` AS `institute_id`,
													`institute`.`name` AS `institute_name`
													FROM `student`
													INNER JOIN `program` ON `program`.`id` = `student`.`program_id`
													INNER JOIN `institute` ON `institute`.`id` = `program`.`institute_id`
													WHERE `institute`.`id` = :institute_id AND `student`.`level`>='".$class['level']."' AND `student`.`id` $include";
										
											$query = $con->prepare($sql);
											$query->bindParam(':institute_id', $user['institute_id'], PDO::PARAM_INT);
											$query->execute();
										
											while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
												// Display students who are not in the class or all students in the institute
												// Replace this with your actual display logic
									?>

										<tr>
										<td class="table-user">
									<?php 
											$userphoto = isset($row['picture']) ? htmlspecialchars(($row['picture']), ENT_QUOTES, 'UTF-8') : '';
											$userphoto = $row['picture'];
											if ($userphoto == "" || $userphoto == "NULL") :
											?>
											<img src="img/profile.png" class="avatar rounded-circle mr-3">
											<?php else : ?>
											<img src="../registrar/img/<?php echo $userphoto; ?>" class="avatar rounded-circle mr-3">
											<?php endif; ?>
											<b>
											<?php 
												$firstCharacter =(!empty($row['middlename']))?substr($row['middlename'], 0, 1):'';
												$name = $row['lastname'].', '.$row['firstname'].' '.$firstCharacter.'.';
												if (!$name == "" || !$name == "NULL") {
													$username_short = htmlentities($name);
													if (strlen($username_short) > 30) $username_short = substr($username_short, 0, 30) . "...";
													echo $username_short;
												}
											?>
											</b>
										</td>
										
										<td>
											<span class="text-muted">
											<?php
												$program = htmlentities($row['program_name']);
												$level = htmlentities($row['level']);
												echo $program.'-'.$level;
											?>
											</span>
										</td>

										<td>
											<a href="emailto:<?php echo htmlentities($row['username']); ?>" class="font-weight-bold"><?php echo htmlentities($row['username']); ?></a>
										</td>

										<!--<td>
											<span class="text-muted"><?php
											//$created_on = isset($row['created_on']) ? htmlspecialchars(created_on($row['created_on']), ENT_QUOTES, 'UTF-8') : '';
											//echo $created_on; ?>
											</span>
										</td>
									-->
										<td class="text-center">
											<?php
												// ADD STUDENT CLASS
												if (isset($_POST['add-student'])) {
													$student_id = $_POST['student_id'];
													$class_id = $_POST['class_id'];
													$created_on = date('Y-m-d H:i:s');

													//validate class id
													if($class_id==0 || $class_id==NULL || empty($class_id)){
														$_SESSION['error'] = 'Class is not found';
															echo "
																<script>
																	location.href='class.php';
																</script>
															";
															exit();
													}

													//validate student id
													if($student_id==0 || $student_id==NULL || empty($student_id)){
														$_SESSION['error'] = 'Student is not found';
															echo "
																<script>
																	location.href='class.php';
																</script>
															";
															exit();
													}
													//try add student
													try {
														$stmt = $con->prepare("INSERT INTO `participants`(`class_id`, `student_id`, `created_on`) VALUES(:class_id, :student_id, :created_on)");
														$stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
														$stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
														$stmt->bindParam(':created_on', $created_on);
														$stmt->execute();

														if ($stmt->rowCount() == 0) {
															$_SESSION['error'] = 'Student not found or already added';
															echo "
																<script>
																	location.href='class_student.php?id=$class_id';
																</script>
															";
															exit();
														}
													} catch (Exception $e) {
														$_SESSION['error'] = 'Something went wrong.' . $e->getMessage();
													}
													
													echo "
														<script>
															location.href='class_student.php?id=$class_id';
														</script>
													";
													exit();
												}
											?>
											<form action="" method="POST">
												<input type="hidden" id="student_id" name="student_id" value="<?php  echo $row['student_id'];?>">
												<input type="hidden" id="class_id" name="class_id" value="<?php echo $_SESSION['class'];?>">
												<input type="submit" class="btn btn-primary btn-sm text-white" name="add-student"  id="add-student"value="+ Student">
											</form>
											
										</td>
															

										</tr>
									<?php 
											} //while
										}catch(Exception $e){
											$_SESSION['error']='Something went wrong in accessing student data.';
										}
									?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col">
						<div class="card">
							<div class="card-header border-0">
								<div class="row">
									<div class="col-6">
									<h3 class="mb-0">Student Added</h3>
									</div>
									<div class="col-6 text-right">
										<label>
											<?php
												$cnt_sql = "SELECT * FROM `participants` WHERE `class_id`=:class_id";
												$cnt_stmt = $con->prepare($cnt_sql);
												$cnt_stmt->bindParam(':class_id', $_SESSION['class'], PDO::PARAM_INT);
												$cnt_stmt->execute();
												$cnt_students = $cnt_stmt->rowCount();
												echo '<h3 class="mb-0">Slot: '.htmlspecialchars($cnt_students, ENT_QUOTES, 'UTF-8')."/".$class['slot'].'</h3>' ;
											?>
										</label>
										<br>
										<code class="text-default"><mark class="text-default">Class Code.: <?php echo ''.$class['class_code'];?></mark></code><br>
										<code class="text-default"><mark class="text-default">Program: <?php 
											$get_program=getrecord('program',['id'],[$class['program_id']]);
											echo ''.$get_program['name'];?></mark></code><br>
										<code class="text-default"><mark class="text-default">Year Level: <?php echo ''.$class['level'];?></mark></code>
									
									</div>
								</div>
							</div>
							<div class="table-responsive">
								<table class="table align-items-center table-flush table-striped" id="datatable-buttons">
									<thead class="thead-light">
										<tr>
											<th>Name</th>
											<th>Program & Year Level</th>
											<th>Email</th>
											<th class="text-center">Options</th>
										</tr>
									</thead>
									<tbody>
									<?php 
										try{
											$sql = "SELECT *,
												`participants`.`id` AS `participants_id`,
												`program`.`name` AS `program_name`,
												`program`.`id` AS `program_id`
												FROM `participants`
											INNER JOIN `student` ON `student`.`id` =`participants`.`student_id`
											INNER JOIN `program` ON `program`.`id`=`student`.`program_id`
											WHERE `participants`.`class_id`='".$_SESSION['class']."'
											";
											$query = $con->query($sql);
											while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
									?>
										<tr>
										<td class="table-user">
											<?php 
											$userphoto = isset($row['picture']) ? htmlspecialchars(($row['picture']), ENT_QUOTES, 'UTF-8') : '';
											$userphoto = $row['picture'];
											if ($userphoto == "" || $userphoto == "NULL") :
											?>
											<img src="img/profile.png" class="avatar rounded-circle mr-3">
											<?php else : ?>
											<img src="../registrar/img/<?php echo $userphoto; ?>" class="avatar rounded-circle mr-3">
											<?php endif; ?>
											<b>
											<?php 
												$firstCharacter =(!empty($row['middlename']))?substr($row['middlename'], 0, 1):'';
												$name = $row['lastname'].', '.$row['firstname'].' '.$firstCharacter.'.';
												if (!$name == "" || !$name == "NULL") {
													$username_short = htmlentities($name);
													if (strlen($username_short) > 30) $username_short = substr($username_short, 0, 30) . "...";
													echo $username_short;
												}
											?>
											</b>
										</td>
										
										<td>
											<span class="text-muted">
											<?php
												$program = htmlentities($row['program_name']);
												$level = htmlentities($row['level']);
												echo $program.'-'.$level;
											?>
											</span>
										</td>

										<td>
											<a href="emailto:<?php echo htmlentities($row['username']); ?>" class="font-weight-bold"><?php echo htmlentities($row['username']); ?></a>
										</td>
										<!--
											<td>
												<span class="text-muted">
													<?php
														$created_on = isset($row['created_on']) ? htmlspecialchars(created_on($row['created_on']), ENT_QUOTES, 'UTF-8') : '';
													echo $created_on; 
													?>
												</span>
											</td>
										--->
											<td class="text-center">
												<a class="btn btn-danger border-none btn-sm text-white remove-button"  data-participants-id="<?php echo $row['participants_id']?>" data-class-id="<?php echo $_GET['id']?>"><i class="fas fa-minus"></i> Remove</a>
											</td>


										</tr>
									<?php 
									} //while
									}catch(Exception $e){
									$_SESSION['error']='Something went wrong in accessing class participants.';
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
	<script>
		// Find the element with the 'add-button' class and add a click event listener
		const addButton = document.querySelector('.add-button');
		addButton.addEventListener('click', function (event) {
			// Prevent the default behavior (refreshing the page)
			event.preventDefault();

			// Get the student_id and class_id from the data attributes
			const studentId = this.getAttribute('data-student-id');
			const classId = this.getAttribute('data-class-id');

			// You can perform any additional actions here before redirecting, if needed

			// Redirect to the specified URL without refreshing the page
			location.href = `class_student_add.php?id=${studentId}&class=${classId}`;
		});

	</script>
	<script>
		// Find all elements with the 'remove-button' class and add a click event listener
		const removeButtons = document.querySelectorAll('.remove-button');
		removeButtons.forEach(button => {
			button.addEventListener('click', function (event) {
				// Prevent the default behavior (refreshing the page)
				event.preventDefault();

				// Get the participants_id and class_id from the data attributes
				const participantsId = this.getAttribute('data-participants-id');
				const classId = this.getAttribute('data-class-id');

				// You can perform any additional actions here before removing the participant, if needed

				// Redirect to the specified URL without refreshing the page
				location.href = `class_student_remove.php?id=${participantsId}&class=${classId}`;
			});
		});

	</script>
	
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
