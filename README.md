## Framework

### Getting Started

#### What command to run / install
- <code>mkdir -p storage/framework/{sessions,views,cache}</code>
- <code>mkdir -p storage/framework/cache/data</code>
- <code>mkdir -p bootstrap/cache</code>
- copy <code>.env.example content</code> then create .env
- <code>composer install</code>
- <code>php artisan cache:clear</code>
- <code>php artisan key:generate --ansi</code>
- <code>php artisan migrate:fresh --seed</code>
- <code>npm install</code>
- <code>npm run watch</code>
- <code>php artisan serve</code>

### NOTE
- <code>php artisan vendor:publish --tag=laravel-pagination </code> (for pagination)
- <code>php artisan storage:link</code> (for file upload)


### Running into Errors
- if you found error in npm install
- try removing node_modules and package-lock.json file
- then run npm install


### PACKAGES FOR SECURITY
- PURIFIER Input Sanitizer (https://github.com/mewebstudio/Purifier)
- LARAVEL FEATURE POLICY (https://github.com/mazedlx/laravel-feature-policy)
- LARAVEL MITNICK (https://github.com/getspooky/Laravel-Mitnick)
- LARAVEL CSP (https://github.com/spatie/laravel-csp)


### REMAKE USER LEVEL
- https://dev.to/craigmichaelmartin/decoupling-user-profiles-from-user-roles-in-activity-based-permission-systems-1lm
