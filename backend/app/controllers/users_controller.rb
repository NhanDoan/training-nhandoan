class UsersController < ApplicationController
  before_action :set_user, only: [:show, :edit, :update, :destroy]

  @result = nil

  # GET /users
  # GET /users.json
  def index
    @users = User.all
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
    @user = User.new(user_params)

    respond_to do |format|
      @result = nil

      if @user.save
        # format.html { redirect_to @user, notice: 'User was successfully created.' }
        # format.json { render :show, status: :created, location: @user }
        @result = {
          ok: '0',
          user: @user
        }

        # format.json { render json: result }
      else
        # format.html { render :new }
        # format.json { render json: @user.errors, status: :unprocessable_entity }
        @result = {
          ok: '1',
          message: @user.errors + '-' + :unprocessable_entity
        }
        # format.json { ok: '1', message: @user.errors + '-' + :unprocessable_entity }
      end

      format.json { render json: @result }
    end
  end

  # PATCH/PUT /users/1
  # PATCH/PUT /users/1.json
  def update
    @user = current_user
    respond_to do |format|
      if @user.update(user_params)
        # format.html { redirect_to @user, notice: 'User was successfully updated.' }
        # format.json { render :show, status: :ok, location: @user }
        @result = { ok: '0', user: @user }
        # format.json { ok: '0', user: @user }
      else
        # format.html { render :edit }
        # format.json { render json: @user.errors, status: :unprocessable_entity }
        @result = { ok: '1', message: @user.errors + '-' + :unprocessable_entity }
        # format.json { ok: '1', message: @user.errors + '-' + :unprocessable_entity }
      end

      format.json { render json: @result }
    end
  end

  # DELETE /users/1
  # DELETE /users/1.json
  def destroy
    @user.destroy
    respond_to do |format|
      # format.html { redirect_to users_url, notice: 'User was successfully destroyed.' }
      # format.json { head :no_content }
      @result = { ok: '0', message: 'User was successfully destroyed.' }
      # format.json { ok: '0', message: 'User was successfully destroyed.' }
      format.json { render json: @result }
    end
  end

  private
    # Use callbacks to share common setup or constraints between actions.
    def set_user
      # @user = User.find(params[:id])
      @user = current_user
    end

    # Never trust parameters from the scary internet, only allow the white list through.
    def user_params
      # params.require(:user).permit(:email, :password, :first_name, :last_name, :user_type)
      params.require(:user).permit(:email, :password, :password_confirmation)
    end
end
