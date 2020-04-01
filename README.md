# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Contributing

Thank you for considering contributing to Lumen! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Getting Started

If you want to install Lumen from scratch and follow along, follow the instructions here: http://lumen.laravel.com/docs/installation

When you're ready to create a new project, issue the following command `lumen new lumen-api`

If you're using Homestead, this should be no different for you than a Laravel app.

If you're developing locally, you should know that the `artisan` command is missing the `serve` command. I recommend that you use PHP's built in web server: `php -S 127.0.0.1:8080 -t public/`

## Generate swagger with the command:
User another terminal to generate or update swagger.json file in /public dir:
```
php artisan swagger:scan
```
url view swagger: `localhost:8080/swagger-ui.html`


## Configure your .env File
Lumen requires several environment variables to function properly. The .env.template file contains the requisite fields without their respective values. To configure Lumen, do the following:

   #cd to your project's root directory
   #copy the .env.template file's contents
   #into a file named .env 
   #the .env file should resemble the following when complete
```   
APP_ENV=local
APP_DEBUG=true
APP_KEY=YOUR_SECRECT_KEY_HERE
DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE= write the name of th database
DB_USERNAME= root
DB_PASSWORD= write the password and keep it blank if not required
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=database
```
