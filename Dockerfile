FROM php:alpine

RUN apk update
RUN apk add composer nodejs-lts yarn

COPY . /usr/src/app
WORKDIR /usr/src/app

RUN composer install
RUN yarn

CMD php -S 0.0.0.0:8000 public/index.php
EXPOSE 8000
