# Aplikasi Kost Anisya

Aplikasi ini digunakan untuk mengelola data kost, kamar, penghuni, barang, tagihan, pembayaran, dan laporan secara online.

## Struktur Folder

- `public/` — Halaman utama dan login
- `admin/` — Halaman admin (dashboard, kamar, penghuni, barang, tagihan, pembayaran, laporan, dll)
- `config/` — Koneksi database
- `database.sql` — Struktur database MySQL

## Cara Menjalankan

1. **Import Database**
   - Import file `database.sql` ke MySQL Anda (misal via phpMyAdmin).
2. **Konfigurasi Database**
   - Edit `config/db.php` jika perlu, sesuaikan user/password/database.
3. **Akses Halaman Utama**
   - [http://localhost/app_kost_anisya/public/index.php](http://localhost/app_kost_anisya/public/index.php)
4. **Akses Login Admin**
   - [http://localhost/app_kost_anisya/public/login.php](http://localhost/app_kost_anisya/public/login.php)
5. **Akses Dashboard Admin**
   - [http://localhost/app_kost_anisya/admin/dashboard.php](http://localhost/app_kost_anisya/admin/dashboard.php)

## Fitur Utama
- Data kamar, penghuni, barang, barang bawaan
- Relasi kamar-penghuni
- Tagihan bulanan & pembayaran
- Laporan kamar kosong, tagihan, keterlambatan
- Dashboard statistik
- Tampilan modern (Bootstrap 5, Bootstrap Icons)

## Tips Troubleshooting
- **Tidak bisa lihat tampilan login:**
  - Jika sudah login, login.php akan redirect ke dashboard. Untuk melihat tampilan login:
    1. Logout dulu: [http://localhost/app_kost_anisya/public/logout.php](http://localhost/app_kost_anisya/public/logout.php)
    2. Atau buka login.php di mode incognito/private browser.
- **Tidak bisa login:**
  - Pastikan database sudah terisi user admin.
  - Cek koneksi di `config/db.php`.

## Dependensi
- [Bootstrap 5](https://getbootstrap.com/)
- [Bootstrap Icons](https://icons.getbootstrap.com/)

## Kontak Pengembang
- (Isi kontak Anda di sini jika perlu)
