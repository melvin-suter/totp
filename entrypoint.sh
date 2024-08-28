#!/bin/bash

# Check PW
if [[ ! -t /var/www/html/data/key.txt ]] && [[ -z "${APP_PW}" ]] ; then
    echo "App password not provided"
    echo "Please set APP_PW at least for the initial setup"
fi

# Create key
if [[ ! -t /var/www/html/data/key.txt ]] ; then
    php /var/www/html/bin/set-key.php "${APP_PW}"
fi

# Generate session key
export APP_SESSION_KEY="$(date | sha256sum  | awk '{print $1}')"

# Exec Command
exec "$@"

