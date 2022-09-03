<p align="center"><a href="https://www.orcas.io/" target="_blank"><img src="https://static.wixstatic.com/media/6ef527_29b85ca4ebb94433808fa7b4a9ce7865~mv2.png/v1/fill/w_366,h_146,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/2.png" width="400" alt="Laravel Logo" style="background-color:  white;"></a></p>

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

### run tests

``  ./vendor/bin/phpunit --filter UserTest ``

Postman collection for login and fetch users


- [Postman Collection](https://documenter.getpostman.com/view/14036413/VUxRN5pN).

### For example:

if you want to filter by email use filter[email] as a parameter the same endpoint api/users/index

url:

#### api/users/index?per_page=20&filter[email]&filter[lastName]&filter[firstName]
