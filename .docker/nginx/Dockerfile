FROM ubuntu:latest
RUN apt-get update && apt-get install -y nginx nano

COPY nginx.conf /etc/nginx/nginx.conf

ADD sites-enabled /etc/nginx/sites-enabled

RUN rm /etc/nginx/sites-enabled/default

WORKDIR /var/www/html/

EXPOSE 80
EXPOSE 443

CMD ["nginx"]
