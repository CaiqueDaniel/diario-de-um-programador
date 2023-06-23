FROM bitnami/laravel:10
COPY ./ /app
WORKDIR /app

ENV DB_HOST=mariadb
ENV DB_PORT=3306
ENV DB_USERNAME=bn_myapp
ENV DB_DATABASE=bitnami_myapp
ENV DB_PASSWORD=""

EXPOSE 8000
