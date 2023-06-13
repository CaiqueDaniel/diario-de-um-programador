FROM bitnami/laravel:10
COPY ./ /app
WORKDIR /app

EXPOSE 8000
