<?php
	error_reporting(0);
	session_start();
	include "../include/conn.php";
	include "include/session.php";
	include "../include/function.php";
	
	//ADD
	if (isset($_POST['add'])) {
		$subject_code = trim($_POST['subject_code']);
		$description = trim($_POST['description']);
		$program = trim($_POST['program']);
		$level = trim($_POST['level']);
		$term = trim($_POST['term']);

		$lab =($_POST['lab']==0 || $_POST['lab']=='')?0:trim($_POST['lab']);
		$lec =($_POST['lec']==0 || $_POST['lec']=='')?0:trim($_POST['lec']);
		$unit=intval($lab)+intval($lec);

		$hours=($_POST['hours']==0 || $_POST['hours']=='')?0:trim($_POST['hours']);
		$prerequisite=trim($_POST['prerequisite']);

		// Input Validation
		if (empty($subject_code) || empty($description) || empty($program) || empty($level) || empty($term) ||empty($prerequisite)) {
			$_SESSION['error'] = 'All fields are required.';
			echo"
				<script>
					location.href='course.php';
				</script>
			";
			exit();
		}
		//CHECK IF THERE IS EXISTING COURSE
		$check=getrecord('course',['subject_code'],[$subject_code]);
		if(!empty($check['subject_code'])){
			$_SESSION['error'] = ' Course already exist.';
			echo"
				<script>
					location.href='course.php';
				</script>
			";
			exit();
		}

		$created_on = date('Y-m-d H:i:s');
		if (addrecord('course', ['subject_code', 'description','program_id','level','term', 'lab_unit', 'lec_unit', 'unit', 'hours', 'prerequisite', 'created_on'], [$subject_code, $description,$program,$level,$term ,$lab, $lec, $unit, $hours, $prerequisite, $created_on])) {
			// Redirect after success
			$_SESSION['success'] = ' New course added.';
			echo"
				<script>
					location.href='course.php';
				</script>
			";
			exit();
		} else {
			$_SESSION['error'] = 'Something went wrong adding course.';
			echo"
				<script>
					location.href='course.php';
				</script>
			";
			exit();
		}
	}

	// EDIT
	if (isset($_POST['edit'])) {
		$edit_id=trim($_POST['edit_id']);
		$edit_subject_code = trim($_POST['edit_subject_code']);
		$edit_description = trim($_POST['edit_description']);
		$edit_program = trim($_POST['edit_program']);
		$edit_level = trim($_POST['edit_level']);
		$edit_term = trim($_POST['edit_term']);
		$edit_lab=($_POST['edit_lab']==0 || $_POST['edit_lab']=='')?0:trim($_POST['edit_lab']);
		$edit_lec=($_POST['edit_lec']==0 || $_POST['edit_lec']=='')?0:trim($_POST['edit_lec']);
		$edit_unit=intval($edit_lab)+intval($edit_lec);
		$edit_hours=trim($_POST['edit_hours']);
		$edit_prerequisite=trim($_POST['edit_prerequisite']);

		// Input Validation
		if (empty($edit_subject_code) || empty($edit_description) || empty($edit_program)  ||empty($edit_prerequisite)) {
			$_SESSION['error'] = 'All fields are required.';
			echo"
				<script>
					location.href='course.php';
				</script>
			";
			exit();
		}
		//CHECK IF THERE IS EXISTING COURSE
		$edit_check=getrecord('course',['subject_code'],[$edit_subject_code]);
		if((!empty($edit_check['subject_code'])) && ($edit_check['id']!=$edit_id)){
			$_SESSION['error'] = ' Course already exist.';
			echo"
				<script>
					location.href='course.php';
				</script>
			";
			exit();
		}

		// Sanitize Input
		$updated_on = date('Y-m-d H:i:s');

		// Update 
		$stmt = $con->prepare("UPDATE `course` SET `subject_code`=?, `description`=?,`program_id`=?, `level`=? ,`term`=?,`lab_unit`=?,`lec_unit`=?, `unit`=?,`hours`=?,`prerequisite`=?,`updated_on`=? WHERE `id`=?");
		if ($stmt->execute([$edit_subject_code,$edit_description, $edit_program, $edit_level, $edit_term, $edit_lab, $edit_lec,$edit_unit,$edit_hours,$edit_prerequisite,$updated_on, $edit_id])) {
			// Redirect after success
			$_SESSION['success'] = 'Course updated.';
			echo"
				<script>
					location.href='course.php';
				</script>
			";
			exit();
		} else {
			$_SESSION['error'] = 'Something went wrong updating course.';
			echo"
				<script>
					location.href='course.php';
				</script>
			";
		}
	}

	//DELETE
	if (isset($_GET['del'])) {
		$id = $_GET['id'];
		try {
			$stmt = $con->prepare("DELETE FROM `course` WHERE id=? LIMIT 1");
			$stmt->execute([$id]);
			if ($stmt->rowCount() > 0) {
				$_SESSION['success'] = 'Course removed';
				echo"
					<script>
						location.href='course.php';
					</script>
				";
			} else {
				$_SESSION['error'] = 'Course not found or already removed';
				echo"
					<script>
						location.href='course.php';
					</script>
				";
			}
		} catch (Exception $e) {
			$_SESSION['error'] = 'Something went wrong.'. $e->getMessage();
		}
		echo"
				<script>
					location.href='course.php';
				</script>
			";
	} 
