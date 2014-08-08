class UserSerializer < ActiveModel::Serializer
  attributes :id, :email, :hashed_password, :first_name, :last_name, :user_type, :password
end
