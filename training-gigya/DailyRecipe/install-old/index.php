<html>
<head>
<title>Daily Recipe Demo Site - Database Setup</title>
<style type="text/css">
<!--
html, body {
	margin-top:15px;
	background: #fff;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size:0.85em;
	color:#4d4948;
	text-align:center;
}

a {
 color:#4d4948;
}
-->
</style>
</head>
<body>
<p><img src="../images/Logo.gif"></p>
<?php

	define('INCLUDE_CHECK',true);
	require_once( str_replace('//','/',dirname(__FILE__).'/') .'../config.php'); 
		//Construct a db instance
		
	$db = new $sql_db();
	if(is_array($db->sql_connect(
							$db_host, 
							$db_user,
							$db_pass,
							$db_name, 
							$db_port,
							false, 
							false
	))) {
		echo "<strong>Unable to connect to the database, check your settings.<br /> Please check your settings and try again</strong>";	
	}
	else
	{
		
		$sql = "SELECT * FROM " . $db_table_prefix . "users LIMIT 1";
		
		$row = $db->sql_fetchrow($db->sql_query($sql));
		
		if($row > 0)
		{
			echo "<strong>Daily Recipe has already been installed.<br /> Please remove / rename the install directory.</strong>";	
		}
		else
		{
			$db_issue = false;			
				
				$users_sql = "
					 CREATE TABLE IF NOT EXISTS `".$db_table_prefix."users` (
						`ID` int(11) NOT NULL AUTO_INCREMENT,
						`Email` varchar(150) NOT NULL,
						`First_Name` varchar(255) DEFAULT NULL,
						`Last_Name` varchar(255) DEFAULT NULL,
						`Password` varchar(255) NOT NULL,
						`Birth` year(4) DEFAULT NULL,
						`Gender` varchar(150) DEFAULT NULL,
						`Avatar` varchar(255) DEFAULT NULL,
						`Status` int(11) NOT NULL,
						PRIMARY KEY (`ID`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
				";
				
				$users_entry = "
					INSERT INTO `users` (`ID`, `Email`, `First_Name`, `Last_Name`, `Password`, `Birth`, `Gender`, `Avatar`, `Status`) VALUES
					(1, 'test@test.com', 'testuser', 'user', 'df399dfd9e689a2d6f4815b07d0450f3db400075d6a9f4e900ef6d9b9760f7840', NULL, NULL, 'http://demo.gigya.com/images/avatar_48x48.gif', 0);	";	
						
				if($db->sql_query($users_sql))
				{
					echo "<br /><p>".$db_table_prefix."users table created.....</p>";
					echo "<br /><p>----------------------------------------------</p>";
					
					if($db->sql_query($users_entry))
					{
						echo "<br /><p> Default user added to table: </p>";
						echo "<p> Email: test@test.com</p>";
						echo "<p> Password: 1234</p>";
					}
					else
					{
						echo "<p>Error inserting default user .</p><br /><br /> DBMS said: ";
					
						echo print_r($db->_sql_error());
						$db_issue = true;
					}
				}
				else
				{
					echo "<p>Error constructing user table.</p><br /><br /> DBMS said: ";
					
					echo print_r($db->_sql_error());
					$db_issue = true;
				}
			
				if(!$db_issue)
					echo "<br /><p><strong>Database setup complete, please delete the install folder.</strong></p>";
				else
					echo "<p><a href=\"?install=true\">Try again</a></p>";
				
			
				
			}
	}
?>
</body>
</html>