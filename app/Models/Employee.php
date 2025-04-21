<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Employee extends Model
{

    use HasFactory;

    protected $fillable = [
        'name', 
        'user_id',
        'document_identification',
        'salary',
        'transport_aid',
        'hire_date',
        'status',
    ];
    

    // Relación con User (Un empleado es un usuario)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function assignments()
    {
        return $this->hasMany(EmployeeCompany::class);
    }


    public function currentAssignment()
    {
        return $this->hasOne(EmployeeCompany::class)->latestOfMany();
    }

        // Employee.php
    public function currentCompany()
    {
        return $this->hasOne(EmployeeCompany::class)->latest(); // o donde determines la empresa activa
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'employee_company')
                    ->withPivot('assigned_at', 'removed_at')
                    ->withTimestamps();
    }

}
