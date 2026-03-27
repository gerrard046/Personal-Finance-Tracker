<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            // Nama item/transaksi yang dilakukan
            $table->string('item_name');
            // Jumlah uang (positif untuk income, negatif untuk expense)
            $table->decimal('amount', 12, 2);
            // Kategori: Makanan, Transport, Entertainment, Gaji, dll
            $table->string('category');
            // Tipe transaksi: 'income' atau 'expense'
            $table->enum('type', ['income', 'expense']);
            // Catatan tambahan (opsional)
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
