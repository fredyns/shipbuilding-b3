git reset --hard HEAD
git pull

# shell
chmod -R 775 *.sh
#chmod -R 775 cron

# app migrations

composer update
npm update
npm run build

# app codes

php artisan livewire:publish --assets
php artisan optimize:clear
php artisan queue:restart

# reset DB
php artisan migrate
