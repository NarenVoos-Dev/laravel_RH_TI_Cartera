<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'period',
        'payment_date',
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    // Relación con PayrollDetails (Una nómina tiene muchos detalles)
    public function payrollDetails(): HasMany
    {
        return $this->hasMany(PayrollDetail::class);
    }
}
