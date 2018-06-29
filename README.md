# lunch
Over-Engineered Unbiased Lunch Selector

1. Create the tables
2. Copy config-sample.ini to config.ini and update accordingly
3. Setup crontab entry

* * * * * /usr/bin/php /var/www/##website_root##/lunch/scripts/pick-potential-winner.php >> /var/www/##website_root##/lunch/scripts/error.log 2>&1


