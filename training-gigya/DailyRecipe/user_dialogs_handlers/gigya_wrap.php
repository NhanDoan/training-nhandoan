<?php 
//------------------------------------------------------------------------------------------------------
// 	This file include methods that wraps all the usage of Gigya's PHP SDK. This includes the implementation of Social Login.
//------------------------------------------------------------------------------------------------------

define('INCLUDE_CHECK',true);
require_once( str_replace('//','/',dirname(__FILE__).'/') .'../config.php'); 
require_once("user_db_access.php");
require_once("utility_functions.php");
require_once("GSSDK.php");

if (empty($_SESSION)) {
  session_start();
}
$errors = "";
$returnVal = 0;

//----------------------------------------------------------------------------------------------------
// Method: registerNewUser
// Use case: A new user in the site logged-in through Gigya's Social Login.
// Flow:
//   1. Add the new user to the site's user-DB 
//   2. Call finalizeGigyaRegistration to notify Gigya of the registration process compition.
// Note: Please refer to Gigya's Developer's guide->User Management 360->Social Login. This method implements Steps 9,10.
// Return: method returns the new user record from the site DB, or 0 incase of error
//----------------------------------------------------------------------------------------------------
function registerNewUser($userObject){
	
	$securePassword = generateHash(generatePassword()); // generate automatic site user-password
	$thumb = $userObject["user"]["thumbnailURL"];
	if(empty($thumb)) // if a user thumbnail image is missing - assign a default avatar image 
		$thumb = $websiteUrl . "/images/avatar_48x48.gif";
	
	// Add a new user record to the site DB.
	$result = addDBUser($userObject["user"]["email"], $userObject["user"]["firstName"], $userObject["user"]["lastName"],$securePassword,$userObject["user"]["birthYear"],$userObject["user"]["gender"],$thumb);
	if (!$result) {
		$errors =  'Invalid query: ' . mysql_error();
		return 0;
	} 
	else
	{
		$userdetails = fetchUserDetails($userObject["user"]["email"]); // Fetch the new user record from the site DB.
		$result = finalizeGigyaRegistration($userObject["UID"], $userdetails["ID"]);
		if($result!=0) 
			return null;
		else
			return $userdetails;
	}
}

//--------------------------------------------------------------------------------------------------------------
// Method: finalizeGigyaRegistration
//    Notify Gigya of the completion of the registration process. 
//    The method also replaces Gigya UID in the Gigya's user account with the site UID (that was generarted by our local site DB).
//    (in other words - links between Gigya user account and site user account)
// Note: Please refer to Gigya's Developer's guide->User Management 360->Social Login. This method implements Step 10.
// Parameters:
//    gigyaUID - user ID designated by Gigya
//    siteUID - user ID designated by our site, to set in Gigya's user managment system (replace the Gigya UID)
//-------------------------------------------------------------------------------------------------------------
function finalizeGigyaRegistration($gigyaUID = "",$siteUID = ""){
	global $gigyaSecret,$gigyaApiKey;
	$request = new GSRequest($gigyaApiKey,$gigyaSecret,"socialize.notifyRegistration");				
	$request->setParam("uid",$gigyaUID);
	$request->setParam("siteUID",$siteUID);
	$response = $request->send();
	return $response->getErrorCode();
}

//------------------------------------------------------------------------------------------------------
// Method: notifySiteLogin
// Use case: User logged-in/registered using the site credentials (not through Gigya Social Login)
// Flow:
//   1. Notify Gigya of the occurrence (a site user logging in) 
//   2. Create a session cookie, so as to maintain the client application synchronized with the user state (for Gigya's usage) 
// Note: Please refer to Gigya's Developer's guide->User Management 360->Social Login. This method implements the "Site Login - Synchronizing with Gigya Service" section.
//------------------------------------------------------------------------------------------------------

function notifySiteLogin($uid = "",$isNewUser = "false", $userInfo=null ){
    global $gigyaSecret,$gigyaApiKey;
	// Notify Gigya of the occurrence
	$request = new GSRequest($gigyaApiKey,$gigyaSecret,"socialize.notifyLogin");
	$request->setParam("siteUID",$uid);
	$request->setParam("newUser",$isNewUser); // let gigya server know that it's a new user (not returning user)
	if ($userInfo!=null)
		$request->setParam("userInfo",json_encode($userInfo));
	$response = $request->send();
	
	// Create a session cookie
	try {
		setcookie ($response->getString("cookieName"), $response->getString("cookieValue"),0,$response->getString("cookiePath"),$response->getString("cookieDomain"));
	} catch (Exception $e) {}
	
	return 1;
}

//--------------------------------------------------------------------------
// Method: Validate Signature 
//   A Gigya utility method for verifying the authenticity of the signature received from Gigya
// Note: Please refer to Gigya's Developer's guide->User Management 360->Social Login. This method implements Step 3.
//--------------------------------------------------------------------------
function validateSignature($UID, $signatureTimestamp,$UIDSignature){
	global $gigyaSecret;
	return SigUtils::validateUserSignature($UID,$signatureTimestamp,$gigyaSecret,$UIDSignature);
}
