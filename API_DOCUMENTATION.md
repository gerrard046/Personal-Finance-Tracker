# 📡 REST API Documentation

## Overview

Personal Finance Tracker menyediakan REST API yang lengkap untuk melakukan operasi CRUD pada goals dan transactions.

**Base URL**: `http://localhost:8000/api`

**Authentication**: Session-based (Login/Register melalui form atau API)

---

## 📋 Authentication Endpoints

### POST /auth/register
Mendaftar user baru dan auto-login.

**Request**:
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response** (201 Created):
```json
{
  "success": true,
  "message": "User berhasil didaftarkan dan login",
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2026-04-02T12:00:00Z",
    "updated_at": "2026-04-02T12:00:00Z"
  }
}
```

---

### POST /auth/login
Login dengan email & password.

**Request**:
```json
{
  "email": "demo@example.com",
  "password": "password123"
}
```

**Response** (200 OK):
```json
{
  "success": true,
  "message": "Login berhasil",
  "data": {
    "id": 1,
    "name": "Demo User",
    "email": "demo@example.com"
  }
}
```

---

### POST /auth/logout
Logout user (destroy session).

**Request**: None (Authenticated)

**Response** (200 OK):
```json
{
  "success": true,
  "message": "Logout berhasil"
}
```

---

### GET /auth/me
Get current authenticated user.

**Response** (200 OK):
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Demo User",
    "email": "demo@example.com"
  }
}
```

---

## 🎯 Goals API Endpoints

### GET /goals
List semua goals user dengan optional filter.

**Query Parameters**:
- `status`: Filter by status (active, completed, cancelled)

**Example**: `GET /goals?status=active`

**Response** (200 OK):
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "goal_name": "Beli Sepatu",
      "target_amount": 2000000.00,
      "current_saved": 500000.00,
      "remaining_amount": 1500000.00,
      "progress_percentage": 25.0,
      "category": "Fashion",
      "description": "Sepatu branded impian",
      "target_date": "2026-06-02",
      "days_remaining": 61,
      "target_per_day": 24590.16,
      "target_per_month": 738105.00,
      "status": "active",
      "is_completed": false,
      "created_at": "2026-04-02T12:00:00Z",
      "updated_at": "2026-04-02T12:00:00Z"
    }
  ],
  "count": 1
}
```

---

### POST /goals
Membuat goal baru.

**Request**:
```json
{
  "goal_name": "Beli Sepatu",
  "target_amount": 2000000,
  "category": "Fashion",
  "description": "Sepatu branded impian",
  "target_date": "2026-06-02"
}
```

**Response** (201 Created):
```json
{
  "success": true,
  "message": "Goal berhasil dibuat",
  "data": {
    "id": 1,
    "goal_name": "Beli Sepatu",
    "target_amount": 2000000.00,
    "current_saved": 0.00,
    "remaining_amount": 2000000.00,
    "progress_percentage": 0,
    "target_per_day": 32786.89,
    "target_per_month": 983606.56,
    "days_remaining": 61,
    "status": "active",
    "is_completed": false
  }
}
```

---

### GET /goals/{id}
Get detail goal by ID.

**Response** (200 OK):
```json
{
  "success": true,
  "data": {
    "id": 1,
    "goal_name": "Beli Sepatu",
    "target_amount": 2000000.00,
    "current_saved": 500000.00,
    "remaining_amount": 1500000.00,
    "progress_percentage": 25.0,
    "target_per_day": 24590.16,
    "target_per_month": 738105.00,
    "days_remaining": 61,
    "status": "active",
    "is_completed": false
  }
}
```

---

### PUT /goals/{id}
Update goal.

**Request** (all fields optional):
```json
{
  "goal_name": "Beli Sepatu Nike",
  "current_saved": 750000,
  "target_date": "2026-05-15"
}
```

**Response** (200 OK):
```json
{
  "success": true,
  "message": "Goal berhasil diupdate",
  "data": {
    "id": 1,
    "goal_name": "Beli Sepatu Nike",
    "target_amount": 2000000.00,
    "current_saved": 750000.00,
    "remaining_amount": 1250000.00,
    "progress_percentage": 37.5,
    "status": "active"
  }
}
```

---

### DELETE /goals/{id}
Hapus goal.

**Response** (200 OK):
```json
{
  "success": true,
  "message": "Goal berhasil dihapus"
}
```

---

### POST /goals/{id}/save
Add savings ke goal.

**Request**:
```json
{
  "amount": 100000
}
```

**Response** (200 OK):
```json
{
  "success": true,
  "message": "Savings berhasil ditambahkan",
  "data": {
    "id": 1,
    "goal_name": "Beli Sepatu",
    "current_saved": 600000.00,
    "remaining_amount": 1400000.00,
    "progress_percentage": 30.0,
    "status": "active"
  }
}
```

---

## 💰 Transactions API Endpoints

### GET /transactions
List transaksi dengan pagination dan filter.

**Query Parameters**:
- `type`: Filter by type (income, expense)
- `category`: Filter by category
- `per_page`: Items per page (default: 15)

**Example**: `GET /transactions?type=expense&per_page=10`

**Response** (200 OK):
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "user_id": 1,
      "item_name": "Gaji Bulanan",
      "amount": 5000000.00,
      "category": "Gaji",
      "type": "income",
      "note": "Gaji bulan April",
      "created_at": "2026-04-02T12:00:00Z",
      "updated_at": "2026-04-02T12:00:00Z"
    }
  ],
  "pagination": {
    "total": 7,
    "count": 7,
    "per_page": 15,
    "current_page": 1,
    "last_page": 1
  }
}
```

---

### POST /transactions
Buat transaksi baru.

**Request**:
```json
{
  "item_name": "Makan Siang",
  "amount": 50000,
  "category": "Makanan",
  "type": "expense",
  "note": "Makan di restoran"
}
```

**Response** (201 Created):
```json
{
  "success": true,
  "message": "Transaksi berhasil dibuat",
  "data": {
    "id": 8,
    "user_id": 1,
    "item_name": "Makan Siang",
    "amount": 50000.00,
    "category": "Makanan",
    "type": "expense",
    "note": "Makan di restoran",
    "created_at": "2026-04-02T14:00:00Z"
  }
}
```

---

### GET /transactions/{id}
Get detail transaction.

**Response** (200 OK):
```json
{
  "success": true,
  "data": {
    "id": 1,
    "item_name": "Gaji Bulanan",
    "amount": 5000000.00,
    "category": "Gaji",
    "type": "income"
  }
}
```

---

### PUT /transactions/{id}
Update transaction.

**Request** (all fields optional):
```json
{
  "item_name": "Gaji Bulan Mei",
  "amount": 5100000,
  "note": "Gaji + bonus"
}
```

**Response** (200 OK):
```json
{
  "success": true,
  "message": "Transaksi berhasil diupdate",
  "data": {
    "id": 1,
    "item_name": "Gaji Bulan Mei",
    "amount": 5100000.00
  }
}
```

---

### DELETE /transactions/{id}
Hapus transaction.

**Response** (200 OK):
```json
{
  "success": true,
  "message": "Transaksi berhasil dihapus"
}
```

---

### GET /transactions/stats/summary
Get transaction summary (total income, expense, balance).

**Response** (200 OK):
```json
{
  "success": true,
  "data": {
    "total_income": 6500000.00,
    "total_expense": 1555000.00,
    "current_balance": 4945000.00
  }
}
```

---

## 🧪 Testing dengan cURL

### Test Register & Login
```bash
# Register
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }' \
  -c cookies.txt

# Get Current User
curl -X GET http://localhost:8000/api/auth/me \
  -b cookies.txt
```

### Create Goal
```bash
curl -X POST http://localhost:8000/api/goals \
  -H "Content-Type: application/json" \
  -b cookies.txt \
  -d '{
    "goal_name": "Beli Laptop",
    "target_amount": 15000000,
    "category": "Electronics",
    "target_date": "2026-12-31"
  }'
```

### Add Savings to Goal
```bash
curl -X POST http://localhost:8000/api/goals/1/save \
  -H "Content-Type: application/json" \
  -b cookies.txt \
  -d '{
    "amount": 1000000
  }'
```

### Create Transaction
```bash
curl -X POST http://localhost:8000/api/transactions \
  -H "Content-Type: application/json" \
  -b cookies.txt \
  -d '{
    "item_name": "Makan Pagi",
    "amount": 25000,
    "category": "Makanan",
    "type": "expense"
  }'
```

### Get Transaction Summary
```bash
curl -X GET http://localhost:8000/api/transactions/stats/summary \
  -b cookies.txt
```

---

## 📊 Goals Feature Calculation

### Formula:
```
Progress % = (Current Saved / Target Amount) × 100

Remaining Amount = Target Amount - Current Saved

Days Remaining = Days between today and target_date

Target Per Day = Remaining Amount / Days Remaining

Target Per Month = Remaining Amount / (Days Remaining / 30)
```

### Example:
```
Goal: Beli Sepatu 2 juta
Target Date: 2 Juni 2026 (61 hari dari sekarang)
Current Saved: 500 ribu
Remaining: 1.5 juta

Calculations:
- Progress: (500k / 2M) × 100 = 25%
- Target/Hari: 1.5M / 61 = Rp 24,590
- Target/Bulan: 1.5M / (61/30) = Rp 738,105

Insight: Butuh nabung Rp 24,590/hari atau Rp 738,105/bulan untuk mencapai target
```

---

## Error Handling

### 401 Unauthorized
```json
{
  "success": false,
  "message": "Email atau password tidak valid"
}
```

### 403 Forbidden
```json
{
  "success": false,
  "message": "Anda tidak memiliki akses ke resource ini"
}
```

### 404 Not Found
```json
{
  "success": false,
  "message": "Goal tidak ditemukan"
}
```

### 422 Unprocessable Entity (Validation Error)
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "goal_name": ["The goal name field is required."],
    "target_amount": ["The target amount must be greater than 0."]
  }
}
```

---

## HTTP Status Codes

| Code | Meaning |
|------|---------|
| 200 | OK - Request berhasil |
| 201 | Created - Resource berhasil dibuat |
| 400 | Bad Request - Request tidak valid |
| 401 | Unauthorized - User belum login |
| 403 | Forbidden - User tidak punya akses |
| 404 | Not Found - Resource tidak ada |
| 422 | Unprocessable Entity - Validasi error |
| 500 | Server Error - Error di server |

---

## Rate Limiting

Tidak ada rate limiting saat ini. Silakan diimplementasi di production.

---

## CORS (Cross-Origin)

API dapat diakses dari origin manapun. Silakan configure di `config/cors.php` untuk production.

---

## Pagination

Beberapa endpoint menggunakan pagination:
- `GET /transactions`

Default: 15 items per page
Maximum: Unlimited (customize sesuai kebutuhan)

---

*API Documentation v1.0 - Personal Finance Tracker*
