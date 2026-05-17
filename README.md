<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# SITAMPAN Helpdesk

Aplikasi helpdesk/pengaduan berbasis Laravel (PHP 8.2+) dengan Tailwind + Vite. Admin dapat membalas aduan mahasiswa secara manual atau menggunakan AI (OpenRouter).

## Prasyarat

- PHP 8.2+
- Composer
- Node.js + npm
- Database MySQL (atau sesuaikan konfigurasi `DB_*`)
- (Opsional) API key OpenRouter untuk fitur balasan AI

## Setup (pertama kali)

1) Install dependency PHP:

```bash
composer install
```

2) Buat file environment:

```bash
copy .env.example .env
```

3) Atur koneksi database di `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=root
DB_PASSWORD=
```

4) Generate APP_KEY:

```bash
php artisan key:generate
```

5) Jalankan migrasi:

```bash
php artisan migrate
```

6) Install dependency front-end:

```bash
npm install
```

7) Buat memakai file upload/asset dari storage:

```bash
php artisan storage:link
```

### Setup cepat (opsional)

Project ini menyediakan script:

```bash
composer run setup
```

Catatan: script ini akan menyalin `.env` jika belum ada, generate key, menjalankan migrasi, lalu `npm install` dan `npm run build`. Pastikan `DB_*` di `.env` sudah benar sebelum menjalankan.

## Menjalankan project (development)

Cara termudah:

```bash
composer run dev
```

Script di atas akan menjalankan:

- `php artisan serve` (Laravel server)
- `php artisan queue:listen` (queue listener)
- `npm run dev` (Vite)

Default URL: `http://127.0.0.1:8000`

Jika ingin manual (tanpa script):

Terminal 1:

```bash
php artisan serve
```

Terminal 2:

```bash
npm run dev
```

## Konfigurasi AI (OpenRouter)

Fitur balasan AI memakai OpenRouter. Isi variabel berikut di `.env`:

```dotenv
OPENROUTER_BASE_URL=https://openrouter.ai/api/v1
OPENROUTER_API_KEY=isi_api_key_anda
OPENROUTER_MODEL=deepseek/deepseek-v4-flash:free
OPENROUTER_VERIFY_TLS=true
OPENROUTER_TIMEOUT=90
OPENROUTER_CONNECT_TIMEOUT=15
OPENROUTER_RETRIES=1
```

## Menjalankan test

```bash
php artisan test
```

Atau via script:

```bash
composer run test
```
