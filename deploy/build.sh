#!/usr/bin/env bash

cd `dirname $0`; docker-compose build --build-arg UID=$(id -u) php; cd -
