# 💰 Personal Finance Tracker

<p align="center">
  <strong>Aplikasi Laravel untuk Memonitor Keuangan Pribadi & Menghindari Boros</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Status-Production%20Ready-green" alt="Production Ready">
  <img src="https://img.shields.io/badge/Version-1.0.0-blue" alt="Version 1.0.0">
  <img src="https://img.shields.io/badge/License-MIT-brightgreen" alt="MIT License">
</p>

## 🎯 Tentang Aplikasi

Personal Finance Tracker adalah aplikasi web yang dirancang khusus untuk membantu Anda mengelola keuangan pribadi dengan lebih baik. Terutama bagi yang sering boros, aplikasi ini menyediakan fitur **"Anti-Boros"** yang menghitung **Daily Safe Limit** - estimasi berapa banyak uang yang bisa Anda keluarkan setiap hari.

### 🌟 Fitur Utama

✅ **Dashboard Overview** - Lihat total saldo, pemasukan, dan pengeluaran Anda  
✅ **Anti-Boros Logic** - Hitung Daily Safe Limit otomatis  
✅ **Color Indicator** - Indikator warna (Hijau/Kuning/Merah) berdasarkan spending  
✅ **Transaction Recording** - Catat transaksi income dan expense dengan mudah  
✅ **Category Management** - Kelompokkan transaksi berdasarkan kategori  
✅ **Recent Transactions** - Lihat 5 transaksi terakhir Anda  
✅ **Responsive Design** - Bekerja sempurna di desktop dan mobile  
✅ **SQLite Database** - Lightweight, tanpa perlu server database tambahan  

---

## 🚀 Quick Start

### Prerequisites
- **PHP 8.1** atau lebih tinggi ([Download PHP](https://www.php.net/downloads))
- **Composer** ([Download Composer](https://getcomposer.org/download/))
- **Node.js** (opsional, untuk asset compilation)

> ℹ️ **Untuk Windows Users:** Kami recommend menggunakan **XAMPP** yang sudah include PHP dan Apache. [Download XAMPP](https://www.apachefriends.org/)

### Installation

#### 📋 Step 1: Download & Extract Project
1. Download repository sebagai ZIP dari GitHub
2. Extract ke folder yang Anda inginkan
3. Buka Command Prompt / PowerShell di folder tersebut

#### 🔧 Step 2: Install Composer Dependencies
```bash
composer install
```

**❌ Jika error `composer not found`:**
- Pastikan Composer sudah terinstall
- Gunakan full path: `C:\ProgramData\ComposerSetup\bin\composer install`
- Atau tambahkan Composer ke PATH environment variables

#### 📝 Step 3: Setup Environment File
```bash
# Linux/Mac
cp .env.example .env

# Windows (Command Prompt)
copy .env.example .env

# Windows (PowerShell)
Copy-Item .env.example .env
```

#### 🔐 Step 4: Generate Application Key
```bash
php artisan key:generate
```

#### 🗄️ Step 5: Setup Database & Run Migrations
```bash
php artisan migrate
```

> **Database Note:** Project ini menggunakan **SQLite** (database file lokal) - tidak butuh MySQL server terpisah!

#### 📦 Step 6: Seed Dummy Data (Optional)
```bash
php artisan db:seed --class=TransactionSeeder
```

#### ▶️ Step 7: Start Development Server
```bash
php artisan serve
```

Anda akan melihat output seperti:
```
INFO  Server running on [http://127.0.0.1:8000]
```

#### 🌐 Step 8: Buka di Browser
```
http://127.0.0.1:8000
```

---

### ❓ Troubleshooting

#### Error: `Failed to open stream: No such file or directory` (vendor/autoload.php)
**Solusi:** Jalankan `composer install` terlebih dahulu
```bash
composer install
```

#### Error: "command not found: composer" (Mac/Linux)
**Solusi:** Gunakan path lengkap atau install Composer globally
```bash
php composer.phar install
```

#### Error: "PHP 8.1 required, you are running X.X.X"
**Solusi:** Update PHP ke versi 8.1+
- Untuk XAMPP users: Edit `php.ini` atau upgrade XAMPP ke versi terbaru

#### Error: ".env file not found"
**Solusi:** Pastikan Anda sudah copy `.env.example` ke `.env`

#### Port 8000 sudah digunakan
**Solusi:** Gunakan port berbeda
```bash
php artisan serve --port=8001
```

---

## 📁 Project Structure

```
Personal-Finance-Tracker/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── FinanceController.php      # Business logic
│   └── Models/
│       └── Transaction.php                # Data model
├── database/
│   ├── migrations/
│   │   └── *_create_transactions_table.php
│   └── seeders/
│       └── TransactionSeeder.php          # Sample data
├── resources/
│   └── views/
│       └── dashboard.blade.php            # Main view
├── routes/
│   └── web.php                            # Routes definition
├── DOKUMENTASI.md                         # Full documentation (Indonesian)
└── README.md                              # This file
```

---

## 💡 How "Anti-Boros" Works

### Daily Safe Limit Formula
```
Daily Safe Limit = Current Balance / Days Left in Month
```

### Status Indicators
| Daily Safe Limit | Status | Color | Message |
|-------------------|--------|-------|---------|
| > Rp 50,000 | Aman (Safe) | 🟢 Green | Pengeluaran masih dalam batas wajar |
| Rp 10,000 - 50,000 | Waspada (Alert) | 🟡 Yellow | Mulai hati-hati dengan pengeluaran |
| < Rp 10,000 | Boros (Overspending) | 🔴 Red | Kurangi spending sekarang! |

### Example Scenario
```
Today: March 27, 2026
Remaining Balance: Rp 4,500,000
Days Left in Month: 5 days (27-31 March)
Daily Safe Limit: 4,500,000 / 5 = Rp 900,000/day
Status: 🟢 SAFE (Green)
→ You can spend up to Rp 900,000/day safely
```

---

## 📋 Database Schema

### transactions table
```sql
CREATE TABLE transactions (
    id BIGINT PRIMARY KEY,
    item_name VARCHAR(255) NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    category VARCHAR(255) NOT NULL,
    type ENUM('income', 'expense') NOT NULL,
    note TEXT NULLABLE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

---

## 🛠️ API Routes

### Display Dashboard
```
GET  /
→ Shows dashboard with balance, daily safe limit, and recent transactions
```

### Store New Transaction
```
POST /transaction
Parameters:
  - item_name (required): string, max 255
  - amount (required): numeric, min 0.01
  - category (required): string
  - type (required): 'income' or 'expense'
  - note (optional): string, max 500

Response: Redirect to dashboard with success message
```

---

## 📚 File Documentation

Untuk dokumentasi lengkap dalam bahasa Indonesia, baca file **[DOKUMENTASI.md](DOKUMENTASI.md)**

Dokumentasi mencakup:
- ✅ Penjelasan detail setiap file yang dibuat
- ✅ Contoh penggunaan code
- ✅ Cara menggunakan aplikasi
- ✅ Tips Anti-Boros
- ✅ Troubleshooting
- ✅ Fitur pengembangan lanjutan

---

## 🎓 Learning Purpose

Kode ini dirancang untuk educational purpose dengan:
- 📝 Comments yang jelas pada setiap fungsi penting
- 📖 Penjelasan logic yang mudah dipahami
- 🎯 Best practices Laravel yang proper
- 💪 Struktur code yang scalable

Sempurna untuk pemula yang sedang belajar Laravel!

---

## 🚀 Future Enhancements

- [ ] User Authentication & Multi-user support
- [ ] Export reports to CSV/PDF
- [ ] Monthly & yearly statistics
- [ ] Budget targets per category
- [ ] Charts & graphs visualization
- [ ] Mobile app version
- [ ] Recurring transactions
- [ ] Multi-currency support

---

## 📞 Support

Jika ada yang tidak mengerti atau ada error, cek bagian **Troubleshooting** di [DOKUMENTASI.md](DOKUMENTASI.md)

---

## 📄 License

This project is open source and available under the MIT license.

---

## 💪 Tips for Anti-Boros Success

1. **Catat Setiap Pengeluaran** - Jangan lewatkan pembelian sekecil apapun
2. **Review Mingguan** - Cek kategori mana yang paling banyak menghabis uang
3. **Perhatikan Daily Safe Limit** - Ini adalah guide Anda untuk spending harian
4. **Analisis Pola** - Pelajari kebiasaan pengeluaran Anda
5. **Adjust Behavior** - Kurangi pengeluaran di kategori non-esensial

---

**Dibangun dengan ❤️ menggunakan Laravel, Tailwind CSS, & SQLite**

*Semoga aplikasi ini membantu Anda lebih sadar dalam berbelanja dan menghindari kebiasaan boros! 💰✨*

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
