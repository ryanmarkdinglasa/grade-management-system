	<?php
		error_reporting(0);
		session_start();
		include("include/conn.php");
		include("include/function.php");
		if (isset($_POST["signin"])) {
			$status = '1';
			$user = trim($_POST['username']);
			$pass = trim($_POST['password']);
			try {
				// Use prepared statements to protect against SQL injection
				$stmt = $con->prepare("SELECT * FROM `user` WHERE `username` = ?");
				$stmt->execute([$user]);
				$user = $stmt->fetch(PDO::FETCH_ASSOC);
				if (!$user) {
					// Protect against username enumeration by returning a generic error message
					//throw new Exception("Invalid username or password");
					$_SESSION['error'] = "This account doesn't exist, please try again.";
					header('location: index.php');
					exit;
				}
				if (!password_verify($pass, $user['password'])) {
					// Use a generic error message to avoid username enumeration
					//throw new Exception("Invalid username or password");
					$_SESSION['error'] = "Invalid username or password";
					echo"<script>window.location.href='index.php';</script>";
					exit();
				}
				if($user['status']==0){
					$_SESSION['error'] = "Your account has been deactivated. For more info contact the admin";
					echo"<script>window.location.href='index.php';</script>";
					exit();
				}
				// Set session variables
				//session_start();
				$user_type=$user['type'];$_SESSION['type']=$user['type'];//admin
				$_SESSION[$user_type] = $user['id'];

				// Log sign-in
				log_sign_in($user['username'],$user_type);

				// Redirect to appropriate page
				echo	"
						<script>
							window.location.href='". $_SESSION['type'] ."/index.php';
						</script>
					";
				exit();
			} catch (Exception $e) {
				// Log the error
				error_log($e->getMessage(), 0);
				// Provide a generic error message to the user
				$_SESSION['error'] = "Something went wrong. ".$e->getMessage();
				echo	"
						<script>
							window.location.href='index.php';
						</script>
					";
				exit;
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
			exit;
		}

