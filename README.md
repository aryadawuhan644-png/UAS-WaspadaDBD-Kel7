# 🦟 BAMUK — Basmi Nyamuk
### Sistem Pemantauan Risiko Demam Berdarah Berbasis Lingkungan

> **Pantau • Laporkan • Cegah**

Aplikasi web end-to-end untuk membantu petugas jumantik mencatat titik risiko DBD, melakukan pemeriksaan lingkungan, mengklasifikasikan level risiko, dan memantau status tindak lanjut secara digital — menggantikan pencatatan berbasis formulir kertas.

---

## 👥 Anggota Kelompok

| Nama | NIM | Peran |
|------|-----|-------|
| Alifia Az-Zahra Murtidewi | 24102004 | UI/UX Designer & Dokumentasi |
| Arya Anugrah Saputra | 24102027 | Backend Developer |
| Audina Ike Wati | 24102028 | Project Manager & Dokumentasi |
| Zayyan Muhammad Ihsan Syafatullah | 24102039 | Frontend Developer & DevOps |

---

## ✨ Fitur Aplikasi

### Backend Laravel (Admin & Petugas)
- 🔐 Login dengan role-based access (Admin & Petugas)
- 📊 Dashboard statistik jumlah titik risiko, risiko tinggi, dan pemeriksaan bulan ini
- 📍 CRUD Titik Risiko (nama, alamat, RT/RW, koordinat, jenis & level risiko)
- 🔬 CRUD Pemeriksaan Risiko (jentik, kondisi lingkungan, tindakan, status akhir)
- 🔽 Filter data berdasarkan level risiko, wilayah, dan status
- ✅ Validasi input semua form
- 🔒 Middleware auth — seluruh halaman backend diproteksi login

### Frontend PHP Native (Publik)
- 🏠 Halaman beranda BAMUK
- 📚 Halaman edukasi DBD (3M Plus & pencegahan)
- 📋 Daftar titik risiko dengan badge level berwarna
- 🔍 Detail titik risiko & riwayat pemeriksaan
- 🔎 Pencarian lokasi berdasarkan nama atau wilayah
- 📡 Semua data diambil dari API Laravel
- 📱 Responsif di desktop dan mobile

### Fitur Inovasi
- 🟢🟡🔴 Badge risiko: rendah (hijau), sedang (kuning), tinggi (merah)
- 🗺️ Link Google Maps dari koordinat latitude/longitude
- 📜 Riwayat pemeriksaan per titik risiko
- ⚠️ Penanda titik risiko yang belum pernah diperiksa
- 📖 Halaman edukasi DBD dengan konten Kemenkes

---

## 🛠️ Teknologi

| Komponen | Teknologi |
|----------|-----------|
| Backend | Laravel 11 |
| Frontend | PHP Native + HTML + Bootstrap 5 |
| Database | MySQL / MariaDB |
| API | REST API (JSON) |
| Auth | Laravel Session Auth + Middleware |
| Deploy | InfinityFree (rf.gd) |

---

## ⚙️ Cara Instalasi

### Prasyarat
- PHP >= 8.1
- Composer
- MySQL / MariaDB
- Node.js (opsional, untuk asset)

### Langkah-langkah

**1. Clone repository**
```bash
git clone https://github.com/aryadawuhan644/UAS-WaspadaDBD-Kel8.git
cd UAS-WaspadaDBD-Kel8
```

**2. Install dependency**
```bash
composer install
```

**3. Konfigurasi environment**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Atur database di file `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=waspadadbd_db
DB_USERNAME=root
DB_PASSWORD=
```

**5. Jalankan migration dan seeder**
```bash
php artisan migrate
php artisan db:seed
```

**6. Jalankan server**
```bash
php artisan serve
```

**7. Akses aplikasi**
- Backend: `http://127.0.0.1:8000/login`
- Frontend: `http://127.0.0.1:8000`

---

## 🔑 Akun Demo

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@demo.com | password123 |
| Petugas | petugasdua@demo.com | password123 |

> ⚠️ Seluruh data yang digunakan merupakan **data dummy/simulasi**. Tidak ada data nyata, NIK, atau informasi pribadi yang digunakan.

---

## 🌐 Link Deploy

| Halaman | URL |
|---------|-----|
| Frontend / Beranda | https://waspada-dbd.rf.gd/ |
| Backend / Admin | https://waspada-dbd.rf.gd/login |

---

## 📡 Endpoint API

| Method | Endpoint | Keterangan |
|--------|----------|------------|
| GET | `/api/titik-risiko` | Menampilkan semua titik risiko |
| GET | `/api/titik-risiko/{id}` | Detail satu titik risiko |
| GET | `/api/titik-risiko/{id}/pemeriksaan` | Riwayat pemeriksaan per titik |
| POST | `/api/pemeriksaan-risiko` | Mencatat pemeriksaan baru |
| GET | `/api/titik-risiko/level/{level}` | Filter titik risiko berdasarkan level (rendah/sedang/tinggi) |

### Contoh Response GET `/api/titik-risiko`
```json
{
  "data": [
    {
      "id": 1,
      "nama_titik": "Genangan Lahan Kosong",
      "alamat": "Jl. S. Supriadi, Sukun",
      "rt_rw": "RT 01/RW 02",
      "latitude": "-7.99423",
      "longitude": "112.62001",
      "jenis_risiko": "genangan",
      "level_risiko_awal": "tinggi",
      "status_aktif": true
    }
  ]
}
```

---

## 🗂️ Struktur Database

| Tabel | Keterangan |
|-------|------------|
| `users` | Data admin dan petugas (role: admin/petugas) |
| `titik_risikos` | Data titik lokasi risiko DBD |
| `pemeriksaan_risikos` | Hasil pemeriksaan per titik risiko |
| `edukasi_dbds` | Konten edukasi pencegahan DBD |

---

## 🤖 AI Usage Log

AI digunakan sebagai alat bantu selama pengerjaan. Seluruh hasil AI telah diverifikasi, dipahami, dan direvisi oleh tim sebelum diterapkan. Penggunaan AI mencakup: referensi desain, rancangan ERD, kode migration Laravel, CRUD controller, konfigurasi API, pengembangan frontend PHP native, debugging CORS, proses deploy, dan penulisan dokumentasi.

Tools yang digunakan: **ChatGPT**, **Google Gemini**, **Claude**

---

## 📋 Pembagian Tugas

| Anggota | Kontribusi |
|---------|------------|
| Alifia Az-Zahra Murtidewi | Merancang tampilan dan alur antarmuka aplikasi BAMUK, membuat referensi desain frontend, membantu penulisan laporan |
| Arya Anugrah Saputra | Membangun backend Laravel, implementasi CRUD, autentikasi role-based, middleware auth, dan endpoint API |
| Audina Ike Wati | Koordinasi project, menyusun laporan PDF, merancang ERD dan desain database, memastikan timeline terpenuhi |
| Zayyan Muhammad Ihsan Syafatullah | Membangun frontend PHP native, integrasi API Laravel ke frontend, dan deploy aplikasi ke server live |

---

## 📄 Lisensi

Project ini dibuat untuk memenuhi tugas UAS mata kuliah **Pemrograman Web**  
Program Studi S1 Informatika — ITSK RS dr. Soepraoen Kesdam V/Brawijaya Malang — 2026