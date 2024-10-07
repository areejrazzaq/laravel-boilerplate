# Set up boiler plate
1. Run command "composer install"
2. Create .env file and update DB host.
3. Generate application key "php artisan key:generate"
4. Generate passport keys "php artisan passport:install"
5. Add the generated PASSPORT_PRIVATE_KEY and PASSPORT_PUBLIC_KEY (under storage folder ) in .env file
6. Run command "php artisan migrate"
7. Modify RoleSeeder class as per needs
8. Run "php artisan db:seed RoleSeeder"

## New Application
1. Update .env file (DB)
2. run command "php artisan migrate"
3. composer require laravel/passport // enable extension=sodium in php.ini
4. php artisan migrate
5. php artisan passport:install ( follow: [guide](https://laravel.com/docs/10.x/passport))
   1. add has api tokens in user folder
6. php artisan passport:keys 
   1. Add keys to .env file
7. install spatie package for role management ( follow [guide](https://spatie.be/docs/laravel-permission/v6/installation-laravel))

8. modify role seeder as per app needs 
9. run command: php artisan db:seed RoleSeeder