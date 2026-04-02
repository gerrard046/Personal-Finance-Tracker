# 💰 Personal Finance Tracker - Demo Guide

Aplikasi **Personal Finance Tracker** adalah sistem manajemen keuangan pribadi dengan fitur "Anti-Boros" yang membantu Anda mengontrol pengeluaran dengan cerdas.

## 🚀 Quick Start

### 1. Akses Aplikasi
Buka browser dan navigasi ke: **http://localhost:8000**

### 2. Demo Credentials

Gunakan akun demo berikut untuk login:

| Field | Value |
|-------|-------|
| Email | `demo@example.com` |
| Password | `password123` |

Atau buat akun baru dengan fitur **Register**.

---

## 📋 Fitur Utama

### 1. **Dashboard - Overview Keuangan**
Halaman pertama setelah login menampilkan:

#### Card 1: Saldo Saat Ini (BIRU)
- Total saldo = Pemasukan - Pengeluaran
- Tampilan terperinci pemasukan dan pengeluaran
- **Demo Data**: Rp 4.945.000 (dari gaji 5juta - pengeluaran 55rb)

#### Card 2: Daily Safe Limit (UNGU)
- Menghitung berapa banyak uang yang bisa dikeluarkan per hari
- Formula: `Total Saldo / Sisa Hari dalam Bulan`
- Membantu Anda mengatur budget harian
- **Demo Data**: ~Rp 224.773/hari (untuk bulan April dengan 22 hari tersisa)

#### Card 3: Status Keuangan (Berwarna - HIJAU/KUNING/MERAH)
- **HIJAU (Aman)**: Daily Limit > Rp 50.000 → Pengeluaran masih wajar
- **KUNING (Waspada)**: Daily Limit Rp 10-50rb → Mulai hati-hati
- **MERAH (Boros!)**: Daily Limit < Rp 10.000 → Kurangi spending!

**Demo Status**: 🟢 **HIJAU** (Aman - Daily Limit tinggi)

---

### 2. **Tambah Saldo/Pemasukan**
Klik tombol **"Tambah Saldo/Pemasukan"** untuk mencatat pendapatan:

**Form Fields:**
- **Nama Item/Keterangan**: Label transaksi (cth: "Gaji", "Bonus", "Investasi")
- **Jumlah (Rp)**: Nominal uang yang masuk
- **Kategori**: Pilihan kategori (Gaji, Bonus, Investasi, Bisnis, Insentif, Lainnya)
- **Catatan (Opsional)**: Penjelasan tambahan

**Contoh Penggunaan Demo:**
1. Nama: `Gaji Bulanan Tambahan`
2. Jumlah: `1000000`
3. Kategori: `Bonus`
4. Catatan: `Bonus kinerja tambahan April`
5. Klik **Simpan Saldo**

Setelah submit, Anda akan kembali ke dashboard dengan saldo yang ter-update.

---

### 3. **Tambah Pengeluaran**
Klik tombol **"Tambah Pengeluaran"** untuk mencatat pengeluaran:

**Form Fields:**
- **Nama Item/Keterangan**: Deskripsi pengeluaran (cth: "Makan", "Bensin")
- **Jumlah (Rp)**: Nominal pengeluaran (sistem otomatis negatif)
- **Kategori**: Pilihan (Makanan, Transportasi, Belanja, Kesehatan, Hiburan, Utilitas, Cicilan, Zakat, Lainnya)
- **Catatan (Opsional)**: Detail pengeluaran

**Contoh Penggunaan Demo:**
1. Nama: `Movie Tickets`
2. Jumlah: `150000`
3. Kategori: `Hiburan`
4. Catatan: `Nonton bareng keluarga`
5. Klik **Simpan Pengeluaran**

Saldo dan Daily Safe Limit akan otomatis ter-update di dashboard.

---

### 4. **Tabel Transaksi Terakhir**
Menampilkan 5 transaksi terbaru dengan kolom:

| Kolom | Keterangan |
|-------|-----------|
| Keterangan | Nama transaksi + emoji (✅ income, ❌ expense) |
| Kategori | Badge warna kategori |
| Jumlah | Nominal + (untuk income, - untuk expense) |
| Tanggal | Format: `dd MMM YYYY HH:mm` |
| Catatan | Note yang ditambahkan |

**Demo Transaksi:**
- ✅ Gaji Bulanan: +Rp 5.000.000
- ❌ Roti Indomaret: -Rp 45.000
- ❌ Bensin Motor: -Rp 85.000
- ❌ Bioskop: -Rp 150.000
- ✅ Bonus Kerja: +Rp 1.500.000

---

### 5. **Sistem Anti-Boros Explanation**
Info box di bawah tabel menjelaskan:

**Cara Kerja:**
```
Daily Safe Limit = Total Saldo ÷ Sisa Hari Bulan

Contoh:
- Saldo: Rp 5.000.000
- Sisa hari: 10 hari
- Daily Limit: Rp 500.000/hari
```

**Status Color:**
- 🟢 HIJAU: Limit > Rp 50.000 (fleksibel)
- 🟡 KUNING: Limit Rp 10-50rb (hati-hati)
- 🔴 MERAH: Limit < Rp 10.000 (waspada)

---

## 🔐 Authentication

### Login
1. Buka halaman login: `http://localhost:8000/login`
2. Masukkan email & password
3. Klik **Login** button
4. Redirect ke dashboard jika berhasil

### Register
1. Buka halaman register: `http://localhost:8000/register`
2. Isi form:
   - Nama Lengkap
   - Email (harus unik)
   - Password (min 6 karakter)
   - Konfirmasi Password
3. Klik **Daftar** button
4. Redirect ke login untuk masuk dengan akun baru

### Logout
Klik tombol **Logout** di navigation bar (atas kanan)

---

## 📊 Demo Workflow

### Flow 1: Login & Lihat Dashboard
```
1. Buka http://localhost:8000
2. Login dengan demo@example.com / password123
3. Lihat dashboard dengan data demo sudah terisi
```

### Flow 2: Tambah Income
```
1. Klik "Tambah Saldo/Pemasukan"
2. Isi form dengan data baru
3. Lihat saldo & daily limit ter-update
```

### Flow 3: Tambah Expense
```
1. Klik "Tambah Pengeluaran"  
2. Isi form dengan pengeluaran
3. Cek status berubah jika daily limit berkurang
4. Lihat riwayat di tabel transaksi
```

### Flow 4: Logout & Register User Baru
```
1. Logout dari akun demo
2. Klik "Daftar" di halaman login
3. Buat akun baru
4. Login dengan akun baru (data kosong awal)
5. Mulai add transaksi sendiri
```

---

## 🎨 UI Features

### Responsive Design
- ✅ Mobile-friendly (Grid responsive)
- ✅ Tailwind CSS styling
- ✅ Font Awesome icons

### Color Scheme
- **Primary**: Purple (#667eea)
- **Success**: Green (income)
- **Danger**: Red (expense)
- **Warning**: Yellow (status waspada)

### Interactive Elements
- ✅ Hover effects di buttons
- ✅ Focus states di input fields
- ✅ Form validation & error messages
- ✅ Success notifications setelah submit

---

## 🐛 Known Limitations
- Node.js version terlalu lama (v20.11.1, butuh 20.19+), jadi assets Vite tidak ter-build
- Namun CSS & JS sudah tersedia via CDN (Tailwind, Font Awesome)
- Aplikasi tetap fully functional

---

## 🚀 API Routes (Backend)

| Method | Route | Handler | Auth |
|--------|-------|---------|------|
| GET | `/` | Redirect login/dashboard | No |
| GET | `/login` | Show login form | Guest |
| POST | `/login` | Process login | Guest |
| GET | `/register` | Show register form | Guest |
| POST | `/register` | Process registration | Guest |
| POST | `/logout` | Logout user | Auth |
| GET | `/dashboard` | Dashboard page | Auth |
| GET | `/add-income` | Income form | Auth |
| GET | `/add-expense` | Expense form | Auth |
| POST | `/transaction` | Store transaction | Auth |

---

## 💾 Database Structure

### Users Table
```
id (PK)
name
email (UNIQUE)
password (hashed)
created_at
updated_at
```

### Transactions Table
```
id (PK)
user_id (FK → users.id)
item_name
amount (decimal, dapat negatif)
category
type (enum: 'income', 'expense')
note (nullable)
created_at
updated_at
```

---

## 📝 Demo Data Included

### User
- **Email**: demo@example.com
- **Password**: password123
- **Name**: Demo User

### Transactions (7 items)
1. Gaji Bulanan: +Rp 5.000.000 (Gaji)
2. Roti Indomaret: -Rp 45.000 (Makanan)
3. Bensin Motor: -Rp 85.000 (Transportasi)
4. Bioskop: -Rp 150.000 (Hiburan)
5. Belanja Rumah: -Rp 200.000 (Belanja)
6. Makan Siang: -Rp 75.000 (Makanan)
7. Bonus Kerja: +Rp 1.500.000 (Bonus)

**Total Balance**: Rp 4.945.000

---

## ✅ Testing Checklist

- [ ] Login dengan akun demo
- [ ] Lihat dashboard & cards (saldo, daily limit, status)
- [ ] Lihat tabel transaksi terakhir
- [ ] Tambah income baru - cek dashboard ter-update
- [ ] Tambah expense baru - cek status berubah jika perlu
- [ ] Logout berhasil
- [ ] Register user baru
- [ ] Login dengan user baru (data kosong)
- [ ] Responsive di mobile/tablet

---

## 🎯 Next Steps / Future Features

Fitur yang bisa ditambahkan:
- 📈 Grafik statistik pengeluaran per kategori
- 📅 Filter transaksi per tanggal/bulan
- 🎯 Budget target per kategori
- 📥 Export ke CSV/PDF
- 💬 Notifikasi real-time
- 🔔 Alert ketika daily limit terlampaui

---

## 📞 Support

Jika ada pertanyaan atau bug, silakan buat issue di repository.

**Happy Tracking! 💰**
