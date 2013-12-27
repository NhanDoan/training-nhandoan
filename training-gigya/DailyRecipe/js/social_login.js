//------------------------------------------------------------------------------------------------------
// This JS file implements client side usage of Gigya (using Gigya's JS API).
// The methods that are implemented here, including Gigya's Login plugin, comprise part of Gigya's Social Login best practice implementation. 
// This file is used by login.php (Login Dialog) and by register.php (Registration Dialog).
//------------------------------------------------------------------------------------------------------

$(document).ready(function() {
		
	// Register to Gigya onLogin & onLogout events
	gigya.socialize.addEventHandlers({   
     onLogin: onLoginHandler  // A reference to a function that is called when the user is successfully logs in through Gigya
		,onLogout: onLogoutHandler  // A reference to a function that is called when the user has logged out.
	});
	
	// Present Gigya's Login plugin...
	var params = { // Plugin's parameters
			height: 100
			,width: 313
			,showTermsLink: false
		  ,hideGigyaLink: true
		  ,showWhatsThis: false
			,UIConfig: '<config><body><controls><snbuttons buttonsize="35" /></controls></body></config>'
			,buttonsStyle: 'fullLogo'
			,facebookExtraPermissions:'user_likes'
    };
	
	//  in the 'loginPluginDiv' <div> element inside the Login Dialog (login.php)
	params["containerID"] = 'loginPluginDiv';  // The plugin is presented in the 'loginPluginDiv' <div> element (see definition in login.php )
	gigya.socialize.showLoginUI(params);    // This Gigya JS API method invokes the Login plugin

	//  and in the 'loginPluginRegisterDiv' <div> element inside the Register Dialog (register.php)
	params["containerID"] = 'loginPluginRegisterDiv';  // The plugin is presented in the 'loginPluginRegisterDiv' <div> element (see definition in register.php)
	gigya.socialize.showLoginUI(params);



	// Show Gigya's Social Privacy Certification Seal in the "sealUIRegisterDiv" <div> (inside the register dialog) -->
	gigya.socialize.showSealUI({
        containerID: "sealUIRegisterDiv"
      });
	
	// Show Gigya's Social Privacy Certification Seal in the "sealUI" <div> (inside the login dialog) -->
	gigya.socialize.showSealUI({
        containerID: "sealUI"
      });


});


//onLogout Event handler
function onLogoutHandler(eventObj) {
	// Site Logout - update site DB and UI
	$.ajax({
		type: "POST",
		url: "user_dialogs_handlers/post_handler.php",
		data:'action=logoff',
		dataType: "json",
		success: function(response){
			if(response.returnVal == "ERROR")
				$('#reg_error').text(response.error);
			else{
        window.location.reload();
				//setLoginPanel("loggedOut");
			}
		}
	});	
}


// onLogin Event handler
function onLoginHandler(eventObj) {	
	// Post a request to the server to handle Social Login
	// The request is handled by social_login.php
	try{
	    $.post("user_dialogs_handlers/post_handler.php", { "userObject": eventObj, "action" : "socialLogin" },
			function(response){ 	
				switch(response.returnVal)
				{
					case "ERROR":  // social login failure
						alert("Gigya Login error : " +  response.error);
					  	break;
					case "SUCCESS": //successfull social login
						closeDialog('#loginDialog','formLogin','#loginMessage');
						closeDialog('#registerDialog','formRegister','#registrationMessage');
            window.location.reload();
						//setUserDetailsInPanel(response.userDetails["First_Name"],response.userDetails["Avatar"]);
						//setLoginPanel("loggedIn");
						if (eventObj.provider == "facebook")
						    $("#cooked").show();
						//try{gigya.gm.showUserStatusUI(userStatusParams);}catch(e){alert(e.message);} //For Game Mechanics
					  	break;
					case "MISSING_EMAIL": // Email is missing. The registration is pending. The user must supply his email as a condition for the registration completion.
						// Pre-populate the form with data from the social network
						$("#welcomeUserImage").attr("src",eventObj.user.thumbnailURL);
				    	$("#welcomeUserFirstName").text(eventObj.user.firstName);
						$("#missingYearbirth").val(eventObj.user.birthYear); 
						if (eventObj.user.gender != "")
							document.getElementById(eventObj.user.gender).selected=true;
						closeDialog('#loginDialog','formLogin','#loginMessage');
						closeDialog('#registerDialog','formRegister',"#registrationMessage");
						showDialog('#provideEmailDialog'); // Show the "Provide email" dialog, which asks the user to enter his email
						break;	
						
					case "EMAIL_NOT_UNIQUE": // Email is missing. The registration is pending. The user must supply his email as a condition for the registration completion.					
						// Pre-populate the form with data from the social network
						$("#linkUserImage").attr("src",eventObj.user.thumbnailURL);
				    	$("#linkWelcomeUserFirstName").text(eventObj.user.firstName);
						$("#linkEmail").attr("value",eventObj.user.email);
						closeDialog('#loginDialog','formLogin','#loginMessage');
						closeDialog('#registerDialog', 'formRegister',"#registrationMessage");
						showDialog('#linkAccountDialog'); // Show the "Link Accounts" dialog, which asks the user to link to an existing site account.
						break;	
						
					default:
						alert("default, onLoginHandler: " +  response.success);
				}
			}
 		, "json");
	}catch(e){}			
}


// Utility methods:

// Update the login bar to show user details
function setUserDetailsInPanel(sName,sAvatarURL )
{
	$("#userimage").attr("src",sAvatarURL);
	$("#userFirstName").text(sName);
}

// Change the state of the login bar logged-in/logged-out
function setLoginPanel(state)
{
	if("loggedIn" == state){
    //window.location.reload();
	}else{
		$("#div_notLoggedIn").show();
		$("#div_LoggedIn").hide();
		$("#cooked").hide();
	}
}


