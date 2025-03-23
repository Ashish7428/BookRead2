<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Author extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'username',
        'password',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
        'bio',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Add this relationship method
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
