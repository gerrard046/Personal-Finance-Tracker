<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FinanceController extends Controller
{
    /**
     * Menampilkan dashboard dengan overview keuangan
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Hitung total saldo (income - expense) untuk user yang login
        $incomes = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->sum('amount');
        $expenses = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->sum('amount');
        // FIXED: amount sudah positif di database, jadi tinggal kurangi
        $currentBalance = $incomes - $expenses;

        // Hitung Daily Safe Limit (Anti-Boros Logic)
        $daysLeftInMonth = $this->getDaysLeftInMonth();
        $dailySafeLimit = $daysLeftInMonth > 0 ? round($currentBalance / $daysLeftInMonth, 2) : 0;

        // Tentukan status warna berdasarkan Daily Safe Limit
        $status = $this->getStatusColor($dailySafeLimit);

        // Ambil 5 transaksi terakhir untuk user yang login
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
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
     * Menampilkan form untuk menambah income/saldo
     */
    public function showAddIncome()
    {
        return view('finance.add-income');
    }

    /**
     * Menampilkan form untuk menambah expense/pengeluaran
     */
    public function showAddExpense()
    {
        return view('finance.add-expense');
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

        // Tambahkan user_id
        $validated['user_id'] = Auth::id();

        // Simpan amount sebagai positif (tipe field sudah menentukan income/expense)
        $validated['amount'] = abs($validated['amount']);

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
     * Logika "Anti-Boros" dengan benchmark 300rb:
     * - HIJAU (Aman): Daily Safe Limit > 300,000
     *   → Banyak duit, bisa belanja santai
     * 
     * - KUNING (Waspada): Daily Safe Limit 100,000 - 300,000
     *   → Budget cukup, mulai perlu planning
     * 
     * - MERAH (Boros): Daily Safe Limit < 100,000
     *   → Budget ketat, harus hemat!
     */
    private function getStatusColor(float $dailyLimit): array
    {
        if ($dailyLimit > 300000) {
            return [
                'color' => 'green',
                'label' => 'Aman',
                'message' => 'Daily budget Anda > Rp 300rb, pengeluaran masih sangat fleksibel',
            ];
        } elseif ($dailyLimit >= 100000) {
            return [
                'color' => 'yellow',
                'label' => 'Waspada',
                'message' => 'Daily budget Anda Rp 100-300rb, mulai rencanakan pengeluaran dengan baik',
            ];
        } else {
            return [
                'color' => 'red',
                'label' => 'Boros!',
                'message' => 'Daily budget < Rp 100rb, harus di-hemat supaya tidak over budget!',
            ];
        }
    }
}

