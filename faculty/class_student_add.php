<?php
	//error_reporting(0);
	session_start();
	include "../include/conn.php";
	include "include/session.php";
	include "../include/function.php";

	// ADD STUDENT CLASS
	if (isset($_GET['id']) && !empty($_GET['class'])) {
		$student_id = $_GET['id'];
		$class_id = $_GET['class'];
		$created_on = date('Y-m-d H:i:s');
		if($class_id==0 || $class_id==NULL || empty($class_id)){
			$_SESSION['error'] = 'Class is not found';
			echo "<script>location.href='class.php';</script>";
			exit();
		}
		if($student_id==0 || $student_id==NULL || empty($student_id)){
			$_SESSION['error'] = 'Student is not found';
			echo "<script>location.href='class.php';</script>";
			exit();
		}
		try {
			$stmt = $con->prepare("INSERT INTO `participants`(`class_id`, `student_id`, `created_on`) VALUES(:class_id, :student_id, :created_on)");
			$stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
			$stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
			$stmt->bindParam(':created_on', $created_on);
			$stmt->execute();

			if ($stmt->rowCount() == 0) {
				$_SESSION['error'] = 'Student not found or already added';
				echo " <script> location.href='class_student.php?id=$class_id'; </script> ";
				exit();
			}
		} catch (Exception $e) {
			$_SESSION['error'] = 'Something went wrong.' . $e->getMessage();
			echo " <script> location.href='class_student.php?id=$class_id'; </script> ";
			exit();
		}
	}
	



