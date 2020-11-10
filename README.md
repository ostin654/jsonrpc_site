# Requirements

- PHP 7.4
- Start data service for json-rpc

# Install

- `composer install`
- `cp .env.dist .env`
- Edit .env and configure endpoint connection

# How to use

- `symfony serve --no-tls --port=8000`
- Go to http://127.0.0.1:8000/comments
- Generate unique UUID and paste it into page URL
- Leave comments
