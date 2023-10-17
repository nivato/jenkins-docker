FROM alpine:3.17

RUN apk update && \
    apk add apache2 apache2-utils php81 php81-apache2 && \
    rm -rf /var/www/localhost/htdocs/index.html

COPY src/index.php /var/www/localhost/htdocs/

EXPOSE 80

CMD ["/usr/sbin/httpd", "-D", "FOREGROUND"]
