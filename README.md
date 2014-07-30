<<<<<<< HEAD
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


## Getting Started

1. [Install VirtualBox](https://www.virtualbox.org/wiki/Downloads) version 4.3.14

2. [Install Vagrant](http://www.vagrantup.com/downloads.html) Latest (tested with 1.6.3)

3. Clone the project and do `vagrant up`

  ```
  cd vagrant
  vagrant up local --provision
  ```

4. SSH to the vagrant box

  ```
  vagrant ssh
  ```

## Design application

1. Install & Run the `design` application

  ```
  cd /design
  sudo npm install -d
  docpad run
  ```

2. [Open http://0.0.0.0:8003/](http://0.0.0.0:8003/)


## Frontend application

1. Install & Run the `frontend` application

  ```

  ```

2. [Open http://0.0.0.0:9000/](http://0.0.0.0:9000/)


## Backend application (rail)
>>>>>>> 91f3928486335b7f74fc601a4741ece920fce5b2
