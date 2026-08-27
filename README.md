# Rental Outdoor - Katalog & Dashboard Rental Peralatan Gunung

Sistem ini dibangun dengan Laravel 11 + Tailwind (Breeze) + Alpine.js.
Berikut panduan lengkap mulai dari instalasi lokal sampai deploy production.

## Isi paket ini

File di zip ini adalah **potongan kode inti** (migration, model, controller, route, view,
Dockerfile) yang perlu kamu **tempelkan ke dalam proyek Laravel baru** — bukan proyek
Laravel yang sudah lengkap (karena file inti Laravel seperti `bootstrap/`, `vendor/`,
`artisan`, dll harus digenerate lewat Composer, tidak bisa dibuat manual).

## LANGKAH 1 — Buat Proyek Laravel Baru

```bash
cd C:\xampp\htdocs
composer create-project laravel/laravel rental-outdoor
cd rental-outdoor
```

## LANGKAH 2 — Install Breeze + Tailwind

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
```

## LANGKAH 3 — Install Midtrans PHP SDK

```bash
composer require midtrans/midtrans-php
```

## LANGKAH 4 — Salin file dari paket ini

Copy-timpa folder/file berikut dari zip ini ke proyek Laravel-mu (struktur foldernya
sudah sama persis, jadi tinggal drag & drop / overwrite):

```
database/migrations/*.php        -> database/migrations/
app/Models/*.php                 -> app/Models/
app/Http/Controllers/*.php       -> app/Http/Controllers/
app/Http/Controllers/Admin/*.php -> app/Http/Controllers/Admin/
routes/web.php                   -> routes/web.php (timpa/replace)
resources/views/*                -> resources/views/ (merge dengan punya Breeze)
Dockerfile, docker/*             -> root proyek
```

Tambahkan juga blok Midtrans dari `config/services.php.snippet` ke dalam
`config/services.php` bawaan Laravel-mu.

## LANGKAH 5 — Konfigurasi Database & .env

Buat database `db_rental_outdoor` di phpMyAdmin, lalu copy `.env.example` ke `.env`
dan sesuaikan (bagian MySQL untuk lokal sudah default sesuai XAMPP).

```bash
copy .env.example .env
php artisan key:generate
```

Isi juga `MIDTRANS_SERVER_KEY` dan `MIDTRANS_CLIENT_KEY` dengan Sandbox key dari
dashboard.midtrans.com (Settings > Access Keys).

## LANGKAH 6 — Generate Struktur Tambahan (Auth Users sudah ada dari Breeze)

Migration `categories`, `items`, `rentals`, `rental_details` sudah tersedia di paket ini,
tidak perlu generate ulang dengan `make:model`. Cukup jalankan:

```bash
php artisan storage:link
php artisan migrate
```

(Opsional) buat admin pertama lewat tinker:
```bash
php artisan tinker
>>> \App\Models\User::create(['name'=>'Admin','email'=>'admin@toko.com','password'=>bcrypt('password123')]);
```

## LANGKAH 7 — Jalankan Lokal

```bash
php artisan serve
```

Buka `http://127.0.0.1:8000` untuk katalog publik, dan `http://127.0.0.1:8000/login`
untuk masuk sebagai admin lalu akses `/admin/dashboard`.

## LANGKAH 8 — Setup Webhook Midtrans (Sandbox)

Di dashboard.midtrans.com > Settings > Configuration, isi Payment Notification URL
dengan `https://domainmu.com/webhook/midtrans` (pakai ngrok dulu kalau mau test lokal).

## LANGKAH 9 — Deploy ke Render.com + Supabase

1. Buat project baru di Supabase, ambil connection string PostgreSQL-nya
   (Project Settings > Database).
2. Push proyek ke GitHub.
3. Di Render.com: New > Web Service > pilih repo ini > Environment: **Docker**.
4. Isi Environment Variables di Render sesuai `.env.example` bagian production
   (DB_CONNECTION=pgsql, host/port/user/pass dari Supabase, MIDTRANS_IS_PRODUCTION=true
   dengan key production kalau sudah live).
5. Render otomatis build pakai `Dockerfile` di root. Saat container start,
   `docker/entrypoint.sh` otomatis menjalankan `php artisan migrate --force`
   ke database Supabase sebelum server nyala.
6. Update Payment Notification URL di Midtrans ke domain Render kamu, misal
   `https://rental-outdoor.onrender.com/webhook/midtrans`.

## Alur Bisnis Singkat

```
Customer pilih alat & tanggal → cek stok otomatis (anti-overbooking)
  → checkout → bayar via Midtrans (QRIS/Transfer) → status: booked
  → datang ke toko, admin cek KTP/SIM/STNK ASLI (fisik, tidak diupload)
    → serah-terima → status: active
  → barang kembali, admin cek kondisi → hitung denda telat & klaim kerusakan otomatis
    → status: selesai → jaminan fisik dikembalikan ke customer (offline)
```

## Catatan Keamanan Data (PDP)

Aplikasi ini **sengaja tidak punya fitur upload foto KTP/identitas**. Tabel `rentals`
hanya menyimpan `is_jaminan_diterima` (boolean) dan `jenis_jaminan` (string) — bukan
gambar atau nomor identitas lengkap — untuk mengurangi risiko kebocoran data pribadi
dan beban storage.
