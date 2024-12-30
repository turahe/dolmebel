A Dolmebel designed to maintain a .

### Installation
- Copy `.env.example` into `.env`
- Edit the superadmin name, email and password in `.env`.
- Run `composer install`.
- Run `php artisan key:generate`.
- Create a file named `database.sqlite` in the database directory or define a connection to your database.
- Run `php artisan migrate`.
- Run `php artisan db:seed`.
- Run `php artisan db:seed --class=WorldSeeder`
- Run `npm install` followed by `npm run build`.

### Technical requirement
- php 8.2 or greater.
- redis cache store (optional).

### Technical description
- Laravel 11.
- Livewire 3 and alpine.js.
- Tailwind css.
- Role and user permissions.
- Caching with Redis when env `CACHE_ENABLED` is set to true and `CACHE_DRIVER` is set to redis.
- Static analysis with phpstan.

### Demo
<a href="https://admin.recoo.app" target="_blank">RecDB demo website</a>
