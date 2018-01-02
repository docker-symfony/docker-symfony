#!/usr/bin/env bash

docker-compose -f deploy/docker-compose.yml build --build-arg UID=$(id -u) php
