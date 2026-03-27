<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * Atribut yang bisa diisi secara massal (mass assignable)
     * Ini penting untuk keamanan - hanya field ini yang bisa diisi dari user input
     */
    protected $fillable = [
        'item_name',
        'amount',
        'category',
        'type',
        'note',
    ];

    /**
     * Cast tipe data untuk atribut tertentu
     * Ini memastikan amount selalu berupa decimal
     */
    protected $casts = [
        'amount' => 'decimal:2',
    ];
}
