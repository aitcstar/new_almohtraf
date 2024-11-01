<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'balance',
        'pending_balance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // العلاقة مع المعاملات
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // دالة لحساب الأرباح في آخر 14 يوما
    public function earningsInLast14Days()
    {
        return $this->transactions()
                    ->where('created_at', '>=', now()->subDays(14))
                    ->sum('amount');
    }

    // دالة لحساب الرصيد المتاح للسحب
    public function availableBalance()
    {
        return $this->totalBalance() - $this->pending_balance;
    }

    public function withdrawableBalance()
    {
        return $this->availableBalance();
    }


    // حساب الرصيد الكلي (الذي يتضمن المتاح والمعلق)
    public function totalBalance()
    {
        return $this->balance + $this->pending_balance;
    }

}
