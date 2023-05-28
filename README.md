# restapi-authentication-sanctum
Sanctum authentication is light weight authentication system in laravel
## installation
- git clone git@github.com:ganesh-421/restapi-authentication-sanctum.git or manually download zip file
```
git clone git@github.com:ganesh-421/restapi-authentication-sanctum.git
```
- change directory to restapi-authentication-sanctum
``` cd restapi-authentication-sanctum ```
- perform composer update 
``` composer update ```
- create .env file, copy everything from .env.example file 
- update .env file , configure your database
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=restapi
DB_USERNAME=yourDbUsername
DB_PASSWORD=yourDbPassword
```
- migrate database
``` php artisan migrate ```
- run server
```php artisan serve ```
- test api using postman
