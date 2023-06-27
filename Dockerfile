FROM bitnami/laravel:10
COPY ./app /app
COPY ./bootstrap /app
COPY ./config /app
COPY ./database /app
COPY ./public /app
COPY ./resources /app
COPY ./resources /app
COPY ./storage /app
COPY ./tests /app
COPY ./.env /app
COPY ./composer.json /app
COPY ./phpunit.xml /app

WORKDIR /app

ENV DB_HOST=mariadb
ENV DB_PORT=3306
ENV DB_USERNAME=bn_myapp
ENV DB_DATABASE=bitnami_myapp
ENV DB_PASSWORD=""

EXPOSE 8000
