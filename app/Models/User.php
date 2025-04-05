<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
   
    use HasFactory, Notifiable;


    protected $fillable = [
        'name', 
        'username', 
        'password', 
        'role_id', 
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function username()
    {
        return 'username';
    }
    

    // Relación con Role (Un usuario tiene un rol)
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

}
