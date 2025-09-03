# GMP - Sistem Pemantauan Produktivitas Konstruksi

Sistem web untuk memantau produktivitas pekerjaan konstruksi (khususnya operasi HSPD/Hammer Soil Pile Driver) dengan fitur input data lapangan, stopwatch/timer per aktivitas, rekap produktivitas, serta manajemen pengguna dan profil.

## Fitur Utama
- Monitoring pekerjaan: input lokasi, titik, spesifikasi pile, tanggal, jam kerja, FA, dll.
- Stopwatch/timer multi-tahap (t1..t9) dengan perhitungan total waktu otomatis (ts).
- Perhitungan produktivitas HSPD per entri.
- Filter data berdasarkan lokasi dan rentang tanggal.
- Tampilan mobile (route prefix `mobile`) untuk input lapangan cepat.
- Manajemen pengguna, autentikasi, dan update profil/password.
- API endpoints untuk integrasi dan mobile client.

## Tech Stack
- Backend: Laravel (PHP)
- Database: MySQL/MariaDB
- Frontend: Blade, HTML/CSS/JS
- Lainnya: RESTful API, middleware auth

## Prasyarat
- PHP 8.1+
- Composer
- MySQL/MariaDB
- Node.js & NPM (opsional bila menggunakan asset pipeline)

## Instalasi & Menjalankan Secara Lokal
1) Clone repo dan masuk ke folder proyek
```bash
git clone <url-repo-anda>
cd GMP
```

2) Instal dependensi
```bash
composer install
```

3) Salin env dan atur konfigurasi
```bash
cp .env.example .env
# Atur DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
```

4) Generate app key
```bash
php artisan key:generate
```

5) Migrasi dan seeding (opsional bila migrasi tersedia)
```bash
php artisan migrate --seed
```

6) Jalankan server lokal
```bash
php artisan serve
# Akses: http://localhost:8000
```

## Struktur Penting
- routes/web.php: route web, termasuk route terlindungi dan route mobile
- routes/api.php: route API
- app/Http/Controllers/MonitoringController.php: logika monitoring, timer, perhitungan ts
- app/Models/Monitoring.php: model Eloquent untuk tabel `monitoring`
- resources/views/: tampilan Blade

## Endpoint Utama (Contoh)
- Web
  - GET /monitoring (list & filter)
  - PUT /monitoring/{id} (update)
  - DELETE /monitoring/{id} (hapus)
  - GET /produktivitas-hspd, GET /produktivitas-harian
  - GET /pengguna, POST /pengguna, PUT /pengguna/{user}, DELETE /pengguna/{user}
  - GET /profil, PUT /profil/update, PUT /profil/password
- Mobile (/mobile prefix)
  - GET /monitoring, POST /monitoring
  - GET /stopwatch, GET /stopwatch/new
  - POST /monitoring/update-time, POST /monitoring/update-time-new
  - GET/POST /final-input/{id}, GET/POST /final-input-new/{id}
- API (/api prefix)
  - POST /monitoring
  - PUT /monitoring/{id}/timer
  - POST /monitoring/{id}/finish

## Environment Variables
- APP_ENV, APP_KEY, APP_DEBUG, APP_URL
- DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD

## Build & Deploy (Ringkas)
- Pastikan .env untuk production telah diatur
- Jalankan migrasi di server: php artisan migrate --force
- Gunakan web server (Nginx/Apache) yang diarahkan ke folder public/

## Lisensi
Proyek ini bersifat privat untuk keperluan portofolio/implementasi. Sesuaikan lisensi sesuai kebutuhan.
