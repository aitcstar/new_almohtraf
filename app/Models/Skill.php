<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{

    public $table = 'skills';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'category_id',
        'subcategory_id',
        'suggested',
        'status'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'skill_user');
    }

    public function portfolios()
{
    return $this->belongsToMany(Portfolio::class, 'portfolio_skills', 'skill_id', 'portfolio_id');
}
}
