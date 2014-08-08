class SessionsController < ApplicationController

	def create
		user = User.authenticate(params[:email], params[:password])

		if user
			session[:user_id] = user.id
			attributes = user.attributes

			reject = attributes.reject { |k,v| k === "hashed_password" }

			@result = { user: reject, message: "Logged in successfully" }
		else
			@result = { user: nil, message: "Invalid login/password combination" }
		end

		render json: @result
	end

	def destroy
		reset_session
		# redirect_to root_path, :notice => "You successfully logged out"
		@result = { ok: 0, message: "You successfully logged out" }

		render json: @result
	end
end
