### Instalation in 4 steps
Get source code from Git Repository
```bash
cd /path/to/foldercode
composer i
cp .env.example .env
php artisan key:generate
```
- You have to setup database connection, paste this to your .env file

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dbname
DB_USERNAME=root
DB_PASSWORD=
```
- Run command

```bash
php artisan migrate
php artisan passport:install
php artisan db:seed

```
- You have to setup APP_NAME, paste this to your .env file

```bash
 APP_NAME=Laravel_vue
 MAIL_PREFIX_SUBJECT=[Laravel Vue]
```

### For develop

- Make Controller
```commandline
php artisan make:controller API/PhotoController --api
```
- Make middleware: 
```commandline
php artisan make:middleware CheckPhoto
```
- Make migration:
```commandline
php artisan make:migration create_users_table
    Schema::create('table_name',...)
php artisan make:migration update_orders_table
    Schema::rename($from, $to)
    Schema::table('users', ...)
php artisan migrate

php artisan migrate:fresh --seed
```
- Make Seed
```commandline
php artisan make:seeder UserSeeder
php artisan db:seed
```

- Show query
```command line
use Illuminate\Support\Facades\DB;
DB::enableQueryLog();
...
dd(DB::getQueryLog()); 
```

### Performance
```
php artisan config:cache
php artisan route:cache
php artisan optimize --force
composer dumpautoload -o
```

##### That's all. Enjoy.

### Change log
##### v 1.0.2

## Screenshots

### For Server 2
Requirements:
 - PHP (PHP >= 7.3)
 - Mysql

Pre Run Command:
 1. php artisan cache:clear
 2. php artisan config:clear

Command Process:
handle +/% search bar.
$content = $this->processSearch($value);
$this->query->where(\DB::raw('BINARY name'), 'like' ,"%$content%");
			
public function processSearch($input_search = ""){
        return addcslashes($input_search, '!@#$%^&*()_-+');
    }
    
#### Use infyom make api step
+ make file migration. put info and run command migrate
+ run infyom to make: controller, model, request, repository. modify them
 - controller: list
 - repository: fieldSearchable - compare =, fieldInList - field in api list, fieldFilter - compare like, fieldOrder - allow field order
 - model: fillable - allow field to store
 - request: rule type, unique ...

```
php artisan make:migration create_categories_table --create=lv_categories
php artisan infyom:api Categories --fromTable --tableName=lv_categories --skip=migration
php artisan make:seeder CategoriesSeeder
php artisan make:factory CategoriesFactory --model=Categories
```
