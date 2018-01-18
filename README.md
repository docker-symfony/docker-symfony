# docker-symfony
[![Build Status](https://travis-ci.org/docker-symfony/docker-symfony.svg?branch=master)](https://travis-ci.org/docker-symfony/docker-symfony)
[![codecov](https://codecov.io/gh/docker-symfony/docker-symfony/branch/master/graph/badge.svg)](https://codecov.io/gh/docker-symfony/docker-symfony)

# What does this project do?
    `tbc`
    
# Contribution
## Linux
0. You need [Docker](https://www.docker.com/community-edition#/download) and [docker-compose](https://docs.docker.com/compose/install/)
1. Fork the project and clone the repository to your development machine.
2. You get the following bash scripts (contributions for other scripting commands are welcome)
    * [deploy/build.sh](deploy/build.sh) build the project images (Nginx and PHP)
    * [deploy/up.sh](deploy/up.sh) run the containers
    * [deploy/exec.sh](deploy/exec.sh) execute a command in the PHP container
3. `./deploy/exec.sh composer install`
4. By default, the application is at http://localhost/

## Windows
0. You need [Docker for Windows](https://docs.docker.com/docker-for-windows/install/#download-docker-for-windows) (docker-compose is included)
1. Fork the project and clone the repository to your development machine.
2. You get the following batch scripts:
    * [deploy/build.bat](deploy/build.bat) build the project images (Nginx and PHP)
    * [deploy/up.bat](deploy/up.bat) run the containers
    * [deploy/exec.bat](deploy/exec.bat) execute bash command in the PHP container
3. `./deploy/exec.bat`
4. `composer install`
5. By default, the application is at http://localhost/
