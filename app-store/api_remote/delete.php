<?php

require_once('remoteAPI.php');

$apiObj = new RemoteAPI('http://localhost', '?q=my_service');
if(isset($_POST['username']) && isset($_POST['password'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
}

if(isset($_POST['id'])) {
	$id = $_POST['id'];
}

$apiObj->session_login($username, $password);
$connect = $apiObj->test_connect();
$token = $connect[1];
$delete = $apiObj->delete_product($token, $id, null);

echo json_encode($delete);

