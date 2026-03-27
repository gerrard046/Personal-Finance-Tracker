# 💰 Personal Finance Tracker

<p align="center">
  <strong>Aplikasi Laravel untuk Memonitor Keuangan Pribadi & Menghindari Boros</strong>
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
- PHP 8.1 atau lebih tinggi
- Composer
- Laravel 11

### Installation

1. **Clone repository dan masuk ke folder project**
   ```bash
   cd Personal-Finance-Tracker
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run migrations**
   ```bash
   php artisan migrate
   ```

5. **Seed dummy data (optional)**
   ```bash
   php artisan db:seed --class=TransactionSeeder
   ```

6. **Start development server**
   ```bash
   php artisan serve
   ```

7. **Buka di browser**
   ```
   http://127.0.0.1:8000
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
