<?php

// *****************************************************************************************
// defines an object for working with a remote API, not using Drupal API
class RemoteAPI {
  public $gateway;
  public $apiVersion;
  public $status;
  public $session;    // the session name (obtained at login)
  public $sessid;     // the session id (obtained at login)
  const RemoteAPI_status_unconnected = 0;
  const RemoteAPI_status_loggedin    = 1;
  // *****************************************************************************
  public function __construct( $gateway, $apiVersion ) {
    $this->gateway    = $gateway;
    $this->apiVersion = $apiVersion;
    // $this->status  = RemoteAPI_status_unconnected;
    $this->session = '';
    $this->sessid  = '';
    $this->auth = false;
  }

  // *****************************************************************************
  // after login, the string generated here needs to be included in any http headers,
  // under the key 'Cookie':
  private function GetCookieHeader() {
    return $this->session.'='.$this->sessid;
  }

  /**
   * checked session when user logged in
   * @param  [type] $username user name 
   * @param  [type] $password password
   * @return [type]           return session 
   */
  
  public function session_login($username, $password) {
        $request_url = $this->gateway.$this->apiVersion.'/user/login'; 

        $user_data = array(
        'username' => $username,
        'password' => $password,
        );
        $user_data = http_build_query($user_data);
        // cURL
        $curl = curl_init($request_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));    // Accept JSON response
        curl_setopt($curl, CURLOPT_POST, 1);                                          // Do a regular HTTP POST
        curl_setopt($curl, CURLOPT_POSTFIELDS, $user_data);                           // Set POST data
        curl_setopt($curl, CURLOPT_HEADER, FALSE);                                    // Ask to not return Header
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_FAILONERROR, TRUE);
        $response = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Check if login was successful
        if ($http_code != 200) {
            // Convert json response as array
            return NULL;
        }
        else {
          $ret = json_decode($response);
          $cookie_session = $ret->session_name . '=' . $ret->sessid;
          $this->sessid  = $ret->sessid;
          $this->session = $ret->session_name;

          $this->auth = true;

          return TRUE;
        }

  }

  /**
   * test_connect function to connect system and return id of user, CSFR Token
   * @param  [type] $session [description]
   * @return [type]          [description]
   */
  public function test_connect() {
    $cookie_session= "";
    // 
    if($this->auth) {
      $cookie_session = $this->GetCookieHeader();
    }
    $curl = curl_init();

    //GET CSRF TOKEN
    curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $this->gateway.'/?q=services/session/token',
    CURLOPT_COOKIE => "$cookie_session",
    ));

    $ret = new stdClass;
    $ret->response = curl_exec($curl);
    $ret->error    = curl_error($curl);
    $ret->info     = curl_getinfo($curl);
    $csrf_token = $ret->response;

    $request_url = $this->gateway.$this->apiVersion.'/system/connect.json';

    //cURL
    $curl = curl_init($request_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'X-CSRF-Token: '.$csrf_token)); // Accept JSON response
    curl_setopt($curl, CURLOPT_POST, 1);                                                                     // Do a regular HTTP POST
    curl_setopt($curl, CURLOPT_POSTFIELDS, array());
    curl_setopt($curl, CURLOPT_HEADER, FALSE);                                                               // Ask to not return Header
    curl_setopt($curl, CURLOPT_COOKIE, "$cookie_session");                                                   // use the previously saved session
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_FAILONERROR, TRUE);
    $ret = new stdClass;
    $ret->response = curl_exec($curl);                                                                        // execute and get response
    $ret->error    = curl_error($curl);
    $ret->info     = curl_getinfo($curl);

    curl_close($curl);
    if($ret->info['http_code'] == 200) {

      $data = json_decode($ret->response);

    } else {
      // Get error msg
        $http_message = $ret->error;
        die($http_message);
    }
    
    if(isset($data->user->uid))
    {
      $user = $data->user->uid;
    } else {
      $user = 0;
    }
    return array( $user, $csrf_token);
  }

  /**
   * Create a product when user logged in sussessfull
   * @param  $csrf_token     CSRF token 
   * @param  [type] $node_data      data for product
   * @param  [type] $cookie_session cookie session 
   * @return [type]                 [description]
   */
  public function create_product($csrf_token, $node_data) {
    $cookie_session = "";

    if ($this->auth)
      $cookie_session =  $this->GetCookieHeader();

    // REST Server URL
    $request_url = $this->gateway.$this->apiVersion.'/product'; 
    $node_data = http_build_query($node_data);

    // cURL
    $curl = curl_init($request_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'X-CSRF-Token: ' .$csrf_token));  // Accept JSON response
    curl_setopt($curl, CURLOPT_POST, 1);                                                                       // Do a regular HTTP POST
    curl_setopt($curl, CURLOPT_POSTFIELDS, $node_data);                                                        // Set POST data
    curl_setopt($curl, CURLOPT_HEADER, FALSE);                                                                 // Ask to not return Header
    curl_setopt($curl, CURLOPT_COOKIE, "$cookie_session");                                                     // use the previously saved session
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_FAILONERROR, TRUE);
    $response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $http_message = curl_error($curl);

    curl_close($curl);
    // Check if login was successful
    if ($http_code == 200) {

        // Convert json response as array
        $node = json_decode($response);
    }
    else {

        // Get error msg
        die($http_message);
    }
    return $node;
  }

  /**
   * view all product
   * @param  [type] $cookie_session [description]
   * @return [type] all product 
   */
  public function view_index() {
    $cookie_session = "";
    if($this->auth) {
      $cookie_session = $this->GetCookieHeader();
    }
    $request_url = $this->gateway.$this->apiVersion.'/product.json';
    $curl = curl_init($request_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    curl_setopt($curl, CURLOPT_FAILONERROR , TRUE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_COOKIE, "$cookie_session");                                                     // use the previously saved session
    curl_setopt($curl, CURLOPT_BINARYTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 3);

    $ret = new stdClass;
    $ret->response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if($http_code == 200) {

      $product = json_decode($ret->response, true);

    } else {

      $http_message = curl_error($curl);

      die($http_message);
    }
    return $product;
  }
  
  public function view_product_id($id) {
    $cookie_session = "";
    if($this->auth) {
      $cookie_session = $this->GetCookieHeader();
    }
    $request_url = $this->gateway.$this->apiVersion.'/product/' . $id . '.json';
    $curl = curl_init($request_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    curl_setopt($curl, CURLOPT_FAILONERROR , TRUE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_COOKIE, "$cookie_session");                                                     // use the previously saved session
    curl_setopt($curl, CURLOPT_BINARYTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 3);

    $ret = new stdClass;
    $ret->response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if($http_code == 200) {

      $product = json_decode($ret->response, true);

    } else {

      $http_message = curl_error($curl);

      die($http_message);
    }
    return $product;
  }

  /**
   * [put_product description]
   * @param  [type] $id         [description]
   * @param  [type] $csrf_token [description]
   * @param  [type] $data       [description]
   * @return [type]             [description]
   */
  public function put_product($id, $csrf_token, $data) {
    $cookie_session = "";
    if ($this->auth) 
      $cookie_session = $this->GetCookieHeader();

    $request_url = $this->gateway . $this->apiVersion .'/product/' . $id .'.json';
    $data_product = http_build_query($data);

    $curl = curl_init($request_url);

    curl_setopt($curl, CURLOPT_FAILONERROR , TRUE);
    curl_setopt($curl, CURLOPT_TIMEOUT, 3);
    curl_setopt($curl, CURLOPT_HEADER, FALSE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array( 'X-HTTP-Method-Override: PUT', 'Content-Length: ' . strlen($data_product), 'Accept: application/json', 'X-CSRF-Token:' . $csrf_token ));
    curl_setopt($curl, CURLOPT_POSTFIELDS , $data_product);
    curl_setopt($curl, CURLOPT_COOKIE , "$cookie_session");

    $ret = new stdClass;
    $ret->response = curl_exec($curl);                                                                        // execute and get response
    $ret->error    = curl_error($curl);
    $ret->info     = curl_getinfo($curl);

    curl_close($curl);
    // var_dump($ret->response); exit;
    if($ret->info['http_code'] == 200) {

      $product_update = json_decode($ret->response);

    } else {

      $http_message = $ret->error;
      die($http_message);
    }
    // var_dump()
    return $product_update;
  }

  /**
   * [delete_product description]
   * @param  [type] $csrf_token     [description]
   * @param  [type] $id             [description]
   * @param  [type] $cookie_session [description]
   * @param  [type] $data           [description]
   * @return [type]                 [description]
   */
  public function delete_product($csrf_token, $id, $data) {

    $cookie_session = "";
    if($this->auth) {
      $cookie_session = $this->GetCookieHeader();
    }
    $request_url = $this->gateway . $this->apiVersion . '/product/'. $id . '.json';
    $data_delete = http_build_query(array($data));

    $curl = curl_init($request_url);
    curl_setopt( $curl, CURLOPT_FAILONERROR, TRUE);
    curl_setopt( $curl, CURLOPT_HEADER, FALSE);
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt( $curl, CURLOPT_POST, TRUE);
    curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt( $curl, CURLOPT_HTTPHEADER, array('Content-Length: ' . strlen($data_delete), 'Accept: application/json', 'X-CSRF-Token:' . $csrf_token ));
    curl_setopt( $curl, CURLINFO_HEADER_OUT, true);
    curl_setopt( $curl, CURLOPT_POSTFIELDS , $data_delete);
    curl_setopt( $curl, CURLOPT_COOKIE, "$cookie_session");

    $ret = new stdClass();
    $ret->response = curl_exec($curl);
    $ret->error  = curl_error($curl);
    $ret->info = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if ($ret->info == 200) {

      $delete = json_decode($ret->response);
    } else {

      die($ret->error);
    }
  }
  
  // *****************************************************************************
  // Logout: uses the cURL library to handle logout
  public function Logout() {
    $callerId = 'RemoteAPI->Logout';
    if (!$this->VerifyLoggedIn( $callerId )) {
      return NULL; // error
    }
    $url = $this->gateway.$this->apiVersion.'/user/logout';
    $ret = $this->CurlHttpRequest($callerId, $url, 'POST', NULL, true);
    if ($ret->info['http_code'] != 200) {
      return NULL;
    }
    else {
      $this->status = RemoteAPI_status_unconnected;
      $this->sessid  = '';
      $this->session = '';
      return true; // success!
    }
  }  // end of Login() definition
   
} // end of remote Api object definition using cUrl and not Drupal API
