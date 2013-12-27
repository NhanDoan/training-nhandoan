<?php
//--------------------------------------------------------------------------
// This file include user DB Access Methods and some general utility methods
//--------------------------------------------------------------------------

	//--------------------------------------------------------------------------
	// isEmailExists
	//   Check if the input $email already exist in the DB
	//--------------------------------------------------------------------------
	function isEmailExists($email)
	{
		global $db,$db_table_prefix;
		
		$sql = "SELECT *
				FROM ".$db_table_prefix."users
				WHERE
				Email = '".$db->sql_escape(sanitize($email))."'
				LIMIT 1";
		
		$count = 0;
		$result = $db->sql_query($sql);
		
		while ($row = $db->sql_fetchrow($result))
		{
		  $count++;
		}
		
		$db->sql_freeresult($result);
		
		return ($count>0);
	}

	//--------------------------------------------------------------------------
	// fetchUserDetails
	//   Searches a user in the DB based on his email or his ID,
	//   and Returns the row associated with this user
	//--------------------------------------------------------------------------
	function fetchUserDetails($email=NULL,$userID = NULL)
	{
		global $db,$db_table_prefix; 
		
		if($email!=NULL) 
		{  
			$sql = "SELECT * FROM ".$db_table_prefix."users
					WHERE
					Email = '".$db->sql_escape(sanitize($email))."'
					LIMIT
					1";
		}
		else if($userID!=NULL)
		{
			
			$sql = "SELECT * FROM ".$db_table_prefix."users
					WHERE
					ID = '".$db->sql_escape(sanitize($userID))."'
					LIMIT
					1";
		}
		 
		$result = $db->sql_query($sql);
		
		$row = $db->sql_fetchrow($result);
		
		return ($row);
	}
	
	
	//--------------------------------------------------------------------------
	// addDBUser
	//   This method adds a new user record to the site DB.
	//--------------------------------------------------------------------------
	function addDBUser($email,$firstname,$lastname,$secure_pass,$birth,$gender,$thumb)
	{
		if(empty($thumb))
			$thumb = $websiteUrl . "/images/avatar_48x48.gif";
			
		global $db,$db_table_prefix; 
		$sql = "INSERT INTO `".$db_table_prefix."users` (
			`Email`,
			`First_Name`,
			`Last_Name`,
			`Password`,
			`Birth`,
			`Gender`,
			`Avatar`,
			`Status`
			)
	 		VALUES (
	 		'".$db->sql_escape($email)."',
	 		'".$db->sql_escape($firstname)."',
			'".$db->sql_escape($lastname)."',
	 		'".$secure_pass."',
			'".$db->sql_escape($birth)."',
			'".$db->sql_escape($gender)."',
			'".$db->sql_escape($thumb)."',
			'1'
		)";
		return $db->sql_query($sql);
					
	}

			
	//--------------------------------------------------------------------------
	// setUserLoginStatus
	//   This method changes the user's login status in the site DB.
	//   User's login status may be one of the following:
	//   '0' - signifies logged-out
	//   '1' - signifies logged-in
	//--------------------------------------------------------------------------
	function setUserLoginStatus($status="0",$userID)
	{
		// change the status in the user DB
		global $db,$db_table_prefix;
			
		$sql = "UPDATE ".$db_table_prefix."users
				SET
				Status = '".$status."'
				WHERE
				ID = '".$db->sql_escape($userID)."'";
		
		if ($status=="1") 
			$_SESSION['login'] = $userID; // login - create a login session and store the user ID in it.
		else
			destorySession("login");  // logout - destroy the login session
		
		return ($db->sql_query($sql));
	}
	
	

//--------------------------------------------------------------------------
// Internal Methods
//--------------------------------------------------------------------------
	
	//--------------------------------------------------------------------------
	// sanitize - The method sanitizes the input string
	//--------------------------------------------------------------------------
	function sanitize($str)
	{
		return strtolower(strip_tags(trim(($str))));
	}

	//--------------------------------------------------------------------------
	// destorySession -  Removes a login session
	//--------------------------------------------------------------------------		
	function destorySession($name)
	{
		if(isset($_SESSION[$name]))
		{
			$_SESSION[$name] = NULL;
			
			unset($_SESSION[$name]);
		}
	}
		
?>
