<?php 
	error_reporting(E_ALL);
	include 'include/conn.php';
	include 'include/session.php';
	include 'include/function.php';
	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$sql = "SELECT  * FROM `scholarship_program` WHERE `id`=?";
		$stmt = $con->prepare($sql);
		$stmt->execute([$id]);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		echo json_encode($row);
	}
