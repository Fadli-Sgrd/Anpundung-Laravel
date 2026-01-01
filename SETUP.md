# Panduan Setup Project (Setelah Clone)

Jika kamu baru saja clone project ini dan mengalami error seperti:
> `Target class [inertia/Middleware] does not exist.`

Itu artinya **dependencies (library pendukung) belum terinstall**. Ikuti langkah-langkah di bawah ini secara berurutan:

## 1. Install Library PHP (Backend)
Buka terminal di folder project, lalu jalankan:

```bash
composer install
```
*Ini akan menginstall Laravel, Inertia, dan library PHP lainnya yang dibutuhkan.*

## 2. Install Library JavaScript (Frontend)
Jalankan perintah ini untuk menginstall React, Vite, Tailwind, dll:

```bash
npm install
```

## 3. Setup File Environment (.env)
Copy file konfigurasi contoh `.env.example` ke file baru `.env`:

```bash
cp .env.example .env
```
*(Kalau pakai Windows Command Prompt biasa, gunakan: `copy .env.example .env`)*

Lalu generate key aplikasi:
```bash
php artisan key:generate
```

## 4. Setup Database
Buka file `.env` yang baru dibuat di text editor, cari bagian Database dan sesuaikan (atau biarkan default sqlite jika pakai SQLite):
```env
DB_CONNECTION=sqlite
# DB_HOST=... (hapus atau comment jika pakai sqlite)
```

Jika pakai SQLite, pastikan file database tersedia (atau biarkan Laravel membuatnya saat migrate):
```bash
php artisan migrate
```
*Jawab 'Yes' jika ditanya untuk membuat database.*

## 5. Build Assets & Jalankan Setup
Sekarang compile assets frontend:
```bash
npm run build
```

Link storage (untuk gambar berita agar bisa diakses public):
```bash
php artisan storage:link
```

## 6. Jalankan Aplikasi
Buka **dua terminal** terpisah:

**Terminal 1 (Backend Server):**
```bash
php artisan serve
```

**Terminal 2 (Frontend Dev Server - Optional tapi recommended):**
```bash
npm run dev
```

Buka browser dan akses URL yang muncul (biasanya `http://127.0.0.1:8000`).

---

## Solusi Error Umum

### `Target class [Inertia\Middleware] does not exist`
**Penyebab:** Lupa menjalankan `composer install`.
**Solusi:** Jalankan langkah no 1.

### `Vite manifest not found`
**Penyebab:** Belum build assets frontend.
**Solusi:** Jalankan `npm run build` atau `npm run dev`.

### `Route [...] not defined` (saat klik link)
**Penyebab:** Cache route lama.
**Solusi:** Jalankan `php artisan route:clear` dan `php artisan view:clear`.
