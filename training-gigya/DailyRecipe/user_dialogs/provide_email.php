<?php 
	$userAvatar =  "user_dialogs/images/avatar_100px.jpg";
?>


	<div id="provideEmailDialog" class="contentRegister" style="height:460px;" >	
		<div class="dialogClose" onclick="closeDialog('#provideEmailDialog','emailForm','#provideEmailMessage')" ></div>
		
		<div id="inheaderlinkAccount">				
				<div class="userImage" >
					<img id="welcomeUserImage" src="<?php echo $userAvatar?>" height="42" width="42" >
				</div>
				<div id="userMainDetails">
					Welcome <span id="welcomeUserFirstName"></span>
				</div>	
		</div>
			<div id="container">
				<div id="side-a">
					
					<p><span class="linkNewText">We still need some details from you...</span></p>
					<form id="emailForm" name="emailForm" method="post">
						<p>
							<label for="missingEmail">Email:</label><label class="redmand">*</label>
							<input type="text" name="missingEmail" id="missingEmail" />
						</p>
					    
						<p> <!-- Year of birth Select.  -->
                            <label for="missingYearbirth">Year of birth:</label><label class="redmand">*</label>
						    <select name="missingYearbirth" id="missingYearbirth" >
						      	<option selected="selected"></option>
                            </select>
                             
					    </p>
					    
					    <p> <!-- Gender Select. Pre-select the gender if the data is available from the social network -->
					    	<label for="missingGender">Gender:</label>
						    <select name="missingGender" id="missingGender" >
						    	<option selected="selected" ></option>
						      	<option value="f" id="f" >Female</option>
						      	<option value="m" id="m" >Male</option>
                            </select>
					    </p>

                        <p style="padding-top: 5px;"></p>
						<div id="provideEmail" name="provideEmail" class="cssSpriteSubmit"></div>
					</form>
					<br/><br/>
					<div id="provideEmailMessage" class="error">&nbsp;</div>
				</div>	
			</div>
			<div id="footer">
				<div class="linkback"><a href=# onclick="closeDialog('#provideEmailDialog','emailForm','#provideEmailMessage'); showDialog('#registerDialog')">Back to registration page</a></div>
				
			</div>	
		</div> 
