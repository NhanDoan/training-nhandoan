Rails.application.routes.draw do

  # DEBUG mode
 if ENV['DEBUG_ENABLE'] == 'yes'
    get 'debug/show'
    get "debug/auto_sign_in"
  end

  resources :users
  resources :session

  # APIS
  namespace :api, defaults: { format: :json } do
    namespace :v1 do
      resources :posts
    end
  end

  root :to => 'wellcome#index'

  post '/sign_up' => 'users#create', :as => "sign_up"
  get '/login' => 'sessions#create', :as => "login"
  get '/logout' => 'sessions#destroy', :as => "logout"
end
