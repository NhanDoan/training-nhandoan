Rails.application.routes.draw do
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
  get '/login' => 'sessions#new', :as => "login"
  get '/logout' => 'sessions#destroy', :as => "logout"
end
