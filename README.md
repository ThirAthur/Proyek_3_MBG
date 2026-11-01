# MBG Report

Aplikasi pelaporan kejadian terkait distribusi dan kualitas makanan dalam program MBG (Makan Bergizi Gratis). Aplikasi menyediakan tiga role pengguna, yaitu User, Admin, dan Koordinator.

## 1. Deskripsi Aplikasi

MBG Report digunakan untuk membuat, memeriksa, dan merekap laporan kejadian di sekolah.

### Fitur Utama
- Login dan registrasi pengguna.
- User dapat membuat dan melihat laporan miliknya.
- Form laporan mencakup sekolah, SPPG, tanggal kejadian, bukti, dan kronologi kejadian.
- Pilihan kronologi: Keracunan, Makanan tidak layak, atau Makanan tidak datang.
- Relasi sekolah dan SPPG menggunakan tabel pivot `school_sppg`.
- Admin dapat melihat dan memeriksa laporan.
- Filter laporan berdasarkan status.
- Koordinator dapat melihat histori dan rekap laporan.
- Koordinator dapat mengelola akun dan mengubah role pengguna.

### Role Pengguna

| Role | Hak Akses |
|---|---|
| User | Membuat laporan dan melihat laporan miliknya. |
| Admin | Melihat serta memeriksa laporan. |
| Koordinator | Mengakses rekap laporan dan mengelola akun serta role pengguna. |

## 2. Kebutuhan Environment

Perangkat lunak yang dibutuhkan:

| Komponen | Kebutuhan |
|---|---|
| PHP | 8.3 atau lebih baru |
| Laravel | 13.x |
| Composer | 2.x |
| Database | MySQL 8.0+ atau MariaDB |
| Node.js | 20.19+ atau 22.12+ |
| NPM | Mengikuti versi Node.js |
| Browser | Chrome, Firefox, Edge, atau browser modern lainnya |

### Ekstensi PHP

Pastikan ekstensi berikut aktif:
- `ctype`
- `curl`
- `dom`
- `fileinfo`
- `mbstring`
- `openssl`
- `PDO`
- `pdo_mysql`
- `session`
- `tokenizer`
- `xml`

Khusus pengguna MySQL, pastikan ekstensi `pdo_mysql` sudah aktif.

## 3. Langkah Instalasi

1. Ekstrak folder proyek MBG Report.
2. Buka terminal pada direktori utama proyek yang berisi file `artisan` dan `composer.json`.
3. Instal dependensi PHP:

   ```bash
   composer install
   ```

4. Buat file `.env` dari `.env.example`.

   **Windows:**
   ```bash
   copy .env.example .env
   ```

   **Linux/macOS:**
   ```bash
   cp .env.example .env
   ```

5. Generate application key:

   ```bash
   php artisan key:generate
   ```

6. Konfigurasikan database pada file `.env`.
7. Instal dependensi frontend:

   ```bash
   npm install
   ```

8. Build asset frontend:

   ```bash
   npm run build
   ```

## 4. Konfigurasi Database

Buat database baru melalui phpMyAdmin atau MySQL. Contoh nama database:

`pelaporan_mbg`

Kemudian buka file `.env` dan sesuaikan konfigurasi berikut:

```dotenv
APP_NAME="MBG Report"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pelaporan_mbg
DB_USERNAME=root
DB_PASSWORD=
```

Keterangan:
- `DB_HOST`: alamat server database.
- `DB_PORT`: port MySQL, biasanya 3306.
- `DB_DATABASE`: nama database.
- `DB_USERNAME`: username MySQL.
- `DB_PASSWORD`: password MySQL.

Sesuaikan username dan password dengan konfigurasi MySQL lokal.

Setelah mengubah `.env`, jalankan:

```bash
php artisan config:clear
```

## 5. Cara Migration dan Seeding

### A. Migration

Migration digunakan untuk membuat struktur tabel database secara otomatis.

Jalankan:

```bash
php artisan migrate
```

Beberapa tabel utama yang digunakan:

| Tabel | Fungsi |
|---|---|
| `users` | Menyimpan data pengguna dan role. |
| `reports` | Menyimpan data laporan. |
| `schools` | Menyimpan data sekolah. |
| `sppgs` | Menyimpan data SPPG. |
| `school_sppg` | Menyimpan relasi sekolah dengan SPPG. |

Tabel pendukung Laravel juga akan dibuat sesuai migration yang tersedia.

### B. Seeding

Seeder digunakan untuk memasukkan data awal ke database.

Jalankan seluruh seeder:

```bash
php artisan db:seed
```

Seeder mencakup:
- Data akun Admin.
- Data akun Koordinator.
- Data akun User.
- Data sekolah.
- Data SPPG.
- Relasi sekolah dan SPPG.

### C. Migration dan Seeding Sekaligus

Untuk database baru:

```bash
php artisan migrate --seed
```

### D. Reset Database

Jika ingin menghapus seluruh tabel dan membuat ulang database:

```bash
php artisan migrate:fresh --seed
```

**Perhatian:** Perintah `migrate:fresh` akan menghapus seluruh data yang tersimpan di database. Gunakan hanya pada lingkungan pengembangan atau database yang datanya boleh dihapus.

### E. Menambahkan Data Sekolah dan SPPG

Data sekolah dan SPPG contoh dapat disesuaikan melalui:

- `database/seeders/SchoolSeeder.php`
- `database/seeders/SppgSeeder.php`
- `database/seeders/SchoolSppgSeeder.php`

Sesuaikan data tersebut dengan daftar sekolah, SPPG, dan hubungan distribusi yang sebenarnya.

## 6. Akun Demo Setiap Role

Berikut akun demo yang dapat digunakan untuk menguji aplikasi:

| Role | Email | Password |
|---|---|---|
| Koordinator | `koordinator@mbgreport.com` | `koordinator12345` |
| Admin | `admin@mbgreport.com` | `admin12345` |
| User | `user@mbgreport.com` | `user12345` |

### Hak Akses Akun Demo

**User**
- Membuat laporan kejadian.
- Melihat histori laporan sendiri.
- Memfilter laporan berdasarkan status.

**Admin**
- Melihat laporan yang masuk.
- Memeriksa laporan.
- Mengelola proses pemeriksaan laporan.

**Koordinator**
- Melihat seluruh laporan.
- Melihat histori dan rekapitulasi laporan.
- Mengakses dashboard Koordinator.
- Mengelola akun pengguna.
- Mengubah role pengguna, termasuk Admin dan User.

Catatan: Akun demo hanya digunakan untuk pengujian. Ganti password akun demo sebelum aplikasi digunakan di lingkungan produksi.

## 7. Cara Menjalankan Aplikasi

Pastikan:
- MySQL sudah aktif.
- Database sudah dibuat.
- Migration sudah dijalankan.
- Seeder sudah dijalankan.
- File `.env` sudah dikonfigurasi.

Jalankan server Laravel:

```bash
php artisan serve
```

Setelah server berjalan, buka browser dan akses:

```text
http://127.0.0.1:8000
```

Login menggunakan salah satu akun demo sesuai role yang ingin diuji.

### Menjalankan Mode Development Frontend

Jika sedang melakukan pengembangan tampilan, jalankan perintah berikut pada terminal kedua:

```bash
npm run dev
```

Biarkan proses Vite berjalan selama pengembangan.

Untuk penggunaan tanpa development server, jalankan:

```bash
npm run build
```

## Troubleshooting

| Masalah | Solusi |
|---|---|
| `could not find driver` | Aktifkan ekstensi PHP `pdo_mysql`. |
| Koneksi database gagal | Periksa konfigurasi `.env` dan pastikan MySQL aktif. |
| Tabel belum tersedia | Jalankan `php artisan migrate`. |
| Akun demo belum tersedia | Jalankan `php artisan db:seed`. |
| Perubahan `.env` tidak terbaca | Jalankan `php artisan config:clear`. |
| Asset Vite tidak ditemukan | Jalankan `npm install` dan `npm run build`. |

---

# IDENTITAS
FATHIR ATHTHUR FAHREZI 
251511037

**MBG Report**  
Sistem Informasi Pelaporan Makan Bergizi Gratis.