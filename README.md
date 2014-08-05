# Development Environment setup

## Pre-requirements
    - Ruby installed with Ruby gems (1.9 or later)
    - VirtualBox 4.3.14
    - Vagrant 1.63
    - Git
    - Berkshelf 3.1.4
      * Important notes for Windows OS, do not using: Ruby x64, Ruby Development Kit x64

=======
## Project structure

1. Design (/design)
Contains html/css design of project

2. Frontend (/frontend)
Contains frontend implemetation (javascript ..) of project

3. Backend (/backend)
Rail application

4. Vagrant (/vagrant)
Contains scripts & config file for [vagrant](http://www.vagrantup.com/)


## Step 1: Install softs
  * Issue the following commands
  <pre>
    $ cd vagrant
    $ bundle install
    $ berks install
  </pre>


## Step 2: vagrant up, ssh
  * Issue the following commands
  <pre>
    $ cd vagrant
    For backend, frontend
    $ bundle exec vagrant up
    For specify box: **railsangular-dev**, **railsangular-db boxes**
    $ bundle exec vagrant ssh railsangular-dev
  </pre>


## Start Backend

  1. There is one boxe in the Vagrant configuration: rails-angular, please issue the following command:
    <pre>
      $ cd /home/vagrant/backend
      $ bundle install
  </pre>


  2. Do migrate the db schema
      <pre>
        $ bundle exec rake db:create db:migrate RAILS_ENV=development
      </pre>

  3. Start Rails server
    <pre>
      $ bundle exec rails s
    </pre>

## Start Frontend
1. Start frontend server (http://localhost:9001)
2.     <pre>
      $ cd /home/vagrant/fronent
      $ npm install
      $ bower install
      $ grunt serve [build,..]
  </pre>

## Start Design
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

=======
