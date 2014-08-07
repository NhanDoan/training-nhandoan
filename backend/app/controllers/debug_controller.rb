class DebugController < ApplicationController

  # Get all users "debug/show"
  def show
  	@users = User.all
  end

  # Signin
  def auto_sign_in
    email = params[:email]
    user = User.find_by(:email => email)
    path = params[:path]
    if user

      sign_in(user)
      if path.nil?
        redirect_to after_sign_in_path_for(user)
      else
        redirect_to path
      end
      return
    end
    render json: "Not found the user with email #{email}"
  end

end
