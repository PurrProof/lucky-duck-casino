<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    protected $fillable = [
        'phone',
        'login',
        'registered_at',
        'logged_at',
    ];

    protected $hidden = [
        'remember_token',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'logged_at' => 'datetime',
    ];

    public function getFormattedPhoneAttribute(): string
    {
        // todo: format
        return $this->phone;
    }

    public function setPhoneAttribute($value)
    {
        // normalize the phone number before saving
        $this->attributes['phone'] = Str::of($value)->replaceMatches('/\D+/', '');
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }
}
