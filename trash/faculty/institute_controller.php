<?php
	error_reporting(0);
	session_start();
	include "../include/conn.php";
	include "include/session.php";
	include "../include/function.php";
	
	//ADD
	if (isset($_POST['add'])) {
		$name = trim($_POST['name']);
		$description = trim($_POST['description']);

		// Input Validation
		if (empty($name) || empty($description)) {
			$_SESSION['error'] = 'All fields are required.';
			echo"
				<script>
					location.href='institute.php';
				</script>
			";
			exit();
		}

		// Sanitize Input
		if (!ctype_alpha($name)) {
			$_SESSION['error'] = 'Name should contain only letters.';
			echo"
				<script>
					location.href='institute.php';
				</script>
			";
			exit();
		}
		//
		if (!preg_match('/^[a-zA-Z\s]+$/', $name)){
			$_SESSION['error'] = "Name should only contain letters.";
			echo"
				<script>
					location.href='institute.php';
				</script>
			";
			exit();
		}
		//
		if(!preg_match('/^[a-zA-Z\s]+$/', $description) ) {
			$_SESSION['error'] = "Description should only contain letters.";
			echo"
				<script>
					location.href='institute.php';
				</script>
			";
			exit();
		}

		$created_on = date('Y-m-d H:i:s');
		if (addrecord('institute', ['name', 'description', 'created_on'], [$name, $description, $created_on])) {
			// Redirect after success
			$_SESSION['success'] = 'New Institute added.';
			echo"
				<script>
					location.href='institute.php';
				</script>
			";
			exit();
		} else {
			$_SESSION['error'] = 'Something went wrong adding institute.';
			echo"
				<script>
					location.href='institute.php';
				</script>
			";
			exit();
		}
	}

	// EDIT
	if (isset($_POST['edit-program'])) {
		$sp_id = $_POST['edit_id'];
		$sp_name = trim($_POST['edit_name']);
		$sp_description = trim($_POST['edit_description']);

		// Input Validation
		if (empty($sp_name) || empty($sp_description)) {
			$_SESSION['error'] = 'All fields are required.';
			echo"
				<script>
					location.href='institute.php';
				</script>
			";
			exit();
		}

		if (!ctype_alpha($sp_name)) {
			$_SESSION['error'] = 'Name should contain only letters.';
			echo"
				<script>
					location.href='institute.php';
				</script>
			";
			
			exit();
		}
		if (!preg_match('/^[a-zA-Z\s]+$/', $sp_name)){
			$_SESSION['error'] = "Name should only contain letters.";
			echo"
				<script>
					location.href='institute.php';
				</script>
			";
			exit();
		}
		 if(!preg_match('/^[a-zA-Z\s]+$/', $sp_description) ) {
			$_SESSION['error'] = "Description should only contain letters.";
			echo"
				<script>
					location.href='institute.php';
				</script>
			";
			exit();
		}
		// Sanitize Input
		$updated_on = date('Y-m-d H:i:s');

		// Update
		$stmt = $con->prepare("UPDATE `institute` SET `name`=?, `description`=?, `updated_on`=? WHERE `id`=?");
		if ($stmt->execute([$sp_name, $sp_description, $updated_on, $sp_id])) {
			// Redirect after success
			$_SESSION['success'] = 'Institute updated.';
			echo"
				<script>
					location.href='institute.php';
				</script>
			";
			exit();
		} else {
			$_SESSION['error'] = 'Something went wrong updating scholarship program.';
			echo"
				<script>
					location.href='institute.php';
				</script>
			";
		}
	}

	//DELETE
	if (isset($_GET['del'])) {
		$id = $_GET['id'];
		try {
			$stmt = $con->prepare("DELETE FROM `institute` WHERE id=? LIMIT 1");
			$stmt->execute([$id]);
			if ($stmt->rowCount() > 0) {
				$_SESSION['success'] = 'Institute removed';
				echo"
					<script>
						location.href='institute.php';
					</script>
				";
			} else {
				$_SESSION['error'] = 'Institute not found or already removed';
				echo"
					<script>
						location.href='institute.php';
					</script>
				";
			}
		} catch (Exception $e) {
			$_SESSION['error'] = 'Something went wrong.'. $e->getMessage();
		}
		echo"
				<script>
					location.href='institute.php';
				</script>
			";
	} 


	
	