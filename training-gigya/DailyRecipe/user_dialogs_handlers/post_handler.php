<?php
//------------------------------------------------------------------------------------------------------
// 	post_handler.php - 
//		processes AJAX POST requests.
//		The types of requests that are handled here:
//		+ Registration form submission
//		+ Login form submission
//		+ Link Accounts form submission
//		+ Social Login (user clicked on Gigya's Login plugin)
//		+ User submitted missing Email
//		+ User clicked "Logout"
//------------------------------------------------------------------------------------------------------

require_once("gigya_wrap.php");
require_once("utility_functions.php");

if (empty($_SESSION)) {
  session_start();
}
$error = "";
$returnVal = "ERROR";// The return value of the process. The possible values are: 
					 // "ERROR" - failure.
					 // "SUCCESS" - the user has been successfuly registered/logged-in/..
					 // "MISSING_EMAIL" - the registration is pending. The user must supply his email as a condition for the registration completion.
					 //        The email may be missing because it is not provided by the social network.
					 // "EMAIL_NOT_UNIQUE" - the registration is pending. The email provided by the SN is already used by a registered user. 
					 //        The user will be given the the option to link to his site account.  

$userdetails= "";
if (!empty($_POST)) {
  $userObject = $_POST["userObject"]; // userObject in JSON format
  $action = $_POST["action"];
}

	switch ($action)
	{
	// Register using site credentials:
	// User registered to site using the site registration form
	//--------------------------------------------------------------
	case "register":  
			
		// fetch user details from the registration form
		$email = trim($_POST["email"]);
		$firstname = trim($_POST["firstname"]);
		$lastname = trim($_POST["lastname"]);
		$password = trim($_POST["password"]);
		$yearbirth = trim($_POST["yearbirth"]);
		$gender = trim($_POST["gender"]);
		$thumb = $websiteUrl . "/images/avatar_48x48.gif";
		// Validate form fields values
		if(!isValidEmail($email))
		{
			$error= "Invalid email address";
		}
		elseif(isEmailExists($email))
		{
			$returnVal = "EMAIL_NOT_UNIQUE"; 
			$error = "Email is already in use";
		}
		elseif(!minMaxRange(4,50,$password))
		{
			$error = "Your password must be at least 4 characters long";
		}
		
		if($error == ""){		
			//Create new user in the local site DB
			$secure_pass = generateHash($password);
			$result = addDBUser($email,$firstname,$lastname,$secure_pass,$yearbirth,$gender,$thumb);
			if (!$result) {
				$error =  'Invalid query: ' . mysql_error();				
			} 
			else
			{
				$userdetails = fetchUserDetails($email);
				$_SESSION['login'] = $userdetails["ID"]; // create a login session and store the user ID in it.
				$userInfo = array('firstName'=> $firstname, 'lastName'=> $lastname, 'gender'=> $gender, 'email'=> $email, 'thumbnailURL'=> $thumb);
				notifySiteLogin($userdetails["ID"],"true",$userInfo); // notify to Gigya of the site login
															// (see  Social Login-> "Site Login - Synchronizing with Gigya Service" section).
				$returnVal = "SUCCESS"; 
			}		
		}		
	    break;
	
	
	// Login using site credentials - user action is either: 
	//     a. User logged in using the site login form (enterded site credentials in the "Login" dialog)
	//     b. User linked to his site account (using the "link account" dialog
	//-----------------------------------------------------------------
	case "login":
	case "linkAccounts": 
		                                                      
		// fetch user's email & password from the form
		$email = trim($_POST["email"]);
		$password = trim($_POST["password"]);
		
		// check email & password validity
		if(empty($email)) {
			$error = "Email is missing";
		}
		else if(empty($password)) {
			$error = "Password is missing";
		}
		if($error == ""){	
			$result = isEmailExists($email); // check if the suplied email already exists in the site DB
			if (!$result) {
				$error =  "Invalid Email and/or Password!" ;
			} 
			else{
				$userdetails = fetchUserDetails($email);
				$entered_pass = generateHash($password,$userdetails["Password"]);
				if($entered_pass != $userdetails["Password"])
				{
					$error = "Invalid Email and/or Password!";
				}
				else{ // the email & password that user entered are valid!
									
					if("linkAccounts" == $action) //  User action - user pressed the "link account" button (right after Social Login)
						finalizeGigyaRegistration($_SESSION['login'], $userdetails["ID"]); // link between the site user account and the Gigya user account
																						 // (see  Social Login-> Step 10)
					else //  User action "login" - user logged in using site form with site credentials
						notifySiteLogin($userdetails["ID"],"false"); // notify to Gigya of the site login
																	// (see  Social Login-> "Site Login - Synchronizing with Gigya Service" section).
						
	
					setUserLoginStatus("1",$userdetails["ID"]); // change the user's status to '1' (logged-in)
					$returnVal = "SUCCESS";
					 
				}		
			}
		}
	    break;
	
	
	// Social Login (user clicked on Gigya's Login plugin)
	//----------------------------------------------------
	// This section implements Gigya's Social Login best practice integration steps as described in http://developers.gigya.com/010_Developer_Guide/10_UM360/030_Social_Login
	case "socialLogin": // User clickeded on Gigya's Login plugin
		
		// verifying the authenticity of the signature received from Gigya	(see Social Login -> Step 3)
		if(!validateSignature($userObject["UID"],$userObject["signatureTimestamp"], $userObject["UIDSignature"])){
			$error =  'Invalid signature!';
		}		
	
		// Check whether the user is new (see Social Login -> Step 4)
		// If isSiteUID=='true' , this means the UID was supplied by the site in a previous login flow, hence the user is a returning user.
		elseif($userObject["user"]["isSiteUID"] == "true") { // returning user, already registered in site -> change the user status on the site
			$userdetails = fetchUserDetails('',$userObject["UID"]);
			if (!$userdetails) { // make sure this user exists on site DB
				$error =  'User does not exist in the site DB'; // this senario may happen only if the user was deleted from local DB (e.g. during development stage)
			}
			else{
				// The user is a returning user -> complete the login proccess (see Social Login -> Step 5)
				setUserLoginStatus("1",$userObject["UID"]); // change the user's status to '1' (logged-in)
				$returnVal = "SUCCESS";  // return value - notify the caller of the social login success
			}
		}
		
		// New user in Gigya's platform 
		// Check if email is missing (see Social Login -> Step 6)	
		elseif (empty($userObject["user"]["email"]))   { 
			// The email is not provided by the social network.   
			// We return a "MISSING_EMAIL" value, the user is redirected to provide his email as a condition for the registration completion. 
			// (see Social Login -> Step 8.b)		
			$_SESSION['missingEmail'] = $userObject; // create a login session and store the user ID in it.
			$returnVal = "MISSING_EMAIL";	         // we return a "MISSING_EMAIL" value, which means that the registration is pending. 
		}
		
		// Check if email exists in our system (user DB) (see Social Login -> Step 7)
		elseif (isEmailExists($userObject["user"]["email"])){  
			// The email provided by the SN is already used by a registered user. 
			// We return a "EMAIL_NOT_UNIQUE" value, the user is redirected to link accounts 
			// (see Social Login -> Step 8.a)  
			$_SESSION['login'] = $userObject["UID"]; // create a login session and store the user ID in it.
			$returnVal = "EMAIL_NOT_UNIQUE";	// we return a "EMAIL_NOT_UNIQUE" value, which means that the registration is pending. 										
		}
		
		else{ // email exist and is unique
			// Register the new user (see Social Login -> Steps 9,10)
			$userdetails = registerNewUser($userObject);     // Store the new user in the site's user-DB, and notify Gigya of registration completion
													// The return value is the new user record, or null incase of error
			if ($userdetails == null) {
				$error =  'Registration of new user failed!';
			}
			else{
				setUserLoginStatus("1",$userdetails["ID"]); // change the user's status to '1' (logged-in)
				$returnVal = "SUCCESS";    // Successful registration!
			}
	
		}
	    break;
		
	
	// User provided missing Email
	// User action - user submitted a missing email in the 'provide email' form (after social registration)
	//-------------------------------
	case "provideEmail":
		
		$email = trim($_POST['loginEmail']);
		$yearbirth = trim($_POST["yearbirth"]);
		$gender = trim($_POST["gender"]);
		
		if(!isValidEmail($email)){
			$error= "Invalid email address";
			$returnVal = "INVALID_EMAIL";
		}
		elseif(isEmailExists($email))
			$returnVal = "EMAIL_NOT_UNIQUE";
	
		else {
			$userObject = $_SESSION['missingEmail'];
			$userObject["user"]["email"] = $email;
			$userObject["user"]["birthYear"] = (!isset($userObject["user"]["birthYear"]) || $userObject["user"]["birthYear"]==0) ? $yearbirth : $userObject["user"]["birthYear"] ;
			$userObject["user"]["gender"] = (isset($gender)) ? $gender : $userObject["user"]["gender"] ;
	
			$userdetails = registerNewUser($userObject);  // Add the new user to the site's user-DB, and notify Gigya of registration completion
													// (see  Social Login ->Best Practice -> steps 9,10)
													// The return value is the new user record, or null incase of error
			if ($userdetails == null) {
				$error =  'Registration of new user failed!';
			}
			else{
				destorySession('missingEmail'); // removes the user object from the session
				setUserLoginStatus("1",$userdetails["ID"]); // change the user's status to '1' (logged-in)
				$returnVal = "SUCCESS"; // social login success
			}	
		}	
	    break;
	
	
	// User clicked "Logout"
	//-------------------------------
	case "logoff": //  User action - user pressed 'Log off'
		$result = setUserLoginStatus("0", $_SESSION['login']); // change the user's status to '0' (logged-out)
		if (!$result) {
			$error =  'Invalid query: ' . mysql_error();
		}
		else{
			$returnVal = "SUCCESS"; 
		}
	    break;
	
	// Fallback
	//-----------
	default:
		$error = "unknown action";
	}


echo json_encode((object) array("error"=>$error,"returnVal"=>$returnVal,"userDetails"=>$userdetails));

	
?>