<?php
	error_reporting(0);
	session_start();
	include "../include/conn.php";
	include "include/session.php";
	include "../include/function.php";
	
	//ADD ADMIN
	if (isset($_POST['add'])) {
		$type = 'admin';
		$firstname = 'New';
		$middlename = 'User';
		$lastname = 'Admin';
		$password = generate_password();
		$passwordhash = password_hash($password, PASSWORD_DEFAULT);
		$username = $_POST["username"];
		$status = 1;
		$isPasswordChanged = 0;
		$created_on = date('Y-m-d H:i:s');
		
		//CHECK USERNAME IF THERE IS ANY DUPLICATION
		$check_username=getrecord('user',['username',],[$username]);
		if(!empty($check_username)){
			$_SESSION['error']='Email is already taken.';
			echo"
				<script>
					location.href='admin.php';
				</script>
			";
			exit();
		}
		
		//ADD NEW ADMIN
		$result = addrecord('user', ['type', 'username', 'password', 'firstname', 'lastname', 'isPasswordChanged', 'status', 'created_on'], [$type, $username, $passwordhash, $firstname, $lastname, $isPasswordChanged, $status, $created_on]);
		if ($result) {
			$message = "
				\n$firstname,
				\nYou recently requested a scholarship admin account: $username.
				\nThis operation has completed successfully. You are now able to login to your account.
				\nYour new scholarship admin password is: $password
				\nYou will be requested to change this password once you successfully log into your account.
				\nThanks for being an active member of PhilSCA.
				\nBest Regards,
				\nPhilSCA
			";
			if (send_email2($username, $message)) {
				$_SESSION['success'] = 'Account created, account password sent.';
				echo"
					<script>
						location.href='admin.php';
					</script>
				";
				exit();
			} else {
				$_SESSION['error'] = 'Fail to send password.';
				echo"
					<script>
						location.href='admin.php';
					</script>
				";
				exit();
			}
		} else {
			$_SESSION['error'] = 'Something went wrong in adding admin. Please try again.';
			echo"
				<script>
					location.href='admin.php';
				</script>
			";
			exit();
		}
	}

	// DELETE ADMIN
	if (isset($_GET['del'])) {
		$id = $_GET['id'];
		try {
			$stmt = $con->prepare("DELETE FROM `user` WHERE id=? LIMIT 1");
			if ($stmt->execute([$id])) {
				$_SESSION['success'] = 'Administrator removed.';
				echo"
					<script>
						location.href='admin.php';
					</script>
				";
				exit();
			} else {
				$_SESSION['error'] = 'Failed to remove administrator.';
				echo"
					<script>
						location.href='admin.php';
					</script>
				";
				exit();
			}
		} catch (PDOException $e) {
			$_SESSION['error'] = 'Error deleting administrator: ' . $e->getMessage();
			echo"
				<script>
					location.href='admin.php';
				</script>
			";
			exit();
		}
	}

	
	//ACTIVATE ADMIN
	if (isset($_GET['on'])) {
		$id = $_GET['id'];
		try {
			$stmt = $con->prepare("UPDATE `user` SET `status`='1' WHERE id=? AND `type`='admin' LIMIT 1");
			if (!$stmt->execute([$id])) {
				$_SESSION['error'] = 'Something went wrong activating an admin. Please try again.';
				echo"
					<script>
						location.href='admin.php';
					</script>
				";
				exit();
			}else{
				echo"
					<script>
						location.href='admin.php';
					</script>
				";
				exit();
			}
		} catch (PDOException $e) {
			$_SESSION['error'] = 'Something went wrong.'. $e->getMessage();
			echo"
				<script>
					location.href='admin.php';
				</script>
			";
			exit();
		}
		
	}

	
	//DEACTIAVTE ADMIN
	if (isset($_GET['off'])) {
		$id=$_GET['id'];
		try{
			$stmt = $con->prepare("UPDATE `user` SET `status`='0' WHERE id=? AND `type`='admin' LIMIT 1");
			if(!$stmt->execute([$id])){
				$_SESSION['error']='Something went wrong deactivating an admin. Please try again.';
				echo"
					<script>
						location.href='admin.php';
					</script>
				";
				exit();
			}else{
				echo"
					<script>
						location.href='admin.php';
					</script>
				";
				exit();
			}
		}catch(PDOException $e){
			$_SESSION['error']='Something went wrong.'. $e->getMessage();
			echo"
				<script>
					location.href='admin.php';
				</script>
			";
			exit();
		}
		
	} 
	