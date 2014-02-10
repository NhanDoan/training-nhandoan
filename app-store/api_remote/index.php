<?php
  require_once('remoteAPI.php');  
  $apiObj = new RemoteAPI('http://localhost', '/?q=my_service');
  
  $connect = $apiObj->test_connect();
  echo json_encode($connect);
  
?>