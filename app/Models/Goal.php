<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Goal extends Model
{
    protected $fillable = [
        'user_id',
        'goal_name',
        'target_amount',
        'current_saved',
        'category',
        'description',
        'target_date',
        'status',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'current_saved' => 'decimal:2',
        'target_date' => 'date',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Hitung persentase progress (0-100%)
     */
    public function getProgressPercentage()
    {
        if ($this->target_amount <= 0) {
            return 0;
        }
        return min(100, round(($this->current_saved / $this->target_amount) * 100, 2));
    }

    /**
     * Hitung sisa yang perlu ditabung
     */
    public function getRemainingAmount()
    {
        return max(0, $this->target_amount - $this->current_saved);
    }

    /**
     * Hitung hari tersisa sampai target_date
     */
    public function getDaysRemaining()
    {
        if (!$this->target_date) {
            return null;
        }
        $today = Carbon::today();
        $targetDate = Carbon::parse($this->target_date);
        
        if ($today > $targetDate) {
            return 0;
        }
        
        return $targetDate->diffInDays($today) + 1;
    }

    /**
     * Hitung target tabungan per hari
     */
    public function getTargetPerDay()
    {
        $daysRemaining = $this->getDaysRemaining();
        if (!$daysRemaining || $daysRemaining <= 0) {
            return 0;
        }
        $remaining = $this->getRemainingAmount();
        return round($remaining / $daysRemaining, 2);
    }

    /**
     * Hitung target tabungan per bulan
     */
    public function getTargetPerMonth()
    {
        $daysRemaining = $this->getDaysRemaining();
        if (!$daysRemaining || $daysRemaining <= 0) {
            return 0;
        }
        $dayPerMonth = $daysRemaining / 30;
        $remaining = $this->getRemainingAmount();
        return round($remaining / $dayPerMonth, 2);
    }

    /**
     * Check apakah goal sudah tercapai
     */
    public function isCompleted()
    {
        return $this->current_saved >= $this->target_amount;
    }
}

