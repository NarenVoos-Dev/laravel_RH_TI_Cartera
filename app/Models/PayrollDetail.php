<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class PayrollDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'payroll_id',
        'employee_id',
        'base_salary',
        'days_worked',
        'transport_aid',
        'total_earnings',
        'total_deductions',
        'net_salary',
    ];

    // Relación con la nómina general
    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }

    // Relación con el empleado
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
