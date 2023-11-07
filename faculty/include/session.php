<?php
	include '../include/conn.php';
		if($_SESSION['type']=='faculty'){
			$stmt = $con->prepare("SELECT *,
				`user`.`id` AS `user_id`,
				`staff`.`id` AS `staff_id`
			 	FROM `user`
				INNER JOIN `staff` ON `staff`.`username` =`user`.`username`
				WHERE `user`.`id` = ? LIMIT 1");
			$stmt->execute([$_SESSION['faculty']]);
			$user = $stmt->fetch(PDO::FETCH_ASSOC);;
			if(empty($user)){
				echo"<script>window.location.href='../403.php';</script>";;
			}
		}else{
			echo"<script>window.location.href='../403.php';</script>";
		}
	
	
