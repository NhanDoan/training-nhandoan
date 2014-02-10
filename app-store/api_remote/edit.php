<?php
	require_once('remoteAPI.php');
	$apiObj = new RemoteAPI('http://localhost', '/?q=my_service');

	if(isset($_POST['id'])) {
		$id = $_POST['id'];
	}
	
	$product_follow_id = $apiObj->view_product_id($id);
	echo json_encode($product_follow_id);