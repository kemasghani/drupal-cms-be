<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users'; // Use Drupal's users table

    protected $fillable = [
        'name',
        'mail',
        'pass', // Use Drupal column names
    ];

    protected $hidden = [
        'pass',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->pass; // Drupal stores hashed passwords
    }
}
