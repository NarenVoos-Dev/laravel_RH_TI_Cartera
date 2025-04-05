<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class EmployeeCompany extends Model
{
    use HasFactory;

    protected $table = 'employee_company';

    protected $fillable = [
        'employee_id',
        'company_id',
        'assigned_at',
        'removed_at',
    ];

    // Relación con empleados
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Relación con empresas
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
