FROM registry.gitlab.com/appsbytherealryanbonham/open-realty-docker:0.0.11

ENV APACHE_DOCUMENT_ROOT /app/src
ENV COMPOSER_HOME /tmp/

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN sed -i 's/upload_max_filesize \= .M/upload_max_filesize \= 10M/g' $PHP_INI_DIR/php.ini
RUN sed -i 's/post_max_size \= .M/post_max_size \= 10M/g' $PHP_INI_DIR/php.ini
RUN echo 'memory_limit = -1' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini;

RUN touch  /.yarnrc && chmod 777 /.yarnrc
# RUN adduser deploy
RUN chmod -R 777 /tmp


EXPOSE 80
