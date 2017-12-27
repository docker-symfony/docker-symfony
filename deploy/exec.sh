#!/usr/bin/env bash

docker-compose -f deploy/docker-compose.yml exec php $@
