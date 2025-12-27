# Fitur Admin Status Update - Dokumentasi

## Deskripsi
Fitur ini memungkinkan **hanya admin** untuk mengubah status laporan menjadi: Pending, Proses, Selesai, atau Ditolak. User biasa tidak dapat mengubah status laporan mereka sendiri.

## File yang Dimodifikasi

### 1. Backend (PHP)

#### [Modules/Laporan/app/Http/Controllers/LaporanController.php](Modules/Laporan/app/Http/Controllers/LaporanController.php)
- **Method `updateStatus()`**: Diupdate untuk menggunakan Authorization Policy
- Menvalidasi role admin melalui `$this->authorize('updateStatus', $laporan)`
- Hanya admin yang dapat mengakses route ini

#### [Modules/Laporan/app/Providers/LaporanServiceProvider.php](Modules/Laporan/app/Providers/LaporanServiceProvider.php)
- Menambahkan registrasi Policy di `boot()` method
- `Gate::policy(Laporan::class, LaporanPolicy::class)`

#### [Modules/Laporan/app/Policies/LaporanPolicy.php](Modules/Laporan/app/Policies/LaporanPolicy.php) (File Baru)
- Policy class untuk handling authorization
- Method `updateStatus()`: Hanya return `true` jika user adalah admin
- Method lainnya untuk authorization laporan (view, edit, delete, etc)

#### [Modules/Laporan/routes/web.php](Modules/Laporan/routes/web.php)
- Route sudah ada: `Route::patch('/laporan/{kode_laporan}/status', ...)`
- Controller method handle authorization check

### 2. Frontend (React/Inertia)

#### [Modules/Laporan/resources/assets/js/Pages/Index.jsx](Modules/Laporan/resources/assets/js/Pages/Index.jsx)
**Perubahan:**
1. Menambahkan state `statusDropdownOpen` untuk track dropdown terbuka
2. Menambahkan function `handleStatusChange()` untuk submit perubahan status via PATCH request
3. UI Status Badge:
   - **Admin**: Dropdown button dengan semua opsi status
   - **User**: Badge statis, tidak bisa di-click
4. Dropdown menampilkan: Pending, Proses, Selesai, Ditolak
5. Status yang sedang aktif ditandai dengan highlight biru

## Flow Implementasi

### Admin mengubah status:
```
Admin klik status badge di laporan
  ↓
Dropdown terbuka dengan 4 pilihan status
  ↓
Admin pilih status baru
  ↓
PATCH request ke /laporan/{id}/status dengan status_tindakan
  ↓
Controller check: apakah user adalah admin? (via Policy)
  ↓
Update status di database
  ↓
Flash success message
  ↓
Page reload, dropdown tutup, status terupdate
```

### User melihat status:
```
User lihat halaman laporan
  ↓
Status ditampilkan sebagai static badge (tidak clickable)
  ↓
Tidak bisa mengubah apapun
```

## Security

✅ **Authorization Check di Backend**: 
- Menggunakan Laravel Policy (`LaporanPolicy::updateStatus()`)
- Jika user non-admin coba akses route, akan dapat 403 Forbidden

✅ **Frontend Guard**: 
- Dropdown hanya muncul untuk `auth.user.role === 'admin'`
- User biasa hanya lihat static badge

✅ **Validation**: 
- Status hanya boleh: Pending, Proses, Selesai, Ditolak
- Request yang tidak valid akan ditolak

## Testing

### Test sebagai Admin:
1. Login dengan akun admin
2. Buka halaman Laporan
3. Status laporan tampil sebagai dropdown button
4. Click status → muncul opsi Pending, Proses, Selesai, Ditolak
5. Pilih status baru → status terupdate
6. Lihat success message di halaman

### Test sebagai User:
1. Login dengan akun user biasa
2. Buka halaman Laporan
3. Status tampil sebagai static badge (tidak bisa diklik)
4. Tidak ada dropdown

### Test Authorization Bypass:
1. Sebagai user, coba request langsung: `PATCH /laporan/{id}/status`
2. Harusnya mendapat 403 Unauthorized
