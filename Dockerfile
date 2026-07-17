FROM registry.gitlab.com/appsbytherealryanbonham/open-realty-docker:0.0.14

ENV APACHE_DOCUMENT_ROOT=/app/src
ENV COMPOSER_HOME=/tmp/

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN chmod -R 777 /tmp

WORKDIR /app

RUN apt-get update && apt-get install -y git \
    && git clone --depth 1 https://gitlab.com/appsbytherealryanbonham/open-realty.git . \
    && chmod +x composer_install.sh \
    && yarn install \
    && ./composer_install.sh \
    && php composer.phar install --no-dev

EXPOSE 80