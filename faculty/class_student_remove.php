<?php
	error_reporting(E_ALL);
	session_start();

	include "include/session.php";
	include "../include/conn.php";
	include "../include/function.php";

	//REMOVE STUDENT IN CLASS
	if (isset($_GET['id']) && !empty($_GET['class'])) {
		$id = $_GET['id'];
		$class_id = $_GET['class'];
		$checkStudent = findrecord('grade',['student_id'],[$id]);
		if ($checkStudent){
			$_SESSION['error'] = 'Student cannot be removed.';
			echo"<script>location.href='class_student.php?id=$class_id';</script>";
			exit();
		}
		try {
			$stmt = $con->prepare("DELETE FROM `participants` WHERE id=? LIMIT 1");
			$stmt->execute([$id]);
			if ($stmt->rowCount() > 0) {
				$_SESSION['success'] = 'Class Participant removed';
				echo"<script>location.href='class_student.php?id=$class_id';</script>";
				exit();
			} else {
				$_SESSION['error'] = 'Class participant not found or already removed';
				echo"<script>location.href='class_student.php?id=$class_id';</script>";
				exit();
			}
		} catch (Exception $e) {
			$_SESSION['error'] = 'Something went wrong.'. $e->getMessage();
			echo"<script>location.href='class_student.php?id=$class_id';</script>";
			exit();
		}
	} 
	



