	<?php
		error_reporting(0);
		session_start();
		include("../include/function.php");
		include("include/session.php");
		
		if (isset($_POST["signup"])) {
			//
			$username=trim($_POST['username']);
			$check_username=getrecord('student',['username'],[$username]);
			if(!empty($check_username['username'])){
				$_SESSION['error']='Email is already taken.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			$password=password_hash(trim($_POST['password']),PASSWORD_DEFAULT);
			$program=trim($_POST['program']);
			$level=trim($_POST['level']);
			$idno=trim($_POST['idno']);
			$check_idno=getrecord('student',['idno'],[$idno]);
			if(!empty($check_idno['idno'])){
				$_SESSION['error']='Student No. is already taken.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			$firstname=trim($_POST['firstname']);
			$middlename=trim($_POST['middlename']);
			$lastname=trim($_POST['lastname']);
			$contactno=trim($_POST['contactno']);
			$birthdate=trim($_POST['birthdate']);
			$birthplace=trim($_POST['birthplace']);
			$gender=trim($_POST['gender']);
			$civil_status=trim($_POST['civil_status']);
			$citizenship=trim($_POST['citizenship']);
			$permanent_address=trim($_POST['permanent_address']);
			$zipcode=trim($_POST['zipcode']);
			$school_name=trim($_POST['school_name']);
			$school_address=trim($_POST['school_address']);
			$school_type=trim($_POST['school_type']);
			$educational_attainement=trim($_POST['educational_attainement']);
			$disability=trim($_POST['disability']);
			$father_vital_status=trim($_POST['father_vital_status']);
			$father_name=trim($_POST['father_name']);
			$father_occupation=trim($_POST['father_occupation']);
			$father_address=trim($_POST['father_address']);
			$father_educationalAtt=trim($_POST['father_educationalAtt']);
			$mother_vital_status=trim($_POST['mother_vital_status']);
			$mother_name=trim($_POST['mother_name']);
			$mother_occupation=trim($_POST['mother_occupation']);
			$mother_address=trim($_POST['mother_address']);
			$mother_educationalAtt=trim($_POST['mother_educationalAtt']);
			$guardian_name=trim($_POST['guardian_name']);
			$guardian_email=trim($_POST['guardian_email']);
			$gross_income=trim($_POST['gross_income']);
			$siblings=trim($_POST['siblings']);
			
			$numbersRegex = '/^[0-9]+$/';
			$digitRegex = '/^\d{10}$/';
			$address_pattern = "/^[a-zA-Z0-9\s\-\.,#]+$/";
			if(empty($username)){
				$_SESSION['error']='Email field is empty.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			if(empty($password)){
				$_SESSION['error']='Password field is empty.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			if(empty($idno)){
				$_SESSION['error']='ID Number field is empty.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			if(empty($program)){
				$_SESSION['error']='Program field is empty.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			if(empty($level)){
				$_SESSION['error']='Level field is empty.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			if(empty($firstname)){
				$_SESSION['error']='First name field is empty.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			if(empty($lastname)){
				$_SESSION['error']='Last name field is empty.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			if(empty($contactno)){
				$_SESSION['error']='Mobile No. field is empty.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			if(empty($birthdate)){
				$_SESSION['error']='Date of birth field is empty.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			if(empty($birthplace)){
				$_SESSION['error']='Place of birth field is empty.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			if(empty($citizenship)){
				$_SESSION['error']='Citizenship field is empty.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			if(empty($permanent_address)){
				$_SESSION['error']='Permanent address field is empty.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			if(empty($zipcode)){
				$_SESSION['error']='Zip code field is empty.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			if(empty($school_name)){
				$_SESSION['error']='High school name field is empty.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			if(empty($school_address)){
				$_SESSION['error']='High school address field is empty.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			if(empty($educational_attainement)){
				$_SESSION['error']='Educational attainment field is empty.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit;
			}
			if(empty($father_name)){
				$_SESSION['error']='Father`s name field is empty.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			if(empty($father_occupation)){
				$_SESSION['error']='Father`s occupation field is empty.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			if(empty($father_address)){
				$_SESSION['error']='Father`s address field is empty.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			if(empty($mother_name)){
				$_SESSION['error']='Mother`s name field is empty.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			if(empty($mother_occupation)){
				$_SESSION['error']='Mother`s occupation field is empty.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			if(empty($mother_address)){
				$_SESSION['error']='Mother`s name address field is empty.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			if(empty($siblings)){
				$_SESSION['error']='Number of siblins field is empty.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}

			//VALIDATE THE SYSNTAX OF EMAIL/USERNAME
			if (!preg_match("/^\S+@\S+\.\S+$/", $username)) {
			$_SESSION['error'] = "Invalid email address.";
			echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			
			if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
				$_SESSION['error'] = "Invalid email address.";
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}

			if(empty($guardian_name)){
				$_SESSION['error']='Guardian`s name field is empty.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}

			//VALIDATE THE SYSNTAX OF EMAIL/USERNAME
			if (!preg_match("/^\S+@\S+\.\S+$/", $guardian_email)) {
			$_SESSION['error'] = "Invalid  guardian's email address.";
			echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			
			if (!filter_var($guardian_email, FILTER_VALIDATE_EMAIL)) {
				$_SESSION['error'] = "Invalid  guardian's email address.";
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			

			//CHECK USERNAME IF THERE IS ANY DUPLICATION
			$check_username=getrecord('user',['username',],[$username]);
			if(!empty($check_username)){
				$_SESSION['error']='Email is already taken.';
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			//VALIDATE MOBILE NO
			if (!preg_match($numbersRegex, $contactno) || !preg_match($digitRegex, $contactno) || substr($contactno, 0, 1) !== "9"  || strlen($contactno)!= 10) {
			$_SESSION['error'] = "Invalid mobile number.";
			echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			if(!empty($middlename)){
				if (!preg_match('/^[a-zA-Z\s]+$/', $firstname)|| !preg_match('/^[a-zA-Z\s]+$/', $middlename) || !preg_match('/^[a-zA-Z\s]+$/', $lastname) ) {
				$_SESSION['error'] = "Name should only contain letters.";
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
				}
			}
			if (!preg_match('/^[a-zA-Z\s]+$/', $firstname) || !preg_match('/^[a-zA-Z\s]+$/', $lastname) ) {
				$_SESSION['error'] = "Name should only contain letters.";
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
				}
			//VALIDATE ADDRESS
			if(!preg_match('/^[a-zA-Z0-9\s\-\.,&#]+$/', $permanent_address)){
				$_SESSION['error'] = "Invalid address, special characters are not allowed.";
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			//VALIDATE BIRTHPLACE
			if(!preg_match('/^[a-zA-Z0-9\s\-\.,#]+$/', $birthplace)){
				$_SESSION['error'] = "Invalid address, special characters are not allowed.";
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			//VALIDATE PARENTS ADDRESS
			if(!preg_match('/^[a-zA-Z0-9\s\-\.,#]+$/', $father_address)||!preg_match('/^[a-zA-Z0-9\s\-\.,#]+$/', $mother_address)){
				$_SESSION['error'] = "Invalid parents address, special characters are not allowed.";
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			//VALIDATE STUDENTS AGE/BIRTH-DATE, only 15yrs old and above are allowed to register
			$today = new DateTime();
			$minAgeDate = new DateTime($today->format('Y') - 15 . '-' . $today->format('m-d'));
			$selectedDate = new DateTime(substr($birthdate, 0, 4) . '-' . substr($birthdate, 5, 2) . '-' . substr($birthdate, 8, 2));
			if ($selectedDate > $minAgeDate) {
				$_SESSION['error'] = "Invalid birth date.";
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			//VALIATE PARENT's NAMES
			if (!preg_match('/^[a-zA-Z\s]+$/', $father_name)|| !preg_match('/^[a-zA-Z\s]+$/', $mother_name)) {
				$_SESSION['error'] = "Invalid parents name, name should only contain letters.";
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			//VALIADATE PARENTS OCCUPATION
			if (!preg_match('/^[a-zA-Z\s]+$/', $father_occupation)|| !preg_match('/^[a-zA-Z\s]+$/', $mother_occupation)) {
				$_SESSION['error'] = "Invalid parent's occupation, it should only contain letters.";
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			//VALIDATE GROSS INCOME
			if(!preg_match($numbersRegex,$siblings)){
				$_SESSION['error'] = "Invalid number of siblings, it should be a number.";
				echo	"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}

			//
			define('KB', 1024);
			define('MB', 1048576);
			define('GB', 1073741824);
			define('TB', 1099511627776);
			$imgfile1 = $_FILES["picture"]["name"];
			$target_dir1 = "img/";
			$target_file1 = $target_dir1 . basename($_FILES["picture"]["name"]);
			$imageFileType1 = strtolower(pathinfo($target_file1, PATHINFO_EXTENSION));

			// // get the image extension
			if ($imgfile1 === "" || $imgfile1===NULL ) {
				$_SESSION['error']='Please select and image.';
				echo"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			$extension1 = substr($imgfile1, strlen($imgfile1) - 4, strlen($imgfile1));
			if ($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg") {
				$_SESSION['error']='The only allowed files are JPG, PNG and JPEG.';
				echo"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			} else {
				if ($_FILES["picture"]["size"] > 2 * MB){
					$_SESSION['error']='Image file size is more than 2 MB';
					echo"
						<script>
							window.location.href='register.php';
						</script>
					";
					exit();
				}
				else{
				//rename the image file
				$imgnewfile1 = md5($imgfile1) . uniqid() . $extension1;
				// Code for move image into directory
				move_uploaded_file($_FILES["picture"]["tmp_name"], "img/" . $imgnewfile1);
				// Query for insertion data into database
				}
			}
			$imgfile2 = $_FILES["signature"]["name"];
			$target_dir2 = "img/";
			$target_file2 = $target_dir2 . basename($_FILES["signature"]["name"]);
			$imageFileType2 = strtolower(pathinfo($target_file2, PATHINFO_EXTENSION));

			// // get the image extension
			if ($imgfile2 === "" || $imgfile2===NULL ) {
				$_SESSION['error']='Please select and image.';
				echo"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			}
			$extension2 = substr($imgfile2, strlen($imgfile2) - 4, strlen($imgfile2));
			if ($imageFileType2 != "jpg" && $imageFileType2 != "png" && $imageFileType2 != "jpeg") {
				$_SESSION['error']='The only allowed files are JPG, PNG and JPEG.';
				echo"
					<script>
						window.location.href='register.php';
					</script>
				";
				exit();
			} else {
				if ($_FILES["signature"]["size"] > 2 * MB){
					$_SESSION['error']='Image file size is more than 2 MB';
					echo"
						<script>
							window.location.href='register.php';
						</script>
					";
					exit();
				}
				else{
				//rename the image file
				$imgnewfile2 = md5($imgfile2) . uniqid() . $extension2;
				// Code for move image into directory
				move_uploaded_file($_FILES["signature"]["tmp_name"], "img/" . $imgnewfile2);
				// Query for insertion data into database
				}
			}
			$type="student";
			$status=0;
			$isPasswordChanged=0;
			$created_on=date('Y-m-d H:i:s');
			$result1=addrecord('student',
			['username','program_id','level','idno','firstname','middlename','lastname','contact_no','birthdate', 'birthplace','gender','civil_status','citizenship','permanent_address','zipcode','school_name','school_address','school_type','educational_attainement','disability','father_vital_status','father_name','father_occupation','father_address','father_educationalAtt','mother_vital_status','mother_name','mother_occupation','mother_address','mother_educationalAtt','gross_income','siblings','guardian_name','guardian_email','picture','signature','status','created_on'],
			[$username,
			$program,
			$level,
			$idno,
			$firstname,
			$middlename,
			$lastname,
			$contactno,
			$birthdate,
			$birthplace,
			$gender,
			$civil_status,
			$citizenship,
			$permanent_address,
			$zipcode,
			$school_name,
			$school_address,
			$school_type,
			$educational_attainement,
			$disability,
			$father_vital_status,
			$father_name,
			$father_occupation,
			$father_address,
			$father_educationalAtt,
			$mother_vital_status,
			$mother_name,
			$mother_occupation,
			$mother_address,
			$mother_educationalAtt,
			$gross_income,
			$siblings,
			$guardian_name,
			$guardian_email,
			$imgnewfile1,
			$imgnewfile2,
			$status,
			$created_on]);
			
			$result2=addrecord('user',
			['type','username','password','firstname','middlename','lastname','gender','birthdate','address','phone_no','isPasswordChanged','status','created_on'],
			[$type,$username,$password,$firstname,$middlename,$lastname,$gender,$birthdate,$permanent_address,$contactno,0,1,$created_on]);
	
			if($result2){
				$_SESSION['success']='Student added.';
				echo	"
					<script>
						window.location.href='student.php';
					</script>
				";
				exit();
				}else{
					$_SESSION['error']='Something went wrong.';
					echo	"
						<script>
							window.location.href='register.php';
						</script>
					";
					exit();
				}
		}
			else{
				// Use a generic error message to avoid username enumeration
				$_SESSION['error'] = 'Invalid username or password';
				echo	"
					<script>
						window.location.href='index.php?error';
					</script>
				";
				exit();
			}
		
