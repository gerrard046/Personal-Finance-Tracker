<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FinanceController extends Controller
{
    /**
     * Menampilkan dashboard dengan overview keuangan
     */
    public function dashboard()
    {
        // Hitung total saldo (income - expense)
        $incomes = Transaction::where('type', 'income')->sum('amount');
        $expenses = Transaction::where('type', 'expense')->sum('amount');
        $currentBalance = $incomes - $expenses;

        // Hitung Daily Safe Limit (Anti-Boros Logic)
        $daysLeftInMonth = $this->getDaysLeftInMonth();
        $dailySafeLimit = $daysLeftInMonth > 0 ? round($currentBalance / $daysLeftInMonth, 2) : 0;

        // Tentukan status warna berdasarkan Daily Safe Limit
        $status = $this->getStatusColor($dailySafeLimit);

        // Ambil 5 transaksi terakhir
        $recentTransactions = Transaction::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Siapkan data untuk di-pass ke view
        $data = [
            'currentBalance' => $currentBalance,
            'dailySafeLimit' => $dailySafeLimit,
            'daysLeftInMonth' => $daysLeftInMonth,
            'status' => $status,
            'recentTransactions' => $recentTransactions,
            'totalIncome' => $incomes,
            'totalExpense' => $expenses,
        ];

        return view('dashboard', $data);
    }

    /**
     * Menyimpan transaksi baru ke database
     */
    public function storeTransaction(Request $request)
    {
        // Validasi input dari user
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'category' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'note' => 'nullable|string|max:500',
        ]);

        // Jika tipe expense, ubah amount menjadi negatif
        if ($validated['type'] === 'expense') {
            $validated['amount'] = abs($validated['amount']) * -1;
        }

        // Simpan transaksi ke database
        Transaction::create($validated);

        // Redirect kembali ke dashboard dengan pesan sukses
        return redirect()->route('dashboard')
            ->with('success', 'Transaksi berhasil disimpan!');
    }

    /**
     * Menghitung sisa hari dalam bulan ini
     * Contoh: Jika hari ini 27 Maret dan bulan Maret punya 31 hari
     * Maka sisa hari = 31 - 27 + 1 = 5 hari (termasuk hari ini)
     */
    private function getDaysLeftInMonth(): int
    {
        $today = Carbon::now();
        $lastDayOfMonth = $today->copy()->endOfMonth();
        
        return $lastDayOfMonth->diffInDays($today) + 1;
    }

    /**
     * Menentukan status warna berdasarkan Daily Safe Limit
     * 
     * Logika "Anti-Boros":
     * - HIJAU (Aman): Daily Safe Limit > 50,000
     *   → Anda bisa menghabiskan lebih dari 50rb per hari masih aman
     * 
     * - KUNING (Waspada): Daily Safe Limit 10,000 - 50,000
     *   → Mulai perlu hati-hati dengan pengeluaran harian
     * 
     * - MERAH (Boros): Daily Safe Limit < 10,000
     *   → Pengeluaran sudah mencurigakan, kurangi spending!
     */
    private function getStatusColor(float $dailyLimit): array
    {
        if ($dailyLimit > 50000) {
            return [
                'color' => 'green',
                'label' => 'Aman',
                'message' => 'Pengeluaran Anda masih dalam batas wajar',
            ];
        } elseif ($dailyLimit >= 10000) {
            return [
                'color' => 'yellow',
                'label' => 'Waspada',
                'message' => 'Mulai hati-hati dengan pengeluaran harian Anda',
            ];
        } else {
            return [
                'color' => 'red',
                'label' => 'Boros!',
                'message' => 'Pengeluaran Anda sudah terlalu banyak, kurangi spending!',
            ];
        }
    }
}
