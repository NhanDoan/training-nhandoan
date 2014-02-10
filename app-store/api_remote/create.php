<?php
require_once('remoteAPI.php');

$apiObj = new RemoteAPI('http://localhost', '/?q=my_service');

// info of product when create
if (isset($_POST["sku"]))
	$sku = $_POST["sku"];

if (isset($_POST["title"]))
	$title = $_POST["title"];

if (isset($_POST["type"]))
	$type = $_POST["type"];

if (isset($_POST["commerce_price"]))
	$amount = $_POST["commerce_price"]["amount"];
	$currency_code = $_POST["commerce_price"]["currency_code"];

if(isset($_POST["password"]))
	$password = $_POST["password"];

if(isset($_POST["username"]))
	$username = $_POST["username"];

if(isset($_POST['data'])) {
	$data_old = $_POST['data'];
}
$data = array(
			'sku' => $sku,
			'title' => $title,
			'type' => $type,
			'commerce_price'=> array(
				'amount' => $amount,
				'currency_code' => $currency_code
			));

//get token when user logged
$apiObj->session_login($password, $username);

$token = $apiObj->test_connect();

$csrf_token = $token[1];

$create_product = $apiObj->create_product($csrf_token, $data);

echo json_encode($create_product);