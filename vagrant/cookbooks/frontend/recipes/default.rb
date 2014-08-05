#
# Cookbook Name:: frontend
# Recipe:: default
#
# Copyright 2014, Asnet
#
# All rights reserved - Do Not Redistribute
#

include_recipe 'nodejs'
include_recipe 'npm'

npm_package 'grunt-cli' do
  action :install
end

npm_package 'bower' do
  action :install
end

# npm_package 'docpad' do
#   version '6.69'
#   action :install
# end

npm_package 'gulp' do
  version '3.8.6'
  action :install
end
