<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zakat extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'amount',
        'address',
        'description',
        'part_of_zakat',
        'image',
        'status',
    ];

    protected $casts = [
        'part_of_zakat' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
