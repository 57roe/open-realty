FROM registry.gitlab.com/appsbytherealryanbonham/open-realty-docker:0.0.14

ENV APACHE_DOCUMENT_ROOT=/app/src
ENV COMPOSER_HOME=/tmp/

# Point Apache at the app's src directory
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN chmod -R 777 /tmp

# Stub out sendmail so failed install/admin emails don't hard-block the app
RUN printf '#!/bin/sh\nexit 0\n' > /usr/sbin/sendmail && chmod +x /usr/sbin/sendmail

WORKDIR /app

RUN apt-get update && apt-get install -y git \
    && git clone --depth 1 https://gitlab.com/appsbytherealryanbonham/open-realty.git . \
    && chmod +x composer_install.sh \
    && yarn install \
    && ./composer_install.sh \
    && php composer.phar install --no-dev

# Fix write permissions the installer requires
RUN chmod -R 775 \
    include \
    images/listing_photos \
    images/user_photos \
    images/vtour_photos \
    images/page_upload \
    images/blog_uploads \
    files/listings \
    files/users \
    addons \
    files/browsercap_cache \
    files/download_cache \
    && chown -R www-data:www-data include images files addons

EXPOSE 80