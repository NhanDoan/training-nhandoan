class Api::V1::PostsController < ApplicationController
	respond_to :json
  def index
    @posts = Post.all
    render :json => @posts, root: false
  end
end
