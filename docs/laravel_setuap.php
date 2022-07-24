https://laravel.com/docs/8.x/controllers

sudo chmod 777 -R laravel-backend-frontend

Laravel Project setuap

1. composer create-project laravel/laravel example-app
2. cd example-app
3. php artisan ui bootstrap --auth
4. npm install
5. export NODE_OPTIONS=--openssl-legacy-provider
6. node run dev
7. php artisan serve
8. php artisan migrate
9. composer require doctrine/dbal
10. php artisan migrate:status

npm upgrade package.json : npx npm-check-updates -u
npm install
or
npm install --legacy-peer-deps

npx npm-check-updates -u

cache:clearCommand
php artisan cache:clear
php artisan route:cache
php artisan config:cache

Create Migrate table
php artisan make:migration create_salon_companies_table

Remove migrate
php artisan migrate:rollback

Create Seeder table
php artisan make:seeder RoleSeeder   New seeder FileCreate
php artisan db:seed  databaseseeder file call
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=ModulesTableSeeder
php artisan db:seed --class=PermissionTableSeeder
php artisan db:seed --class=RoleAccessTableSeeder
php artisan db:seed --class=AdminTableSeeder
php artisan db:seed --class=SettingsTableSeeder
php artisan db:seed --class=CountryTableSeeder
php artisan db:seed --class=StateTableSeeder
php artisan db:seed --class=DistrictTableSeeder
php artisan db:seed --class=SubdistrictTableSeeder
php artisan db:seed --class=BlockTableSeeder
php artisan db:seed --class=PanchayatTableSeeder
php artisan db:seed --class=VillageTableSeeder
php artisan db:seed --class=FestivalTableSeeder
php artisan db:seed --class=RelationTableSeeder
php artisan db:seed --class=DepartmentTableSeeder
php artisan db:seed --class=ReligionTableSeeder
php artisan db:seed --class=CategoryTableSeeder
php artisan db:seed --class=TypeofcategoryTableSeeder

DB import in class
use Illuminate\Support\Facades\DB;

cretae import class name
php artisan make:import StateImport --model=State

Creating indexs db in key
primary
unique
index
spatialindex

Any update bs4 to bs5 node js run command
npx mix

Create laravel controller command
php artisan make:controller PhotoController --resource --model=Photo

Create laravel model command
php artisan make:model Flight

Create laravel request command
php artisan make:request StorePostRequest

Create laravel controller component
php artisan make:component Message


//Salon history
php artisan make:migration create_saloon_companies_table --path=/database/migrations/salon_modify
php artisan make:migration create_saloon_services_table --path=/database/migrations/salon_modify
php artisan make:migration create_saloon_staff_services_table --path=/database/migrations/salon_modify

//Product manage
php artisan make:migration create_categories_table --path=/database/migrations/products_modify
php artisan make:migration create_products_table --path=/database/migrations/products_modify

//User Modify
php artisan make:migration create_users_table
php artisan make:migration create_users_table

//Common table
php artisan make:migration create_config_table --path=/database/migrations/common
php artisan make:migration create_email_templates_table --path=/database/migrations/common
php artisan make:migration create_templatefield_table --path=/database/migrations/common



Migrate directory table
php artisan migrate --path=/path/to/your/migration/directory


Cache clear coomand
php artisan cache:clear


Create Middleware
php artisan make:middleware EnsureTokenIsValid

Create Middleware Error pages
php artisan vendor:publish --tag=laravel-errors

1.php artisan make:migration create_users_table
2.php artisan make:migration create_categories_add_column_table --table=categories
3.php artisan make:migration create_categories_remove_column_table --table=categories
4.php artisan make:migration create_categories_add_foreign_key_table --table=categories
5.php artisan make:migration create_categories_remove_foreign_key_table --table=categories



Laravel 8 Multi Authentication – Role Based Login Tutorial
https://onlinewebtutorblog.com/laravel-8-multi-authentication-role-based-login-tutorial/

php artisan grid_view:publish --only=views
php artisan grid_view:publish --only=lang


Any change mix file scss
1. export NODE_OPTIONS=--openssl-legacy-provider
2. node run dev

Live mix changes command npm run watch


npm install anchor-js
npm install is_js
npm install overlayscrollbars


Admin panel generated packages
Install gridview and detail view library

https://github.com/itstructure/laravel-detail-view
https://github.com/itstructure/laravel-grid-view

Multiple form clonData library
https://www.jqueryscript.net/demo/clone-field-increment-id/

Storage folder pass
php artisan storage:link


"Itstructure\\GridView\\": "composer/itstructure/laravel-grid-view/src/"

'name' => 'required',
            'panel' => 'required',



SET  @num := 0;

UPDATE your_table SET id = @num := (@num+1);

ALTER TABLE your_table AUTO_INCREMENT =1;


$2y$10$fiSy6uAKiA4I.r42gmggIOvJ7ebvnHaTDItkeWG8lnch6rEl1uXmO 8894
Server Side databse export to seed file command

php artisan iseed role
php artisan iseed modules
php artisan iseed permission
php artisan iseed role_access
php artisan iseed Admin
php artisan iseed country
php artisan iseed state
php artisan iseed district
php artisan iseed subdistrict
php artisan iseed block
php artisan iseed panchayat
php artisan iseed village
php artisan iseed festival
php artisan iseed relation
php artisan iseed religion
php artisan iseed department
php artisan iseed category
php artisan iseed typeofcategory
php artisan iseed lang


Server file buid in laravel

1.Create .env file
2.php artisan migrate
3.php artisan db:seed  (Data insert in datatable)
2.Api use command - php artisan passport:install


Api Postman Link : https://www.getpostman.com/collections/c8b0aad452459c69db8f
Figma Link 1: https://www.figma.com/file/0wC0gbLEfIOgBSjCrbSIdo/Vande-Mission-App---Maulik?node-id=0%3A1
Figma lInk 2: https://www.figma.com/file/xmtKXtFChTySeBfTp4Yarp/VandeMission-Me?node-id=0%3A1
