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
		$institute=$_POST['institute'];

		// Input Validation
		if (empty($name) || empty($description)|| empty($institute)) {
			$_SESSION['error'] = 'All fields are required.';
			echo"
				<script>
					location.href='program.php';
				</script>
			";
			exit();
		}

		if (!preg_match('/^[a-zA-Z\s]+$/', $name)){
			$_SESSION['error'] = "Name should only contain letters.";
			echo"
				<script>
					location.href='program.php';
				</script>
			";
			exit();
		}
		 if(!preg_match('/^[a-zA-Z\s]+$/', $description) ) {
			$_SESSION['error'] = "Description should only contain letters.";
			echo"
				<script>
					location.href='program.php';
				</script>
			";
			exit();
		}
		$created_on = date('Y-m-d H:i:s');
		if (addrecord('program', ['name', 'description','institute_id', 'created_on'], [$name, $description, $institute, $created_on])) {
			// Redirect after success
			$_SESSION['success'] = ' New program added.';
			echo"
				<script>
					location.href='program.php';
				</script>
			";
			exit();
		} else {
			$_SESSION['error'] = 'Something went wrong adding program.';
			echo"
				<script>
					location.href='program.php';
				</script>
			";
			exit();
		}
	}

	// EDIT
	if (isset($_POST['edit-program'])) {
		$edit_id = $_POST['edit_id'];
		$edit_name = trim($_POST['edit_name']);
		$edit_description = trim($_POST['edit_description']);
		$edit_institute = trim($_POST['edit_institute']);
		// Input Validation
		if (empty($edit_name) || empty($edit_description) || empty($edit_institute) || $edit_institute=='0') {
			$_SESSION['error'] = 'All fields are required.';
			echo"
				<script>
					location.href='program.php';
				</script>
			";
			exit();
		}

		
		if (!preg_match('/^[a-zA-Z\s]+$/', $edit_name)){
			$_SESSION['error'] = "Name should only contain letters.";
			echo"
				<script>
					location.href='program.php';
				</script>
			";
			exit();
		}
		 if(!preg_match('/^[a-zA-Z\s]+$/', $edit_description) ) {
			$_SESSION['error'] = "Description should only contain letters.";
			echo"
				<script>
					location.href='program.php';
				</script>
			";
			exit();
		}
		// Sanitize Input
		$updated_on = date('Y-m-d H:i:s');

		// Update 
		$stmt = $con->prepare("UPDATE `program` SET `name`=?, `description`=?, `institute_id`=?,`updated_on`=? WHERE `id`=?");
		if ($stmt->execute([$edit_name, $edit_description,$edit_institute, $updated_on, $edit_id])) {
			// Redirect after success
			$_SESSION['success'] = 'Program updated.';
			echo"
				<script>
					location.href='program.php';
				</script>
			";
			exit();
		} else {
			$_SESSION['error'] = 'Something went wrong updating program.';
			echo"
				<script>
					location.href='program.php';
				</script>
			";
		}
	}

	//DELETE
	if (isset($_GET['del'])) {
		$id = $_GET['id'];
		try {
			$stmt = $con->prepare("DELETE FROM `program` WHERE id=? LIMIT 1");
			$stmt->execute([$id]);
			if ($stmt->rowCount() > 0) {
				$_SESSION['success'] = 'Program removed';
				echo"
					<script>
						location.href='program.php';
					</script>
				";
			} else {
				$_SESSION['error'] = 'Program not found or already removed';
				echo"
					<script>
						location.href='program.php';
					</script>
				";
			}
		} catch (Exception $e) {
			$_SESSION['error'] = 'Something went wrong.'. $e->getMessage();
		}
		echo"
				<script>
					location.href='program.php';
				</script>
			";
	} 
