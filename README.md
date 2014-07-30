# Development Environment setup

## Pre-requirements
    - Ruby installed with Ruby gems (1.9 or later)
    - Git
    - Install Berkshelf 3.1.3
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

<br/>

## Getting Started

1. [Install VirtualBox](https://www.virtualbox.org/wiki/Downloads) version 4.3.14

2. [Install Vagrant](http://www.vagrantup.com/downloads.html) Latest (tested with 1.6.3)

3. [Install Berkshelf](http://berkshelf.com/) Latest (tested with 3.1.3)

3. Clone the project and do `vagrant up`

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
    $ bundle exec vagrant up
    $ bundle exec vagrant ssh rails-angular
  </pre>


## Start Backend

  1. There is one boxe in the Vagrant configuration: rails-angular, please issue the following command:
    <pre>
      $ cd /home/vagrant/backend
  </pre>


  2. Do migrate the db schema
      <pre>
        $ bundle exec rake db:migrate RAILS_ENV=development
      </pre>

  3. Start Rails server
    <pre>
      $ bundle exec rails s
    </pre>

## Start Frontend
1. Start frontend server (http://localhost:9000)
2.     <pre>
      $ cd /home/vagrant/fronent
      $ npm install
      $ bower install
      $ gulp [compile, watch]
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
