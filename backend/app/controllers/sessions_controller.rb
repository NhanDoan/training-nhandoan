class SessionsController < ApplicationController
	def create
		if user = User.authenticate(params[:email], params[:password])
			session[:user_id] = user.id
			# redirect_to root_path, :notice => "Logged in successfully"
			format.json { user: user, message: "Logged in successfully" }
		else
			# flash.now[:alert] = "Invalid login/password combination"
			# render :action => 'new'
			format.json { user: nil, message: "Invalid login/password combination" }
		end
	end

	def destroy
		reset_session
		# redirect_to root_path, :notice => "You successfully logged out"
		format.json { ok: '0', message: "You successfully logged out" }
	end
end
