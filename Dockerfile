FROM wordpress:php7.2-apache

# Copy wp-config.php to root directory
COPY ./wp-config.php /usr/src/wordpress/wp-config.php

# Copy the contents of src/ to plugins directory
COPY ./src/ /usr/src/wordpress/wp-content/plugins/speedmaster/
