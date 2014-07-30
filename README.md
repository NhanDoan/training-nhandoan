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
