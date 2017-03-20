# Dockerfile for simple PHP frontend

FROM alpine:3.4

# Do a system update
RUN apk update

# Install PHP and the non-BusyBox wget
RUN apk --update add php5 wget

# Composer needs all of 'php5-openssl php5-json php5-phar'
RUN apk --update add openssl php5-openssl php5-json php5-phar php5-curl

# Refresh the SSL certs, which seem to be missing
# (Uncomment this if the app needs to contact the API over HTTPS)
#RUN wget -O /etc/ssl/cert.pem https://curl.haxx.se/ca/cacert.pem

# Install Composer
# See https://getcomposer.org/doc/faqs/how-to-install-composer-programmatically.md
COPY install/composer.sh /tmp/composer.sh
RUN chmod u+x /tmp/composer.sh

# Install Composer
RUN cd /tmp && sh /tmp/composer.sh

# Install dependencies first
COPY composer.json /var/www/
COPY composer.lock /var/www/

# Install deps using Composer (ignore dev deps)
RUN cd /var/www && php /tmp/composer.phar install --no-dev

# Install main body of source code after other installations, since this will change more often
COPY src /var/www/src
COPY public /var/www/public

# The port is:
#
# 8084 - app
EXPOSE 8084

# We need a shell command to interpret the env var
COPY container-start.sh /tmp/

ENTRYPOINT ["/tmp/container-start.sh"]
