<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data sample transaksi untuk testing
        $transactions = [
            // Pemasukan
            [
                'item_name' => 'Gaji Bulanan',
                'amount' => 5000000,
                'category' => 'Gaji',
                'type' => 'income',
                'note' => 'Gaji bulan Maret 2026',
                'created_at' => now()->subDays(10),
            ],
            // Pengeluaran
            [
                'item_name' => 'Beli Roti di Indomaret',
                'amount' => -45000,
                'category' => 'Makanan',
                'type' => 'expense',
                'note' => 'Sarapan pagi',
                'created_at' => now()->subDays(5),
            ],
            [
                'item_name' => 'Bensin Motor',
                'amount' => -85000,
                'category' => 'Transport',
                'type' => 'expense',
                'note' => 'Isi bensin full tank',
                'created_at' => now()->subDays(4),
            ],
            [
                'item_name' => 'Nonton Bioskop',
                'amount' => -150000,
                'category' => 'Entertainment',
                'type' => 'expense',
                'note' => 'Tiket bioskop 2 orang',
                'created_at' => now()->subDays(3),
            ],
            [
                'item_name' => 'Belanja Kebutuhan Rumah',
                'amount' => -200000,
                'category' => 'Belanja',
                'type' => 'expense',
                'note' => 'Beli sabun, pasta gigi, dan lainnya',
                'created_at' => now()->subDays(2),
            ],
            [
                'item_name' => 'Makan Siang di Restoran',
                'amount' => -75000,
                'category' => 'Makanan',
                'type' => 'expense',
                'note' => 'Makan bersama teman',
                'created_at' => now()->subHours(12),
            ],
        ];

        // Insert semua data ke database
        foreach ($transactions as $transaction) {
            Transaction::create($transaction);
        }

        $this->command->info('✅ TransactionSeeder berhasil dijalankan! ' . count($transactions) . ' transaksi telah ditambahkan.');
    }
}
