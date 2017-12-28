# docker-symfony
[![Build Status](https://travis-ci.org/docker-symfony/docker-symfony.svg?branch=master)](https://travis-ci.org/docker-symfony/docker-symfony)

# Contribution
0. You need [Docker](https://www.docker.com/community-edition#/download) and [docker-compose](https://docs.docker.com/compose/install/)
1. Fork the project and clone the repository to your development machine.
2. You get the following bash scripts (contributions for other scripting commands are welcome)
    * [deploy/build.sh](deploy/build.sh) build the project images (Nginx and PHP)
    * [deploy/up.sh](deploy/up.sh) run the containers
    * [deploy/exec.sh](deploy/exec.sh) execute a command in the PHP container
3. `./deploy/exec.sh composer install`
4. By default, the application is at http://localhost/
