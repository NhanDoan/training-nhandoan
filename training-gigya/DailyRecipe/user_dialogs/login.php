
		<div id="loginDialog" class="contentRegister" ">
	
			<div id="inheader">&nbsp; 
				 <div class="dialogClose" onclick="closeDialog('#loginDialog','formLogin','#loginMessage')" ></div>
			</div>
			
			<div id="container">
				<div id="side-a">
					<span id="loginTitle" style="padding-left:15px;">Login with Your Social Identity:</span>	
					<div id="loginPluginDiv">Loading Social Login...</div>
					</br></br>					
					<!-- Gigya's Social Privacy Certification Seal : -->
					<div id="sealUI" style="padding-left:15px;"></div>
				</div>	
				<div id="orseperator"><img src="user_dialogs/images/or.jpg" /></div>	
				<div id="side-b">
					<span id="loginTitle">Login Here:</span>
					<form class="formContainer" id="formLogin" name="formLogin" method="post">
						<p>
							<label for="email">Email: </label>
							<input type="text" name="loginEmail" id="loginEmail" value=""/>
						</p>
						<p>
							<label for="password">Password: </label>
							<input type="password" name="loginPassword" id="loginPassword" value=""/>
						</p>
						<p style="padding-top: 5px;"></p>
						<div id="login" name="login" class="cssSpriteLogin"></div>
					</form>
					 <div id="loginMessage" class="error"></div>
				</div>
			</div>
			<div id="footer">
				<div class="linkback">Don't have an Account yet? <a href=# onclick="closeDialog('#loginDialog','formLogin','#loginMessage'); showDialog('#registerDialog')">Click here</a></div>
			</div>
		
		</div> 

	