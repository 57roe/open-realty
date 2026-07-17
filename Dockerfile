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

# Fix write permissions the installer requires (paths are under src/)
RUN chmod -R 775 \
    src/include \
    src/images/listing_photos \
    src/images/user_photos \
    src/images/vtour_photos \
    src/images/page_upload \
    src/images/blog_uploads \
    src/files/listings \
    src/files/users \
    src/addons \
    src/files/browsercap_cache \
    src/files/download_cache \
    && chown -R www-data:www-data src/include src/images src/files src/addons

EXPOSE 80