# Argumentos da Imagem
## Versão da Imagem Docker PHP
ARG PHP_VERSION=8.2-fpm
FROM php:${PHP_VERSION}

## Diretório da aplicação
ARG APP_DIR=/var/www
## Versão da Lib do Redis para PHP
ARG REDIS_LIB_VERSION=5.3.7

RUN apt-get update
RUN apt-get install -y --no-install-recommends \
    apt-utils
### apt-utils é um extensão de recursos do gerenciador de pacotes APT

RUN apt-get install -y --no-install-recommends supervisor
COPY ./docker/supervisord/supervisord.conf /etc/supervisor
COPY ./docker/supervisord/conf /etc/supervisord.d/
### Supervisor permite monitorar e controlar vários processos (LINUX)
### Bastante utilizado para manter processos em Daemon, ou seja, executando em segundo plano

# dependências recomendadas de desenvolvido para ambiente linux
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip \
    libpng-dev \
    libpq-dev \
    libxml2-dev \
    libicu-dev

RUN docker-php-ext-install mysqli pdo pdo_mysql pdo_pgsql pgsql session xml intl bcmath

# habilita instalação do Redis
RUN pecl install redis-${REDIS_LIB_VERSION} \
    && docker-php-ext-enable redis

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


RUN docker-php-ext-install zip iconv simplexml pcntl gd fileinfo

#COPY php.ini-production /usr/local/etc/php/php.ini
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

# Definir o diretório de trabalho
WORKDIR /var/www

RUN cd /var/www
# Copiar os arquivos da aplicação para o diretório de trabalho
COPY . .

# Ajustar permissões
RUN cd /var/www && chmod -R 755 *
RUN cd /var/www && chown -R www-data:www-data *

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

RUN apt install nginx -y

# carragar configuração padrão do NGINX
COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
# se for necessário criar os sites disponíveis já na confecção da imagem, então descomente a linha abaixo
COPY ./docker/nginx/sites /etc/nginx/sites-available

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

EXPOSE 9001

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
