#!/usr/bin/env bash

PHP_SERVICE=bankcat_php

if [[ $OSTYPE == 'msys'* ]]; then
    winpty docker exec -it $PHP_SERVICE bash
else
    docker exec -it $PHP_SERVICE bash
fi
