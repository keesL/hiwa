FROM nginx

COPY etc/hiwa.conf /etc/nginx/conf.d/default.conf
COPY static/style.css /var/www/hiwa/
COPY static/hiwa.png /var/www/hiwa/uploads/

RUN chown www-data:www-data /var/www/hiwa/uploads
RUN chmod ug+rwx /var/www/hiwa/uploads
