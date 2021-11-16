#!/bin/sh

usermod -u $(stat -c '%u' .) www-data
groupmod -g $(stat -c '%g' .) www-data

exec "$@"
