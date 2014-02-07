<?php
/**
 * Show product by ID return 
 */
	require_once('remoteAPI.php');
	$apiObj = new RemoteAPI('http://localhost', '/?q=my_service');

	if(isset($_POST['id'])) {
		$id = $_POST['id'];
	}
	
	$product_follow_id = $apiObj->view_product_id(85);
	echo json_encode($product_follow_id);