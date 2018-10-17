FROM wordpress:php7.2-apache

# Copy wp-config.php to root directory
COPY ./wp-config.php /usr/src/wordpress/wp-config.php

# Copy the contents of src/ to plugins directory
COPY ./src/ /usr/src/wordpress/wp-content/plugins/speedmaster/

# Copy test themes
COPY ./tests/speedmaster-test-theme/ /usr/src/wordpress/wp-content/themes/speedmaster-test/

# Install Wordpress CLI
WORKDIR /tmp
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
RUN chmod +x wp-cli.phar
RUN mv wp-cli.phar /usr/bin/wp

WORKDIR /var/www/html