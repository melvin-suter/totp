FROM php:8.3-apache


ENV APP_KEY=myappkey
ENV APP_NAME=TOTP

USER root

# Setup Base
RUN mkdir -p /var/www/

# Add Source
COPY src/ /var/www/html/
RUN mkdir -p /var/www/html/data 

# Change Owner
RUN chown -R www-data:www-data /var/www/html

# Change port to 5000
RUN sed -i "s/80/5000/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Change base to public
RUN sed -i "s;/var/www/html;/var/www/html/public;g" /etc/apache2/sites-available/000-default.conf

# Setup entrypoint
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chown www-data:www-data /usr/local/bin/entrypoint.sh && chmod +x /usr/local/bin/entrypoint.sh

# Setup Sessions
RUN mkdir -p /var/www/html/session && \
    chown www-data:www-data /var/www/html/session
COPY custom.ini /usr/local/etc/php/conf.d/custom.ini

# Docker Stuff
ENV PATH="${PATH}:/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin"
USER www-data
WORKDIR /var/www/html
EXPOSE 5000
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["/usr/local/bin/apache2-foreground"]