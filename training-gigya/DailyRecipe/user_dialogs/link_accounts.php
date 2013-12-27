<?php 
	$userAvatar = "user_dialogs/images/avatar_100px.jpg";
?>


		<div id="linkAccountDialog" class="contentRegister" style="height:500px;" >	
			<div class="dialogClose" onclick="closeDialog('#linkAccountDialog','linkForm','#linkAccountMessage')" ></div>
			<div id="inheaderlinkAccount">				
				<div class="userImage" >
					<img id="linkUserImage" src="<?php echo $userAvatar;?>" style="width:40px;" />
				</div>
				<div id="userMainDetails">
					Welcome <span id="linkWelcomeUserFirstName"></span>
				</div>	
			</div>
			<div id="container">
				<div style="width:360px;">
					<div id="loginTitle" >Already a Member:</div>
					<p  style="width:360px;"><span class="linkNewText">"We found your email in our system</br>Please provide your site password to link to your existing account"</span></p><br/>
					<form id="linkForm" name="linkForm" method="post">
						<p>
							<label for="linkEmail">Email: </label>
							<input type="text" name="linkEmail" id="linkEmail" value=""/>
						</p>
						<p>
							<label for="linkPassword">Password: </label>
							<input type="password" name="linkPassword" id="linkPassword" value=""/>
						</p>
						<p style="padding-top: 5px;"></p>
						<div id="linkAccount" name="linkAccount" class="cssSpriteLink"></div>
					</form>
					<br/><br/><div id="linkAccountMessage" class="error">&nbsp;</div>
				</div>
			</div>	
			<div id="footer">
				<div class="linkback"><a href=# onclick="closeDialog('#linkAccountDialog','linkForm','#linkAccountMessage'); showDialog('#registerDialog')">Back to registration page</a></div>
			</div>	
		</div> 
	