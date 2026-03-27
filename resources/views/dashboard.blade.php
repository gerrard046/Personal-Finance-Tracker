@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-gray-800 mb-2">💰 Dashboard Keuangan Saya</h1>
    <p class="text-gray-600">Kelola keuangan Anda dengan sistem "Anti-Boros"</p>
</div>

<!-- Grid Layout -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Saldo Card -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-gray-200 text-sm font-semibold">SALDO SAAT INI</h3>
            <i class="fas fa-wallet text-2xl opacity-20"></i>
        </div>
        <p class="text-3xl font-bold">Rp {{ number_format($currentBalance, 0, ',', '.') }}</p>
        <div class="mt-4 text-blue-100 text-xs">
            <p>📈 Pemasukan: Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
            <p>📉 Pengeluaran: Rp {{ number_format(abs($totalExpense), 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Daily Safe Limit Card -->
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-lg shadow-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-purple-200 text-sm font-semibold">DAILY SAFE LIMIT</h3>
            <i class="fas fa-chart-pie text-2xl opacity-20"></i>
        </div>
        <p class="text-3xl font-bold">Rp {{ number_format($dailySafeLimit, 0, ',', '.') }}/hari</p>
        <div class="mt-4 text-purple-100 text-xs">
            <p>📅 Sisa {{ $daysLeftInMonth }} hari dalam bulan ini</p>
        </div>
    </div>

    <!-- Status Card -->
    <div class="rounded-lg shadow-lg p-6 {{ $status['color'] === 'green' ? 'bg-gradient-to-br from-green-500 to-green-600' : ($status['color'] === 'yellow' ? 'bg-gradient-to-br from-yellow-500 to-yellow-600' : 'bg-gradient-to-br from-red-500 to-red-600') }} text-white">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-opacity-80 text-sm font-semibold">STATUS KEUANGAN</h3>
            <i class="fas fa-shield-alt text-2xl opacity-20"></i>
        </div>
        <p class="text-3xl font-bold">{{ $status['label'] }}</p>
        <div class="mt-4 opacity-90 text-xs">
            <p>{{ $status['message'] }}</p>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
    <a href="{{ route('income.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-4 rounded-lg transition flex items-center justify-center gap-3 shadow-lg">
        <i class="fas fa-plus-circle text-xl"></i>
        <span>Tambah Saldo/Pemasukan</span>
    </a>
    <a href="{{ route('expense.create') }}" class="bg-red-500 hover:bg-red-600 text-white font-bold py-4 rounded-lg transition flex items-center justify-center gap-3 shadow-lg">
        <i class="fas fa-minus-circle text-xl"></i>
        <span>Tambah Pengeluaran</span>
    </a>
</div>

<!-- Recent Transactions -->
<div class="bg-white rounded-lg shadow-lg p-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        <i class="fas fa-history text-purple-600"></i>
        Transaksi Terakhir
    </h2>

    @if ($recentTransactions->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b-2 border-gray-200">
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold">Keterangan</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold">Kategori</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold">Jumlah</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold">Tanggal</th>
                        <th class="text-left py-3 px-4 text-gray-600 font-semibold">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentTransactions as $transaction)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-4 px-4 font-medium text-gray-900">
                                <div class="flex items-center gap-2">
                                    <span class="text-xl">
                                        @if ($transaction->type === 'income')
                                            ✅
                                        @else
                                            ❌
                                        @endif
                                    </span>
                                    {{ $transaction->item_name }}
                                </div>
                            </td>
                            <td class="py-4 px-4 text-gray-600">
                                <span class="bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-sm">
                                    {{ $transaction->category }}
                                </span>
                            </td>
                            <td class="py-4 px-4 font-bold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format(abs($transaction->amount), 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-4 text-gray-600 text-sm">
                                {{ $transaction->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="py-4 px-4 text-gray-600 text-sm max-w-xs truncate" title="{{ $transaction->note }}">
                                {{ $transaction->note ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-inbox text-gray-400 text-4xl mb-4"></i>
            <p class="text-gray-500 text-lg">Belum ada transaksi</p>
            <p class="text-gray-400">Mulai catat pengeluaran atau saldo Anda sekarang!</p>
        </div>
    @endif
</div>

<!-- Info Box -->
<div class="mt-8 bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg">
    <h3 class="font-bold text-blue-900 mb-2">💡 Cara Kerja Anti-Boros</h3>
    <p class="text-blue-800 text-sm mb-3">
        Sistem ini menghitung berapa banyak uang yang bisa Anda keluarkan setiap hari dengan membagi saldo total Anda dengan jumlah hari yang tersisa dalam bulan ini.
    </p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
        <div class="bg-white p-3 rounded">
            <p class="text-sm font-semibold text-green-600">🟢 HIJAU (Aman)</p>
            <p class="text-xs text-gray-600">Daily Limit > Rp 50.000</p>
        </div>
        <div class="bg-white p-3 rounded">
            <p class="text-sm font-semibold text-yellow-600">🟡 KUNING (Waspada)</p>
            <p class="text-xs text-gray-600">Daily Limit Rp 10-50rb</p>
        </div>
        <div class="bg-white p-3 rounded">
            <p class="text-sm font-semibold text-red-600">🔴 MERAH (Boros!)</p>
            <p class="text-xs text-gray-600">Daily Limit < Rp 10.000</p>
        </div>
    </div>
</div>
@endsection

