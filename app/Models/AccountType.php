<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountType extends Model
{

    public $table = 'account_types';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'title',
        'status',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_account_types');
    }


    /*public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_account_types', 'account_type_id', 'user_id');
    }*/

}
