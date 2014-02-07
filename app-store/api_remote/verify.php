<?php
	include('remoteAPI.php');
	
	$username = "";
	$password = "";

	$apiObject = new RemoteAPi('http://localhost', '/?q=my_service');

	if(isset($_POST["username"]) && isset($_POST["password"])) {
		
		$username = $_POST["username"];
		$password = $_POST["password"];

		$apiObject->session_login($username, $password);

		$connect = $apiObject->test_connect();

		echo json_encode($connect);

	} else {
		echo json_encode("username or password is in corrected!");
	}

