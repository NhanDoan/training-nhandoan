Rails.application.routes.draw do

  resources :session

  # APIS
  namespace :api, defaults: { format: :json } do
    namespace :v1 do
      resources :posts
      resources :users
      post '/sign_up' => 'users#create'
      get '/login' => 'sessions#new', :as => "login"
      get '/logout' => 'sessions#destroy', :as => "logout"
    end
  end

  root :to => 'wellcome#index'
end
