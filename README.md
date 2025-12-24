<h1 align="center">ANPUNDUNG</h1>

<p align="center">
Platform Pelaporan dan Informasi Publik Berbasis Web  
Dibangun menggunakan Laravel & Inertia.js
</p>

---

## 📌 Tentang Anpundung

**Anpundung** adalah aplikasi berbasis web yang dirancang untuk memfasilitasi masyarakat dalam:
- Mengakses informasi dan berita resmi
- Melakukan pelaporan permasalahan di lingkungan sekitar
- Meningkatkan transparansi dan komunikasi antara masyarakat dan pihak pengelola

Aplikasi ini membedakan **hak akses pengguna**:
- **Admin**: mengelola berita, memverifikasi dan menindaklanjuti laporan
- **User**: melihat berita dan mengirim laporan

---

## 🧩 Fitur Utama

### 👤 User
- Melihat daftar berita
- Melihat detail berita
- Mengirim laporan permasalahan

### 🛠️ Admin
- Dashboard admin
- CRUD Berita (Create, Read, Update, Delete)
- Melihat seluruh berita yang dipublikasikan
- Melihat detail laporan dari user

---

## ⚙️ Teknologi yang Digunakan

- **Laravel** (Backend)
- **Inertia.js + React** (Frontend)
- **MySQL** (Database)
- **Tailwind / Bootstrap** (UI)
- **Vite** (Asset bundler)

---

## 🗂️ Struktur Umum Proyek

app/
└── Http/Controllers
resources/
└── js/Pages
└── Berita
├── Index.jsx
├── Create.jsx
├── Edit.jsx
└── Show.jsx
routes/
└── web.php

## 🚀 Instalasi & Menjalankan Project

git clone https://github.com/username/anpundung.git
cd anpundung
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run dev
php artisan serve

🔐 Hak Akses

Akses halaman dashboard dan manajemen berita dibatasi untuk admin

User umum hanya dapat mengakses halaman publik

📄 Lisensi

Project ini dikembangkan untuk keperluan akademik dan pembelajaran.
Penggunaan di luar konteks tersebut menjadi tanggung jawab masing-masing pihak.

✍️ Author

Anpundung Team
Mahasiswa D4 Sistem Informasi Kota Cerdas
Universitas Telkom
