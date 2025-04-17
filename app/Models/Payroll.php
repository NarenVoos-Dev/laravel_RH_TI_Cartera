<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'start_date',
        'end_date',
        'payment_date',
        'total_earnings',
        'total_deductions',
        'total_net_pay',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relación con PayrollDetails (Una nómina tiene muchos detalles)
    public function details()
    {
        return $this->hasMany(PayrollDetail::class);
    }
}
