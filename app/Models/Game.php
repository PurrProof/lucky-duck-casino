<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'user_id',
        'random',
        'prize',
        'is_won',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
