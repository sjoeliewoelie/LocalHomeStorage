<?php
	if(isset($_POST['access_token'])){
		session_start();
		$_SESSION['access_token'] = $_POST['access_token'];
		$_SESSION['expires_in'] = $_POST['expires_in'];
		$_SESSION['user_id'] = $_POST['user_id'];
		echo 'OK';
	}
?>