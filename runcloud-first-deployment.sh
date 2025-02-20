# first install

# shell
chmod -R 775 *.sh
#chmod -R 775 cron

composer update
npm update
npm run build
php artisan key:generate
php artisan storage:link

# app codes

php artisan livewire:publish --assets
php artisan optimize:clear

# reset DB
php artisan migrate
#php artisan migrate:fresh --seed # --force
