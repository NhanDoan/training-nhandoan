class Api::PostsController < ApplicationController
	respond_to :json
  def index
    @posts = Post.all
    render :json => @posts, root: false
  end
end
