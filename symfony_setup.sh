#!/bin/bash

# -------------------
# Setup script
#
# To install into production environment, run:
#   ./setup.sh
# -------------------

# make sure it's deleteable
chmod -R 777 app/cache app/logs

if [ ! -f "composer.phar" ]; then
    # get latest composer.phar
    curl -s http://getcomposer.org/installer
fi

if [ "$1" == "prod" ]; then
    echo "Prepping for prod:"

    # Install dependencies
    echo "Running composer install..."
    composer.phar install --no-dev --optimize-autoloader

    echo "Clearing cache..."
    app/console cache:clear --env=prod

    echo "Installing assets..."
    app/console assets:install --env=prod
    app/console assetic:dump --env=prod
else
    echo "Refreshing for dev..."
    /usr/bin/php app/console cache:clear
    /usr/bin/php app/console assets:install --symlink
    /usr/bin/php app/console assetic:dump
fi

# make sure everything is writeable
chown -R www-data:www-data *
chmod -R 777 app/cache app/logs