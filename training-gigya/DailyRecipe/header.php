<?php
$logendIn = false;
define('INCLUDE_CHECK',true);

require_once('config.php');
require_once("user_dialogs_handlers/user_db_access.php");


if (empty($_SESSION)) {
  session_start();
}

// Login panel display status
$script = '';
if(!empty($_SESSION['login']))
{
	$userdetails = fetchUserDetails('',$_SESSION['login']);
  $logendIn = true;
    $script = '
   <script type="text/javascript">
   $(document).ready(function(){
       setLoginPanel("loggedIn");
    });
    </script>';
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb=http://www.facebook.com/2008/fbml>
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# socializedemo: http://ogp.me/ns/fb/socializedemo#">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, user-scalable=false"> <!-- For Mobile view  -->	
	<title>Daily Recipe - Gigya Demo Site</title>
	
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
 	<link href="css/style.css?v=2" rel="stylesheet" type="text/css" />
    <link href="css/sprites.css?v=2" rel="stylesheet" type="text/css" />
 	<link href="user_dialogs/dialogs.css" rel="stylesheet" type="text/css" />
    <script  type="text/javascript" lang="javascript">
    	var expire5min = (new Date()).getTime() + 120000; // expiration time - 5 min from now
	</script>	
	<!-- include Gigya's JS library -->    
	<script type="text/javascript" lang="javascript" src="http://cdn.gigya.com/JS/socialize.js?apikey=<?php echo $gigyaApiKey;?>">
	{ // Global configuration object for Gigya JS API methods
		sessionExpiration:0 // expire the user login session when the browser closes
		,connectWithoutLoginBehavior: 'alwaysLogin' // This will cause Gigya's 'Adding Connection' operation (i.e. when the user clicks one of the social network buttons within the Social Plugins) 
													// to behave like a call to login in case the current user is not logged in.
		,autoShareExpiration: expire5min // User's auto-share selection will expire after 5 min
		,facebookInitParams: {"cookie":true, "status":true, "xfbml":true, "oauth":true} // Facebook init for Graph Actions
		,deviceType: 'auto' // Automatically identify the device mobile/desktop (using user-agent) and optimize the view of the plugins accordingly
	}
	</script>
  	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>

	
	<script src="http://cdn.gigya.com/seal/seal.js?apiKey=<?php echo $sealKey;?>"></script> <!-- Loading Gigya's Social Privacy Certification Seal -->
	
	
	<!-- include JS libraries -->
	<script type="text/javascript" lang="javascript" src="js/jquery-1.6.min.js"></script>
	<script type="text/javascript" lang="javascript" src="js/json2.js"></script>    
	<script type="text/javascript" src="js/submit_form.js"></script>
    <script type="text/javascript" src="js/social_login.js"></script>
	<script type="text/javascript" src="js/selection_lists_data.js"></script>
	<script type="text/javascript" src="js/password_validator.js"></script>
  	<script type="text/javascript" src="js/mobile.js"></script>  <!-- Implements the mobile version of the menu !-->
  	<script type="text/javascript" src="js/fbAction.js"></script> <!-- Implementation of posting Facebook Open Graph action !-->

	<!-- Facebook's Open Graph tags !-->
	<meta property="fb:app_id" content="<?php echo $FBAppID?>"> 
  	<meta property="og:url" content="<?php echo $pageURL ?>"> 
  	<meta property="og:title" content="<?php echo $title ?>"> 
  	<meta property="og:description" content="<?php echo $description ?>"> 
  	<meta property="og:type" content="socializedemo:recipe"> 
  	<meta property="og:image" content="<?php echo $websiteUrl . '/' . $image ?>">
  	<meta property="og:site_name" content="<?php echo $websiteName ?>"/>
  	
	<script type="text/javascript" src="http://cdn.gigya.com/js/gigyaGAIntegration.js"></script> <!--Loading  Gigya's Google Analytics plug&play library-->
	
	<script type="text/javascript">
		// Google Analytics load
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', "<?php echo $GAaccount ?>"]);
		_gaq.push(['_trackPageview']);
		
		(function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	
	</script>
</head>
<body class="<?php echo $current_page ?>">
<?php echo $script;?>


<div class="wrap">
<?php
// The user dialogs:
require_once("user_dialogs/login.php");
require_once("user_dialogs/register.php");	
require_once("user_dialogs/provide_email.php");	
require_once("user_dialogs/link_accounts.php");	
?>

	<div style="clear:both;"></div>

	<!-- Poping the user dialogs  -->
	<script type="text/javascript">
		function showDialog(dialogID){
			$(dialogID).show();
		}

	    function closeDialog(dialogID, formID, errorMsg){
			$(dialogID).hide();
			document.getElementById(formID).reset();
			$(errorMsg).text("");
			$(errorMsg).hide();
				
		}
	
	</script>
	
	<script type="text/javascript">
		// fill the selection list of birth-year in the registration dialog and in the provide-email dialog
	    for (year in years_options) {     	
	       	$('#yearbirth').append($("<option></option>").attr("value", years_options[year]).text(years_options[year])); // selection list in the registration dialog
	       	$('#missingYearbirth').append($("<option></option>").attr("value", years_options[year]).text(years_options[year])); // selection list in the provide-email dialog
	    }		
		
		$('#password').focus(function(){
			$('#passwordHint').html(passwordError+'<span class="hint-pointer">&nbsp;</span><br /><br /><div id="passwordInidcator" class="passwordInidcator">&nbsp;</div><span class="hint-strength" id="hint-strength"></span></span>');
			var pos = $(this).position();
			var width = $(this).outerWidth();
			$("#passwordHint").css({
		        position: "absolute",
		        top: pos.top + "px",
		        left: (pos.left + width + 20) + "px"
		    }).show();
		    
		});

		$('#password').keyup(function(){
			var retPasss = validatePassword($("#password").val());
			$('#hint-strength').html(retPasss);
			if('Perfect' == retPasss){
					$('#hint-strength').css('color', 'green');
					$('#passwordInidcator').css('background-color', 'green');
					$('#hint-strength').html('Password strength: Strong  ');
			}
			else{
				$('#hint-strength').css('color', 'red');
				$('#passwordInidcator').css('background-color', 'red');
			}
		});

		$('#password').blur(function(){
			$('#passwordHint').hide();
		});
	</script>
	

	<!--  Header  -->
	<div class="header">
    	<div class="mobile-menu"></div> <!-- Mobile menu  -->

		<div class="logo"><a href="index.php" class="link">Daily Recipe</a></div>
		<!-- The Menu bar  -->	
		<div class="menu">
			<div class="menu-item menu-item-first">
				<a href="index.php" <?php echo $current_page == "home" ? "class=\"selected\"" : ""; ?>>HOME</a>
			</div>
			<div class="menu-item">
				<a href="recipe1.php" <?php echo $current_page == "recipe1" ? "class=\"selected\"" : ""; ?>>RECIPE OF THE DAY</a>
			</div>
			<div class="menu-item">

				<a href="recipe2.php" <?php echo $current_page == "recipe2" ? "class=\"selected\"" : ""; ?>>OUR FAVORITE</a>
			</div>
			<div class="menu-item">
				<a href="recipe3.php" <?php echo $current_page == "recipe3" ? "class=\"selected\"" : ""; ?>>MOST POPULAR</a>
			</div>
			<div class="menu-item menu-item-last">
				<a href="about.php" <?php echo $current_page == "about" ? "class=\"selected\"" : ""; ?>>ABOUT</a>
			</div>
        </div>
        
        <!-- The login-bar  -->	
        <div class="loginBar">
            <?php if (!$logendIn): ?>
            <!-- The bar when the user is not logged-in (initial state) -->
            <div id="div_notLoggedIn" class="logged-out">
              <div class="loginBar-item hello">Hello Guest!</div>
              <div class="actions">
              <div class="loginBar-item login">
                <a href="#" onclick="closeDialog('#registerDialog','formRegister','#registrationMessage');showDialog('#loginDialog');">Login</a>
              </div>
              <div class="loginBar-item register">
                <a href="#" onclick="closeDialog('#loginDialog','formLogin','#loginMessage');showDialog('#registerDialog')">Register</a>
              </div>
                </div>
            </div>
            <?php else :?>
            <!-- The bar when the user is logged-in -->
            <div id="div_LoggedIn" class="loginBar logged-in">
              <div class="loginBar-item loginBar-image"><img class="userimage" src="<?php echo $userdetails["Avatar"]?>"/></div>
              <div class="login-text loginBar-item ">
                <div class="user-name"><?php echo $userdetails["First_Name"] . " " . $userdetails['Last_Name']?></div>
                <div class="logout"><a href="#" onclick="gigya.socialize.logout();">Logout</a></div>
              </div>
            </div> <!-- / top -->
            <?php endif; ?>
		</div>
	</div>
	<!--  Body -->
	<div class="body">
		<div class="body-wrap ui-helper-clearfix">