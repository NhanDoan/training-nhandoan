class UserSerializer < ActiveModel::Serializer
  attributes :id, :email, :password, :first_name, :last_name, :user_type
end
