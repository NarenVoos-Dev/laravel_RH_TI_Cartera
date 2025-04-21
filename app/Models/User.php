<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{

    use HasFactory, Notifiable, HasRoles;


    protected $fillable = [
        'name', 
        'username', 
        'password', 
        'role_id',
        'company_id',
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


    // Relación con Empleado (Un usuario tiene un empleado)
    public function employee()
    {
        return $this->hasOne(Employee::class,'user_id');
    }    

    // Relación con Role (Un usuario tiene un rol)
    public function customRole(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }


}
