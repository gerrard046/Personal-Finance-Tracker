# 💰 Personal Finance Tracker - Dokumentasi Lengkap

## 🚀 Ringkasan Aplikasi

Personal Finance Tracker adalah aplikasi Laravel yang dirancang untuk membantu Anda mengelola keuangan pribadi dan menghindari pengeluaran yang berlebihan (boros). Aplikasi ini menggunakan konsep **"Anti-Boros"** dengan menghitung **Daily Safe Limit** - estimasi berapa banyak uang yang bisa Anda keluarkan setiap hari.

---

## 📋 Struktur File yang Telah Dibuat

### 1. **Migration: `/database/migrations/2026_03_27_110214_create_transactions_table.php`**

File ini mendefinisikan struktur tabel `transactions` di database SQLite.

**Kolom yang tersedia:**
- `id` - ID unik transaksi (Primary Key)
- `item_name` - Nama item/deskripsi transaksi (string)
- `amount` - Jumlah uang transaksi (decimal, 12 digit, 2 desimal)
- `category` - Kategori transaksi (string)
- `type` - Tipe transaksi ('income' atau 'expense')
- `note` - Catatan tambahan (text, nullable)
- `created_at`, `updated_at` - Timestamp otomatis

**Contoh Data:**
```
| id | item_name | amount | category | type | note |
|----|-----------|---------|----|------|------|
| 1 | Gaji | 5000000 | Gaji | income | Gaji bulan Maret 2026 |
| 2 | Roti | -45000 | Makanan | expense | Sarapan pagi |
| 3 | Bensin | -85000 | Transport | expense | Isi bensin full tank |
```

---

### 2. **Model: `/app/Models/Transaction.php`**

Model ini merepresentasikan tabel `transactions` di database. Model ini memungkinkan Anda untuk:
- Mengambil, menyimpan, mengubah, dan menghapus data transaksi dari database
- Mengakses data dengan cara yang ORM (Object-Relational Mapping)

**Properti Penting:**
- `$fillable` - Kolom yang bisa diisi dari user input (item_name, amount, category, type, note)
- `$casts` - Konversi tipe data (amount selalu decimal)

**Contoh Penggunaan:**
```php
// Membuat transaksi baru
Transaction::create([
    'item_name' => 'Makan',
    'amount' => -50000,
    'category' => 'Makanan',
    'type' => 'expense',
]);

// Mengambil semua transaksi
$transactions = Transaction::all();

// Mengambil transaksi berdasarkan tipe
$incomes = Transaction::where('type', 'income')->get();
$expenses = Transaction::where('type', 'expense')->get();
```

---

### 3. **Controller: `/app/Http/Controllers/FinanceController.php`**

Controller ini berisi logika bisnis aplikasi. Ada 2 method utama:

#### **Method 1: `dashboard()`**
Menampilkan dashboard dengan:
- Total saldo saat ini (pemasukan - pengeluaran)
- Daily Safe Limit (jumlah yang boleh dikeluarkan per hari)
- Status warna (Hijau/Kuning/Merah)
- 5 transaksi terakhir

**Logika Daily Safe Limit:**
```
Daily Safe Limit = Sisa Saldo / Sisa Hari dalam Bulan
```

**Contoh:**
- Sisa Saldo: Rp 2.000.000
- Hari ini: 27 Maret
- Hari terakhir bulan: 31 Maret
- Sisa hari: 5 hari
- Daily Safe Limit = 2.000.000 / 5 = **Rp 400.000/hari**

#### **Method 2: `storeTransaction(Request $request)`**
Menyimpan transaksi baru dengan validasi:
- item_name (wajib diisi, max 255 karakter)
- amount (wajib diisi, harus angka positif)
- category (wajib diisi)
- type (wajib diisi, hanya 'income' atau 'expense')
- note (opsional, max 500 karakter)

**Fitur Otomatis:**
Jika tipe adalah 'expense', amount akan otomatis menjadi negatif.

---

### 4. **Routes: `/routes/web.php`**

Mendefinisikan 2 endpoint aplikasi:

```php
// GET / - Menampilkan dashboard
Route::get('/', [FinanceController::class, 'dashboard'])->name('dashboard');

// POST /transaction - Menyimpan transaksi baru
Route::post('/transaction', [FinanceController::class, 'storeTransaction'])
    ->name('transaction.store');
```

---

### 5. **View: `/resources/views/dashboard.blade.php`**

Tampilan frontend aplikasi menggunakan Tailwind CSS. Fitur-fitur:

#### **Bagian 1: Informasi Saldo**
- Menampilkan total saldo dengan warna besar
- Breakdown pemasukan vs pengeluaran

#### **Bagian 2: Indikator Anti-Boros**
Status warna berdasarkan Daily Safe Limit:

| Daily Safe Limit | Status | Warna | Pesan |
|-------------------|--------|-------|-------|
| > Rp 50.000 | Aman | 🟢 Hijau | Pengeluaran masih dalam batas wajar |
| Rp 10.000 - 50.000 | Waspada | 🟡 Kuning | Mulai hati-hati dengan pengeluaran harian |
| < Rp 10.000 | Boros! | 🔴 Merah | Pengeluaran sudah terlalu banyak, kurangi spending! |

#### **Bagian 3: Form Input Transaksi**
Form sederhana untuk input:
- Nama item
- Jenis transaksi (Income/Expense)
- Kategori dinamis (berubah sesuai jenis transaksi)
- Jumlah uang
- Catatan opsional

**Kategori Pengeluaran:**
🍔 Makanan & Minuman, 🚗 Transport, 🎬 Entertainment, 💡 Utilitas, 🛍️ Belanja, ⚕️ Kesehatan, ℹ️ Lainnya

**Kategori Pemasukan:**
💰 Gaji, 🎁 Bonus, 📈 Return Investasi, 💻 Freelance, ℹ️ Lainnya

#### **Bagian 4: Daftar 5 Transaksi Terakhir**
Menampilkan transaksi terbaru dengan:
- Icon transaksi (📈 untuk income, 📉 untuk expense)
- Nama item
- Kategori dan tanggal/waktu
- Catatan (jika ada)
- Jumlah uang dengan warna (hijau untuk income, merah untuk expense)

---

## 🗄️ Database Schema (SQLite)

Tabel `transactions`:
```sql
CREATE TABLE transactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    item_name VARCHAR(255) NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    category VARCHAR(255) NOT NULL,
    type VARCHAR(10) NOT NULL CHECK(type IN ('income', 'expense')),
    note TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## 🎯 Cara Menggunakan Aplikasi

### **Step 1: Akses Dashboard**
Buka browser dan pergi ke: **http://127.0.0.1:8000**

### **Step 2: Lihat Informasi Saldo**
Di bagian atas, Anda akan melihat:
- Total saldo saat ini
- Breakdown pemasukan dan pengeluaran
- Daily Safe Limit Anda
- Status indikator warna

### **Step 3: Catat Transaksi Baru**
Di sisi kanan, ada form untuk input transaksi:
1. Isi **Nama Item** (contoh: "Beli Roti", "Gaji Hari Ini")
2. Pilih **Jenis Transaksi** (Income atau Expense)
3. Kategori akan otomatis berubah sesuai pilihan Anda
4. Isi **Jumlah Uang** (tanpa Rp atau tanda negatif)
5. Tambahkan **Catatan** (opsional)
6. Klik **Simpan Transaksi**

### **Step 4: Lihat Riwayat Transaksi**
Di bagian bawah, Anda bisa melihat 5 transaksi terakhir Anda.

---

## 💡 Tips Menggunakan "Anti-Boros"

1. **Perhatikan Daily Safe Limit**
   - Ini adalah target berapa banyak uang yang bisa Anda keluarkan per hari
   - Jika sudah merah, kurangi pengeluaran Anda

2. **Catat Setiap Pengeluaran**
   - Jangan lupa mencatat pembelian sekecil apapun
   - Setiap rupiah berpengaruh pada Daily Safe Limit Anda

3. **Review Mingguan**
   - Setiap minggu, lihat kategori mana yang paling banyak menghabis uang
   - Fokus untuk mengurangi pengeluaran di kategori tersebut

4. **Analisis Pola Pengeluaran**
   - Dari data yang terakumulasi, Anda bisa melihat pola spending Anda
   - Apakah lebih banyak dun makanan, transport, atau entertainment?

---

## 📝 Contoh Skenario Real-World

**Skenario 1: Aman** ✅
```
Tanggal: 27 Maret 2026
Sisa Saldo: Rp 4.500.000
Sisa Hari: 5 hari
Daily Safe Limit: 4.500.000 / 5 = Rp 900.000/hari
Status: 🟢 HIJAU (AMAN)
→ Anda masih boleh keluar uang hingga Rp 900.000 per hari
```

**Skenario 2: Waspada** ⚠️
```
Tanggal: 27 Maret 2026
Sisa Saldo: Rp 200.000
Sisa Hari: 5 hari
Daily Safe Limit: 200.000 / 5 = Rp 40.000/hari
Status: 🟡 KUNING (WASPADA)
→ Mulai hati-hati, hanya boleh Rp 40.000 per hari
```

**Skenario 3: Boros** 🔴
```
Tanggal: 27 Maret 2026
Sisa Saldo: -Rp 500.000 (minus/hutang!)
Sisa Hari: 5 hari
Daily Safe Limit: -100.000
Status: 🔴 MERAH (BOROS!)
→ Anda sudah deficit, STOP SPENDING sekarang juga!
```

---

## 🛠️ Data Dummy yang Sudah Ada

Saat Anda pertama kali membuka aplikasi, sudah ada 6 transaksi dummy:

1. **Gaji Bulanan** - +Rp 5.000.000 (Pemasukan)
2. **Roti Indomaret** - -Rp 45.000 (Makanan)
3. **Bensin Motor** - -Rp 85.000 (Transport)
4. **Nonton Bioskop** - -Rp 150.000 (Entertainment)
5. **Belanja Kebutuhan Rumah** - -Rp 200.000 (Belanja)
6. **Makan Siang Restoran** - -Rp 75.000 (Makanan)

**Total Transaksi:**
- Pemasukan: Rp 5.000.000
- Pengeluaran: -Rp 555.000
- **Saldo Akhir: Rp 4.445.000**
- **Daily Safe Limit (5 hari): Rp 889.000/hari** → 🟢 HIJAU

---

## 🔧 Pengembangan Lanjutan (Fitur yang Bisa Ditambahkan)

1. **Authentication** - Login/Register untuk multi-user
2. **Export to CSV** - Download laporan transaksi
3. **Monthly Report** - Laporan bulanan per kategori
4. **Budget Target** - Set target pengeluaran per kategori
5. **Chart/Graph** - Visualisasi spending pola menggunakan Chart.js
6. **Mobile App** - React Native atau Flutter version
7. **Recurring Transactions** - Transaksi otomatis yang berulang
8. **Multiple Currency** - Support untuk multi-currency

---

## 📞 Troubleshooting

### **Q: Form tidak bisa submit**
A: Pastikan semua field wajib sudah diisi (item_name, amount, type, category)

### **Q: Data tidak tersimpan**
A: Cek di browser console (F12) apakah ada error. Pastikan database sudah ter-migrate dengan `php artisan migrate`

### **Q: Halaman error 500**
A: Jalankan `php artisan config:clear` untuk clear cache, kemudian restart server

### **Q: Daily Safe Limit tidak akurat**
A: Nilai dihitung real-time berdasarkan sisa hari dalam bulan dan saldo Anda. Akan berubah setiap hari otomatis.

---

## 📚 File Referensi

- **Database:** `/database/database.sqlite`
- **Log:** `/storage/logs/laravel.log`
- **Config:** `/config/app.php`, `/config/database.php`

---

## ✅ Checklist Implementasi

- ✅ Database Migration dengan kolom lengkap
- ✅ Transaction Model dengan fillable & casts
- ✅ FinanceController dengan logika Anti-Boros
- ✅ Routes untuk dashboard dan store
- ✅ Dashboard View dengan Tailwind CSS
- ✅ Form input dengan validasi
- ✅ Display 5 transaksi terbaru
- ✅ Dynamic kategori berdasarkan tipe transaksi
- ✅ Color indicator (Hijau/Kuning/Merah)
- ✅ Sample data dummy untuk testing
- ✅ Responsive design untuk mobile

---

**Selamat menggunakan Personal Finance Tracker! Semoga dengan aplikasi ini, Anda bisa lebih sadar dalam berbelanja dan menghindari kebiasaan boros. 💪💰**

---

*Dibuat dengan ❤️ menggunakan Laravel, Tailwind CSS, dan SQLite*
*Dokumentasi lengkap dan code yang mudah dipelajari untuk pemula yang masih belajar*
