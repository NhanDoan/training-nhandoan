<?php
	require_once('remoteAPI.php');
	$apiObj = new RemoteAPI('http://localstore.fitmoo.com/', '/?q=my_service');
	$ret = $apiObj->view_index();
	echo json_encode($ret);	
?>

	

