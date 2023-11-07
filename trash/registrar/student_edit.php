 <?php
	error_reporting(0);
	session_start();
	include("include/session.php");
	include("include/header.php");

	$currentTime = date('d-m-Y h:i:s A', time());
    if(!isset($_GET['id'])){
        echo    "
            <script>
                window.location.href='404.php';
            </script>
        ";
        exit();
	}
    $id = intval($_GET['id']);
    $student=getrecord('student',['id'],[$_GET['id']]);
    if(empty($student['username'])){
        echo    "
            <script>
                window.location.href='404.php';
            </script>
        ";
        exit();
    }
	?>

	</head>
		<script>
		function userAvailability() {
		  $("#loaderIcon").show();
		  jQuery.ajax({
			url: "check_username.php",
			data: 'username=' + $("#username").val(),
			type: "POST",
			success: function(data) {
			  $("#user-availability-status1").html(data);
			  $("#loaderIcon").hide();
			},
			error: function() {}
		  });
		}
	  </script>
	<body class="bg-primary">
	<!-- Main content -->
		<div class="main-content">
			<section class="py-2 pb-3 pt-6" >
				<div class="container mt-4 pb-3" >
					<div class="row justify-content-center" >
						<div class="col-lg-9 col-md-7" >
							<div class="card bg-secondary border-0 mb-0">
									<div class="card-header pb-0 text-start">
										<div class="row mb-0">
											<div class="col-6">
											<h3 class="mb-0">Students</h3>
											</div>
											<div class="col-6 text-right mb-2">
												<a type="button" href="student.php" class="btn btn-primary btn-round btn-icon" style="color:white;">
													<span class="btn-inner--text" style="color:white;"> Back</span>
												</a>
											</div>
										</div>
									</div>
									
									<form action="student_edit_controller.php" method="POST" enctype="multipart/form-data" class="needs-validation">
										<?php include("inlcude/prompt.php");?>
										<div class="row">
										<input value="<?php echo"".$_GET['id'];?>" type="hidden" onBlur="" id="student_id" name="student_id" required>
											<div class="col-lg-6">
												<div class="form-group">
													<label class="form-control-label" for="input-first-name">Email Address</label>
													<div class="input-group input-group-merge input-group-alternative">
														<div class="input-group-prepend">
															<span class="input-group-text"><i class="ni ni-email-83"></i></span>
														</div>
														<input value="<?php echo"".$student['username'];?>" onBlur="userAvailability()" id="username" name="username" class="form-control" placeholder="Email" type="email" title="Enter Username" oninvalid="this.setCustomValidity('Please enter the new admin Username.')" oninput="setCustomValidity('')" required>
														<div class="input-group-append">
																<span class="input-group-text" id="user-availability-status1"></span>
														</div>
													</div>
													<span id="user-availability-status1"></span>
												</div>
											</div>
											
										</div>
										<div class="row">

											<div class="col-lg-4">
												<div class="form-group">
													<label class="form-control-label" for="input-first-name">ID Number</label>
													<div class="input-group input-group-merge">
														<input value="<?php echo"".$student['idno'];?>" class="form-control" id='idno' name="idno" placeholder="Enter Student ID Number" required>
													</div>
												</div>
											</div>

											<div class="col-lg-4">
												<div class="form-group">
													<label class="form-control-label" for="input-first-name">Program</label>
													<div class="input-group input-group-merge">
														<select  id="program" name="program" class="form-control" placeholder="" required>
															<?php
																$get_program=getrecord('program',['id'],[$student['program_id']]);
																echo "<option value='".$get_program['id']."'>".$get_program['name']."</option>";
																echo "<option value=''> Select Program</option>";
																try{
																	$query1="SELECT * FROM `program`";
																	$stmt1 = $con->prepare($query1);
																	$stmt1->execute();
																	$result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
																}catch(Exception $e){
																	$_SESSION['error']='Something went wrong accessing program.';
																}
																	foreach ($result1 as $row1) {
																	echo"<option value=".$row1['id'].">".$row1['name']."</option>";
																}
															?>
														</select>
													</div>
												</div>
											</div>
											
											<div class="col-lg-4">
												<div class="form-group">
													<label class="form-control-label" for="input-first-name">Year Level</label>
													<div class="input-group input-group-merge">
														<select class="form-control" id='level' name="level" required>
															<?php
																if($student['level']=='1') {
																	echo"<option value='1'>1st Year</option>";
																}
																else if($student['level']=='2') {
																	echo"<option value='2'>2nd Year</option>";
																}
																else if($student['level']=='3') {
																	echo"<option value='3'>3rd Year</option>";
																}
																else if($student['level']=='4') {
																	echo"<option value='4'>4th Year</option>";
																} 
																else{
																	echo"<option value=''>Select Year Level</option>";
																}
															?>
															<option value="">Select Year Level</option>
															<option value="1">1st Year</option>
															<option value="2">2nd Year</option>
															<option value="3">3rd Year</option>
															<option value="4">4th Year</option>
														</select>
													</div>
												</div>
											</div>
										</div>
										<h3 class="text-center">Personal Information</h3>
										<div class="row">
										  <div class="col-lg-4">
											<div class="form-group">
											  <label class="form-control-label" for="input-first-name">Full Name</label>
											  <div class="input-group input-group-merge">
												<input value="<?php echo "".$student['firstname'];?>" type="text" id="firstname" name="firstname" class="form-control" placeholder="First Name" value="" required>
											  </div>
											</div>
										  </div>
										  <div class="col-lg-4">
											<div class="form-group">
											  <label class="form-control-label" for="input-first-name">&nbsp; </label>
											  <div class="input-group input-group-merge">
												<input value="<?php echo "".$student['middlename'];?>"type="text" id="middlename" name="middlename" class="form-control" placeholder="Middle Name" value="">
											  </div>
											</div>
										  </div>
										  <div class="col-lg-4">
											<div class="form-group">
											  <label class="form-control-label" for="input-first-name">&nbsp; </label>
											  <div class="input-group input-group-merge">
												<input value="<?php echo "".$student['lastname'];?>"type="text" id="lastname" name="lastname" class="form-control" placeholder="Last Name" value="" required>
											  </div>
											</div>
										  </div>
										</div>
										
										<div class="row">
											<div class="col-lg-4">
												<div class="form-group">
													<label class="form-control-label" for="input-last-name">Mobile No.</label>
												<div class="input-group input-group-merge">
												<div class="input-group-prepend">
												  <span class="input-group-text">+63 |</span>
												</div>
												<input value="<?php echo $student['contact_no'];?>" type="tel" id='contact_no' name="contact_no" maxlength="10" class="form-control" placeholder="Mobile No." value="" required>
											  </div>
											</div>
										  </div>
										  <div class="col-lg-4">
											<div class="form-group">
											  <label class="form-control-label" for="input-first-name">Date of Birth</label>
											  <div class="input-group input-group-merge">
												<input value="<?php echo $student['birthdate'];?>" type="date" id="birthdate" name="birthdate" class="form-control"  value="" />
											  </div>
											</div>
										  </div>
										 <div class="col-lg-4">
											<div class="form-group">
											  <label class="form-control-label" for="input-first-name">Place of Birth</label>
											  <div class="input-group input-group-merge">
												<input value="<?php echo $student['birthplace'];?>" type="text" id="birthplace" name="birthplace" class="form-control" placeholder="Place of birth" value="" required>
											  </div>
											</div>
										  </div>
										</div>
										
										<div class="row">
										  <div class="col-lg-4">
											<div class="form-group">
											  <label class="form-control-label" for="input-first-name">Gender</label>
											  <div class="input-group input-group-merge">
												<select  id="gender" name="gender" class="form-control" placeholder="gender" required>
													<?php
														echo"<option value='".$student['gender']."'>".$student['gender']."</option>"
													?>
													<option value=''>Select Gender</option>
													<option value='male'>Male</option>
													<option value='female'>Female</option>
													<option value='other'>Other</option>
												</select>
											  </div>
											</div>
										  </div>

										  <div class="col-lg-4">
											<div class="form-group">
											  <label class="form-control-label" for="input-first-name">Civil Status</label>
											  <div class="input-group input-group-merge">
												<select  id="civil_status" name="civil_status" class="form-control" placeholder="civil_status" required>
													<?php
														echo"<option value='".$student['civil_status']."'>".$student['civil_status']."</option>"
													?>
													<option value=''>Select Status</option>
													<option value='single'>Single</option>
													<option value='married'>Married</option>
													<option value='diviorced'>Divorced</option>
													<option value='separated'>Separated</option>
													<option value='widowed'>Widowed</option>
												</select>
											  </div>
											</div>
										  </div>

										  <div class="col-lg-4">
											<div class="form-group">
											  <label class="form-control-label" for="input-first-name">Citizenship</label>
											  <div class="input-group input-group-merge">
												<input value="<?php echo $student['citizenship'];?>" type="text" id="citizenship" name="citizenship" class="form-control" placeholder="Citizenship" value="" required>
											  </div>
											</div>
										  </div>

										</div>
										<hr>
										
										<div class="row">
										  <div class="col-lg-8">
											<div class="form-group">
											  <label class="form-control-label" for="input-first-name">Permanent Address</label>
											  <div class="input-group input-group-merge">
												<input value="<?php echo $student['permanent_address'];?>" type="text" id="permanent_address" name="permanent_address" class="form-control" placeholder="Permanent Address" value="" required>
											  </div>
											</div>
										  </div>

										  <div class="col-lg-4">
											<div class="form-group">
											  <label class="form-control-label" for="input-first-name">Zip Code </label>
											  <div class="input-group input-group-merge">
												<input value="<?php echo $student['zipcode'];?>" type="tel" id="zipcode" name="zipcode" maxlength='4' class="form-control" placeholder="Zip Code" value="" required>
											  </div>
											</div>
										  </div>
										</div>
										
										<div class="row">
										  <div class="col-lg-4">
											<div class="form-group">
											  <label class="form-control-label" for="input-first-name">(Senior) High School Name</label>
											  <div class="input-group input-group-merge">
												<input value="<?php echo $student['school_name'];?>" type="text" id="school_name" name="school_name" class="form-control" placeholder="Senior High School Name" value="" required>
											  </div>
											</div>
										  </div>
										  <div class="col-lg-4">
											<div class="form-group">
											  <label class="form-control-label" for="input-first-name">School Address </label>
											  <div class="input-group input-group-merge">
												<input value="<?php echo $student['school_address'];?>" type="text" id="school_address" name="school_address" class="form-control" placeholder="School Address" value="" required>
											  </div>
											</div>
										  </div>
										  <div class="col-lg-4">
											<div class="form-group">
											  <label class="form-control-label" for="input-first-name">School Type </label>
											  <div class="input-group input-group-merge">
												<select id="school_type" name="school_type" class="form-control" placeholder="school_type" required>
													<?php
														echo"<option value='".$student['school_type']."'>".$student['school_type']."</option>"
													?>
													<option value=''>Select Type</option>
													<option value='private'>Private School</option>
													<option value='public'>Public School</option>
												</select>
											  </div>
											</div>
										  </div>
										</div>
										<div class="row">
										  <div class="col-lg-6">
											<div class="form-group">
											  <label class="form-control-label" for="input-first-name">Educational Attainment</label>
											  <div class="input-group input-group-merge">
											 	 <select type="text" id="educational_attainement" name="educational_attainement" class="form-control"  value="" required>
												  	<?php
														echo"<option value='".$student['educational_attainement']."'>".$student['educational_attainement']."</option>"
													?>
												 	<option value=''>Select Attainment</option>
													<option value='high school'>High School (Old Curriculum)</option>
													<option value='junior high school'>Junior High School</option>
													<option value='senior high school'>Senior High School</option>
													<option value='college'>College</option>
												</select>
											  </div>
											</div>
										  </div>
										  <div class="col-lg-6">
											<div class="form-group">
											  <label class="form-control-label" for="input-first-name">Type of disability (if applicable) </label>
											  <div class="input-group input-group-merge">
												<input value="<?php echo ''.$student['disability'];?>" type="text" id="disability" name="disability" class="form-control" placeholder="Disability" value="">
											  </div>
											</div>
										  </div>
										</div>
										<hr>
										
										<h3 class="text-center">Family Background</h3>
										<div class="row">
											<div class="col-lg-4">
												<div class="form-group">
												  <label class="form-control-label" for="input-first-name">Father's Vital Status</label>
												  <div class="input-group input-group-merge">
													<select id="father_vital_status" name="father_vital_status" class="form-control" value="" required>
														<?php
															echo"<option value='".$student['father_vital_status']."'>".$student['father_vital_status']."</option>"
														?>
														<option value=''>Select Vital Status</option>
														<option value='living'>Living</option>
														<option value='deceased'>Deceased</option>
													</select>
												  </div>
												</div>
											</div>
										  <div class="col-lg-4">
											<div class="form-group">
											  <label class="form-control-label" for="input-first-name">Father's Name</label>
											  <div class="input-group input-group-merge">
												<input value="<?php echo ''.$student['father_name'];?>" type="text" id="father_name" name="father_name" class="form-control" placeholder="Father's Name" value=""required>
											  </div>
											</div>
										  </div>
										  <div class="col-lg-4">
											<div class="form-group">
											  <label class="form-control-label" for="input-first-name">Father's Occupation</label>
											  <div class="input-group input-group-merge">
												<input value="<?php echo ''.$student['father_occupation'];?>"  type="text" id="father_occupation" name="father_occupation" class="form-control" placeholder="Occupation" value="" required>
											  </div>
											</div>
										  </div>
										</div>
										<div class="row">
										  <div class="col-lg-6">
											<div class="form-group">
											  <label class="form-control-label" for="input-first-name">Father's Address</label>
											  <div class="input-group input-group-merge">
												<input value="<?php echo ''.$student['father_address'];?>" type="text" id="father_address" name="father_address" class="form-control" placeholder="Address" value="" required>
											  </div>
											</div>
										  </div>
										  <div class="col-lg-6">
											<div class="form-group">
											  <label class="form-control-label" for="input-first-name">Father's Educational Attainment</label>
											  <div class="input-group input-group-merge">
												<select id="father_educationalAtt" name="father_educationalAtt" class="form-control" placeholder="Educational Attainment" value="" required>
													<?php
														echo"<option value='".$student['father_educationalAtt']."'>".$student['father_educationalAtt']."</option>"
													?>
													<option value=''>Select Attainment</option>
													<option value='none'>None</option>
													<option value='elementary'>Elementary Graduate</option>
													<option value='high school'>High School Graduate (Old Curriculum) </option>
													<option value='junior high school'>Junior High School Completer</option>
													<option value='senior high school'>Senior High School Graduate</option>
													<option value='college'>College Graduate</option>
													<option value='master'>Master's Degree</option>
													<option value='doctoral'>Doctoral</option>
												</select>
											  </div>
											</div>
										  </div>
										</div>
										
										<div class="row">
											<div class="col-lg-4">
												<div class="form-group">
												  <label class="form-control-label" for="input-first-name">Mother's Vital Status</label>
												  <div class="input-group input-group-merge">
													<select id="mother_vital_status" name="mother_vital_status" class="form-control" value="" required>
														<?php
															echo"<option value='".$student['mother_vital_status']."'>".$student['mother_vital_status']."</option>"
														?>
														<option value=''>Select Vital Status</option>
														<option value='living'>Living</option>
														<option value='deceased'>Deceased</option>
													</select>
												  </div>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
												  <label class="form-control-label" for="input-first-name">Mother Name</label>
												  <div class="input-group input-group-merge">
													<input value="<?php echo ''.$student['mother_name']; ?>" type="text" id="mother_name" name="mother_name" class="form-control" placeholder="Mother's Name" value="" required>
												  </div>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
												  <label class="form-control-label" for="input-first-name">Mother's Occupation</label>
												  <div class="input-group input-group-merge">
													<input value="<?php echo ''.$student['mother_occupation']; ?>"  type="text" id="mother_occupation" name="mother_occupation" class="form-control" placeholder="Occupation" value="" required>
												  </div>
												</div>
											</div>
										</div>
										<div class="row">
										  <div class="col-lg-6">
											<div class="form-group">
											  <label class="form-control-label" for="input-first-name">Mother's Address</label>
											  <div class="input-group input-group-merge">
												<input value="<?php echo ''.$student['mother_address']; ?>" type="text" id="mother_address" name="mother_address" class="form-control" placeholder="Address" value="" required>
											  </div>
											</div>
										  </div>
										  <div class="col-lg-6">
											<div class="form-group">
											  <label class="form-control-label" for="input-first-name">Mother's Educational Attainment</label>
											  <div class="input-group input-group-merge">
												<select id="mother_educationalAtt" name="mother_educationalAtt" class="form-control" placeholder="Educational Attainment" value="" required>
													<?php
														echo"<option value='".$student['mother_educationalAtt']."'>".$student['mother_educationalAtt']."</option>"
													?>
													<option value=''>Select Attainment</option>
													<option value='none'>None</option>
													<option value='elementary'>Elementary Graduate</option>
													<option value='high school'>High School Graduate (Old Curriculum) </option>
													<option value='junior high school'>Junior High School Completer</option>
													<option value='senior high school'>Senior High School Graduate</option>
													<option value='college'>College Graduate</option>
													<option value='master'>Master's Degree</option>
													<option value='doctoral'>Doctoral</option>
												</select>
											  </div>
											</div>
										  </div>
										</div>
										
										<div class="row">
										  <div class="col-lg-6">
											<div class="form-group">
											  <label class="form-control-label" for="input-first-name">Total Parents Gross Income(Per Month)</label>
											  <div class="input-group input-group-merge">
												<select id="gross_income" name="gross_income" class="form-control" placeholder="Total Parents Gross Income" value="" required>
													<?php
														echo"<option value='".$student['gross_income']."'>".$student['gross_income']."</option>"
													?>
													<option value=''>Select Income Classification</option>
													<option value='poor'>Less than ₱9,100</option>
													<option value='low income'>Between ₱9,100 to ₱18,200</option>
													<option value='lowwer middle class'>Between ₱18,200 to ₱36,400</option>
													<option value='middle class'>Between ₱36,400 to ₱63,700</option>
													<option value='upper middle income'>Between ₱63,700 to ₱109,200</option>
													<option value='high income'>Between ₱109,200 to ₱182,000</option>
													<option value='rich'>At least ₱182,000 and up</option>
												</select>
											  </div>
											</div>
										  </div>
										  <div class="col-lg-6 mb-0">
											<div class="form-group">
											  <label class="form-control-label" for="input-first-name">No. of Siblings in the Familty</label>
											  <div class="input-group input-group-merge">
												<input value="<?php echo''.$student['siblings']; ?>" type="number" id="siblings" name="siblings" class="form-control" placeholder="Number of Siblings" value="" required>
											  </div>
											</div>
										  </div>
										</div>
										<hr>
										<div class="row">
										  <div class="col-lg-6">
											<div class="form-group">
											  <label class="form-control-label" for="input-first-name">(2x2) Picture</label>
											  <div class="input-group input-group-merge">
											  <input  value="<?php echo htmlspecialchars($student['picture']); ?>" type="hidden" lang="id" id="temp_picture" name="temp_picture" class="form-control" >
											  <input value="<?php echo htmlspecialchars($student['picture']); ?>" type="file" lang="id" id="picture" name="picture" class="form-control"  >
											  </div>
											</div>
										  </div>
										  	<div class="col-lg-6">
												<div class="form-group">
													<label class="form-control-label" for="signature">Signature</label>
													<div class="input-group input-group-merge">
													<!-- Add the "accept" attribute to specify the file types allowed for upload -->
													
													<input  value="<?php echo htmlspecialchars($student['signature']); ?>" type="hidden" lang="id" id="temp_signature" name="temp_signature" class="form-control" >
													<input  type="file" lang="id" id="signature" name="signature" class="form-control" >
													</div>
												</div>
											</div>
										</div>
										
										<div class="text-center">
										  <button type="submit" id='edit' name='edit' class="btn  btn-primary w-100 mt-2 mb-0 sign-up">Update</button>
										</div>
									</div>
									</form>
									<div class="card-footer text-center pt-0 px-lg-2 px-1">
										<center>
											<span class="text-center">
												<small> PhilSCA &copy; 2023</small>
											</span>
										</center>
									</div>
								</form>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
			<script>
				
			</script>
			 <?php
			//}else{
				//header("location:".$_SESSION['type'].'/');
			//}
			include("include/header.php");
			?>
			 <!-- Core JS -->
			 <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
			 <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
			 <script src="assets/vendor/js-cookie/js.cookie.js"></script>
			 <script src="assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
			 <script src="assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
			 <!-- Optional JS -->
			 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAq_ljbjvx9Z6BGjTAwwxdaa-_n4Mr48-E&ver=3.19.17"></script>
			 <!-- Calender JS -->
			 <script src="assets/vendor/moment/min/moment.min.js"></script>
			 <script src="assets/vendor/fullcalendar/dist/fullcalendar.min.js"></script>
			 <script src="assets/vendor/fullcalendar/dist/locale/id.js"></script>
			 <script src="assets/js/argon.js?v=1.1.0"></script>
			 <script type="text/javascript">
				
				function checkImageFile(fileInput) {
				//Responsive Checker for email
				const checkEmail = document.getElementById('username');
				checkEmail.addEventListener('change', () => {
				  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
				  if (!emailRegex.test(checkEmail.value)) {
					$("#username").css({ 
						"border" :"1px solid red",
						"color" :"red",
					});
					$("#username").fadeIn("slow");
					$("#username").focus();
					return false;
				  }else{
					  $("#username").css({ 
						"border" :"",
						"color" :"#000",
					});
					$("#username").fadeIn("slow");
				  }
				});
				//Responsive Checker for mobile number
				const checkMobileNo = document.getElementById('contactno');
				checkMobileNo.addEventListener('change', () => {
				  const numbersRegex = /^[0-9]+$/;
				  const digitRegex = /^\d{10}$/;
				  if (!numbersRegex.test(checkMobileNo.value) || !digitRegex.test(checkMobileNo.value) || checkMobileNo.value.charAt(0) !== "9") {
					$("#contactno").css({ 
					  "border" :"1px solid red",
					  "color" :"red",
					});
					$("#contactno").fadeIn("slow");
					$("#contactno").focus();
				  } else {
					$("#contactno").css({ 
					  "border" :"",
					  "color" :"#000",
					});
					$("#contactno").fadeIn("slow");
				  }
				});

				$(document).on("click", ".sign-up",function(){
				var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
				var lettersRegex = /^[a-zA-Z\s]+$/;
				var numbersRegex = /^[0-9]+$/;
				var specialCharactersRegex = /^[a-zA-Z0-9\s]*$/;
				var digitRegex = /^\d{10}$/;	
				var zipcodeRegex = /^\d{4}$/;	
				//check Email Input
				var email=document.getElementById("username").value.trim();
				if (email==='') {
					 $("#username").css({ 
						"border" :"1px solid red",
					});
					$("#username").fadeIn("slow");
					$("#username").focus();
				   return false;
				}
				if(!emailRegex.test(email)){
					 $("#username").css({ 
						"border" :"1px solid red",
						"color" :"red",
					});
					$("#username").fadeIn("slow");
					$("#username").focus();
					return false;
				}
				//check password input
				var password=document.getElementById("password").value.trim();
				if (password==='') {
					 $("#password").css({ 
						"border" :"1px solid red",
					});
					$("#password").fadeIn("slow");
					$("#password").focus();
				   return false;
				}

				//check firstname input if its blank or contains numbers
				var firstname=document.getElementById("firstname").value.trim();
				if (firstname==='') {
					 $("#firstname").css({ 
						"border" :"1px solid red",
					});
					$("#firstname").fadeIn("slow");
					$("#firstname").focus();
				   return false;
				}
				if (!lettersRegex.test(firstname)) {
					 $("#firstname").css({ 
						"border" :"1px solid red",
						"color" :"red",
					});
					$("#firstname").fadeIn("slow");
					$("#firstname").focus();
				   return false;
				}
				
				//check firstname input if its blank or contains numbers
				var middlename=document.getElementById("middlename").value.trim();
				if (middlename!=='' && !lettersRegex.test(middlename)) {
					 $("#middlename").css({ 
						"border" :"1px solid red",
						"color"  :"red",
					});
					$("#middlename").fadeIn("slow");
					$("#middlename").focus();
				   return false;
				}
				
				//check lastname input if its blank or contains numbers
				var lastname=document.getElementById("lastname").value.trim();
				if (lastname==='') {
					 $("#lastname").css({ 
						"border" :"1px solid red",
					});
					$("#lastname").fadeIn("slow");
					$("#lastname").focus();
				   return false;
				}
				if (!lettersRegex.test(lastname)) {
					 $("#lastname").css({ 
						"border" :"1px solid red",
						"color" :"red",
					});
					$("#lastname").fadeIn("slow");
					$("#lastname").focus();
				   return false;
				}

				//check contact_no input if its blank or contains letters or special characters
				var contactno=document.getElementById("contactno").value.trim();
				if (contactno==='') {
					 $("#contactno").css({ 
						"border" :"1px solid red",
					});
					$("#contactno").fadeIn("slow");
					$("#contactno").focus();
				   return false;
				}
				if (contactno.charAt(0) !== "9") {
					 $("#contactno").css({ 
						"border" :"1px solid red",
						"color" :"red",
					});
					$("#contactno").fadeIn("slow");
					$("#contactno").focus();
				   return false;
				}
				if (!numbersRegex.test(contactno)) {
					 $("#contactno").css({ 
						"border" :"1px solid red",
						"color" :"red",
					});
					$("#contactno").fadeIn("slow");
					$("#contactno").focus();
				   return false;
				}
				if (!digitRegex.test(contactno)) {
					 $("#contactno").css({ 
						"border" :"1px solid red",
						"color" :"red",
					});
					$("#contactno").fadeIn("slow");
					$("#contactno").focus();
				   return false;
				}
				//check birthdate input if its blank 
				var birthdate=document.getElementById("birthdate").value.trim();
				if (birthdate==='') {
					 $("#birthdate").css({ 
						"border" :"1px solid red",
					});
					$("#birthdate").fadeIn("slow");
					$("#birthdate").focus();
				   return false;
				}
				// Check if the age is above 15
				const today = new Date();
				const minAgeDate = new Date(today.getFullYear() - 15, today.getMonth(), today.getDate());
				const selectedDate = new Date(birthdate.slice(0, 4), birthdate.slice(5, 7) - 1, birthdate.slice(8, 10));
				if (selectedDate > minAgeDate) {
				  $("#birthdate").css({
					"border": "1px solid red",
				  });
				  $("#birthdate").fadeIn("slow");
				  $("#birthdate").focus();
				  return false;
				}
				
				
				//check contact_no input if its blank or contains letters or special characters
				var birthplace=document.getElementById("birthplace").value.trim();
				if (birthplace==='') {
					 $("#birthplace").css({ 
						"border" :"1px solid red",
					});
					$("#birthplace").fadeIn("slow");
					$("#birthplace").focus();
				   return false;
				}
				if (!specialCharactersRegex.test(birthplace)) {
					 $("#birthplace").css({ 
						"border" :"1px solid red",
						"color" :"red",
					});
					$("#birthplace").fadeIn("slow");
					$("#birthplace").focus();
				   return false;
				}
				//check gender input if its blank
				var gender=document.getElementById("gender").value.trim();
				if (gender==='') {
					 $("#gender").css({ 
						"border" :"1px solid red",
					});
					$("#gender").fadeIn("slow");
					$("#gender").focus();
				   return false;
				}
				
				//check civil_status input if its blank
				var civil_status=document.getElementById("civil_status").value.trim();
				if (civil_status==='') {
					 $("#civil_status").css({ 
						"border" :"1px solid red",
					});
					$("#civil_status").fadeIn("slow");
					$("#civil_status").focus();
				   return false;
				}
				
				//check citizenship input if its blank or contains numbers or special characters
				var citizenship=document.getElementById("citizenship").value.trim();
				if (citizenship==='') {
					 $("#citizenship").css({ 
						"border" :"1px solid red",
					});
					$("#citizenship").fadeIn("slow");
					$("#citizenship").focus();
				   return false;
				}
				if (!lettersRegex.test(citizenship)) {
					 $("#citizenship").css({ 
						"border" :"1px solid red",
						"color" :"red",
					});
					$("#citizenship").fadeIn("slow");
					$("#citizenship").focus();
				   return false;
				}
				
				//check permanent_address input if its blank or contains special characters
				var permanent_address=document.getElementById("permanent_address").value.trim();
				if (permanent_address==='') {
					 $("#permanent_address").css({ 
						"border" :"1px solid red",
					});
					$("#permanent_address").fadeIn("slow");
					$("#permanent_address").focus();
				   return false;
				}
				if (!specialCharactersRegex.test(permanent_address)) {
					 $("#permanent_address").css({ 
						"border" :"1px solid red",
						"color" :"red",
					});
					$("#permanent_address").fadeIn("slow");
					$("#permanent_address").focus();
				   return false;
				}
				
				//check permanent_address input if its blank or contains letters or special characters
				var zipcode=document.getElementById("zipcode").value.trim();
				if (zipcode==='') {
					 $("#zipcode").css({ 
						"border" :"1px solid red",
					});
					$("#zipcode").fadeIn("slow");
					$("#zipcode").focus();
				   return false;
				}
				if (!zipcodeRegex.test(zipcode)) {
					 $("#zipcode").css({ 
						"border" :"1px solid red",
						"color" :"red",
					});
					$("#zipcode").fadeIn("slow");
					$("#zipcode").focus();
				   return false;
				}
				//check school_name input if its blank or contains numbers or special characters
				var school_name=document.getElementById("school_name").value.trim();
				if (school_name==='') {
					 $("#school_name").css({ 
						"border" :"1px solid red",
					});
					$("#school_name").fadeIn("slow");
					$("#school_name").focus();
				   return false;
				}
				if (!lettersRegex.test(school_name)) {
					 $("#school_name").css({ 
						"border" :"1px solid red",
						"color" :"red",
					});
					$("#school_name").fadeIn("slow");
					$("#school_name").focus();
				   return false;
				}
				
				//check school_address input if its blank or contains special characters
				var school_address=document.getElementById("school_address").value.trim();
				if (school_address==='') {
					 $("#school_address").css({ 
						"border" :"1px solid red",
					});
					$("#school_address").fadeIn("slow");
					$("#school_address").focus();
				   return false;
				}
				if (!specialCharactersRegex.test(school_address)) {
					 $("#school_address").css({ 
						"border" :"1px solid red",
						"color" :"red",
					});
					$("#school_address").fadeIn("slow");
					$("#school_address").focus();
				   return false;
				}
				//check school_type input if its blank
				var school_type=document.getElementById("school_type").value.trim();
				if (school_type==='') {
					 $("#school_type").css({ 
						"border" :"1px solid red",
					});
					$("#school_type").fadeIn("slow");
					$("#school_type").focus();
				   return false;
				}
				
				//check educational_attainment input if its blank
				var educational_attainment=document.getElementById("educational_attainment").value.trim();
				if (educational_attainment==='') {
					 $("#educational_attainment").css({ 
						"border" :"1px solid red",
					});
					$("#educational_attainment").fadeIn("slow");
					$("#educational_attainment").focus();
				   return false;
				}
				
				//check disability input if its blank or contains letters or special characters
				var disability=document.getElementById("disability").value.trim();
				if (disability!=='' && numbersRegex.test(disability)) {
					 $("#disability").css({ 
						"border" :"1px solid red",
						"color"  :"red",
					});
					$("#disability").fadeIn("slow");
					$("#disability").focus();
				   return false;
				}
				
				//check educational_attainement input if its blank or contains letters or special characters
				var educational_attainement=document.getElementById("educational_attainement").value.trim();
				if (educational_attainement==='' ) {
					 $("#educational_attainement").css({ 
						"border" :"1px solid red",
					});
					$("#educational_attainement").fadeIn("slow");
					$("#educational_attainement").focus();
				   return false;
				}
				//check father_name input if its blank or contains numbers or special character
				var father_name=document.getElementById("father_name").value.trim();
				if (father_name==='') {
					 $("#father_name").css({ 
						"border" :"1px solid red",
					});
					$("#father_name").fadeIn("slow");
					$("#father_name").focus();
				   return false;
				}
				if (!lettersRegex.test(father_name)) {
					 $("#father_name").css({ 
						"border" :"1px solid red",
						"color" :"red",
					});
					$("#father_name").fadeIn("slow");
					$("#father_name").focus();
				   return false;
				}
				
				//check father_occupation input if its blank or contains numbers or special character
				var father_occupation=document.getElementById("father_occupation").value.trim();
				if (father_occupation==='') {
					 $("#father_occupation").css({ 
						"border" :"1px solid red",
					});
					$("#father_occupation").fadeIn("slow");
					$("#father_occupation").focus();
				   return false;
				}
				if (!lettersRegex.test(father_occupation)) {
					 $("#father_occupation").css({ 
						"border" :"1px solid red",
						"color" :"red",
					});
					$("#father_occupation").fadeIn("slow");
					$("#father_occupation").focus();
				   return false;
				}
				
				//check father_address input if its blank or contains numbers or special character
				var father_address=document.getElementById("father_address").value.trim();
				if (father_address==='') {
					 $("#father_address").css({ 
						"border" :"1px solid red",
					});
					$("#father_address").fadeIn("slow");
					$("#father_address").focus();
				   return false;
				}
				if (!specialCharactersRegex.test(father_address)) {
					 $("#father_address").css({ 
						"border" :"1px solid red",
						"color" :"red",
					});
					$("#father_address").fadeIn("slow");
					$("#father_address").focus();
				   return false;
				}
				
				//check father_educationalAtt input if its blank
				var father_educationalAtt=document.getElementById("father_educationalAtt").value.trim();
				if (father_address==='') {
					 $("#father_address").css({ 
						"border" :"1px solid red",
					});
					$("#father_address").fadeIn("slow");
					$("#father_address").focus();
				   return false;
				}
				
				//check mother_name input if its blank or contains numbers or special character
				var mother_name=document.getElementById("mother_name").value.trim();
				if (mother_name==='') {
					 $("#mother_name").css({ 
						"border" :"1px solid red",
					});
					$("#mother_name").fadeIn("slow");
					$("#mother_name").focus();
				   return false;
				}
				if (!lettersRegex.test(mother_name)) {
					 $("#mother_name").css({ 
						"border" :"1px solid red",
						"color" :"red",
					});
					$("#mother_name").fadeIn("slow");
					$("#mother_name").focus();
				   return false;
				}
				
				//check mother_name input if its blank or contains numbers or special character
				var mother_occupation=document.getElementById("mother_occupation").value.trim();
				if (mother_occupation==='') {
					 $("#mother_occupation").css({ 
						"border" :"1px solid red",
					});
					$("#mother_occupation").fadeIn("slow");
					$("#mother_occupation").focus();
				   return false;
				}
				if (!lettersRegex.test(mother_occupation)) {
					 $("#mother_occupation").css({ 
						"border" :"1px solid red",
						"color" :"red",
					});
					$("#mother_occupation").fadeIn("slow");
					$("#mother_occupation").focus();
				   return false;
				}
				
				//check mother_address input if its blank or contains numbers or special character
				var mother_address=document.getElementById("mother_address").value.trim();
				if (mother_address==='') {
					 $("#mother_address").css({ 
						"border" :"1px solid red",
					});
					$("#mother_address").fadeIn("slow");
					$("#mother_address").focus();
				   return false;
				}
				if (!specialCharactersRegex.test(mother_address)) {
					 $("#mother_address").css({ 
						"border" :"1px solid red",
						"color" :"red",
					});
					$("#mother_address").fadeIn("slow");
					$("#mother_address").focus();
				   return false;
				}
				
				//check mother_address input if its blank 
				var mother_educationalAtt=document.getElementById("mother_educationalAtt").value.trim();
				if (mother_address==='') {
					 $("#mother_address").css({ 
						"border" :"1px solid red",
					});
					$("#mother_address").fadeIn("slow");
					$("#mother_address").focus();
				   return false;
				}
				
				//check gross_income input if its blank or contains letters or special characters
				var gross_income=document.getElementById("gross_income").value.trim();
				if (gross_income==='') {
					 $("#gross_income").css({ 
						"border" :"1px solid red",
					});
					$("#gross_income").fadeIn("slow");
					$("#gross_income").focus();
				   return false;
				}
				
				//check siblings input if its blank or contains letters or special characters
				var siblings=document.getElementById("siblings").value.trim();
				if (siblings==='') {
					 $("#siblings").css({ 
						"border" :"1px solid red",
					});
					$("#siblings").fadeIn("slow");
					$("#siblings").focus();
				   return false;
				}
				if (!numbersRegex.test(siblings)) {
					 $("#siblings").css({ 
						"border" :"1px solid red",
						"color" :" red",
					});
					$("#siblings").fadeIn("slow");
					$("#siblings").focus();
				   return false;
				}
				
				//check picture input if its blank or file type is valid
				var picture=document.getElementById("picture").value.trim();
				if (picture==='') {
					 $("#picture").css({ 
						"border" :"1px solid red",
					});
					$("#picture").fadeIn("slow");
					$("#picture").focus();
				   return false;
				}
				
				if (checkImageFile(picture)) {
					 $("#picture").css({ 
						"border" :"1px solid red",
					});
					$("#picture").fadeIn("slow");
					$("#picture").focus();
				   return false;
				}
				var signature=document.getElementById("signature").value.trim();
				if (signature==='') {
					 $("#signature").css({ 
						"border" :"1px solid red",
					});
					$("#signature").fadeIn("slow");
					$("#signature").focus();
				   return false;
				}
				if (!checkImageFile(signature)) {
					 $("#signature").css({ 
						"border" :"1px solid red",
					});
					$("#signature").fadeIn("slow");
					$("#signature").focus();
				   return false;
				}
				
			});
				</script>
			</div>
		</div>
	</body>
 </html>
<?php?>