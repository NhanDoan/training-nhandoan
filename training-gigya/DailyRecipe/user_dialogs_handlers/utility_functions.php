<?php

//--------------------------------------------------------------------------
// General Utility Methods
//--------------------------------------------------------------------------

	//--------------------------------------------------------------------------
	// isValidEmail
	//   This method verifies that the input string constitutes a valid email string 
	//--------------------------------------------------------------------------
	function isValidEmail($email)
	{
		return preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",trim($email));
	}
	
	//--------------------------------------------------------------------------
	// minMaxRange
	//   Verifies that the input $str length is inbetween the range of $min & $max 
	//--------------------------------------------------------------------------	
	function minMaxRange($min, $max, $str)
	{
		return (strlen(trim($str)) >= $min) && (strlen(trim($str)) <= $max);
	}

	//--------------------------------------------------------------------------
	// generateHash
	//--------------------------------------------------------------------------	
	function generateHash($plainText, $salt = null)
	{
		if ($salt === null)
		{
			$salt = substr(md5(uniqid(rand(), true)), 0, 25);
		}
		else
		{
			$salt = substr($salt, 0, 25);
		}
	
		return $salt . sha1($salt . $plainText);
	}

	

	
	//--------------------------------------------------------------------------
	// generatePassword
	//	 Generates a random password
	//--------------------------------------------------------------------------		
	function generatePassword($length = 4) {
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$chars .= '!@#$%^&*()';
		$password = '';
		for($i = 0; $i < $length; $i++ ) {
			$password .= substr($chars,rand(0, strlen($chars) - 1), 1);
		}
		if(empty($password))
			return (object) array('error'=>"<strong>ERROR: </strong>".__('Error creating random password'));
		
		return $password;
	}
	
	
?>