# SiapLapor

Platform pelaporan dan pemantauan infrastruktur kota berbasis prioritas. Warga melaporkan masalah infrastruktur (jalan rusak, sampah menumpuk, lampu jalan mati, dll) lengkap dengan foto dan titik lokasi di peta, sistem otomatis menghitung skor prioritas laporan, lalu Petugas memproses laporan berdasarkan urutan prioritas tersebut.

Dibuat untuk study case seleksi Asisten Praktikum & Asisten Lab EISD (Enterprise Intelligent and Systems Development), Program Studi S1 Sistem Informasi, Telkom University.

![Landing page SiapLapor](docs/screenshots/landing.png)

---

## Latar Belakang

Isu infrastruktur kota berkaitan erat dengan SDG 11, *Sustainable Cities and Communities*. Warga sering menemukan masalah infrastruktur di sekitarnya, tapi tidak ada kanal pelaporan terstruktur yang menampilkan status penanganan secara transparan, apalagi yang bisa membantu petugas menentukan laporan mana yang harus ditangani lebih dulu. SiapLapor mencoba menjawab ini dengan alur yang jelas: Warga lapor, sistem menghitung prioritas, Petugas menindaklanjuti sesuai urutan prioritas, dan Warga bisa memantau progresnya. Jadi penanganan masalah kota lebih terarah, tidak sekadar "siapa cepat dia dapat".

---

## Fitur Utama

### Warga
- Registrasi akun & login
- Buat laporan baru: judul, deskripsi, pilih titik lokasi di peta interaktif (koordinat otomatis terisi), pilih satu atau lebih kategori masalah, upload foto bukti
- Lihat riwayat semua laporan yang pernah dibuat beserta statusnya
- Lihat detail laporan lengkap dengan timeline riwayat status dari Petugas
- Edit profil (nama, telepon, alamat, password)

### Petugas
- Login khusus akun Petugas
- Dashboard berisi semua laporan warga, diurutkan dari skor prioritas tertinggi
- Filter laporan berdasarkan kategori dan/atau status
- Lihat detail satu laporan
- Perbarui status laporan (Diterima → Diproses → Selesai) dengan catatan penanganan yang tersimpan sebagai riwayat, bukan menimpa status sebelumnya

### Admin
- Login khusus akun Admin
- Dashboard statistik: total laporan, jumlah per status, jumlah per kategori (chart)
- Kelola Kategori masalah: CRUD penuh (nama + bobot prioritas)
- Kelola Akun Pengguna: CRUD penuh untuk akun Warga dan Petugas
- Lihat seluruh laporan yang masuk ke sistem (read-only, tanpa batasan kepemilikan)

Akses tiap halaman dibatasi sesuai role lewat middleware. Petugas misalnya tidak bisa mengakses halaman Kelola Kategori milik Admin.

---

## Tech Stack

| Kategori | Teknologi |
|---|---|
| Backend | Laravel 12 (PHP ^8.2) |
| Autentikasi | Laravel Breeze |
| Frontend | Blade Templates, Tailwind CSS 3, Alpine.js |
| Build tool | Vite |
| Database | SQLite |
| Peta interaktif | Leaflet.js + OpenStreetMap (gratis, tanpa API key), Nominatim untuk reverse geocoding |
| Chart | Chart.js |

Seluruh fitur CRUD (Controller, View, Route) ditulis manual mengikuti arsitektur MVC standar Laravel. Tidak ada package admin-panel-builder seperti Filament, Nova, atau Backpack yang dipakai.

---

## Struktur Database

| Tabel | Keterangan |
|---|---|
| `users` | Akun dengan kolom `role` (`warga` / `petugas` / `admin`), single table inheritance |
| `categories` | Kategori masalah infrastruktur beserta `priority_weight` (bobot prioritas) |
| `reports` | Laporan warga: judul, deskripsi, foto, alamat, lat/long, status, `priority_score` |
| `report_category` | Tabel pivot relasi many-to-many antara `reports` dan `categories` |
| `status_histories` | Riwayat setiap perubahan status laporan beserta catatan petugas |

Relasi utama:
- `User` hasMany `Report` (sebagai pelapor), 1-to-Many
- `User` hasMany `StatusHistory` (sebagai petugas yang update), 1-to-Many
- `Report` belongsTo `User`
- `Report` belongsToMany `Category` melalui `report_category`, Many-to-Many
- `Report` hasMany `StatusHistory` (cascade delete)
- `StatusHistory` belongsTo `Report` dan belongsTo `User`

---

## Cara Menjalankan Project dari Nol

Langkah di bawah sudah diuji langsung: clone repo ini ke folder kosong lalu dijalankan satu per satu, bukan cuma asumsi dari dokumentasi Laravel.

### Prasyarat

- PHP ≥ 8.2 (diuji dengan PHP 8.2.12) beserta ekstensi standar (`pdo_sqlite`, `mbstring`, `openssl`, `gd`)
- Composer 2.x
- Node.js ≥ 18 dan npm (diuji dengan Node 24, npm 11)
- Git

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/nuxras/REPO_Nugraha-Ade-Mulyana_Rekrutmen_EISD.git
cd REPO_Nugraha-Ade-Mulyana_Rekrutmen_EISD

# 2. Install dependency PHP
composer install

# 3. Salin file environment & generate application key
cp .env.example .env
php artisan key:generate

# 4. Buat file database SQLite kosong
#    Windows PowerShell:  New-Item database/database.sqlite
#    Git Bash / macOS / Linux:
touch database/database.sqlite

# 5. Jalankan migration untuk membuat seluruh tabel
php artisan migrate

# 6. Isi database dengan data dummy (akun demo, kategori, contoh laporan)
php artisan db:seed

# 7. Buat symbolic link agar foto laporan bisa diakses dari browser
php artisan storage:link

# 8. Install dependency frontend & build asset CSS/JS
npm install
npm run build

# 9. Jalankan server development
php artisan serve
```

Setelah langkah terakhir, buka http://127.0.0.1:8000 di browser.

Catatan: `.env.example` sudah diset memakai `DB_CONNECTION=sqlite`, jadi tidak perlu setup MySQL apa pun. Untuk mode pengembangan aktif (auto-reload saat mengubah file Blade/CSS), jalankan `npm run dev` di terminal terpisah alih-alih `npm run build`.

---

## Akun Demo untuk Testing

Semua akun di bawah pakai password yang sama: `password`

| Role | Email | Password |
|---|---|---|
| Admin | `admin@siaplapor.test` | `password` |
| Petugas | `petugas1@siaplapor.test` | `password` |
| Petugas | `petugas2@siaplapor.test` | `password` |
| Warga | `warga1@siaplapor.test` | `password` |
| Warga | `warga2@siaplapor.test` | `password` |
| Warga | `warga3@siaplapor.test` | `password` |

Setelah login, sistem otomatis mengarahkan ke dashboard sesuai role. Database demo sudah berisi 5 kategori masalah dan 10 contoh laporan dengan variasi status dan lokasi (area Bandung) untuk keperluan pengujian.

---

## Fitur Unggulan

### Peta Interaktif (Leaflet.js)

Saat Warga membuat laporan baru, tersedia peta interaktif penuh (bukan sekadar tautan ke Google Maps) pakai Leaflet.js + OpenStreetMap, gratis dan tanpa perlu API key. Warga tinggal klik titik di peta: marker langsung muncul, koordinat latitude/longitude otomatis terisi ke form, dan alamat ikut terisi lewat reverse geocoding (Nominatim API) berdasarkan koordinat tersebut. Tetap bisa diedit manual kalau kurang tepat.

![Peta interaktif saat membuat laporan](docs/screenshots/peta-interaktif.png)

Di halaman detail laporan ada mini-map dengan marker lokasi, plus timeline vertikal riwayat status supaya Warga bisa memantau progres penanganan secara visual.

![Timeline riwayat status laporan](docs/screenshots/timeline-status.png)

### Sistem Skor Prioritas Otomatis

Setiap laporan baru otomatis dihitung skor prioritasnya dengan formula:

```
priority_score = SUM(bobot semua kategori yang dipilih)
               + (jumlah laporan lain yang serupa) x 10
```

Sebuah laporan dianggap "serupa" kalau memenuhi dua syarat sekaligus: berbagi minimal satu kategori yang sama, dan berlokasi dalam radius 500 meter dari laporan yang baru dibuat (dihitung pakai formula Haversine untuk jarak antar dua koordinat GPS).

Contohnya, laporan "Jalan Rusak" (bobot 30) yang lokasinya berdekatan dengan 2 laporan "Jalan Rusak" lain akan mendapat skor `30 + (2 x 10) = 50`. Makin banyak laporan serupa menumpuk di satu area, makin tinggi urutan prioritasnya di dashboard Petugas.

Skor ini ditampilkan sebagai badge berwarna: merah untuk skor ≥ 70 ("Tinggi"), kuning untuk 40-69 ("Sedang"), hijau untuk di bawah 40 ("Rendah"). Petugas jadi tidak perlu menyortir manual, laporan paling mendesak otomatis muncul paling atas.

![Dashboard Petugas terurut skor prioritas](docs/screenshots/petugas-dashboard.png)

### Dashboard Admin

Statistik ringkas plus chart jumlah laporan per kategori dan distribusi status, untuk memantau kondisi sistem secara keseluruhan.

![Dashboard Admin dengan chart](docs/screenshots/admin-dashboard.png)

---

## Menjalankan Test

```bash
php artisan test
```

---

## Struktur Folder Singkat

```
app/
├── Http/Controllers/
│   ├── Admin/          # DashboardController, CategoryController, UserController, ReportController
│   ├── Petugas/        # DashboardController, ReportController
│   └── Warga/          # DashboardController, ReportController, ProfileController
├── Models/              # User, Category, Report, StatusHistory
└── Http/Middleware/     # RoleMiddleware (pembatas akses per role)

database/
├── migrations/          # Skema tabel users, categories, reports, report_category, status_histories
└── seeders/             # DatabaseSeeder, akun demo + kategori + laporan contoh

resources/views/
├── admin/ petugas/ warga/   # View per role
├── layouts/                 # Layout utama + navigasi (responsive, ada menu mobile)
└── components/               # priority-badge, status-badge, dan komponen Blade reusable lain

routes/web.php           # Seluruh route aplikasi, dikelompokkan per role + middleware
```
