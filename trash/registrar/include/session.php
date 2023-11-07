<?php
	include '../include/conn.php';
		if($_SESSION['type']==NULL || empty($_SESSION['type'])){
			echo"<script>window.location.href='../403.php';</script>";
		}
		if($_SESSION['type']=='registrar'){
			$stmt = $con->prepare("SELECT * FROM `user` WHERE `id` = ? LIMIT 1");
			$stmt->execute([$_SESSION['registrar']]);
			$user = $stmt->fetch(PDO::FETCH_ASSOC);;
			if(empty($user) || $user==NULL){
				echo"<script>window.location.href='../403.php';</script>";
			}
		}else{
			echo"<script>window.location.href='../403.php';</script>";
		}