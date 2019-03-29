# Frontend
This project was generated with [Angular CLI](https://github.com/angular/angular-cli) version 7.3.7.

## Requirement
PHP7
composer

## Demo
Run `composer install --dev` in this folder.
Run `php -S localhost:8080 -t public`. Navigate to `http://localhost:4200/`. The app will automatically reload if you change any of the source files.

## JWT Token
A `GET` token param is needed to access api routes
The token can be retrieved from by:
POST `http://localhost:8080/auth/login`
{"email":"admin@daas.com", "password", "12345"}

![alt text](https://raw.githubusercontent.com/ShadOoW/daas/master/backend/public/login.png)

## Tests
Run `composer test` to execute backend tests
