
		<div id="registerDialog" class="contentRegister" >
			
			<div id="inheader">&nbsp;
				 <div class="dialogClose" onclick="closeDialog('#registerDialog','formRegister','#registrationMessage')" ></div>
			</div>
			
			<div id="container">
				<div id="side-a">
					<span id="loginTitle" style="padding-left:15px;">Register with Your Social Identity:</span>
					<div id="loginPluginRegisterDiv">Loading Social Login...</div>
					</br></br>					
					<!-- Gigya's Social Privacy Certification Seal : -->
					<div id="sealUIRegisterDiv" style="padding-left:15px;"></div>
					
				</div>	
				<div id="orseperator"><img src="user_dialogs/images/or.jpg" /></div>	
				<div id="side-b">
					<span id="loginTitle">Create a New Account:</span>
					<form class="formContainer" id="formRegister" name="formRegister" method="post">
						<p>
							<label for="email">Email: </label><label class="redmand">*</label>
							<input type="text" name="email" id="email" value=""/>
						</p>
						<p>
							<label for="firstnameReg" style="float: left">First Name: </label><label class="redmand">*</label>
							<input type="text" name="firstnameReg" id="firstnameReg" value="" style="float:left; clear: both" />
                            <label for="lastnameReg" style="padding-left:88px;">Last Name: </label><label class="redmand">*</label>
							<input type="text" name="lastnameReg" id="lastnameReg" value="" style="float:right;" />
						</p>
						<p>
							<label for="password">Password: </label><label class="redmand">*</label>
							<input type="password" name="password" id="password" value=""/>
							<span class="hint" id="passwordHint">Please provide a password<span class="hint-pointer">&nbsp;</span></span>
						</p>
						<p>
							<label for="repassword">Re-enter Password: </label><label class="redmand">*</label>
							<input type="password" name="repassword" id="repassword" value=""/>
						</p>
						<p>
					        <label for="yearbirth">Year of Birth:</label><label class="redmand">*</label>
						    <select name="yearbirth" id="yearbirth" >
						      	<option selected="selected"></option>
                            </select>
					    </p>
						<p>
					        <label for="gender">Gender:</label>
						    <select name="gender" id="gender" >
						    	<option selected="selected"></option>
						      	<option value="f">Female</option>
						      	<option value="m">Male</option>
                            </select>
					    </p>

					  	<p style="padding-top: 5px;"></p>
						<div id="register" name="register" class="cssSpriteRegister"></div>
						
					</form>
					 <div id="registrationMessage" class="error">&nbsp;</div>	
				</div>
			</div>
			<div id="footer">
				<div class="linkback">Already have an Account? <a href=# onclick="closeDialog('#registerDialog','formRegister','#registrationMessage');showDialog('#loginDialog')">Click here</a></div>
			</div>
		</div> 
	
