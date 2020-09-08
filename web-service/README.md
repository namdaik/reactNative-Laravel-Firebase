```bash
# Install php library
composer install

# Install node library
npm install

# Create .env file
copy .env.example .env 
or
cp .env.example .env

# Generate key for this app
php artisan key:generate

# Insert the data original of 64 province in vietnam into database
php artisan import:data_original

# Create database 
php artisan migrate

# Seeding
php artisan db:seed

# Run laravel port default localhost:8000
php artisan serve

# Run webpack for build js project
npm run dev (for build) 
or
npm run  watch (for auto rebuild)
```
