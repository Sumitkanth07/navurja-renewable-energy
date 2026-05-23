# Navurja Renewable Energy Solutions

Premium Laravel 12 renewable energy website and custom CMS.

## Features

- Dynamic homepage, navigation, branding, footer, projects, redirects, and blog
- Custom admin panel at `/admin/login`
- TinyMCE GPL editor loaded once from jsDelivr
- Relative upload paths stored in `storage/app/public/uploads`
- Energy savings calculator
- SEO routes for `/sitemap.xml` and `/robots.txt`
- MySQL-ready for localhost, phpMyAdmin, Hostinger, and shared hosting

## Local Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
php artisan serve
```

Admin login:

- Email: `admin@navurja.test`
- Password: `password`

## Database

Use MySQL database `navurja`.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=navurja
DB_USERNAME=root
DB_PASSWORD=
```

## GitHub

```bash
git init
git add .
git commit -m "Initial Navurja project"
git branch -M main
git remote add origin YOUR_REPO
git push -u origin main
```
