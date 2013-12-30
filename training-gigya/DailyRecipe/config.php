
<?php

/* Database config */
$dbtype = "mysql"; 
$db_host = "localhost";  // Enter here your host name 
$db_user = "root";  // Enter here your DB user name
$db_pass = "";  // Enter here your DB password
$db_name = "gigya_database";  // Enter the name of the newly created DB name (e.g. DailyRecipeDB)
$db_port = "";
$db_table_prefix = "";
$langauge = "en";
/* End Database config */

$websiteUrl = "http://localhost/DailyRecipe"; // Change this to your demo site URL
$websiteName = "Daily Recipe";

//Current Page URL
$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
if ($_SERVER["SERVER_PORT"] != "80")
{
    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
} 
else 
{
    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
}


require_once( str_replace('//','/',dirname(__FILE__).'/') .'db/mysql.php'); 


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
	die("Unable to connect to the database");
}

// Facebook open graph App ID
$FBAppID = "";  // Enter here your Facebook Application ID (optional)

//Google Analytics Code
$GAaccount = ""; // Insert your Google Analytics account code (optional)

//---------------------------------------------------------------------------
//Gigya Settings
//--------------------------------------------------------------------------

global $gigya_api_key,$gigya_secret; 

$gigyaApiKey = "3_EI_66qADeEaw3XLW9uQKfEOy-7EuP0fDaUTk-44x4N9rZh0LXUGcoxt5yJ0PEXCq"; // Enter here your Gigya API Key
$gigyaSecret = "W2NGv9a2eGhwUUwhJLMuiSYWqPptqiN6pfA50zFJgG8=";  // Enter here your Gigya Secret Key

$sealKey = "";	// Enter here your seal key (optional)

$commentsCategoryID = "Comment-daily-demo";  // Enter here your Comments plugin Category ID (optional)
$ratingsCategoryID = "rating-daily"; // Enter here your Reviews plugin Category ID (optional)
	
?>