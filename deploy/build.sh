#!/usr/bin/env bash

user_id=${1:-$(id -u)}
cd `dirname $0`; docker-compose build --build-arg UID=$user_id php; cd -
