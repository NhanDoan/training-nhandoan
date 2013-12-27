//------------------------------------------------------------------------------------------------------
// 	This file implements the forms' submission using AJAX
//------------------------------------------------------------------------------------------------------


function validateEmail(email){
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

$(document).ready(function() {

	// Login Form submit
	//-------------------------------
	$("#login").click(function() {
		 if(!validateEmail( $("#loginEmail").val())){
			 $("#loginMessage").text("Please enter a valid e-mail address");
			 $('#loginMessage').show();
			 return false;
		}
		if ($("#loginPassword").val()==null || $("#loginPassword").val()=="" ){
			 $("#loginMessage").text("Please enter a password");
			 $('#loginMessage').show();
			 return false;
		}
		
		var formData = {
			email: $("#loginEmail").val(),
			password: $("#loginPassword").val(),
			action: 'login'
		};
		$('#loginMessage').hide();
		$.ajax({
			type: "POST",
			url: "user_dialogs_handlers/post_handler.php",
			data: formData,
			dataType: "json",
			success: function(response){				
				switch(response.returnVal)
				{
					case "SUCCESS": //success
						closeDialog('#loginDialog','formLogin','#loginMessage');
						setUserDetailsInPanel(response.userDetails["First_Name"],response.userDetails["Avatar"]);
            window.location.reload();
            //setLoginPanel("loggedIn");
						break;
					default:
						$("#loginMessage").text("Invalid Email and/or Password!");
						$('#loginMessage').show();
				}				
			}
		});

		return false;
	});
	
	
	// Registration Form submit
	//-------------------------------
	$("#register").click(function() {
		if(!validateEmail( $("#email").val())){
			 $("#registrationMessage").text("Please enter a valid e-mail address");
			 $("#registrationMessage").show();
			return false;
		}
		if ($("#password").val()==null || $("#password").val()=="" || $("#repassword").val()==null || $("#repassword").val()==""){
			 $("#registrationMessage").text("Please enter a password");
			 $("#registrationMessage").show();
			 return false;
		}
		if ($("#password").val() !=  $("#repassword").val()){
			 $("#registrationMessage").text("The password and verified password do not match.");
			 $("#registrationMessage").show();
			 return false;
		}
		
		if('Perfect' != validatePassword($("#password").val())){
			$("#registrationMessage").text(passwordError);
			$("#registrationMessage").show();
			return false;
		}
		
		if ($("#firstnameReg").val()==null || $("#firstnameReg").val()==""){
			 $("#registrationMessage").text("Please enter you first name");
			 $('#registrationMessage').show();
			 return false;
		}
		if ($("#lastnameReg").val()==null || $("#lastnameReg").val()==""){
			 $("#registrationMessage").text("Please enter you last name");
			 $('#registrationMessage').show();
			 return false;
		}
		
		if ($("#yearbirth").val() == ""){
			 $("#registrationMessage").text("Please choose your birth year");
			 $('#registrationMessage').show();
			 return false;
		}	

		var formData = {
			email: $("#email").val(),
			password: $("#password").val(),
			firstname: $("#firstnameReg").val(),
			lastname: $("#lastnameReg").val(),
			yearbirth: $("#yearbirth").val(),
			gender: $("#gender").val(),
			action: 'register'
		};
		
		$("#registrationMessage").text("");
		$("#registrationMessage").hide();
		$.ajax({
			type: "POST",
			url: "user_dialogs_handlers/post_handler.php",
			data: formData,
			dataType: "json",
			success: function(response){
				switch(response.returnVal)
				{
					case "SUCCESS": //success
						closeDialog('#registerDialog','formRegister',"#registrationMessage");
						//$("#successValidationEmail").show();
						setUserDetailsInPanel(response.userDetails["First_Name"],response.userDetails["Avatar"]);
            window.location.reload();
						//setLoginPanel("loggedIn");
						//try{gigya.gm.showUserStatusUI(userStatusParams);}catch(e){alert(e.message);} //For Game Mechanics
						break;
					case "EMAIL_NOT_UNIQUE": // The email provided by the user already exists in the DB
						$("#registrationMessage").text("Regsitration Failed. The email you have provided already exists in our system.");
						$("#registrationMessage").show();
						break;
					default:
						$("#registrationMessage").text("Regsitration Failed. Error message: " + response.error);
					 	$("#registrationMessage").show();	
				}	
			}
		});
		return false;
	});
	
	// Link Accounts Form handler
	//-------------------------------
	$("#linkAccount").click(function() {
		if(!validateEmail( $("#linkEmail").val())){
			 $("#linkAccountMessage").text("Error: Email is missing");
			 $("#linkAccountMessage").show();
			return false;
		}
		if ($("#linkPassword").val()==null || $("#linkPassword").val()=="" ){
			 $("#linkAccountMessage").text("Please enter a password");
			 $("#linkAccountMessage").show();
			 return false;
		}
		var formData = {
			email: $("#linkEmail").val(),
			password: $("#linkPassword").val(),
			action: 'linkAccounts'
		};
		
		$("#linkAccountMessage").text("");
		$("#linkAccountMessage").hide();
		$.ajax({
			type: "POST",
			url: "user_dialogs_handlers/post_handler.php",
			data: formData,
			dataType: "json",
			success: function(response){
				switch(response.returnVal)
				{
					case "SUCCESS": //success
						closeDialog('#linkAccountDialog','linkForm','#linkAccountMessage');
						setUserDetailsInPanel(response.userDetails["First_Name"],response.userDetails["Avatar"]);
            window.location.reload();
						//setLoginPanel("loggedIn");
						//try{gigya.gm.showUserStatusUI(userStatusParams);}catch(e){} //For Game Mechanics
						break;
					default:
						$("#linkAccountMessage").text(response.error);
						$('#linkAccountMessage').show();
				}	
			}
		});

		return false;
	});

	
	// User provided missing Email
	//-------------------------------
	$("#provideEmail").click(function() {
		if(!validateEmail( $("#missingEmail").val())){
			 $("#provideEmailMessage").text("Please enter a valid e-mail address");
			 $("#provideEmailMessage").show();
			return false;
		}
		if ($("#missingYearbirth").val() ==  ""){
			 $("#provideEmailMessage").text("Please choose your birth year");
			 $('#provideEmailMessage').show();
			 return false;
		}	

		var formData = {
			loginEmail: $("#missingEmail").val(),
			yearbirth: $("#missingYearbirth").val(),
			gender: $("#missingGender").val(),
			//newsletter: $('#newsletter').prop("checked"),
			action: 'provideEmail'
		};
		
		$("#provideEmailMessage").text("");
		$("#provideEmailMessage").hide();
		$.ajax({
			type: "POST",
			url: "user_dialogs_handlers/post_handler.php",
			data: formData,
			dataType: "json",
			success: function(response){
				switch(response.returnVal)
				{
					case "SUCCESS": //success
						closeDialog('#provideEmailDialog','emailForm','#provideEmailMessage');
						//$("#successValidationEmail").show();
						//window.setTimeout('window.location="login.php"',20000);
						setUserDetailsInPanel(response.userDetails["First_Name"],response.userDetails["Avatar"]);
            window.location.reload();
						//try{gigya.gm.showUserStatusUI(userStatusParams);}catch(e){} //For Game Mechanics
						break;
					case "EMAIL_NOT_UNIQUE": // The email provided by the user already exists in the DB
						$("#provideEmailMessage").html("The email you have provided already exists in our system. Please provide a different email.<br/><br/><span style=\"color: #333333;\">Already have an Account?<span> <a style=\"color:#2095e6;\" href=# onclick=\"closeDialog('#provideEmailDialog','emailForm','#provideEmailMessage'); showDialog('#linkAccountDialog')\">Link Your Account</a>");
						$("#provideEmailMessage").show();
						break;
					default:
						$("#provideEmailMessage").text("Regsitration Failed. Error message: " + response.error);
					 	$("#provideEmailMessage").show();	
				}	
			}
		});

		return false;
	});

});