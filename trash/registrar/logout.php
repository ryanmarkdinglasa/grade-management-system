<?php
	session_start();
	error_reporting(E_ALL);
	include("include/session.php");
	include("../include/function.php");
	if(log_sign_out($user['username'])){
		$_SESSION[$_SESSION['type']]=NULL;
		$_SESSION['type']=NULL;
		session_unset();
		session_destroy();
		echo"<script language='javascript'>window.location.href='../';</script>";
	}else{
		$_SESSION['error']= "Something went wrong signing out.";
		echo"<script language='javascript'>window.location.href='index.php';</script>";
	}
?>

