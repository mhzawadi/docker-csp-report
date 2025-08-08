#!/bin/sh

docker compose -f docker/docker-compose.yml down;
docker image rm mhzawadi/csp-report:dev && \
docker build -t mhzawadi/csp-report:dev -f ./docker/Dockerfile . && \
docker compose -f docker/docker-compose.yml up
