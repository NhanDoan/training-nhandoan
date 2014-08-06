class UsersController < ApplicationController
  before_action :authenticate, only: [:edit, :update]
  before_action :set_user, only: [:show, :edit, :update, :destroy]
  # skip_before_filter :verify_authenticity_token, :only => [:index, :show]
  skip_before_action :verify_authenticity_token

  # GET /users
  # GET /users.json
  def index
    @users = User.all
    render json: @users
  end

  # GET /users/1
  # GET /users/1.json
  def show
  end

  # GET /users/new
  def new
    @user = User.new
  end

  # GET /users/1/edit
  def edit
    @user = current_user
  end

  # POST /users
  # POST /users.json
  def create
    custom_params = user_params

    @user = User.find_by_email(custom_params[:email])

    if @user
      @result = {
        ok: 1,
        message: "An user already exists with this email address."
      }
    else
      @user = User.new(custom_params)

      if @user.save
        @result = {
          ok: 0,
          message: "Signed up successfully."
        }
      else
        @result = {
          ok: 1,
          message: @user.errors
        }
      end
    end

    render json: @result
  end

  # PATCH/PUT /users/1
  # PATCH/PUT /users/1.json
  def update
    @user = current_user
    
    if @user.update(user_params)
      @result = { ok: 0, user: @user }
    else
      @result = {
        ok: 1,
        # message: @user.errors + '-' + :unprocessable_entity
        message: @user.errors
      }
    end

    render json: @result
  end

  # DELETE /users/1
  # DELETE /users/1.json
  def destroy
    @user.destroy
    @result = { ok: 0, message: 'User was successfully destroyed.' }

    render json: @result
  end

  private
    # Use callbacks to share common setup or constraints between actions.
    def set_user
      @user = current_user
    end

    # Never trust parameters from the scary internet, only allow the white list through.
    def user_params
      params.require(:user).permit(:email, :password, :first_name, :last_name, :user_type)
    end
end
