<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About the task

It supports command to fetch the users from two endpoints
`` https://60e1b5fc5a5596001730f1d6.mockapi.io/api/v1/users/users_1 ``
`` https://60e1b5fc5a5596001730f1d6.mockapi.io/api/v1/users/user_2 ``
 
using job to inject chunked users into the database using raw sql statements. Moreover, I used DDD for each domain created in the project.

As well as, writing tests to ensure about the process

### commands to fetch users:

`` sail artisan migrate:fresh ``

`` sail artisan passport:install ``

``  sail artisan InjectUsersIntoDatabase ``

`` sail artisan queue:work ``

Postman collection for login and fetch users


- [Postman Collection](https://documenter.getpostman.com/view/14036413/VUxRN5pN).

### For example:

if you want to filter by email use filter[email] as a parameter the same endpoint api/users/index

url:

#### api/users/index?per_page=20&filter[email]&filter[lastName]&filter[firstName]
