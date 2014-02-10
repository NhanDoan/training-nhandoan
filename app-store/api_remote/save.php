
<?php 
	require_once('remoteAPI.php');
	$apiObj = new RemoteAPI('http://localhost', '/?q=my_service');

	if (isset($_POST['username']) && isset($_POST['password'])) {

		$username = $_POST['username'];
		$password = $_POST['password'];

		if (isset($_POST['id'])) {
		$id = $_POST['id'];
		}

		if (isset($_POST['type'])) {
			$type = $_POST['type'];
		}

		if (isset($_POST['sku'])){
			$sku = $_POST['sku'];
		}

		if (isset($_POST['commerce_price'])) {
			$amount = $_POST['commerce_price']['amount'];
			$currency_code = $_POST['commerce_price']['currency_code'];
		}

		if(isset($_POST['title'])) {
			$title = $_POST['title'];
		}

		if(isset($_POST['data_old'])) {
			$data_old = $_POST['data_old'];
		}
		$data = array(
			// 'product_id' => $id,
			'sku' => $sku,
			'title' => $title,
			'type' => $type,
			'commerce_price' => array(
				'amount' => $amount,
				'currency_code' => $currency_code
				),
			);

		($data_old['title'] != $data['title']) ? $data_old['title'] = $data['title'] : $data_old['title'] = $data_old['title'];

		($data_old['sku'] != $data['sku']) ? $data_old['sku'] = $data['sku'] : $data_old['sku'] = $data_old['sku'];

		($data_old['type'] != $data['type']) ? $data_old['type'] = $data['type'] : $data_old['type'] = $data_old['type'];

		($data_old['commerce_price']['amount'] != $data['commerce_price']['amount']) ? $data_old['commerce_price']['amount'] = $data['commerce_price']['amount'] : $data_old['commerce_price']['amount'] = $data_old['commerce_price']['amount'];

		($data_old['commerce_price']['currency_code'] != $data['commerce_price']['currency_code']) ? $data_old['commerce_price']['currency_code'] = $data['commerce_price']['currency_code'] : $data_old['commerce_price']['currency_code'] = $data_old['commerce_price']['currency_code'];

	    $apiObj->session_login($username, $password);

	    $connect = $apiObj->test_connect();
	    $token = $connect[1];
	    $update = $apiObj->put_product( $id, $token, $data);

	    echo json_encode($update);
	}
	
