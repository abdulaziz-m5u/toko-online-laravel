# Laravel 10 - Toko Online

## Screenshots

![preview img](/preview.png)

## Donwload

Clone Projek

```bash
  git clone https://github.com/abdulaziz-m5u/toko-online-laravel.git nama_projek
```

Masuk ke folder dengan perintah

```bash
  cd nama_projek
```

-   Copy .env.example menjadi .env kemudia edit database dan api key nya

```bash
    composer install
```

```bash
    php artisan key:generate
```

```bash
    php artisan artisan migrate:fresh --seed
```

```bash
    php artisan storage:link
```

#### Login

-   email = admin@admin.com
-   password = 123
