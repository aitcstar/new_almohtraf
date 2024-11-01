<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioView extends Model
{
    use HasFactory;

    protected $fillable = ['portfolio_id', 'user_id'];

    // العلاقة مع البورتفوليو
    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    // العلاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
