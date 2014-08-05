require 'rails_helper'

RSpec.describe "users/show", :type => :view do
  before(:each) do
    @user = assign(:user, User.create!(
      :email => "Email",
      :password => "Password",
      :first_name => "First Name",
      :last_name => "Last Name",
      :user_type => "User Type"
    ))
  end

  it "renders attributes in <p>" do
    render
    expect(rendered).to match(/Email/)
    expect(rendered).to match(/Password/)
    expect(rendered).to match(/First Name/)
    expect(rendered).to match(/Last Name/)
    expect(rendered).to match(/User Type/)
  end
end
