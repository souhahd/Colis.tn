#!/bin/bash
VENDOR="/var/www/symfony/vendor"
DB_HOST=$1
if ! [  -d "$VENDOR" ]; then
  echo "composer insall ===================================================="
  exec /usr/bin/composer install
fi
until  `php /var/www/symfony/docker/php-fpm/testMysqlConnection.php`
do
  echo "wait for database connexion"
  sleep 3
done
echo "connexion estableshed to database"
php bin/console doctrine:schema:update --force
php bin/console hautelook:fixtures:load -n
exec php-fpm -F
