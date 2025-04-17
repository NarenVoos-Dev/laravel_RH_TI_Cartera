<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nit',
        'address',
        'phone',
        'email',
        'status',
    ];

     // Relación con asignaciones de empleados
     public function assignments()
     {
         return $this->hasMany(EmployeeCompany::class);
     }

    // Relación con empleados a través de la tabla pivote
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_company')
                    ->withPivot('assigned_at', 'removed_at')
                    ->withTimestamps();
    }
    

}
