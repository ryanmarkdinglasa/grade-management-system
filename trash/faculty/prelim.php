<?php
	error_reporting(0);
	session_start();
	include("include/session.php");
	include("include/header.php");
	
	$parentpage='Grade';
	$parentpage_link='grade.php';
	$page=$currentpage='Grade';

	//validate user
	if ($user['position_id']!='3'){
        echo  "
            <script>
                window.location.href='403.php';
            </script>
        ";
        exit();
	}
	//validate class id and shced id
	if ((!isset($_GET['class_id'])) && (!isset($_GET['sched_id']))){
        echo  "
            <script>
                window.location.href='403.php';
            </script>
        ";
        exit();
	}
	




	//validate class id if exist
	$class=getrecord('class',['id'],[$_GET['class_id']]);
	if(empty($class['class_code'])){
  		 echo    "<script>window.location.href='404.php';</script>";
        exit();
    }

	//validate schedule id if exist
	$schedule=getrecord('schedule',['id'],[$_GET['sched_id']]);
	if(empty($class['class_code'])){
  		 echo    "<script>window.location.href='404.php';</script>";
        exit();
    }

	$get=getrecord('isgraded',['class_id','course_id'],[$_GET['class_id'],$_GET['sched_id']]);
	if($get!=false){
		echo    "<script>window.location.href='403.php';</script>";
		 exit();
 	}
	//SESSSION the class_id and the period
	$_SESSION['class']=$_GET['class_id'];
	$_SESSION['period']=$_GET['sched_id'];
	

	// ADD GRADE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prelim'])) {
    try {
		$regex = '/^[0-9]+(\.[0-9]+)?$|^[cdionu]+$/i';
			// Get the schedule_id from the form
			$schedule_id = $_POST['schedule_id'];
	
			$grades = $_POST['grades'];
			$notes = $_POST['notes'];
			$created_on = date('Y-m-d H:i:s');

			
				// Loop through the grades and notes arrays
				foreach ($grades as $student_id => $grade) {
					$student_id = intval($student_id); // Convert student_id to an integer
		
					// Validate $grade against the regex pattern
					if (!preg_match($regex, $grade)) {
						$_SESSION['error'] = 'Some student grade is not numerical or not INC, UD, OD.';
						echo "<script>window.location.href='".$_SERVER['REQUEST_URI']."';</script>";
						exit();
					}
		
					
					$note = htmlspecialchars(trim($notes[$student_id]), ENT_QUOTES, 'UTF-8'); // Sanitize the note
					if(isNumber($grade)){
						$grade = floatval($grade); // Convert the grade to a float
						// Check if the grade is below 50
						if ($grade < 50) {
							$_SESSION['error'] = 'Some student grade is below 50.';
							echo "<script>window.location.href='".$_SERVER['REQUEST_URI']."';</script>";
							exit();
						}
			
						// Check if the grade is higher than 100
						if ($grade > 100) {
							$_SESSION['error'] = 'Some student grade is higher than 100.';
							echo "<script>window.location.href='".$_SERVER['REQUEST_URI']."';</script>";
							exit();
						}
					}else if (is_string($grade)){
						
						$grade=strtoupper($grade);
					}

            // Execute the insert query for each student
            $insert_sql = "INSERT INTO `grade`(`student_id`, `schedule_id`, `prelim`, `note`, `created_on`) VALUES (:student_id, :schedule_id, :grade, :note, :created_on)";
            $insert_stmt = $con->prepare($insert_sql);
            $insert_stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
            $insert_stmt->bindParam(':schedule_id', $schedule_id, PDO::PARAM_INT);
            $insert_stmt->bindParam(':grade', $grade, PDO::PARAM_STR);
            $insert_stmt->bindParam(':note', $note, PDO::PARAM_STR);
            $insert_stmt->bindParam(':created_on', $created_on, PDO::PARAM_STR);
            $insert_stmt->execute();
        }

        $_SESSION['success'] = 'Prelim grades are submitted.';
        $update_sql = "INSERT INTO `isgraded`(`class_id`, `course_id`, `isPrelim`, `created_on`) VALUES (:class_id, :course_id, '1', :created_on)";
        $update_stmt = $con->prepare($update_sql);
        $update_stmt->bindParam(':class_id', $_SESSION['class'], PDO::PARAM_INT);
        $update_stmt->bindParam(':course_id', $_SESSION['period'], PDO::PARAM_INT);
        $update_stmt->bindParam(':created_on', $created_on, PDO::PARAM_STR);
        $update_stmt->execute();

        unset($_SESSION['class']);
        unset($_SESSION['period']);
        echo "<script>window.location.href='grading_sheet.php';</script>";
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = 'Something went wrong: ' . $e->getMessage();
    }

    // Redirect to the same page to prevent form resubmission on page refresh
    echo "<script>window.location.href='" . $_SERVER['REQUEST_URI'] . "';</script>";
    exit();
}
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
					  <li class="breadcrumb-item " aria-current="page"><a href="grading_sheet.php">Grading Sheet</a></li>
					  <li class="breadcrumb-item active" aria-current="page">Prelim|Grade Sheet Encoding <?php ?></li>
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
						  <h3 class="mb-0">Prelim|Grade Sheet Encoding</h3>
						  	<br>
						  	<?php
								$class=getrecord('class',['id'],[$_SESSION['class']]);
							?>
							<code class="text-default"><mark class="text-default">Class Code.: <?php echo ''.$class['class_code'];?></mark></code><br>
							<code class="text-default"><mark class="text-default">Program: <?php 
							$get_program=getrecord('program',['id'],[$class['program_id']]);
							echo ''.$get_program['name'];?></mark></code><br>
							<code class="text-default"><mark class="text-default">Year Level: <?php echo ''.$class['level'];?></mark></code><br>
							<?php
								$get_course=getrecord('course',['id'],[$schedule['course_id']]);
								$course_code=(empty($get_course['subject_code']) || $get_course['subject_code']==NULL)?'Empty':$get_course['subject_code'];
							?>
							<code class="text-default"><mark class="text-default">Subject Code: <?php echo ''.$course_code;?></mark></code>
						  
						</div>
						<div class="col-6 text-right">
							<label class="form-control-label">LEDEND:</label><br>
							<span class="text-muted"><small>99.00 - 100.0  96.00 - 98.99</small></span><br>
							<span class="text-muted"><small>93.00 - 95.99  90.00 - 92.99</small></span><br>
							<span class="text-muted"><small>86.00 - 89.99  83.00 - 85.99</small></span><br>
							<span class="text-muted"><small>80.00 - 82.99  77.00 - 79.99</small></span><br>
							<span class="text-muted "><small>75.00 - 76.99</small></span><br>
						</div>
					  </div>
					</div>
					<div class="table-responsive">
						<form action="" method="POST">
              			<table class="table align-items-center table-flush table-striped" >
                			<thead class="thead-light">
								<tr>
									<th>No.</th>
									<th>Student No.</th>
									<th>Name</th>
									<th>Numerical Grade</th>
									<th>Notes</th>
								</tr>
							</thead>
						<tbody>
							<?php
							try{
								$sql = "SELECT *,
										`participants`.`student_id` AS `stud_id`,
										`student`.`firstname` AS `student_firstname`,
										`student`.`lastname` AS `student_lastname`,
										`student`.`middlename` AS `student_middlename`,
										`student`.`idno` AS `student_idno`
										FROM `participants`
										INNER JOIN `student` ON `student`.`id` = `participants`.`student_id`
										WHERE `participants`.`class_id` = :class_id";

								$query = $con->prepare($sql);
								$query->bindParam(':class_id', $_SESSION['class'], PDO::PARAM_INT);
								$query->execute();
								$cnt = 1;
								while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
							?>
						  <tr>
						  	<td  class=" text-muted ">
								<?php
									$count=(empty($cnt) || $cnt==NULL)?'':$cnt;
									echo $count;
								?>
							</td>
							<td  class=" ">
								<?php
									$idno=(empty(trim($row['student_idno'])) || $row['student_idno']==NULL)?'':trim($row['student_idno']);
									echo htmlspecialchars($idno, ENT_QUOTES, 'UTF-8');
								?>
							</td>

							<td  class="">
								<?php
									$fname=(empty(trim($row['student_firstname'])) || $row['student_firstname']==NULL)?'':trim($row['student_firstname']);
									$lname=(empty(trim($row['student_lastname'])) || $row['student_lastname']==NULL)?'':trim($row['student_lastname']);
									$mname =(empty(trim($row['student_middlename'])) || $row['student_middlename']==NULL )?'':substr(trim($row['student_middlename']), 0, 1).'.';
									$name=$lname.', '.$fname.' '.$mname;
									echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
								?>				
							</td>

							<td class="text-center">
								<div class="form-group mb-2">
									<div class="input-group input-group-merge input-group-alternative">
										<input type="text" name="grades[<?php echo $row['stud_id']; ?>]" placeholder="Enter grade" class="grade form-control" required>
										<div class="input-group-prepend">
										<span class="input-group-text" data-toggle="tooltip" data-placement="top" title="None numerical input are INC, OD, UD"><i class="fas fa-question-circle"></i></span>
										</div>
									</div>
									<span class="error-message" style="display: none; color: red;">The input should be a numerical value.</span>
								</div>
							</td>

							<td class="text-center">
								<input type="text" name="notes[<?php echo $row['stud_id']; ?>]" placeholder="Enter note" class="form-control w-100">
							</td>	

						  </tr>						  
						  <?php
						  		$cnt++;
						  	  } //while
							
							}catch(Exception $e){
								$_SESSION['error']='Something went wrong in accessing participants.';
							}?>
						</tbody>
					  </table>
					  	<div class="text-right">
						  		
							  	<input type="hidden" id="schedule_id" name="schedule_id"value="<?php echo $_SESSION['period']?>" class="form-control w-100" required >
							<button type="submit" id="prelim" name="prelim" class="add btn btn-primary text-white my-4" style="margin-right:25px;">Submit</button>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	<?php
		include("include/footer.php"); //Edit topnav on this page
    ?>
				<script type="text/javascript">
					$(document).on("click", ".add", function () {
						var numbersRegex = /^[0-9]+(\.[0-9]+)?$|^[cdionu]+$/i;
						var specialCharsRegex = /[$&+,:;=?@#|'<>^*()%!-]/;

						var grade = $(".grade").val().trim();
						var errorMessageElement = $(".error-message");

						if (grade === '') {
							$(".grade").css({
								"border": "1px solid red",
							});
							errorMessageElement.text("This field is required.");
							errorMessageElement.fadeIn("fast");
							$(".grade").fadeIn("slow");
							$(".grade").focus();
							return false;
						}
						if (grade < 50) {
							$(".grade").css({
								"border": "1px solid red",
							});
							errorMessageElement.text("Grade should not be lower than 50");
							errorMessageElement.fadeIn("fast");
							$(".grade").fadeIn("slow");
							$(".grade").focus();
							return false;
						}
						if (grade > 100) {
							$(".grade").css({
								"border": "1px solid red",
							});
							errorMessageElement.text("Grade should not be higher than 100");
							errorMessageElement.fadeIn("fast");
							$(".grade").fadeIn("slow");
							$(".grade").focus();
							return false;
						}
						if (!numbersRegex.test(grade) || specialCharsRegex.test(grade)) {
							$(".grade").css({
								"border": "1px solid red",
								"color": "red",
							});
							errorMessageElement.text("The input should be a numerical value without special characters.");
							errorMessageElement.fadeIn("fast");
							$(".grade").fadeIn("slow");
							$(".grade").focus();
							return false;
						}

						// If the input is valid, hide the error message and proceed with other actions
						errorMessageElement.text("");
						errorMessageElement.fadeOut("fast");
						// ... any other actions you want to perform after validation ...
					});
				</script>

    		</div>
    	</div>
	</body>
</html>
