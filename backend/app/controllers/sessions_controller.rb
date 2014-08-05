class SessionsController < ApplicationController

	def create
		if user = User.authenticate(params[:email], params[:password])
			session[:user_id] = user.id
			# redirect_to root_path, :notice => "Logged in successfully"
			@result = { user: user, message: "Logged in successfully" }
		else
			@result = { user: nil, message: "Invalid login/password combination" }
		end

		render json: @result
	end

	def destroy
		reset_session
		# redirect_to root_path, :notice => "You successfully logged out"
		@result = { ok: '0', message: "You successfully logged out" }
		
		render json: @result
	end
end
