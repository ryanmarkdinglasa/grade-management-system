<?php
	error_reporting(0);
	session_start();
	include "../include/conn.php";
	include "include/session.php";
	include "../include/function.php";
	
	//ADD
	if (isset($_POST['add'])) {
		$class_code = trim($_POST['class_code']);
		$program = trim($_POST['program']);
		$level=$_POST['level'];
		$period=$_POST['period'];

		// Input Validation
		if (empty($class_code) || empty($program) || empty($level) || empty($period)) {
			$_SESSION['error'] = 'All fields are required.';
			echo"
				<script>
					location.href='class.php';
				</script>
			";
			exit();
		}

		$created_on = date('Y-m-d H:i:s');
		if (addrecord('class', ['class_code', 'program_id', 'level', 'period_id', 'created_on'], [$class_code, $program, $level, $period, $created_on])) {
			// Redirect after success
			$_SESSION['success'] = ' New class added.';
			echo"
				<script>
					location.href='class.php';
				</script>
			";
			exit();
		} else {
			$_SESSION['error'] = 'Something went wrong adding class.';
			echo"
				<script>
					location.href='class.php';
				</script>
			";
			exit();
		}
	}

	// EDIT
	if (isset($_POST['edit-program'])) {
		$edit_id = $_POST['edit_id'];
		$edit_class_code = trim($_POST['edit_class_code']);
		$edit_period = trim($_POST['edit_period']);
		$edit_level = trim($_POST['edit_level']);
		$edit_program = trim($_POST['edit_program']);
		// Input Validation
		if (empty($edit_id) || empty($edit_class_code) || empty($edit_period) || empty($edit_level) || empty($edit_program)) {
			$_SESSION['error'] = 'All fields are required.';
			echo"
				<script>
					location.href='class.php';
				</script>
			";
			exit();
		}

		// Sanitize Input
		$updated_on = date('Y-m-d H:i:s');

		// Update 
		$stmt = $con->prepare("UPDATE `class` SET `class_code`=?, `program_id`=?, `level`=?,`period_id`=?,`updated_on`=? WHERE `id`=?");
		if ($stmt->execute([$edit_class_code, $edit_program, $edit_level, $edit_period, $updated_on, $edit_id])) {
			// Redirect after success
			$_SESSION['success'] = 'Class updated.';
			echo"
				<script>
					location.href='class.php';
				</script>
			";
			exit();
		} else {
			$_SESSION['error'] = 'Something went wrong updating class.';
			echo"
				<script>
					location.href='class.php';
				</script>
			";
		}
	}

	//DELETE
	if (isset($_GET['del'])) {
		$id = $_GET['id'];
		try {
			$stmt = $con->prepare("DELETE FROM `class` WHERE id=? LIMIT 1");
			$stmt->execute([$id]);
			if ($stmt->rowCount() > 0) {
				$_SESSION['success'] = 'Class removed';
				echo"
					<script>
						location.href='class.php';
					</script>
				";
			} else {
				$_SESSION['error'] = 'Class not found or already removed';
				echo"
					<script>
						location.href='class.php';
					</script>
				";
			}
		} catch (Exception $e) {
			$_SESSION['error'] = 'Something went wrong.'. $e->getMessage();
		}
		echo"
				<script>
					location.href='class.php';
				</script>
			";
	} 
