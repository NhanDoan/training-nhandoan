<?php
// *****************************************************************************************
// defines an object for working with the remote API, using the Drupal API
class RemoteAPI_via_DrupalAPI {
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
    $this->status  = RemoteAPI_status_unconnected;
    $this->session = '';
    $this->sessid  = '';
  }
  // *****************************************************************************
  // after login, the string generated here needs to be included in any http headers,
  // under the key 'Cookie':
  private function GetCookieHeader() {
    return $this->session.'='.$this->sessid;
  }
  // *****************************************************************************
  // return false if we're logged in
  private function VerifyUnconnected( $caller ) {
    if ($this->status != RemoteAPI_status_unconnected) {
      return false;
    }
    return true;
  }
  // *****************************************************************************
  // return false if we're not logged in
  private function VerifyLoggedIn( $caller ) {
    if ($this->status != RemoteAPI_status_loggedin) {
      return false;
    }
    return true;
  }
  // *****************************************************************************
  // replace these with the resource type names you'll be using
  private function VerifyValidResourceType( $resourceType ) {
    switch ($resourceType) {
      case 'product':
      case 'image':
      case 'thingamajig':
               return true;
      default: return false;
    }
  }
  // *****************************************************************************
  // Perform the common logic for performing an HTTP request with the Drupal API
  public function DrupalHttpRequest( $caller, $url, $method, $data, $includeAuthCookie = false ) {
    $headers = array();
    $headers['Content-Type'] = 'application/x-www-form-urlencoded';
    if ($includeAuthCookie) {
      $headers['Cookie']     = $this->GetCookieHeader();
    }
    if ($data) {
      $data = http_build_query($data, '', '&');
    }
    $response = drupal_http_request($url, $headers, $method, $data);
    if ($response->code == 200) {
      $response->data = json_decode($response->data);
    }
    else {
      $response->data = NULL;
    }
    return $response;
  }
  // *****************************************************************************
  public function Login( $username, $password ) {
    $callerId = 'RemoteAPI_DrupalAPI->Login';
    if (!$this->VerifyUnconnected( $callerId )) {
      return NULL; // error
    }
    $url = $this->gateway.$this->apiVersion.'/user/login';
    $data = array( 'username' => $username, 'password' => $password, );
    $response = $this->DrupalHttpRequest($callerId,  $url, 'POST', $data, false);
    if ($response->code == 200) {
      $this->session = $response->data->session_name;
      $this->sessid  = $response->data->sessid;
      $this->status  = RemoteAPI_status_loggedin;
      return true; // meaning okay
    }
    return NULL; // meaning error
  }
  // *****************************************************************************
  public function Logout() {
    $callerId = 'RemoteAPI_DrupalAPI->Logout';
    if (!$this->VerifyLoggedIn( $callerId )) {
      return NULL; // error
    }
    $url = $this->gateway.$this->apiVersion.'/user/logout';
    $response = $this->DrupalHttpRequest($callerId, $url, 'POST', NULL, true);
    if ($response->code == 200) {
      $this->status = RemoteAPI_status_unconnected;
      $this->sessid  = '';
      $this->session = '';
      return true; // success!
    }
    return NULL;
  } 
  // **************************************************************************
  // perform an 'Index' operation on a resource type using Drupal API.
  // Return an array of resource descriptions, or NULL if an error occurs
  public function Index( $resourceType ) {
    $callerId = 'RemoteAPI_DrupalAPI->Index';
    if (!$this->VerifyLoggedIn( $callerId )) {
      return NULL; // error
    }
    $url = $this->gateway.$this->apiVersion.'/'.$resourceType;
    $response = $this->DrupalHttpRequest($callerId,  $url, 'GET', NULL, true);
    return $response->data; // if failed, this is NULL, if success, this is an object holding requested data
  }
  // *****************************************************************************
  // create a new resource of the named type given an array of data, using Drupal API
  public function Create( $resourceType, $resourceData ) {
    $callerId = 'RemoteAPI_DrupalAPI->Create:'.$resourceType;
    if (!$this->VerifyLoggedIn( $callerId )) {
      return NULL; // error
    }
    if (!$this->VerifyValidResourceType($resourceType)) {
      return NULL;
    }
    $url = $this->gateway.$this->apiVersion.'/'.$resourceType;
    $response = $this->DrupalHttpRequest($callerId, $url, 'POST', $resourceData, true);
    return $response->data; // if failed, this is NULL, if success, this is an object holding response data
  }
  // **************************************************************************
  // perform a 'GET' operation on the named resource type and id using Drupal API
  public function Get( $resourceType, $resourceId ) {
    $callerId = 'RemoteAPI_DrupalAPI->Get:'.$resourceType.'/'.$resourceId.'"';
    if (!$this->VerifyLoggedIn( $callerId )) {
      return NULL; // error
    }
    if (!$this->VerifyValidResourceType($resourceType)) {
      return NULL;
    }
    $url = $this->gateway.$this->apiVersion.'/'.$resourceType.'/'.$resourceId;
    $response = $this->DrupalHttpRequest($callerId,  $url, 'GET', NULL, true);
    return $response->data; // if failed, this is NULL, if success, this is an object holding response data
  }
  // *****************************************************************************
  // update a resource given the resource type and updating array, using Drupal API
  public function Update( $resourceType, $resourceData ) {
    $callerId = 'RemoteAPI_DrupalAPI->Update:'.$resourceType;
    if (!$this->VerifyLoggedIn( $callerId )) {
      return NULL; // error
    }
     if (!$this->VerifyValidResourceType($resourceType)) {
      return NULL;
    }
    if (!isset($resourceData['data']['id'])) {
      _devReport('missing referencing ID of update resource!');
      return NULL;
    }
    $url = $this->gateway.$this->apiVersion.'/'.$resourceType.'/'.$resourceData['data']['id'];
    $response = $this->DrupalHttpRequest($callerId, $url, 'PUT', $resourceData, true);
    return $response->data; // if failed, this is NULL, if success, this is an object holding response data
  }   
  // *****************************************************************************
  // perform a 'DELETE' operation on the named resource type and id using Drupal API
  public function Delete( $resourceType, $resourceId ) {
    $callerId = 'RemoteAPI_DrupalAPI->Delete:'.$resourceType;
    if (!$this->VerifyLoggedIn( $callerId )) {
      return NULL; // error
    }
    if (!$this->VerifyValidResourceType($resourceType)) {
      return NULL;
    }
    $url = $this->gateway.$this->apiVersion.'/'.$resourceType.'/'.$resourceId;
    $response = $this->DrupalHttpRequest($callerId,  $url, 'DELETE', NULL, true);
    return $response->data; // if failed, this is NULL, if success, this is an object holding response data
  } 
} // end of RemoteAPI_via_DrupalAPI object definition
?>