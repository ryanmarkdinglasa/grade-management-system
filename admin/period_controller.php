<?php
	error_reporting(0);
	session_start();
	include "../include/conn.php";
	include "include/session.php";
	include "../include/function.php";
	
	//ADD PERIOD
	if (isset($_POST['add'])) {
		$year = trim($_POST['year']);
		$term = $_POST['term'];

		// Input Validation
		if (empty($year) || empty($term)) {
			$_SESSION['error'] = 'All fields are required.';
			echo"
				<script>
					location.href='period.php';
				</script>
			";
			exit();
		}

		// Sanitize Input
		if (!ctype_digit($year)) {
			$_SESSION['error'] = 'Year should contain only numbers.';
			echo "
				<script>
					location.href='period.php';
				</script>
			";
			exit();
		}
		//
		$year=$year.'-'.$year+1;
		$created_on = date('Y-m-d H:i:s');
		if (addrecord('period', ['year', 'term', 'created_on'], [$year, $term, $created_on])) {
			// Redirect after success
			$_SESSION['success'] = 'New Academic Year added.';
			echo"
				<script>
					location.href='period.php';
				</script>
			";
			exit();
		} else {
			$_SESSION['error'] = 'Something went wrong adding academic year.';
			echo"
				<script>
					location.href='period.php';
				</script>
			";
			exit();
		}
	}

	// EDIT SCHOLARSHIP PROGRAM
	if (isset($_POST['edit-program'])) {
		$sp_id = $_POST['edit_id'];
		$sp_name = trim($_POST['edit_name']);
		$sp_description = trim($_POST['edit_description']);

		// Input Validation
		if (empty($sp_name) || empty($sp_description)) {
			$_SESSION['error'] = 'All fields are required.';
			echo"<script>location.href='period.php';</script>";
			exit();
		}

		if (!ctype_alpha($sp_name)) {
			$_SESSION['error'] = 'Name should contain only letters.';
			echo"<script>location.href='period.php';</script>";
			exit();
		}
		if (!preg_match('/^[a-zA-Z\s]+$/', $sp_name)){
			$_SESSION['error'] = "Name should only contain letters.";
			echo"<script>location.href='period.php';</script>";
			exit();
		}
		 if(!preg_match('/^[a-zA-Z\s]+$/', $sp_description) ) {
			$_SESSION['error'] = "Description should only contain letters.";
			echo"<script>location.href='period.php';</script>";
			exit();
		}
		// Sanitize Input
		$updated_on = date('Y-m-d H:i:s');

		// Update Scholarship Program
		$stmt = $con->prepare("UPDATE `institute` SET `name`=?, `description`=?, `updated_on`=? WHERE `id`=?");
		if ($stmt->execute([$sp_name, $sp_description, $updated_on, $sp_id])) {
			$_SESSION['success'] = 'Academic Year updated.';
			echo"<script>location.href='period.php';</script>";
			exit();
		} else {
			$_SESSION['error'] = 'Something went wrong updating scholarship program.';
			echo"<script>location.href='period.php';</script>";
		}
	}

	//DELETE SCHOLARSHIP PROGRAM
	if (isset($_GET['del'])) {
		$id = $_GET['id'];
		try {
			$stmt = $con->prepare("DELETE FROM `period` WHERE id=? LIMIT 1");
			$stmt->execute([$id]);
			if ($stmt->rowCount() > 0) {
				$_SESSION['success'] = 'Academic Year removed';
				echo"
					<script>
						location.href='period.php';
					</script>
				";
			} else {
				$_SESSION['error'] = 'Academic Year not found or already removed';
				echo"
					<script>
						location.href='period.php';
					</script>
				";
			}
		} catch (Exception $e) {
			$_SESSION['error'] = 'Something went wrong.'. $e->getMessage();
		}
		echo"
				<script>
					location.href='period.php';
				</script>
			";
	} 

	//ACTIVATE
	if (isset($_GET['on']) && $_GET['on']==1) {
		$id=$_GET['id'];
		try{
			// Update the status of the period being activated to 1
			$stmt = $con->prepare("UPDATE `period` SET `status`='1' WHERE id=? LIMIT 1");
			$stmt->execute([$id]);

			// Update the status of all other periods to 0, excluding the period being activated
			$stmt = $con->prepare("UPDATE `period` SET `status`='0' WHERE id<>?");
			$stmt->execute([$id]);
		}catch(Exception $e){
			$_SESSION['error']='Something went wrong in activating an academic year. Please try again.';
			echo"
				<script>
					location.href='period.php';
				</script>
			";
		}
		echo"
				<script>
					location.href='period.php';
				</script>
			";
	}

	//DEACTIVATE
	if (isset($_GET['off']) && $_GET['off']==0) {
		$id=$_GET['id'];
		try{
			$stmt = $con->prepare("UPDATE `period` SET `status`='0' WHERE id=? LIMIT 1");
			$stmt->execute([$id]);
		}catch(Exception $e){
			$_SESSION['error']='Something went wrong in deactivating an academic year. Please try again.';
			echo"
				<script>
					location.href='period.php';
				</script>
			";
		}
		echo"
				<script>
					window.location.href='period.php';
				</script>
			";
	}	

	
	