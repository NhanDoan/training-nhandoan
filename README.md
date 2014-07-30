# Development Environment setup

## Pre-requirements
    - Ruby installed with Ruby gems (1.9 or later)
    - Git
    - Install Berkshelf 3.1.3
      * Important notes for Windows OS, do not using: Ruby x64, Ruby Development Kit x64


## Step 1: Install VirtualBox
- [VirtualBox](https://www.virtualbox.org/wiki/Downloads)

## Step 2: Install gems
  * Issue the following commands
  <pre>
    $ cd vagrant
    $ bundle install
  </pre>

## Step 3: Install cookbooks
  * Install cookbooks

	  <pre>
	  $ berks install
	  </pre>

## Step 4-1: Local development with Vagrant
### Step 4-1: Backend

  1. There is one boxe in the Vagrant configuration: rails-angular, please issue the following command:
    <pre>
      $ bundle exec vagrant up
  </pre>


  2. Do migrate the db schema
      <pre>
        $ bundle exec vagrant ssh rails-angular
        $ cd /backend
        $ bundle exec rake db:migrate RAILS_ENV=development
      </pre>

  3. Start Rails server
    <pre>
      $ bundle exec rails s
    </pre>

## Design Environment
1. Start design server (http://localhost:9778)
2.     <pre>
      $ cd /home/vagrant/design
      $ npm install
      $ docpad run
  </pre>


## Notes
* IPs of 'host': 192.168.3.2,
* Postgresql Database connections on 'localhost': { host: localhost, username: vagrant encoding: utf8)
* Working folders:
  * /backend for Backend devs
  * /frontend for Frontend devs
  
